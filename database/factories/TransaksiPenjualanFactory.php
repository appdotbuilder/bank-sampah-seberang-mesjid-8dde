<?php

namespace Database\Factories;

use App\Models\JenisSampah;
use App\Models\Pengepul;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransaksiPenjualan>
 */
class TransaksiPenjualanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $beratKg = fake()->randomFloat(2, 1, 50);
        $hargaPerKg = fake()->randomFloat(2, 1000, 7000);
        $nilaiJual = $beratKg * $hargaPerKg;
        $keuntungan = fake()->randomFloat(2, 100, 1000);

        return [
            'pengepul_id' => Pengepul::factory(),
            'jenis_sampah_id' => JenisSampah::factory(),
            'berat_kg' => $beratKg,
            'harga_per_kg' => $hargaPerKg,
            'nilai_jual' => $nilaiJual,
            'keuntungan' => $keuntungan,
        ];
    }
}