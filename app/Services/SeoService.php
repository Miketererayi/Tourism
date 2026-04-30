<?php

namespace App\Services;

use App\DTO\SeoData;
use App\Models\Category;
use App\Models\Country;
use App\Models\Page;
use App\Models\Place;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SeoService
{
    public function forHome(Country $country): SeoData
    {
        return new SeoData(
            title: "{$country->name} Directory — Find Places & Businesses",
            description: "Discover the best restaurants, hotels, services and businesses in {$country->name}. Your local guide to everything {$country->name}.",
            canonical: request()->getScheme() . '://' . request()->getHost() . '/'
        );
    }

    public function forCategory(Country $country, Category $category): SeoData
    {
        return new SeoData(
            title: "{$category->name} in {$country->name} — {$country->name} Directory",
            description: "Browse the best {$category->name} in {$country->name}. Find top-rated {$category->name} listings with addresses, contacts and more.",
            canonical: request()->getScheme() . '://' . request()->getHost() . '/category/' . $category->slug
        );
    }

    public function forPlace(Country $country, Place $place): SeoData
    {
        $strippedDesc = trim(strip_tags($place->description ?? ''));
        $description = $strippedDesc !== ''
            ? Str::limit($strippedDesc, 160)
            : "{$place->title} in {$country->name}. Find contact details, address and more.";

        $ogImage = $place->cover_image ? url(Storage::url($place->cover_image)) : null;

        $jsonLd = [
            '@context'    => 'https://schema.org',
            '@type'       => 'LocalBusiness',
            'name'        => $place->title,
            'description' => $strippedDesc ?: null,
            'address'     => $place->address,
            'telephone'   => $place->phone,
            'email'       => $place->email,
            'url'         => $place->website,
        ];

        if ($place->latitude !== null && $place->longitude !== null) {
            $jsonLd['geo'] = [
                '@type'     => 'GeoCoordinates',
                'latitude'  => $place->latitude,
                'longitude' => $place->longitude,
            ];
        }

        // Remove null values
        $jsonLd = array_filter($jsonLd, fn($val) => $val !== null);

        return new SeoData(
            title: "{$place->title} — " . ($place->category?->name ?? 'Places') . ", {$country->name}",
            description: $description,
            canonical: request()->getScheme() . '://' . request()->getHost() . '/place/' . $place->slug,
            og_type: 'article',
            og_image: $ogImage,
            json_ld: json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
        );
    }

    public function forSearch(Country $country, string $query): SeoData
    {
        return new SeoData(
            title: "Search '{$query}' — {$country->name} Directory",
            description: "Search results for {$query} in {$country->name}.",
            canonical: request()->getScheme() . '://' . request()->getHost() . '/search?q=' . urlencode($query),
            robots: 'noindex, follow'
        );
    }

    public function forPage(Country $country, Page $page): SeoData
    {
        $strippedContent = trim(strip_tags($page->content ?? ''));
        
        return new SeoData(
            title: $page->meta_title ?? "{$page->title} — {$country->name}",
            description: $page->meta_description ?? Str::limit($strippedContent, 160),
            canonical: request()->getScheme() . '://' . request()->getHost() . '/page/' . $page->slug
        );
    }
}
