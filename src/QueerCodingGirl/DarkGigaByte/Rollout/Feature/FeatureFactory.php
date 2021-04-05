<?php

namespace QueerCodingGirl\Rollout\Feature;


use QueerCodingGirl\Rollout\Interfaces\RolloutableInterface;

/**
 * Class FeatureFactory
 * @package QueerCodingGirl\Rollout\Feature
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