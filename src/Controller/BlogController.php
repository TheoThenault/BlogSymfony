<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/blog', name: 'blog')]
class BlogController extends AbstractController
{

    #[Route(
                        '/list/{nPage}',
        name:           '_list',
        requirements:   ['nPage' => '\d+'],
        defaults:       ['nPage' => 1])
    ]
    public function listArticles($nPage): Response
    {
        if($nPage <= 0)
        {
            //TODO? Page 404 personnalisé ?
            throw new NotFoundHttpException('La page n\'existe pas');
        }

        return $this->render('blog/list/list.html.twig');
    }

    #[Route(
                        '/article/{idArticle}',
        name:           '_view',
        requirements:   ['$idArticle' => '\d+'],
        defaults:       ['$idArticle' => 0])
    ]
    public function viewArticle($idArticle): Response
    {
        if($idArticle <= 0)
        {
            //TODO? Page 404 personnalisé ?
            throw new NotFoundHttpException('La page n\'existe pas');
        }

        return $this->render('blog/view/view.html.twig');
    }



}
