<?php

namespace QueerCodingGirl\Rollout\Storage;


use QueerCodingGirl\Rollout\Interfaces\KeyValueStorageInterface;

/**
 * Class ArrayStorage
 * @package QueerCodingGirl\Rollout\Storage
 */
class ArrayStorage implements KeyValueStorageInterface
{
    /**
     * @var array
     */
    protected $storage = array();

    /**
     * Gets a value from a key in the storage
     *
     * @param $key
     * @return string|null
     */
    public function get($key)
    {
        $storageValue = null;
        if (true === array_key_exists($key, $this->storage)) {
            $storageValue = $this->storage[$key];
        }
        return $storageValue;
    }

    /**
     * Sets a key in the storage to a value
     *
     * @param $key
     * @param $value
     * @return KeyValueStorageInterface
     */
    public function set($key, $value)
    {
        $this->storage[$key] = $value;
        return $this;
    }

} 