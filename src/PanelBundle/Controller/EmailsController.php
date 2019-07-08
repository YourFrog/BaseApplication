<?php

namespace PanelBundle\Controller;

use AppBundle\Entity\Email;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WhiteOctober\SwiftMailerDBBundle\EmailInterface;


/**
 *  Administracja wiadomościami email
 *
 * @package PanelBundle\Controller
 */
class EmailsController extends Controller
{
    /**
     *  Wszystkie wiadomości
     *
     * @Route("/emails/list", name="panel_email")
     */
    public function listAction()
    {
        $emails = $this->getDoctrine()->getManager()->getRepository(\AppBundle\Entity\Email::class)->findBy([], ['id' => 'DESC']);

        return $this->render('panel/email/list.html.twig', [
            'emails' => $emails
        ]);
    }

    /**
     *  Wstrzymanie wiadomości email
     *
     * @Route("/emails/suspend/{id}", name="panel_email_suspend")
     */
    public function suspendAction(Email $email)
    {
        if( $email->getStatus() != Email::STATUS_READY ) {
            $this->addFlash('error', 'Nie można wstrzymać wiadomości');
            return $this->redirectToRoute('panel_email');
        }

        $email->setStatus(Email::STATUS_SUSPEND);
        $this->getDoctrine()->getManager()->persist($email);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('panel_email');
    }
}