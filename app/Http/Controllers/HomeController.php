<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        private readonly \App\Services\SeoService $seo
    ) {}

    public function index(): View
    {
        $country = app(Country::class);

        $categories = $country->categories()
            ->withCount(['places' => function ($query) {
                $query->active();
            }])
            ->active()
            ->ordered()
            ->get();

        $featuredPlaces = $country->places()
            ->with('category')
            ->active()
            ->featured()
            ->latest('published_at')
            ->take(6)
            ->get();

        $latestPlaces = $country->places()
            ->with('category')
            ->active()
            ->latest('published_at')
            ->take(8)
            ->get();

        $seo = $this->seo->forHome($country)->toArray();

        return view('home', compact('country', 'categories', 'featuredPlaces', 'latestPlaces', 'seo'));
    }
}
