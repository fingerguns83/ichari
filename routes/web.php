<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Controller\ErrorController;

use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ClaimRequestController;
use App\Http\Controllers\LandManagementController;
use Illuminate\Notifications\Notification;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::check()){
        return redirect('/module/dashboard');
    }
    return view('login');
});

Route::get('/auth/redirect', function(){
    return Socialite::driver('discord')->redirect();
});

Route::get('/auth/callback', function(){
    $discordUser = Socialite::driver('discord')->user();
    $user = User::where('oauth_id', $discordUser->id)->first();
    if ($user){
        if (!$user->is_banned){
            Auth::login($user, true);
            return redirect('/module/dashboard');
        }
        else {
            abort(418);
        }
    }
    else {
        
        $verifURL = sprintf("https://bot.ichari.net/?d=%s&u=%s", getenv('DISCORD_AUTH_GUILD'), $discordUser->id);
        $verifResponse = Http::get($verifURL);

        if (boolval($verifResponse)){

            $allowedRoles = explode(',', getenv('DISCORD_REQUIRED_ROLES'));
            $verifResponseArr = json_decode($verifResponse->body(), true);
            $verified = false;
            foreach($verifResponseArr['roles'] as $i){
                if (in_array($i, $allowedRoles)){
                    $verified = true;
                }
            }

            if ($verified){
                if ($verifResponseArr['nick']){
                    $name = $verifResponseArr['nick'];
                }
                else {
                    $name = $discordUser->name;
                }

                $rssKeyPool = '2346789bBcCdDfFgGhHjJkKmMpPqQrRtTvVwWxXyY';
                $rssKey = '';
                for ($i = 0; $i < 8; $i++){
                    $rssKey .= substr($rssKeyPool, rand(0, strlen($rssKeyPool) -1), 1);
                }

                $user = User::create([
                    'oauth_id' => $discordUser->id,
                    'username' => $name,
                    'oauth_unique' => $discordUser->nickname,
                    'avatar' => $discordUser->avatar,
                    'rss_key' => $rssKey
                ]);
                Auth::login($user, true);
                return redirect('/module/dashboard');
            }
            else {
                abort(401);
            }
        }
        else {
            abort(403);
        }
    }
    
});

Route::get('/module/{feature}', [ModuleController::class, 'loadModule'])->middleware('auth');
Route::post('/forms/claim-request', ClaimRequestController::class)->middleware('auth');

Route::get('/notifications/{notifID}', function($notifID){

    $userInfo = explode('-', $notifID);

    $user = User::where('username', '=', $userInfo[0])->first();
    if ($user->rss_key !== $userInfo[1]){
        abort(403);
    }

    header("Content-type: text/xml");
    echo "<?xml version='1.0' encoding='UTF-8'?>
    <rss version='2.0'>
    <channel>
    ";
    echo "<title>".getenv('APP_NAME')."</title>" . PHP_EOL;
    echo "<link>".getenv('APP_URL')."</link>" . PHP_EOL;
    foreach ($user->notifications as $notif){
        echo "<item>" . PHP_EOL;
        echo "<title>" . $notif->data['title'] . "</title>" . PHP_EOL;
        echo "<description>" . $notif->data['message'] . "</description>" . PHP_EOL;
        echo "</item>" . PHP_EOL;
        if (!$notif->read_at){
            $notif->markAsRead();
        }
    }
    echo "</channel>" . PHP_EOL;
    echo "</rss>";

});

Route::controller(LandManagementController::class)->group(function(){
    Route::post('/forms/land-management/add/{type}', 'add')->middleware('auth');
    Route::post('/forms/land-management/modify/{type}', 'modify')->middleware('auth');
});