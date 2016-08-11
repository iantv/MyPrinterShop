<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends Controller
{
    /**
     * @Route("/blog", name="blog_home")
     */
    public function blogAction()
    {
        return new Response('ok!!!!');
    }

    /**
     * @Route("/blog/article/{articleId}", name="blog_article")
     */
    public function ArticleAction($articleId)
    {
        // ...
        return new Response("blogArticle!");
    }
}

?>