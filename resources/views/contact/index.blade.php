@extends('layouts.app')

@section('title', 'Contact Us - ' . $country->name)

@section('content')

    <div class="contact-layout">
        
        <!-- Form -->
        <div class="contact-form-card">
            <div class="text-center mb-4">
                <div class="trust-icon" style="margin-bottom: 1rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                </div>
                <h1 style="font-size: var(--text-4xl); margin-bottom: 0.5rem; color: var(--text);">Contact Us</h1>
                <p class="text-muted">Have a question? We'd love to hear from you.</p>
            </div>
            
            <form action="{{ route('contact.send') }}" method="POST">
                @csrf
                
                <!-- Honeypot Field -->
                <div style="display: none;">
                    <label for="website_url">Website URL (leave blank)</label>
                    <input type="text" name="website_url" id="website_url" value="">
                </div>
                
                <div class="form-group">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required maxlength="100">
                    @error('name')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="message" class="form-label">Message</label>
                    <textarea name="message" id="message" class="form-control" rows="6" required maxlength="2000">{{ old('message') }}</textarea>
                    @error('message')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                    Send Message
                </button>
            </form>
        </div>
        
        <!-- Contact Info -->
        <div class="contact-info-card">
            <h2 style="font-size: var(--text-2xl); font-weight: 700; color: var(--text);">Get in Touch</h2>
            <p class="text-muted">Fill out the form and we'll get back to you as soon as possible.</p>

            <div class="contact-info-item">
                <div class="contact-info-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                </div>
                <div>
                    <h4 style="font-weight: 700; color: var(--text); margin-bottom: 0.25rem;">Email</h4>
                    <p class="text-muted" style="font-size: var(--text-sm);">info@{{ request()->getHost() }}</p>
                </div>
            </div>

            <div class="contact-info-item">
                <div class="contact-info-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                </div>
                <div>
                    <h4 style="font-weight: 700; color: var(--text); margin-bottom: 0.25rem;">Location</h4>
                    <p class="text-muted" style="font-size: var(--text-sm);">{{ $country->name }}</p>
                </div>
            </div>

            <div class="contact-info-item">
                <div class="contact-info-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <div>
                    <h4 style="font-weight: 700; color: var(--text); margin-bottom: 0.25rem;">Response Time</h4>
                    <p class="text-muted" style="font-size: var(--text-sm);">We respond within 24 hours</p>
                </div>
            </div>
        </div>
    </div>

@endsection
