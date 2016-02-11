<?php

namespace Domain\Aggregate\AggregateId;

use Domain\EventEngine\AggregateId;

class CommentId implements AggregateId
{
    private $commentId;

    public function __construct($commentId)
    {
        $this->commentId = $commentId;
    }

    public static function fromString($string)
    {
        $commentId = new self($string);

        return $commentId;
    }

    public function __toString()
    {
        return $this->commentId;
    }

    public static function generate()
    {
        $random = md5(mt_rand(time()-10, time()) . 'comment');

        return self::fromString($random);
    }
}
