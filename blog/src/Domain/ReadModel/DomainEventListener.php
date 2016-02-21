<?php

namespace Domain\ReadModel;

use Domain\EventEngine\DomainEvent;

interface DomainEventListener
{
    /**
     * @param DomainEvent $event
     */
    public function when(DomainEvent $event);
}
