<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservasi>
 */
class ReservasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'pelanggan_id' => mt_rand(1, 10),
            'lapangan_id' => mt_rand(1, 10),
            'tanggal' => now()->toDateString(),
            'waktu_mulai' => now()->addHours(mt_rand(1, 5))->toTimeString(),
            'waktu_selesai' => now()->addHours(mt_rand(1, 5))->toTimeString(),
            'status' => fake()->randomElement(['Ditunda', 'Dibatalkan', 'Selesai', 'Berlangsung']),
        ];
    }
}
