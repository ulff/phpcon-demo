<?php

namespace Domain\ReadModel;

use Domain\EventEngine\EventBus;
use Domain\EventEngine\DomainEvent;

abstract class AbstractDomainEventListener implements DomainEventListener
{
    /**
     * @var ProjectionStorage
     */
    protected $projectionStorage;

    /**
     * @param EventBus $eventBus
     * @param ProjectionStorage $projectionStorage
     */
    public function __construct(EventBus $eventBus, ProjectionStorage $projectionStorage)
    {
        $eventBus->registerListener($this);
        $this->projectionStorage = $projectionStorage;
    }

    /**
     * @param DomainEvent $event
     */
    public function when(DomainEvent $event)
    {
        $method = explode('\\', get_class($event));
        $method = 'on' . end($method);
        if (method_exists($this, $method)) {
            $this->$method($event);
        }
    }
}
