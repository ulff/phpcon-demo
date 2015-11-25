<?php

namespace Domain\ReadModel\Listener;

use Domain\EventModel\Event\PostWasPublished;
use Domain\EventModel\Event\PostWasUpdated;
use Domain\ReadModel\AbstractDomainEventListener;
use Domain\ReadModel\DomainEventListener;
use Domain\ReadModel\Projection\PostListProjection;

class PostListListener extends AbstractDomainEventListener implements DomainEventListener
{
    public function onPostWasPublished(PostWasPublished $event)
    {
        $templateListProjection = new PostListProjection($event->getAggregateId(), $event->getTitle(), $event->getPublishingDate());
        $this->projectionStorage->save($templateListProjection);
    }

    public function onPostWasUpdated(PostWasUpdated $event)
    {
        $templateListProjection = $this->projectionStorage->findById('post-list', $event->getAggregateId());
        $templateListProjection->title = $event->getTitle();
        $templateListProjection->content = $event->getContent();
        $this->projectionStorage->save($templateListProjection);
    }
}
