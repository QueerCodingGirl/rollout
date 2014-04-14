<?php

namespace DarkGigaByte\Rollout;


use DarkGigaByte\Rollout\Feature\FeatureFactoryAbstract;
use DarkGigaByte\Rollout\Feature\FeatureAbstract;
use DarkGigaByte\Rollout\Interfaces\DeterminableUserInterface;
use DarkGigaByte\Rollout\Interfaces\KeyValueStorageInterface;
use DarkGigaByte\Rollout\Interfaces\RolloutableInterface;

/**
 * Class RolloutAbstract
 * @package DarkGigaByte\Rollout
 */
abstract class RolloutAbstract
{
    /**
     * @var KeyValueStorageInterface
     */
    protected $storage;

    /**
     * @var FeatureFactoryAbstract
     */
    protected $featureFactory;

    /**
     * @param $featureName
     * @return FeatureAbstract
     */
    public function getFeature($featureName)
    {
        $featureConfigString = $this->storage->get($this->getKey($featureName));
        $feature = $this->featureFactory->getFeature($featureName);
        if (false === empty($featureConfigString)) {
            $feature->configureByConfigString($featureConfigString);
        }
        return $feature;
    }

    /**
     * Get all feature names
     * @return string[]
     */
    public function getFeatures()
    {
        $featuresString = $this->storage->get($this->getFeaturesKey());
        $features = explode(',', $featuresString);
        return $features;
    }

    /**
     * Saves a feature to the storage
     * @param RolloutableInterface $feature
     */
    protected function saveFeature(RolloutableInterface $feature)
    {
        $this->storage->set($this->getKey($feature->getName()), (string)$feature);
        $features = $this->getFeatures();
        if (false === in_array($feature->getName(), $features)) {
            $features[] = $feature->getName();
        }
        $this->storage->set($this->getFeaturesKey(), implode(',', $features));
    }

    /**
     * Get the storage key for a feature name
     * @param $featureName
     * @return string
     */
    protected function getKey($featureName)
    {
        return 'feature:' . $featureName;
    }

    /**
     * Get the storage key for all features (the feature list)
     * @return string
     */
    protected function getFeaturesKey()
    {
        return 'feature:__features__';
    }

    /**
     * Activates a feature (for everyone)
     * @param $featureName
     */
    public function activate($featureName)
    {
        $feature = $this->getFeature($featureName);
        $feature->setPercentage(100);
        $this->saveFeature($feature);
    }

    /**
     * Deactivates a feature (for everyone)
     * @param $featureName
     */
    public function deactivate($featureName)
    {
        $feature = $this->getFeature($featureName);
        $feature->clearConfig();
        $this->saveFeature($feature);
    }

    /**
     * Activates a feature for a specific role
     * @param $featureName
     * @param $roleName
     */
    public function activateRole($featureName, $roleName)
    {
        $feature = $this->getFeature($featureName);
        $feature->addRole($roleName);
        $this->saveFeature($feature);
    }

    /**
     * Deactivates a feature for a specific role.
     * @param $featureName
     * @param $roleName
     */
    public function deactivateRole($featureName, $roleName)
    {
        $feature = $this->getFeature($featureName);
        $feature->removeRole($roleName);
        $this->saveFeature($feature);
    }

    /**
     * Activates a feature for a specific group
     * @param $featureName
     * @param $groupName
     */
    public function activateGroup($featureName, $groupName)
    {
        $feature = $this->getFeature($featureName);
        $feature->addGroup($groupName);
        $this->saveFeature($feature);
    }

    /**
     * Deactivates a feature for a specific group.
     * @param $featureName
     * @param $groupName
     */
    public function deactivateGroup($featureName, $groupName)
    {
        $feature = $this->getFeature($featureName);
        $feature->removeGroup($groupName);
        $this->saveFeature($feature);
    }

    /**
     * Activates a feature for a specific user
     * @param $featureName
     * @param $userId
     */
    public function activateUser($featureName, $userId)
    {
        $feature = $this->getFeature($featureName);
        $feature->addUser($userId);
        $this->saveFeature($feature);
    }

    /**
     * Deactivates a feature for a specific user
     * @param $featureName
     * @param $userId
     */
    public function deactivateUser($featureName, $userId)
    {
        $feature = $this->getFeature($featureName);
        $feature->removeUser($userId);
        $this->saveFeature($feature);
    }

    /**
     * Activates a feature for a percentage of users
     * @param $featureName
     * @param $percentage
     */
    public function activatePercentage($featureName, $percentage)
    {
        $feature = $this->getFeature($featureName);
        $feature->setPercentage($percentage);
        $this->saveFeature($feature);
    }

    /**
     * Deactivates the percentage activation for a feature
     * @param $featureName
     */
    public function deactivatePercentage($featureName)
    {
        $feature = $this->getFeature($featureName);
        $feature->setPercentage(0);
        $this->saveFeature($feature);
    }

    /**
     * Checks if a feature is active
     * @param $featureName
     * @param DeterminableUserInterface $user
     * @return bool
     */
    public function isActive($featureName, DeterminableUserInterface $user = null)
    {
        $feature = $this->getFeature($featureName);
        return $feature->isActive($this, $user);
    }

    /**
     * Checks if a user has the given role
     * @param $roleName
     * @param DeterminableUserInterface $user
     * @return bool
     */
    public function userHasRole($roleName, DeterminableUserInterface $user)
    {
        $userHasRole = false;
        if (true === in_array($roleName, $user->getRoles())) {
            $userHasRole = true;
        }
        return $userHasRole;
    }

    /**
     * Checks if a user has the given group
     * @param $groupName
     * @param DeterminableUserInterface $user
     * @return bool
     */
    public function userHasGroup($groupName, DeterminableUserInterface $user)
    {
        $userHasGroup = false;
        if (true === in_array($groupName, $user->getGroups())) {
            $userHasGroup = true;
        }
        return $userHasGroup;
    }

} 