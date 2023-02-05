<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

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
        $user->setEmail('theo.thenault@email.com')->setRoles(['ROLE_USER']);
        $user->setPassword('$2y$13$viDdenVdWndIFbZ9N.zdk.8.Uf3Vq3AfA1VrxZUo9TOvd1eq1dzhS');
        $manager->persist($user);

        $user = new User();
        $user->setNom('Thénault')->setPrenom('Théo ADMIN')->setDateNaissance(new DateTime('2001-03-01'));
        $user->setEmail('admin@email.com')->setRoles(['ROLE_ADMIN']);
        $user->setPassword('$2y$13$viDdenVdWndIFbZ9N.zdk.8.Uf3Vq3AfA1VrxZUo9TOvd1eq1dzhS');
        $manager->persist($user);



        $manager->flush();
    }
}
