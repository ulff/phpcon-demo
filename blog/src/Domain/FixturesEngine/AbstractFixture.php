<?php

namespace Domain\FixturesEngine;

use Domain\EventEngine\EventBus;
use Domain\EventEngine\EventStorage;
use Domain\ReadModel\ProjectionStorage;

class AbstractFixture
{
    /**
     * @var EventBus
     */
    protected $eventBus;

    /**
     * @var EventStorage
     */
    protected $eventStorage;

    /**
     * @var ProjectionStorage
     */
    protected $projectionStorage;

    public function __construct(EventBus $eventBus, EventStorage $eventStorage, ProjectionStorage $projectionStorage)
    {
        $this->eventBus = $eventBus;
        $this->eventStorage = $eventStorage;
        $this->projectionStorage = $projectionStorage;
    }
}
