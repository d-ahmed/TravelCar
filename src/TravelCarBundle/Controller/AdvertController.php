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
        
        
        if ($request->isMethod('POST')) {
            
            $form->handleRequest($request);

            if ($form->isValid()) {
                
                $advert->setUser($this->getUser()->setRoles(array("ROLE_CONDUCTEUR")));

                $em = $this->getDoctrine()->getManager(); // Recupération entityManager

                $em->merge($advert);

                $em->flush();
                // Permet de récuperer l'id de la dernière annonce créee
                $last = $this->getDoctrine()
                        ->getRepository('TravelCarBundle:Advert')
                        ->findOneBy(array('user' => $this->getUser()), array('id' => 'desc'));
                
                $idAdvert = $last->getId();
                
                return $this->redirectToRoute('view_advert', array('id' => $idAdvert));
            }
        }
        
        return $this->render('TravelCarBundle:Advert:add.html.twig', array('form' => $form->createView()));
    }
    
    
    public function viewAction(Advert $advert) {

        return $this->render('TravelCarBundle:Advert:viewUser.html.twig', array(
        'advert' => $advert
        ));
    }
    
    public function viewAdvertsAction($departureCity, $cityOfArrival, $departureDate, $page, $numberPerPage, Request $request){
     
        if($page < 1){
            throw $this->createNotFoundException('Traduction : page n existe pas');
        }
     
        $adverts = array();
     
     
            if($request->isMethod('GET')){

                if($request->query->count()!=0){
                    $departureCity = $request->query->get("departureCity");
                    $cityOfArrival = $request->query->get("cityOfArrival");
                    $departureDate = $request->query->get("departureDate");
                }

                preg_match('/[a-zA-Z]+/',$departureCity, $departureCity_match);
                preg_match('/[a-zA-Z]+/',$cityOfArrival, $cityOfArrival_match);
                preg_match('/\d{2} \d{2} \d{4}/',$departureDate, $departureDate_match);

                if((!isset($departureCity_match[0] ) || !isset($cityOfArrival_match[0] ) || !isset($departureDate_match[0] ) ) || ($departureCity_match[0]!=$departureCity || $cityOfArrival_match[0]!=$cityOfArrival || $departureDate_match[0]!=$departureDate)){
                    throw $this->createNotFoundException('Traduction : annonces n existe pas');
                }else{

                // On split la date en 3 variables , puis on créé un 
                // objet Datetime auquel on attribue ces 3 valeurs pour la BDD

                list($day, $month, $year) = preg_split('/ /', $departureDate);
                $departureDate = new \DateTime();
                $departureDate->setDate($year, $month, $day);

                $adverts = $this->getDoctrine()
                        ->getRepository('TravelCarBundle:Advert')
                        ->findBymatchAnnonces($departureCity, $cityOfArrival, $departureDate,$page,$numberPerPage);

                // On calcule le nombre total de page
                $numberPage = ceil(count($adverts)/$numberPerPage);

                if($page>$numberPage){
                    throw $this->createNotFoundException('Traduction : page n existe pas');
                }

                return $this->render('TravelCarBundle:Advert:viewAll.html.twig', array(
                    'adverts' => $adverts, 
                    'numberOfAdvert' => count($adverts), 
                    'page'=>$page, 
                    'numberPage'=>$numberPage,
                    'departureDate'=>$departureDate->format('d m Y'),
                    'departureCity'=>$departureCity,
                    'cityOfArrival'=>$cityOfArrival
                ));
            }
        }
            
        return $this->render('TravelCarBundle:TravelCar:home.html.twig');
    }

}
