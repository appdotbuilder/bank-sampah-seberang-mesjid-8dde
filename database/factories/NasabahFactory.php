<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Nasabah>
 */
class NasabahFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'nik_nip' => fake()->unique()->numerify('################'),
            'alamat' => fake()->address(),
            'instansi' => fake()->optional()->company(),
            'saldo_total' => fake()->randomFloat(2, 0, 1000000),
            'saldo_dapat_ditarik' => fake()->randomFloat(2, 0, 500000),
        ];
    }
}