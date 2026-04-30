<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(
        private readonly \App\Services\SeoService $seo
    ) {}

    public function show(Request $request, string $slug): View
    {
        $country = app(Country::class);

        $category = $country->categories()
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        $query = $country->places()
            ->with(['category', 'country'])
            ->where('category_id', $category->id)
            ->active()
            ->latest('published_at');

        $searchQuery = $request->input('q');
        if (!empty($searchQuery)) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('title', 'LIKE', "%{$searchQuery}%")
                  ->orWhere('description', 'LIKE', "%{$searchQuery}%");
            });
        }

        $places = $query->paginate(12)->withQueryString();

        $seo = $this->seo->forCategory($country, $category)->toArray();

        return view('category.show', compact('country', 'category', 'places', 'searchQuery', 'seo'));
    }
}
