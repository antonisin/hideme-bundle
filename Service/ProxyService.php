<?php

namespace Antonisin\HideMeBundle\Service;

use Antonisin\HideMeBundle\Model\ProxyModel;
use GuzzleHttp\Client;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Request;

/**
 * ProxyService
 * This class is designed to work with hideMe api service. Also this class is used as service to store, get, save and
 * return proxies. This class contain all needed methods to process proxy.
 * @author Maxim Antonisin <maxim.antonisin@gmail.com>
 *
 * @version 1.0.0
 */
class ProxyService implements ProxyServiceInterface
{
    /**
     * This property contain cache item.
     * Cache item store an loaded list of proxies.
     * @var FilesystemAdapter
     */
    private $cache;

    /**
     * Api url.
     * This property contain api url to work with hideMe remove service.
     * @var string
     */
    private $apiUrl;

    /**
     * Api Key.
     * This property contain api key to auth on the hideMe remove service api.
     * @var string
     */
    private $apiKey;

    /**
     * Filters array.
     * This property store the filters array. Filter describe the params used to filter the response proxy list.
     * @var array
     */
    private $filters;

    /**
     * {@inheritdoc}
     */
    public function __construct(string $url, string $key, array $filters = [])
    {
        $this->cache   = new FilesystemAdapter();
        $this->apiUrl  = $url;
        $this->apiKey  = $key;
        $this->filters = $filters;
    }

    /**
     * {@inheritdoc}
     */
    public function load():array
    {
        $params = [
            'query' => array_merge($this->encodeFilters(), [
                'code' => $this->apiKey,
            ]),
        ];

        $client = new Client(['base_uri' => $this->apiUrl]);

        $response = $client->request(Request::METHOD_GET, ProxyServiceInterface::API_LIST_URL, $params);
        $response = $response->getBody()->getContents();

        /** Hide me service used windows-1251 encoding. To avoid any kinds of errors and problems on decode, we need
         * to change response string encoding. */
        $response = mb_convert_encoding($response, ProxyServiceInterface::UTF8, ProxyServiceInterface::WIN1251);
        $response = json_decode($response, true) ?? [];

        $this->saveArray($response);

        return $this->getAll();
    }

    /**
     * {@inheritdoc}
     */
    public function getAll():array
    {
        $store   = $this->cache->getItem(ProxyServiceInterface::CACHE_KEY);
        $proxies = $store->get();
        $proxies = array_map(function ($proxy) {

            return new ProxyModel($proxy);
        }, $proxies);

        return $proxies;
    }

    /**
     * {@inheritdoc}
     */
    public function getRand():ProxyModel
    {
        $proxies = $this->getAll();
        $proxy   = $proxies[array_rand($proxies)];

        return $proxy;
    }

    /**
     * Save array of proxies.
     * This method is designed to save an array of proxies in the cache.
     * @param array $proxies
     *
     * @return ProxyService
     */
    private function saveArray(array $proxies):ProxyService
    {
        $store = $this->cache->getItem(ProxyServiceInterface::CACHE_KEY);

        $store->set($proxies);
        $this->cache->save($store);

        return $this;
    }

    /**
     * Encode filters depth level >2.
     * This method is designed to transform all arrays to string for every element of depth level more then 2.
     * @return array
     */
    private function encodeFilters():array
    {
        return array_map(function ($filter) {
            if (is_array($filter)) {
                return implode("", $filter);
            }

            return $filter;
        }, array_filter($this->filters));
    }
}
