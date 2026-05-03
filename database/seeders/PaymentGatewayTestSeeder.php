<?php

namespace Database\Seeders;

use App\Models\Destination;
use App\Models\Tag;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PaymentGatewayTestSeeder extends Seeder
{
    /**
     * Seed data dummy untuk test payment gateway.
     */
    public function run(): void
    {
        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@tiketwisata.test'],
            [
                'name' => 'Admin TiketWisata',
                'username' => 'admin_tiket',
                'phone' => '081200000001',
                'password' => Hash::make('password123'),
                'tipe_user' => User::TYPE_ADMIN,
                'balance' => 0,
                'google_id' => null,
            ]
        );

        $owner = User::query()->updateOrCreate(
            ['email' => 'owner@tiketwisata.test'],
            [
                'name' => 'Owner Candi Sejahtera',
                'username' => 'owner_candi',
                'phone' => '081200000002',
                'password' => Hash::make('password123'),
                'tipe_user' => User::TYPE_OWNER,
                'balance' => 0,
                'google_id' => null,
            ]
        );

        $buyer = User::query()->updateOrCreate(
            ['email' => 'buyer@tiketwisata.test'],
            [
                'name' => 'Buyer Test',
                'username' => 'buyer_test',
                'phone' => '081200000003',
                'password' => Hash::make('password123'),
                'tipe_user' => User::TYPE_USER,
                'balance' => 0,
                'google_id' => null,
            ]
        );

        $destination = Destination::query()->updateOrCreate(
            ['name' => 'Candi Borobudur Test'],
            [
                'user_id' => $owner->id,
                'description' => 'Destinasi dummy untuk pengujian checkout Midtrans dan webhook settlement/expire.',
                'address' => 'Jl. Badrawati, Borobudur, Magelang',
                'city' => 'Kabupaten Magelang',
                'map_link' => 'https://maps.google.com/?q=Candi+Borobudur',
                'open_time' => '08:00:00',
                'close_time' => '17:00:00',
                'status' => 'active',
            ]
        );

        $tagBudaya = Tag::query()->updateOrCreate(['name' => 'Budaya']);
        $tagSejarah = Tag::query()->updateOrCreate(['name' => 'Sejarah']);
        $destination->tags()->syncWithoutDetaching([$tagBudaya->id, $tagSejarah->id]);

        Ticket::query()->updateOrCreate(
            [
                'destination_id' => $destination->id,
                'name' => 'Tiket Reguler Borobudur',
            ],
            [
                'price' => 50000,
                'benefit' => 'Akses area utama Candi Borobudur + area taman wisata',
                'daily_quota' => 200,
                'current_quota' => 200,
            ]
        );

        Ticket::query()->updateOrCreate(
            [
                'destination_id' => $destination->id,
                'name' => 'Tiket Sunrise Borobudur',
            ],
            [
                'price' => 150000,
                'benefit' => 'Akses sunrise spot + pemandu lokal + welcome drink',
                'daily_quota' => 50,
                'current_quota' => 50,
            ]
        );

        $this->command?->info('Dummy payment gateway selesai dibuat.');
        $this->command?->line('Akun buyer: buyer_test / password123');
        $this->command?->line('Akun owner: owner_candi / password123');
        $this->command?->line('Akun admin: admin_tiket / password123');
        $this->command?->line("Destinasi: {$destination->name}");
    }
}
