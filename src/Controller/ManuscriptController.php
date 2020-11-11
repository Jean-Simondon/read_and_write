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
     * @Route("/manuscript/{id}", name="manuscript_show")
     */
    public function show($id): Response
    {
        $manuscript = $this->getDoctrine()
        ->getRepository(Manuscript::class)
        ->find($id);

        // if (!$manuscript) {
        //     throw $this->createNotFoundException(
        //         'No manuscript found for id '.$id
        //     );
        // }

        var_dump($manuscript);
        die();
        // return new Response('Check out this great product: '.$manuscript->getTitle());
    }


    /**
     * @Route("/manuscript_create", name="create_manuscript")
     */
    public function createManuscript(): Response
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $manuscrit = new Manuscript();
        $manuscrit->setTitle('le titre');
        $manuscrit->setAbstract('Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sapiente itaque et, natus voluptas reprehenderit illo voluptatibus dolore consequuntur iure, ratione maiores corporis impedit eius voluptate debitis expedita adipisci! Perferendis, aliquam.');
        $manuscrit->setType('Science-fiction');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($manuscrit);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$manuscrit->getId());
    }





}
