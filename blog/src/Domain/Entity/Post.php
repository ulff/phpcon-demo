<?php

namespace Domain\Entity;

use Domain\Entity\Post\PostId;
use Domain\EventModel\AggregateHistory\PostAggregateHistory;
use Domain\EventModel\Event\PostWasPublished;
use Domain\EventModel\EventBased;
use Domain\EventModel\EventSourced;

class Post implements EventBased
{
    use EventSourced;

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
     * @var \DateTime
     */
    private $publishingDate;

    public function __construct(PostId $postId)
    {
        $this->postId = $postId;
    }

    public function getPostId()
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

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @param \DateTime $publishingDate
     */
    public function setPublishingDate($publishingDate)
    {
        $this->publishingDate = $publishingDate;
    }

    /**
     * @return PostId
     */
    public function getAggregateId()
    {
        return $this->postId;
    }

    private function applyPostWasPublished(PostWasPublished $event)
    {
        $this->setTitle($event->getTitle());
        $this->setContent($event->getContent());
        $this->setPublishingDate($event->getPublishingDate());
    }

    /**
     * @param string $title
     * @param string $content
     * @return Post
     */
    public static function create($title, $content)
    {
        $post = new self($postId = PostId::generate());
        $post->setTitle($title);
        $post->setContent($content);
        $post->setPublishingDate($publishingDate = new \DateTime());
        $post->recordThat(new PostWasPublished($postId, $title, $content, $publishingDate));

        return $post;
    }

    /**
     * @param PostAggregateHistory $aggregateHistory
     * @return Post
     */
    public static function reconstituteFrom(PostAggregateHistory $aggregateHistory)
    {
        $postId = $aggregateHistory->getAggregateId();
        $post = new self($postId);
        $events = $aggregateHistory->getEvents();

        foreach ($events as $event) {
            $applyMethod = explode('\\', get_class($event));
            $applyMethod = 'apply' . end($applyMethod);
            $post->$applyMethod($event);
        }

        return $post;
    }
}
