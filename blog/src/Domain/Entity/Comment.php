<?php

namespace Domain\Entity;

use Domain\Entity\Comment\CommentId;
use Domain\Entity\Post\PostId;
use Domain\EventModel\AggregateHistory\CommentAggregateHistory;
use Domain\EventModel\DomainEvent;
use Domain\EventModel\Event\CommentWasAdded;
use Domain\EventModel\EventBased;
use Domain\EventModel\EventSourced;

class Comment implements EventBased
{
    use EventSourced;

    /**
     * @var CommentId
     */
    private $commentId;

    /**
     * @var PostId
     */
    private $postId;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $author;

    /**
     * @var \DateTime
     */
    private $creatingDate;

    /**
     * @param CommentId $commentId
     * @param PostId $postId
     */
    public function __construct(CommentId $commentId, PostId $postId)
    {
        $this->commentId = $commentId;
        $this->postId = $postId;
    }

    /**
     * @return PostId
     */
    public function getPostId()
    {
        return $this->postId;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return \DateTime
     */
    public function getCreatingDate()
    {
        return $this->creatingDate;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @param string $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @param \DateTime $creatingDate
     */
    public function setCreatingDate($creatingDate)
    {
        $this->creatingDate = $creatingDate;
    }

    /**
     * @return CommentId
     */
    public function getAggregateId()
    {
        return $this->commentId;
    }

    private function applyCommentWasAdded(CommentWasAdded $event)
    {
        $this->setAuthor($event->getAuthor());
        $this->setContent($event->getContent());
        $this->setCreatingDate($event->getCreatingDate());
    }

    /**
     * @param PostId $postId
     * @param string $author
     * @param string $content
     * @return Comment
     */
    public static function create(PostId $postId, $author, $content)
    {
        $comment = new self($commentId = CommentId::generate(), $postId);
        $comment->setAuthor($author);
        $comment->setContent($content);
        $comment->setCreatingDate($creatingDate = new \DateTime());
        $comment->recordThat(new CommentWasAdded($commentId, $postId, $author, $content, $creatingDate));

        return $comment;
    }

    /**
     * @param CommentAggregateHistory $aggregateHistory
     * @return Post
     */
    public static function reconstituteFrom(CommentAggregateHistory $aggregateHistory, PostId $postId)
    {
        $commentId = $aggregateHistory->getAggregateId();
        $comment = new self($commentId, $postId);
        $events = $aggregateHistory->getEvents();

        foreach ($events as $event) {
            $applyMethod = explode('\\', get_class($event));
            $applyMethod = 'apply' . end($applyMethod);
            $comment->$applyMethod($event);
        }

        return $comment;
    }
}
