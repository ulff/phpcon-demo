<?php

namespace Domain\UseCase;

use Domain\EventEngine\EventBus;
use Domain\EventEngine\EventStorage;
use Domain\ReadModel\ProjectionStorage;
use Domain\UseCase\ListPosts\Command;
use Domain\UseCase\ListPosts\Responder;

class ListPosts 
{
    /**
     * @var ProjectionStorage
     */
    private $projectionStorage;

    /**
     * @param ProjectionStorage $projectionStorage
     */
    public function __construct(ProjectionStorage $projectionStorage)
    {
        $this->projectionStorage = $projectionStorage;
    }

    public function execute(Command $command, Responder $responder)
    {
        $projections = $this->projectionStorage->find('post-list');
        $responder->postsListedSuccessfully($projections);
    }
}
