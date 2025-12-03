<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    // Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::updateOrCreate(
                ['email' => $googleUser->email],
                [
                    'name' => $googleUser->name,
                    'username' => Str::slug($googleUser->name) . rand(1000, 9999),
                    'password' => Hash::make(Str::random(24)),
                    'email_verified_at' => now(),
                ]
            );

            Auth::login($user);

            return redirect()->intended('dashboard');
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Error al iniciar sesión con Google');
        }
    }

    // Facebook
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();

            $user = User::updateOrCreate(
                ['email' => $facebookUser->email],
                [
                    'name' => $facebookUser->name,
                    'username' => Str::slug($facebookUser->name) . rand(1000, 9999),
                    'password' => Hash::make(Str::random(24)),
                    'email_verified_at' => now(),
                ]
            );

            Auth::login($user);

            return redirect()->intended('dashboard');
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Error al iniciar sesión con Facebook');
        }
    }
}