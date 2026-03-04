<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Bus;
use App\Models\Promo;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Admin BusGo',
            'email'    => 'admin@busgo.id',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // User biasa
        User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'budi@email.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
        ]);

        // Bus
        $buses = [
            [
                'nama'          => 'Sinar Jaya Eksekutif',
                'plat'          => 'B 1234 SJ',
                'asal'          => 'Jakarta',
                'tujuan'        => 'Bandung',
                'jam_berangkat' => '07:00',
                'harga'         => 150000,
                'kapasitas'     => 40,
                'tipe'          => 'Eksekutif',
                'fasilitas'     => 'AC, WiFi, Toilet, Snack',
                'deskripsi'     => 'Bus eksekutif nyaman dengan kursi reclining 2-2.',
                'promo'         => 'HEMAT15%',
                'status'        => 'Aktif',
            ],
            [
                'nama'          => 'Rosalia Indah Super',
                'plat'          => 'AD 5678 RI',
                'asal'          => 'Yogyakarta',
                'tujuan'        => 'Semarang',
                'jam_berangkat' => '09:00',
                'harga'         => 85000,
                'kapasitas'     => 44,
                'tipe'          => 'Ekonomi',
                'fasilitas'     => 'AC, Musik',
                'deskripsi'     => 'Bus ekonomi terpercaya rute Yogyakarta-Semarang.',
                'promo'         => null,
                'status'        => 'Aktif',
            ],
            [
                'nama'          => 'Pahala Kencana Sleeper',
                'plat'          => 'L 9012 PK',
                'asal'          => 'Surabaya',
                'tujuan'        => 'Malang',
                'jam_berangkat' => '22:00',
                'harga'         => 200000,
                'kapasitas'     => 24,
                'tipe'          => 'Sleeper',
                'fasilitas'     => 'AC, Sleeper Bed, Makan, WiFi, TV',
                'deskripsi'     => 'Bus sleeper mewah untuk perjalanan malam.',
                'promo'         => 'MALAM30%',
                'status'        => 'Aktif',
            ],
            [
                'nama'          => 'Damri Premium',
                'plat'          => 'B 3456 DM',
                'asal'          => 'Jakarta',
                'tujuan'        => 'Bandung',
                'jam_berangkat' => '14:00',
                'harga'         => 120000,
                'kapasitas'     => 36,
                'tipe'          => 'Eksekutif',
                'fasilitas'     => 'AC, WiFi, USB Charger',
                'deskripsi'     => 'Bus premium armada terbaru pengemudi berpengalaman.',
                'promo'         => null,
                'status'        => 'Aktif',
            ],
        ];

        foreach ($buses as $bus) {
            Bus::create($bus);
        }

        // Promo
        Promo::create([
            'nama'           => 'Flash Sale Akhir Tahun',
            'kode'           => 'AKHIRTAHUN',
            'diskon'         => 30,
            'berlaku_hingga' => '2026-12-31',
            'deskripsi'      => 'Diskon spesial akhir tahun untuk semua rute!',
            'status'         => 'Aktif',
        ]);

        Promo::create([
            'nama'           => 'Promo Lebaran',
            'kode'           => 'LEBARAN26',
            'diskon'         => 15,
            'berlaku_hingga' => '2026-04-10',
            'deskripsi'      => 'Sambut mudik dengan harga spesial.',
            'status'         => 'Aktif',
        ]);
    }
}