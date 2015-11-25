<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Domain\Entity\Comment;
use Domain\Entity\Post;
use Domain\EventModel\EventBus;
use Domain\ReadModel\Listener\PostListListener;
use Domain\UseCase\AddComment;
use Domain\UseCase\PublishPost;
use Domain\UseCase\UpdatePost;
use Domain\UseCase\ListPosts;
use Domain\ReadModel\Projection\PostListProjection;
use Infrastructure\InMemory\InMemoryEventStorage;
use Infrastructure\InMemory\InMemoryProjectionStorage;

/**
 * Defines application features from the specific context.
 */
class DomainContext implements Context, SnippetAcceptingContext, PublishPost\Responder, AddComment\Responder, ListPosts\Responder, UpdatePost\Responder
{
    /**
     * @var $eventBus EventBus
     */
    private $eventBus;

    /**
     * @var $eventStorage InMemoryEventStorage
     */
    private $eventStorage;

    /**
     * @var $projectionStorage InMemoryProjectionStorage
     */
    private $projectionStorage;

    /**
     * @var $publishPost PublishPost
     */
    private $publishPost;

    /**
     * @var $updatePost UpdatePost
     */
    private $updatePost;

    /**
     * @var $listPosts ListPosts
     */
    private $listPosts;

    /**
     * @var $addComment AddComment
     */
    private $addComment;

    /**
     * @var $currentPost Post
     */
    private $currentPost;

    /**
     * @var $currentComment Comment
     */
    private $currentComment;

    /**
     * @var PostListProjection[]
     */
    private $postListProjections;

    private $postWasUpdated = false;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->eventBus = new EventBus();
        $this->eventStorage = new InMemoryEventStorage();
        $this->projectionStorage = new InMemoryProjectionStorage();
        $this->publishPost = new PublishPost($this->eventBus, $this->eventStorage);
        $this->updatePost = new UpdatePost($this->eventBus, $this->eventStorage);
        $this->addComment = new AddComment($this->eventBus, $this->eventStorage);
        $this->listPosts = new ListPosts($this->eventBus, $this->eventStorage, $this->projectionStorage);

        new PostListListener($this->eventBus, $this->projectionStorage);
    }

    /**
     * @When I create post with data:
     * @Given post exists with data:
     */
    public function iCreatePostWithData(TableNode $table)
    {
        $this->publishPost->execute(new PublishPost\Command(
            $table->getRowsHash()['title'],
            $table->getRowsHash()['content']
        ), $this);
    }

    /**
     * @When I update post with data:
     */
    public function iUpdatePostWithData(TableNode $table)
    {
        $this->updatePost->execute(new UpdatePost\Command(
            $this->currentPost->getPostId(),
            $table->getRowsHash()['title'],
            $table->getRowsHash()['content']
        ), $this);
    }

    /**
     * @Then new post should be published
     */
    public function newPostShouldBePublished()
    {
        if(empty($this->currentPost)) {
            throw new \Exception('Post was not published!');
        }
    }

    /**
     * @Then post should be updated
     */
    public function postShouldBeUpdated()
    {
        if(empty($this->currentPost)) {
            throw new \Exception('Post does not exist!');
        }
        if($this->postWasUpdated === false) {
            throw new \Exception('Post was not updated!');
        }
    }

    /**
     * @When I add new comment for that post with data:
     */
    public function iAddNewCommentForThatPostWithData(TableNode $table)
    {
        $this->addComment->execute(new AddComment\Command(
            $this->currentPost->getPostId(),
            $table->getRowsHash()['author'],
            $table->getRowsHash()['content']
        ), $this);
    }

    /**
     * @Then new comment should be added to that post
     */
    public function newCommentShouldBeAddedToThatPost()
    {
        if(empty($this->currentComment)) {
            throw new \Exception('Comment was not added!');
        }
        if($this->currentComment->getPostId() != $this->currentPost->getPostId()) {
            throw new \Exception('Comment was not added, but is not assigned to proper post!');
        }
    }

    /**
     * @When I visit post list
     */
    public function iVisitPostList()
    {
        $this->listPosts->execute(new ListPosts\Command(), $this);
    }

    /**
     * @Then I should see post :postTitle on the list
     */
    public function iShouldSeePostOnTheList($postTitle)
    {
        foreach($this->postListProjections as $postListProjection) {
            if($postListProjection->title == $postTitle) {
                return;
            }
        }
        throw new \Exception('Expected post titled "'.$postTitle.'" was not found on the list');
    }

    /**
     * @Then I should not see post :postTitle on the list
     */
    public function iShouldNotSeePostOnTheList($postTitle)
    {
        foreach($this->postListProjections as $postListProjection) {
            if($postListProjection->title == $postTitle) {
                throw new \Exception('Post titled "'.$postTitle.'" exists on the list, but was not expected');
            }
        }
    }

    /**
     * @param Post $post
     */
    public function postPublishedSuccessfully(Post $post)
    {
        $this->currentPost = $post;
    }

    /**
     * @param Post $post
     */
    public function postUpdatedSuccessfully(Post $post)
    {
        $this->currentPost = $post;
        $this->postWasUpdated = true;
    }

    /**
     * @param Comment $comment
     */
    public function commentAddedSuccessfully(Comment $comment)
    {
        $this->currentComment = $comment;
    }

    /**
     * @param PostListProjection[] $postListProjections
     */
    public function postsListedSuccessfully(array $postListProjections)
    {
        $this->postListProjections = $postListProjections;
    }

    /**
     * @param \Exception $e
     */
    public function postPublishingFailed(\Exception $e)
    {
        throw new \Exception($e->getMessage());
    }

    /**
     * @param \Exception $e
     */
    public function commentAddingFailed(\Exception $e)
    {
        throw new \Exception($e->getMessage());
    }

    /**
     * @param \Exception $e
     */
    public function postUpdatingFailed(\Exception $e)
    {
        throw new \Exception($e->getMessage());
    }
}
