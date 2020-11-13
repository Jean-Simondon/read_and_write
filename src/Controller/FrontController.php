<?php

namespace App\Controller;

use Doctrine\Persistence\ObjectManager;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Manuscript;
use App\Entity\Author;

use App\Repository\ManuscriptRepository;
use App\Repository\AuthorRepository;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="/home")
     */
    public function index2()
    {
        return $this->render('pages/home.html.twig', [
            'title' => 'HomePage',
        ]);
    }

}
