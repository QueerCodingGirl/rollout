<?php

namespace QueerCodingGirl\Rollout\Interfaces;

/**
 * Interface DeterminableUserInterface
 * @package QueerCodingGirl\Rollout\Interfaces
 */
interface DeterminableUserInterface
{

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

    /**
     * Returns an array of Groups (strings)
     * @return string[]
     */
    public function getGroups();
}