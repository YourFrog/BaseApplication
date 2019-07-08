<?php

namespace PanelBundle\Controller;

use AppBundle\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WhiteOctober\SwiftMailerDBBundle\EmailInterface;


/**
 *  Administracja zgłoszonymi błędami
 *
 * @package PanelBundle\Controller
 */
class BugController extends Controller
{
    /**
     *  Lista błędów
     *
     * @Route("/bug/list", name="panel_bug")
     */
    public function listAction()
    {
        $bugs = $this->getDoctrine()->getManager()->getRepository(Entity\Bug\Report::class)->findBy([], ['id' => 'DESC']);

        return $this->render('panel/bug/list.html.twig', [
            'bugs' => $bugs
        ]);
    }

    /**
     * @param Entity\Bug\Report $bug
     *
     * @Route("/bug/detail/{id}", name="panel_bug_detail")
     */
    public function detailAction(Entity\Bug\Report $bug)
    {
        return $this->render('panel/bug/detail.html.twig', [
            'bug' => $bug
        ]);
    }

    /**
     * @param Entity\Bug\Report $bug
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/bug/confirm/{id}", name="panel_bug_confirm")
     */
    public function confirmAction(Entity\Bug\Report $bug)
    {
        if( !in_array($bug->getStatus(), [Entity\Bug\Report::STATUS_OPEN, Entity\Bug\Report::STATUS_CLOSE, Entity\Bug\Report::STATUS_REJECT]) ) {
            $this->addFlash('error', 'Nie można zmienić statusu');
        } else {
            $bug->setStatus(Entity\Bug\Report::STATUS_CONFIRM);

            $this->getDoctrine()->getManager()->persist($bug);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Zmieniono status');
        }

        return $this->redirectToRoute('panel_bug_detail', [
            'id' => $bug->getId()
        ]);
    }

    /**
     * @param Entity\Bug\Report $bug
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/bug/reject/{id}", name="panel_bug_reject")
     */
    public function rejectAction(Entity\Bug\Report $bug)
    {
        if( in_array($bug->getStatus(), [Entity\Bug\Report::STATUS_CLOSE, Entity\Bug\Report::STATUS_REJECT]) ) {
            $this->addFlash('error', 'Nie można zmienić statusu');
        } else {
            $bug->setStatus(Entity\Bug\Report::STATUS_REJECT);

            $this->getDoctrine()->getManager()->persist($bug);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Zmieniono status');
        }

        return $this->redirectToRoute('panel_bug_detail', [
            'id' => $bug->getId()
        ]);
    }

    /**
     * @param Entity\Bug\Report $bug
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/bug/close/{id}", name="panel_bug_close")
     */
    public function closeAction(Entity\Bug\Report $bug)
    {
        $bug->setStatus(Entity\Bug\Report::STATUS_CLOSE);

        $this->getDoctrine()->getManager()->persist($bug);
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', 'Zmieniono status');

        return $this->redirectToRoute('panel_bug_detail', [
            'id' => $bug->getId()
        ]);
    }
}