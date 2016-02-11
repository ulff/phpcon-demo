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
     * @return DomainEvent[]
     */
    public function find(AggregateId $aggregateId);
}
