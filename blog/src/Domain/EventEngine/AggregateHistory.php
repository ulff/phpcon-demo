<?php

namespace Domain\EventEngine;

abstract class AggregateHistory
{
    /**
     * @var $aggregateId AggregateId
     */
    protected $aggregateId;

    /**
     * @var $events DomainEvent[]
     */
    protected $events;

    /**
     * @param AggregateId $aggregateId
     * @param EventStorage $eventStorage
     */
    public function __construct(AggregateId $aggregateId, EventStorage $eventStorage)
    {
        $this->aggregateId = $aggregateId;
        $this->events = $this->events = $eventStorage->find($aggregateId);
    }

    /**
     * @return AggregateId
     */
    public function getAggregateId()
    {
        return $this->aggregateId;
    }

    /**
     * @return DomainEvent[]
     */
    public function getEvents()
    {
        return $this->events;
    }
}
