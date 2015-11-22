<?php

namespace Domain\UseCase\AddComment;

use Domain\Entity\Comment;
use Domain\Entity\Post;

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
