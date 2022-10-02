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

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use function config;
use function auth;

class TorrentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'type'          => 'torrent',
            'id'            => (string) $this->id,
            'attributes'    => [
                'meta' => [
                    'poster'   => 'https://via.placeholder.com/90x135',
                    'genres'   => 'None',
                ],
                'name'              => $this->name,
                'release_year'      => $this->release_year,
                'category'          => $this->category->name,
                'type'              => $this->type->name,
                'description'       => $this->description,
                'info_hash'         => $this->info_hash,
                'size'              => $this->size,
                'num_file'          => $this->num_file,
                'freeleech'         => $this->free.'%',
                'double_upload'     => $this->doubleup,
                'internal'          => $this->internal,
                'uploader'          => $this->anon ? 'Anonymous' : $this->user->username,
                'seeders'           => $this->seeders,
                'leechers'          => $this->leechers,
                'times_completed'   => $this->times_completed,
                'category_id'       => $this->category_id,
                'type_id'           => $this->type_id,
                'created_at'        => $this->created_at,
                'download_link'     => \route('torrent.download.rsskey', ['id' => $this->id, 'rsskey' => auth('api')->user()->rsskey]),
                'magnet_link'       => $this->when(config('torrent.magnet') === true, 'magnet:?dn='.$this->name.'&xt=urn:btih:'.$this->info_hash.'&as='.route('torrent.download.rsskey', ['id' => $this->id, 'rsskey' => auth('api')->user()->rsskey]).'&tr='.route('announce', ['passkey' => auth('api')->user()->passkey]).'&xl='.$this->size),
                'details_link'      => \route('torrent', ['id' => $this->id]),
            ],
        ];
    }

    /**
     * Customize the outgoing response for the resource.
     */
    public function withResponse($request, $response): void
    {
        $response->setEncodingOptions(JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}
