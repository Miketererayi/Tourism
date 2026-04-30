<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function __construct(
        private readonly \App\Services\SeoService $seo
    ) {}

    public function index(Request $request): View
    {
        $country = app(Country::class);
        $queryStr = $request->input('q', '');

        $places = collect(); // Default empty if no query
        $placesQuery = null;

        if (!empty(trim($queryStr))) {
            $placesQuery = $country->places()
                ->with('category')
                ->active()
                ->where(function ($q) use ($queryStr) {
                    $q->where('title', 'LIKE', "%{$queryStr}%")
                      ->orWhere('description', 'LIKE', "%{$queryStr}%");
                });
                
            $places = $placesQuery->paginate(12)->withQueryString();
        }

        $seo = $this->seo->forSearch($country, $queryStr)->toArray();

        return view('search.index', compact('country', 'places', 'queryStr', 'seo'));
    }
}
