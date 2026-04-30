<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Destination;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OwnerRegisterController extends Controller
{
   public function step1()
   {
      return view('owner.register.step1');
   }

   public function storeStep1(Request $request)
   {
      $request->validate([
         'username' => 'required|unique:users|alpha_num|max:255',
         'email' => 'required|email|unique:users',
         'password' => 'required|min:8|confirmed',
      ]);

      session(['owner_register' => $request->only(['username', 'email', 'password'])]);

      return redirect()->route('owner.register.step2');
   }

   public function step2()
   {
      if (!session('owner_register')) {
         return redirect()->route('owner.register.step1');
      }

      $tags = Tag::all();

      return view('owner.register.step2', compact('tags'));
   }

   public function storeStep2(Request $request)
   {
      $request->validate([
         'nama_tempat' => 'required|string|max:255',
         'nama_pemilik' => 'required|string|max:255',
         'tag_ids' => 'required|array',
         'domisili' => 'required|string|max:255',
      ]);

      $step1Data = session('owner_register');
      if (!$step1Data) {
         return redirect()->route('owner.register.step1');
      }

      DB::transaction(function () use ($request, $step1Data) {
         $user = User::create([
            'username' => $step1Data['username'],
            'email' => $step1Data['email'],
            'password' => Hash::make($step1Data['password']),
            'tipe_user' => 3, // Owner
            'name' => $request->nama_pemilik,
         ]);

         $destination = Destination::create([
            'user_id' => $user->id,
            'name' => $request->nama_tempat,
            'address' => $request->domisili,
            'city' => $request->domisili, // Assuming domisili is city
            'status' => 'pending',
         ]);

         $destination->tags()->attach($request->tag_ids);
      });

      session()->forget('owner_register');

      return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Tunggu verifikasi admin.');
   }
}
