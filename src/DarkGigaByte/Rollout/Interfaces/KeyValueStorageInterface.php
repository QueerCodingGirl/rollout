<?php

namespace DarkGigaByte\Rollout\Interfaces;

/**
 * Interface KeyValueStorageInterface
 * @package DarkGigaByte\Rollout\Interfaces
 */
interface KeyValueStorageInterface
{

    /**
     * @param $key
     * @return mixed
     */
    public function get($key);

    /**
     * @param $key
     * @param $value
     * @return string|null
     */
    public function set($key, $value);
}