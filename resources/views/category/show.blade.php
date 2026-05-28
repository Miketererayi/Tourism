@extends('layouts.app')

@section('title', $category->name . ' in ' . $currentCountry->name)
@section('meta_description', 'Browse the best ' . $category->name . ' in ' . $currentCountry->name)

@section('hero')
<div class="category-hero">
    <div class="container" style="position: relative; z-index: 1;">
        <div class="category-hero-icon">
            <x-category-icon :slug="$category->slug" :size="32" />
        </div>
        <h1>{{ $category->name }}</h1>
        <p class="category-hero-count">{{ $places->total() }} {{ Str::plural('place', $places->total()) }} found</p>
    </div>
</div>
@endsection

@section('content')

    <div class="breadcrumbs">
        <a href="{{ route('home') }}">Home</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        <span class="breadcrumb-current">{{ $category->name }}</span>
    </div>

    <div class="flex items-center justify-between mb-5" style="flex-wrap: wrap; gap: 1rem;">
        <h2 class="section-title" style="margin: 0;">
            <x-category-icon :slug="$category->slug" :size="24" />
            {{ $category->name }}
        </h2>
        
        <form action="{{ route('category.show', $category->slug) }}" method="GET" class="category-search">
            <input type="text" name="q" placeholder="Search in {{ $category->name }}..." value="{{ $searchQuery }}">
            <button type="submit" aria-label="Search">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </button>
        </form>
    </div>

    @if($places->isEmpty())
        <div class="empty-state">
            <svg class="empty-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M16 16s-1.5-2-4-2-4 2-4 2"/><line x1="9" x2="9.01" y1="9" y2="9"/><line x1="15" x2="15.01" y1="9" y2="9"/></svg>
            <h2>No places found</h2>
            <p class="text-muted mb-4">We couldn't find any places matching your criteria.</p>
            <a href="{{ route('category.show', $category->slug) }}" class="btn btn-primary">Clear Search</a>
            <a href="{{ route('home') }}" class="btn" style="background: var(--surface); color: var(--text); border: 1px solid var(--border); margin-left: 0.5rem;">Go Home</a>
        </div>
    @else
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
