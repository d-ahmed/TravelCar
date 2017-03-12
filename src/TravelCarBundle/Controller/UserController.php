<?php

namespace TravelCarBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use TravelCarBundle\Entity\User;

class UserController extends Controller
{
    /**
     * @Route("user/edit/{id}", name="user_edit")
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     */
    public function editAction(User $user)
    {
        return $this->render('TravelCarBundle:Default:User/Layout/edit.html.twig', array("user"=>$user));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function viewAllAction()
    {
    }
    
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function removeAction()
    {
        // Lors de la suppression d'une personne, il faut supprimer toutes les informations concernant la personne
    }
}
