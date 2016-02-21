<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PostListItem;
use Domain\ReadModel\Projection\PostListProjection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Domain\UseCase\ListPosts;
use Symfony\Component\HttpKernel\Exception\HttpException;

class BlogController extends Controller implements ListPosts\Responder
{
    private $postList;

    public function listAction()
    {
        $listPostsUseCase = new ListPosts($this->get('projection_storage'));
        $listPostsUseCase->execute(new ListPosts\Command(), $this);

        return $this->render('AppBundle:Blog:list.html.twig', ['posts' => $this->postList]);
    }

    public function viewAction()
    {
        throw new HttpException(404, 'Not implemented yet');
    }

    public function createAction()
    {
        throw new HttpException(404, 'Not implemented yet');
    }

    /** {@inheritdoc} */
    public function postsListedSuccessfully(array $projections)
    {
        $this->postList = [];
        /** @var PostListProjection $projection */
        foreach ($projections as $projection) {
            $this->postList[] = PostListItem::createFromProjection($projection);
        }
    }
}
