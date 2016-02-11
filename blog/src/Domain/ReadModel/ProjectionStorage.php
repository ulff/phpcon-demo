<?php

namespace Domain\ReadModel;

use Domain\EventEngine\AggregateId;

interface ProjectionStorage
{
    /**
     * @param Projection $projection
     */
    public function save(Projection $projection);

    /**
     * @param Projection $projection
     */
    public function remove(Projection $projection);

    /**
     * @param string $projectionName
     * @return Projection[]
     */
    public function find($projectionName);

    /**
     * @param string $projectionName
     * @param AggregateId $aggregateId
     * @return Projection
     */
    public function findById($projectionName, AggregateId $aggregateId);
}
