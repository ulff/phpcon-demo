<?php

namespace Domain\EventModel\Event;

use Domain\Entity\Post\PostId;
use Domain\EventModel\DomainEvent;

class PostWasPublished implements DomainEvent
{
    private $postId;

    private $title;

    private $content;

    private $publishingDate;

    /**
     * @param PostId $postId
     * @param string $title
     * @param string $content
     * @param \DateTime $publishingDate
     */
    public function __construct(PostId $postId, $title, $content, \DateTime $publishingDate)
    {
        $this->postId = $postId;
        $this->title = $title;
        $this->content = $content;
        $this->publishingDate = $publishingDate;
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
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return \DateTime
     */
    public function getPublishingDate()
    {
        return $this->publishingDate;
    }
}
