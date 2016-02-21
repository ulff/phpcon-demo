<?php

namespace Domain\EventEngine;

interface Aggregate
{
    /**
     * @return DomainEvent[]
     */
    public function getEvents();

    /**
     * @return AggregateId
     */
    public function getAggregateId();

    /**
     * @return Aggregate
     */
    public static function reconstituteFrom(AggregateHistory $aggregateHistory);
}
