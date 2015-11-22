<?php

namespace Infrastructure\InMemory;

use Domain\EventModel\AggregateId;
use Domain\EventModel\DomainEvent;
use Domain\EventModel\EventStorage;
use Domain\EventModel\EventBased;
use Everzet\PersistedObjects\AccessorObjectIdentifier;
use Everzet\PersistedObjects\InMemoryRepository;

class InMemoryEventStorage implements EventStorage
{
    private $repo;

    public function __construct()
    {
        $this->repo = new InMemoryRepository(new AccessorObjectIdentifier('getAggregateId'));
    }

    /**
     * @param EventBased $eventBased
     */
    public function add(EventBased $eventBased)
    {
        $this->repo->save($eventBased);
    }

    /**
     * @param AggregateId $aggregateId
     * @return DomainEvent[]
     */
    public function find(AggregateId $aggregateId)
    {
        $events = [];
        foreach($this->repo->getAll() as $storedEvent) {
            if($storedEvent->getAggregateId() == $aggregateId) {
                array_merge($events, $storedEvent->getEvents());
            }
        }

        return $events;
    }

}