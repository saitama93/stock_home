<?php

namespace App\Controller;

use App\Entity\Specificity;
use App\Form\SpecificityType;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SpecificityRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminSpeficityController extends AbstractController
{
    /**
     * Permet d'afficher la liste des spécificité
     * 
     * @Route("/admin/specifcity/list/{page<\d+>?1}", name="AdminSpecificity.index")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index($page, PaginationService $paginator) : Response
    {
        $paginator->setEntityClass(Specificity::class)
            ->setCurrentPage($page)
            ->setLimit(10);

        return $this->render('admin/specificity/index.html.twig', [
            'paginator' => $paginator
        ]);
    }

     /**
     * Permet d'ajouter une spécificité
     * 
     * @Route("/admin/specificity/add", name ="AdminSpecificity.add")
     * @IsGranted("ROLE_ADMIN")
     */
    public function add(Request $request, EntityManagerInterface $em){

        $specificity = new Specificity();
        $form = $this->createForm(SpecificityType::class, $specificity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($specificity);
            $em->flush();

            $this->addFlash(
                'success', 
                "La specificité {$specificity->getWording()} a bien été ajoutée." 
            );

            return $this->redirectToRoute('AdminSpecificity.index');
        }

        return $this->render('admin/specificity/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

     /**
     * Permet de modifier une spécificité
     * 
     * @Route("/admin/specificity/edit/{id}", name ="AdminSpecificity.edit")
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit($id, Request $request, EntityManagerInterface $em, SpecificityRepository $specificityRepo){

        $specificity = $specificityRepo->find($id);

        $form = $this->createForm(SpecificityType::class, $specificity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($specificity);
            $em->flush();

            $this->addFlash(
                'success',
                "Succès de la modification du libellé"
            );

            return $this->redirectToRoute('AdminSpecificity.index');
        }

        return $this->render('admin/specificity/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

     /**
     * Permet de supprimer une specificité
     * 
     * @Route("/admin/specificity/delete/{id}", name ="AdminSpecificity.delete")
     * @IsGranted("ROLE_ADMIN"))
     */
    public function delete($id, Request $request, SpecificityRepository $specificityRepo, EntityManagerInterface $em){

        $specificity = $specificityRepo->find($id);

            $em->remove($specificity);
            $em->flush();

            $this->addFlash(
                'danger',
                "La specificité {$specificity->getWording()} est définitivement supprimé."
            );

            return $this->redirectToRoute('AdminSpecificity.index');
    
    }
}
