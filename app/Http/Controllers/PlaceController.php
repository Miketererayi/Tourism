<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\View\View;

class PlaceController extends Controller
{
    public function __construct(
        private readonly \App\Services\SeoService $seo
    ) {}

    public function show(string $slug): View
    {
        $country = app(Country::class);

        $place = $country->places()
            ->with(['category', 'country', 'images' => function ($query) {
                $query->orderBy('sort_order');
            }])
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        $relatedPlaces = $country->places()
            ->where('category_id', $place->category_id)
            ->where('id', '!=', $place->id)
            ->active()
            ->latest('published_at')
            ->take(4)
            ->get();

        $seo = $this->seo->forPlace($country, $place)->toArray();

        return view('place.show', compact('country', 'place', 'relatedPlaces', 'seo'));
    }
}
