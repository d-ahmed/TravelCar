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
            if ($nbOfReservation<1) {
                $request->getSession()->getFlashBag()->add('notice', 'Nombre positif attendu');
                $canAdd = false;
            }
            
            if ($nbOfReservation > $advert->getNumberOfPlace()) {
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

            if ($canAdd) {
                $reservation = new Reservation();
            
                $reservation->setNumberOfPlace($nbOfReservation)->setAdvert($advert)->setUser($this->getUser());
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
                ->findOneBy(array('advert'=>$advert,'user'=> $user));

        if ($reservation) {
            $this->getUser()->removeReservation($reservation);
            $this->getDoctrine()->getManager()->flush();
        } else {
            throw $this->createNotFoundException('Permission non accordée');
        }

        return $this->redirectToRoute('view_advert', array(
            'id' => $advert->getId()
        ));
    }
    
    /**
     * @Security("has_role('ROLE_ADMIN')")
     *
     */
    public function viewAllAction()
    {
        $reservations = $this->getDoctrine()
                    ->getRepository('TravelCarBundle:Reservation')
                    ->findAll();
    }
    
    /**
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function viewAllMyAction(Request $request)
    {
        $reservations = $this->getDoctrine()
                    ->getRepository('TravelCarBundle:Reservation')
                    ->findBy(array('user'=>$this->getUser()));
    }

    /**
     * @param $page
     * @param $numberPerPage
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     * @Route("/myReservations/{page}/{numberPerPage}", name="my_reservations",
     *      defaults={"page"=1, "numberPerPage"=5}, requirements={"page"="\d+", "numberPerPage"="\d+"}
     * )
     */
    public function myReservationsAction($page, $numberPerPage, Request $request)
    {
        if (!$page) {
            $page=1;
        }
        $reservations = $this->getDoctrine()->getRepository('TravelCarBundle:Reservation')
                ->findByUser($this->getUser(), $page, $numberPerPage);
        $numberPage = ceil(count($reservations)/$numberPerPage);

        return $this->render('TravelCarBundle:Default:Advert/Layout/myAdverts.html.twig', array('reservation'=>$reservations,'page'=>$page,'numberPage'=>$numberPage));
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
