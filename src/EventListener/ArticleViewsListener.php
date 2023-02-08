<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\Article;
use App\Services\MailSender;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;


//#[AsEntityListener(event: Events::postPersist, method: 'postPersist', entity: Article::class)]
class ArticleViewsListener
{
    private MailSender $mailer;

    public function __construct(MailSender $m)
    {
        $this->mailer = $m;
    }

    public function postPersist(
        LifecycleEventArgs $args
    ): void
    {
        $entity = $args->getObject();
        if(!$entity instanceof Article) {
            return;
        }

        if($entity->getNbViews() % 10 == 0)
        {
            $this->mailer->sendMail($entity);
        }
    }

}