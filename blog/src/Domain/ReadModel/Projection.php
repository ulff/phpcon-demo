<?php

namespace Domain\ReadModel;

use Domain\EventModel\AggregateId;

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
