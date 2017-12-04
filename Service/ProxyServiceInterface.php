<?php

namespace Antonisin\HideMeBundle\Service;

use Antonisin\HideMeBundle\Model\ProxyModel;

/**
 * Interface ProxyServiceInterface
 * @author Maxim Antonsin <maxim.antonisin@gmail.com>
 *
 * @version 1.0.0
 */
interface ProxyServiceInterface
{
    const CACHE_PROXY_LIST_KEY = 'hideme.proxy.list';
    const PARAM_KEY_API_KEY    = 'api_key';
    const PARAM_KEY_API_URL    = 'api_url';

    const API_LIST_URL = 'proxylist.php';

    const FORMAT_JSON   = 'js';
    const FORMAT_PLAIN  = 'plain';
    const FORMAT_PHP    = 'php';
    const FORMAT_CSV    = 'csv';
    const FORMAT_XML    = 'xml';

    const TYPE_HTTP   = 'h';
    const TYPE_HTTPS  = 's';
    const TYPE_SOCKS4 = '4';
    const TYPE_SOCKS5 = '5';

    const WIN1251 = 'windows-1251';
    const UTF8    = 'utf-8';

    const CACHE_KEY = 'hideme.proxy';

    /**
     * ProxyService constructor.
     * @param string $url
     * @param string $key
     * @param array  $filters
     */
    public function __construct(string $url, string $key, array $filters = []);

    /**
     * Load proxies.
     * This method is designed to get an list of proxies using api auth key and filter params. Also this method
     * store full list of proxies in cache item.
     * @return array
     */
    public function load():array;

    /**
     * Return proxy list.
     * This method is designed to return an array of proxies. Every element of this array is instance of ProxyModel.
     * @return array
     */
    public function getAll():array;

    /**
     * Return rand element.
     * This method is designed to return an random proxy.
     * @return ProxyModel
     */
    public function getRand():ProxyModel;
}
