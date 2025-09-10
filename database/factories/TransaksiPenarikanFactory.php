<?php

namespace Database\Factories;

use App\Models\Nasabah;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransaksiPenarikan>
 */
class TransaksiPenarikanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nasabah_id' => Nasabah::factory(),
            'jumlah_penarikan' => fake()->randomFloat(2, 50000, 500000),
            'status' => fake()->randomElement(['pending', 'approved', 'rejected']),
            'keterangan' => fake()->optional()->sentence(),
        ];
    }
}