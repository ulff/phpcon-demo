<?php

namespace Domain\UseCase\UpdatePost;

use Domain\Aggregate\Post;

interface Responder
{
    /**
     * @param Post $post
     */
    public function postUpdatedSuccessfully(Post $post);

    /**
     * @param \Exception $e
     */
    public function postUpdatingFailed(\Exception $e);
}
