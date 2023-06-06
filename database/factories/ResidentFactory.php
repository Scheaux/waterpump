<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ResidentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fio' => fake()->name(),
            'area' => fake()->randomFloat(2, 3, 25),
            'start_date' => fake()->dateTimeThisYear()->getTimestamp(),
        ];
    }
}
