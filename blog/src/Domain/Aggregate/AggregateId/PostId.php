<?php

namespace Domain\Aggregate\AggregateId;

use Domain\EventEngine\AggregateId;

class PostId implements AggregateId
{
    private $postId;

    public function __construct($postId)
    {
        $this->postId = $postId;
    }

    public static function fromString($string)
    {
        $postId = new self($string);

        return $postId;
    }

    public function __toString()
    {
        return $this->postId;
    }

    public static function generate()
    {
        $random = md5(mt_rand(time()-10, time()) . 'post');

        return self::fromString($random);
    }
}
