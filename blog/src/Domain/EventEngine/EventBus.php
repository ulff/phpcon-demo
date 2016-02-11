<?php

namespace Domain\EventEngine;

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
        /** @var DomainEvent $event */
        foreach ($events as $event) {
            /** @var DomainEventListener $listener */
            foreach ($this->listeners as $listener) {
                $listener->when($event);
            }
        }

        return $this;
    }
}
