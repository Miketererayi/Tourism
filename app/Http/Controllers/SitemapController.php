<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use DOMDocument;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $countries = Country::where('is_active', true)->get();
        
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;
        
        $sitemapindex = $dom->createElement('sitemapindex');
        $sitemapindex->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        $dom->appendChild($sitemapindex);

        $host = request()->getSchemeAndHttpHost();

        foreach ($countries as $country) {
            $sitemap = $dom->createElement('sitemap');
            
            $loc = $dom->createElement('loc', "{$host}/sitemap-{$country->code}.xml");
            $sitemap->appendChild($loc);
            
            $lastmod = $dom->createElement('lastmod', now()->toAtomString());
            $sitemap->appendChild($lastmod);
            
            $sitemapindex->appendChild($sitemap);
        }

        return response($dom->saveXML(), 200, [
            'Content-Type' => 'application/xml'
        ]);
    }

    public function country(string $code): Response
    {
        $country = Country::where('code', $code)->where('is_active', true)->firstOrFail();
        $host = "https://{$country->domain}";
        
        $xmlContent = Cache::remember("sitemap_{$code}", 86400, function () use ($country, $host) {
            $dom = new DOMDocument('1.0', 'UTF-8');
            $dom->formatOutput = true;
            
            $urlset = $dom->createElement('urlset');
            $urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
            $dom->appendChild($urlset);
            
            // Home URL
            $this->addUrl($dom, $urlset, "{$host}/", '1.0', 'daily', now()->toAtomString());
            
            // Categories
            $categories = $country->categories()->active()->get();
            foreach ($categories as $category) {
                $this->addUrl($dom, $urlset, "{$host}/category/{$category->slug}", '0.8', 'weekly', $category->updated_at?->toAtomString());
            }
            
            // Places
            $places = $country->places()->active()->published()->get();
            foreach ($places as $place) {
                $this->addUrl($dom, $urlset, "{$host}/place/{$place->slug}", '0.6', 'weekly', $place->updated_at?->toAtomString());
            }
            
            // Pages
            $pages = $country->pages()->active()->get();
            foreach ($pages as $page) {
                $this->addUrl($dom, $urlset, "{$host}/page/{$page->slug}", '0.4', 'monthly', $page->updated_at?->toAtomString());
            }
            
            return $dom->saveXML();
        });

        return response($xmlContent, 200, [
            'Content-Type' => 'application/xml'
        ]);
    }

    private function addUrl(DOMDocument $dom, \DOMElement $urlset, string $loc, string $priority, string $changefreq, ?string $lastmod = null): void
    {
        $url = $dom->createElement('url');
        
        $locNode = $dom->createElement('loc', htmlspecialchars($loc, ENT_XML1, 'UTF-8'));
        $url->appendChild($locNode);
        
        if ($lastmod) {
            $lastmodNode = $dom->createElement('lastmod', $lastmod);
            $url->appendChild($lastmodNode);
        }
        
        $changefreqNode = $dom->createElement('changefreq', $changefreq);
        $url->appendChild($changefreqNode);
        
        $priorityNode = $dom->createElement('priority', $priority);
        $url->appendChild($priorityNode);
        
        $urlset->appendChild($url);
    }
}
