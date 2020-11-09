<?php

namespace App\Controller;

use App\Entity\Location;
use App\Form\LocationType;
use App\Service\PaginationService;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminLocationController extends AbstractController
{
    /**
     * Permet d'afficher la liste des sites de l'application
     * 
     * @Route("/admin/location/list/{page<\d+>?1}", name="AdminLocation.index")
     * @IsGranted("ROLE_ADMIN"))
     */
    public function index($page, PaginationService $paginator): Response
    {
        $paginator->setEntityClass(Location::class)
            ->setCurrentPage($page)
            ->setLimit(10);

        return $this->render('admin/location/index.html.twig',[
            'paginator' => $paginator,
        ]);
    }

    /**
     * Permet d'ajouter un site
     * 
     * @Route("/admin/location/add", name ="AdminLocation.add")
     * @IsGranted("ROLE_ADMIN")
     */
    public function add(Request $request, EntityManagerInterface $em){

        $location = new Location();
        $form = $this->createForm(LocationType::class, $location);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($location);
            $em->flush();

            $this->addFlash(
                'success', 
                "Le site {$location->getWording()} a bien été ajouté." 
            );

            return $this->redirectToRoute('AdminLocation.index');
        }

        return $this->render('admin/location/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de modifier un site
     * 
     * @Route("/admin/location/edit/{id}", name ="AdminLocation.edit")
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit($id, Request $request, EntityManagerInterface $em, LocationRepository $locationRepo){

        $location = $locationRepo->find($id);

        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($location);
            $em->flush();

            $this->addFlash(
                'success',
                "Succès de la modification du libellé"
            );

            return $this->redirectToRoute('AdminLocation.index');
        }

        return $this->render('admin/location/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de supprimer un site
     * 
     * @Route("/admin/location/delete/{id}", name ="AdminLocation.delete")
     * @IsGranted("ROLE_ADMIN"))
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
