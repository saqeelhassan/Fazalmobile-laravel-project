<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    /**
     * Providers this app knows how to authenticate with.
     * Add a new provider here (and its config/services.php entry) to support it —
     * no new controller or routes needed.
     */
    protected array $providers = ['google', 'facebook'];

    public function redirectToProvider(string $provider)
    {
        $this->validateProvider($provider);

        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(Request $request, string $provider)
    {
        $this->validateProvider($provider);

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Throwable $e) {
            return redirect()->route('my-account')
                ->withErrors(['email' => 'Unable to login with ' . ucfirst($provider) . '. Please try again.'], 'login');
        }

        $providerIdColumn = $provider . '_id';

        $user = User::where($providerIdColumn, $socialUser->getId())->first();

        if (!$user) {
            $user = User::where('email', $socialUser->getEmail())->first();

            if ($user) {
                // Existing account with this email — link this provider to it.
                $user->update([$providerIdColumn => $socialUser->getId()]);
            } else {
                $user = User::create([
                    'name'            => $socialUser->getName() ?: $socialUser->getNickname() ?: ucfirst($provider) . ' User',
                    'email'           => $socialUser->getEmail(),
                    $providerIdColumn => $socialUser->getId(),
                    'password'        => null,
                ]);
            }
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        return redirect()->intended(route('my-account'))
            ->with('success', 'Welcome, ' . $user->name . '!');
    }

    protected function validateProvider(string $provider): void
    {
        abort_unless(in_array($provider, $this->providers, true), 404);
    }
}
