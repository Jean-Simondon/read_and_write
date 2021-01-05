<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\User;
use App\Entity\Author;
use App\Entity\Manuscript;
use App\Entity\Act;
use App\Entity\Chapter;
use App\Entity\Scene;
use App\Entity\Cell;

class ManuscriptFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->encoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {

        // la structure en 3 actes
        $actes = [
            'exposition',
            'confrontation',
            'dénouement',
        ];

        // Pour chaque User, 1 nom de plumes différents
        $authorsName = [
            'Aragon',
            'Balzac',
        ];

        for ($a = 0; $a < 2; $a++) {
            // User
            $user = new User();
            $user->setUsername('user_' . $a);
            $user->setEmail('jsimondon'.$a.'@yahoo.fr');
            $user->setFirstName('prénom');
            $user->setLastName('nom de famille');
            
            if( $a == 0) {
                $user->setRoles([]);
            } else {
                $user->setRolesWithAdmin([]);
            }

            // $user->setPassword(
            //     $this->encoder->encodePassword(
            //         $user,
            //         '123456',
            //     )
            // );

            $user->setPassword('$2y$13$YQcOPoEAntwtgkwAl5rOjO5riDYKdOsWTEW/6FuSzPiU7Vlrog19u');
            $manager->persist($user);

            // Auteur
            $author = new Author();
            $author->setPenName($authorsName[$a]);
            $author->setUser($user);
            $manager->persist($author);

            // Manuscrits pour chaque auteur
            for ($j = 0; $j < 2; $j++ ) {

                $manuscript = new Manuscript();
                $manuscript->setAuthor($author);
                $manuscript->setTitle('manuscrit ' . $j);
                $manuscript->setSubTitle('un sous-titre');
                $manuscript->setFourthCover('Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, fugiat. Sed deserunt sapiente veniam ut, molestiae, omnis accusamus nulla est perferendis ipsa corrupti repudiandae adipisci porro ad, blanditiis doloribus? Incidunt!');
                $manuscript->setStoryTelling('Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, fugiat. Sed deserunt sapiente veniam ut, molestiae, omnis accusamus nulla est perferendis ipsa corrupti repudiandae adipisci porro ad, blanditiis doloribus? Incidunt!');
                $manuscript->setType('science-fiction');
                $manuscript->setCover('cover_'.$j.'.png');

                $manager->persist($manuscript);

                // Actes pour chaque manuscrit
                for ($k = 0; $k < 3; $k++) {

                    $act = new Act();
                    $act->setTitle($actes[$k]);
                    $act->setManuscript($manuscript);

                    $manager->persist($act);

                    // Chapitres pour chaque acte
                    for($l = 0; $l < 4; $l++) {

                        $chapter = new Chapter();
                        $chapter->setTitle('chapter ' . $l);
                        $chapter->setIntroduction('...');
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
