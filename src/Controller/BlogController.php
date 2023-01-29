<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
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
    public function listArticles($nPage, EntityManagerInterface $entityManager): Response
    {
        if($nPage <= 0)
        {
            //TODO? Page 404 personnalisé ?
            throw new NotFoundHttpException('La page n\'existe pas');
        }
/*
        $ArticleParDefaut = new Article();
        $ArticleParDefaut->setAuthor("Théo")->setContent("Test")->setCreatedAt(new \DateTime('2023-01-29'))
            ->setNbViews(0)->setPublished(true)->setTitle("Test");
        $entityManager->persist($ArticleParDefaut);
        $entityManager->flush();
*/

        $perPage = $this->getParameter('article_per_page');
        $articleRepo = $entityManager->getRepository(Article::class);
        $articles = $articleRepo->findPublishedArticlesPaged($nPage, $perPage);

        $pageMax = intval(ceil(count($articles)/$perPage));
        if($nPage > $pageMax)
        {
            throw new NotFoundHttpException('La page n\'existe pas');
        }

        foreach ($articles as $a)
        {
            dump($a);
        }
        return $this->render('blog/list/list.html.twig', ['listArticles' => $articles]);
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
            $this->addFlash('info', 'Article créé !');
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
            $this->addFlash('info', 'Article modifié !');
            return $this->redirectToRoute('blog_list'); //TODO? rediriger vers la lecture de l'article?
        }

        return $this->render('blog/edit/edit.html.twig');
    }

    #[Route(
        '/article/delete/{idArticle}',
        name:           '_delete',
        requirements:   ['$idArticle' => '\d+'],
        defaults:       ['$idArticle' => 0]
    )]
    public function deleteArticle($idArticle): Response
    {
        if($idArticle <= 0) //TODO Changer avec une requete doctrine
        {
            //TODO? Page 404 personnalisé ?
            throw new NotFoundHttpException('La page n\'existe pas');
        }

        // messasge de succès
        $this->addFlash('info', 'Article suprimé !');

        return $this->redirectToRoute('blog_list');
    }

    #[Route(
                        '/article/{idArticle}',
        name:           '_view',
        requirements:   ['$idArticle' => '\d+'],
        defaults:       ['$idArticle' => 0]
    )]
    public function viewArticle($idArticle, EntityManagerInterface $entityManager): Response
    {
        if($idArticle <= 0)
        {
            //TODO? Page 404 personnalisé ?
            throw new NotFoundHttpException('La page n\'existe pas');
        }
        $articleRepo = $entityManager->getRepository(Article::class);
        $article = $articleRepo->findOneBy(['id' => $idArticle]);
        if(is_null($article))
        {
            throw new NotFoundHttpException('La page n\'existe pas');
        }

        return $this->render('blog/view/view.html.twig', ['article' => $article]);
    }


}
