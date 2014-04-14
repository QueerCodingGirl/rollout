<?php

namespace DarkGigaByte\Rollout\Interfaces;

use DarkGigaByte\Rollout\RolloutAbstract;

/**
 * Interface RolloutableInterface
 * @package DarkGigaByte\Rollout\Interfaces
 */
interface RolloutableInterface
{

    /**
     * Configure the feature with a single string
     *
     * Format of config string should be: "100|1,2,3,4|ROLE_ADMIN,ROLE_PREMIUM"
     * - where "100" is the percentage of user for that the feature should be enabled.
     * - where "1,2,3,4" are a comma-separated list of user IDs that should have this feature.
     * - where "ROLE_ADMIN,ROLE_PREMIUM" are a comma-separated list of the role names that should have this feature.
     *
     * Empty section are allowed and silently ignored as long as the format of the string stays the same:
     * e.g. "20||ROLE_PREMIUM" is valid (20 percent and additionally al users with ROLE_PREMIUM will get the feature)
     * e.g. "|||" is valid and will completely disable this feature, but it is recommend to use "0|||" instead.
     *
     * @param string $configString
     * @return bool Successfully parsed the string or not
     */
    public function configureByConfigString($configString);

    /**
     * @param RolloutAbstract $rollout
     * @param DeterminableUserInterface $user
     * @internal param int $userId
     * @return bool $isActive
     */
    public function isActive(RolloutAbstract $rollout, DeterminableUserInterface $user = null);

    /**
     * Returns the name of the feature as string. A features name has to be unique!
     * @return string
     */
    public function getName();

    /**
     * Returns the percentage of users that should be enabled
     * @return integer
     */
    public function getPercentage();

    /**
     * Returns an array of user IDs that should be explicitly enabled for this feature
     * @return integer[]
     */
    public function getUsers();

    /**
     * Returns an array of role names that should be enabled for this feature
     * @return string[]
     */
    public function getRoles();

    /**
     * Returns an array of group names that should be enabled for this feature
     * @return string[]
     */
    public function getGroups();

    /**
     * Set the percentage of users that should be enabled
     * @param integer
     * @return RolloutableInterface $this
     */
    public function setPercentage($integer);

    /**
     * Sets the array of user IDs that should be explicitly enabled for this feature
     * @param integer[] $userIds
     * @return RolloutableInterface $this
     */
    public function setUsers(array $userIds);

    /**
     * Adds a user to the list of user IDs that should be explicitly enabled for this feature
     * @param integer $userId
     * @return RolloutableInterface $this
     */
    public function addUser($userId);

    /**
     * Removes a user from the list of user IDs that should be explicitly enabled for this feature
     * @param integer $userId
     * @return RolloutableInterface $this
     */
    public function removeUser($userId);

    /**
     * Sets the array of role names that should be enabled for this feature
     * @param string[] $roles
     * @return RolloutableInterface $this
     */
    public function setRoles(array $roles);

    /**
     * Adds a role to the list of role names that should be enabled for this feature
     * @param string $roleName
     * @return RolloutableInterface $this
     */
    public function addRole($roleName);

    /**
     * Removes a role from the list of role names that should be enabled for this feature
     * @param string $roleName
     * @return RolloutableInterface $this
     */
    public function removeRole($roleName);

    /**
     * Sets the array of group names that should be enabled for this feature
     * @param string[] $groups
     * @return RolloutableInterface $this
     */
    public function setGroups(array $groups);

    /**
     * Adds a group to the list of group names that should be enabled for this feature
     * @param string $groupName
     * @return RolloutableInterface $this
     */
    public function addGroup($groupName);

    /**
     * Removes a group from the list of group names that should be enabled for this feature
     * @param string $groupName
     * @return RolloutableInterface $this
     */
    public function removeGroup($groupName);

    /**
     * Resets the feature config
     * @return RolloutableInterface $this
     */
    public function clearConfig();

    /**
     * @return string
     */
    public function __toString();
}