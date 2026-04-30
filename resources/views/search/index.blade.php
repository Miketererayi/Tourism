@extends('layouts.app')

@section('title', 'Search - ' . $currentCountry->name)

@section('hero')
<div style="background: var(--surface); padding: 3rem 1rem; border-bottom: 1px solid var(--border); text-align: center;">
    <div class="container">
        <h1 style="margin-bottom: 1.5rem;">Search {{ $currentCountry->name }}</h1>
        <form action="{{ route('search.index') }}" method="GET" style="max-width: 600px; margin: 0 auto; display: flex; box-shadow: var(--shadow); border-radius: var(--radius);">
            <input type="text" name="q" placeholder="What are you looking for?" value="{{ $queryStr }}" required 
                   style="flex: 1; padding: 1rem; border: 1px solid var(--border); border-right: none; border-radius: var(--radius) 0 0 var(--radius); font-size: 1.1rem; outline: none;">
            <button type="submit" style="padding: 1rem 2rem; border: none; background: var(--primary); color: white; font-size: 1.1rem; border-radius: 0 var(--radius) var(--radius) 0; cursor: pointer; transition: background 0.2s;">
                Search
            </button>
        </form>
    </div>
</div>
@endsection

@section('content')

    @if(empty($queryStr))
        <div class="empty-state">
            <div style="font-size: 3rem; margin-bottom: 1rem;">🔍</div>
            <h2>Enter a search term above</h2>
            <p style="color: var(--text-muted); margin-bottom: 1.5rem;">Find the best places, businesses, and services.</p>
            <a href="{{ route('home') }}" class="btn">Browse Categories</a>
        </div>
    @elseif($places->isEmpty())
        <div class="empty-state">
            <div style="font-size: 3rem; margin-bottom: 1rem;">😔</div>
            <h2>No results for '{{ $queryStr }}'</h2>
            <p style="color: var(--text-muted); margin-bottom: 1.5rem;">Try adjusting your search terms or browse by category instead.</p>
            <a href="{{ route('home') }}" class="btn">Go Home</a>
        </div>
    @else
        <h2 class="section-title">{{ $places->total() }} results for '{{ $queryStr }}'</h2>
        
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
