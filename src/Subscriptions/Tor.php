<?php

namespace Mic2100\IsTor\Subscriptions;

use ArrayIterator;
use Mic2100\IsTor\Subscriptions\SubscriptionInterface;

/**
 * IsTor?
 *
 * Tor Subscription Class
 *
 * @author Michael Bardsley @mic_bardsley
 */
class Tor implements SubscriptionInterface
{
    const TOR_URL = 'https://check.torproject.org/cgi-bin/TorBulkExitList.py?ip=%s&port=%s';

    /**
     * @var string
     */
    protected $ip;

    /**
     * @var int
     */
    protected $port;

    /**
     * Constructor
     *
     * @param string $ip
     * @param int $port default is 80
     */
    public function __construct($ip, $port = 80)
    {
        $this->ip = $ip;
        $this->port = $port;
    }

    /**
     * Gets the Tor exit point addresses
     *
     * @return \ArrayIterator
     */
    public function get()
    {
        $url = sprintf(self::TOR_URL, $this->ip, $this->port);

        $ch = \curl_init();
        \curl_setopt($ch, CURLOPT_URL, $url);
        \curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        \curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $ips = new ArrayIterator();
        $rows = new ArrayIterator(explode(PHP_EOL, trim(\curl_exec($ch))));
        \curl_close($ch);

        //check each of the rows to get the IP addresses
        array_walk($rows, function($row, $key, &$ips) {
            if (ip2long($row)) {
                $ips[] = $row;
            }
        }, $ips);
        unset($rows);
        return $ips;
    }
}

