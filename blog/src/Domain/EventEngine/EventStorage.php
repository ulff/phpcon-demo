<?php

namespace Domain\EventEngine;

interface EventStorage
{
    /**
     * @param Aggregate $aggregate
     */
    public function add(Aggregate $aggregate);

    /**
     * @param AggregateId $aggregateId
     * @return DomainEvent[]
     */
    public function find(AggregateId $aggregateId);
}
