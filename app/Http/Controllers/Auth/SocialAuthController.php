<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Referral;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect(string $provider)
    {
        $this->validateProvider($provider);
        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider)
    {
        $this->validateProvider($provider);

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['email' => 'Unable to authenticate with ' . $provider]);
        }

        $user = User::where('email', $socialUser->getEmail())->first();

        if ($user) {
            $user->update([
                'avatar' => $socialUser->getAvatar(),
                'last_login' => now(),
            ]);
        } else {
            $referralCode = session('referral_code');
            $user = User::create([
                'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? 'User',
                'email' => $socialUser->getEmail(),
                'password' => null,
                'avatar' => $socialUser->getAvatar(),
                'role' => 'tenant',
                'plan' => 'free',
                'referral_code' => strtoupper(Str::random(8)),
                'email_verified_at' => now(),
                'last_login' => now(),
            ]);

            if ($referralCode) {
                $referrer = User::where('referral_code', $referralCode)->first();
                if ($referrer) {
                    Referral::create([
                        'referrer_id' => $referrer->id,
                        'referred_user_id' => $user->id,
                        'status' => 'pending',
                    ]);
                }
            }
        }

        Auth::login($user, true);
        return redirect()->intended(route('dashboard'));
    }

    private function validateProvider(string $provider): void
    {
        if (!in_array($provider, ['google', 'facebook'])) {
            abort(404);
        }
    }
}
