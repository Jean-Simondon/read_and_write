<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Manuscript;
use App\Entity\Author;

class ManuscriptFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $author = new Author();
        $author->setLogin('mon login');
        $author->setLastName('Simondon');
        $author->setFirstName('Jean');
        $author->setPassword('1234');
        $author->setEmail('jsimondon@yahoo.fr');
        $manager->persist($author);

        for ($i = 0; $i < 2; $i++) {

            $manuscript = new Manuscript();
            $manuscript->setAuthor($author);
            $manuscript->setTitle('manuscrit '.$i);
            $manuscript->setAbstract('Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, fugiat. Sed deserunt sapiente veniam ut, molestiae, omnis accusamus nulla est perferendis ipsa corrupti repudiandae adipisci porro ad, blanditiis doloribus? Incidunt!');
            $manager->persist($manuscript);
        }

        $manager->flush();
    }
}
