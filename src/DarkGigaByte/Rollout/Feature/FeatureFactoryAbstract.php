<?php

namespace DarkGigaByte\Rollout\Feature;


use DarkGigaByte\Rollout\Interfaces\RolloutableInterface;

/**
 * Class FeatureFactoryAbstract
 * @package DarkGigaByte\Rollout\Feature
 */
abstract class FeatureFactoryAbstract {

    /**
     * @param $featureName
     * @param string|null $featureConfigString
     * @return RolloutableInterface
     */
    abstract public function getFeature($featureName, $featureConfigString = null);

} 