<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InterventionController extends AbstractController
{
    /**
     * Permet de partir/revenir d'intervention
     * 
     * @Route("/intervention", name="Intervention.index")
     * @IsGranted("ROLE_USER")
     */
    public function index(): Response
    {
        return $this->render('intervention/index.html.twig');
    }
}
