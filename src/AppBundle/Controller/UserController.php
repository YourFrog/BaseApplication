<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *  Kontroller obsługujący użytkownika
 *
 * @package AppBundle\Controller
 */
class UserController extends Controller
{
    /**
     *  Akcja dotycząca profilu użytkownika
     *
     * @Route("/profile", name="app_profile")
     */
    public function profileAction()
    {
        return $this->render('app/user/profile.html.twig');
    }
}