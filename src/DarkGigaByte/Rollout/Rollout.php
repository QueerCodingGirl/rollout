<?php

namespace DarkGigaByte\Rollout;
use DarkGigaByte\Rollout\Feature\FeatureFactoryAbstract;
use DarkGigaByte\Rollout\Interfaces\KeyValueStorageInterface;

/**
 * Class Rollout
 * @package DarkGigaByte\Rollout
 */
class Rollout extends RolloutAbstract {

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