<?php

namespace Infrastructure\InMemory;

use Domain\EventEngine\AggregateId;
use Domain\EventEngine\DomainEvent;
use Domain\EventEngine\EventStorage;
use Domain\EventEngine\Aggregate;
use Everzet\PersistedObjects\AccessorObjectIdentifier;
use Everzet\PersistedObjects\InMemoryRepository;
use Infrastructure\InMemory\Document\StoredEvent;

class InMemoryEventStorage implements EventStorage
{
    private $repo;

    public function __construct()
    {
        $this->repo = new InMemoryRepository(new AccessorObjectIdentifier('getAggregateId'));
    }

    /**
     * @param Aggregate $aggregate
     */
    public function add(Aggregate $aggregate)
    {
        foreach($aggregate->getEvents() as $event) {
            $storedEvent = new StoredEvent($aggregate->getAggregateId(), get_class($event), $event);
            $this->repo->save($storedEvent);
        }
    }

    /**
     * @param AggregateId $aggregateId
     * @return DomainEvent[]
     */
    public function find(AggregateId $aggregateId)
    {
        $events = [];
        /** @var $storedEvent StoredEvent */
        foreach($this->repo->getAll() as $storedEvent) {
            if($storedEvent->getAggregateId() == $aggregateId) {
                $events[] = $storedEvent->getEvent();
            }
        }

        return $events;
    }

    /**
     * @return DomainEvent[]
     */
    public function getAll()
    {
        $events = [];
        /** @var $storedEvent StoredEvent */
        foreach($this->repo->getAll() as $storedEvent) {
            $events[] = $storedEvent->getEvent();
        }

        return $events;
    }

}