<?php

namespace spec\Domain\Model\Comment;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommentIdSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(Argument::type('Domain\Model\Comment\CommentId'));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Domain\Model\Comment\CommentId');
    }
}
