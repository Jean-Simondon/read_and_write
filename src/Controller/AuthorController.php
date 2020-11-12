<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Author;

class AuthorController extends AbstractController
{
    /**
     * @Route("/archives_authors", name="archives_authors")
     */
    public function archives_authors()
    {
        return $this->render('pages/author/archives_authors.html.twig', [
            'title' => 'archives_authors',
        ]);
    }

    /**
     * @Route("/details_author", name="details_author")
     */
    public function details_author()
    {
        return $this->render('pages/author/details_author.html.twig', [
            'title' => 'details_author',
        ]);
    }
    
}
