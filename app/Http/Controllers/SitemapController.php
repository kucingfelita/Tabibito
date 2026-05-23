<?php

namespace App\Http\Controllers;

use App\Models\Destination;

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

            $content = view('sitemap', ['destinations' => $destinations])->render();

            // Prepend XML declaration from PHP so short_open_tag=On servers don't break it
            $xmlDeclaration = '<' . '?xml version="1.0" encoding="UTF-8"?' . '>';
            $content = $xmlDeclaration . "\n" . $content;

            return response($content, 200)->header('Content-Type', 'text/xml; charset=UTF-8');
        } catch (\Throwable $e) {
            // Temporarily return plain text error for debugging production issues
            return response($e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine(), 500)
                ->header('Content-Type', 'text/plain');
        }
    }
}
