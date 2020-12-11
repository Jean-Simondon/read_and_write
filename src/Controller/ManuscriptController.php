<?php

namespace App\Controller;

use App\Entity\Manuscript;
use App\Repository\ManuscriptRepository;
use App\Form\ManuscriptType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Author;
use App\Entity\Act;
use App\Entity\Chapter;
use App\Entity\Scene;
use App\Entity\Cell;

class ManuscriptController extends AbstractController
{
    /**
     * @Route("/archives_manucripts", name="/archives_manucripts")
     */
    public function archives_manucripts(ManuscriptRepository $manuscriptRepository)
    {

        $manuscripts = $manuscriptRepository->findAll();

        return $this->render('manuscript/archives-manucripts.html.twig', [
            'title' => 'Manuscrits',
            'manuscripts' => $manuscripts,
        ]);
    }

    /**
     * @Route("/archives_my_manuscripts/{id}", name="/archives_my_manuscripts")
     */
    public function archives_my_manuscripts($id, ManuscriptRepository $manuscriptRepository)
    {
        if($id == null) {
            // get current user;
        }

        $repository = $this->getDoctrine()->getRepository(Manuscript::class);
        $manuscripts = $repository->findBy(
            ['author' => $id],
        );

        return $this->render('manuscript/archives-manucripts.html.twig', [
            'title' => 'Mes/Ses Manuscrits',
            'manuscripts' => $manuscripts,
        ]);
    }

    /**
     * @Route("/details_manuscript/{id}", name="details_manuscript")
     */
    public function details_manuscript($id, ManuscriptRepository $manuscriptRepository)
    {
        $manuscript = $manuscriptRepository->find($id);

        return $this->render('manuscript/details_manuscript.html.twig', [
            'title' => 'Un Manuscrit',
            'manuscript' => $manuscript,
        ]);
    }

    /**
     * @Route("/details_my_manuscript/{id}", name="/details_my_manuscript")
     */
    public function details_my_manuscript($id)
    {
        return $this->render('manuscript/details_my_manuscript.html.twig', [
            'title' => 'Mon Manuscrit',
        ]);
    }

    /**
     * @Route("/manuscript/create", name="manuscript_admin_create")
     */
    public function createManuscript(Request $request): Response
    {
        $manuscript = new Manuscript();

        $form = $this->createForm(ManuscriptType::class, $manuscript);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $manuscript = $form->getData();
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($manuscript);
            $entityManager->flush();
    
            $this->addFlash('success', 'Un nouveau manuscrit, un nouveau projet');

            return $this->redirectToRoute('manuscript_success');
        }

        return $this->render('manuscript/new.html.twig', [
            'form' => $form->createView(),
        ]);

    }
    
    /**
     * 
     * @Route("delete/{id}", name="manuscript_delete")
     */
    public function delete(Request $request, Manuscript $manuscript): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($manuscript);
        $entityManager->flush();

        return $this->redirectToRoute('liste_manuscripts');
    }

    /**
     * 
     * @Route("manuscript/edit/{id}", name="update_manuscript")
     */
    public function update(Request $request, Manuscript $manuscript): Response
    {
        $form = $this->createForm(ManuscriptType::class, $manuscript);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $manuscript = $form->getData();
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($manuscript);
            $entityManager->flush();
    
            $this->addFlash('success', 'Votre manuscrit a bien été mis à jour');

            return $this->redirectToRoute('manuscript_success');
        }

        return $this->render('manuscript/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }



}
