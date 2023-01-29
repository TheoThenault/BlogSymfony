<?php

namespace App\DataFixtures;

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

        $manager->flush();
    }
}
