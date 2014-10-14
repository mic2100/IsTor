<?php

namespace Mic2100\IsTor\Storage;

use Mic2100\IsTor\Exception\InvalidCacheNameException;

/**
 * IsTor?
 *
 * FileStorage Class
 *
 * @author Michael Bardsley @mic_bardsley
 */
class FileStorage extends AbstractStorage
{
    const MISSING_NAME_READ = 'You must set a filename before trying to read the data';
    const MISSING_NAME_WRITE = 'You must set a filename before trying to write the data';
    const MISSING_NAME_UPDATE = 'You must set a filename before checking if an update is required';

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

            if (!file_exists($this->getName())) {
                return '';
            }

            $this->dataCache = file_get_contents($this->getName());
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

        file_put_contents($this->getName(), $this->dataCache);

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @throws Mic2100\IsTor\Exception\InvalidCacheNameException
     */
    public function isUpdateRequired()
    {
        if(!$this->isNameSet()) {
            throw new InvalidCacheNameException(self::MISSING_NAME_UPDATE);
        }

        return !file_exists($this->getName()) || $this->calculateUpdateRequiredTime() > 0;
    }

    /**
     * Calculate the update required time
     *
     * @return int
     */
    protected function calculateUpdateRequiredTime()
    {
        return time() - $this->getTimeout() - filemtime($this->getName());
    }
}
