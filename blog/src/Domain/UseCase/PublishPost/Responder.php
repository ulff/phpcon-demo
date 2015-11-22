<?php

namespace Domain\UseCase\PublishPost;

use Domain\Entity\Post;

interface Responder
{
    /**
     * @param Post $post
     */
    public function postPublishedSuccessfully(Post $post);

    /**
     * @param \Exception $e
     */
    public function postPublishingFailed(\Exception $e);
}
