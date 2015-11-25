<?php

namespace Domain\ReadModel\Projection;

use Domain\EventModel\AggregateId;
use Domain\ReadModel\Projection;

class PostListProjection implements Projection
{
    /**
     * @var string
     */
    private $projectionName;

    /**
     * @var AggregateId
     */
    private $aggregateId;

    /**
     * @var string
     */
    public $title;

    /**
     * @var \DateTime
     */
    public $publishingDate;

    /**
     * @param AggregateId $aggregateId
     */
    public function __construct(AggregateId $aggregateId, $title, \DateTime $publishingDate)
    {
        $this->projectionName = 'post-list';
        $this->aggregateId = $aggregateId;
        $this->title = $title;
        $this->publishingDate = $publishingDate;
    }

    /**
     * @return string
     */
    public function getProjectionName()
    {
        return $this->projectionName;
    }

    /**
     * @return AggregateId
     */
    public function getAggregateId()
    {
        return $this->aggregateId;
    }
}
