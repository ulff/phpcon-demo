<?php

namespace Domain\UseCase;

use Domain\EventModel\EventBus;
use Domain\EventModel\EventStorage;
use Domain\ReadModel\ProjectionStorage;
use Domain\UseCase\ListPosts\Command;
use Domain\UseCase\ListPosts\Responder;

class ListPosts 
{
    /**
     * @var EventBus
     */
    private $eventBus;

    /**
     * @var EventStorage
     */
    private $eventStorage;

    /**
     * @var ProjectionStorage
     */
    private $projectionStorage;

    /**
     * @param EventBus $eventBus
     * @param EventStorage $eventStorage
     * @param ProjectionStorage $projectionStorage
     */
    public function __construct(EventBus $eventBus, EventStorage $eventStorage, ProjectionStorage $projectionStorage)
    {
        $this->eventBus = $eventBus;
        $this->eventStorage = $eventStorage;
        $this->projectionStorage = $projectionStorage;
    }

    public function execute(Command $command, Responder $responder)
    {
        $projections = $this->projectionStorage->find('post-list');
        $responder->postsListedSuccessfully($projections);
    }
}
