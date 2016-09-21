<?php

namespace Domain\FixturesEngine\Data;

use Domain\Aggregate\Post;
use Domain\UseCase\PublishPost;
use Domain\FixturesEngine\AbstractFixture;
use Domain\FixturesEngine\FixtureInterface;
use Domain\FixturesEngine\ReferenceRepository;

class PostFixtures extends AbstractFixture implements FixtureInterface, PublishPost\Responder
{
    /**
     * @var Post
     */
    private $publishedPost;

    /** {@inheritdoc} */
    public function load(ReferenceRepository $referenceRepository)
    {
        $this->loadPost1($referenceRepository);
        $this->loadPost2($referenceRepository);
        $this->loadPost3($referenceRepository);
    }

    /** {@inheritdoc} */
    public function getOrder()
    {
        return 1;
    }

    /** {@inheritdoc} */
    public function postPublishedSuccessfully(Post $post)
    {
        $this->publishedPost = $post;
    }

    /** {@inheritdoc} */
    public function postPublishingFailed(\Exception $e)
    {
        throw new \Exception($e);
    }

    private function loadPost1(ReferenceRepository $referenceRepository)
    {
        $command = new PublishPost\Command(
            'First post title',
            'Some content here'
        );

        $publishPostUseCase = new PublishPost(
            $this->eventBus,
            $this->eventStorage
        );
        $publishPostUseCase->execute($command, $this);

        $referenceRepository->addReference('post_1', $this->publishedPost);
    }

    private function loadPost2(ReferenceRepository $referenceRepository)
    {
        $command = new PublishPost\Command(
            'PHPcon demo',
            'Here is content of PHPcon demo blogpost'
        );

        $publishPostUseCase = new PublishPost(
            $this->eventBus,
            $this->eventStorage
        );
        $publishPostUseCase->execute($command, $this);

        $referenceRepository->addReference('post_2', $this->publishedPost);
    }

    private function loadPost3(ReferenceRepository $referenceRepository)
    {
        $command = new PublishPost\Command(
            'Yet another post title',
            'I have no ideas of content that can be put here'
        );

        $publishPostUseCase = new PublishPost(
            $this->eventBus,
            $this->eventStorage
        );
        $publishPostUseCase->execute($command, $this);

        $referenceRepository->addReference('post_3', $this->publishedPost);
    }

}
