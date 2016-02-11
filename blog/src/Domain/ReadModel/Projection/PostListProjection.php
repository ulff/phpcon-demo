<?php

namespace Domain\ReadModel\Projection;

use Domain\Aggregate\AggregateId\PostId;
use Domain\ReadModel\Projection;

class PostListProjection implements Projection
{
    const PROJECTION_NAME = 'post-list';

    /**
     * @var PostId
     */
    private $postId;

    /**
     * @var string
     */
    public $title;

    /**
     * @var \DateTime
     */
    public $publishingDate;

    /**
     * @param PostId $postId
     */
    public function __construct(PostId $postId, $title, \DateTime $publishingDate)
    {
        $this->postId = $postId;
        $this->title = $title;
        $this->publishingDate = $publishingDate;
    }

    /**
     * @return string
     */
    public function getProjectionName()
    {
        return self::PROJECTION_NAME;
    }

    /**
     * @return PostId
     */
    public function getAggregateId()
    {
        return $this->postId;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return \DateTime
     */
    public function getPublishingDate()
    {
        return $this->publishingDate;
    }
}
