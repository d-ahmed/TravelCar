<?php

namespace TravelCarBundle\Controller;

use TravelCarBundle\Entity\Vehicle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Vehicle controller.
 *
 */
class VehicleController extends Controller
{
    /**
     * Lists all vehicle entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $vehicles = $em->getRepository('TravelCarBundle:Vehicle')->findAll();

        return $this->render('vehicle/index.html.twig', array(
            'vehicles' => $vehicles,
        ));
    }

    /**
     * Creates a new vehicle entity.
     *
     */
    public function newAction(Request $request)
    {
        $vehicle = new Vehicle();
        $form = $this->createForm('TravelCarBundle\Form\VehicleType', $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $this->getUser()->addVehicle($vehicle);
            $em->flush($this->getUser());

            return $this->redirectToRoute('vehicle_show', array('id' => $vehicle->getIdNumber()));
        }

        return $this->render('vehicle/new.html.twig', array(
            'vehicle' => $vehicle,
            'form' => $form->createView(),
        ));
    }


    
    /**
     * @ParamConverter("vehicle", options={"idNumber": "id"})
     */
    public function showAction(Vehicle $vehicle)
    {
        $deleteForm = $this->createDeleteForm($vehicle);

        return $this->render('vehicle/show.html.twig', array(
            'vehicle' => $vehicle,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    public function MyVehicleAction()
    {

        $vehicles = $this->getUser()->getVehicles();
        dump($vehicles);
        return $this->render('vehicle/index.html.twig', array(
            'vehicles' => $vehicles,
        ));
    }

    /**
     * @ParamConverter("vehicle", options={"idNumber": "id"})
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

        return $this->render('vehicle/edit.html.twig', array(
            'vehicle' => $vehicle,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @ParamConverter("vehicle", options={"idNumber": "id"})
     */
    public function deleteAction(Request $request, Vehicle $vehicle)
    {
        $form = $this->createDeleteForm($vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $this->getUser()->removeVehicle($vehicle);
            $em->flush($this->getUser());
        }

        return $this->redirectToRoute('my_vehicles');
    }

    /**
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
}
