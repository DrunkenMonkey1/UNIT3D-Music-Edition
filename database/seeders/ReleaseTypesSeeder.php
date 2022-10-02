<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\ReleaseType;
use Illuminate\Database\Seeder;

class ReleaseTypesSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->getReleaseTypes() as $releaseType) {
            ReleaseType::updateOrCreate($releaseType);
        }
    }

    private function getReleaseTypes(): array
    {
        return [
            [
                'id'       => 1,
                'name'     => 'Album',
                'slug'     => 'album',
                'position' => 0,
            ],
            [
                'id'       => 2,
                'name'     => 'Soundtrack',
                'slug'     => 'soundtrack',
                'position' => 1,
            ],
            [
                'id'       => 3,
                'name'     => 'EP',
                'slug'     => 'ep',
                'position' => 2,
            ],
            [
                'id'       => 4,
                'name'     => 'Anthology',
                'slug'     => 'Anthology',
                'position' => 3,
            ],
            [
                'id'       => 5,
                'name'     => 'Compilation',
                'slug'     => 'compilation',
                'position' => 4,
            ],
            [
                'id'       => 6,
                'name'     => 'Single',
                'slug'     => 'single',
                'position' => 5,
            ],
            [
                'id'       => 7,
                'name'     => 'Live album',
                'slug'     => 'live-album',
                'position' => 7,
            ],
            [
                'id'       => 8,
                'name'     => 'Remix',
                'slug'     => 'remix',
                'position' => 7,
            ],
            [
                'id'       => 9,
                'name'     => 'Bootleg',
                'slug'     => 'bootleg',
                'position' => 8,
            ],
            [
                'id'       => 10,
                'name'     => 'interview',
                'slug'     => 'interview',
                'position' => 9,
            ],
            [
                'id'       => 11,
                'name'     => 'Mixtape',
                'slug'     => 'mixtape',
                'position' => 10,
            ],
            [
                'id'       => 12,
                'name'     => 'DJ Mix',
                'slug'     => 'dj-mix',
                'position' => 11,
            ],
            [
                'id'       => 13,
                'name'     => 'Concert Recording',
                'slug'     => 'concert-recording',
                'position' => 12,
            ],
            [
                'id'       => 14,
                'name'     => 'Unknown',
                'slug'     => 'unknown',
                'position' => 13,
            ],
        ];
    }
}
