<?php

namespace Database\Seeders;

use App\Models\Destination;
use App\Models\Tag;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TourDestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'owner' => [
                    'name' => 'Budi Santoso',
                    'username' => 'owner1',
                    'email' => 'ownerwisata1@mail.com',
                ],
                'destination' => [
                    'name' => 'Kawah Sikidang',
                    'description' => 'Kawah vulkanik aktif yang terkenal di Dataran Tinggi Dieng dengan fenomena kawah utama yang selalu berpindah-pindah. Menyajikan pemandangan asap belerang yang eksotis dan tanah vulkanik putih kekuningan.',
                    'address' => 'Bakal, Dieng Kulon, Batur',
                    'city' => 'Banjarnegara',
                    'map_link' => 'https://maps.google.com/?q=Kawah+Sikidang+Dieng',
                    'open_time' => '07:00:00',
                    'close_time' => '17:00:00',
                    'status' => 'active',
                ],
                'tags' => ['Alam', 'Pegunungan'],
                'tickets' => [
                    ['name' => 'Tiket Masuk Reguler (Domestik)', 'price' => 20000, 'benefit' => 'Akses area Kawah Sikidang, jembatan kayu catwalk, dan asuransi Jasa Raharja', 'daily_quota' => 200],
                    ['name' => 'Tiket Terusan Dieng (Sikidang + Arjuna)', 'price' => 35000, 'benefit' => 'Akses masuk Kawah Sikidang dan Kompleks Candi Arjuna', 'daily_quota' => 150],
                    ['name' => 'Tiket Masuk Wisatawan Asing (Foreigner)', 'price' => 80000, 'benefit' => 'Entrance fee to Sikidang Crater, english map, and welcome drink/mineral water', 'daily_quota' => 50],
                    ['name' => 'Tiket Rombongan (Min. 15 Orang)', 'price' => 17000, 'benefit' => 'Akses grup, asuransi, dan free local guide untuk rombongan', 'daily_quota' => 100],
                ]
            ],
            [
                'owner' => [
                    'name' => 'Eko Prasetyo',
                    'username' => 'owner2',
                    'email' => 'ownerwisata2@mail.com',
                ],
                'destination' => [
                    'name' => 'Candi Borobudur',
                    'description' => 'Candi Buddha terbesar di dunia dan salah satu warisan budaya dunia UNESCO yang megah. Terkenal dengan relief indahnya dan stupa yang berjejer rapi menghadap pemandangan perbukitan Menoreh.',
                    'address' => 'Jl. Badrawati, Borobudur',
                    'city' => 'Magelang',
                    'map_link' => 'https://maps.google.com/?q=Candi+Borobudur',
                    'open_time' => '06:30:00',
                    'close_time' => '17:00:00',
                    'status' => 'active',
                ],
                'tags' => ['Budaya', 'Sejarah', 'Edukasi', 'Religi'],
                'tickets' => [
                    ['name' => 'Tiket Pelataran Candi (Domestik)', 'price' => 50000, 'benefit' => 'Akses area pelataran/taman candi, pin souvenir, dan asuransi', 'daily_quota' => 300],
                    ['name' => 'Tiket Pelataran Candi (Anak/Pelajar)', 'price' => 25000, 'benefit' => 'Akses pelataran candi untuk anak usia 3-10 tahun atau pelajar kartu OSIS', 'daily_quota' => 200],
                    ['name' => 'Tiket Naik Struktur Stupa Candi', 'price' => 120000, 'benefit' => 'Akses naik ke atas stupa candi, dipandu pemandu wisata lokal, dan mendapatkan sandal Upanat gratis', 'daily_quota' => 100],
                    ['name' => 'Tiket Terusan (Borobudur + Mendut + Pawon)', 'price' => 75000, 'benefit' => 'Akses pelataran Borobudur ditambah kunjungan Candi Mendut dan Candi Pawon', 'daily_quota' => 100],
                    ['name' => 'Tiket Wisatawan Mancanegara (Foreigner)', 'price' => 375000, 'benefit' => 'Full access to temple structure, professional English guide, Upanat sandals, and souvenir', 'daily_quota' => 80],
                ]
            ],
            [
                'owner' => [
                    'name' => 'Siti Aminah',
                    'username' => 'owner3',
                    'email' => 'ownerwisata3@mail.com',
                ],
                'destination' => [
                    'name' => 'Telaga Warna',
                    'description' => 'Danau vulkanik cantik di Dataran Tinggi Dieng yang terkenal karena airnya yang dapat berubah warna (hijau, kuning, biru) akibat konsentrasi belerang yang tinggi yang memantulkan sinar matahari.',
                    'address' => 'Dieng, Kejajar',
                    'city' => 'Wonosobo',
                    'map_link' => 'https://maps.google.com/?q=Telaga+Warna+Dieng',
                    'open_time' => '07:30:00',
                    'close_time' => '16:30:00',
                    'status' => 'active',
                ],
                'tags' => ['Alam', 'Pegunungan'],
                'tickets' => [
                    ['name' => 'Tiket Masuk Reguler (Hari Kerja)', 'price' => 15000, 'benefit' => 'Akses masuk kawasan Telaga Warna dan Telaga Pengilon', 'daily_quota' => 150],
                    ['name' => 'Tiket Masuk Reguler (Akhir Pekan)', 'price' => 22000, 'benefit' => 'Akses masuk kawasan Telaga Warna & Telaga Pengilon di hari Sabtu, Minggu & Libur Nasional', 'daily_quota' => 200],
                    ['name' => 'Tiket Paket Dokumentasi / Prewedding', 'price' => 250000, 'benefit' => 'Izin pemotretan komersial/prewedding untuk kru (maks 5 orang) dan akses semua spot foto', 'daily_quota' => 10],
                    ['name' => 'Tiket Terusan Batu Pandang Ratapan Angin', 'price' => 30000, 'benefit' => 'Akses masuk Telaga Warna dan spot foto Batu Pandang Ratapan Angin dari ketinggian', 'daily_quota' => 100],
                    ['name' => 'Tiket Turis Asing (Foreigner)', 'price' => 100000, 'benefit' => 'Entrance fee to Color Lake & Pengilon Lake, English booklet', 'daily_quota' => 50],
                ]
            ],
            [
                'owner' => [
                    'name' => 'Aditya Wijaya',
                    'username' => 'owner4',
                    'email' => 'ownerwisata4@mail.com',
                ],
                'destination' => [
                    'name' => 'Pulau Karimun Jawa',
                    'description' => 'Kepulauan eksotis di Laut Jawa yang menawarkan keindahan bawah laut luar biasa, pantai pasir putih bersih, hutan bakau lestari, serta penangkaran hiu karang yang mendebarkan.',
                    'address' => 'Kepulauan Karimunjawa',
                    'city' => 'Jepara',
                    'map_link' => 'https://maps.google.com/?q=Karimunjawa+Island',
                    'open_time' => '00:00:00',
                    'close_time' => '23:59:59',
                    'status' => 'active',
                ],
                'tags' => ['Alam', 'Pantai', 'Wahana'],
                'tickets' => [
                    ['name' => 'Tiket Retribusi Masuk Taman Nasional', 'price' => 10000, 'benefit' => 'Biaya retribusi resmi Balai Taman Nasional Karimunjawa', 'daily_quota' => 500],
                    ['name' => 'Tiket Paket Snorkeling 1 Hari (Sharing)', 'price' => 175000, 'benefit' => 'Sewa alat snorkel, pelampung, perahu boat sharing, dokumentasi underwater, makan siang bakar ikan', 'daily_quota' => 100],
                    ['name' => 'Tiket Masuk Penangkaran Hiu (Pulau Menjangan)', 'price' => 30000, 'benefit' => 'Akses kolam hiu, pendampingan pawang, foto bersama hiu di dalam air', 'daily_quota' => 120],
                    ['name' => 'Tiket Paket Diving Pemula (Discovery Scuba)', 'price' => 550000, 'benefit' => 'Instruktur bersertifikasi, 1x dive (maks 45 menit), perlengkapan dive lengkap, snack', 'daily_quota' => 20],
                    ['name' => 'Tiket Island Hopping (Pulau Cemara & Geleang)', 'price' => 120000, 'benefit' => 'Akses kapal penyebrangan antar pulau dan tiket masuk pulau-pulau eksotis', 'daily_quota' => 80],
                    ['name' => 'Tiket Paket Snorkeling Private (Min 4 Orang)', 'price' => 300000, 'benefit' => 'Private boat snorkeling, 2 spot terumbu karang, makan siang seafood premium, pemandu khusus', 'daily_quota' => 15],
                ]
            ],
            [
                'owner' => [
                    'name' => 'Dewi Lestari',
                    'username' => 'owner5',
                    'email' => 'ownerwisata5@mail.com',
                ],
                'destination' => [
                    'name' => 'Lawangsewu',
                    'description' => 'Gedung bersejarah milik PT KAI yang dahulu merupakan kantor pusat NIS. Dikenal dengan arsitektur pintu yang sangat banyak dan megah, jendela kaca patri besar, serta lorong bersejarah.',
                    'address' => 'Jl. Pemuda, Sekayu, Semarang Tengah',
                    'city' => 'Semarang',
                    'map_link' => 'https://maps.google.com/?q=Lawang+Sewu+Semarang',
                    'open_time' => '08:00:00',
                    'close_time' => '20:00:00',
                    'status' => 'active',
                ],
                'tags' => ['Sejarah', 'Budaya', 'Edukasi'],
                'tickets' => [
                    ['name' => 'Tiket Masuk Dewasa', 'price' => 20000, 'benefit' => 'Akses area museum perkeretaapian dan lorong-lorong utama Lawangsewu', 'daily_quota' => 400],
                    ['name' => 'Tiket Masuk Anak / Pelajar', 'price' => 10000, 'benefit' => 'Akses masuk untuk anak-anak dan pelajar (wajib menunjukkan kartu pelajar)', 'daily_quota' => 300],
                    ['name' => 'Tiket Masuk Wisatawan Asing', 'price' => 50000, 'benefit' => 'Entrance ticket for foreign tourists with English brochure', 'daily_quota' => 100],
                    ['name' => 'Tiket Tour Guide Bersejarah (Private)', 'price' => 80000, 'benefit' => 'Jasa pemandu profesional berlisensi untuk menjelaskan sejarah mendalam NIS dan arsitektur bangunan (maks 8 orang)', 'daily_quota' => 40],
                ]
            ],
            [
                'owner' => [
                    'name' => 'Rian Hidayat',
                    'username' => 'owner6',
                    'email' => 'ownerwisata6@mail.com',
                ],
                'destination' => [
                    'name' => 'Baturraden',
                    'description' => 'Lokawisata alam legendaris di lereng selatan Gunung Slamet. Menawarkan udara yang sangat sejuk, kolam renang alami, air terjun Pancuran Pitu, pemandian air panas belerang, dan wahana bermain anak.',
                    'address' => 'Jl. Raya Baturraden, Karangmangu',
                    'city' => 'Banyumas',
                    'map_link' => 'https://maps.google.com/?q=Lokawisata+Baturraden',
                    'open_time' => '07:00:00',
                    'close_time' => '17:00:00',
                    'status' => 'active',
                ],
                'tags' => ['Alam', 'Wahana', 'Pegunungan'],
                'tickets' => [
                    ['name' => 'Tiket Masuk Lokawisata Reguler', 'price' => 25000, 'benefit' => 'Akses masuk kawasan utama, kolam renang, air terjun gumawang, dan area taman', 'daily_quota' => 350],
                    ['name' => 'Tiket Pancuran Pitu & Belerang Hangat', 'price' => 15000, 'benefit' => 'Akses ke area sumber mata air belerang hangat Pancuran Pitu dan terapi kaki belerang', 'daily_quota' => 150],
                    ['name' => 'Tiket Terusan outbound & Sepeda Air', 'price' => 45000, 'benefit' => 'Tiket masuk reguler ditambah free 1x wahana flying fox dan sepeda air di danau buatan', 'daily_quota' => 100],
                    ['name' => 'Tiket Camping Ground Bukit Bintang', 'price' => 35000, 'benefit' => 'Akses bermalam di camping ground, fasilitas toilet umum, dan penjagaan keamanan 24 jam', 'daily_quota' => 80],
                ]
            ],
            [
                'owner' => [
                    'name' => 'Ahmad Fauzi',
                    'username' => 'owner7',
                    'email' => 'ownerwisata7@mail.com',
                ],
                'destination' => [
                    'name' => 'Candi Arjuna',
                    'description' => 'Kompleks candi Hindu tertua di Jawa Tengah yang berasal dari abad ke-8. Terletak di tengah dataran tinggi Dieng yang dingin dan sering diselimuti kabut tipis romantis, menciptakan panorama magis.',
                    'address' => 'Dieng Kulon, Batur',
                    'city' => 'Banjarnegara',
                    'map_link' => 'https://maps.google.com/?q=Kompleks+Candi+Arjuna+Dieng',
                    'open_time' => '07:00:00',
                    'close_time' => '17:00:00',
                    'status' => 'active',
                ],
                'tags' => ['Sejarah', 'Budaya', 'Religi'],
                'tickets' => [
                    ['name' => 'Tiket Reguler Domestik', 'price' => 20000, 'benefit' => 'Akses masuk kompleks candi Arjuna, Candi Semar, Candi Srikandi, Candi Puntadewa, dan Candi Sembadra', 'daily_quota' => 250],
                    ['name' => 'Tiket Masuk Terusan (Candi Arjuna + Sikidang)', 'price' => 35000, 'benefit' => 'Paket hemat masuk Candi Arjuna dan Kawah Sikidang sekaligus', 'daily_quota' => 200],
                    ['name' => 'Tiket Masuk Pelajar / Mahasiswa', 'price' => 15000, 'benefit' => 'Potongan harga tiket masuk dengan menunjukkan kartu pelajar aktif', 'daily_quota' => 150],
                    ['name' => 'Tiket Festival Budaya Dieng (Event Khusus)', 'price' => 150000, 'benefit' => 'Akses khusus saat gelaran Dieng Culture Festival (ruwat rambut gimbal) di area candi', 'daily_quota' => 50],
                ]
            ],
            [
                'owner' => [
                    'name' => 'Indah Permatasari',
                    'username' => 'owner8',
                    'email' => 'ownerwisata8@mail.com',
                ],
                'destination' => [
                    'name' => 'Candi Prambanan',
                    'description' => 'Candi Hindu terbesar di Indonesia yang menjulang setinggi 47 meter. Terkenal dengan arsitektur ramping khas Hindu, relief epos Ramayana, serta legenda Roro Jonggrang yang populer.',
                    'address' => 'Jl. Raya Solo - Yogyakarta No.16, Kranggan, Bokoharjo',
                    'city' => 'Sleman',
                    'map_link' => 'https://maps.google.com/?q=Candi+Prambanan',
                    'open_time' => '06:30:00',
                    'close_time' => '17:30:00',
                    'status' => 'active',
                ],
                'tags' => ['Budaya', 'Sejarah', 'Religi', 'Seni'],
                'tickets' => [
                    ['name' => 'Tiket Masuk Dewasa Domestik', 'price' => 50000, 'benefit' => 'Akses area luar dan pelataran utama candi Prambanan, asuransi, gratis minum', 'daily_quota' => 350],
                    ['name' => 'Tiket Masuk Anak Domestik', 'price' => 25000, 'benefit' => 'Akses pelataran untuk anak usia 3-10 tahun', 'daily_quota' => 200],
                    ['name' => 'Tiket Sendratari Ramayana (Kelas II)', 'price' => 150000, 'benefit' => 'Voucher kursi nonton Sendratari Ramayana Prambanan di panggung terbuka/tertutup kelas II', 'daily_quota' => 100],
                    ['name' => 'Tiket Sendratari Ramayana (VIP)', 'price' => 300000, 'benefit' => 'Kursi eksklusif VIP, softdrink, dan souvenir pertunjukan Ramayana Ballet', 'daily_quota' => 50],
                    ['name' => 'Tiket Wisatawan Mancanegara (Foreigner)', 'price' => 362500, 'benefit' => 'Prambanan temple entrance ticket, English booklet, welcome drink', 'daily_quota' => 100],
                ]
            ],
            [
                'owner' => [
                    'name' => 'Taufik Hidayat',
                    'username' => 'owner9',
                    'email' => 'ownerwisata9@mail.com',
                ],
                'destination' => [
                    'name' => 'Owabong',
                    'description' => 'Owabong Waterpark (Objek Wisata Air Bojongsari) adalah taman rekreasi air terlengkap di Jawa Tengah dengan sumber mata air alami yang segar tanpa kaporit. Menyajikan wahana kolam ombak, slide raksasa, dan terapi ikan.',
                    'address' => 'Jl. Raya Bojongsari, Bojongsari',
                    'city' => 'Purbalingga',
                    'map_link' => 'https://maps.google.com/?q=Owabong+Waterpark',
                    'open_time' => '08:00:00',
                    'close_time' => '16:00:00',
                    'status' => 'active',
                ],
                'tags' => ['Wahana', 'Edukasi', 'Alam'],
                'tickets' => [
                    ['name' => 'Tiket Masuk Weekday (Senin - Jumat)', 'price' => 25000, 'benefit' => 'Akses semua kolam air, kolam ombak, kolam arus, ember tumpah, dan asuransi', 'daily_quota' => 300],
                    ['name' => 'Tiket Masuk Weekend (Sabtu - Minggu)', 'price' => 35000, 'benefit' => 'Akses semua kolam air, event live music weekend, kolam ombak, kolam arus', 'daily_quota' => 400],
                    ['name' => 'Tiket Wahana Gokart & Flying Fox', 'price' => 50000, 'benefit' => 'Akses masuk air + 1x putaran gokart sirkuit Owabong + 1x flying fox', 'daily_quota' => 100],
                    ['name' => 'Tiket VIP Family (Min 4 Tiket)', 'price' => 120000, 'benefit' => 'Paket 4 tiket masuk weekend, gratis sewa 1 gazebo keluarga, gratis sewa ban double', 'daily_quota' => 50],
                ]
            ],
            [
                'owner' => [
                    'name' => 'Sari Wulandari',
                    'username' => 'owner10',
                    'email' => 'ownerwisata10@mail.com',
                ],
                'destination' => [
                    'name' => 'Pantai Menganti',
                    'description' => 'Pantai pasir putih menakjubkan yang dikelilingi oleh perbukitan karst hijau yang menjulang tinggi di pesisir selatan Jawa. Memiliki jembatan merah ikonik, mercusuar bersejarah, dan spot sunset memukau.',
                    'address' => 'Karangduwur, Ayah',
                    'city' => 'Kebumen',
                    'map_link' => 'https://maps.google.com/?q=Pantai+Menganti+Kebumen',
                    'open_time' => '00:00:00',
                    'close_time' => '23:59:59',
                    'status' => 'active',
                ],
                'tags' => ['Alam', 'Pantai', 'Pegunungan'],
                'tickets' => [
                    ['name' => 'Tiket Masuk Gerbang Utama (Termasuk Parkir)', 'price' => 20000, 'benefit' => 'Akses area pantai, asuransi, jasa parkir motor/mobil free, akses jembatan merah', 'daily_quota' => 500],
                    ['name' => 'Tiket Naik Shuttle Angkutan Wisata (PP)', 'price' => 10000, 'benefit' => 'Layanan antar jemput shuttle dari area parkir menuju Tanjung Karang Bata & Bukit Menguneng', 'daily_quota' => 300],
                    ['name' => 'Tiket Camping Bukit Menguneng', 'price' => 40000, 'benefit' => 'Izin mendirikan tenda semalam di bukit, fasilitas kebersihan, pemandangan sunrise samudera', 'daily_quota' => 100],
                    ['name' => 'Tiket Sewa Gazebo Pantai (3 Jam)', 'price' => 30000, 'benefit' => 'Sewa gazebo eksklusif menghadap langsung ke laut lepas selama 3 jam', 'daily_quota' => 80],
                    ['name' => 'Tiket Paket Outbound Pantai (Min 10 Orang)', 'price' => 75000, 'benefit' => 'Makan kelapa muda, tikar lesehan, area outbound khusus, pemandu permainan', 'daily_quota' => 50],
                ]
            ],
        ];

        foreach ($data as $item) {
            // 1. Buat atau update Owner
            $owner = User::updateOrCreate(
                ['email' => $item['owner']['email']],
                [
                    'name' => $item['owner']['name'],
                    'username' => $item['owner']['username'],
                    'phone' => '0812' . rand(10000000, 99999999),
                    'password' => Hash::make('password123'),
                    'tipe_user' => User::TYPE_OWNER,
                    'balance' => 0,
                ]
            );

            // 2. Buat atau update Destinasi Wisata
            $destData = $item['destination'];
            $destData['user_id'] = $owner->id;

            $destination = Destination::updateOrCreate(
                ['name' => $destData['name']],
                $destData
            );

            // 3. Pasang Tag
            $tagIds = [];
            foreach ($item['tags'] as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }
            $destination->tags()->sync($tagIds);

            // 4. Buat Tiket
            foreach ($item['tickets'] as $ticketData) {
                Ticket::updateOrCreate(
                    [
                        'destination_id' => $destination->id,
                        'name' => $ticketData['name'],
                    ],
                    [
                        'price' => $ticketData['price'],
                        'benefit' => $ticketData['benefit'],
                        'daily_quota' => $ticketData['daily_quota'],
                    ]
                );
            }
        }
    }
}
