<?php


namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function homepage()
    {
        return new Response('Radi li ovo?');
    }

    /**
     * @Route("/news/{slug}")
     */
    public function show($slug)
    {
        $comments = ['Zvezda le!',
            'bla bla',
            'Dok se zemlja oko sunca krece'
        ];

        return $this->render('article/show.html.twig',[
            'title'=>ucwords(str_replace('-',' ',$slug)),
            'comments'=>$comments,
            ]);
    }
}