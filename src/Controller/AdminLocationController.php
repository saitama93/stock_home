<?php

namespace App\Controller;

use App\Entity\Location;
use App\Service\PaginationService;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminLocationController extends AbstractController
{
    /**
     * Permet d'afficher la liste des sites de l'application
     * 
     * @Route("/admin/location/list/{page<\d+>?1}", name="AdminLocation.index")
     */
    public function index($page, PaginationService $paginator): Response
    {
        $paginator->setEntityClass(Location::class)
            ->setCurrentPage($page)
            ->setLimit(10);

        return $this->render('admin/location/index.html.twig',[
            'paginator' => $paginator
        ]);
    }

    /**
     * Permet de supprimer un site
     * 
     * @Route("/admin/location/delete/{id}", name ="AdminLocation.delete")
     */
    public function delete($id, Request $request, LocationRepository $locationRepo, EntityManagerInterface $em){

        $location = $locationRepo->find($id);

            $em->remove($location);
            $em->flush();

            $this->addFlash(
                'danger',
                "Le site {$location->getWording()} est définitivement supprimé."
            );

            return $this->redirectToRoute('AdminLocation.index');
    
    }
}
