<?php

namespace Infrastructure\ODM\Document;

use Domain\ReadModel\Projection;

class StoredProjection implements Projection
{
    private $id;
    private $projectionName;
    private $aggregateId;
    private $projection;
    private $updatedAt;

    public function __construct($projectionName, $aggregateId, $projection)
    {
        $this->id = $projectionName . '_' . $aggregateId;
        $this->projectionName = $projectionName;
        $this->aggregateId = $aggregateId;
        $this->projection = serialize($projection);
        $this->updatedAt = new \DateTime();
    }

    public function getProjection()
    {
        return unserialize($this->projection);
    }

    public function getProjectionName()
    {
        return $this->projectionName;
    }

    public function getAggregateId()
    {
        return $this->aggregateId;
    }
}