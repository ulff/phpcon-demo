<?php

namespace Domain\EventModel;

trait EventSourced
{
    /**
     * @var $events DomainEvent[]
     */
    protected $events = [];

    /**
     * @return DomainEvent[]
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param DomainEvent $event
     */
    protected function recordThat(DomainEvent $event)
    {
        $this->events[] = $event;
    }

    /**
     * @param DomainEvent $event
     */
    private function apply(DomainEvent $event)
    {
        $method = explode('\\', get_class($event));
        $method = 'apply' . end($method);
        $this->$method($event);
    }

    /**
     * @return AggregateId
     */
    abstract public function getAggregateId();

    public static function create()
    {
        throw new \Exception('Method create was not implemented in class: '.self::class);
    }

    public static function reconstituteFrom()
    {
        throw new \Exception('Method reconstituteFrom was not implemented in class: '.self::class);
    }
}
