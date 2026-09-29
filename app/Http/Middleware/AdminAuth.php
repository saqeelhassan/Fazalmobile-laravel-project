<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')
                ->with('error', 'Please login to access the admin panel.');
        }

        $admin = Auth::guard('admin')->user();

        if (!$admin->is_active) {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')
                ->with('error', 'Your account has been deactivated.');
        }

        if ($admin->must_change_password && !$request->routeIs(['admin.profile.edit', 'admin.profile.password', 'admin.logout'])) {
            return redirect()->route('admin.profile.edit')
                ->with('error', 'You are using the default password. Please set a new password to continue.');
        }

        return $next($request);
    }
}
