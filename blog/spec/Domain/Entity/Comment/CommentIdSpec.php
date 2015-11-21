<?php

namespace spec\Domain\Entity\Comment;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommentIdSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(Argument::type('Domain\Entity\Comment\CommentId'));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Domain\Entity\Comment\CommentId');
    }
}
