<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $recommendations = collect();
        $tags = collect();
        $cities = collect();

        if (Schema::hasTable('destinations')) {
            $recommendations = Destination::query()
                ->where('status', 'active')
                ->with(['tickets:id,destination_id,price', 'images', 'coverImage', 'tags'])
                ->when(auth()->check(), fn($q) => $q->with(['wishlists' => fn($qw) => $qw->where('user_id', auth()->id())]))
                ->withAvg('transactions', 'rating')
                ->withCount('transactions')
                ->orderByDesc('transactions_avg_rating')
                ->orderByDesc('transactions_count')
                ->take(3)
                ->get();

            $cities = Destination::query()->where('status', 'active')->distinct()->pluck('city');
        }

        if (Schema::hasTable('tags')) {
            $tags = \App\Models\Tag::query()->orderBy('name')->get(['id', 'name']);
        }

        return view('home.index', compact('recommendations', 'cities', 'tags'));
    }

    public function terms(): View
    {
        return view('home.terms');
    }

    public function partnershipTerms(): View
    {
        return view('home.partnership-terms');
    }

    public function privacy(): View
    {
        return view('home.privacy');
    }
}
