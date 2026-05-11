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
            ->with(['tags', 'images'])
            ->withAvg('transactions', 'rating')
            ->where('status', 'active')
            ->when($request->filled('tag'), function ($query) use ($request) {
                $query->whereHas('tags', fn($q) => $q->where('tags.id', $request->integer('tag')));
            })
            ->when($request->filled('city'), fn($query) => $query->where('city', $request->string('city')->toString()))
            ->when($request->filled('q'), fn($query) => $query->where('name', 'like', '%' . $request->string('q')->toString() . '%'))
            ->paginate(20);

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
            ->with(['tags', 'images'])
            ->withAvg('transactions', 'rating')
            ->where('status', 'active')
            ->when($request->filled('tag'), function ($query) use ($request) {
                $query->whereHas('tags', fn($q) => $q->where('tags.id', $request->integer('tag')));
            })
            ->when($request->filled('city'), fn($query) => $query->where('city', $request->string('city')->toString()))
            ->when($request->filled('q'), fn($query) => $query->where('name', 'like', '%' . $request->string('q')->toString() . '%'))
            ->paginate(20, ['*'], 'page', $request->page);

        $html = view('destinations.partials.cards', compact('destinations'))->render();

        return response()->json([
            'html' => $html,
            'has_more' => $destinations->hasMorePages(),
        ]);
    }
}
