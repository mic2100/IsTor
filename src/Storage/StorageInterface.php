<?php

namespace Mic2100\IsTor\Storage;

/**
 * IsTor?
 *
 * Storage Interface
 *
 * @author Michael Bardsley @mic_bardsley
 */
interface StorageInterface
{
    /**
     * Reads the data from the storage
     *
     * @return string
     */
    public function read();

    /**
     * Writes the data to the storage
     *
     * @param string $content
     * @return \Mic2100\IsTor\Storage\StorageInterface
     */
    public function write($content);

    /**
     * Does the stored data need to be updated
     *
     * @return bool
     */
    public function isUpdateRequired();

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return \Mic2100\IsTor\Storage\StorageInterface
     */
    public function setName($name);

    /**
     * @return mixed
     */
    public function getTimeout();

    /**
     * @param int $timeout
     * @return \Mic2100\IsTor\Storage\StorageInterface
     */
    public function setTimeout($timeout);
}