<?php

namespace Domain\Event;

use Domain\Aggregate\AggregateId\PostId;
use Domain\EventEngine\DomainEvent;

class PostWasUpdated implements DomainEvent
{
    /**
     * @var PostId
     */
    private $postId;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
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