<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Persistence\ObjectManager;

class CategorieFixtures
{
    public array $list_categories = array();

    public function charger(ObjectManager $manager) : void
    {
        $cat = new Categorie();
        $cat->setName("Téchnologie");
        $this->list_categories[] = $cat;
        $manager->persist($cat);

        $cat = new Categorie();
        $cat->setName("Information");
        $this->list_categories[] = $cat;
        $manager->persist($cat);

        $cat = new Categorie();
        $cat->setName("développement");
        $this->list_categories[] = $cat;
        $manager->persist($cat);

        $cat = new Categorie();
        $cat->setName("France");
        $this->list_categories[] = $cat;
        $manager->persist($cat);

        $cat = new Categorie();
        $cat->setName("Catégorie 2");
        $this->list_categories[] = $cat;
        $manager->persist($cat);

        $cat = new Categorie();
        $cat->setName("Memes");
        $this->list_categories[] = $cat;
        $manager->persist($cat);

        $manager->flush();
    }
}