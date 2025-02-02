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

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;

use function config;
use function json_decode;
use function response;
use function version_compare;

/**
 * @see \Tests\Todo\Feature\Http\Controllers\Staff\VersionControllerTest
 */
class VersionController extends Controller
{
    private readonly mixed $versionController;

    public function __construct()
    {
        $this->versionController = config('unit3d.version');
    }

    /**
     * Check the latest release of UNIT3D and compare them to the local version.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    public function checkVersion(): \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
    {
        $client         = new Client();
        $response       = json_decode((string) $client->get('//api.github.com/repos/HDInnovations/UNIT3D/releases')->getBody(), true, 512, JSON_THROW_ON_ERROR);
        $lastestVersion = $response[0]['tag_name'];

        return response([
            'updated'       => ! version_compare($this->versionController, $lastestVersion, '<'),
            'latestversion' => $lastestVersion,
        ]);
    }
}
