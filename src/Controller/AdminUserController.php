<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminUserController extends AbstractController
{
    /**
     * @Route("/admin/user/list/{page<\d+>?1}", name="AdminUser.index")
     */
    public function index($page, PaginationService $paginator)
    {
        $paginator->setEntityClass(User::class)
            ->setCurrentPage($page)
            ->setLimit(10);

        return $this->render('admin/user/index.html.twig', [
            'paginator' => $paginator,
            'present' => true
        ]);
    }

    /**
     * Affiche la liste des utilisateurs
     * 
     * @Route("/admin/user/add", name="AdminUser.add")
     */
    public function add(Request $request,  UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em)
    {

        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPasswd = $user->getPassword();
            $user->setPlainPassword($plainPasswd);

            $password = $passwordEncoder->encodePassword($user, $plainPasswd);
            $user->setPassword($password);

            $user->setPresent(1);
            $em->persist($user);
            $em->flush();
            $this->addFlash(
                'success',
                "Compte de {$user->getFullName()} créé et un mail vous a été envoyé avec vos identifiants"
            );

            return $this->redirectToRoute('AdminUser.index');
        }

        return $this->render('admin/user/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de modifier les utilisateurs
     * 
     * @Route("admin/user/edit/{id}",name="AdminUser.edit",methods={"GET","POST"})
     * 
     */
    public function edit(Request $request, $id, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em, UserRepository $userRepo)
    {
        $user = $userRepo->find($id);
        $check = '';
        $form =  $this->createForm(RegistrationType::class, $user);
        $plainPasswd = $user->getPassword();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $plainPasswd = $user->getPassword();
                $user->setPlainPassword($plainPasswd);
                $password = $passwordEncoder->encodePassword($user, $plainPasswd);
                $user->setPassword($password);

                // if ($user->getId() != 1 && $user->getId() != 2) {
                //     switch ($_POST['roles']) {
                //         case 0:
                //             $user->setRoles(array());
                //             break;
                //         case 1:
                //             $user->setRoles(array('ROLE_ADMIN'));
                //             break;
                //         case 2:
                //             $user->setRoles(array('ROLE_PUBLIC'));
                //             break;
                //         default:
                //             $user->setRoles(array());
                //             break;
                //     }
                // }

                $user->setPresent(1);
                $em->persist($user);
                $em->flush();
                $this->addFlash(
                    'success',
                    "Informations du compte de {$user->getFullName()} modifiées."
                );

                //Création et envoie de mail    

                // sendMail prend en parametres:
                // Le message du mail
                // L'expéditeur du mail
                // Le destinataire du mail
                // L'objet du mail
                // Le nom de l'expéditeur
                // $mailerService->sendMail(
                //     'Voici vos informations utilisateurs afin d\'accéder à l\'application',
                //     'rononoa.zoro@mugiwara.fr',
                //     'igal.ilmiamir@doubs.fr',
                //     'Création de compte',
                //     'Zoro'
                // );

                return $this->redirectToRoute('AdminUser.index');
            }
        }
        return $this->render('admin/user/edit.html.twig', [
            'id' => $id,
            'user' => $user,
            'check' => $check,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Permet de supprimer un utilisateur avec page de confirmation
     * 
     * @Route("admin/user/delete/{id}",name="AdminUser.delete",methods={"GET","POST"})
     */
    public function archive(Request $request, $id, UserRepository $userRepo, EntityManagerInterface $em)
    {

        $user = $userRepo->find($id);

        if ($request->isMethod('POST')) {
            $user->setPresent(0);
            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'danger',
                "Le compte de {$user->getFullName()} a bien été désactivé."
            );

            return $this->redirectToRoute('AdminUser.index');
        }
        return $this->render(
            'admin/user/confirmDelete.html.twig',
            [
                'user' => $user,
                'present' => true
            ]
        );
    }
}
