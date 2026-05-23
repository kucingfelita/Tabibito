<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate dynamic sitemap.xml
     */
    public function index(): Response
    {
        $destinations = Destination::where('status', 'active')
            ->orderBy('updated_at', 'desc')
            ->get();

        return response()->view('sitemap', [
            'destinations' => $destinations,
        ])->header('Content-Type', 'text/xml');
    }
}
