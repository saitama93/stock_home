<?php

namespace App\Service;

use Twig\Environment;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailerService  {

    private $mailer;
    private $twig;
    private $userRepo;

    public function __construct(MailerInterface $mailer, Environment $twig, UserRepository $userRepo){
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->userRepo = $userRepo;
    }

  
    /**
     * Permet d'envoyer un mail
     * 
     * @param string $message => Message du mail
     * @param string $sender => L'expéditeur du mail
     * @param string $recipient => Le destinataire du mail
     * @param string $subject =>  Objet du mail
     * @param User $id => l'utilisateur à qui on utilise les info dans le template 'admin/mails/new_account.html.twig'
     * 
     * @return void
     */
    public function sendMail(string $message, string $sender, string $recipient, string $subject, $id, string $pathToPdf = null) : void{
        //Création et envoie de mail    

       try {
            $email = (new Email())
                ->from($sender)
                ->to($recipient)
                ->subject($subject)
                ->html($this->twig->render('admin/mails/new_account.html.twig', [
                    'user' => $this->userRepo->find($id)
                ]))
                ->text($message)
            ;

            $this->mailer->send($email);
       } catch (Exception $e) {
           echo 'Exception reçue: ', $e->getMessage(), "\n";
       }
    }

  }