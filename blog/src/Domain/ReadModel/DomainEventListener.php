<?php

namespace Domain\ReadModel;

use Domain\EventModel\DomainEvent;

interface DomainEventListener
{
    /**
     * @param DomainEvent $event
     */
    public function when(DomainEvent $event);
}
