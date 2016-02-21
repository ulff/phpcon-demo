<?php

namespace Domain\ReadModel;

use Domain\EventEngine\AggregateId;

interface Projection
{
    /**
     * @return string
     */
    public function getProjectionName();

    /**
     * @return AggregateId
     */
    public function getAggregateId();
}
