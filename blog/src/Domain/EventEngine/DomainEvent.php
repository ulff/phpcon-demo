<?php

namespace Domain\EventEngine;

interface DomainEvent
{
    /**
     * @return AggregateId
     */
    public function getAggregateId();
}
