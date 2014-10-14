<?php

namespace Mic2100\IsTor;

use ArrayIterator;
use Mic2100\IsTor\Storage\StorageInterface;
use Mic2100\IsTor\Exception\EmptySubscriptionsArray;

/**
 * IsTor?
 *
 * Subscriptions Class
 *
 * @author Michael Bardsley @mic_bardsley
 */
class Subscriptions
{
    /**
     * @var \Mic2100\IsTor\Engine
     */
    protected $engine;

    /**
     * @var \Mic2100\IsTor\Storage\StorageInterface
     */
    protected $storage;

    /**
     * @var array
     */
    protected $subscriptions = [];

    /**
     * @var array
     */
    protected $ips = [];

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
     * Adds a subscription to the class
     *
     * @param \Mic2100\IsTor\Subscriptions\SubscriptionInterface $subscription
     * @return \Mic2100\IsTor\Subscriptions
     */
    public function addSubscription(Subscriptions\SubscriptionInterface $subscription)
    {
        $this->subscriptions[] = $subscription;
        return $this;
    }

    /**
     * Retrieves the data from the subscriptions providers
     *
     * @return \Mic2100\IsTor\Subscriptions
     * @throws EmptySubscriptionsArray - if no subscriptions have been added
     */
    public function retrieve()
    {
        if (empty($this->subscriptions)) {
            throw new EmptySubscriptionsArray("You need to add at least 1 subscription before you can retrieve");
        }

        if($this->isUpdateNeeded()) {
            foreach ($this->subscriptions as $subscription) {
                $this->ips = array_merge($this->ips, (array) $subscription->get());
            }

            $this->saveIps($this->engine->collapseIps(new ArrayIterator($this->ips)));
        }

        return $this;
    }

    /**
     * Does the storage information need updating
     *
     * @return boolean
     */
    public function isUpdateNeeded()
    {
        return $this->storage->isUpdateRequired();
    }

    /**
     * Gets the name
     *
     * @return string
     */
    public function getName()
    {
        return $this->storage->getName();
    }

    /**
     * Sets the name
     *
     * @param string $name
     * @return \Mic2100\IsTor\Subscriptions
     */
    public function setName($name)
    {
        $this->storage->setName($name);

        return $this;
    }

    /**
     * Gets the storage timeout value
     *
     * @return int
     */
    public function getTimeout()
    {
        return $this->storage->getTimeout();
    }

    /**
     * Sets the storage timeout value
     *
     * @param int $timeout
     * @return \Mic2100\IsTor\Subscriptions
     */
    public function setTimeout($timeout)
    {
        $this->storage->setTimeout($timeout);

        return $this;
    }

    /**
     * Saves the array of IP's using the attached storage
     *
     * @param array $ips
     * @return \Mic2100\IsTor\Subscriptions
     */
    protected function saveIps(array $ips)
    {
        $this->storage->write($ips);

        return $this;
    }

    /**
     * Loads the IP's from the attached storage
     *
     * @return \Mic2100\IsTor\Subscriptions
     */
    protected function loadIps()
    {
        $contents = $this->storage->read();
        if (empty($contents)) {
            $this->ips = [];
            return $this;
        }

        $this->ips = json_decode($contents, true);

        return $this;
    }
}
