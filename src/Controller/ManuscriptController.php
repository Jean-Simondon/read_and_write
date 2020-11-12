<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ManuscriptRepository;

use App\Entity\Author;
use App\Entity\Manuscript;
use App\Entity\Act;
use App\Entity\Chapter;
use App\Entity\Scene;
use App\Entity\Cell;

class ManuscriptController extends AbstractController
{
    /**
     * @Route("/archives_manucripts", name="archives_manucripts")
     */
    public function archives_manucripts()
    {
        return $this->render('pages/manuscript/archives_manucripts.html.twig', [
            'title' => 'Manuscrits',
        ]);
    }

    /**
     * @Route("/archives_my_manuscripts", name="archives_my_manuscripts")
     */
    public function archives_my_manuscripts()
    {
        return $this->render('pages/manuscript/archives_my_manuscripts.html.twig', [
            'title' => 'Mes Manuscrits',
        ]);
    }

    /**
     * @Route("/details_manuscript/{id}", name="details_manuscript")
     */
    public function details_manuscript($id)
    {
        return $this->render('pages/manuscript/details_manuscript.html.twig', [
            'title' => 'Un Manuscrit',
        ]);
    }

    /**
     * @Route("/details_my_manuscript/{id}", name="details_my_manuscript")
     */
    public function details_my_manuscript($id)
    {
        return $this->render('pages/manuscript/details_my_manuscript.html.twig', [
            'title' => 'Mon Manuscrit',
        ]);
    }    
}
