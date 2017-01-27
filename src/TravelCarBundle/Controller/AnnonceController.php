<?php

namespace TravelCarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use TravelCarBundle\Entity\Annonce;
use Symfony\Component\HttpFoundation\Request;

class AnnonceController extends Controller
{
    public function ajouterAction(Request $request){
        $annonce = new Annonce();
        $form = $this->createForm('TravelCarBundle\Form\AnnonceType', $annonce);
        $form->handleRequest($request);
    
        
        /*if ($form->isSubmitted() && $form->isValid()) {

            $annonce = $form->getData();
            $date_dep = $annonce->getDateDep();
            $temps_trajet = $annonce->getTempsTrajet();


            $em = $this->getDoctrine()->getManager(); // Recupération entityManager
            
            list($day, $month, $year, $hour, $minute) = preg_split('/[\/ :]/', $date_dep);
            $date_dep = new \DateTime();
            $date_dep->setDate($year, $month, $day);
            $date_dep->setTime($hour, $minute, 0);
            
            list($hour, $minute) = preg_split('/:/', $temps_trajet);
            $temps_trajet = new \DateTime();
            $temps_trajet->setDate(0, 0, 0);
            $temps_trajet->setTime($hour, $minute, 0);
                    
            $annonce->setDateDep($date_dep);
            $annonce->setTempsTrajet($temps_trajet);
            $annonce->setPersonne($this->getUser()->setRoles(array("ROLE_CONDUCTEUR")));
            
            $em->merge($this->getUser()->addAnnonce($annonce));
            $em->flush();
            
            //$request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

            return $this->redirectToRoute('home');
        }*/
        
        return $this->render('TravelCarBundle:Annonce:ajouter.html.twig', array('form' => $form->createView()));
    }
    
    /**
    * @ParamConverter("Annonce", options={"mapping": {"id_annonce": "id"}})
    */
    public function viewAction(Annonce $annonce) {

        return $this->render('TravelCarAnnonceBundle:Annonce:viewUser.html.twig', array(
        'annonce' => $annonce
        ));
    }

}
