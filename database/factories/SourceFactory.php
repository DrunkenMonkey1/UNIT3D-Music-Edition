<?php

namespace Database\Factories;

use App\Models\Source;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;


class SourceFactory extends Factory
{
    protected $model = Source::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'slug' => Str::slug($this->faker->word()),
            'icon' => $this->faker->word(),
            'num_torrent' => $this->faker->randomNumber(4),
            'position' => $this->faker->randomNumber(2),
        ];
    }
}
