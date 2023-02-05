<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\DateTime;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categoriesFixtures = new CategorieFixtures();
        $categoriesFixtures->charger($manager);

        $articlesFixtures = new ArticleFixtures();
        $articlesFixtures->charger($manager, $categoriesFixtures->list_categories);

        $commentFixtures = new CommentFixtures();
        $commentFixtures->charger($manager, $articlesFixtures->list_articles);

        $user = new User();
        $user->setNom('Thénault')->setPrenom('Théo')->setDateNaissance(new DateTime('2001-03-01'));
        $user->setEmail('theo.thenault@email.com');
        $user->setPassword('$2y$13$viDdenVdWndIFbZ9N.zdk.8.Uf3Vq3AfA1VrxZUo9TOvd1eq1dzhS');
        $manager->persist($user);



        $manager->flush();
    }
}
