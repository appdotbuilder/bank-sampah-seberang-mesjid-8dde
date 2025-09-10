<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JenisSampah>
 */
class JenisSampahFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $wasteTypes = [
            'Botol Plastik PET',
            'Kertas Putih (HVS)',
            'Kardus Bekas',
            'Kaleng Aluminium',
            'Besi Tua',
            'Kaca Bening',
            'Plastik PP',
            'Kertas Koran',
            'Duplex/Karton',
            'Tembaga',
            'Kuningan',
            'Botol Kaca',
            'Plastik HDPE',
            'Kertas Campuran',
            'Seng/Aluminium Tebal'
        ];

        $wasteType = fake()->unique()->randomElement($wasteTypes);
        $hargaBeli = fake()->randomFloat(2, 500, 5000);
        $hargaJual = $hargaBeli + fake()->randomFloat(2, 200, 2000); // Margin profit

        return [
            'jenis_sampah' => $wasteType,
            'harga_beli' => $hargaBeli,
            'harga_jual' => $hargaJual,
            'stok_kg' => fake()->randomFloat(2, 0, 500),
        ];
    }
}