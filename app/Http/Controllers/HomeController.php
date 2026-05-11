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

        if (Schema::hasTable('destinations')) {
            $recommendations = Destination::query()
                ->where('status', 'active')
                ->with('tickets:id,destination_id,price')
                ->withAvg('transactions', 'rating')
                ->latest()
                ->take(3)
                ->get();
        }

        return view('home.index', compact('recommendations'));
    }
}
