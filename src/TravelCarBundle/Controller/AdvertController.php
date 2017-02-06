<?php

namespace TravelCarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TravelCarBundle\Entity\Advert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use TravelCarBundle\Modele\AdvertModele;


class AdvertController extends Controller
{
    public function searchAction(Request $request){
        $form = $this->createForm('TravelCarBundle\Form\SearchType');
        return $this->render('TravelCarBundle:Default:Advert/ContaintsUsed/search.html.twig',array('search'=>$form->createView()));
    }
    
    public function searchTreatmentAction($page,$numberPerPage,Request $request){
        
        if($page < 1) throw $this->createNotFoundException('Traduction : page n existe pas');
        
        $form = $this->createForm('TravelCarBundle\Form\SearchType');
        
        if($request->isMethod('POST')){
            
            $form->handleRequest($request);
            
            if($form->isValid()){
                $adverts = $this->getDoctrine()
                        ->getRepository('TravelCarBundle:Advert')
                        ->findBymatchAnnonces($form->get('departureCity')->getData(), $form->get('cityOfArrival')->getData(), $form->get('departureDate')->getData(),$page,$numberPerPage);
                $numberPage = ceil(count($adverts)/$numberPerPage);

                if($page>$numberPage) throw $this->createNotFoundException('Traduction : page n existe pas');

                return $this->render('TravelCarBundle:Default:Advert/Layout/viewAll.html.twig', array(
                    'adverts' => $adverts, 
                    'numberOfAdvert' => count($adverts), 
                    'page'=>$page, 
                    'numberPage'=>$numberPage,
                    'departureDate'=>$form->get('departureDate')->getData()->format('d/m/Y'),
                    'departureCity'=>$form->get('departureCity')->getData(),
                    'cityOfArrival'=>$form->get('cityOfArrival')->getData()
                ));
            }
        }else{
            throw $this->createNotFoundException('Page non trouvée');
        }
        return 0;
    }
    
    
    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function addAction(Request $request){
        
        $advert = new Advert();
        
        $form = $this->createForm('TravelCarBundle\Form\AdvertType', $advert);
        
        if ($request->isMethod('POST')) {
            
            $form->handleRequest($request);

            if ($form->isValid()) {
                
                $advert->setUser($this->getUser()->setRoles(array("ROLE_CONDUCTEUR")));
                
                $advertConflict = $this->getDoctrine()
                        ->getRepository('TravelCarBundle:Advert')
                        ->findByUserDepartureDate($this->getUser(), $advert->getDepartureDate());
                
                if(count($advertConflict)>0){
                    throw $this->createNotFoundException('Traduction : Conflit d annonce');
                }
                
                $em = $this->getDoctrine()->getManager(); // Recupération entityManager

                $em->merge($advert);

                $em->flush();
                // Permet de récuperer l'id de la dernière annonce créee
                $last = $this->getDoctrine()
                        ->getRepository('TravelCarBundle:Advert')
                        ->findOneBy(array('user' => $this->getUser()), array('id' => 'desc'));
                
                return $this->render('TravelCarBundle:Default:Advert/Layout/viewUser.html.twig', array(
                'advert' => $last,
                ));
            }
        }
        
        return $this->render('TravelCarBundle:Default:Advert/Layout/add.html.twig', array('form' => $form->createView(), 'nameBtn'=>'btn.add'));
    }
    
    
    public function viewAction(Advert $advert) {

        return $this->render('TravelCarBundle:Default:Advert/Layout/viewUser.html.twig', array(
        'advert' => $advert,
        ));
    }
    
    /**
     * @Security("has_role('ROLE_DRIVER')")
     */
    public function modifyAction(Advert $advert, Request $request){
        
        $form = $this->createForm('TravelCarBundle\Form\AdvertType', $advert);
        
        if ($request->isMethod('POST')) {
            
            $form->handleRequest($request);

            if ($form->isValid()) {
                
                $advert->setUser($this->getUser()->setRoles(array("ROLE_CONDUCTEUR")));
                
                $advertConflict = $this->getDoctrine()
                        ->getRepository('TravelCarBundle:Advert')
                        ->findByUserDepartureDate($this->getUser(), $advert->getDepartureDate());
                
                if(count($advertConflict)>0){
                    throw $this->createNotFoundException('Traduction : Conflit d annonce');
                }
                
                $em = $this->getDoctrine()->getManager(); // Recupération entityManager

                $em->merge($advert);

                $em->flush();
                
                return $this->render('TravelCarBundle:Default:Advert/Layout/viewUser.html.twig', array(
                'advert' => $advert,
                ));
            }
        }
        
        return $this->render('TravelCarBundle:Default:Advert/Layout/add.html.twig', array('form' => $form->createView(), 'nameBtn'=>'btn.modify'));
    }
    
    /**
     * @Security("has_role('ROLE_DRIVER')")
     */
    public function removeAction(Advert $advert, Request $request){
        if($request->isMethod('GET')){
            if($advert->getUser()!=$this->getUser()){
                throw $this->createNotFoundException('Pas le doit');
            }else{
                $em = $this->getDoctrine()->getManager();
                $em->remove($advert);
                $em->flush();
                // Message annonce bien supprimé
            }
        }
        return new Response('Annonce supprimer');
    }
    
    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function myAdvertsAction(){
        $adverts = $this->getDoctrine()->getRepository('TravelCarBundle:Advert')
                ->findBy(array('user'=>$this->getUser()));
        dump($adverts);
        
        return $this->render('TravelCarBundle:Default:Advert/Layout/myAdverts.html.twig', array('user'=>$this->getUser(), 'adverts'=>$adverts));
    }

}
