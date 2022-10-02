<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Format;
use Illuminate\Database\Seeder;

class FormatsTableSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->getFormats() as $format) {
            Format::updateOrCreate($format);
        }
    }

    private function getFormats(): array
    {
        return [
            [
                'id'       => 1,
                'name'     => 'FLAC',
                'slug'     => 'flac',
                'position' => 0,
            ],
            [
                'id'       => 2,
                'name'     => 'DVD',
                'slug'     => 'dvd',
                'position' => 1,
            ],
            [
                'id'       => 3,
                'name'     => 'Vinyl',
                'slug'     => 'vinyl',
                'position' => 2,
            ],
            [
                'id'       => 4,
                'name'     => 'Blu-Ray',
                'slug'     => 'blu-ray',
                'position' => 4,
            ],
            [
                'id'       => 5,
                'name'     => 'Soundboard',
                'slug'     => 'soundboard',
                'position' => 5,
            ],
            [
                'id'       => 6,
                'name'     => 'SACD',
                'slug'     => 'sacd',
                'position' => 6,
            ],
            [
                'id'       => 7,
                'name'     => 'DAT',
                'slug'     => 'dat',
                'position' => 7,
            ],
            [
                'id'       => 8,
                'name'     => 'Cassette',
                'slug'     => 'cassette',
                'position' => 8,
            ],
            [
                'id'       => 9,
                'name'     => 'Web',
                'slug'     => 'web',
                'position' => 9,
            ],
        ];
    }
}
