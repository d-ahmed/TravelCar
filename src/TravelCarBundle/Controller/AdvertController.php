<?php

namespace TravelCarBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TravelCarBundle\Entity\Advert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use TravelCarBundle\Form\AdvertType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

class AdvertController extends Controller
{
    public function searchAction(Request $request)
    {
        $form = $this->createForm('TravelCarBundle\Form\SearchType');
        return $this->render('TravelCarBundle:Default:Advert/ContaintsUsed/search.html.twig', array(
            'search'=>$form->createView()
        ));
    }

    /**
     *
     * @param $page
     * @param $numberPerPage
     * @param Request $request
     * @return RedirectResponse|Response
     * @Route("search/adverts/{page}/{numberPerPage}", name="searchTreatment_adverts",
     *     defaults={"page"=1, "numberPerPage"=5}, requirements={"page"="\d+", "numberPerPage"="\d+"}
     * )
     * @Method({"GET", "POST"})
     */
    public function searchTreatmentAction($page, $numberPerPage, Request $request)
    {
        if ($page < 1) {
            throw $this->createNotFoundException('Traduction : page n existe pas');
        }
        
        $form = $this->createForm('TravelCarBundle\Form\SearchType');
        
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            
            if ($form->isValid()) {
                $adverts = $this->getDoctrine()
                        ->getRepository('TravelCarBundle:Advert')
                        ->findBymatchAnnonces(
                            $form->get('departureCity')->getData(),
                            $form->get('cityOfArrival')->getData(),
                            $form->get('departureDate')->getData(),
                            $page,
                            $numberPerPage
                        );
                $numberPage = ceil(count($adverts)/$numberPerPage);

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
        } else {
            throw $this->createNotFoundException('Page non trouvée');
        }
        return $this->redirectToRoute('home');
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Security("has_role('ROLE_USER')")
     * @Route("adverts/add", name="add_advert")
     * @Method({"GET", "POST"})
     */
    public function addAction(Request $request)
    {
        $advert = new Advert();
        
        $form = $this->createForm(AdvertType::class, $advert);
        
        if ($request->isMethod('POST') && $form->handleRequest($request)) {
            $advertConflict = $this->getDoctrine()
                                        ->getRepository('TravelCarBundle:Advert')
                                        ->findByUserDepartureDate($this->getUser(), $advert->getDepartureDate());
                
            if (count($advertConflict)>0) {
                throw $this->createNotFoundException('Traduction : Conflit d annonce');
            }

            $advert->setUser($this->getUser());
            $this->getUser()->addAdvert($advert);
            $this->getDoctrine()->getManager()->flush();; // Recupération entityManager

            // Permet de récuperer l'id de la dernière annonce créee
            $last = $this->getDoctrine()
                        ->getRepository('TravelCarBundle:Advert')
                        ->findOneBy(array('user' => $this->getUser()), array('id' => 'desc'));
                
            return $this->redirectToRoute('view_advert', array(
                'id' => $last->getId(),
            ));
        }
        
        return $this->render('TravelCarBundle:Default:Advert/Layout/add.html.twig', array(
            'form' => $form->createView(),
            'nameBtn'=>'btn.add'
        ));
    }

    /**
     * @param Advert $advert
     * @return Response
     * @Route("/advert/{id}", name="view_advert", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function viewAction(Advert $advert)
    {

        $deleteForm = $this->createDeleteForm($advert);
        if ($advert->getUser()->getId()==$this->getUser()->getId()) {
            return $this->render('TravelCarBundle:Default:Advert/Layout/viewDriver.html.twig', array(
                'advert' => $advert,
                'delete_form' => $deleteForm->createView(),
                'has_reserved'=>1
            ));
        }

        return $this->render('TravelCarBundle:Default:Advert/Layout/viewUser.html.twig', array(
            'advert' => $advert,
        ));
    }

    /**
     * @param Advert $advert
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Security("has_role('ROLE_USER')")
     * @Route("adverts/modify/{id}", name="modify_advert", requirements={"id"="\d+"})
     * @Method({"GET", "POST"})
     */
    public function modifyAction(Advert $advert, Request $request)
    {
        $form = $this->createForm('TravelCarBundle\Form\AdvertType', $advert);
        
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
                
            $advertConflict = $this->getDoctrine()
                        ->getRepository('TravelCarBundle:Advert')
                        ->findByUserDepartureDate($this->getUser(), $advert->getDepartureDate());
                
            if (count($advertConflict)>0) {
                throw $this->createNotFoundException('Traduction : Conflit d annonce');
            }

            $this->getDoctrine()->getManager()->flush();
                
            return $this->redirectToRoute('view_advert', array(
                'id' => $advert->getId(),
            ));
        }
        
        return $this->render('TravelCarBundle:Default:Advert/Layout/add.html.twig', array(
            'form' => $form->createView(),
            'nameBtn'=>'btn.modify'
        ));
    }

    /**
     * @param Advert $advert
     * @param Request $request
     * @return Response
     * @Security("has_role('ROLE_USER')")
     * @Route("adverts/remove/{id}", name="remove_advert", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function removeAction(Advert $advert, Request $request)
    {
        if ($advert->getUser()!=$this->getUser()) {
            throw $this->createNotFoundException('Pas le doit');
        } else {
            $this->getUser()->removeAdvert($advert);
            $em = $this->getDoctrine()->getManager();; // Recupération entityManager
            $em->remove($advert);
            $em->flush();
            
        }
        return $this->redirectToRoute('my_adverts');
    }

    /**
     * Creates a form to delete a vehicle entity.
     *
     * @param Advert $advert the advert entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Advert $advert)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('remove_advert', array('id' => $advert->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
    
    /**
     * @Security("has_role('ROLE_USER')")
     * @Route("/myAdverts/{mode}/{page}/{numberPerPage}", name="my_adverts",
     *     defaults={"page"=1, "numberPerPage"=5, "mode"="block"},
     *     requirements={"page"="\d*", "numberPerPage"="\d*", "mode"="list|block"}
     * )
     */
    public function myAdvertsAction($mode, $page, $numberPerPage, Request $request)
    {
        if (!$page) {
            $page=1;
        }
        $adverts = $this->getDoctrine()->getRepository('TravelCarBundle:Advert')
                ->findByUser($this->getUser(), $page, $numberPerPage);
        $numberPage = ceil(count($adverts)/$numberPerPage);
        return $this->render('TravelCarBundle:Default:Advert/Layout/myAdverts.html.twig', array(
        'adverts'=>$adverts,
        'page'=>$page,
        'numberPage'=>$numberPage,
        'mode'=>$mode));
    }

    /**
     * @Route("/advert/lastAdverts", name="last_adverts_to_expose", options={"expose"=true} )
     */
    public function lastAdvertsAction(){
        $adverts = $this->getDoctrine()->getRepository('TravelCarBundle:Advert')->findByLast();

        return new JsonResponse($adverts);
    }

    /**
     * @Route("/advert/price/{sort}", name="price_adverts_to_expose",
     *     options={"expose"=true}, requirements={"sort"="desc|asc"}
     *)
     */
    public function lastByPriceAdvertsAction($sort){
        $adverts = $this->getDoctrine()->getRepository('TravelCarBundle:Advert')->findLastByPrice($sort);
        return new JsonResponse($adverts);
    }
}
