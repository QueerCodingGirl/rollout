<?php

namespace QueerCodingGirl\Rollout;

use QueerCodingGirl\Rollout\Feature\FeatureFactoryAbstract;
use QueerCodingGirl\Rollout\Interfaces\KeyValueStorageInterface;

/**
 * Class Rollout
 * @package QueerCodingGirl\Rollout
 */
class Rollout extends RolloutAbstract
{

    /**
     * @param KeyValueStorageInterface $storage
     * @param FeatureFactoryAbstract $featureFactory
     */
    public function __construct(KeyValueStorageInterface $storage, FeatureFactoryAbstract $featureFactory)
    {
        $this->storage = $storage;
        $this->featureFactory = $featureFactory;
    }
}