<?php

namespace Domain\EventModel\Event;

use Domain\Entity\Post\PostId;
use Domain\EventModel\DomainEvent;

class PostWasUpdated implements DomainEvent
{
    private $postId;

    private $title;

    private $content;

    /**
     * @param PostId $postId
     * @param string $title
     * @param string $content
     */
    public function __construct(PostId $postId, $title, $content)
    {
        $this->postId = $postId;
        $this->title = $title;
        $this->content = $content;
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
}