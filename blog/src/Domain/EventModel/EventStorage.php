<?php

namespace Domain\EventModel;

interface EventStorage
{
    /**
     * @param EventBased $eventBased
     */
    public function add(EventBased $eventBased);

    /**
     * @param AggregateId $aggregateId
     * @return AggregateHistory[]
     */
    public function find(AggregateId $aggregateId);
}
