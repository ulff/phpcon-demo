<?php

namespace Domain\UseCase\PublishPost;

class Command 
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * @param string $title
     * @param string $content
     */
    function __construct($title, $content)
    {
        $this->title = $title;
        $this->content = $content;
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
