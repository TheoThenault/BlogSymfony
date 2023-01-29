<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures
{
    public array $list_articles = array();

    public function charger(ObjectManager $manager, array $list_categories) : void
    {
        $max = count($list_categories)-1;

        $a = new Article();
        $a->setCreatedAt(new \DateTime('2023-01-29'))->setNbViews(0)->setAuthor('Théo');
        $a->setTitle("Premier article")->setContent('Ceci est le premier article!')->setPublished(true);
        $a->addCategory($list_categories[rand(0,$max)]);
        $a->addCategory($list_categories[rand(0,$max)]);
        $this->list_articles[] = $a;
        $manager->persist($a);

        $a = new Article();
        $a->setCreatedAt(new \DateTime('2023-01-29'))->setNbViews(0)->setAuthor('Théo');
        $a->setTitle("Second Article")->setContent('Cet article est cacher')->setPublished(false);
        $a->addCategory($list_categories[rand(0,$max)]);
        $this->list_articles[] = $a;
        $manager->persist($a);

        $a = new Article();
        $a->setCreatedAt(new \DateTime('2023-01-29'))->setNbViews(0)->setAuthor('Théo');
        $a->setTitle('Blog symfony')->setContent('Je fais ce blog en symfony')->setPublished(true);
        $this->list_articles[] = $a;
        $manager->persist($a);

        $a = new Article();
        $a->setCreatedAt(new \DateTime('2023-01-29'))->setNbViews(0)->setAuthor('Théo');
        $a->setTitle('206 Tuning')->setContent('https://ma-206-tuning-by-rem.skyrock.com/')->setPublished(true);
        $a->addCategory($list_categories[rand(0,$max)]);
        $a->addCategory($list_categories[rand(0,$max)]);
        $a->addCategory($list_categories[rand(0,$max)]);
        $this->list_articles[] = $a;
        $manager->persist($a);

        $a = new Article();
        $a->setCreatedAt(new \DateTime('2023-01-29'))->setNbViews(0)->setAuthor('Théo');
        $a->setTitle('Lorem')->setContent('Posidonium id causae turpis gravida facilisis platonem brute. Debet finibus congue velit solum ridiculus autem. At epicuri natoque posse praesent idque epicuri. Dolore labores morbi aliquid regione inciderint varius sententiae simul appetere. Ornatus tempus graecis euripidis propriae rutrum. Ancillae mei impetus habitant sed. Sanctus cum ponderum mel reformidans aliquet fugit. Conubia eum tincidunt mediocrem mollis auctor prompta eripuit parturient sem. Sociis decore mentitum adversarium eripuit sumo enim novum inimicus donec. Aenean falli atqui aperiri iusto torquent volutpat eleifend quidam. Enim donec viris blandit eloquentiam altera omittantur expetendis id. Adipisci offendit prodesset condimentum impetus suspendisse vim. Ludus erat appareat iaculis ius. Aeque aliquid veniam urna disputationi wisi noster semper maiestatis. Cum commune velit doming nisi persius tritani viderer. Viverra cum aliquam nihil habitant ancillae finibus evertitur maecenas. Quaestio ipsum propriae neglegentur putent suscipit. Vidisse mazim mei lorem hendrerit deterruisset senectus definiebas. Postulant adipiscing legimus natum discere. Felis consetetur euismod solet nec nobis suspendisse.')->setPublished(true);
        $a->addCategory($list_categories[rand(0,$max)]);
        $a->addCategory($list_categories[rand(0,$max)]);
        $a->addCategory($list_categories[rand(0,$max)]);
        $a->addCategory($list_categories[rand(0,$max)]);
        $a->addCategory($list_categories[rand(0,$max)]);
        $this->list_articles[] = $a;
        $manager->persist($a);

        $a = new Article();
        $a->setCreatedAt(new \DateTime('2024-01-29'))->setNbViews(0)->setAuthor('Théo');
        $a->setTitle('Ceci est un très très (trop ?) long titre d\'article !')->setContent('Pour tester le truncate!')->setPublished(true);
        $a->addCategory($list_categories[rand(0,$max)]);
        $this->list_articles[] = $a;
        $manager->persist($a);

        $a = new Article();
        $a->setCreatedAt(new \DateTime('2023-01-29'))->setNbViews(0)->setAuthor('Théo');
        $a->setTitle('Plus de 5 articles !')->setContent('Dolore menandri idque te definitionem iaculis mattis. Donec cetero instructior dolores verterem vituperatoribus. Vim eos elitr mandamus fabulas tritani laoreet persius fusce postulant.')->setPublished(true);
        $a->addCategory($list_categories[rand(0,$max)]);
        $a->addCategory($list_categories[rand(0,$max)]);
        $this->list_articles[] = $a;
        $manager->persist($a);

        $manager->flush();
    }
}