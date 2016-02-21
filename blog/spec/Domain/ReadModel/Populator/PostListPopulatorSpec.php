<?php

namespace spec\Domain\ReadModel\Populator;

use Domain\Aggregate\AggregateId\PostId;
use Domain\Event\PostWasPublished;
use Domain\EventEngine\EventStorage;
use Domain\ReadModel\BulkProjectionStorage;
use Domain\ReadModel\DomainEventListener;
use Domain\ReadModel\Projection\PostListProjection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PostListPopulatorSpec extends ObjectBehavior
{
    function let(EventStorage $eventStorage, BulkProjectionStorage $projectionStorage, DomainEventListener $listener)
    {
        $this->beConstructedWith($eventStorage, $projectionStorage, $listener);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Domain\ReadModel\Populator\PostListPopulator');
    }

    function it_should_have_projection_name()
    {
        $this->getProjectionName()->shouldReturn('post-list');
    }

    function it_should_have_stats()
    {
        $this->getStats()->shouldHaveType('Domain\ReadModel\ProjectionPopulatorStats');
    }

    function it_should_clear_projections(BulkProjectionStorage $projectionStorage)
    {
        $projectionStorage->find('post-list')->willReturn(
            $projections = [new PostListProjection(PostId::generate(), 'Post title', new \DateTime())]
        );

        foreach ($projections as $projection) {
            $projectionStorage->remove($projection)->shouldBeCalled();
        }

        $projectionStorage->flush()->shouldBeCalled();

        $this->clear();
    }

    function it_should_run_populator(
        BulkProjectionStorage $projectionStorage,
        EventStorage $eventStorage,
        DomainEventListener $listener
    ) {
        $projectionStorage->find('post-list')->willReturn(
            $projections = [new PostListProjection(PostId::generate(), 'Post title', new \DateTime())]
        );

        foreach ($projections as $projection) {
            $projectionStorage->remove($projection)->shouldBeCalled();
        }

        $projectionStorage->flush()->shouldBeCalled();

        $eventStorage->getAll()->willReturn(
            $events = [new PostWasPublished(PostId::generate(), 'title', 'content', new \DateTime())]
        );

        foreach ($events as $event) {
            $eventClass = explode('\\', get_class($event));
            $method = 'on'.end($eventClass);
            if (method_exists($listener, $method)) {
                $listener->when($event)->shouldBeCalled();
            }
        }
        $projectionStorage->flush()->shouldBeCalled();

        $this->run();
    }
}
