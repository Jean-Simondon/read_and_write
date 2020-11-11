<?php

namespace App\Controller;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Manuscript;
use App\Entity\Author;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        $author = new Author();
        $author->setLastName('bernard');
        $author->setFirstName('xavier');
        
        $entityManager->persist($author);

        $manuscript = new Manuscript();
        $manuscript->setTitle('Un nouveau manuscrit');
        $manuscript->setAuthor($author);

        $entityManager->persist($manuscript);

        $entityManager->flush();

        return $this->render('pages/home.html.twig', [
            'title' => 'HomePage',
        ]);
    }

}
