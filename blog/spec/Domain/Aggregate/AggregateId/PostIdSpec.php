<?php

namespace spec\Domain\Aggregate\AggregateId;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PostIdSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(Argument::type('Domain\Aggregate\AggregateId\PostId'));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Domain\Aggregate\AggregateId\PostId');
    }
}
