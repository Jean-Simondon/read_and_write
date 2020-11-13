<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Author;
use App\Entity\Manuscript;
use App\Entity\Act;
use App\Entity\Chapter;
use App\Entity\Scene;
use App\Entity\Cell;

class ManuscriptFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        // Auteur
        for ($i = 0; $i < 2; $i++) {

            $author = new Author();
            $author->setLogin('blablalogin');
            $author->setLastName('LN Author ' . $i);
            $author->setFirstName('FN Author ' . $i);
            $author->setPenName('PN Author ' . $i);
            $author->setPassword('PW 1234');
            $author->setEmail('EM blabla@blabla.fr');
            $manager->persist($author);

            // Manuscrits pour chaque auteur
            for ($j = 0; $j < 2; $j++ ) {

                $manuscript = new Manuscript();
                $manuscript->setAuthor($author);
                $manuscript->setTitle('manuscrit '.$j);
                $manuscript->setAbstract('Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, fugiat. Sed deserunt sapiente veniam ut, molestiae, omnis accusamus nulla est perferendis ipsa corrupti repudiandae adipisci porro ad, blanditiis doloribus? Incidunt!');
                $manuscript->setType('science-fiction');

                $manager->persist($manuscript);

                // Actes pour chaque manuscrit
                for ($k = 0; $k < 3; $k++) {

                    $act = new Act();
                    $act->setTitle('act' . $k);
                    $act->setManuscript($manuscript);

                    $manager->persist($act);

                     // Chapitres pour chaque acte
                    for($l = 0; $l < 4; $l++) {

                        $chapter = new Chapter();
                        $chapter->setTitle('chapter ' . $l);
                        $chapter->setIntroduction('lorem ipsum norem dolum');
                        $chapter->setPublished(1);
                        $chapter->setAct($act);

                        $manager->persist($chapter);

                         // Scenes pour chaque chapitre
                        for($m = 0; $m < 5; $m++) {
                        
                            $scene = new Scene();
                            $scene->setTitle('scene ' . $m); 
                            $scene->setPublished(1);
                            $scene->setChapter($chapter);

                            $manager->persist($scene);

                            // Cellules pour chaque scene
                            for($n = 0; $n < 10; $n++) {

                                $cell = new Cell();
                                $cell->setTextContent('Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur impedit est eum, amet maiores dolorum modi quod atque magnam fuga nobis optio ipsam excepturi expedita unde quisquam id non aliquam?');
                                $cell->setScene($scene);
                                $cell->setPublished(1);
                                $cell->setType('action');

                                $manager->persist($cell);

                            }   
                        }
                    }
                }
            }
        }
        $manager->flush();
    }
}
