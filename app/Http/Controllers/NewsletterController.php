<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validateWithBag('newsletter', [
            'newsletter_email' => ['required', 'email', 'max:255'],
        ]);

        $subscriber = Subscriber::firstOrCreate(['email' => $data['newsletter_email']]);

        if (!$subscriber->wasRecentlyCreated) {
            return back()->with('newsletter_success', 'You\'re already subscribed — thanks!');
        }

        return back()->with('newsletter_success', 'Subscribed! You\'ll hear from us about promotions and new arrivals.');
    }
}
