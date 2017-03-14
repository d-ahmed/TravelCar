<?php
/**
 * Created by PhpStorm.
 * User: danielahmed
 * Date: 11/03/2017
 * Time: 13:19
 */

namespace TravelCarBundle\EventListener;

use Symfony\Component\Security\Core\Event\AuthenticationEvent;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use TravelCarBundle\Service\StyleUser;

class LoginListener
{
    private $styleUser;
    private $session;

    public function __construct(StyleUser $styleUser, SessionInterface $session)
    {
        $this->session = $session;
        $this->styleUser  = $styleUser;
    }

    public function onAuthenticationSuccess(AuthenticationEvent $event)
    {
        if ($event->getAuthenticationToken()->getUser() !== "anon.") {
            $this->styleUser->setTheme($event->getAuthenticationToken()->getUser(), $this->session);
        }
    }
}
