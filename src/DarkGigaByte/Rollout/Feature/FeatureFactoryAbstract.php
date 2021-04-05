<?php

namespace QueerCodingGirl\Rollout\Feature;


use QueerCodingGirl\Rollout\Interfaces\RolloutableInterface;

/**
 * Class FeatureFactoryAbstract
 * @package QueerCodingGirl\Rollout\Feature
 */
abstract class FeatureFactoryAbstract
{

    /**
     * @param $featureName
     * @param string|null $featureConfigString
     * @return RolloutableInterface
     */
    abstract public function getFeature($featureName, $featureConfigString = null);
}