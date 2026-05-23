<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate dynamic sitemap.xml
     */
    public function index()
    {
        try {
            $destinations = Destination::where('status', 'active')
                ->orderBy('updated_at', 'desc')
                ->get();

            return response()->view('sitemap', [
                'destinations' => $destinations,
            ])->header('Content-Type', 'text/xml');
        } catch (\Throwable $e) {
            // Temporarily return plain text error for debugging production issues
            return response($e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine(), 500)
                ->header('Content-Type', 'text/plain');
        }
    }
}
