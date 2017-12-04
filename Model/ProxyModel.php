<?php

namespace Antonisin\HideMeBundle\Model;

/**
 * Class ProxyModel
 * This class describe proxy model and designed to work with proxy params and details.
 * @author Maxim Antonisin <maxim.antonisin@gmail.com>
 *
 * @version 1.0.1
 */
class ProxyModel
{
    /** Base proxy types. */
    const TYPE_SOCKS5 = 'socks5';
    const TYPE_SOCKS4 = 'socks4';
    const TYPE_HTTP   = 'http';
    const TYPE_HTTPS  = 'ssl';

    /** Proxy array access keys. */
    const KEY_HOST         = 'host';
    const KEY_IP           = 'ip';
    const KEY_PORT         = 'port';
    const KEY_LAST_SEEN    = 'lastseen';
    const KEY_DELAY        = 'delay';
    const KEY_CID          = 'cid';
    const KEY_COUNTRY_CODE = 'country_code';
    const KEY_COUNTRY_NAME = 'country_name';
    const KEY_CITY         = 'city';
    const KEY_CHECKS_UP    = 'checks_up';
    const KEY_CHECKS_DOWN  = 'checks_down';
    const KEY_ANON         = 'anon';

    /**
     * Proxy host string value.
     * @var string
     */
    private $host;

    /**
     * Proxy IP address.
     * 127.0.0.1 - 255.255.255.255
     * @var string
     */
    private $ip;

    /**
     * Proxy port.
     * 10 - 65555
     * @var int
     */
    private $port;

    /**
     * Unknown parameter for now.
     * @var int
     */
    private $lastSeen;

    /**
     * Response time.
     * @var int
     */
    private $delay;

    /**
     * Proxy id.
     * @var int
     */
    private $id;

    /**
     * Proxy country code. (2 symbols)
     * @var string
     */
    private $countryCode;

    /**
     * Proxy country name.
     * @var string
     */
    private $countryName;

    /**
     * Proxy city. May be empty string.
     * @var string
     */
    private $city;

    /**
     * Number of proxy up check.
     * This property shown how many times proxy was checked and it was online.
     * @var int
     */
    private $checksUp;

    /**
     * Number of proxy down check.
     * This property shown how many times proxy was checked and it was offline.
     * @var int
     */
    private $checksDown;

    /**
     * Proxy anonymous level. (1-4)
     * @var int
     */
    private $anonymous;

    /**
     * Proxy type.
     * This property is designed to show proxy time.
     * One of the constants TYPE_HTTP, TYPE_HTTPS, TYPE_SOCKS4, TYPE_SOCKS5.
     * @var string
     */
    private $type;

    /**
     * ProxyModel constructor.
     * This method is designed to initialize and setup proxy model with all needed parameters.
     * The input array have next format:
     * [
     *      "ip"           =>  string
     *      "host"         =>  string
     *      "port"         =>  int
     *      "delay"        =>  int
     *      "cid"          =>  int
     *      "lastseen"     =>  int,
     *      "country_code" =>  string([A-Z]{1,}),
     *      "country_name" =>  string,
     *      "city"         =>  string,
     *      "checks_up"    =>  int,
     *      "checks_down"  =>  int,
     *      "anon"         =>  1-4,
     *      "http"         =>  0/1,
     *      "ssl"          =>  0/1,
     *      "socks4"       =>  0/1,
     *      "socks5"       =>  0/1
     * ]
     * @param array $proxyArray
     */
    public function __construct(array $proxyArray)
    {
        $this->host         = $proxyArray[ProxyModel::KEY_HOST];
        $this->ip           = $proxyArray[ProxyModel::KEY_IP];
        $this->countryCode  = $proxyArray[ProxyModel::KEY_COUNTRY_CODE];
        $this->countryName  = $proxyArray[ProxyModel::KEY_COUNTRY_NAME];
        $this->city         = $proxyArray[ProxyModel::KEY_CITY];

        $this->port         = (int) $proxyArray[ProxyModel::KEY_PORT];
        $this->lastSeen     = (int) $proxyArray[ProxyModel::KEY_LAST_SEEN];
        $this->delay        = (int) $proxyArray[ProxyModel::KEY_DELAY];
        $this->id           = (int) $proxyArray[ProxyModel::KEY_CID];
        $this->checksUp     = (int) $proxyArray[ProxyModel::KEY_CHECKS_UP];
        $this->checksDown   = (int) $proxyArray[ProxyModel::KEY_CHECKS_DOWN];
        $this->anonymous    = (int) $proxyArray[ProxyModel::KEY_ANON];

        if (boolval($proxyArray[ProxyModel::TYPE_HTTP])) {
            $this->type = ProxyModel::TYPE_HTTP;
        } elseif (boolval($proxyArray[ProxyModel::TYPE_HTTPS])) {
            $this->type = ProxyModel::TYPE_HTTPS;
        } elseif (boolval($proxyArray[ProxyModel::TYPE_SOCKS4])) {
            $this->type = ProxyModel::TYPE_SOCKS4;
        } elseif (boolval($proxyArray[ProxyModel::TYPE_SOCKS5])) {
            $this->type = ProxyModel::TYPE_SOCKS5;
        }
    }

