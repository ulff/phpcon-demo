<?php

namespace Domain\EventModel;

interface EventBased
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
