<?php

namespace spec\Domain\ReadModel\Projection;

use Domain\Aggregate\AggregateId\PostId;
use Domain\ReadModel\Projection;
use Domain\ReadModel\Projection\PostListProjection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin PostListProjection
 */
class PostListProjectionSpec extends ObjectBehavior
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
     * @var \DateTime
     */
    private $publishingDate;

    function let()
    {
        $this->postId = PostId::generate();
        $this->title = 'Post title';
        $this->publishingDate = new \DateTime();

        $this->beConstructedWith($this->postId, $this->title, $this->publishingDate);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Domain\ReadModel\Projection\PostListProjection');
    }

    function it_is_a_projection()
    {
        $this->shouldImplement(Projection::class);
    }

    function it_has_projection_name()
    {
        $this->getProjectionName()->shouldReturn('post-list');
    }

    function it_has_aggregate_id()
    {
        $this->getAggregateId()->shouldReturn($this->postId);
    }

    function it_has_title()
    {
        $this->getTitle()->shouldReturn($this->title);
    }

    function it_has_publishing_date()
    {
        $this->getPublishingDate()->shouldReturn($this->publishingDate);
    }
}
