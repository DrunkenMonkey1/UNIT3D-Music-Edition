<?php
/**
 * NOTICE OF LICENSE.
 *
 * UNIT3D Community Edition is open-sourced software licensed under the GNU Affero General Public License v3.0
 * The details is bundled with this project in the file LICENSE.txt.
 *
 * @project    UNIT3D Community Edition
 *
 * @author     HDVinnie <hdinnovations@protonmail.com>
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html/ GNU Affero General Public License v3.0
 */

namespace Database\Seeders;

use App\Models\Source;
use Illuminate\Database\Seeder;

class SourcesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        foreach ($this->getSources() as $type) {
            Source::updateOrCreate($type);
        }
    }

    private function getSources(): array
    {
        return [
            [
                'id'       => 1,
                'name'     => 'CD',
                'slug'     => 'cd',
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
