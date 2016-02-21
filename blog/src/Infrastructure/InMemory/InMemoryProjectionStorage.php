<?php

namespace Infrastructure\InMemory;

use Domain\EventEngine\AggregateId;
use Domain\ReadModel\Projection;
use Domain\ReadModel\ProjectionStorage;
use Everzet\PersistedObjects\AccessorObjectIdentifier;
use Everzet\PersistedObjects\InMemoryRepository;

class InMemoryProjectionStorage implements ProjectionStorage
{
    private $repo;

    public function __construct()
    {
        $this->repo = new InMemoryRepository(new AccessorObjectIdentifier('getAggregateId'));
    }

    /**
     * @param Projection $projection
     */
    public function save(Projection $projection)
    {
        $this->repo->save($projection);
    }

    /**
     * @param Projection $projection
     */
    public function remove(Projection $projection)
    {
        $projection = $this->repo->findById($projection->getAggregateId());
        $this->repo->remove($projection);
    }

    /**
     * @param $projectionName
     * @return Projection[]
     */
    public function find($projectionName)
    {
        $projections = [];
        /** @var $projection Projection */
        foreach($this->repo->getAll() as $projection) {
            if($projection->getProjectionName() == $projectionName) {
                $projections[] = $projection;
            }
        }

        return $projections;
    }

    /**
     * @param string $projectionName
     * @param AggregateId $aggregateId
     * @return Projection
     */
    public function findById($projectionName, AggregateId $aggregateId)
    {
        /** @var $projection Projection */
        foreach($this->repo->getAll() as $projection) {
            if($projection->getProjectionName() == $projectionName && $projection->getAggregateId() == $aggregateId) {
                return $projection;
            }
        }

        return null;
    }
}
