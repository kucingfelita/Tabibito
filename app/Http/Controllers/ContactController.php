<?php

namespace App\Http\Controllers;

use App\Jobs\SendFeedbackMailJob;
use Illuminate\Http\Request;

class ContactController extends Controller
{
   public function index()
   {
      return view('checkout.contact.index');
   }

   public function store(Request $request)
   {
      $request->validate([
         'name' => 'required|string|max:255',
         'email' => 'required|email',
         'message' => 'required|string|max:1000',
      ]);

      // Queue feedback email
      SendFeedbackMailJob::dispatch($request->only(['name', 'email', 'message']));

      return back()->with('success', 'Terima kasih atas feedback Anda!');
   }
}
