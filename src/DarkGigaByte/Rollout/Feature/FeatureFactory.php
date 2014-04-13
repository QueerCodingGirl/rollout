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
     * @param $featureName
     * @param string|null $featureConfigString
     * @return \DarkGigaByte\Rollout\Interfaces\RolloutableInterface
     */
    public function getFeature($featureName, $featureConfigString = null)
    {
        return new CoreFeature($featureName, $featureConfigString);
    }


} 