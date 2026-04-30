<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\View\View;

class TicketController extends Controller
{
   public function show(Ticket $ticket): View
   {
      $ticket->load(['destination.tags', 'destination.images']);

      return view('tickets.show', compact('ticket'));
   }
}
