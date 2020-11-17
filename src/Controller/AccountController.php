<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    /**
     * Permet de se connecter à l'appli
     * @Route("/login", name="Account.login")
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $lastUser = $utils->getLastUsername();

        return $this->render('account/login.html.twig',[
            'hasError' => $error !== null,
            'lastUser' => $lastUser
        ]);
    }

    /**
     * Permet de se déconnecté de l'appli
     * 
     * @Route("/logout", name="Account.logout")
     * 
     * @return void
     */
    public function logout(){ }

    
    /**
     * Permet de visualiser le profil de l'utilisateur connecté
     * 
     * @Route("/account/profile", name="Account.profile")
     * @IsGranted("ROLE_USER")
     */
    public function profile()
    {
        return $this->render('admin/account/profile.html.twig');
    }
}
