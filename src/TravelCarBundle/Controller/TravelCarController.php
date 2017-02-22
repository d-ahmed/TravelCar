<?php

namespace TravelCarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TravelCarController extends Controller
{
    public function homeAction()
    {
        return $this->render('TravelCarBundle:Default:TravelCar/Layout/home.html.twig');
    }
    
    public function aboutAction()
    {
        return $this->render('TravelCarBundle:Default:TravelCar/Layout/about.html.twig');
    }       

}
