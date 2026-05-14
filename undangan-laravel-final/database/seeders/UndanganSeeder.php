<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UndanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Pengaturan::create([
            'judul_undangan' => 'Undangan Pernikahan',
            'pengantar'      => 'Tanpa mengurangi rasa hormat, kami mengundang Bapak/Ibu/Saudara/i untuk hadir di acara pernikahan kami.',
            'dress_code'     => 'Pastel — Nude — Earthy Tone',
            'maps_link'      => 'https://maps.google.com/?q=Universitas+Riau',
            'maps_embed'     => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3288.369402747278!2d101.37807147396548!3d0.4763830637627744!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5aea1f427ab57:0x74d49c35acbd10e1!2sUniversitas%20Riau!5e1!3m2!1sid!2sid!4v1772437642959!5m2!1sid!2sid',
        ]);

        \App\Models\Mempelai::insert([
            [
                'tipe'           => 'pria',
                'nama_lengkap'   => 'Muhammad Fikry Efendi',
                'nama_panggilan' => 'Fikry',
                'nama_ayah'      => 'Bapak Harry',
                'nama_ibu'       => 'Ibu Ginny',
                'status_keluarga'=> 'Putra pertama dari',
                'foto'           => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'tipe'           => 'wanita',
                'nama_lengkap'   => 'Bulan Hijarati A',
                'nama_panggilan' => 'Bulan',
                'nama_ayah'      => 'Bapak Ron',
                'nama_ibu'       => 'Ibu Hermione',
                'status_keluarga'=> 'Putri pertama dari',
                'foto'           => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]
        ]);

        \App\Models\Acara::insert([
            [
                'nama_acara'   => 'Akad Nikah',
                'tanggal'      => '2027-02-14',
                'jam_mulai'    => '08:00',
                'jam_selesai'  => null,
                'nama_venue'   => 'Universitas Riau',
                'alamat_venue' => 'Kampus Bina Widya, Jl. Bangau Sakti KM. 12,5<br>Simpang Baru, Kec. Tampan, Kota Pekanbaru, Riau 28293',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'nama_acara'   => 'Resepsi',
                'tanggal'      => '2027-02-14',
                'jam_mulai'    => '11:00',
                'jam_selesai'  => 'Selesai',
                'nama_venue'   => 'Universitas Riau',
                'alamat_venue' => 'Kampus Bina Widya, Jl. Bangau Sakti KM. 12,5<br>Simpang Baru, Kec. Tampan, Kota Pekanbaru, Riau 28293',
                'created_at'   => now(),
                'updated_at'   => now(),
            ]
        ]);

        \App\Models\Cerita::insert([
            ['tahun' => '2019', 'judul' => 'Pertemuan Pertama',  'isi' => 'Takdir mempertemukan kami di kampus Universitas Riau. Sebuah senyum sederhana menjadi awal dari segalanya.', 'warna' => null, 'created_at' => now(), 'updated_at' => now()],
            ['tahun' => '2020', 'judul' => 'Semakin Dekat',      'isi' => 'Di tengah pandemi yang mengunci dunia, justru kedekatan kami semakin tak terbendung.', 'warna' => null, 'created_at' => now(), 'updated_at' => now()],
            ['tahun' => '2022', 'judul' => 'Menjalin Hubungan',  'isi' => 'Dengan bismillah dan doa restu keluarga, kami resmi memulai hubungan.', 'warna' => null, 'created_at' => now(), 'updated_at' => now()],
            ['tahun' => '2027', 'judul' => 'Menuju Pelaminan ✦','isi' => 'Setelah perjalanan panjang yang indah, kami siap melangkah ke babak baru.', 'warna' => 'rose', 'created_at' => now(), 'updated_at' => now()],
        ]);
        
        \App\Models\Galeri::insert([
            ['path_foto' => 'images/gallery-1.jpg', 'caption' => null, 'created_at' => now(), 'updated_at' => now()],
            ['path_foto' => 'images/gallery-2.jpg', 'caption' => null, 'created_at' => now(), 'updated_at' => now()],
            ['path_foto' => 'images/gallery-3.jpg', 'caption' => null, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
