<?php

namespace App\Controller;

use App\Entity\Equipment;
use App\Form\EquipmentType;
use App\Service\PaginationService;
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
     * Permet de supprimer un matériel
     * 
     * @Route("/admin/equipment/delete/{id}", name="AdminEquipment.delete")
     */
    public function delete($id, EntityManagerInterface $em, EquipmentRepository $equipmentRepo)
    {
        $equipment = $equipmentRepo->find($id);

        $equipment->setDeleted(true);

        $em->persist($equipment);
        $em->flush();

        $this->addFlash(
            'danger',
            "Le matériel à été enelvé du stock"
        );

        return $this->redirectToRoute('AdminEquipment.index');

    }
}
