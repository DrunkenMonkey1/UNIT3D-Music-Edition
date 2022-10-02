<?php

declare(strict_types=1);

namespace App\Services\DiscogsApi;

use App\Exceptions\DiscogsApiException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * @author JolitaGrazyte <https://github.com/JolitaGrazyte>
 */
class DiscogsApi
{
    protected string $baseUrl = 'https://api.discogs.com';

    public function __construct(protected Client $client, protected ?string $token = null, protected ?string $userAgent = null)
    {
    }

    /**
     * @param string $id
     * @return mixed
     * @throws GuzzleException
     */
    public function artist(string $id): mixed
    {
        return $this->get('artists', $id);
    }

    /**
     * @param string $artistId
     * @return mixed
     * @throws GuzzleException
     */
    public function artistReleases(string $artistId): mixed
    {
        return $this->get("artists/{$artistId}/releases");
    }

    /**
     * @param string $id
     * @return mixed
     * @throws GuzzleException
     */
    public function label(string $id): mixed
    {
        return $this->get('labels', $id);
    }

    /**
     * @param string $labelId
     * @return mixed
     * @throws GuzzleException
     */
    public function labelReleases(string $labelId): mixed
    {
        return $this->get("labels/{$labelId}/releases");
    }

    /**
     * @param string $id
     * @return mixed
     * @throws GuzzleException
     */
    public function release(string $id): mixed
    {
        return $this->get('releases', $id);
    }

    /**
     * @param string $id
     * @return mixed
     * @throws GuzzleException
     */
    public function masterRelease(string $id): mixed
    {
        return $this->get('masters', $id);
    }

    /**
     * @param string $userName
     * @return mixed
     * @throws GuzzleException
     */
    public function userCollection(string $userName): mixed
    {
        return $this->get("/users/{$userName}/collection/folders");
    }

    /**
     * @param string $id
     * @return mixed
     * @throws GuzzleException
     */
    public function getMarketplaceListing(string $id): mixed
    {
        return $this->get("/marketplace/listings/{$id}");
    }

    /**
     * @param string $userName
     * @return mixed
     */
    public function getMyInventory(string $userName): mixed
    {
        return $this->getAuthenticated("users/{$userName}/inventory");
//        return $this->get("users/{$userName}/inventory", '', [], true);
    }

    /**
     * @param string $listingId
     * @return \Psr\Http\Message\ResponseInterface
     * @throws DiscogsApiException
     * @throws GuzzleException
     */
    public function deleteListing(string $listingId): \Psr\Http\Message\ResponseInterface
    {
        return $this->delete('marketplace/listings/', $listingId);
    }

    /**
     * @return mixed
     * @throws GuzzleException
     */
    public function requestInventoryExport(): mixed
    {
        return $this->post('inventory/export');
    }

    /**
     * @return mixed
     * @throws GuzzleException
     */
    public function addInventory(): mixed
    {
        $file = 'file.csv'; // get CSV file
        return $this->post('inventory/upload/add', '', ['upload' => $file]);
    }

