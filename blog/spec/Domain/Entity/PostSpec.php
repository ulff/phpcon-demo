<?php

namespace spec\Domain\Entity;

use Domain\Entity\Post\PostId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PostSpec extends ObjectBehavior
{
    function let(PostId $postId)
    {
        $this->beConstructedWith($postId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Domain\Entity\Post');
    }

    function it_has_title()
    {
        $this->setTitle('Short leading post');
        $this->getTitle()->shouldReturn('Short leading post');
    }

    function it_has_content()
    {
        $this->setContent('This is first post created on this blog');
        $this->getContent()->shouldReturn('This is first post created on this blog');
    }

    function it_has_publishing_date()
    {
        $this->setPublishingDate($publishingDate = new \DateTime('2015-11-19 23:04:00'));
        $this->getPublishingDate()->shouldReturn($publishingDate);
    }
}
