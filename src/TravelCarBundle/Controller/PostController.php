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
/**
 * Description of PostController
 *
 * @author danielahmed
 */
class PostController extends Controller{
    
    /**
     * @ParamConverter("advert", options={"id": "advertId"})
     */
    public function viewAction(Advert $advert, Request $request){
        $posts = $this->getDoctrine()
                ->getRepository('TravelCarBundle:Post')
                ->findBy(array('advert'=>$advert));
        
        return $this->render('TravelCarBundle:Default:Post/ContaintsUsed/listPost.html.twig',array(
            'posts'=>$posts,
        ));
    }
    
    /**
     * @ParamConverter("advert", options={"id": "advertId"})
     */
    public function renderFormAction(Advert $advert){
        $form = $this->createForm('TravelCarBundle\Form\PostType');
        return $this->render('TravelCarBundle:Default:Post/ContaintsUsed/add.html.twig',array(
            'post'=>$form->createView(),
            'advert'=>$advert
        ));
    }
    
    /**
     * @ParamConverter("advert", options={"id": "advertId"})
     */
    public function addAction(Advert $advert, Request $request){
        
        if(!$advert) $this->createNotFoundException ('Problème de serveur');
        
        $post = new Post();
        
        $form = $this->createForm('TravelCarBundle\Form\PostType', $post);
        
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            
            if ($form->isValid()) {
                if($this->getUser()){
                    $post->setAdvert($advert)->setUser($this->getUser());
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($post);
                    $em->flush();
                }else{
                    return $this->redirectToRoute('fos_user_security_login');
                }   
            }
            return $this->redirectToRoute('view_advert', array(
                'id' => $advert->getId(),
            ));
        }else{
            throw $this->createNotFoundException('Page non trouvée');
        }
        return 0;
    }
    
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function viewAllAction(){
        
    }
    
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function removeAction(){
        
    }
}
