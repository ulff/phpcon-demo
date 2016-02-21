<?php

namespace Domain\UseCase\ListPosts;

use Domain\ReadModel\Projection\PostListProjection;

interface Responder
{
    /**
     * @param PostListProjection[] $projections
     */
    public function postsListedSuccessfully(array $projections);
}
