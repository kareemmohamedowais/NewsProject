<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    public function callback($provider)
    {
        $allowedProviders = ['google', 'facebook', 'github'];
if (! in_array($provider, $allowedProviders)) {
    abort(404);
}

        try {
            $user_provider = Socialite::driver($provider)->user();
            // return $user_provider->token;
            $user_from_db = User::where(
                [
                    'email'=>$user_provider->getEmail(),
                    'provider' => $provider,
                    'provider_id' => $user_provider->id
                    ])->first();

            if ($user_from_db) {
                Auth::login($user_from_db);
                return redirect()->route('frontend.dashboard.setting');
            }

            $username = $this->generateUniqueUsername($user_provider->name);

            $user = User::create([
                'name' => $user_provider->name,
                'email' => $user_provider->email,
                'username' => $username,
                'image' => $user_provider->avatar,
                'status' => 1,
                'country' => 'updated',
                'city' => 'updated',
                'street' => 'updated',
                'email_verified_at' => now(),
                'provider' => $provider,
                'provider_id' => $user_provider->id,
                'provider_token' => $user_provider->token,
                'password' => Hash::make(Str::random(8)),
            ]);

            Auth::login($user);
            return redirect()->route('frontend.dashboard.setting');

        } catch (\Exception $e) {
Log::error("Social login error with {$provider}", [
    'error' => $e->getMessage(),
    'email' => $user_provider->getEmail() ?? null,
]);

            return redirect()->route('login')->withErrors([
                'social' => 'Something went wrong with ' . ucfirst($provider) . ' login. Please try again.'
            ]);
        }
    }

    public function generateUniqueUsername($name)
    {
        $username = Str::slug($name);
        $count = 1;
        while (User::where('username', $username)->exists()) {
            $username = $username . $count++;
        }
        return $username;
    }
}
