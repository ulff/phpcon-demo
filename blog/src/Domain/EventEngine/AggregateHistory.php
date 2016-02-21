<?php

namespace Domain\EventEngine;

interface AggregateHistory
{
    /**
     * @return DomainEvent[]
     */
    public function getEvents();

    /**
     * @return AggregateId
     */
    public function getAggregateId();
}
