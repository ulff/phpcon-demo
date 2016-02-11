<?php

namespace Domain\UseCase\AddComment;

use Domain\Aggregate\Comment;
use Domain\Aggregate\Post;

interface Responder
{
    /**
     * @param Comment $comment
     */
    public function commentAddedSuccessfully(Comment $comment);

    /**
     * @param \Exception $e
     */
    public function commentAddingFailed(\Exception $e);
}
