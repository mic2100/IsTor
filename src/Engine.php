<?php

namespace Mic2100\IsTor;

/**
 * IsTor?
 *
 * Engine Class
 *
 * @author Michael Bardsley @mic_bardsley
 */
class Engine
{
    /**
     * Collapse the IP's ArrayIterator list
     *
     * @param \ArrayIterator $ips
     * @return array
     */
    public function collapseIps(\ArrayIterator $ips)
    {
        $ipsArray = [];
        foreach ($ips as $ip) {
            $ipsArray = $this->collapseIp(explode(".", $ip), $ipsArray);
        }

        return $ipsArray;
    }

    /**
     * Collapse an IP address array (exploded IP string by .)
     *
     * @param array $ip
     * @param array $ipsArray
     * @param array $ipsArray
     * @return array
     */
    protected function collapseIp(array $ip, array $ipsArray)
    {
        $segments = $ip;

        $compressor = function ($ipsArray) use (&$segments) {
            $segment = array_shift($segments);
            if (! array_key_exists($segment, $ipsArray)) {
                $ipsArray[$segment] = [];
            }
            return $ipsArray;
        };

        $s1 = &$ipsArray;
        $s1 = $compressor($s1);

        $s2 = &$ipsArray[$ip[0]];
        $s2 = $compressor($s2);

        $s3 = &$ipsArray[$ip[0]][$ip[1]];
        $s3 = $compressor($s3);

        $s4 = &$ipsArray[$ip[0]][$ip[1]][$ip[2]];
        $s4 = $compressor($s4);

        return $ipsArray;
    }

    /**
     * Checks the remote IP to see if it exists in the collapsed IP list
     *
     * @param string $remoteIp 192.168.0.1
     * @param array $list
     * @return boolean
     */
    public function checkIp($remoteIp, array $list)
    {
        foreach ($remoteIps = explode(".", $remoteIp) as $segment) {
            if (isset($list[$segment])) {
                $list = $list[$segment];
                continue;
            }
            return false;
        }

        return true;
    }
}

