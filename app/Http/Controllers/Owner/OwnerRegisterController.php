<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Jobs\SendOwnerPartnerWelcomeMailJob;
use App\Models\User;
use App\Models\Destination;
use App\Models\DestinationImage;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class OwnerRegisterController extends Controller
{
   protected function jawaTengahCities(): array
   {
      return [
         'Kota Semarang',
         'Kota Surakarta',
         'Kota Salatiga',
         'Kota Magelang',
         'Kota Pekalongan',
         'Kota Tegal',
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
          'map_link' => 'nullable|url|max:255',
          'cover_image' => 'required|image|max:5120',
          'slide_images' => 'nullable|array|max:7',
          'slide_images.*' => 'image|max:5120',
       ], [
          'tag_ids.required_without' => 'Pilih minimal satu tag atau masukkan tag baru.',
          'custom_tags.required_without' => 'Pilih minimal satu tag atau masukkan tag baru.',
          'city.required' => 'Kota/domisi wajib diisi.',
          'city.in' => 'Pilih kota atau kabupaten di Jawa Tengah saja.',
          'cover_image.required' => 'Foto Cover wajib diunggah.',
          'map_link.url' => 'Masukkan format link Google Maps yang valid.',
       ]);

       $step1Data = session('owner_register');
       if (!$step1Data) {
          return redirect()->route('owner.register.step1');
       }

       $registeredUser = null;
       $registeredDestination = null;

       DB::transaction(function () use ($request, $step1Data, &$registeredUser, &$registeredDestination) {
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
             'map_link' => $request->map_link,
             'open_time' => $request->open_time,
             'close_time' => $request->close_time,
             'status' => 'pending',
          ]);

          // Save Cover Image
          if ($request->hasFile('cover_image')) {
             $path = $this->compressAndStoreImage($request->file('cover_image'));
             DestinationImage::create([
                'destination_id' => $destination->id,
                'image_path'     => $path,
                'is_cover'       => true,
             ]);
          }

          // Save Slide Images
          if ($request->hasFile('slide_images')) {
             foreach ($request->file('slide_images') as $image) {
                $path = $this->compressAndStoreImage($image);
                DestinationImage::create([
                   'destination_id' => $destination->id,
                   'image_path' => $path,
                   'is_cover' => false,
                ]);
             }
          }

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

          $registeredUser = $user;
          $registeredDestination = $destination;
       });

       if ($registeredUser && $registeredDestination) {
          SendOwnerPartnerWelcomeMailJob::dispatch($registeredUser, $registeredDestination);
       }

       session()->forget('owner_register');

       return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Tunggu verifikasi admin.');
    }

    private function compressAndStoreImage(UploadedFile $file): string
    {
        $targetPath = 'destinations/' . uniqid('img_', true) . '.jpg';

        try {
            if (!class_exists(ImageManager::class) || !class_exists(Driver::class)) {
                throw new \Exception('Intervention Image classes missing');
            }

            $manager = new ImageManager(new Driver());
            $image = $manager->read($file->getRealPath())->scaleDown(width: 1600);
            $encoded = $image->toJpeg(75);
            
            Storage::disk('public')->put($targetPath, $encoded->toStream());

            return $targetPath;
        } catch (\Throwable $e) {
            // Fallback to standard upload
            return $file->store('destinations', 'public');
        }
    }
}
