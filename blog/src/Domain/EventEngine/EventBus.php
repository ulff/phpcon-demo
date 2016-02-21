<?php

namespace Domain\EventEngine;

use Domain\ReadModel\DomainEventListener;

class EventBus
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
    public function dispatch(array $events)
    {
        /** @var DomainEvent $event */
        foreach ($events as $event) {
            /** @var DomainEventListener $listener */
            foreach ($this->listeners as $listener) {
                $listener->when($event);
            }
        }
    }
}
