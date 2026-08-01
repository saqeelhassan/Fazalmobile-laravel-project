<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('admin.profile.edit');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password'          => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $admin = Auth::guard('admin')->user();

        if (! Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Your current password is incorrect.']);
        }

        $admin->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }
}
