<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ManuscriptRepository;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Author;
use App\Entity\Manuscript;
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
     * @Route("/details_manuscript/{id}", name="/details_manuscript")
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
}
