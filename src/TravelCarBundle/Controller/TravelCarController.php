<?php

namespace TravelCarBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use TravelCarBundle\Form\StyleType;

/**
 * Class TravelCarController
 * @package TravelCarBundle\Controller
 * @Route("/")
 */
class TravelCarController extends Controller
{


    /**
     * @Route("/load/{format}",name="loadRss_travelCar_format", methods={"GET"},
     *     requirements={"format":"json"}, options={"expose"=true}
     * )
     */
    public function loadRssAction($format=null)
    {
        $fluxRss = $this->container->get('travel_car_load_rss');

        $items = $fluxRss->load();

        if($format){

            $normalizers = array(new ObjectNormalizer(), new GetSetMethodNormalizer());

            $serializer = new Serializer($normalizers);

            $normalized = $serializer->normalize($items);

            return new JsonResponse($normalized);
        }
        shuffle($items);
        return $this->render('TravelCarBundle:Default:TravelCar/ContaintsUsed/rssActu.html.twig', array(
            'items'=> $items,
        ));

    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name="home")
     */
    public function homeAction(Request $request)
    {
        return $this->render('TravelCarBundle:Default:TravelCar/Layout/home.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/about", name="tc_travelcarbundle_about", methods={"GET"})
     */
    public function aboutAction()
    {
        return $this->render('TravelCarBundle:Default:TravelCar/Layout/about.html.twig');
    }


    /**
     * @param Request $request
     * @Route("profile/style", name="travel_car_style")
     * @Method({"GET","POST"})
     */
    public function styleAclion(Request $request){

        $styleForm = $this->createForm(StyleType::class);

        if($request->isMethod('Post') && $styleForm->handleRequest($request)->isValid()){
            $this->getUser()->setStyle($styleForm->get('style')->getData());
            $this->getUser()->setFont($styleForm->get('font')->getData());
            $this->getDoctrine()->getManager()->flush();
            $request->getSession()->set('style',$styleForm->get('style')->getData());
            $request->getSession()->set('font',$styleForm->get('font')->getData());
            return $this->redirectToRoute('fos_user_profile_show');
        }

        return $this->render('TravelCarBundle:Default:TravelCar/Layout/style.html.twig', array(
            'styleForm'=>$styleForm->createView()
        ));

    }

    /**
     * @param Request $request
     * @Route("/language", name="travel_car_language")
     * @Method({"GET","POST"})
     */
    public function renderLanguageAction(Request $request){

        if($request->isMethod('POST')){

            // On enregistre la langue en session
            $this->get('session')->set('_locale', $request->get('language'));

            // on tente de rediriger vers la page d'origine
            $url = $request->headers->get('referer');

        }
        return new RedirectResponse($url);
    }
}
