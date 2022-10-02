<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Bitrate;
use Illuminate\Database\Seeder;

class BitrateSeeder extends Seeder
{
    public function run()
    {
        foreach ($this->getBitrates() as $bitrate) {
            Bitrate::updateOrCreate($bitrate);
        }
    }

    private function getBitrates(): array
    {
        return [
            [
                'id'       => 1,
                'name'     => '16bit Lossless',
                'slug'     => '16bit-lossless',
                'position' => 0,
            ],
            [
                'id'       => 2,
                'name'     => '24bit Lossless',
                'slug'     => '24bit-lossless',
                'position' => 1,
            ],
            [
                'id'       => 3,
                'name'     => 'AAC (@ CBR 320kbps)',
                'slug'     => 'aac-cbr-320kbps',
                'position' => 2,
            ],
            [
                'id'       => 4,
                'name'     => 'AAC (@ VBR 320kbps)',
                'slug'     => 'aac-vbr-320kbps',
                'position' => 3,
            ], [
                'id'       => 5,
                'name'     => 'Other',
                'slug'     => 'other',
                'position' => 4,
            ],
        ];
    }
}
