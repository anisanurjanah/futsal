<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PembayaranDetail>
 */
class PembayaranDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'pembayaran_id' => mt_rand(1, 10),
            'tanggal_pembayaran' => now()->toDateString(),
            'jumlah_pembayaran' => fake()->numberBetween(10000, 1000000),
            'metode_pembayaran' => fake()->randomElement(['Bank Transfer', 'E-Wallet', 'Kartu Kredit']),
        ];
    }
}
