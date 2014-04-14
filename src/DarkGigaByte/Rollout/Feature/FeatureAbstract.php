<?php

namespace DarkGigaByte\Rollout\Feature;


use DarkGigaByte\Rollout\Interfaces\RolloutableInterface;
use DarkGigaByte\Rollout\RolloutAbstract;
use DarkGigaByte\Rollout\Interfaces\DeterminableUserInterface;

/**
 * Class FeatureAbstract
 * @package DarkGigaByte\Rollout\Feature
 */
abstract class FeatureAbstract implements RolloutableInterface
{

    const FEATURE_CONFIGSTRING_SECTION_DELIMITER = '|';

    const FEATURE_CONFIGSTRING_ENTRY_DELIMITER = ',';

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var integer
     */
    protected $percentage = 0;

    /**
     * @var integer[]
     */
    protected $users = array();

    /**
     * @var string[]
     */
    protected $roles = array();

    /**
     * @var string[]
     */
    protected $groups = array();

    /**
     * Configure the feature with a single string
     *
     * Format of config string should be: "100|1,2,3,4|ROLE_ADMIN,ROLE_PREMIUM|caretaker,supporter,staff"
     * - where "100" is the percentage of user for that the feature should be enabled.
     * - where "1,2,3,4" are a comma-separated list of user IDs that should have this feature.
     * - where "ROLE_ADMIN,ROLE_PREMIUM" are a comma-separated list of the role names that should have this feature.
     * - where "caretaker,supporter,staff" are a comma-separated list of the role names that should have this feature.
     *
     * Empty section are allowed and silently ignored as long as the format of the string stays the same:
     * e.g. "20||ROLE_PREMIUM|" is valid (20 percent and additionally al users with ROLE_PREMIUM will get the feature)
     * e.g. "||||" is valid and will completely disable this feature, but it is recommend to use "0||||" instead.
     *
     * @param $configString
     * @return bool Successfully parsed the string or not
     */
    public function configureByConfigString($configString)
    {
        if (
            true === is_string($configString)
            && '' !== $configString
            && 4 === mb_substr_count($configString, self::FEATURE_CONFIGSTRING_SECTION_DELIMITER)
        ) {

            list($percentageString, $usersString, $rolesString, $groupsString) = explode(
                self::FEATURE_CONFIGSTRING_SECTION_DELIMITER,
                $configString
            );

            if (true === is_numeric($percentageString)) {
                $this->setPercentage((int)$percentageString);
            } else {
                $this->setPercentage(0);
            }

            if (true === is_string($usersString) && '' !== $usersString) {
                $userIds = explode(self::FEATURE_CONFIGSTRING_ENTRY_DELIMITER, $usersString);
                $this->setUsers($userIds);
            } else {
                $this->setUsers(array());
            }

            if (true === is_string($rolesString) && '' !== $rolesString) {
                $roleNames = explode(self::FEATURE_CONFIGSTRING_ENTRY_DELIMITER, $rolesString);
                $this->setRoles($roleNames);
            } else {
                $this->setRoles(array());
            }

            if (true === is_string($groupsString) && '' !== $groupsString) {
                $groupNames = explode(self::FEATURE_CONFIGSTRING_ENTRY_DELIMITER, $groupsString);
                $this->setGroups($groupNames);
            } else {
                $this->setGroups(array());
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * Resets the feature config
     * @return RolloutableInterface $this
     */
    public function clearConfig()
    {
        $this->setPercentage(0);
        $this->setUsers(array());
        $this->setRoles(array());
        $this->setGroups(array());
        return $this;
    }

    /**
     * Check if this feature is active for the given userId
     * @param RolloutAbstract $rollout
     * @param DeterminableUserInterface|null $user
     * @internal param int $userId
     * @return bool
     */
    public function isActive(RolloutAbstract $rollout, DeterminableUserInterface $user = null)
    {
        $isActive = false;
        $userId = (null === $user) ? null : $user->getId();
        if (100 === $this->getPercentage()) {
            $isActive = true;
        } elseif (true === is_numeric($userId)) {
            if (
                true === $this->isUserInPercentage($userId)
                || true === $this->isUserInActiveUsers($userId)
                || true === $this->isUserInActiveRole($user, $rollout)
                || true === $this->isUserInActiveGroup($user, $rollout)
            ) {
                $isActive = true;
            }
        }
        return $isActive;
    }

    /**
     * @param $userId
     * @return bool
     */
    protected function isUserInPercentage($userId)
    {
        $return = ((crc32($userId)%100) < $this->getPercentage());
        return $return;
    }

    /**
     * @param $userId
     * @return bool
     */
    protected function isUserInActiveUsers($userId) {
        return in_array($userId, $this->getUsers());
    }

    /**
     * @param DeterminableUserInterface $user
     * @param RolloutAbstract $rollout
     * @return bool
     */
    protected function isUserInActiveRole(DeterminableUserInterface $user, RolloutAbstract $rollout)
    {
        foreach ($this->getRoles() as $roleName) {
            if (true === $rollout->userHasRole($roleName, $user)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param DeterminableUserInterface $user
     * @param RolloutAbstract $rollout
     * @return bool
     */
    protected function isUserInActiveGroup(DeterminableUserInterface $user, RolloutAbstract $rollout)
    {
        foreach ($this->getGroups() as $groupName) {
            if (true === $rollout->userHasGroup($groupName, $user)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Returns the name of the feature as string. A features name has to be unique!
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the percentage of users that should be enabled
     * @return integer
     */
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * Returns an array of user IDs that should be explicitly enabled for this feature
     * @return integer[]
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Returns an array of role names that should be enabled for this feature
     * @return string[]
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Returns an array of group names that should be enabled for this feature
     * @return string[]
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Set the percentage of users that should be enabled
     * @param $integer
     * @return RolloutableInterface $this
     */
    public function setPercentage($integer)
    {
        $this->percentage = (int)$integer;
        return $this;
    }

    /**
     * Sets the array of user IDs that should be explicitly enabled for this feature
     * @param integer[] $userIds
     * @return RolloutableInterface $this
     */
    public function setUsers(array $userIds)
    {
        $this->users = $this->checkUserIds($userIds);
        return $this;
    }

    /**
     * Adds a user to the list of user IDs that should be explicitly enabled for this feature
     * @param integer $userId
     * @return RolloutableInterface $this
     */
    public function addUser($userId)
    {
        if (true === is_numeric($userId) && false === in_array($userId, $this->users)) {
            $this->users[] = (int)$userId;
        }
        return $this;
    }

    /**
     * Removes a user from the list of user IDs that should be explicitly enabled for this feature
     * @param integer $userId
     * @return RolloutableInterface $this
     */
    public function removeUser($userId)
    {
        if (true === is_numeric($userId) && true === in_array($userId, $this->users)) {
            foreach (array_keys($this->users, (int)$userId, true) as $key) {
                unset($this->users[$key]);
            }
        }
        return $this;
    }

    /**
     * Sets the array of role names that should be enabled for this feature
     * @param string[] $roles
     * @return RolloutableInterface $this
     */
    public function setRoles(array $roles)
    {
        $this->roles = $this->checkRoles($roles);
        return $this;
    }

    /**
     * Adds a role to the list of role names that should be enabled for this feature
     * @param string $roleName
     * @return RolloutableInterface $this
     */
    public function addRole($roleName)
    {
        if (true === is_string($roleName) && false === in_array($roleName, $this->roles)) {
            $this->roles[] = $roleName;
        }
        return $this;
    }

    /**
     * Removes a role from the list of role names that should be enabled for this feature
     * @param string $roleName
     * @return RolloutableInterface $this
     */
    public function removeRole($roleName)
    {
        if (true === is_string($roleName) && true === in_array($roleName, $this->roles)) {
            foreach (array_keys($this->roles, (string)$roleName, true) as $key) {
                unset($this->roles[$key]);
            }
        }
        return $this;
    }

    /**
     * Sets the array of group names that should be enabled for this feature
     * @param string[] $groups
     * @return RolloutableInterface $this
     */
    public function setGroups(array $groups)
    {
        $this->groups = $this->checkGroups($groups);
        return $this;
    }

    /**
     * Adds a group to the list of group names that should be enabled for this feature
     * @param string $groupName
     * @return RolloutableInterface $this
     */
    public function addGroup($groupName)
    {
        if (true === is_string($groupName) && false === in_array($groupName, $this->groups)) {
            $this->groups[] = $groupName;
        }
        return $this;
    }

    /**
     * Removes a group from the list of group names that should be enabled for this feature
     * @param string $groupName
     * @return RolloutableInterface $this
     */
    public function removeGroup($groupName)
    {
        if (true === is_string($groupName) && true === in_array($groupName, $this->groups)) {
            foreach (array_keys($this->groups, (string)$groupName, true) as $key) {
                unset($this->groups[$key]);
            }
        }
        return $this;
    }

    /**
     * Checks the user IDs and returns only the valid ones
     * @param array $userIds
     * @return array $checkedUserIds
     */
    protected function checkUserIds(array $userIds)
    {
        $checkedUserIds = array();
        foreach ($userIds as $userId) {
            if (true === is_numeric($userId) && false === in_array($userId, $checkedUserIds)) {
                $checkedUserIds[] = (int)$userId;
            }
        }
        return $checkedUserIds;
    }

    /**
     * Checks the roles and returns only the valid ones
     * @param array $roles
     * @return array $checkedRoles
     */
    protected function checkRoles(array $roles)
    {
        $checkedRoles = array();
        foreach ($roles as $role) {
            if (true === is_string($role) && false === in_array($role, $checkedRoles)) {
                $checkedRoles[] = (string)$role;
            }
        }
        return $checkedRoles;
    }

    /**
     * Checks the groups and returns only the valid ones
     * @param array $groups
     * @return array $checkedGroups
     */
    protected function checkGroups(array $groups)
    {
        $checkedGroups = array();
        foreach ($groups as $group) {
            if (true === is_string($group) && false === in_array($group, $checkedGroups)) {
                $checkedGroups[] = (string)$group;
            }
        }
        return $checkedGroups;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return ''
            . $this->getPercentage()
            . self::FEATURE_CONFIGSTRING_SECTION_DELIMITER
            . implode(self::FEATURE_CONFIGSTRING_ENTRY_DELIMITER, $this->getUsers())
            . self::FEATURE_CONFIGSTRING_SECTION_DELIMITER
            . implode(self::FEATURE_CONFIGSTRING_ENTRY_DELIMITER, $this->getRoles())
            . self::FEATURE_CONFIGSTRING_SECTION_DELIMITER
            . implode(self::FEATURE_CONFIGSTRING_ENTRY_DELIMITER, $this->getGroups())
        ;
    }

} 