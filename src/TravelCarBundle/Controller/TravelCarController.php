<?php

namespace TravelCarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
    public function homeAction()
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
}
