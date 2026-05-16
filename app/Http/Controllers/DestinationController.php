<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DestinationController extends Controller
{
    public function index(Request $request): View
    {
        if (! Schema::hasTable('destinations')) {
            return view('destinations.index', [
                'destinations' => new LengthAwarePaginator([], 0, 20),
                'tags' => collect(),
                'cities' => collect(),
            ]);
        }

        $destinations = Destination::query()
            ->with(['tags', 'images', 'tickets'])
            ->withAvg('transactions', 'rating')
            ->when(auth()->check(), fn($q) => $q->with(['wishlists' => fn($qw) => $qw->where('user_id', auth()->id())]))
            ->where('status', 'active')
            // Multi-tag support (OR logic)
            ->when($request->filled('tags'), function ($query) use ($request) {
                $tags = is_array($request->tags) ? $request->tags : [$request->tags];
                $query->whereHas('tags', fn($q) => $q->whereIn('tags.id', $tags));
            })
            // Price range support
            ->when($request->filled('min_price'), function ($query) use ($request) {
                $query->whereHas('tickets', fn($q) => $q->where('price', '>=', $request->min_price));
            })
            ->when($request->filled('max_price'), function ($query) use ($request) {
                $query->whereHas('tickets', fn($q) => $q->where('price', '<=', $request->max_price));
            })
            ->when($request->filled('city'), fn($query) => $query->where('city', $request->string('city')->toString()))
            ->when($request->filled('q'), fn($query) => $query->where('name', 'like', '%' . $request->string('q')->toString() . '%'));

        // Sorting
        $sort = $request->get('sort', 'latest');
        $destinations = match ($sort) {
            'price_asc' => $destinations->addSelect(['min_price' => \App\Models\Ticket::select('price')->whereColumn('destination_id', 'destinations.id')->orderBy('price')->limit(1)])->orderBy('min_price', 'asc'),
            'price_desc' => $destinations->addSelect(['min_price' => \App\Models\Ticket::select('price')->whereColumn('destination_id', 'destinations.id')->orderBy('price')->limit(1)])->orderBy('min_price', 'desc'),
            'rating_desc' => $destinations->orderBy('transactions_avg_rating', 'desc'),
            default => $destinations->latest(),
        };

        $destinations = $destinations->paginate(20)->withQueryString();

        $tags = Tag::query()->orderBy('name')->get(['id', 'name']);
        $cities = Destination::query()->where('status', 'active')->distinct()->pluck('city');

        return view('destinations.index', compact('destinations', 'tags', 'cities'));
    }

    public function show(Destination $destination): View
    {
        $destination->load(['tags', 'images', 'tickets']);
        $destination->loadAvg('transactions', 'rating');

        return view('destinations.show', compact('destination'));
    }

    public function loadMore(Request $request)
    {
        $destinations = Destination::query()
            ->with(['tags', 'images', 'tickets'])
            ->withAvg('transactions', 'rating')
            ->when(auth()->check(), fn($q) => $q->with(['wishlists' => fn($qw) => $qw->where('user_id', auth()->id())]))
            ->where('status', 'active')
            // Multi-tag support (OR logic)
            ->when($request->filled('tags'), function ($query) use ($request) {
                $tags = is_array($request->tags) ? $request->tags : [$request->tags];
                $query->whereHas('tags', fn($q) => $q->whereIn('tags.id', $tags));
            })
            // Price range support
            ->when($request->filled('min_price'), function ($query) use ($request) {
                $query->whereHas('tickets', fn($q) => $q->where('price', '>=', $request->min_price));
            })
            ->when($request->filled('max_price'), function ($query) use ($request) {
                $query->whereHas('tickets', fn($q) => $q->where('price', '<=', $request->max_price));
            })
            ->when($request->filled('city'), fn($query) => $query->where('city', $request->string('city')->toString()))
            ->when($request->filled('q'), fn($query) => $query->where('name', 'like', '%' . $request->string('q')->toString() . '%'));

        // Sorting
        $sort = $request->get('sort', 'latest');
        $destinations = match ($sort) {
            'price_asc' => $destinations->addSelect(['min_price' => \App\Models\Ticket::select('price')->whereColumn('destination_id', 'destinations.id')->orderBy('price')->limit(1)])->orderBy('min_price', 'asc'),
            'price_desc' => $destinations->addSelect(['min_price' => \App\Models\Ticket::select('price')->whereColumn('destination_id', 'destinations.id')->orderBy('price')->limit(1)])->orderBy('min_price', 'desc'),
            'rating_desc' => $destinations->orderBy('transactions_avg_rating', 'desc'),
            default => $destinations->latest(),
        };

        $destinations = $destinations->paginate(20, ['*'], 'page', $request->page);

        $html = view('destinations.partials.cards', compact('destinations'))->render();

        return response()->json([
            'html' => $html,
            'has_more' => $destinations->hasMorePages(),
        ]);
    }
}
