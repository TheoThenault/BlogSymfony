<?php

namespace App\Controller\Twig;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class LastArticleController extends AbstractController
{
    // affiche les x derniers articles
    public function lastArticle($number, EntityManagerInterface $entityManager): Response
    {
        $articleRepo = $entityManager->getRepository(Article::class);
        // récupérer les articles
        $articles = $articleRepo->findBy(['published' => true],['createdAt' => 'desc'], $number);
        dump($articles);
        return $this->render('last_articles.html.twig', ['articles' => $articles]);
    }
}