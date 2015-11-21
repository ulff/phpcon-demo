<?php

namespace spec\Domain\Entity\Post;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PostIdSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(Argument::type('Domain\Entity\Post\PostId'));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Domain\Entity\Post\PostId');
    }
}
