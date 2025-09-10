<?php

namespace Database\Seeders;

use App\Models\JenisSampah;
use App\Models\Nasabah;
use App\Models\Pengepul;
use App\Models\TransaksiSetoran;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BankSampahSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin Bank Sampah',
            'email' => 'admin@banksampah.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create sample nasabah users
        $nasabahData = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'nik_nip' => '1234567890123456',
            ],
            [
                'name' => 'Siti Aminah',
                'email' => 'siti@example.com',
                'nik_nip' => '1234567890123457',
            ],
            [
                'name' => 'Ahmad Wijaya',
                'email' => 'ahmad@example.com',
                'nik_nip' => '1234567890123458',
            ],
        ];

        foreach ($nasabahData as $data) {
            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'role' => 'nasabah',
                'nik_nip' => $data['nik_nip'],
                'email_verified_at' => now(),
            ]);
        }

        // Create jenis sampah
        JenisSampah::factory(15)->create();

        // Create nasabah
        $nasabahUsers = User::where('role', 'nasabah')->get();
        foreach ($nasabahUsers as $user) {
            Nasabah::create([
                'nama' => $user->name,
                'nik_nip' => $user->nik_nip,
                'alamat' => fake()->address(),
                'instansi' => fake()->optional()->company(),
                'saldo_total' => 0,
                'saldo_dapat_ditarik' => 0,
            ]);
        }

        // Add more nasabah without user accounts
        Nasabah::factory(20)->create();

        // Create pengepul
        Pengepul::factory(8)->create();

        // Create some sample transactions
        $nasabahList = Nasabah::all();
        $jenisSampahList = JenisSampah::all();

        // Create setoran transactions
        foreach ($nasabahList->take(10) as $nasabah) {
            for ($i = 0; $i < random_int(1, 5); $i++) {
                $jenisSampah = $jenisSampahList->random();
                $beratKg = fake()->randomFloat(2, 0.5, 20);
                $nilaiSetoran = $beratKg * $jenisSampah->harga_beli;

                TransaksiSetoran::create([
                    'nasabah_id' => $nasabah->id,
                    'jenis_sampah_id' => $jenisSampah->id,
                    'berat_kg' => $beratKg,
                    'harga_per_kg' => $jenisSampah->harga_beli,
                    'nilai_setoran' => $nilaiSetoran,
                    'sudah_dijual' => fake()->boolean(30), // 30% chance already sold
                    'created_at' => fake()->dateTimeBetween('-3 months', 'now'),
                ]);

                // Update nasabah saldo
                $nasabah->increment('saldo_total', $nilaiSetoran);
                
                // Update stock
                $jenisSampah->increment('stok_kg', $beratKg);
            }
        }
    }
}