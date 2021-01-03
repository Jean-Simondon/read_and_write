<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\UserType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class UserController extends AbstractController
{
    /**
     * @Route("/archive_user", name="all_user")
     * @isGranted("ROLE_ADMIN")
     */
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->render('user/archive.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/create_user", name="create_user")
     * @isGranted("ROLE_ADMIN")
     */
    public function create(Request $request): Response
    {

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            
            $this->addFlash('success', 'Un nouvel utilisateur a été ajouté');

            return $this->redirectToRoute('all_user');
        }

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/update_user/{id}", name="update_user")
     * @isGranted("ROLE_ADMIN")
     */
    public function update(Request $request,  User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
    
            $this->addFlash('success', 'L\'utilisateur a bien été mis à jour');

            return $this->redirectToRoute('all_user');
        }

        return $this->render('registration/update.html.twig', [
            'updateForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/remove_user/{id}", name="remove_user")
     * @isGranted("ROLE_ADMIN")
     */
    public function delete(User $user): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('success', 'L\'utilisateur a bien été supprimé');

        return $this->redirectToRoute('all_user');
    }


}
