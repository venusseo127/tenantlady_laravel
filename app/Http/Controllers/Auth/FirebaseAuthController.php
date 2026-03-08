<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;

class FirebaseAuthController extends Controller
{
    public function __construct(
        protected ?FirebaseAuth $firebaseAuth = null
    ) {
        try {
            $this->firebaseAuth = app('firebase.auth');
        } catch (\Throwable) {
            //
        }
    }

    public function show(): View
    {
        return view('auth.firebase-login');
    }

    public function verifyToken(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'id_token' => ['required', 'string'],
        ]);

        if (!$this->firebaseAuth) {
            return response()->json(['error' => 'Firebase not configured'], 500);
        }

        try {
            $verifiedIdToken = $this->firebaseAuth->verifyIdToken($request->id_token);
            $claims = $verifiedIdToken->claims();
            $firebaseUid = $claims->get('sub');
            $email = $claims->get('email');
            $name = $claims->get('name') ?? $claims->get('email');

            $user = User::where('firebase_uid', $firebaseUid)->orWhere('email', $email)->first();

            if (!$user) {
                $referralCode = session('referral_code');
                $user = User::create([
                    'name' => $name ?? 'User',
                    'email' => $email ?? $firebaseUid . '@firebase.local',
                    'password' => null,
                    'firebase_uid' => $firebaseUid,
                    'role' => 'tenant',
                    'plan' => 'free',
                    'referral_code' => strtoupper(Str::random(8)),
                    'email_verified_at' => $email ? now() : null,
                    'last_login' => now(),
                ]);

                if ($referralCode) {
                    $referrer = User::where('referral_code', $referralCode)->first();
                    if ($referrer && $referrer->id !== $user->id) {
                        Referral::create([
                            'referrer_id' => $referrer->id,
                            'referred_user_id' => $user->id,
                            'status' => 'pending',
                        ]);
                    }
                }
            } else {
                $user->update([
                    'firebase_uid' => $firebaseUid,
                    'last_login' => now(),
                ]);
            }

            Auth::login($user, true);

            if ($request->wantsJson()) {
                return response()->json(['redirect' => route('dashboard')]);
            }

            return redirect()->intended(route('dashboard'));
        } catch (\Throwable $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => $e->getMessage()], 401);
            }
            return back()->withErrors(['firebase' => 'Invalid or expired token.']);
        }
    }
}
