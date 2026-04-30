<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function __construct(
        private readonly \App\Services\SeoService $seo
    ) {}

    public function index(): View
    {
        $country = app(Country::class);
        $contactEmail = $country->settings()->where('key', 'contact_email')->value('value');

        $seo = (new \App\DTO\SeoData(
            title: "Contact Us — {$country->name} Directory",
            description: "Get in touch with the {$country->name} Directory team. Fill out our contact form for inquiries, support, or feedback.",
            canonical: request()->url()
        ))->toArray();

        return view('contact.index', compact('country', 'contactEmail', 'seo'));
    }

    public function send(Request $request): RedirectResponse
    {
        // Rate limiting handled by Route::post in web.php (or we can use RateLimiter here if preferred, but doing it in routes or controller constructor is standard)
        // I will add the throttle middleware to the route directly in web.php instead. Wait, the prompt said "Use Laravel 13 rate limiting: 3 submissions per minute per IP" on the send method. I'll add middleware to the controller constructor.
        
        $country = app(Country::class);

        // Honeypot check
        if ($request->filled('website_url')) {
            // Silently discard
            return back()->with('success', 'Your message has been sent successfully.');
        }

        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:100'],
            'email'   => ['required', 'email'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $contactEmail = $country->settings()->where('key', 'contact_email')->value('value');

        if (!$contactEmail) {
            return back()->with('error', 'Contact email is not configured for this country.');
        }

        try {
            Mail::raw("New Contact Message:\n\nName: {$validated['name']}\nEmail: {$validated['email']}\n\nMessage:\n{$validated['message']}", function ($message) use ($contactEmail, $validated) {
                $message->to($contactEmail)
                        ->subject('New Contact Inquiry - ' . $validated['name'])
                        ->replyTo($validated['email']);
            });

            return back()->with('success', 'Your message has been sent successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'There was an error sending your message. Please try again later.');
        }
    }
}
