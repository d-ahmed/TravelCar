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
     * @Route("user/edit/", name="user_edit")
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     */
    public function editAction()
    {
        return $this->render('TravelCarBundle:Default:User/Layout/edit.html.twig', array("user"=>$this->getUser()));
    }


    /**
     * @Route("/user/{id}", name="user_show")
     * @Method("GET")
     */
    public function showAction(User $user)
    {
        dump($user);
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('TravelCarBundle:Default:User/Layout/showUser.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_remove_id', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
    
    /**
     * @Route("profile/remove", name="user_remove")
     * @Route("profile/remove/{id}", name="user_remove_id")
     * @Security("has_role('ROLE_USER')")
     */
    public function removeAction(User $user=null)
    {
        // Lors de la suppression d'une personne, il faut supprimer toutes les informations concernant la personne
        if($user){
            $this->getDoctrine()->getRepository('TravelCarBundle:User')->remove($user);
            return $this->redirectToRoute('admin_users');
        }else{
            $this->getDoctrine()->getRepository('TravelCarBundle:User')->remove($this->getUser());
        }

        $this->get('session')->getFlashBag()->add('notice', 'Votre compte a été supprimer avec succes');
        return $this->redirectToRoute('fos_user_security_login');
    }
}
