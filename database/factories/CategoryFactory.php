<?php

/* @var \Illuminate\Database\Eloquent\Factory $factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name'        => $this->faker->name(),
            'slug'        => $this->faker->slug(),
            'image'       => $this->faker->word(),
            'position'    => $this->faker->randomNumber(),
            'icon'        => $this->faker->word(),
            'num_torrent' => $this->faker->randomNumber(),
        ];
    }
}
