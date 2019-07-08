<?php

namespace PanelBundle\Controller;

use DateTime;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseNullableUserEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Mailer\MailerInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 *  Administracja użytkownikami
 *
 * @package PanelBundle\Controller
 */
class UserController extends Controller
{
    /**
     *  Wszyscy użytkownicy
     *
     * @Route("/user/list", name="panel_user")
     */
    public function listAction()
    {
        $users = $this->getDoctrine()->getManager()->getRepository(\AppBundle\Entity\User::class)->findBy([], ['id' => 'ASC']);

        return $this->render('panel/user/list.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @param User $targetUser
     *
     * @Route("/user/lock/{id}", name="panel_user_lock")
     *
     * @return RedirectResponse
     */
    public function lockAction(User $targetUser)
    {
        if( $this->getUser()->getId() == $targetUser->getId() ) {
            $this->addFlash('error', 'Nie można modyfikować swojego konta...');
            return $this->redirectToRoute('panel_user');
        }

        $targetUser->lock();

        $this->getDoctrine()->getManager()->persist($targetUser);
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash("success", 'Zablokowano konto "' . $targetUser->getUsername() . '"');

        return $this->redirectToRoute('panel_user');
    }

    /**
     * @param User $targetUser
     *
     * @Route("/user/unlock/{id}", name="panel_user_unlock")
     *
     * @return RedirectResponse
     */
    public function unlockAction(User $targetUser)
    {
        if( $this->getUser()->getId() == $targetUser->getId() ) {
            $this->addFlash('error', 'Nie można modyfikować swojego konta...');
            return $this->redirectToRoute('panel_user');
        }

        $targetUser->unlock();

        $this->getDoctrine()->getManager()->persist($targetUser);
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash("success", 'Odblokowano konto "' . $targetUser->getUsername() . '"');

        return $this->redirectToRoute('panel_user');
    }

    /**
     *  Zresetowanie hasła przez administratora
     *
     * @param Request $request
     * @param User $targetUser
     *
     * @Route("/user/reset/{id}", name="panel_user_reset")
     *
     * @return null|RedirectResponse|Response
     */
    public function resetAction(Request $request, User $targetUser)
    {
        if( $this->getUser()->getId() == $targetUser->getId() ) {
            $this->addFlash('error', 'Nie można modyfikować swojego konta...');
            return $this->redirectToRoute('panel_user');
        }

        $event = new GetResponseNullableUserEvent($targetUser, $request);
        $this->get('event_dispatcher')->dispatch(FOSUserEvents::RESETTING_SEND_EMAIL_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            $this->addFlash('error', 'Nie można zresetować hasła');
            return $event->getResponse();
        }

        $event = new GetResponseUserEvent($targetUser, $request);
        $this->get('event_dispatcher')->dispatch(FOSUserEvents::RESETTING_RESET_REQUEST, $event);

        if (null !== $event->getResponse()) {
            $this->addFlash('error', 'Nie można zresetować hasła');
            return $event->getResponse();
        }

        if (null === $targetUser->getConfirmationToken()) {
            $targetUser->setConfirmationToken($this->get('fos_user.util.token_generator')->generateToken());
        }

        $event = new GetResponseUserEvent($targetUser, $request);
        $this->get('event_dispatcher')->dispatch(FOSUserEvents::RESETTING_SEND_EMAIL_CONFIRM, $event);

        if (null !== $event->getResponse()) {
            $this->addFlash('error', 'Nie można zresetować hasła');
            return $event->getResponse();
        }

        $this->get('fos_user.mailer')->sendResettingEmailMessage($targetUser);
        $targetUser->setPasswordRequestedAt(new DateTime());
        $this->get('fos_user.user_manager')->updateUser($targetUser);

        $event = new GetResponseUserEvent($targetUser, $request);
        $this->get('event_dispatcher')->dispatch(FOSUserEvents::RESETTING_SEND_EMAIL_COMPLETED, $event);

        $this->addFlash('success', 'Wysłano hasło do klienta na adres e-mail "' . $targetUser->getEmailCanonical() . '"');
        return $this->redirectToRoute('panel_user');
    }
}