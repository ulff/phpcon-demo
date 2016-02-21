<?php

namespace spec\Domain\Aggregate;

use Domain\Aggregate\AggregateId\CommentId;
use Domain\Aggregate\AggregateId\PostId;
use Domain\Aggregate\Comment;
use Domain\Event\CommentWasAdded;
use Domain\EventEngine\Aggregate;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin Comment
 */
class CommentSpec extends ObjectBehavior
{
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

    function let()
    {
        $this->postId = PostId::generate();
        $this->author = 'Ellis';
        $this->content = 'Bob has written this';

        $this->beConstructedThrough('create', [$this->postId, $this->author, $this->content]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Domain\Aggregate\Comment');
    }

    function it_is_an_aggregate()
    {
        $this->shouldImplement(Aggregate::class);
    }

    function it_has_reference_to_post()
    {
        $this->getPostId()->shouldReturn($this->postId);
    }

    function it_has_content()
    {
        $this->getContent()->shouldReturn($this->content);
    }

    function it_has_author()
    {
        $this->getAuthor()->shouldReturn($this->author);
    }

    function it_has_creating_date()
    {
        $this->getCreatingDate()->shouldHaveType('DateTime');
    }
}
