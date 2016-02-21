<?php

namespace Domain\ReadModel;

use Domain\EventEngine\EventStorage;

abstract class ProjectionPopulator
{
    /**
     * @var EventStorage
     */
    private $eventStorage;

    /**
     * @var BulkProjectionStorage
     */
    private $projectionStorage;

    /**
     * @var DomainEventListener
     */
    private $listener;

    /**
     * @var ProjectionPopulatorStats
     */
    private $stats;

    /**
     * @param EventStorage $eventStorage
     * @param BulkProjectionStorage $projectionStorage
     * @param DomainEventListener $listener
     */
    public function __construct(
        EventStorage $eventStorage,
        BulkProjectionStorage $projectionStorage,
        DomainEventListener $listener
    ) {
        $this->eventStorage = $eventStorage;
        $this->projectionStorage = $projectionStorage;
        $this->listener = $listener;

        $this->stats = new ProjectionPopulatorStats();
    }

    public function getStats()
    {
        return $this->stats;
    }

    public function run()
    {
        $this->clear();
        $this->populate();
    }

    public function clear()
    {
        $projections = $this->projectionStorage->find($this->getProjectionName());
        foreach ($projections as $projection) {
            $this->projectionStorage->remove($projection);
            $this->stats->increaseRemoved();
        }
        $this->projectionStorage->flush();
    }

    abstract protected function getProjectionName();

    private function populate()
    {
        $events = $this->eventStorage->getAll();
        foreach ($events as $event) {
            $this->stats->increaseTotalEvents();
            $eventClass = explode('\\', get_class($event));
            $method = 'on'.end($eventClass);
            if (method_exists($this->listener, $method)) {
                $this->listener->when($event);
                $this->stats->increaseProcessedEvents();
            }
        }
        $this->projectionStorage->flush();
        $this->stats->setPopulatedProjections(count($this->projectionStorage->find(static::getProjectionName())));
    }
}