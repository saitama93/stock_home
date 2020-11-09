<?php

namespace App\Controller;

use App\Entity\Status;
use App\Form\StatusType;
use App\Service\PaginationService;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminStatusController extends AbstractController
{
    /**
     * Permet d'afficher la liste des statuts
     * 
     * @Route("/admin/status/list/{page<\d+>?1}", name="AdminStatus.index")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index($page, PaginationService $paginator) : Response
    {
        $paginator->setEntityClass(Status::class)
            ->setCurrentPage($page)
            ->setLimit(10);

        return $this->render('admin/status/index.html.twig', [
            'paginator' => $paginator
        ]);
    }

     /**
     * Permet d'ajouter un statut
     * 
     * @Route("/admin/status/add", name ="AdminStatus.add")
     * @IsGranted("ROLE_ADMIN")
     */
    public function add(Request $request, EntityManagerInterface $em){

        $status = new Status();
        $form = $this->createForm(StatusType::class, $status);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($status);
            $em->flush();

            $this->addFlash(
                'success', 
                "Le statut {$status->getWording()} a bien été ajouté." 
            );

            return $this->redirectToRoute('AdminStatus.index');
        }

        return $this->render('admin/status/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

     /**
     * Permet de modifier une statut
     * 
     * @Route("/admin/status/edit/{id}", name ="AdminStatus.edit")
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit($id, Request $request, EntityManagerInterface $em, StatusRepository $statusRepo){

        $status = $statusRepo->find($id);

        $form = $this->createForm(StatusType::class, $status);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($status);
            $em->flush();

            $this->addFlash(
                'success',
                "Succès de la modification du libellé"
            );

            return $this->redirectToRoute('AdminStatus.index');
        }

        return $this->render('admin/status/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

     /**
     * Permet de supprimer un statut
     * 
     * @Route("/admin/status/delete/{id}", name ="AdminStatus.delete")
     * @IsGranted("ROLE_ADMIN"))
     */
    public function delete($id, Request $request, StatusRepository $statusRepo, EntityManagerInterface $em){

        $status = $statusRepo->find($id);

            $em->remove($status);
            $em->flush();

            $this->addFlash(
                'danger',
                "Le statut {$status->getWording()} est définitivement supprimé."
            );

            return $this->redirectToRoute('AdminStatus.index');
    
    }
}
