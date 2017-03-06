<?php

namespace TravelCarBundle\Controller;

use TravelCarBundle\Entity\Vehicle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class VehicleController extends Controller
{
    /**
     * Lists all vehicle entities.
     *
     * @Route("/vehicle/", name="vehicle_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $vehicles = $em->getRepository('TravelCarBundle:Vehicle')->findAll();

        return $this->render('TravelCarBundle:Default:vehicle/index.html.twig', array(
            'vehicles' => $vehicles,
        ));
    }


    /**
     * Creates a new vehicle entity.
     *
     * @Route("/vehicle/new", name="vehicle_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $vehicle = new Vehicle();
        $form = $this->createForm('TravelCarBundle\Form\VehicleType', $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vehicle);
            $em->flush($vehicle);

            return $this->redirectToRoute('vehicle_show', array('id' => $vehicle->getIdNumber()));
        }

        return $this->render('TravelCarBundle:Default:vehicle/new.html.twig', array(
            'vehicle' => $vehicle,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a vehicle entity.
     * @ParamConverter("vehicle", options={"idNumber": "id"})
     * @Route("/vehicle/{id}", name="vehicle_show")
     * @Method("GET")
     */
    public function showAction(Vehicle $vehicle)
    {
        dump($vehicle);
        $deleteForm = $this->createDeleteForm($vehicle);

        return $this->render('TravelCarBundle:Default:vehicle/show.html.twig', array(
            'vehicle' => $vehicle,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vehicle entity.
     * @ParamConverter("vehicle", options={"idNumber": "id"})
     * @Route("/vehicle/edit/{id}", name="vehicle_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Vehicle $vehicle)
    {
        $deleteForm = $this->createDeleteForm($vehicle);
        $editForm = $this->createForm('TravelCarBundle\Form\VehicleType', $vehicle);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vehicle_edit', array('id' => $vehicle->getIdNumber()));
        }

        return $this->render('TravelCarBundle:Default:vehicle/edit.html.twig', array(
            'vehicle' => $vehicle,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a vehicle entity.
     * @ParamConverter("vehicle", options={"idNumber": "id"})
     * @Route("/vehicle/{id}", name="vehicle_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Vehicle $vehicle)
    {
        $form = $this->createDeleteForm($vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vehicle);
            $em->flush($vehicle);
        }

        return $this->redirectToRoute('vehicle_index');
    }

    /**
     * Creates a form to delete a vehicle entity.
     *
     * @param Vehicle $vehicle The vehicle entity
     *
     * @return \Symfony\Component\Form\Form The form
     *
     * @ParamConverter("vehicle", options={"idNumber": "id"})
     */
    private function createDeleteForm(Vehicle $vehicle)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vehicle_delete', array('id' => $vehicle->getIdNumber())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/myVehicles", name="my_vehicles")
     */
    public function MyVehicleAction()
    {
        $vehicles = $this->getUser()->getVehicles();
        return $this->render('TravelCarBundle:Default:vehicle/index.html.twig', array(
            'vehicles' => $vehicles,
        ));
    }
}
