<?php

namespace Domain\UseCase\UpdatePost;

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
    function __construct(PostId $postId, $title, $content)
    {
        $this->postId = $postId;
        $this->title = $title;
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
