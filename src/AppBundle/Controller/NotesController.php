<?php

namespace AppBundle\Controller;

use AppBundle\Form;
use AppBundle\Entity;
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
        $nodeItem->setGhost(true);

        if( $nodeItem->getNote()->getOwner()->getId() === $this->getUser()->getId() ) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($nodeItem);
            $entityManager->flush();
        }

        return $this->redirectToRoute('notes_detail', ['id' => $nodeItem->getNote()->getId()]);
    }

    /**
     * @param Entity\Notes\Note $note
     *
     * @Route("/notes/checked/{note}", name="note_item_checked")
     */
    public function checkedAction(Request $request, Entity\Notes\Note $note)
    {
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

        if( $note->getOwner()->getId() !== $this->getUser()->getId() ) {
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

        $params = [];
        $params['note'] = $note;
        $params['form'] = $form->createView();

        return $this->render('app/notes/details.html.twig', $params);
    }

    /**
     * @Route("/notes", name="notes_list")
     */
    public function listAction(Request $request)
    {
        $form = $this->createForm(Form\NewNotesType::class);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ) {
            $data = $form->getData();

            $entity = new Entity\Notes\Note();
            $entity->setOwner($this->getUser());
            $entity->setName($data['name']);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();
        }

        $repository = $this->getDoctrine()->getRepository(Entity\Notes\Note::class);

        $params = [];
        $params['form'] = $form->createView();
        $params['notes'] = $repository->findBy(['owner' => $this->getUser(), 'ghost' => false]);

        return $this->render('app/notes/index.html.twig', $params);
    }
}