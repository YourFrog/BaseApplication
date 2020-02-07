<?php

namespace AppBundle\Controller;

use AppBundle\Form;
use AppBundle\Entity;
use AppBundle\Service;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 *  Kontroller obsługujący notatki
 */
class NotesController extends Controller
{
    /**
     * @Route("/notes/remove/{id}", name="notes_remove")
     */
    public function deleteAction(Entity\Notes\Note $note)
    {
        $note->setGhost(true);

        if( $note->getOwner()->getId() === $this->getUser()->getId() ) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($note);
            $entityManager->flush();
        }

        return $this->redirectToRoute('notes_list');
    }

    /**
     * @Route("/notes/item/remove/{id}", name="notes_item_remove")
     */
    public function deleteItemAction(Entity\Notes\NoteItem $nodeItem)
    {
        /** @var Entity\User $user */
        $user = $this->getUser();

        $note = $nodeItem->getNote();

        /** @var Service\Notes\UserIsOwner $service */
        $userIsOwner = $this->get('service.notes.UserIsOwner');

        if( $userIsOwner->execute($note, $user) ) {
            $nodeItem->setGhost(true);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($nodeItem);
            $entityManager->flush();
        }

        return $this->redirectToRoute('notes_detail', ['id' => $note->getId()]);
    }

    /**
     * @param Entity\Notes\Note $note
     *
     * @Route("/notes/checked/{note}", name="note_item_checked")
     */
    public function checkedAction(Request $request, Entity\Notes\Note $note)
    {
        /** @var Entity\User $user */
        $user = $this->getUser();

        $nodeItemID =  $request->request->get('noteItem');

        $repository = $this->getDoctrine()->getRepository(Entity\Notes\NoteItem::class);
        /** @var Entity\Notes\NoteItem $nodeItem */
        $nodeItem = $repository->find($nodeItemID);

        if( $nodeItem == null ) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Note item not found'
            ]);
        }

        if( $note->getId() !== $nodeItem->getNote()->getId() ) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Note item invalid ID'
            ]);
        }

        /** @var Service\Notes\UserIsOwner $userIsOwner */
        $userIsOwner = $this->get('service.notes.UserIsOwner');

        if( !$userIsOwner->execute($note, $user) ) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'You are not owner'
            ]);
        }

        $nodeItem->setChecked(!$nodeItem->isChecked());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($nodeItem);
        $entityManager->flush();

        $data = [];
        $data['status'] = 'success';
        $data['data'] = [
            'checked' => $nodeItem->isChecked()
        ];

        return new JsonResponse($data);
    }

    /**
     * @param Entity\Notes\Note $note
     *
     * @Route("/notes/details/{id}", name="notes_detail")
     */
    public function detailsAction(Request $request, Entity\Notes\Note $note)
    {
        $form = $this->createForm(Form\Notes\NewItemType::class);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ) {
            // Add Item
            $data = $form->getData();

            $noteItem = new Entity\Notes\NoteItem();
            $noteItem->setName($data['name']);
            $noteItem->setNote($note);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($noteItem);
            $entityManager->flush();
        }

        /** @var Service\Notes\ListOfActiveNoteItems $service */
        $service = $this->get('service.notes.ListOfActiveNoteItems');

        $params = [];
        $params['note'] = $note;
        $params['items'] = $service->execute($note);
        $params['form'] = $form->createView();

        return $this->render('app/notes/details.html.twig', $params);
    }

    /**
     * @Route("/notes", name="notes_list")
     */
    public function listAction(Request $request)
    {
        /** @var Entity\User $user */
        $user = $this->getUser();

        $form = $this->createForm(Form\NewNotesType::class);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ) {
            $data = $form->getData();

            $note = new Entity\Notes\Note();
            $note->setName($data['name']);

            $noteRelationship = new Entity\Notes\NoteRelationship();
            $noteRelationship->setUser($user);
            $noteRelationship->setNote($note);
            $noteRelationship->setType(Entity\Notes\NoteRelationship::OWNER);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($note);
            $entityManager->persist($noteRelationship);
            $entityManager->flush();
        }

        /** @var Service\Notes\ListOfActiveNote $listOfActiveNote */
        $listOfActiveNote = $this->get('service.notes.ListOfActiveNote');

        $params = [];
        $params['form'] = $form->createView();
        $params['notes'] = $listOfActiveNote->execute($user);

        return $this->render('app/notes/index.html.twig', $params);
    }
}