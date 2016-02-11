<?php

namespace Domain\UseCase\AddComment;

use Domain\Aggregate\AggregateId\PostId;

class Command
{
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
     * @param PostId $postId
     * @param string $author
     * @param string $content
     */
    function __construct(PostId $postId, $author, $content)
    {
        $this->postId = $postId;
        $this->author = $author;
        $this->content = $content;
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
}
