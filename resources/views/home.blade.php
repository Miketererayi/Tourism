@extends('layouts.app')

@section('hero')
<div class="hero">
    <div class="container">
        <h1>Discover {{ $currentCountry->name }}</h1>
        <p style="font-size: 1.25rem; margin-bottom: 2rem; opacity: 0.9;">Find the best places, services and businesses</p>
        
        <form action="{{ route('search.index') }}" method="GET" style="max-width: 600px; margin: 0 auto; display: flex;">
            <input type="text" name="q" placeholder="What are you looking for?" required 
                   style="flex: 1; padding: 1rem; border: none; border-radius: var(--radius) 0 0 var(--radius); font-size: 1.1rem; outline: none;">
            <button type="submit" style="padding: 1rem 2rem; border: none; background: var(--accent); color: white; font-size: 1.1rem; border-radius: 0 var(--radius) var(--radius) 0; cursor: pointer; font-weight: bold;">
                Search
            </button>
        </form>
    </div>
</div>
@endsection

@section('content')

    <h2 class="section-title">Browse by Category</h2>
    <div class="grid grid-3">
        @foreach($categories as $category)
            <a href="{{ route('category.show', $category->slug) }}" class="place-card" style="padding: 1.5rem; text-align: center; display: block; border-radius: var(--radius); box-shadow: var(--shadow); transition: transform 0.2s ease, box-shadow 0.2s ease;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">{{ $category->icon }}</div>
                <h3 style="color: var(--text); margin-bottom: 0.5rem;">{{ $category->name }}</h3>
                <span style="color: var(--text-muted); font-size: 0.875rem;">{{ $category->places_count }} {{ Str::plural('place', $category->places_count) }}</span>
            </a>
        @endforeach
    </div>

    @if($featuredPlaces->isNotEmpty())
        <h2 class="section-title">Featured Places</h2>
        <div class="grid grid-3">
            @foreach($featuredPlaces as $place)
                <x-place-card :place="$place" />
            @endforeach
        </div>
    @endif

    @if($latestPlaces->isNotEmpty())
        <h2 class="section-title">Latest Listings</h2>
        <div class="grid grid-4">
            @foreach($latestPlaces as $place)
                <x-place-card :place="$place" />
            @endforeach
        </div>
    @endif

@endsection
