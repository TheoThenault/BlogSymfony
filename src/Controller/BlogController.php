<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Form\ArticleType;
use App\Services\SpamFinder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/blog', name: 'blog')]
class BlogController extends AbstractController
{

    #[Route(
                        '/list/{nPage}',
        name:           '_list',
        requirements:   ['nPage' => '\d+'],
        defaults:       ['nPage' => 1]
    )]
    public function listArticles($nPage, EntityManagerInterface $entityManager, SpamFinder $finder): Response
    {
        if($nPage <= 0)
        {
            //TODO? Page 404 personnalisé ?
            throw new NotFoundHttpException('La page n\'existe pas');
        }

        $res = $finder->isSpam('aaaaaaaaaaaaa');
        dump('\'aaaaaaaaaaaaa\' est un spam ? ' . ($res?'oui':'non'));
        $res = $finder->isSpam('sdfsdfsdfsdf');
        dump('\'sdfsdfsdfsdf\' est un spam ? ' . ($res?'oui':'non'));
        $res = $finder->isSpam('ahahahahah');
        dump('\'ahahahahah\' est un spam ? ' . ($res?'oui':'non'));
        $res = $finder->isSpam('Le message precédent est acceptable.');
        dump('\'Le message precédent est acceptable.\' est un spam ? ' . ($res?'oui':'non'));

        $perPage = $this->getParameter('article_per_page');
        $articleRepo = $entityManager->getRepository(Article::class);
        $articles = $articleRepo->findPublishedArticlesPaged($nPage, $perPage);

        $pageMax = intval(ceil(count($articles)/$perPage));
        if($nPage != 1 && $nPage > $pageMax)  // Différent de 1 car si la BDD est vide on veut quand même afficher une page basique pour l'utilisateur
        {
            throw new NotFoundHttpException('La page n\'existe pas');
        }

        return $this->render('blog/list/list.html.twig', ['listArticles' => $articles, 'currPage' => $nPage, 'pageMax' => $pageMax]);
    }

    #[Route(
        '/article/add',
        name:           '_add'
    )]
    public function addArticle(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->add('send', SubmitType::class);
        $form ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            // traitement du formulaire
            $response = $form->getData();
            dump($response);

            // messasge de succès
            //$entityManager->persist($article);
            //$entityManager->flush();
            $this->addFlash('info', 'Article créé !');
            //return $this->redirectToRoute('blog_list');
        }

        return $this->render('blog/add/add.html.twig', [
            'formulaire' => $form->createView()
        ]);
    }

    #[Route(
        '/article/edit/{idArticle}',
        name:           '_edit',
        requirements:   ['$idArticle' => '\d+'],
        defaults:       ['$idArticle' => 0]
    )]
    public function editArticle($idArticle, EntityManagerInterface $entityManager, Request $request): Response
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

        $form = $this->createForm(ArticleType::class, $article);
        $form->add('send', SubmitType::class);
        $form ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            // traitement du formulaire

            // messasge de succès
            $this->addFlash('info', 'Article modifié !');
            //return $this->redirectToRoute('blog_list');
        }

        return $this->render('blog/edit/edit.html.twig', [
            'formulaire' => $form->createView()
        ]);
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
        $article = $articleRepo->findByIDWithOrderedComments($idArticle);
        if(is_null($article))
        {
            throw new NotFoundHttpException('La page n\'existe pas');
        }
        $article->setNbViews($article->getNbViews() + 1);
        $entityManager->flush();

        return $this->render('blog/view/view.html.twig', ['article' => $article]);
    }

    #[Route(
        '/categorie/{idCategorie}',
        name:           '_categorie',
        requirements:   ['$idCategorie' => '\d+'],
        defaults:       ['$idCategorie' => 0]
    )]
    public function listArticleByCategorie($idCategorie, EntityManagerInterface $entityManager): Response
    {
        $catRepo = $entityManager->getRepository(Categorie::class);
        $cat = $catRepo->findOneBy(['id'=>$idCategorie]);
        if(is_null($cat))
        {
            throw new NotFoundHttpException('La page n\'existe pas');
        }

        $articleRepo = $entityManager->getRepository(Article::class);
        $articles = $articleRepo->findByCategorie($idCategorie);

        return $this->render('blog/categorie/categorie.html.twig', ['listArticles' => $articles, 'name' => $cat->getName()]);
    }


}
