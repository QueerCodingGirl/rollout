<?php

namespace DarkGigaByte\Rollout\Feature;


use DarkGigaByte\Rollout\Interfaces\RolloutableInterface;

/**
 * Class FeatureFactory
 * @package DarkGigaByte\Rollout\Feature
 */
class FeatureFactory extends FeatureFactoryAbstract
{
    /**
     * @param string $featureName
     * @param string|null $featureConfigString
     * @return RolloutableInterface
     */
    public function getFeature($featureName, $featureConfigString = null)
    {
        return new CoreFeature($featureName, $featureConfigString);
    }

}