<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama'=> $this->faker->name(),
            'nim'=> $this->faker->numerify('#############'),
            'ymd' => $this->faker->optional()->dateTimeBetween('now', '+4 years'),
            // 'user_id' => null
        ];
    }


}
