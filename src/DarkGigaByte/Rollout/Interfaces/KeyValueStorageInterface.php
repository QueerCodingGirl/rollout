<?php

namespace QueerCodingGirl\Rollout\Interfaces;

/**
 * Interface KeyValueStorageInterface
 * @package QueerCodingGirl\Rollout\Interfaces
 */
interface KeyValueStorageInterface
{

    /**
     * Gets a value from a key in the storage
     *
     * @param $key
     * @return string|null
     */
    public function get($key);

    /**
     * Sets a key in the storage to a value
     *
     * @param $key
     * @param $value
     * @return KeyValueStorageInterface
     */
    public function set($key, $value);
}