<?php

namespace Mic2100IsTor\Tests;

use PHPUnit_Framework_TestCase;
use Mic2100\IsTor\Storage\FileStorage;
use Mic2100\IsTor\Engine;
use Mic2100\IsTor\Subscriptions;
use Mic2100\IsTor\Subscriptions\Tor;
use Mic2100\IsTor\Assessor;

class IsTorTest extends PHPUnit_Framework_TestCase
{
    public function testIsTor()
    {
        $filename = sys_get_temp_dir() . '/ips.ip';
        $ip = '86.19.228.173';

        $storage = new FileStorage;
        $engine = new Engine;
        $subscriptions = new Subscriptions($engine, $storage);
        $assessor = new Assessor($engine, $storage);

        $subscriptions->addSubscription(new Tor($ip))
            ->setName($filename)
            ->retrieve();

        if ($assessor->setName($filename)->isTor($ip)) {
            echo 'Found';
        }

        echo 'Not Found';

        $this->assertTrue(true);
    }
}
