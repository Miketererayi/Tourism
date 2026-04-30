@extends('layouts.app')

@section('title', $category->name . ' in ' . $currentCountry->name)
@section('meta_description', 'Browse the best ' . $category->name . ' in ' . $currentCountry->name)

@section('content')

    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a> &gt; {{ $category->name }}
    </div>

    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <h1 style="display: flex; align-items: center; gap: 0.5rem; font-size: 2rem;">
            <span>{{ $category->icon }}</span> {{ $category->name }}
            <span style="font-size: 1rem; color: var(--text-muted); font-weight: normal; margin-left: 0.5rem;">({{ $places->total() }})</span>
        </h1>
        
        <form action="{{ route('category.show', $category->slug) }}" method="GET" style="display: flex; min-width: 250px;">
            <input type="text" name="q" placeholder="Search in {{ $category->name }}..." value="{{ $searchQuery }}" 
                   style="flex: 1; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius) 0 0 var(--radius); outline: none;">
            <button type="submit" style="padding: 0.75rem 1rem; background: var(--primary); color: white; border: none; border-radius: 0 var(--radius) var(--radius) 0; cursor: pointer;">🔍</button>
        </form>
    </div>

    @if($places->isEmpty())
        <div class="empty-state">
            <div style="font-size: 3rem; margin-bottom: 1rem;">😔</div>
            <h2>No places found</h2>
            <p style="color: var(--text-muted); margin-bottom: 1.5rem;">We couldn't find any places matching your criteria.</p>
            <a href="{{ route('category.show', $category->slug) }}" class="btn">Clear Search</a>
            <a href="{{ route('home') }}" class="btn" style="background: var(--surface); color: var(--text); border: 1px solid var(--border); margin-left: 0.5rem;">Go Home</a>
        </div>
    @else
        <div class="grid grid-3">
            @foreach($places as $place)
                <x-place-card :place="$place" />
            @endforeach
        </div>

        <div style="margin-top: 3rem;">
            {{ $places->links() }}
        </div>
    @endif

@endsection
