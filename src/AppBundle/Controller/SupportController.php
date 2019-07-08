<?php

namespace AppBundle\Controller;

use AppBundle\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *  Kontroller obsługujący podstrony wsparcia
 *
 * @package AppBundle\Controller
 */
class SupportController extends Controller
{
    /**
     *  Informacje o ostatnich zmianach
     *
     * @Route("/changelog", name="app_changelog")
     */
    public function changelogAction()
    {
        /** @var Entity\Changelog[] $posts */
        $posts = $this->getDoctrine()->getManager()->getRepository(Entity\Changelog::class)->findAll();

        return $this->render('app/support/changelog.html.twig', [
            'posts' => $posts
        ]);
    }
}