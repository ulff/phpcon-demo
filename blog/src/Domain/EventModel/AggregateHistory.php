<?php

namespace Domain\EventModel;

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
     * @param DomainEvent[] $events
     */
    public function __construct(AggregateId $aggregateId, array $events)
    {
        $this->aggregateId = $aggregateId;
        $this->events = $events;
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
