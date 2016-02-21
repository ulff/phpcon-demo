<?php

namespace Infrastructure\ODM\Document;

class StoredEvent
{
    private $id;
    private $aggregateId;
    private $aggregateClass;
    private $event;
    private $createdAt;

    public function __construct($aggregateId, $aggregateClass, $event)
    {
        $this->aggregateId = $aggregateId;
        $this->aggregateClass = $aggregateClass;
        $this->event = serialize($event);
        $this->createdAt = new \DateTime();
    }

    public function getEvent()
    {
        return unserialize($this->event);
    }

    public function getAggregateId()
    {
        return $this->aggregateId;
    }
}