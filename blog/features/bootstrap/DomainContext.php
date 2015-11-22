<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Domain\Entity\Comment;
use Domain\Entity\Post;
use Domain\EventModel\EventBus;
use Domain\UseCase\AddComment;
use Domain\UseCase\PublishPost;
use Infrastructure\InMemory\InMemoryEventStorage;

/**
 * Defines application features from the specific context.
 */
class DomainContext implements Context, SnippetAcceptingContext, PublishPost\Responder, AddComment\Responder
{
    /**
     * @var $eventStorage InMemoryEventStorage
     */
    private $eventStorage;

    /**
     * @var $eventBus EventBus
     */
    private $eventBus;

    /**
     * @var $publishPost PublishPost
     */
    private $publishPost;

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
        $this->publishPost = new PublishPost($this->eventBus, $this->eventStorage);
        $this->addComment = new AddComment($this->eventBus, $this->eventStorage);
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
     * @Then new post should be published
     */
    public function newPostShouldBePublished()
    {
        if(empty($this->currentPost)) {
            throw new \Exception('Post was not published!');
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
     * @param Post $post
     */
    public function postPublishedSuccessfully(Post $post)
    {
        $this->currentPost = $post;
    }

    /**
     * @param Comment $comment
     */
    public function commentAddedSuccessfully(Comment $comment)
    {
        $this->currentComment = $comment;
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
}
