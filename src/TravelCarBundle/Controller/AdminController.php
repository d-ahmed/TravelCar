<?php

namespace TravelCarBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class AdminController
 * @package TravelCarBundle\Controller
 * @Route("/admin/")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="admin_home")
     */
    public function homeAction()
    {
        return $this->render('TravelCarBundle:Admin:home.html.twig');
    }

    /**
     * @Route("/users/", name="admin_users")
     */
    public function viewUsersAction()
    {
        $users = $this->getDoctrine()->getRepository('TravelCarBundle:User')->findAll();
        return $this->render('TravelCarBundle:Admin:users.html.twig', array(
            'users'=>$users
        ));
    }

    /**
     * @Route("/adverts/", name="admin_adverts")
     */
    public function viewAdvertsAction()
    {
        $advert = $this->getDoctrine()->getRepository('TravelCarBundle:Advert')->findAll();
        return $this->render('TravelCarBundle:Admin:adverts.html.twig', array(
            'adverts'=>$advert
        ));
    }

}