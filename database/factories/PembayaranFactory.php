<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pembayaran>
 */
class PembayaranFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'reservasi_id' => mt_rand(1, 10),
            'tanggal_pembayaran' => now()->toDateString(),
            'total_pembayaran' => fake()->numberBetween(10000, 1000000),
            'sisa_pembayaran' => fake()->numberBetween(10000, 100000),
            'status_pembayaran' => fake()->randomElement(['Ditunda', 'Gagal', 'Dibayar']),
        ];
    }
}
