<?php
/**
 * Created by PhpStorm.
 * User: danielahmed
 * Date: 11/03/2017
 * Time: 14:43
 */

namespace TravelCarBundle\Service;



use Symfony\Component\HttpFoundation\Session\SessionInterface;
use TravelCarBundle\Entity\User;

class StyleUser
{


    public function setTheme(User $user, SessionInterface $session)
    {
        if ($user->getStyle()) {
            $session->set('style', $user->getStyle());
            $session->set('font', $user->getFont());
        } else {
            $session->set('style', 'default');
            $session->set('font', 'default');
        }


    }

}