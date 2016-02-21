<?php

namespace Domain\ReadModel\Populator;

use Domain\ReadModel\ProjectionPopulator;

class PostListPopulator extends ProjectionPopulator
{
    const PROJECTION_NAME = 'post-list';

    public function getProjectionName()
    {
        return self::PROJECTION_NAME;
    }
}
