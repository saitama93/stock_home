<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminHomeController extends AbstractController
{
    /**
     * @Route("/admin/home", name="AdminHome.index")
     * @IsGranted("ROLE_ADMIN"))
     */
    public function index()
    {
        return $this->render('admin_home/index.html.twig', [
            'controller_name' => 'AdminHomeController',
        ]);
    }
}
