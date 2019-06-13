<?php


namespace App\Controller;


use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage()
    {
        return $this->render('article/homepage.html.twig');
    }

    /**
     * @Route("/news/{slug}", name="article_show")
     */
    public function show($slug)
    {
        $comments = ['Zvezda le!',
            'bla bla',
            'Dok se zemlja oko sunca krece'
        ];

        return $this->render('article/show.html.twig',[
            'title'=>ucwords(str_replace('-',' ',$slug)),
            'slug' => $slug,
            'comments'=>$comments,
            ]);
    }

    /**
     * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     */
    public function toggleArticleHeart($slug, LoggerInterface $logger)
    {
        //TODO - actually heart/unheart the article!

        $logger->info('Lajkuju ljudi');

        return new JsonResponse(['hearts' => rand(5, 100)]);
    }
}