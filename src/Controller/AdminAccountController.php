<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAccountController extends AbstractController
{
     /**
     * Permet de visualiser le profil de l'utilisateur connecté
     * 
     * @Route("/account/my_account/{id}", name="Account.myAccount")
     */
    public function myAccount(User $user)
    {
        return $this->render('admin/account/index.html.twig', [
            'user' => $user
        ]);
    }
}
