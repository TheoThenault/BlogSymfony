<?php

namespace App\Services;

use App\Entity\Article;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


class MailSender
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendMail(Article $article):void
    {
        $email = new Email();
        $email->addFrom('admin@email.com')->addTo('admin@email.com');
        $email->subject($article->getTitle())->text($article->getNbViews() . ' vues!');

        $this->mailer->send($email);
    }

}