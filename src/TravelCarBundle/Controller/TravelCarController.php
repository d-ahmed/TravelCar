<?php

namespace TravelCarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TravelCarController extends Controller
{
    public function homeAction()
    {
        return $this->render('TravelCarBundle:TravelCar:home.html.twig', array(
            // ...
        ));
    }

}
