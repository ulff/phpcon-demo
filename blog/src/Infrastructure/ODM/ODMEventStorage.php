<?php

namespace Infrastructure\ODM;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Domain\EventEngine\AggregateId;
use Domain\EventEngine\DomainEvent;
use Domain\EventEngine\Aggregate;
use Domain\EventEngine\EventStorage;
use Infrastructure\ODM\Document\StoredEvent;

class ODMEventStorage implements EventStorage
{
    /**
     * @var DocumentManager
     */
    private $manager;

    /**
     * @var DocumentRepository
     */
    private $repository;

    public function __construct(DocumentManager $manager, ManagerRegistry $managerRegistry)
    {
        $this->manager = $manager;
        $this->repository = $managerRegistry->getRepository('\Infrastructure\ODM\Document\StoredEvent');
    }

    /**
     * @param Aggregate $aggregate
     */
    public function add(Aggregate $aggregate)
    {
        foreach($aggregate->getEvents() as $event) {
            $storedEvent = new StoredEvent($aggregate->getAggregateId(), get_class($event), $event);
            $this->manager->persist($storedEvent);
        }
        $this->manager->flush();
    }

    /**
     * @param AggregateId $aggregateId
     * @return DomainEvent[]
     */
    public function find(AggregateId $aggregateId)
    {
        $events = [];
        /** @var $storedEvent StoredEvent */
        $storedEvents = $this->repository->findBy(['aggregateId' => (string) $aggregateId]);
        foreach ($storedEvents as $storedEvent) {
            $events[] = $storedEvent->getEvent();
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
        $storedEvents = $this->repository->findAll();
        foreach ($storedEvents as $storedEvent) {
            $events[] = $storedEvent->getEvent();
        }

        return $events;
    }
}
