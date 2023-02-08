<?php

namespace App\EventListener;


use App\Entity\Article;
use App\Services\MailSender;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;


#[AsEntityListener(event: Events::postPersist, method: 'postPersist', entity: Article::class)]
class ArticleViewsListener
{
    private MailSender $mailer;

    public function __construct(MailSender $m)
    {
        $this->mailer = $m;
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        if(!$entity instanceof Article)
        {
            return;
        }

        var_dump("\n\n\n\n\n\nLISTENER\n\n\n\n\n\n\n\n\n\n");
        var_dump($entity);

        if($entity->getNbViews() % 10 == 0)
        {
            $this->mailer->sendMail($entity);
        }
    }

}