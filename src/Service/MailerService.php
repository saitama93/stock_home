<?php

namespace App\Service;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailerService  {

    private $mailer;


    public function __construct(MailerInterface $mailer){
        $this->mailer = $mailer;
    }

  
    /**
     * Permet d'envoyer un mail
     * 
     * @param string $message => Message du mail
     * @param string $sender => L'expéditeur du mail
     * @param string $recipient => Le destinataire du mail
     * @param string $subject =>  Objet du mail
     * 
     * @return void
     */
    public function sendMail(string $message, string $sender, string $recipient, string $subject) : void{
        //Création et envoie de mail    

       try {
            $email = (new Email())
                ->from($sender)
                ->to($recipient)
                ->subject($subject)
                ->html("<p>" . $message . "</p>")
                ->text($message)
            ;

            $this->mailer->send($email);
       } catch (Exception $e) {
           echo 'Exception reçue: ', $e->getMessage(), "\n";
       }
    }
}