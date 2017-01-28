<?php

namespace TravelCarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TravelCarBundle\Entity\Advert;
use Symfony\Component\HttpFoundation\Request;

class AdvertController extends Controller
{
    public function addAction(Request $request){
        $advert = new Advert();
        $form = $this->createForm('TravelCarBundle\Form\AdvertType', $advert);
        $form->handleRequest($request);
    
        
        if ($form->isSubmitted() && $form->isValid()) {

            $advert = $form->getData();
            $departureDate = $advert->getDepartureDate();
            $travelTime = $advert->getTravelTime();


            $em = $this->getDoctrine()->getManager(); // Recupération entityManager
            
            list($day, $month, $year, $hour, $minute) = preg_split('/[\/ :]/', $departureDate);
            $departureDate = new \DateTime();
            $departureDate->setDate($year, $month, $day);
            $departureDate->setTime($hour, $minute, 0);
            
            list($hour, $minute) = preg_split('/:/', $travelTime);
            $travelTime = new \DateTime();
            $travelTime->setDate(0, 0, 0);
            $travelTime->setTime($hour, $minute, 0);
                    
            $advert->setDepartureDate($departureDate);
            $advert->setTravelTime($travelTime);
            $advert->setUser($this->getUser()->setRoles(array("ROLE_CONDUCTEUR")));
            
            $em->merge($advert);

            $em->flush();
            
            //$request->getSession()->getFlashBag()->add('notice', 'Advert bien enregistrée.');

            
            return $this->redirectToRoute('view_advert', array('id' => $advert->getId()));
        }
        
        return $this->render('TravelCarBundle:Advert:add.html.twig', array('form' => $form->createView()));
    }
    
    public function viewAction(Advert $advert) {

        return $this->render('TravelCarBundle:Advert:viewUser.html.twig', array(
        'advert' => $advert
        ));
    }

}