    /**
     * Return proxy url string with protocol context.
     * @return string
     */
    public function __toString():string
    {
        switch ($this->type) {
            case ProxyModel::TYPE_HTTPS:
                return "https://".$this->ip.":".$this->port;
            case ProxyModel::TYPE_SOCKS4:
                return "socks4://".$this->ip.":".$this->port;
            case ProxyModel::TYPE_SOCKS5:
                return "socks5://".$this->ip.":".$this->port;
            default:
                return $this->ip.":".$this->port;
        }
    }

    /**
     * Return proxy host string value.
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * Set proxy host string value.
     * @param string $host
     *
     * @return ProxyModel
     */
    public function setHost(string $host): ProxyModel
    {
        $this->host = $host;

        return $this;
    }

    /**
     * Return proxy ip address.
     * 127.0.0.1 - 255.255.255.255
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * Set proxy ip address.
     * 127.0.0.1 - 255.255.255.255
     * @param string $ip
     *
     * @return ProxyModel
     */
    public function setIp(string $ip): ProxyModel
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Return proxy port value.
     * 10 - 65555
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * Set proxy port value.
     * 10 - 65555
     * @param int $port
     *
     * @return ProxyModel
     */
    public function setPort(int $port): ProxyModel
    {
        $this->port = $port;

        return $this;
    }

    /**
     * Return proxy last seen.
     * For now destination of this property is unknown.
     * @return int
     */
    public function getLastSeen(): int
    {
        return $this->lastSeen;
    }

    /**
     * Set proxy last seen
     * For now destination of this property is unknown.
     * @param int $lastSeen
     *
     * @return ProxyModel
     */
    public function setLastSeen(int $lastSeen): ProxyModel
    {
        $this->lastSeen = $lastSeen;

        return $this;
    }

    /**
     * Return proxy response time in ms.
     * @return int
     */
    public function getDelay(): int
    {
        return $this->delay;
    }

    /**
     * Set proxy response time.
     * @param int $delay
     *
     * @return ProxyModel
     */
    public function setDelay(int $delay): ProxyModel
    {
        $this->delay = $delay;

        return $this;
    }

    /**
     * Return proxy id.
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set proxy id.
     * @param int $id
     *
     * @return ProxyModel
     */
    public function setId(int $id): ProxyModel
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Return proxy country code. (2 chars)
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * Set proxy country code. (2 chars)
     * @param string $countryCode
     *
     * @return ProxyModel
     */
    public function setCountryCode(string $countryCode): ProxyModel
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * Return proxy country name.
     * @return string
     */
    public function getCountryName(): string
    {
        return $this->countryName;
    }

    /**
     * Set proxy country name.
     * @param string $countryName
     *
     * @return ProxyModel
     */
    public function setCountryName(string $countryName): ProxyModel
    {
        $this->countryName = $countryName;

        return $this;
    }

    /**
     * Return proxy city.
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * Set proxy city.
     * @param string $city
     *
     * @return ProxyModel
     */
    public function setCity(string $city): ProxyModel
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Return number of checks up.
     * This method is designed to return number of checks when proxy was up.
     * @return int
     */
    public function getChecksUp(): int
    {
        return $this->checksUp;
    }

    /**
     * Set number of checks up.
     * This method is designed to set number of checks when proxy was up.
     * @param int $checksUp
     *
     * @return ProxyModel
     */
    public function setChecksUp(int $checksUp): ProxyModel
    {
        $this->checksUp = $checksUp;

        return $this;
    }

    /**
     * Return number of checks down.
     * This method is designed to return number of checks when proxy was down.
     * @return int
     */
    public function getChecksDown(): int
    {
        return $this->checksDown;
    }

    /**
     * Set number of checks down.
     * This method is designed to set number of checks when proxy was down.
     * @param int $checksDown
     *
     * @return ProxyModel
     */
    public function setChecksDown(int $checksDown): ProxyModel
    {
        $this->checksDown = $checksDown;

        return $this;
    }

    /**
     * Return proxy anonymous level. (1-4)
     * @return int
     */
    public function getAnonymous(): int
    {
        return $this->anonymous;
    }

    /**
     * Set proxy anonymous level. (1-4)
     * @param int $anonymous
     *
     * @return ProxyModel
     */
    public function setAnonymous(int $anonymous): ProxyModel
    {
        $this->anonymous = $anonymous;

        return $this;
    }

    /**
     * Return proxy type.
     * This method is designed to return proxy time.
     * One of the constants TYPE_HTTP, TYPE_HTTPS, TYPE_SOCKS4, TYPE_SOCKS5.
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Set proxy type.
     * @param string $type
     * This method is designed to set proxy time.
     * One of the constants TYPE_HTTP, TYPE_HTTPS, TYPE_SOCKS4, TYPE_SOCKS5.
     *
     * @return ProxyModel
     */
    public function setType(string $type): ProxyModel
    {
        $this->type = $type;

        return $this;
    }
}
