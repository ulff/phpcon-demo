<?php

namespace AppBundle\Entity;

use Domain\ReadModel\Projection;

class PostListItem implements FromProjection
{
    public $postId;
    public $title;
    public $publishingDate;

    public function __construct($postId, $title, $publishingDate)
    {
        $this->postId = $postId;
        $this->title = $title;
        $this->publishingDate = $publishingDate;
    }

    /**
     * @param Projection $projection
     * @return FromProjection
     */
    public static function createFromProjection(Projection $projection)
    {
        /** @var $projection Projection\PostListProjection */
        return new self(
            (string) $projection->getAggregateId(),
            $projection->getTitle(),
            $projection->getPublishingDate()->format('Y-m-d H:i:s')
        );
    }

    /**
     * @return string
     */
    public function getId()
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
    public function getPublishingDate()
    {
        return $this->publishingDate;
    }

}
