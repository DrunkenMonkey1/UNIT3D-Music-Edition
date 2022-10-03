<?php


declare(strict_types=1);

namespace App\Services\JioSaavnApi;

use Illuminate\Support\Facades\Http;

use function collect;

class JioSaavnApi
{
    private const API_BASE_URL    =   'https://www.jiosaavn.com/api.php?__call=';
    private const SEARCH_PARAMS = 'autocomplete.get&_format=json&_marker=0&cc=in&includeMetaTags=1&query=';

    private const SONG_DETAILS_PARAMS = 'song.getDetails&cc=in&_marker=0%3F_marker%3D0&_format=json&pids=';

    private const ALBUM_DETAILS_PARAMS = 'content.getAlbumDetails&_format=json&cc=in&_marker=0%3F_marker%3D0&albumid=';

    private const PLAYLIST_DETAILS_PARAMS = 'playlist.getDetails&_format=json&cc=in&_marker=0%3F_marker%3D0&listid=';

    private const  LYRICS_PARAMS = 'lyrics.getLyrics&ctx=web6dot0&api_version=4&_format=json&_marker=0%3F_marker%3D0&lyrics_id=';

    /**
     * @param string $query
     *
     * @return \Illuminate\Support\Collection
     */
    public function search(string $query): \Illuminate\Support\Collection
    {
        return $this->get(self::SEARCH_PARAMS . $query)
            ->map(fn ($item) => $item['data']);
    }

    /**
     * @param string $id
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAlbumDetails(string $id): \Illuminate\Support\Collection
    {
        return $this->get(self::ALBUM_DETAILS_PARAMS . $id);
    }

    /**
     * @param string $id
     *
     * @return \Illuminate\Support\Collection
     */
    public function getSongsDetails(string $id): \Illuminate\Support\Collection
    {
        return $this->get(self::SONG_DETAILS_PARAMS . $id);
    }


    /**
     * @param string $url
     *
     * @return \Illuminate\Support\Collection
     */
    private function get(string $urlParams): \Illuminate\Support\Collection
    {
        $request = Http::get(self::API_BASE_URL . $urlParams);
        return $request->ok()
            ? $request->collect()
            : collect([]);
    }
}
