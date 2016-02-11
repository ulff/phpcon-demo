<?php

namespace spec\Domain\Aggregate\AggregateId;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommentIdSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(Argument::type('Domain\Aggregate\AggregateId\CommentId'));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Domain\Aggregate\AggregateId\CommentId');
    }
}
