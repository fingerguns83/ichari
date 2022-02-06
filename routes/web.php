<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Http;
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
        
        $identityCheck = sprintf("https://bot.ichari.net/?d=%s&u=%s", getenv('DISCORD_AUTH_GUILD'), $discordUser->id);
        $response = Http::get($identityCheck);

        if (boolval($response)){
            $user = User::create([

                'discord_id' => $discordUser->id,
                'discord_name' => $discordUser->name,
                'discord_nickname' => $discordUser->nickname,
                'discord_avatar' => $discordUser->avatar
            ]);
            Auth::login($user, true);
            DashboardController::show('dashboard');
        }
        else {
            abort(401);
        }
    }
    
});

Route::get('/section/{feature}', [DashboardController::class, 'show']);