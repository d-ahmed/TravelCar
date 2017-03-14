<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TravelCarBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use TravelCarBundle\Entity\Advert;
use TravelCarBundle\Entity\Post;
use \Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use TravelCarBundle\Form\PostType;

/**
 * Description of PostController
 *
 * @author danielahmed
 */
class PostController extends Controller
{

    /**
     * @param Advert $advert
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @ParamConverter("advert", options={"id": "advertId"})
     * @Route("posts/view/{advertId}", name="view_posts", requirements={"advertId"="\d+"})
     */
    public function viewAction(Advert $advert, Request $request)
    {
        $posts = $this->getDoctrine()
                ->getRepository('TravelCarBundle:Post')
                ->findBy(array('advert'=>$advert));
        
        return $this->render('TravelCarBundle:Default:Post/ContaintsUsed/listPost.html.twig', array(
            'posts'=>$posts,
        ));
    }
    
    /**
     * @ParamConverter("advert", options={"id": "advertId"})
     */
    public function renderFormAction(Advert $advert)
    {
        $form = $this->createForm('TravelCarBundle\Form\PostType');
        return $this->render('TravelCarBundle:Default:Post/ContaintsUsed/add.html.twig', array(
            'post'=>$form->createView(),
            'advert'=>$advert
        ));
    }

    /**
     * @param Advert $advert
     * @param Request $request
     * @return int|\Symfony\Component\HttpFoundation\RedirectResponse
     * @ParamConverter("advert", options={"id": "advertId"})
     * @Route("posts/add/{advertId}", name="add_post", requirements={"advertId"="\d+"})
     */
    public function addAction(Advert $advert, Request $request)
    {
        if (!$advert) {
            $this->createNotFoundException('Problème de serveur');
        }
        
        $post = new Post();
        
        $form = $this->createForm('TravelCarBundle\Form\PostType', $post);
        
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            
            if ($form->isValid()) {
                if ($this->getUser()) {
                    $post->setAdvert($advert)->setUser($this->getUser());
                    $advert->addPost($post);
                    $this->getDoctrine()->getManager()->flush();
                } else {
                    return $this->redirectToRoute('fos_user_security_login');
                }
            }
            return $this->redirectToRoute('view_advert', array(
                'id' => $advert->getId(),
            ));
        } else {
            throw $this->createNotFoundException('Page non trouvée');
        }
        return 0;
    }

    /**
     * @param Post $post
     * @param Request $request
     * @return int|\Symfony\Component\HttpFoundation\RedirectResponse
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/post/{id}", name="past_edit")
     */
    public function editAction(Post $post, Request $request)
    {
        if (!$post) {
            $this->createNotFoundException('Problème de serveur');
        }

        $form = $this->createForm(PostType::class, $post);


        if ($request->isMethod('POST') && $post->getAdvert()->getUser()->getId()==$this->getUser()->getId()) {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $this->getDoctrine()->getManager()->flush();
            }
            return $this->redirectToRoute('view_advert', array(
                'id' => $post->getAdvert()->getId(),
            ));
        } else {
            throw $this->createNotFoundException('Page non trouvée');
        }
        return 0;
    }
    
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function viewAllAction()
    {
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function removeAction()
    {

    }

    public function myReservationsAction(Request $request)
    {

        $reservations = $this->getDoctrine()->getRepository('TravelCarBundle:Reservation')
            ->findBy(array('user'=>$this->getUser()));
        return $this->render('TravelCarBundle:Default:Advert/Layout/myResrvations.html.twig', array(
            'reservations'=>$reservations
        ));
    }
}
