<?php

namespace spec\Domain\Event;

use Domain\Aggregate\AggregateId\PostId;
use Domain\Event\PostWasPublished;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin PostWasPublished
 */
class PostWasPublishedSpec extends ObjectBehavior
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

    /**
     * @var \DateTime
     */
    private $publishingDate;

    function let()
    {
        $this->postId = PostId::generate();
        $this->title = 'title';
        $this->content = 'content';
        $this->publishingDate = new \DateTime();

        $this->beConstructedWith($this->postId, $this->title, $this->content, $this->publishingDate);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Domain\Event\PostWasPublished');
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

    function it_has_publishing_date()
    {
        $this->getPublishingDate()->shouldHaveType(\DateTime::class);
        $this->getPublishingDate()->shouldReturn($this->publishingDate);
    }
}
