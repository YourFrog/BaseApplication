<?php

namespace PanelBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *  Kontroller dla panelu administracyjnego
 */
class IndexController extends Controller
{
    /**
     * @param Request $request
     *
     * @Route("/", name="panel_dashboard")
     */
    public function dashboardAction(Request $request)
    {
        return $this->render('panel/index/dashboard.html.twig');
    }
}