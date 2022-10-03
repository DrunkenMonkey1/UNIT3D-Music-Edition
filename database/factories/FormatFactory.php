<?php

namespace Database\Factories;

use App\Models\Format;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class FormatFactory extends Factory
{
    protected $model = Format::class;

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
