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
        defaults:       ['nPage' => 1]
    )]
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
        '/article/add',
        name:           '_add'
    )]
    public function addArticle(): Response
    {
        if(false)
        {
            // traitement du formulaire

            // messasge de succès
            $this->addFlash('info', '.....');
            return $this->redirectToRoute('blog_list'); //TODO? rediriger vers la lecture de l'article?
        }

        return $this->render('blog/add/add.html.twig');
    }

    #[Route(
        '/article/edit/{idArticle}',
        name:           '_edit',
        requirements:   ['$idArticle' => '\d+'],
        defaults:       ['$idArticle' => 0]
    )]
    public function editArticle($idArticle): Response
    {
        if($idArticle <= 0)
        {
            //TODO? Page 404 personnalisé ?
            throw new NotFoundHttpException('La page n\'existe pas');
        }
        
        if(false)
        {
            // traitement du formulaire

            // messasge de succès
            $this->addFlash('info', '.....');
            return $this->redirectToRoute('blog_list'); //TODO? rediriger vers la lecture de l'article?
        }

        return $this->render('blog/edit/edit.html.twig');
    }

    #[Route(
                        '/article/{idArticle}',
        name:           '_view',
        requirements:   ['$idArticle' => '\d+'],
        defaults:       ['$idArticle' => 0]
    )]
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
