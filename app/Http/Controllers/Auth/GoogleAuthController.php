<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect(): RedirectResponse
    {
        abort_unless((bool) config('freeeducation.features.google_oauth', true), 404);

        return Socialite::driver('google')->redirect();
    }

    public function callback(): RedirectResponse
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::query()->firstOrCreate([
            'email' => $googleUser->getEmail(),
        ], [
            'name' => $googleUser->getName() ?? 'Google User',
            'password' => Str::password(24),
            'is_approved' => true,
            'locale' => 'en',
        ]);

        SocialAccount::query()->firstOrCreate([
            'provider' => 'google',
            'provider_user_id' => $googleUser->getId(),
        ], [
            'user_id' => $user->id,
            'provider_email' => $googleUser->getEmail(),
        ]);

        auth()->login($user, true);

        return redirect()->route('home')->with('status', 'Logged in with Google.');
    }
}
