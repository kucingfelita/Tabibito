<?php

namespace App\Http\Controllers\Traveler;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Wishlist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(): View
    {
        $destinations = auth()->user()->wishlistedDestinations()
            ->with(['tags', 'images'])
            ->withAvg('transactions', 'rating')
            ->paginate(12);

        return view('traveler.wishlist', compact('destinations'));
    }

    public function toggle(Destination $destination): JsonResponse
    {
        $user = auth()->user();
        $wishlist = Wishlist::where('user_id', $user->id)
            ->where('destination_id', $destination->id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $status = 'removed';
            $message = 'Berhasil dihapus dari wishlist.';
        } else {
            Wishlist::create([
                'user_id' => $user->id,
                'destination_id' => $destination->id,
            ]);
            $status = 'added';
            $message = 'Berhasil ditambahkan ke wishlist.';
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }
}
