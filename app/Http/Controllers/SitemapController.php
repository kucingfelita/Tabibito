<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    /**
     * Generate dynamic sitemap.xml using spatie/laravel-sitemap
     */
    public function index(Request $request)
    {
        $sitemap = Sitemap::create();

        // Static pages
        $sitemap->add(
            Url::create('/')
                ->setPriority(1.0)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setLastModificationDate(Carbon::today())
        );

        $sitemap->add(
            Url::create('/wisata')
                ->setPriority(0.8)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setLastModificationDate(Carbon::today())
        );

        $sitemap->add(
            Url::create('/contact')
                ->setPriority(0.5)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setLastModificationDate(Carbon::create(2026, 1, 1))
        );

        $sitemap->add(
            Url::create('/terms')
                ->setPriority(0.3)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setLastModificationDate(Carbon::create(2026, 1, 1))
        );

        $sitemap->add(
            Url::create('/privacy')
                ->setPriority(0.3)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setLastModificationDate(Carbon::create(2026, 1, 1))
        );

        // Dynamic destination pages
        Destination::where('status', 'active')
            ->orderBy('updated_at', 'desc')
            ->get()
            ->each(function (Destination $destination) use ($sitemap) {
                $sitemap->add(
                    Url::create(route('destinations.show', $destination))
                        ->setPriority(0.7)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                        ->setLastModificationDate($destination->updated_at ?? Carbon::today())
                );
            });

        return $sitemap->toResponse($request);
    }
}
