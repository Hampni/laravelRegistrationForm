<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'birthday' => $this->faker->date(),
            'report_subject' => $this->faker->sentence(3),
            'country' => $this->faker->country(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'company' => $this->faker->company(),
            'position' => $this->faker->word(),
            'about_me' => $this->faker->sentence(5),
            'photo' => 'default.png',
            'is_shown' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
