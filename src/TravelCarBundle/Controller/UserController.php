<?php

namespace TravelCarBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class UserController extends Controller
{
    /**
     * @Route("user/edit/", name="user_edit")
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     */
    public function editAction()
    {
        return $this->render('TravelCarBundle:Default:User/Layout/edit.html.twig', array("user"=>$this->getUser()));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function viewAllAction()
    {
    }
    
    /**
     * @Route("profile/remove", name="user_remove")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function removeAction()
    {
        // Lors de la suppression d'une personne, il faut supprimer toutes les informations concernant la personne
        $this->getDoctrine()->getRepository('TravelCarBundle:User')->remove($this->getUser());
        $this->get('session')->getFlashBag()->add('notice', 'Votre compte a été supprimer avec succes');
        return $this->redirectToRoute('fos_user_security_login');

    }
}
