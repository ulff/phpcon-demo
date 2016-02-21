<?php

namespace spec\Domain\ReadModel\Listener;

use Domain\Aggregate\AggregateId\PostId;
use Domain\Event\PostWasPublished;
use Domain\EventEngine\EventBus;
use Domain\ReadModel\Listener\PostListListener;
use Domain\ReadModel\Projection\PostListProjection;
use Domain\ReadModel\ProjectionStorage;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin PostListListener
 */
class PostListListenerSpec extends ObjectBehavior
{
    function let(EventBus $eventBus, ProjectionStorage $projectionStorage)
    {
        $this->beConstructedWith($eventBus, $projectionStorage);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Domain\ReadModel\Listener\PostListListener');
    }

    function it_should_update_post_list_projection(ProjectionStorage $projectionStorage)
    {
        $event = new PostWasPublished(PostId::generate(), 'title', 'content', new \DateTime());
        $projectionStorage->save(Argument::type(PostListProjection::class))->shouldBeCalled();

        $this->when($event);
    }
}
