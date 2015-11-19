<?php

namespace Domain\Model;

use Domain\Model\Comment\CommentId;
use Domain\Model\Post\PostId;

class Comment
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
     * @param PostId $postId
     * @param string $author
     * @param string $content
     * @return Comment
     */
    public static function add(PostId $postId, $author, $content)
    {
        $comment = new self(CommentId::generate(), $postId);
        $comment->setAuthor($author);
        $comment->setContent($content);
        $comment->setCreatingDate(new \DateTime());

        return $comment;
    }
}
