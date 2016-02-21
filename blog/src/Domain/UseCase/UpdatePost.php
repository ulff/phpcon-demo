<?php

namespace Domain\UseCase;

use Domain\Aggregate\Post;
use Domain\AggregateHistory\PostAggregateHistory;
use Domain\EventEngine\EventBus;
use Domain\EventEngine\EventStorage;
use Domain\UseCase\UpdatePost\Command;
use Domain\UseCase\UpdatePost\Responder;

class UpdatePost
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
     * @param EventBus $eventBus
     * @param EventStorage $eventStorage
     */
    public function __construct(EventBus $eventBus, EventStorage $eventStorage)
    {
        $this->eventBus = $eventBus;
        $this->eventStorage = $eventStorage;
    }

    public function execute(Command $command, Responder $responder)
    {
        $postAggregateHistory = new PostAggregateHistory($command->getPostId(), $this->eventStorage);
        $post = Post::reconstituteFrom($postAggregateHistory);

        $post->update(
            $command->getTitle(),
            $command->getContent()
        );

        try {
            $this->eventBus->dispatch($post->getEvents());
            $this->eventStorage->add($post);
        } catch(\Exception $e) {
            $responder->postUpdatingFailed($e);
        }

        $responder->postUpdatedSuccessfully($post);
    }
}
