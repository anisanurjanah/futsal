<?php

namespace Database\Factories;

use Illuminate\Support\Carbon;
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
        $baseTime = Carbon::now()->addDays(mt_rand(0, 5));
        $startTime = clone $baseTime;
        $startTime->addHours(mt_rand(1, 5));

        $endTime = clone $startTime;
        $endTime->addHours(mt_rand(1, 2));

        return [
            'pelanggan_id' => mt_rand(1, 10),
            'lapangan_id' => mt_rand(1, 3),
            'tanggal' => $startTime->toDateString(),
            'waktu_mulai' => $startTime->toTimeString(),
            'waktu_selesai' => $endTime->toTimeString(),
            'status' => fake()->randomElement(['Ditunda', 'Dibatalkan', 'Selesai', 'Berlangsung']),
        ];
    }
}
