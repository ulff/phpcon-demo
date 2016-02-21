<?php

namespace spec\Domain\Aggregate;

use Domain\Aggregate\AggregateId\PostId;
use Domain\Aggregate\Post;
use Domain\EventEngine\Aggregate;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin Post
 */
class PostSpec extends ObjectBehavior
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    function let()
    {
        $this->title = 'Short leading post';
        $this->content = 'This is first post created on this blog';

        $this->beConstructedThrough('create', [$this->title, $this->content]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Domain\Aggregate\Post');
    }

    function it_is_an_aggregate()
    {
        $this->shouldImplement(Aggregate::class);
    }

    function it_has_title()
    {
        $this->getTitle()->shouldReturn($this->title);
    }

    function it_has_content()
    {
        $this->getContent()->shouldReturn($this->content);
    }

    function it_has_publishing_date()
    {
        $this->getPublishingDate()->shouldHaveType('DateTime');
    }
}
