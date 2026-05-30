<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Ticket; // <--- Sesuaikan dengan nama Model Tiket kamu

class GenerateSitemap extends Command
{
    // Ini adalah nama perintah yang akan kita ketik di terminal nanti
    protected $signature = 'sitemap:generate';

    protected $description = 'Otomatis membuat file sitemap.xml untuk Google';

    public function handle()
    {
        // 1. Mulai membuat sitemap dan masukkan halaman utama/statis dulu
        $sitemap = Sitemap::create()
            ->add(Url::create('/'))
            ->add(Url::create('/terms'))
            ->add(Url::create('/contact'));
            ->add(Url::create('/privacy'));
            ->add(Url::create('/login'));
            ->add(Url::create('/register'));

        // 2. Ambil semua data tiket dari database kamu
        // (Pastikan nama modelnya sesuai, misalnya Ticket atau Tiket)
        $semuaTiket = Ticket::all(); 

        // 3. Masukkan semua link detail tiket secara otomatis menggunakan perulangan (looping)
        foreach ($semuaTiket as $tiket) {
            // Asumsinya kamu punya kolom 'slug' atau 'id' untuk URL detail tiketnya
            $sitemap->add(Url::create("/ticket/{$tiket->slug}")); 
        }

        // 4. Simpan hasilnya menjadi file sitemap.xml di folder public kamu
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Mantap! File sitemap.xml berhasil diperbarui.');
    }
}