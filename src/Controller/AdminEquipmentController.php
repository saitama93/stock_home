<?php

namespace App\Controller;

use DateTimeInterface;
use App\Entity\Equipment;
use App\Form\EquipmentType;
use App\Form\UpdateEquipmentType;
use App\Service\PaginationService;
use App\Repository\StatusRepository;
use App\Repository\EquipmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminEquipmentController extends AbstractController
{
   /**
     * Permet d'afficher la liste des matériels de l'application
     * 
     * @Route("/admin/equipment/list/{page<\d+>?1}", name="AdminEquipment.index")
     * @IsGranted("ROLE_ADMIN"))
     */
    public function index($page, PaginationService $paginator): Response
    {
        $paginator->setEntityClass(Equipment::class)
            ->setCurrentPage($page)
            ->setLimit(10);

        return $this->render('admin/equipment/index.html.twig',[
            'paginator' => $paginator,
            'deleted' => false
        ]);
    }

   
    /**
     * Permet d'ajouter un matériel
     * 
     * @Route("/admin/equipment/add", name="AdminEquipment.add")
     * @IsGranted("ROLE_ADMIN")
     */
   public function add (Request $request, EntityManagerInterface $em){

        $equipment = new Equipment();
        
        $form = $this->createForm(EquipmentType::class, $equipment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $keywords = "{$equipment->getMark()->getWording()}, {$equipment->getSpecificity()->getWording()}";
            $equipment->setDeleted(false)
                ->setManipulatedAt(new \DateTime())
                ->setSerialNumber(\uniqid())
                ->setKeywords($keywords);

            $em->persist($equipment);
            $em->flush();

            $this->addFlash(
                'success', 
                "Le matériel a bien été ajouté!"
            );

            return $this->redirectToRoute('AdminEquipment.index');
        }

        return $this->render('admin/equipment/add.html.twig', [
            'form' => $form->createView(),
            'deleted' => false
        ]);
   }
   
   
    /**
     * Permet de modifier un matériel
     * 
     * @Route("/admin/equipment/edit/{id}", name="AdminEquipment.edit")
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit($id, Request $request, EntityManagerInterface $em, EquipmentRepository $equipmentRepo){

        $equipment = $equipmentRepo->find($id);

        $form = $this->createForm(UpdateEquipmentType::class, $equipment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $keywords = "{$equipment->getMark()->getWording()}, {$equipment->getSpecificity()->getWording()}";
            $equipment->setKeywords($keywords);

            $em->persist($equipment);
            $em->flush();

            $this->addFlash(
                'success', 
                "Le matériel a bien été mmodifié!"
            );

            return $this->redirectToRoute('AdminEquipment.index');
        }

        return $this->render('admin/equipment/edit.htlm.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de supprimer un matériel
     * 
     * @Route("/admin/equipment/delete/{id}", name="AdminEquipment.delete")
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete($id, EntityManagerInterface $em, EquipmentRepository $equipmentRepo, StatusRepository $statusRepo)
    {   
        $status = $statusRepo->findOneBy(['wording' => 'A réformer']);
        $equipment = $equipmentRepo->find($id);
        $user = $this->getUser();

        $equipment->setDeleted(true)
            ->setManipulatedAt(new \DateTime)
            ->setStatus($status)
            ->setUser($user);

        $em->persist($equipment);
        $em->flush();

        $this->addFlash(
            'danger',
            "Le matériel à été enelvé du stock"
        );

        return $this->redirectToRoute('AdminEquipment.index');

    }
}
