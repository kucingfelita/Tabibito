<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\OwnerTicketRequest;
use App\Models\Destination;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TicketController extends Controller
{
    public function index(): View
    {
        $ownerId = auth()->id();
        $destinations = Destination::query()
            ->where('user_id', $ownerId)
            ->orderBy('name')
            ->get(['id', 'name']);

        $tickets = Ticket::query()
            ->whereHas('destination', fn ($q) => $q->where('user_id', $ownerId))
            ->with('destination:id,name')
            ->latest()
            ->paginate(10);

        return view('owner.tickets.index', compact('tickets', 'destinations'));
    }

    public function store(OwnerTicketRequest $request): RedirectResponse
    {
        $this->assertOwnerOwnsDestination($request->integer('destination_id'));

        $dailyQuota = $request->integer('daily_quota');
        Ticket::query()->create([
            'destination_id' => $request->integer('destination_id'),
            'name' => $request->string('name')->toString(),
            'price' => $request->input('price'),
            'benefit' => $request->input('benefit'),
            'daily_quota' => $dailyQuota,
            'current_quota' => $dailyQuota,
        ]);

        return back()->with('success', 'Tiket berhasil ditambahkan.');
    }

    public function update(OwnerTicketRequest $request, Ticket $ticket): RedirectResponse
    {
        $this->assertOwnerOwnsDestination($request->integer('destination_id'));
        abort_unless((int) $ticket->destination->user_id === (int) auth()->id(), 403);

        $dailyQuota = $request->integer('daily_quota');
        $ticket->update([
            'destination_id' => $request->integer('destination_id'),
            'name' => $request->string('name')->toString(),
            'price' => $request->input('price'),
            'benefit' => $request->input('benefit'),
            'daily_quota' => $dailyQuota,
            'current_quota' => min((int) $ticket->current_quota, $dailyQuota),
        ]);

        return back()->with('success', 'Tiket berhasil diperbarui.');
    }

    public function destroy(Ticket $ticket): RedirectResponse
    {
        abort_unless((int) $ticket->destination->user_id === (int) auth()->id(), 403);
        $ticket->delete();

        return back()->with('success', 'Tiket berhasil dihapus.');
    }

    private function assertOwnerOwnsDestination(int $destinationId): void
    {
        $owned = Destination::query()
            ->where('id', $destinationId)
            ->where('user_id', auth()->id())
            ->exists();

        abort_unless($owned, 403);
    }
}
