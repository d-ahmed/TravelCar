<?php

namespace TravelCarBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use TravelCarBundle\Entity\Advert;

/**
 * Class AdminController
 * @package TravelCarBundle\Controller
 * @Route("/admin/")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="admin_home")
     */
    public function homeAction()
    {
        return $this->render('TravelCarBundle:Admin:home.html.twig');
    }

    /**
     * @Route("/users/", name="admin_users")
     */
    public function viewUsersAction()
    {
        $users = $this->getDoctrine()->getRepository('TravelCarBundle:User')->findAll();
        return $this->render('TravelCarBundle:Admin:users.html.twig', array(
            'users'=>$users
        ));
    }

    /**
     * @Route("/adverts/", name="admin_adverts")
     */
    public function viewAdvertsAction()
    {
        $advert = $this->getDoctrine()->getRepository('TravelCarBundle:Advert')->findAll();
        return $this->render('TravelCarBundle:Admin:adverts.html.twig', array(
            'adverts'=>$advert
        ));
    }

    /**
     * @param Advert $advert
     * @return Response
     * @Route("/advert/{id}", name="admin_advert", requirements={"id"="\d+"}, options={"expose"=true})
     * @Method("GET")
     */
    public function showAdvertAction(Advert $advert){
        $deleteForm = $this->createDeleteAdvertForm($advert);

        return $this->render('TravelCarBundle:Admin:showAdvert.html.twig', array(
            'advert' => $advert,
            'delete_form' => $deleteForm->createView(),
            'has_reserved'=>1
        ));
    }

    private function createDeleteAdvertForm(Advert $advert)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_remove_advert', array('id' => $advert->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     * @param Advert $advert
     * @Route("adverts/remove/{id}", name="admin_remove_advert", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function removeAdvertAction(Advert $advert)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($advert);
        $em->flush();
        return $this->redirectToRoute('admin_adverts');
    }

}