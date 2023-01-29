<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures
{
    public array $list_articles = array();

    public function charger(ObjectManager $manager) : void
    {
        $a = new Article();
        $a->setCreatedAt(new \DateTime('2023-01-29'))->setNbViews(0)->setAuthor('Théo');
        $a->setTitle("Premier article")->setContent('Ceci est le premier article!')->setPublished(true);
        $manager->persist($a);

        $a = new Article();
        $a->setCreatedAt(new \DateTime('2023-01-29'))->setNbViews(0)->setAuthor('Théo');
        $a->setTitle("Second Article")->setContent('Cet article est cacher')->setPublished(false);
        $manager->persist($a);

        $a = new Article();
        $a->setCreatedAt(new \DateTime('2023-01-29'))->setNbViews(0)->setAuthor('Théo');
        $a->setTitle('Blog symfony')->setContent('Je fais ce blog en symfony')->setPublished(true);
        $manager->persist($a);

        $a = new Article();
        $a->setCreatedAt(new \DateTime('2023-01-29'))->setNbViews(0)->setAuthor('Théo');
        $a->setTitle('206 Tuning')->setContent('https://ma-206-tuning-by-rem.skyrock.com/')->setPublished(true);
        $manager->persist($a);

        $a = new Article();
        $a->setCreatedAt(new \DateTime('2023-01-29'))->setNbViews(0)->setAuthor('Théo');
        $a->setTitle('Lorem')->setContent('Dolore menandri idque te definitionem iaculis mattis. Donec cetero instructior dolores verterem vituperatoribus. Vim eos elitr mandamus fabulas tritani laoreet persius fusce postulant.')->setPublished(true);
        $manager->persist($a);

        $a = new Article();
        $a->setCreatedAt(new \DateTime('2024-01-29'))->setNbViews(0)->setAuthor('Théo');
        $a->setTitle('Ceci est un très très (trop ?) long titre d\'article !')->setContent('Pour tester le truncate!')->setPublished(true);
        $manager->persist($a);

        $a = new Article();
        $a->setCreatedAt(new \DateTime('2023-01-29'))->setNbViews(0)->setAuthor('Théo');
        $a->setTitle('Plus de 5 articles !')->setContent('Dolore menandri idque te definitionem iaculis mattis. Donec cetero instructior dolores verterem vituperatoribus. Vim eos elitr mandamus fabulas tritani laoreet persius fusce postulant.')->setPublished(true);
        $manager->persist($a);

        $manager->flush();
    }
}