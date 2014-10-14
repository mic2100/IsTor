<?php

namespace Mic2100\IsTor;

use Mic2100\IsTor\Storage\StorageInterface;

/**
 * IsTor?
 *
 * Assessor Class
 *
 * @author Michael Bardsley @mic_bardsley
 */
class Assessor
{
    /**
     * @var \Mic2100\IsTor\Engine $engine
     */
    protected $engine;

    /**
     * @var \Mic2100\IsTor\Storage\StorageInterface $storage
     */
    protected $storage;

    /**
     * Constructor
     *
     * @param \Mic2100\IsTor\Engine $engine
     * @param \Mic2100\IsTor\Storage\StorageInterface $storage
     */
    public function __construct(Engine $engine, StorageInterface $storage)
    {
        $this->engine = $engine;
        $this->storage = $storage;
    }

    /**
     * Is the remote IP string (IPv4 - e.g. 192.168.0.1) in the Tor list?
     *
     * @param string $remoteIp
     * @return boolean
     */
    public function isTor($remoteIp)
    {
        return $this->engine->checkIp($remoteIp, json_decode($this->storage->read(), true));
    }

    /**
     * Gets the name
     *
     * @return \Mic2100\IsTor\Assessor
     */
    public function getName()
    {
        $this->storage->getName();

        return $this;
    }

    /**
     * Sets the name
     *
     * @param string $name
     * @return \Mic2100\IsTor\Assessor
     */
    public function setName($name)
    {
        $this->storage->setName($name);

        return $this;
    }
}
