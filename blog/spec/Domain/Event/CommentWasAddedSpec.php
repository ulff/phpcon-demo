<?php

namespace spec\Domain\Event;

use Domain\Aggregate\AggregateId\CommentId;
use Domain\Aggregate\AggregateId\PostId;
use Domain\Event\CommentWasAdded;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin CommentWasAdded
 */
class CommentWasAddedSpec extends ObjectBehavior
{
    /**
     * @var CommentId
     */
    private $commentId;

    /**
     * @var PostId
     */
    private $postId;

    /**
     * @var string
     */
    private $author;

    /**
     * @var string
     */
    private $content;

    /**
     * @var \DateTime
     */
    private $creatingDate;

    function let()
    {
        $this->commentId = CommentId::generate();
        $this->postId = PostId::generate();
        $this->author = 'Rochelle';
        $this->content = 'Comment';
        $this->creatingDate = new \DateTime();

        $this->beConstructedWith($this->commentId, $this->postId, $this->author, $this->content, $this->creatingDate);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Domain\Event\CommentWasAdded');
    }

    function it_has_aggregate_id()
    {
        $this->getAggregateId()->shouldHaveType('Domain\Aggregate\AggregateId\CommentId');
        $this->getAggregateId()->shouldReturn($this->commentId);
    }

    function it_has_post_id()
    {
        $this->getPostId()->shouldHaveType('Domain\Aggregate\AggregateId\PostId');
        $this->getPostId()->shouldReturn($this->postId);
    }

    function it_has_author()
    {
        $this->getAuthor()->shouldReturn($this->author);
    }

    function it_has_content()
    {
        $this->getContent()->shouldReturn($this->content);
    }

    function it_has_creating_date()
    {
        $this->getCreatingDate()->shouldHaveType(\DateTime::class);
        $this->getCreatingDate()->shouldReturn($this->creatingDate);
    }
}
