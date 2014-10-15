<?php

namespace Mic2100IsTor\Tests\Unit;

use Mic2100\IsTor\Assessor;
use Mic2100\IsTor\Engine;
use Mic2100\IsTor\Storage\AbstractStorage;
use PHPUnit_Framework_TestCase;

/**
 * IsTor?
 *
 * PHPUnit AssessorTest Class
 *
 * @author Michael Bardsley @mic_bardsley
 */
class AssessorTest extends PHPUnit_Framework_TestCase
{

    /**
     * Test isTor returning true
     */
    public function test_isTor_returning_true()
    {
        $engine = $this->mockEngine();
        $read = $this->mockStorage();

        $engine->expects($this->any())
            ->method('checkIp')
            ->will($this->returnValue(true));

        $read->expects($this->any())
            ->method('read')
            ->will($this->returnValue(json_encode([])));

        $assessor = new Assessor($engine, $read);

        $this->assertTrue($assessor->isTor('12.13.123.23'));
    }

    /**
     * Test isTor returning false
     */
    public function test_isTor_returning_false()
    {
        $engine = $this->mockEngine();
        $storage = $this->mockStorage();

        $engine->expects($this->any())
            ->method('checkIp')
            ->will($this->returnValue(false));

        $storage->expects($this->any())
            ->method('read')
            ->will($this->returnValue(json_encode([])));

        $assessor = new Assessor($engine, $storage);

        $this->assertFalse($assessor->isTor('145.45.45.75'));
    }

    /**
     * Test getting the storage name
     */
    public function test_get_storage_name()
    {
        $storageName = __DIR__ . '/ips.ip';
        $storage = $this->mockStorage();

        $storage->expects($this->any())
            ->method('getName')
            ->will($this->returnValue($storageName));

        $assessor = new Assessor($this->mockEngine(), $storage);

        $this->assertSame($storageName, $assessor->getStorageName());
    }

    /**
     * Test setting the storage name returns instance of Mic2100\IsTor\Assessor
     */
    public function test_set_storage_name()
    {
        $storage = $this->mockStorage();

        $storage->expects($this->once())
            ->method('setName')
            ->will($this->returnSelf());

        $assessor = new Assessor($this->mockEngine(), $storage);

        $this->assertInstanceOf('Mic2100\IsTor\Assessor', $assessor->setStorageName(__DIR__ . '/ips.ip'));
    }


    /**
     * @return Engine
     */
    private function mockEngine()
    {
        return $this->getMock(
            'Mic2100\IsTor\Engine',
            ['checkIp']
        );
    }

    /**
     * @return AbstractStorage
     */
    private function mockStorage()
    {
        return $this->getMock(
            'Mic2100\IsTor\Storage\AbstractStorage',
            ['getName', 'read', 'setName', 'write', 'isUpdateRequired']
        );
    }
}
 