<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Author;
use App\Repository\AuthorRepository;

class AuthorController extends AbstractController
{
    /**
     * @Route("/archives_authors", name="/archives_authors")
     */
    public function archives_authors(AuthorRepository $authorRepository)
    {
        $authors = $authorRepository->findAll();

        return $this->render('author/archives_authors.html.twig', [
            'title' => 'archives_authors',
            'authors' => $authors,
        ]);
    }

    /**
     * @Route("/details_author/{id}", name="/details_author")
     */
    public function details_author($id, AuthorRepository $authorRepository)
    {
        $author = $authorRepository->find($id);
        
        return $this->render('author/details_author.html.twig', [
            'title' => 'details_author',
            'author' => $author,
        ]);
    }


    
}
