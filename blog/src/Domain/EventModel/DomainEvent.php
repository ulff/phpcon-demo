<?php

namespace Domain\EventModel;

interface DomainEvent
{
    /**
     * @return AggregateId
     */
    public function getAggregateId();
}
