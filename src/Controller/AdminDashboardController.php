<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminDashboardController extends AbstractController
{
    /**
     * Page d'accueilde l'admin avec stats
     * 
     * @Route("/admin/home", name="AdminDashboard.home")
     * @IsGranted("ROLE_ADMIN") 
     */
    public function home(){

        return $this->render('admin/dashboard/home.html.twig');
    }

    
    /**
     * Page d'accueil de l'adminstrateur
     * 
     * @Route("/admin/dashboard", name="AdminDashboard.index")
     * @IsGranted("ROLE_ADMIN"))
     */
    public function index()
    {
        $user = $this->getUser();

        // if ($this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            // dd('ADMIN');
        // }else{
            // dd('PAS ADMIN');
        // }
        return $this->render('admin/dashboard/index.html.twig');
    }
}
