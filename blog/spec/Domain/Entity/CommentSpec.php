<?php

namespace spec\Domain\Entity;

use Domain\Entity\Comment\CommentId;
use Domain\Entity\Post\PostId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommentSpec extends ObjectBehavior
{
    function let(CommentId $commentId, PostId $postId)
    {
        $this->beConstructedWith($commentId, $postId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Domain\Entity\Comment');
    }

    function it_has_reference_to_post(PostId $postId)
    {
        $this->getPostId()->shouldReturn($postId);
    }

    function it_has_content()
    {
        $this->setContent('Opinion about the post');
        $this->getContent()->shouldReturn('Opinion about the post');
    }

    function it_has_author()
    {
        $this->setAuthor('Ellis');
        $this->getAuthor()->shouldReturn('Ellis');
    }

    function it_has_creating_date()
    {
        $this->setCreatingDate($creatingDate = new \DateTime('2015-11-20 13:15:00'));
        $this->getCreatingDate()->shouldReturn($creatingDate);
    }
}
