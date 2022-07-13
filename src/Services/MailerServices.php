<?php

namespace App\Services;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Twig\Environment;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

class MailerServices
{

    public function __construct(MailerInterface $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }


    public function sendEmail(User $user ,$subject="Création de compte")
    {

        $email = new TemplatedEmail();
        $email->from("mouhamed@gmail.com")
            ->to($user->getEmail())
            ->subject($subject)
            ->htmlTemplate('Mail/index.html.twig')
            ->context([
                "user"=>$user,
                "subject"=>$subject,
                 "token"=>$user->getToken()
            ]);
               
        

        $this->mailer->send($email);
    }
}
