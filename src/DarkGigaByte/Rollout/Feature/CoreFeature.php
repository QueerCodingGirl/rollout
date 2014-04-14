<?php

namespace DarkGigaByte\Rollout\Feature;

/**
 * Class CoreFeature
 * @package DarkGigaByte\Rollout\Feature
 */
class CoreFeature extends FeatureAbstract
{

    /**
     * @param string $name A unique name for this feature.
     * @param string|null $configString For the format definition see RolloutableInterface::configureByConfigString()
     */
    public function __construct($name, $configString = null)
    {
        $this->name = $name;
        $this->clearConfig();
        if (null !== $configString) {
            $this->configureByConfigString($configString);
        }
    }
}