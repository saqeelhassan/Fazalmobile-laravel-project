<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validateWithBag('contact', [
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255'],
            'phone'   => ['nullable', 'string', 'max:30'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $contactMessage = ContactMessage::create($data);

        try {
            Mail::to(config('site.email'))->send(new ContactMessageReceived($contactMessage));
        } catch (\Throwable $e) {
            Log::error('Failed to send contact message notification: ' . $e->getMessage());
        }

        return back()->with('contact_success', 'Thanks for reaching out — we\'ll get back to you soon.');
    }
}
