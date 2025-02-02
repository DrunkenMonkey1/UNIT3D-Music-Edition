<?php

/* @var \Illuminate\Database\Eloquent\Factory $factory */

namespace Database\Factories;

use App\Models\Category;
use App\Models\Torrent;
use App\Models\Type;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TorrentRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name'               => $this->faker->name(),
            'category_id'        => fn () => Category::factory()->create()->id,
            'type_id'            => fn () => Type::factory()->create()->id,
            'description'        => $this->faker->text(),
            'user_id'            => fn () => User::factory()->create()->id,
            'bounty'             => $this->faker->randomFloat(),
            'votes'              => $this->faker->randomNumber(),
            'claimed'            => $this->faker->boolean(),
            'anon'               => $this->faker->boolean(),
            'filled_by'          => fn () => User::factory()->create()->id,
            'filled_hash'        => fn () => Torrent::factory()->create()->id,
            'filled_when'        => $this->faker->dateTime(),
            'filled_anon'        => $this->faker->boolean(),
            'approved_by'        => fn () => User::factory()->create()->id,
            'approved_when'      => $this->faker->dateTime(),
        ];
    }
}
