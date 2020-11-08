<?php

namespace App\Controller;

use App\Entity\Mark;
use App\Service\PaginationService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminMarkController extends AbstractController
{
    /**
     * Permet d'afficher la liste des marques
     * 
     * @Route("/admin/mark/list/{page<\d+>?1}", name="AdminMark.index")
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
}
