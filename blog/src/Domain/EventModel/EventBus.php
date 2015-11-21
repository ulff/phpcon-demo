<?php

namespace Domain\EventModel;

use Domain\EventModel\DomainEvent;
use Domain\ReadModel\DomainEventListener;

final class EventBus
{
    /**
     * @var $listeners DomainEventListener[]
     */
    private $listeners = [];

    public function registerListener(DomainEventListener $domainEventListener)
    {
        $this->listeners[] = $domainEventListener;
    }

    /**
     * @param $events DomainEvent[]
     */
    public function dispatch($events)
    {
        foreach ($events as $event) {
            foreach ($this->listeners as $listener) {
                $listener->when($event);
            }
        }

        return $this;
    }
}
