<?php

namespace Mic2100\IsTor\Storage;

/**
 * IsTor?
 *
 * AbstractStorage Class
 *
 * @author Michael Bardsley @mic_bardsley
 */
abstract class AbstractStorage implements StorageInterface
{
    /**
     * @var int
     */
    protected $timeout = 3600;

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var string
     */
    protected $dataCache;

    /**
     * {@inheritdoc}
     */
    abstract public function read();

    /**
     * {@inheritdoc}
     */
    abstract public function write($content);

    /**
     * {@inheritdoc}
     */
    abstract public function isUpdateRequired();

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * {@inheritdoc}
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * Is the name set true or false returned
     *
     * @return bool
     */
    protected function isNameSet()
    {
        return (bool) $this->getName();
    }
}
