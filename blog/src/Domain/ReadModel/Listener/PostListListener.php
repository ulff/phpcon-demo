<?php

namespace Domain\ReadModel\Listener;

use Domain\Event\PostWasPublished;
use Domain\Event\PostWasUpdated;
use Domain\ReadModel\AbstractDomainEventListener;
use Domain\ReadModel\DomainEventListener;
use Domain\ReadModel\Projection\PostListProjection;

class PostListListener extends AbstractDomainEventListener implements DomainEventListener
{
    public function onPostWasPublished(PostWasPublished $event)
    {
        $postListProjection = new PostListProjection(
            $event->getAggregateId(),
            $event->getTitle(),
            $event->getPublishingDate()
        );
        $this->projectionStorage->save($postListProjection);
    }

    public function onPostWasUpdated(PostWasUpdated $event)
    {
        $postListProjection = $this->projectionStorage->findById(
            'post-list',
            $event->getAggregateId()
        );
        $postListProjection->title = $event->getTitle();
        $postListProjection->content = $event->getContent();
        $this->projectionStorage->save($postListProjection);
    }
}
