<?php

namespace Tests\Feature;

use App\Models\Destination;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SitemapTest extends TestCase
{
    use RefreshDatabase;

    public function test_sitemap_returns_xml_and_contains_pages()
    {
        // Create an owner/user
        $user = User::factory()->create();

        // Create an active destination
        $destination = Destination::create([
            'user_id' => $user->id,
            'name' => 'Kawah Putih',
            'description' => 'Beautiful volcanic lake in Ciwidey.',
            'address' => 'Ciwidey, Bandung',
            'city' => 'Bandung',
            'open_time' => '07:00:00',
            'close_time' => '17:00:00',
            'status' => 'active',
        ]);

        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/xml; charset=UTF-8');

        // Check if the response contains the URLs
        $response->assertSee(url('/'));
        $response->assertSee(url('/wisata'));
        $response->assertSee(url('/terms'));
        $response->assertSee(url('/privacy'));
        $response->assertSee(url('/contact'));
        $response->assertSee(route('destinations.show', $destination));
    }
}
