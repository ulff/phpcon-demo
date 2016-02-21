<?php

namespace spec\Domain\EventEngine;

use Domain\Aggregate\AggregateId\PostId;
use Domain\EventEngine\EventBus;
use Domain\Event\PostWasPublished;
use Domain\ReadModel\Listener\PostListListener;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin EventBus
 */
class EventBusSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Domain\EventEngine\EventBus');
    }

    function it_should_trigger_post_list_projection_update(PostListListener $postListListener)
    {
        $postListListener->when(Argument::type(PostWasPublished::class))->shouldBeCalled();

        $this->registerListener($postListListener);
        $this->dispatch([new PostWasPublished(PostId::generate(), 'title', 'content', new \DateTime())]);
    }
}
