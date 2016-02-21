<?php

namespace spec\Domain\Event;

use Domain\Aggregate\AggregateId\PostId;
use Domain\Event\PostWasUpdated;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin PostWasUpdated
 */
class PostWasUpdatedSpec extends ObjectBehavior
{
    /**
     * @var PostId
     */
    private $postId;

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
        $this->postId = PostId::generate();
        $this->title = 'title';
        $this->content = 'content';

        $this->beConstructedWith($this->postId, $this->title, $this->content);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Domain\Event\PostWasUpdated');
    }

    function it_has_aggregate_id()
    {
        $this->getAggregateId()->shouldHaveType('Domain\Aggregate\AggregateId\PostId');
        $this->getAggregateId()->shouldReturn($this->postId);
    }

    function it_has_title()
    {
        $this->getTitle()->shouldReturn($this->title);
    }

    function it_has_content()
    {
        $this->getContent()->shouldReturn($this->content);
    }
}
