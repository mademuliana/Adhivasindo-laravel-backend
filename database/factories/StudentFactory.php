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
            'name'=> $this->faker->name(),
            'nim'=> $this->faker->numerify('#############'),
            'faculty'=> $this->faker->randomElement(['FIT', 'FIK', 'FIP']),
            'major'=> $this->faker->randomElement(['computer science', 'doctorate', 'farming technology']),
            'registered_date' => $this->faker->dateTimeBetween('-4 years', 'now'),
            'graduation_date' => $this->faker->optional()->dateTimeBetween('now', '+4 years'),
            'user_id' => null
        ];
    }


}
