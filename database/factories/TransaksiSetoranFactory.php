<?php

namespace Database\Factories;

use App\Models\JenisSampah;
use App\Models\Nasabah;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransaksiSetoran>
 */
class TransaksiSetoranFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $beratKg = fake()->randomFloat(2, 0.5, 20);
        $hargaPerKg = fake()->randomFloat(2, 500, 5000);
        $nilaiSetoran = $beratKg * $hargaPerKg;

        return [
            'nasabah_id' => Nasabah::factory(),
            'jenis_sampah_id' => JenisSampah::factory(),
            'berat_kg' => $beratKg,
            'harga_per_kg' => $hargaPerKg,
            'nilai_setoran' => $nilaiSetoran,
            'sudah_dijual' => fake()->boolean(20),
        ];
    }
}