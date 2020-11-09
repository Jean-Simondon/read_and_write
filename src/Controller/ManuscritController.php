<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Manuscrit;

class ManuscritController extends AbstractController
{
    /**
     * @Route("manuscrit", name="create_manuscrit)
     */
    public function createManuscrit(): Response
    {
        // Le manager, entité la plus importante de doctrine, pour écrire et lire dans la BDD
        $entityManager = $this->getDoctrine()->getManager();
        
        // instantiation et setup du nouvel objet
        $manuscrit = new Manuscrit();
        $manuscrit->setTitle('test');

        // say that you wantt to save the object
        $entityManager->persist($manuscrit);

        // insert or update the object
        $entityManager->flush();

        return new Response('Saved new manuscrit with id '.$manuscrit->getId());

    }

    /**
     * @Route("/manuscrit/{id}", name="manuscrit_show")
     */
    public function show(Manuscrit $manuscrit)
    {
        $manuscrit = $this->getDoctrine()
            ->getRepository(Manuscrit::class)
            ->find($id);

            if($manuscrit) {
                throw $this->createNotFoundException(
                    "No manuscrit found for id ".$id
                );
            }

            return new Response('Check out this great manuscrit:'.$manuscrit->getTitle());
    }


}
