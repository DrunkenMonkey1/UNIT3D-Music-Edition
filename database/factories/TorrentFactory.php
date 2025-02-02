<?php

/* @var \Illuminate\Database\Eloquent\Factory $factory */

namespace Database\Factories;

use App\Models\Bitrate;
use App\Models\Category;
use App\Models\Format;
use App\Models\ReleaseType;
use App\Models\Source;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

use function random_int;
use function count;
use function now;

class TorrentFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $freeleech = ['0', '25', '50', '75', '100'];
        $selected  = random_int(0, count($freeleech) - 1);

        return [
            'name'               => $this->faker->name(),
            'slug'               => $this->faker->slug(),
            'description'        => $this->faker->text(),
            'info_hash'          => $this->faker->word(),
            'file_name'          => $this->faker->word(),
            'num_file'           => $this->faker->randomNumber(),
            'size'               => $this->faker->randomFloat(),
            'nfo'                => $this->faker->text(),
            'leechers'           => $this->faker->randomNumber(),
            'seeders'            => $this->faker->randomNumber(),
            'times_completed'    => $this->faker->randomNumber(),
            'category_id'        => fn () => Category::factory()->create()->id,
            'announce'           => $this->faker->word(),
            'user_id'            => fn () => User::factory()->create()->id,
            'source_id'          => fn () => Source::factory()->create()->id,
            'format_id'          => fn () => Format::factory()->create()->id,
            'release_type_id'    => fn () => ReleaseType::factory()->create()->id,
            'bitrate_id'         => fn () => Bitrate::factory()->create()->id,
            'stream'             => $this->faker->boolean(),
            'free'               => $freeleech[$selected],
            'doubleup'           => $this->faker->boolean(),
            'highspeed'          => $this->faker->boolean(),
            'featured'           => false,
            'status'             => 1,
            'moderated_at'       => now(),
            'moderated_by'       => 1,
            'anon'               => $this->faker->boolean(),
            'sticky'             => $this->faker->boolean(),
            'internal'           => $this->faker->boolean(),
            'release_year'       => $this->faker->date('Y'),
        ];
    }
}
