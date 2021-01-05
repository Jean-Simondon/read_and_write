<?php

namespace App\Controller;

use App\Entity\Manuscript;
use App\Repository\ManuscriptRepository;
use App\Form\ManuscriptType;

use Symfony\Component\Security\Core\User\UserProviderInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Author;
use App\Entity\Act;
use App\Entity\Chapter;
use App\Entity\Scene;
use App\Entity\Cell;

class ManuscriptController extends AbstractController
{
    /**
     * @Route("/archives_manucripts", name="archives_manucripts")
     */
    public function archives_manucripts(ManuscriptRepository $manuscriptRepository)
    {

        $manuscripts = $manuscriptRepository->findAll();

        return $this->render('manuscript/archives-manucripts.html.twig', [
            'title' => 'Manuscrits',
            'manuscripts' => $manuscripts,
        ]);
    }

    /**
     * @Route("/archives_my_manuscripts", name="archives_my_manuscripts")
     */
    public function archives_my_manuscripts(ManuscriptRepository $manuscriptRepository)
    {

        // $result = $manuscriptRepository->findOrderedByAuthorAndCreateDate($this->getUser()->getId());
        // dump($result);
        // die();

        $userId = $this->getUser()->getId();
        $authors = $this->getDoctrine()->getRepository(Author::class)->findBy(['User' => $userId]);

        $manuscripts = [];
        foreach($authors as $author) {
            $authorId = $author->getId();
            $manuscripts[$author->getPenName()] = $this->getDoctrine()->getRepository(Manuscript::class)->findBy(['author' => $authorId]);
        }

        return $this->render('manuscript/archives-my-manuscripts.html.twig', [
            'title' => 'Mes Manuscrits',
            'manuscriptsByAuthors' => $manuscripts,
        ]);
    }

    /**
     * @Route("/details_manuscript/{id}", name="details_manuscript")
     */
    public function details_manuscript($id, ManuscriptRepository $manuscriptRepository)
    {
        $manuscript = $manuscriptRepository->find($id);

        return $this->render('manuscript/details_manuscript.html.twig', [
            'title' => 'Un Manuscrit',
            'manuscript' => $manuscript,
        ]);
    }

    /**
     * @Route("/details_my_manuscript/{id}", name="details_my_manuscript")
     */
    public function details_my_manuscript($id)
    {
        return $this->render('manuscript/details_my_manuscript.html.twig', [
            'title' => 'Mon Manuscrit',
        ]);
    }

    /**
     * @Route("/manuscript/create", name="manuscript_create")
     */
    public function create(Request $request): Response
    {
        if ( !$this->getUser()) {
            $this->addFlash('connection', 'Vous devez être connecté pour créer un manuscrit');
            return $this->redirectToRoute('app_login');
        }

        $manuscript = new Manuscript();

        $form = $this->createForm(ManuscriptType::class, $manuscript);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $manuscript = $form->getData();

            $manuscript->setCreatedAt(new \DateTime('now'));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($manuscript);
            $entityManager->flush();
    
            $this->addFlash('success', 'Un nouveau manuscrit, un nouveau projet');

            return $this->redirectToRoute('details_manuscript', [
                'id' => $manuscript->getId()
                ]);
        }

