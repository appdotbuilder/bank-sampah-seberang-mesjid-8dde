<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pengepul>
 */
class PengepulFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $collectorNames = [
            'CV. Cahaya Recycling',
            'UD. Bersama Jaya',
            'PT. Hijau Mandiri',
            'CV. Sampah Bersih',
            'UD. Daur Ulang Sejahtera',
            'PT. Eco Green Indonesia',
            'CV. Plastik Nusantara',
            'UD. Kertas Baru',
            'PT. Metal Recycling',
            'CV. Bumi Lestari'
        ];

        return [
            'nama' => fake()->unique()->randomElement($collectorNames),
            'alamat' => fake()->address() . ', ' . fake()->city(),
        ];
    }
}