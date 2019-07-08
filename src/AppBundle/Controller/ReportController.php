<?php

namespace AppBundle\Controller;

use AppBundle\Form;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *  Obsługa raportowania
 *
 * @package AppBundle\Controller
 */
class ReportController extends Controller
{
    /**
     *  Raportowanie błędów przez użytkownika
     *
     * @param Request $request
     *
     * @Route("/report/bug", name="report_bug")
     */
    public function bugAction(Request $request)
    {
        $form = $this->createForm(Form\ReportBugType::class);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ) {
            $entity = new \AppBundle\Entity\Bug\Report();

//            $form->setData($entity);
            $data = $form->getData();

            $this->getDoctrine()->getManager()->persist($data);
            $this->getDoctrine()->getManager()->flush();

            return $this->render('app/report/bug_submitted.html.twig');
        } else {
            $data = new \AppBundle\Entity\Bug\Report();

            if( $this->getUser() ) {
                $data->setEmail($this->getUser()->getEmail());
            }

            $form->setData($data);
        }

        return $this->render('app/report/bug.html.twig', [
            'form' => $form->createView()
        ]);
    }
}