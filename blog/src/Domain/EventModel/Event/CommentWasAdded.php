<?php

namespace Domain\EventModel\Event;

use Domain\Entity\Comment\CommentId;
use Domain\Entity\Post\PostId;
use Domain\EventModel\DomainEvent;

class CommentWasAdded implements DomainEvent
{
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
    private $author;

    /**
     * @var string
     */
    private $content;

    /**
     * @var \DateTime
     */
    private $creatingDate;

    /**
     * @param CommentId $commentId
     * @param PostId $postId
     * @param $author
     * @param $content
     * @param \DateTime $creatingDate
     */
    function __construct(CommentId $commentId, PostId $postId, $author, $content, \DateTime $creatingDate)
    {
        $this->commentId = $commentId;
        $this->postId = $postId;
        $this->author = $author;
        $this->content = $content;
        $this->creatingDate = $creatingDate;
    }

    /**
     * @return CommentId
     */
    public function getAggregateId()
    {
        return $this->commentId;
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
    public function getAuthor()
    {
        return $this->author;
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
    public function getCreatingDate()
    {
        return $this->creatingDate;
    }
}
