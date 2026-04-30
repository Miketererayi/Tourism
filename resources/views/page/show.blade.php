@extends('layouts.app')

@section('title', $page->title . ' - ' . $country->name)
@section('meta_description', $page->meta_description ?? Str::limit(strip_tags($page->content), 160))

@section('content')

    <div style="max-width: 800px; margin: 3rem auto; background: var(--surface); padding: 3rem; border-radius: var(--radius); box-shadow: var(--shadow);">
        
        <h1 style="font-size: 2.5rem; margin-bottom: 2rem; color: var(--text); border-bottom: 1px solid var(--border); padding-bottom: 1rem;">
            {{ $page->title }}
        </h1>
        
        <div style="line-height: 1.8; font-size: 1.1rem; color: var(--text);">
            {!! $page->content !!}
        </div>
        
    </div>

@endsection
