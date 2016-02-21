<?php

namespace Domain\Aggregate;

use Domain\Aggregate\AggregateId\CommentId;
use Domain\Aggregate\AggregateId\PostId;
use Domain\AggregateHistory\CommentAggregateHistory;
use Domain\EventEngine\AggregateHistory;
use Domain\EventEngine\DomainEvent;
use Domain\Event\CommentWasAdded;
use Domain\EventEngine\Aggregate;
use Domain\EventEngine\EventSourced;

class Comment implements Aggregate
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
     */
    public function __construct(CommentId $commentId)
    {
        $this->commentId = $commentId;
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
    private function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @param string $author
     */
    private function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @param \DateTime $creatingDate
     */
    private function setCreatingDate($creatingDate)
    {
        $this->creatingDate = $creatingDate;
    }

    /**
     * @param PostId $postId
     */
    private function setPostId($postId)
    {
        $this->postId = $postId;
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
        $this->setPostId($event->getPostId());
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
        $comment = new self($commentId = CommentId::generate());
        $comment->setPostId($postId);
        $comment->setAuthor($author);
        $comment->setContent($content);
        $comment->setCreatingDate($creatingDate = new \DateTime());
        $comment->recordThat(new CommentWasAdded($commentId, $postId, $author, $content, $creatingDate));

        return $comment;
    }

    /**
     * @param CommentAggregateHistory $commentAggregateHistory
     * @return Post
     */
    public static function reconstituteFrom(AggregateHistory $commentAggregateHistory)
    {
        $commentId = $commentAggregateHistory->getAggregateId();
        $comment = new self($commentId);
        $events = $commentAggregateHistory->getEvents();

        foreach ($events as $event) {
            $applyMethod = explode('\\', get_class($event));
            $applyMethod = 'apply' . end($applyMethod);
            $comment->$applyMethod($event);
        }

        return $comment;
    }
}
