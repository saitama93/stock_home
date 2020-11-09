<?php

namespace App\Controller;

use App\Entity\Mark;
use App\Form\MarkType;
use App\Repository\MarkRepository;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminMarkController extends AbstractController
{
    /**
     * Permet d'afficher la liste des marques
     * 
     * @Route("/admin/mark/list/{page<\d+>?1}", name="AdminMark.index")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index($page, PaginationService $paginator) : Response
    {
        $paginator->setEntityClass(Mark::class)
            ->setCurrentPage($page)
            ->setLimit(10);

        return $this->render('admin/mark/index.html.twig', [
            'paginator' => $paginator
        ]);
    }

    /**
     * Permet d'ajouter une marque
     * 
     * @Route("/admin/mark/add", name ="AdminMark.add")
     * @IsGranted("ROLE_ADMIN")
     */
    public function add(Request $request, EntityManagerInterface $em){

        $mark = new Mark();
        $form = $this->createForm(MarkType::class, $mark);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($mark);
            $em->flush();

            $this->addFlash(
                'success', 
                "La marque {$mark->getWording()} a bien été ajoutée." 
            );

            return $this->redirectToRoute('AdminMark.index');
        }

        return $this->render('admin/mark/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

     /**
     * Permet de modifier une marque
     * 
     * @Route("/admin/mark/edit/{id}", name ="AdminMark.edit")
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit($id, Request $request, EntityManagerInterface $em, MarkRepository $markRepo){

        $mark = $markRepo->find($id);

        $form = $this->createForm(MarkType::class, $mark);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($mark);
            $em->flush();

            $this->addFlash(
                'success',
                "Succès de la modification du libellé"
            );

            return $this->redirectToRoute('AdminMark.index');
        }

        return $this->render('admin/mark/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de supprimer une marque
     * 
     * @Route("/admin/mark/delete/{id}", name ="AdminMark.delete")
     * @IsGranted("ROLE_ADMIN"))
     */
    public function delete($id, Request $request, MarkRepository $markRepo, EntityManagerInterface $em){

        $mark = $markRepo->find($id);

            $em->remove($mark);
            $em->flush();

            $this->addFlash(
                'danger',
                "La marque {$mark->getWording()} est définitivement supprimé."
            );

            return $this->redirectToRoute('AdminMark.index');
    
    }
}
