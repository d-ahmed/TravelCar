<?php

namespace TravelCarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class TravelCarController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name="home")
     */
    public function homeAction()
    {
        return $this->render('TravelCarBundle:Default:TravelCar/Layout/home.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/about", name="tc_travelcarbundle_about", methods={"GET"})
     */
    public function aboutAction()
    {
        return $this->render('TravelCarBundle:Default:TravelCar/Layout/about.html.twig');
    }       

}