    /**
     * @return mixed
     * @throws GuzzleException
     */
    public function deleteInventory()
    {
        return $this->post('inventory/upload/delete');
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function orderWithId(string $id): mixed
    {
//        return $this->get("marketplace/orders/{$id}", '', [], true);
        return $this->getAuthenticated("marketplace/orders/{$id}");
    }

    /**
     * @param string $orderId
     * @return mixed
     */
    public function orderMessages(string $orderId): mixed
    {
//        return $this->get("marketplace/orders/{$orderId}/messages", '', [], true);
        return $this->getAuthenticated("marketplace/orders/{$orderId}/messages");
    }

    /**
     * @param int|null $page
     * @param int|null $perPage
     * @param string|null $status
     * @param string|null $sort
     * @param string|null $sortOrder
     * @return mixed
     */
    public function getMyOrders(int $page = null, int $perPage = null, string $status = null, string $sort = null, string $sortOrder = null): mixed
    {
        $query = [
            'page'       => $page      ?? 1,
            'per_page'   => $perPage   ?? 50,
            'status'     => $status    ?? 'All',
            'sort'       => $sort      ?? 'id',
            'sort_order' => $sortOrder ?? 'desc',
        ];

//        return $this->get('marketplace/orders', '', $query, true);
        return $this->getAuthenticated('marketplace/orders', '', $query);
    }

    /**
     * @param string $orderId
     * @param string $status
     * @return \Psr\Http\Message\ResponseInterface
     * @throws DiscogsApiException
     * @throws GuzzleException
     */
    public function changeOrderStatus(string $orderId, string $status): \Psr\Http\Message\ResponseInterface
    {
        return $this->changeOrder($orderId, 'status', $status);
    }

    public function addShipping($orderId, string $shipping)
    {
        return $this->changeOrder($orderId, 'shipping', $shipping);
    }

    /**
     * @param string $keyword
     * @param SearchParameters|null $searchParameters
     * @return mixed
     * @throws GuzzleException
     */
    public function search(string $keyword, SearchParameters $searchParameters = null): mixed
    {
        $query = [
            'q' => $keyword,
        ];

        if (!is_null($searchParameters)) {
            $query = collect($query)->merge($searchParameters->get())->toArray();
        }

        return $this->get('database/search', '', $query, true);
    }

    /**
     * @param string $resource
     * @param string $id
     * @param array $query
     * @return mixed
     * @throws GuzzleException
     */
    protected function getAuthenticated(string $resource, string $id = '', array $query = [])
    {
        return $this->get($resource, $id, $query, true);
    }

    /**
     * @param string $resource
     * @param string $id
     * @param array $query
     * @param bool $mustAuthenticate
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(string $resource, string $id = '', array $query = [], bool $mustAuthenticate = false): mixed
    {
        $content = $this->client
            ->get(
                $this->url($this->path($resource, $id)),
                $this->parameters($query, $mustAuthenticate)
            )->getBody()
            ->getContents();

        return json_decode($content);
    }

    /**
     * @param string $resource
     * @param string $id
     * @param array $query
     * @param bool $mustAuthenticate
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post(string $resource, string $id = '', array $query = [], bool $mustAuthenticate = false)
    {
        $content = $this->client
            ->post(
                $this->url($this->path($resource, $id)),
                $this->parameters($query, $mustAuthenticate)
            )->getBody()
            ->getContents();

        return json_decode($content);
    }

    /**
     * @param string $orderId
     * @param string $key
     * @param string $value
     * @return \Psr\Http\Message\ResponseInterface
     * @throws DiscogsApiException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function changeOrder(string $orderId, string $key, string $value)
    {
        $resource = 'marketplace/orders/';

        return $this->client
            ->post(
                $this->url($this->path($resource, $orderId)),
                ['query' => [
                    $key    => $value,
                    'token' => $this->token(),
                ],
                ]
            );
    }

    /**
     * @param string $resource
     * @param string $listingId
     * @return \Psr\Http\Message\ResponseInterface
     * @throws DiscogsApiException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function delete(string $resource, string $listingId)
    {
        return $this->client
            ->delete(
                $this->url($this->path($resource, $listingId)),
                ['query' => ['token' => $this->token()]]
            );
    }

    /**
     * @param array $query
     * @param bool $mustAuthenticate
     * @return array
     * @throws DiscogsApiException
     */
    protected function parameters(array $query, bool $mustAuthenticate): array
    {
        if ($mustAuthenticate) {
            $query['token'] = $this->token();
        }

        return [
            'stream'  => true,
            'headers' => ['User-Agent' => $this->userAgent ?: null],
            'query'   => $query,
        ];
    }

    /**
     * @return string|null
     * @throws DiscogsApiException
     */
    protected function token()
    {
        if (!is_null($this->token)) {
            return $this->token;
        }

        throw DiscogsApiException::tokenRequiredException();
    }

    /**
     * @param string $path
     * @return string
     */
    protected function url(string $path): string
    {
        return "{$this->baseUrl}/{$path}";
    }

    /**
     * @param string $resource
     * @param string $id
     * @return string
     */
    protected function path(string $resource, string $id = ''): string
    {
        if (empty($id)) {
            return $resource;
        }

        return "{$resource}/{$id}";
    }
}
