<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminArchiveController extends AbstractController
{
    /**
     * Permet l'accès aux archives
     * 
     * @Route("/admin/archives", name="AdminArchive.index")
     */
    public function index()
    {
        return $this->render('admin/archive/index.html.twig');
    }

    /**
     * @Route("/admin/archive/list/{page<\d+>?1}", name="AdminArchive.users")
     */
    public function users($page, PaginationService $paginator)
    {
        $paginator->setEntityClass(User::class)
            ->setCurrentPage($page)
            ->setLimit(10);

        return $this->render('admin/user/index.html.twig', [
            'paginator' => $paginator,
            'present' => false
        ]);
    }

    /**
     * Permet de vraiment supprimer un utilisateur
     * 
     * @Route("/admin/archive/user/delete/{id}", name="AdminArchive.userDelete")
     */
    public function deleteUser(Request $request, $id, UserRepository $userRepo, EntityManagerInterface $em)
    {
        $user = $userRepo->find($id);

        if ($request->isMethod('POST')) {
            $em->remove($user);
            $em->flush();

            $this->addFlash(
                'danger',
                "Le compte de {$user->getFullName()} est définitivement supprimé."
            );

            return $this->redirectToRoute('AdminArchive.users');
        }

        return $this->render('admin/user/confirmDelete.html.twig', [
            'user' => $user,
            'present' => false
        ]);
    }

    /**
     * Permet d'activer un compte
     * 
     * @Route("/admin/archive/user/activate/{id}", name="AdminArchive.activateAccount")
     */
    public function activateAccount($id, EntityManagerInterface $em, UserRepository $userRepo)
    {

        $user = $userRepo->find($id);

        $user->setPresent(1);

        $em->persist($user);
        $em->flush();

        $this->addFlash(
            'success',
            "Le compte de {$user->getFullName()} est activé."
        );

        return $this->redirectToRoute('AdminUser.index');
    }
}
