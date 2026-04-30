<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\View\View;

class PageController extends Controller
{
    public function __construct(
        private readonly \App\Services\SeoService $seo
    ) {}

    public function show(string $slug): View
    {
        $country = app(Country::class);

        $page = $country->pages()
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        $seo = $this->seo->forPage($country, $page)->toArray();

        return view('page.show', compact('country', 'page', 'seo'));
    }
}
