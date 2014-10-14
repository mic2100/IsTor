<?php

namespace Mic2100\IsTor\Storage;

/**
 * IsTor?
 *
 * ApcStorage Class
 *
 * @author Michael Bardsley @mic_bardsley
 */
class ApcStorage extends AbstractStorage
{
    const CACHE_NAME = 'isTor-collector-storage-apc';
    const MISSING_NAME_READ = 'You must set a cache before trying to read the data';
    const MISSING_NAME_WRITE = 'You must set a cache before trying to write the data';
    const MISSING_NAME_UPDATE = 'You must set a cache before checking if an update is required';

    /**
     * {@inheritdoc}
     *
     * @throws Mic2100\IsTor\Exception\InvalidCacheNameException
     */
    public function read()
    {
        if (empty($this->dataCache)) {
            if(!$this->isNameSet()) {
                throw new InvalidCacheNameException(self::MISSING_NAME_READ);
            }

            $this->dataCache = apc_fetch($this->getName());
        }

        return $this->dataCache;
    }

    /**
     * {@inheritdoc}
     *
     * @throws Mic2100\IsTor\Exception\InvalidCacheNameException
     */
    public function write($content)
    {
        if(!$this->isNameSet()) {
            throw new InvalidCacheNameException(self::MISSING_NAME_WRITE);
        }

        //store the JSON string in the cache so it doesn't need to be read from the file
        $this->dataCache = json_encode($content);

        apc_store($this->getName(), $this->dataCache, $this->getTimeout());

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @throws Mic2100\IsTor\Exception\InvalidCacheNameException
     */
    public function isUpdateRequired()
    {
        if(! $this->isNameSet()) {
            throw new InvalidCacheNameException(self::MISSING_NAME_UPDATE);
        }

        if (apc_exists($this->getName())) {
            return true;
        }

        return false;
    }
}

