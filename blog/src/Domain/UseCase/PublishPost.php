<?php

namespace Domain\UseCase;

use Domain\Aggregate\Post;
use Domain\EventEngine\EventBus;
use Domain\EventEngine\EventStorage;
use Domain\UseCase\PublishPost\Command;
use Domain\UseCase\PublishPost\Responder;

class PublishPost
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
        $post = Post::create(
            $command->getTitle(),
            $command->getContent()
        );
        try {
            $this->eventBus->dispatch($post->getEvents());
            $this->eventStorage->add($post);
        } catch(\Exception $e) {
            $responder->postPublishingFailed($e);
        }

        $responder->postPublishedSuccessfully($post);
    }
}
