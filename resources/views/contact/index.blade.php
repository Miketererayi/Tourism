@extends('layouts.app')

@section('title', 'Contact Us - ' . $country->name)

@section('content')

    <div style="max-width: 600px; margin: 3rem auto; background: var(--surface); padding: 3rem; border-radius: var(--radius); box-shadow: var(--shadow);">
        
        <h1 style="font-size: 2.5rem; margin-bottom: 1rem; color: var(--text); text-align: center;">
            Contact Us
        </h1>
        
        <p style="color: var(--text-muted); text-align: center; margin-bottom: 2rem;">
            Have a question or need assistance? Fill out the form below and we'll get back to you as soon as possible.
        </p>
        
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
                    <div class="text-error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                @error('email')
                    <div class="text-error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="message" class="form-label">Message</label>
                <textarea name="message" id="message" class="form-control" rows="6" required maxlength="2000">{{ old('message') }}</textarea>
                @error('message')
                    <div class="text-error">{{ $message }}</div>
                @enderror
            </div>
            
            <div style="text-align: center; margin-top: 2rem;">
                <button type="submit" class="btn" style="width: 100%;">Send Message</button>
            </div>
        </form>
        
    </div>

@endsection
