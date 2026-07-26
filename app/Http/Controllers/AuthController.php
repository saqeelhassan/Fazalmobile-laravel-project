<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validateWithBag('register', [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('my-account')->with('success', 'Welcome, ' . $user->name . '! Your account has been created.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validateWithBag('login', [
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $key = 'customer-login:' . Str::lower($credentials['email']) . '|' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors(['email' => "Too many login attempts. Try again in {$seconds} seconds."], 'login')
                ->withInput($request->only('email'));
        }

        $remember = $request->boolean('remember');

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $remember)) {
            RateLimiter::clear($key);
            $request->session()->regenerate();

            return redirect()->route('my-account')->with('success', 'Welcome back, ' . Auth::user()->name . '!');
        }

        RateLimiter::hit($key, 60);

        return back()->withErrors(['email' => 'These credentials do not match our records.'], 'login')
            ->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('my-account')->with('success', 'You have been logged out.');
    }
}
