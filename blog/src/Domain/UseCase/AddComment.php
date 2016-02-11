<?php

namespace Domain\UseCase;

use Domain\Aggregate\Comment;
use Domain\EventEngine\EventBus;
use Domain\EventEngine\EventStorage;
use Domain\UseCase\AddComment\Command;
use Domain\UseCase\AddComment\Responder;

class AddComment
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
        $comment = Comment::create(
            $command->getPostId(),
            $command->getAuthor(),
            $command->getContent()
        );
        try {
            $this->eventBus->dispatch($comment->getEvents());
            $this->eventStorage->add($comment);
        } catch(\Exception $e) {
            $responder->commentAddingFailed($e);
        }

        $responder->commentAddedSuccessfully($comment);
    }
}
