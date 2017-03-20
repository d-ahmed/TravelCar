<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TravelCarBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use  \TravelCarBundle\Entity\Reservation;
use TravelCarBundle\Entity\Advert;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Description of ReservationController
 *
 * @author danielahmed
 */
class ReservationController extends Controller
{
    public function reserveFormAction(Advert $advert, Request $request)
    {
        $formReserved = $this->createFormBuilder()->setAction($this->generateUrl('remove_reservation', array('advertId' => $advert->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;

        if ($this->getUser()) {
            $reserved = $this->getDoctrine()->getRepository('TravelCarBundle:Reservation')->findOneBy(array(
                'user'=>$this->getUser()->getId(),
                'advert'=>$advert->getId()
            ));
        }

        return $this->render('TravelCarBundle:Default:Reservation/ContaintsUsed/reserve.html.twig', array(
            'advert'=>$advert,
            'formReserved'=> $formReserved->createView(),
            'reserved' => $reserved!=null
        ));
    }

    /**
     * @param Request $request
     * @return int|\Symfony\Component\HttpFoundation\RedirectResponse
     * @Security("has_role('ROLE_USER')")
     * @Route("reservations/add", name="add_reservation", methods={"GET","POST"})
     */
    public function addAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            $advertId = $request->get('advertId');
            
            $nbOfReservation = $request->get('nbOfReservation');
            
            $advert = $this->getDoctrine()
                ->getRepository('TravelCarBundle:Advert')
                ->find($advertId);

            $canAdd = true;

            if ($nbOfReservation > ($advert->getNumberOfPlace()-$advert->getNumberOfReservation())) {
                $request->getSession()->getFlashBag()->add('notice', 'Nombre inferieur attendu');
                $canAdd = false;
            }
            
            $reservation = $this->getDoctrine()
                ->getRepository('TravelCarBundle:Reservation')
                ->findOneBy(array('advert'=>$advert, 'user'=>$this->getUser()));

            if ($reservation) {
                $request->getSession()->getFlashBag()->add('notice', 'Reservation existe');
                $canAdd = false;
            }

            $reservation = new Reservation();

            $reservation->setNumberOfPlace($nbOfReservation)->setAdvert($advert)->setUser($this->getUser());

            if($canAdd && count($this->get('validator')->validate($reservation)) > 0){
                $request->getSession()->getFlashBag()->add('notice', 'Nombre positif attendu');
                $canAdd = false;
            }

            if ($canAdd) {
                $advert->addReservation($reservation);
                $this->getUser()->addReservation($reservation);
                $this->getDoctrine()->getManager()->flush();
            }
            
            return $this->redirectToRoute('view_advert', array(
            'id' => $advertId,
            ));
        } else {
            throw $this->createNotFoundException('Page non trouvée');
        }
        
        return 0;
    }

    /**
     * @param Advert $advert
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @ParamConverter("advert", options={"id": "advertId"})
     * @Security("has_role('ROLE_USER')")
     * @Route("reservations/{advertId}", name="remove_reservation", requirements={"advertId"="\d+"})
     * @Method("DELETE")
     */
    public function removeAction(Advert $advert, Request $request)
    {
        $user = $this->getUser();
        
        $reservation = $this->getDoctrine()
                ->getRepository('TravelCarBundle:Reservation')
                ->findOneBy(array('advert'=>$advert->getId(),'user'=> $user->getId()));
        if ($reservation) {
            $this->getUser()->removeReservation($reservation);
            $advert->removeReservation($reservation);
            $em = $this->getDoctrine()->getManager();
            $em->remove($reservation);
            $em->flush();
        } else {
            throw $this->createNotFoundException('Permission non accordée');
        }

        return $this->redirectToRoute('my_reservations');
    }


    /**
     * @Security("has_role('ROLE_USER')")
     * @Route("/myReservations/{mode}", name="my_reservations",
     *     defaults={"mode"="block"},
     *     requirements={"mode"="list|block"}
     * )
     */
    public function myReservationsAction($mode, Request $request)
    {
        $reservations = $this->getDoctrine()->getRepository('TravelCarBundle:Reservation')
                            ->findBy(array('user'=>$this->getUser()->getId()));
        return $this->render('TravelCarBundle:Default:Advert/Layout/myResrvations.html.twig', array(
            'reservations'=>$reservations,
            'mode'=> $mode
        ));
    }

    /**
     * Creates a form to delete a vehicle entity.
     *
     * @param Reservation $reservation the advert entity
     *
     * @return \Symfony\Component\Form\Form The form
     *
     */
    private function createDeleteForm(Reservation $reservation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('remove_reservation', array('id' => $reservation->getAdvert()->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
