<?php

namespace Database\Seeders;

use App\Models\Destination;
use App\Models\Tag;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Dapatkan atau buat Owner
        $owner = User::where('email', 'owner@tiketwisata.test')->first();
        if (!$owner) {
            $owner = User::create([
                'name' => 'Owner Utama',
                'username' => 'owner_utama',
                'email' => 'owner@tiketwisata.test',
                'phone' => '081234567890',
                'password' => Hash::make('password'),
                'tipe_user' => User::TYPE_OWNER,
                'balance' => 0,
            ]);
        }

        // 2. Buat beberapa Tag
        $tagNames = ['Alam', 'Budaya', 'Sejarah', 'Edukasi', 'Wahana', 'Kuliner', 'Pantai', 'Pegunungan', 'Religi', 'Seni'];
        $tags = [];
        foreach ($tagNames as $name) {
            $tags[] = Tag::firstOrCreate(['name' => $name]);
        }

        // 3. Buat 30 Tempat Wisata
        $cities = ['Yogyakarta', 'Magelang', 'Solo', 'Semarang', 'Bandung', 'Jakarta', 'Bali', 'Malang', 'Surabaya', 'Bogor'];
        
        for ($i = 1; $i <= 30; $i++) {
            $isBorobudur = ($i === 1);
            $name = $isBorobudur ? 'Candi Borobudur' : 'Tempat Wisata ' . $i . ' - ' . Str::random(5);
            
            $destination = Destination::create([
                'user_id' => $owner->id,
                'name' => $name,
                'description' => 'Ini adalah deskripsi untuk ' . $name . '. Tempat wisata yang sangat menarik untuk dikunjungi bersama keluarga dan teman-teman. Menawarkan pemandangan yang indah dan pengalaman yang tak terlupakan.',
                'address' => 'Jl. Wisata No. ' . $i . ', Area ' . $cities[array_rand($cities)],
                'city' => $cities[array_rand($cities)],
                'map_link' => 'https://maps.google.com/?q=' . urlencode($name),
                'open_time' => '08:00:00',
                'close_time' => '17:00:00',
                'status' => 'active',
            ]);

            // Tempelkan 2-3 tag acak
            $randomTags = collect($tags)->random(rand(2, 3))->pluck('id')->toArray();
            $destination->tags()->attach($randomTags);

            // 4. Tambah Tiket
            $ticketCount = $isBorobudur ? 30 : 10;
            
            for ($j = 1; $j <= $ticketCount; $j++) {
                Ticket::create([
                    'destination_id' => $destination->id,
                    'name' => 'Tiket ' . ($isBorobudur ? 'Eksklusif ' : 'Reguler ') . $j,
                    'price' => rand(5, 20) * 10000, // Rp 50.000 - Rp 200.000
                    'benefit' => 'Benefit ' . $j . ': Akses masuk, asuransi, dan fasilitas standar.',
                    'daily_quota' => rand(50, 100),
                ]);
            }
        }

        $this->command?->info('30 destinasi wisata berhasil dibuat dengan ' . $owner->email);
    }
}
