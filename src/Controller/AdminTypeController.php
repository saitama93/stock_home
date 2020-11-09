<?php

namespace App\Controller;

use App\Entity\Type;
use App\Form\TypeType;
use App\Repository\TypeRepository;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminTypeController extends AbstractController
{
   /**
     * Permet d'afficher la liste des types de l'application
     * 
     * @Route("/admin/type/list/{page<\d+>?1}", name="AdminType.index")
     * @IsGranted("ROLE_ADMIN"))
     */
    public function index($page, PaginationService $paginator): Response
    {
        $paginator->setEntityClass(Type::class)
            ->setCurrentPage($page)
            ->setLimit(10);

        return $this->render('admin/type/index.html.twig',[
            'paginator' => $paginator,
        ]);
    }

    /**
     * Permet d'ajouter un type
     * 
     * @Route("/admin/type/add", name ="AdminType.add")
     * @IsGranted("ROLE_ADMIN")
     */
    public function add(Request $request, EntityManagerInterface $em){

        $type = new Type();
        $form = $this->createForm(TypeType::class, $type);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($type);
            $em->flush();

            $this->addFlash(
                'success', 
                "Le type {$type->getWording()} a bien été ajouté." 
            );

            return $this->redirectToRoute('AdminType.index');
        }

        return $this->render('admin/type/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de modifier un type
     * 
     * @Route("/admin/type/edit/{id}", name ="AdminType.edit")
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit($id, Request $request, EntityManagerInterface $em, TypeRepository $typeRepo){

        $type = $typeRepo->find($id);

        $form = $this->createForm(TypeType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($type);
            $em->flush();

            $this->addFlash(
                'success',
                "Succès de la modification du libellé"
            );

            return $this->redirectToRoute('AdminType.index');
        }

        return $this->render('admin/type/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

     /**
     * Permet de supprimer un type
     * 
     * @Route("/admin/type/delete/{id}", name ="AdminType.delete")
     * @IsGranted("ROLE_ADMIN"))
     */
    public function delete($id, Request $request, TypeRepository $typeRepo, EntityManagerInterface $em){

        $type = $typeRepo->find($id);

            $em->remove($type);
            $em->flush();

            $this->addFlash(
                'danger',
                "Le type {$type->getWording()} est définitivement supprimé."
            );

            return $this->redirectToRoute('AdminType.index');
    
    }
}
