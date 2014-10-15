<?php

namespace Mic2100IsTor\Tests\Unit;

use ArrayIterator;
use Mic2100\IsTor\Engine;
use PHPUnit_Framework_TestCase;

/**
 * IsTor?
 *
 * PHPUnit EngineTest Class
 *
 * @author Michael Bardsley @mic_bardsley
 */
class EngineTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Engine
     */
    protected $engine;

    /**
     * Setup
     */
    public function setup()
    {
        $this->engine = new Engine;
    }

    /**
     * Test Engine::checkIp and assert true
     */
    public function test_check_ip_return_true()
    {
        $this->assertTrue($this->engine->checkIp('108.13.245.62', json_decode($this->get_ip_file_contents(), true)));
    }

    /**
     * Test Engine::checkIp and assert true
     */
    public function test_check_ip_return_false()
    {
        $this->assertFalse($this->engine->checkIp('108.13.245.63', json_decode($this->get_ip_file_contents(), true)));
    }

    /**
     * Test Engine::collapseIps
     */
    public function test_collapse_ips_returns_array()
    {
        $ipArray = $this->engine->collapseIps($this->get_array_iterator_of_ip_addresses());

        $this->assertInternalType('array', $ipArray);
        $this->assertSame(14, sizeof($ipArray));
    }

    /**
     * Get an ArrayIterator populated with IP addresses
     *
     * @return ArrayIterator
     */
    private function get_array_iterator_of_ip_addresses()
    {
        return new ArrayIterator([
            '12.13.13.14',
            '12.14.15.17',
            '13.111.131.187',
            '14.123.13.134',
            '111.123.11.15',
            '134.123.142.14',
            '135.123.132.155',
            '142.123.123.13',
            '146.1.5.1',
            '153.12.134.12',
            '164.132.143.164',
            '167.123.123.176',
            '173.163.15.136',
            '187.123.21.4',
            '187.143.12.11',
            '234.123.213.2',
        ]);
    }

    /**
     * Get a file contents populated with a collapsed IP addresses
     *
     * @return string
     */
    private function get_ip_file_contents()
    {
        return file_get_contents(__DIR__ . '/ips.ip');
    }
}
