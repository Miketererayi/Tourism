@extends('layouts.app')

@section('title', 'Search - ' . $currentCountry->name)

@section('hero')
<div class="hero-gradient" style="padding: 4rem 0 5rem;">
    <div class="container" style="position: relative; z-index: 1;">
        <h1 class="hero-title" style="font-size: var(--text-4xl);">Search {{ $currentCountry->name }}</h1>
        <form action="{{ route('search.index') }}" method="GET" class="hero-search">
            <div class="hero-search-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </div>
            <input type="text" name="q" placeholder="What are you looking for?" value="{{ $queryStr }}" required>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>
</div>
@endsection

@section('content')

    @if(empty($queryStr))
        <div class="empty-state" data-animate="fade-up">
            <svg class="empty-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <h2 class="section-title" style="margin-top: 0; margin-bottom: 0.5rem;">Start your search</h2>
            <p class="text-muted mb-4">Find the best places, businesses, and services around you.</p>
            <a href="{{ route('home') }}" class="btn btn-primary">Browse Categories</a>
        </div>
    @elseif($places->isEmpty())
        <div class="empty-state" data-animate="fade-up">
            <svg class="empty-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M16 16s-1.5-2-4-2-4 2-4 2"/><line x1="9" x2="9.01" y1="9" y2="9"/><line x1="15" x2="15.01" y1="9" y2="9"/></svg>
            <h2 class="section-title" style="margin-top: 0; margin-bottom: 0.5rem;">No results for '{{ $queryStr }}'</h2>
            <p class="text-muted mb-4">Try adjusting your search terms or browse by category instead.</p>
            <a href="{{ route('home') }}" class="btn btn-primary">Go Home</a>
        </div>
    @else
        <div class="mt-5 mb-4" data-animate="fade-up">
            <p class="text-muted" style="font-size: var(--text-sm);">Showing <strong>{{ $places->total() }}</strong> results for '<strong>{{ $queryStr }}</strong>'</p>
        </div>
        
        <div class="grid grid-3 stagger-children" data-animate="fade-up">
            @foreach($places as $place)
                <x-place-card :place="$place" />
            @endforeach
        </div>

        <div class="mt-5">
            {{ $places->links() }}
        </div>
    @endif

@endsection