        return $this->render('manuscript/new.html.twig', [
            'form' => $form->createView(),
        ]);

    }
    
    
    /**
     * 
     * @Route("delete/{id}", name="manuscript_delete")
     * @isGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Manuscript $manuscript): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($manuscript);
        $entityManager->flush();

        return $this->redirectToRoute('liste_manuscripts');
    }

    /**
     * 
     * @Route("manuscript/edit/{id}", name="update_manuscript")
     * @isGranted("ROLE_ADMIN")
     */
    public function update(Request $request, Manuscript $manuscript): Response
    {
        $form = $this->createForm(ManuscriptType::class, $manuscript);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $manuscript = $form->getData();
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($manuscript);
            $entityManager->flush();
    
            $this->addFlash('success', 'Votre manuscrit a bien été mis à jour');

            return $this->redirectToRoute('manuscript_success');
        }

        return $this->render('manuscript/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * 
     * @Route("manuscript/chapters/{id}", name="get_chapters")
     */
    public function getChapters(Request $request, Manuscript $manuscript): Response
    {
        $currentAct = $request->request->get('currentAct');

        $act = $this->getDoctrine()->getRepository(Act::class)->find($currentAct);
        $chapters = $act->getChapters();

        $jsonData = [];
        foreach($chapters as $chapter) {
            $temp = [
                'id' => $chapter->getId(),
                'title' => $chapter->getTitle(),
            ];
            $jsonData[] = $temp;
        }

        return new JsonResponse($jsonData);
    }

    /**
     * 
     * @Route("manuscript/scenes/{id}", name="get_scenes")
     */
    public function getScene(Request $request, Manuscript $manuscript): Response
    {
        $currentChapter = $request->request->get('currentChapter');

        $chapter = $this->getDoctrine()->getRepository(Chapter::class)->find($currentChapter);
        $scenes = $chapter->getScenes();

        $jsonData = [];
        foreach($scenes as $scene) {
            $temp = [
                'id' => $scene->getId(),
                'title' => $scene->getTitle(),
            ];
            $jsonData[] = $temp;
        }
        return new JsonResponse($jsonData);
    }

    /**
     * 
     * @Route("manuscript/cells/{id}", name="get_cells")
     */
    public function getCells(Request $request, Manuscript $manuscript): Response
    {
        $currentScene = $request->request->get('currentScene');

        $scene = $this->getDoctrine()->getRepository(Scene::class)->find($currentScene);
        $cells = $scene->getCells();

        $jsonData = [];
        foreach($cells as $cell) {
            $temp = [
                'id' => $cell->getId(),
                'textContent' => $cell->getTextContent(),
            ];
            $jsonData[] = $temp;
        }
        return new JsonResponse($jsonData);
    }

    /**
     * 
     * @Route("manuscript/new_act/{id}", name="add_act")
     */
    public function setAct(Request $request, Manuscript $manuscript): Response
    {
        $currentAct = $request->request->get('currentAct');

        $act = new Act;
        $act->setManuscript($manuscript);
        $act->setTitle("...");
        $manuscript->addAct($act);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($act);
        $entityManager->persist($manuscript);
        $entityManager->flush();

        return new JsonResponse(['id' => $act->getId()]);
    }

    /**
     * 
     * @Route("manuscript/new_chapter/{id}", name="add_chapter")
     */
    public function setChapter(Request $request, Manuscript $manuscript): Response
    {
        $currentAct = $request->request->get('currentAct');
        $act = $this->getDoctrine()->getRepository(Act::class)->find($currentAct);

        $chapter = new Chapter;
        $chapter->setAct($act);
        $chapter->setTitle("...");
        $chapter->setIntroduction("...");
        $chapter->setPublished(true);
        $act->addChapter($chapter);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($act);
        $entityManager->persist($chapter);
        $entityManager->flush();

        return new JsonResponse(['id' => $chapter->getId()]);
    }

    /**
     * 
     * @Route("manuscript/new_scene/{id}", name="add_scene")
     */
    public function setScene(Request $request, Manuscript $manuscript): Response
    {
        $currentChapter = $request->request->get('currentChapter');
        $chapter = $this->getDoctrine()->getRepository(Chapter::class)->find($currentChapter);

        $scene = new Scene;
        $scene->setChapter($chapter);
        $scene->setTitle("...");
        $scene->setPublished(true);
        $chapter->addScene($scene);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($chapter);
        $entityManager->persist($scene);
        $entityManager->flush();

        return new JsonResponse(['id' => $scene->getId()]);
    }

    /**
     * 
     * @Route("manuscript/new_cell/{id}", name="add_cell")
     */
    public function setCell(Request $request, Manuscript $manuscript): Response
    {
        $currentScene = $request->request->get('currentScene');
        $scene = $this->getDoctrine()->getRepository(Scene::class)->find($currentScene);

        $cell = new Cell;
        $cell->setScene($scene);
        $cell->setTextContent("...");
        $cell->setPublished(true);
        $scene->addCell($cell);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($scene);
        $entityManager->persist($cell);
        $entityManager->flush();

        return new JsonResponse(['id' => $cell->getId()]);
    }

    

    /**
     * 
     * @Route("manuscript/edit_act/{id}", name="edit_act")
     */
    public function editAct(Request $request, Manuscript $manuscript): Response
    {
        $id = $request->request->get('actId');
        $title = $request->request->get('actTitle');
        $act = $this->getDoctrine()->getRepository(Act::class)->find($id);

        $act->setTitle($title);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($act);
        $entityManager->flush();

        return new JsonResponse(['success']);
    }
    
    /**
     * 
     * @Route("manuscript/edit_chapter/{id}", name="edit_chapter")
     */
    public function editChapter(Request $request, Manuscript $manuscript): Response
    {
        $id = $request->request->get('chapterId');
        $title = $request->request->get('chapterTitle');
        $chapter = $this->getDoctrine()->getRepository(Chapter::class)->find($id);

        $chapter->setTitle($title);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($chapter);
        $entityManager->flush();

        return new JsonResponse(['success']);
    }

    /**
     * 
     * @Route("manuscript/edit_scene/{id}", name="edit_scene")
     */
    public function editScene(Request $request, Manuscript $manuscript): Response
    {
        $id = $request->request->get('sceneId');
        $title = $request->request->get('sceneTitle');
        $scene = $this->getDoctrine()->getRepository(Scene::class)->find($id);

        $scene->setTitle($title);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($scene);
        $entityManager->flush();

        return new JsonResponse(['success']);
    }

    /**
     * 
     * @Route("manuscript/edit_cell/{id}", name="edit_cell")
     */
    public function editCell(Request $request, Manuscript $manuscript): Response
    {
        $id = $request->request->get('cellId');
        $title = $request->request->get('cellContent');
        $cell = $this->getDoctrine()->getRepository(Cell::class)->find($id);

        $cell->setTextContent($title);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($cell);
        $entityManager->flush();

        return new JsonResponse(['success']);
    }

    /**
     * 
     * @Route("manuscript/edit_title/{id}", name="edit_title")
     */
    public function editTitle(Request $request, Manuscript $manuscript): Response
    {
        $title = $request->request->get('titleContent');
        $manuscript->setTitle($title);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($manuscript);
        $entityManager->flush();
        return new JsonResponse(['success']);
    }

    /**
     * 
     * @Route("manuscript/edit_subtitle/{id}", name="edit_subtitle")
     */
    public function editSubTitle(Request $request, Manuscript $manuscript): Response
    {
        $subtitle = $request->request->get('subtitleContent');
        $manuscript->setSubTitle($subtitle);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($manuscript);
        $entityManager->flush();
        return new JsonResponse(['success']);
    }

    /**
     * 
     * @Route("manuscript/edit_fourthCover/{id}", name="edit_fourthCover")
     */
    public function editFourthCover(Request $request, Manuscript $manuscript): Response
    {
        $fourthCoverContent = $request->request->get('fourthCoverContent');
        $manuscript->setFourthCover($fourthCoverContent);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($manuscript);
        $entityManager->flush();
        return new JsonResponse(['success']);
    }

    /**
     * 
     * @Route("manuscript/edit_storyTelling/{id}", name="edit_storyTelling")
     */
    public function editStoryTelling(Request $request, Manuscript $manuscript): Response
    {
        $storyTellingContent = $request->request->get('storyTellingContent');
        $manuscript->setStoryTelling($storyTellingContent);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($manuscript);
        $entityManager->flush();
        return new JsonResponse(['success']);
    }

}
