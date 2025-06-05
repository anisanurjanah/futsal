<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lapangan>
 */
class LapanganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->randomElement(['Lapangan Futsal', 'Lapangan Bulu Tangkis', 'Lapangan Basket']),
            'price' => fake()->numberBetween(10000, 100000),
        ];
    }
}
