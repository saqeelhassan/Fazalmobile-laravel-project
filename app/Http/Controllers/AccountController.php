<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return view('myaccount');
        }

        $orders = Auth::user()->orders()->with('items')->latest()->paginate(10);

        return view('myaccount', ['orders' => $orders]);
    }

    public function updateProfile(Request $request)
    {
        $data = $request->validate([
            'name'                     => ['required', 'string', 'max:255'],
            'receive_marketing_sms'    => ['nullable', 'boolean'],
            'receive_marketing_emails' => ['nullable', 'boolean'],
        ]);

        $data['receive_marketing_sms']    = $request->boolean('receive_marketing_sms');
        $data['receive_marketing_emails'] = $request->boolean('receive_marketing_emails');

        Auth::user()->update($data);

        return redirect()->back()->with('success', 'Your profile has been updated.');
    }

    public function profile()
    {
        if (!Auth::check()) {
            return redirect()->route('my-account');
        }

        return view('account.profile', ['u' => Auth::user()]);
    }

    public function returns()
    {
        if (!Auth::check()) {
            return redirect()->route('my-account');
        }

        $orders = Auth::user()->orders()->where('status', 'returned')->with('items')->latest()->paginate(10);

        return view('account.returns', ['u' => Auth::user(), 'orders' => $orders]);
    }

    public function cancellations()
    {
        if (!Auth::check()) {
            return redirect()->route('my-account');
        }

        $orders = Auth::user()->orders()->where('status', 'cancelled')->with('items')->latest()->paginate(10);

        return view('account.cancellations', ['u' => Auth::user(), 'orders' => $orders]);
    }
}
