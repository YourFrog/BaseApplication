<?php

namespace PanelBundle\Controller;

use PanelBundle\Form;
use DateTime;
use AppBundle\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *  Administracja news'ami
 *
 * @package PanelBundle\Controller
 */
class NewsController extends Controller
{
    /**
     * @param string $type
     *
     * @Route("news/{type}", name="panel_news", requirements={"type"="(short|normal)"})
     */
    public function listAction(String $type)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Entity\News\News::class);

        $items = $repository->findBy(['type' => $type], ['id' => 'DESC']);

        return $this->render('panel/news/list.html.twig', [
            'items' => $items,
            'type' => $type
        ]);
    }

    /**
     *  Edycja artykułu
     *
     * @param Request $request
     *
     * @Route("news/new/{type}", name="panel_news_new", requirements={"type"="(short|normal)"})
     */
    public function newAction(Request $request, String $type)
    {
        $form = $this->createForm(Form\ArticleType::class);
        $form->handleRequest($request);

        if( $form->isSubmitted() ) {

            if( $form->isValid() ) {
                /** @var Entity\News\News $entity */
                $entity = $form->getData();
                $entity->setType($type);
                $entity->setAuthor($this->getUser());

                $this->getDoctrine()->getManager()->persist($entity);
                $this->getDoctrine()->getManager()->flush();

                $this->addFlash('success', 'Poprawnie utworzono artykuł');
                return $this->redirectToRoute('panel_news', [
                    'type' => $type
                ]);
            }

        }

        return $this->render('panel/news/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     *  Edycja artykułu
     *
     * @param Request $request
     * @param Entity\News\News $news
     *
     * @Route("news/edit/{id}-{type}", name="panel_news_edit", requirements={"type"="(short|normal)"})
     */
    public function editAction(Request $request, Entity\News\News $news, String $type)
    {
        $form = $this->createForm(Form\ArticleType::class);
        $form->setData($news);
        $form->handleRequest($request);

        if( $form->isSubmitted() ) {

            if( $form->isValid() ) {
                /** @var Entity\News\News $entity */
                $entity = $form->getData();
                $entity->setType($type);
                $entity->setAuthor($this->getUser());

                $this->getDoctrine()->getManager()->persist($entity);
                $this->getDoctrine()->getManager()->flush();

                $this->addFlash('success', 'Poprawnie zedytowano artykuł');
                return $this->redirectToRoute('panel_news', [
                    'type' => $type
                ]);
            }

        }

        return $this->render('panel/news/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}