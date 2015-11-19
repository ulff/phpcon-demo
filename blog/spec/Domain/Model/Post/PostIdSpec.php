<?php

namespace spec\Domain\Model\Post;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PostIdSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(Argument::type('Domain\Model\Post\PostId'));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Domain\Model\Post\PostId');
    }
}
