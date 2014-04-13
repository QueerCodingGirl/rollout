<?php

namespace DarkGigaByte\Rollout\Interfaces;

/**
 * Interface DeterminableUserInterface
 * @package DarkGigaByte\Rollout\Interfaces
 */
interface DeterminableUserInterface {

    /**
     * Returns the user identifier (which must be an integer)
     * @return integer
     */
    public function getId();

    /**
     * Returns an array of Roles (strings)
     * @return string[]
     */
    public function getRoles();
} 