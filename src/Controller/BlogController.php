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
    public function index($nPage): Response
    {
        if($nPage <= 0)
        {
            //TODO? Page 404 personnalisé ?
            throw new NotFoundHttpException('La page n\'existe pas');
        }

        return $this->render('blog/list.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }
}
