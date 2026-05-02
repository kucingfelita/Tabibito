<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Destination;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class OwnerRegisterController extends Controller
{
   protected function jawaTengahCities(): array
   {
      return [
         'Semarang',
         'Surakarta',
         'Kota Salatiga',
         'Kota Magelang',
         'Kota Pekalongan',
         'Kota Tegal',
         'Kota Pekalongan',
         'Kabupaten Banjarnegara',
         'Kabupaten Banyumas',
         'Kabupaten Batang',
         'Kabupaten Blora',
         'Kabupaten Boyolali',
         'Kabupaten Brebes',
         'Kabupaten Cilacap',
         'Kabupaten Demak',
         'Kabupaten Grobogan',
         'Kabupaten Jepara',
         'Kabupaten Karanganyar',
         'Kabupaten Kebumen',
         'Kabupaten Kendal',
         'Kabupaten Klaten',
         'Kabupaten Kudus',
         'Kabupaten Pati',
         'Kabupaten Pekalongan',
         'Kabupaten Pemalang',
         'Kabupaten Purbalingga',
         'Kabupaten Purworejo',
         'Kabupaten Rembang',
         'Kabupaten Semarang',
         'Kabupaten Sragen',
         'Kabupaten Sukoharjo',
         'Kabupaten Tegal',
         'Kabupaten Temanggung',
         'Kabupaten Wonogiri',
         'Kabupaten Wonosobo',
      ];
   }

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
      $cities = $this->jawaTengahCities();

      return view('owner.register.step2', compact('tags', 'cities'));
   }

   public function storeStep2(Request $request)
   {
      $request->validate([
         'nama_tempat' => 'required|string|max:255',
         'nama_pemilik' => 'required|string|max:255',
         'description' => 'required|string',
         'tag_ids' => 'nullable|array|required_without:custom_tags',
         'tag_ids.*' => 'exists:tags,id',
         'custom_tags' => 'nullable|string|max:255|required_without:tag_ids',
         'domisili' => 'required|string|max:255',
         'city' => ['required', 'string', Rule::in($this->jawaTengahCities())],
         'open_time' => 'required|date_format:H:i',
         'close_time' => 'required|date_format:H:i',
      ], [
         'tag_ids.required_without' => 'Pilih minimal satu tag atau masukkan tag baru.',
         'custom_tags.required_without' => 'Pilih minimal satu tag atau masukkan tag baru.',
         'city.required' => 'Kota/domisi wajib diisi.',
         'city.in' => 'Pilih kota atau kabupaten di Jawa Tengah saja.',
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
            'description' => $request->description,
            'address' => $request->domisili,
            'city' => $request->city,
            'open_time' => $request->open_time,
            'close_time' => $request->close_time,
            'status' => 'pending',
         ]);

         $tagIds = $request->input('tag_ids', []);

         if ($request->filled('custom_tags')) {
            $customTags = collect(explode(',', $request->custom_tags))
               ->map(fn($tag) => trim($tag))
               ->filter()
               ->unique();

            foreach ($customTags as $tagName) {
               $tag = Tag::firstOrCreate(['name' => $tagName]);
               $tagIds[] = $tag->id;
            }
         }

         $tagIds = array_unique($tagIds);
         if (!empty($tagIds)) {
            $destination->tags()->sync($tagIds);
         }
      });

      session()->forget('owner_register');

      return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Tunggu verifikasi admin.');
   }
}
