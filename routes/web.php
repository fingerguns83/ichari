<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Controller\ErrorController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClaimRequestController;

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
        return view('dashboard', ['show' => 'dashboard']);
    }
    return view('start');
});

Route::get('/auth/redirect', function(){
    return Socialite::driver('discord')->redirect();
});

Route::get('/auth/callback', function(){
    $discordUser = Socialite::driver('discord')->user();
    $user = User::where('discord_id', $discordUser->id)->first();
    if ($user){
        Auth::login($user, true);
        return redirect('/section/dashboard');
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
                $user = User::create([
                    'discord_id' => $discordUser->id,
                    'discord_name' => $name,
                    'discord_unique' => $discordUser->nickname,
                    'discord_avatar' => $discordUser->avatar
                ]);
                Auth::login($user, true);
                return redirect('/section/dashboard');
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

Route::get('/section/{feature}', [DashboardController::class, 'show'])->middleware('auth');
Route::post('/forms/{type}', ClaimRequestController::class)->middleware('auth');