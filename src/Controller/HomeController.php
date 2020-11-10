<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="Home.index")
     * @IsGranted("ROLE_USER"))
     */
    public function index(AuthenticationUtils $authenticationUtils)
    {
        if ($this->getUser()) {
            $roles = $this->getUser()->getRoles();

            if (($this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
                && ($this->container->get('security.authorization_checker')->isGranted('ROLE_USER'))) {
                return $this->render('admin/home/index.html.twig', [
                    'role' => $roles
                ]);
            } elseif ($this->container->get('security.authorization_checker')->isGranted('ROLE_USER')) {
                return $this->render('home/index.html.twig', [
                    'role' => $roles
                ]);
            }
        }


        return $this->render('home/index.html.twig');
    }
}
