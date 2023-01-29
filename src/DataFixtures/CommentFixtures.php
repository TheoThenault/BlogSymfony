<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use DateInterval;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;

class CommentFixtures
{
    public array $list_comments = array();

    public function charger(ObjectManager $manager, array $list_articles) : void
    {
        $possible_comments = [
            'Très bon article!',
            'Moyen',
            'J\'aurai fait un meilleur article',
            'C\'était mieux avant',
            'Manque de profondeur',
            'Vous savez, moi je ne crois pas qu’il y ait de bonne ou de mauvaise situation. Moi, si je devais résumer ma vie aujourd’hui avec vous, je dirais que c’est d’abord des rencontres. Des gens qui m’ont tendu la main, peut-être à un moment où je ne pouvais pas, où j’étais seul chez moi. Et c’est assez curieux de se dire que les hasards, les rencontres forgent une destinée… Parce que quand on a le goût de la chose, quand on a le goût de la chose bien faite, le beau geste, parfois on ne trouve pas l’interlocuteur en face je dirais, le miroir qui vous aide à avancer. Alors ça n’est pas mon cas, comme je disais là, puisque moi au contraire, j’ai pu: et je dis merci à la vie, je lui dis merci, je chante la vie, je danse la vie… je ne suis qu’amour! Et finalement, quand beaucoup de gens aujourd’hui me disent «Mais comment fais-tu pour avoir cette humanité?», et bien je leur réponds très simplement, je leur dis que c’est ce goût de l’amour ce goût donc qui m’a poussé aujourd’hui à entreprendre une construction mécanique, mais demain qui sait? Peut-être simplement à me mettre au service de la communauté, à faire le don, le don de soi… ',
            'À remettre: vendredi 10 février 2023, 23:59'
        ];

        $possible_authors = [
            'A.Rideau',
            'Mattieu',
            'Luka',
            'S.Merlu'
        ];

        $possible_title = [
            'Bien',
            'Moyen',
            'Mauvais'
        ];

        for($currArticle = 0; $currArticle < count($list_articles); $currArticle++)
        {
            $nombreComments = rand(0,10);
            for($c = 0; $c < $nombreComments; $c++)
            {
                $com = rand(0, count($possible_comments)-1);
                $aut = rand(0, count($possible_authors)-1);
                $tit = rand(0, count($possible_title)-1);
                $date = clone $list_articles[$currArticle]->getCreatedAt();
                try {
                    $date->add(new DateInterval('P' . rand(1, 10) . 'D'));
                } catch (\Exception $e) {
                }

                $comment = new Comment();
                $comment->setTitle($possible_title[$tit]);
                $comment->setAuthor($possible_authors[$aut]);
                $comment->setMessage($possible_comments[$com]);
                $comment->setCreatedAt($date);
                $comment->setArticle($list_articles[$currArticle]);

                $this->list_comments[] = $comment;
                $manager->persist($comment);
            }
        }
        $manager->flush();
    }
}