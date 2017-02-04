<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TravelCarBundle\DataFixtures\ORM;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use TravelCarBundle\Entity\Advert;

/**
 * Description of AdvertData
 *
 * @author danielahmed
 */
class AdvertData extends AbstractFixture implements OrderedFixtureInterface{
    //put your code here
    public function load(ObjectManager $manager) {
        $date = new \DateTime();
        
        $advert1 = new Advert();
        $date->setDate(2017, 02, 28);
        $date->setTime(06, 30, 00);
        $advert1->setDepartureCity('Nantes')
                ->setCityOfArrival('Paris')
                ->setDepartureDate($date)
                ->setUser($this->getReference('user1'))
                ->setNumberOfPlace(3)
                ->setPricePerPersonne(21)
                ->setTravelTime($date);
        $manager->persist($advert1);
        
        $advert2 = new Advert();
        $date->setDate(2017, 02, 20);
        $date->setTime(12, 30, 00);
        $advert2->setDepartureCity('Nantes')
                ->setCityOfArrival('Marseille')
                ->setDepartureDate($date)
                ->setUser($this->getReference('user2'))
                ->setNumberOfPlace(3)
                ->setPricePerPersonne(21)
                ->setTravelTime($date->setTime(3, 30, 00));
        $manager->persist($advert2);
        
        $advert3 = new Advert();
        $date->setDate(2017, 02, 20);
        $date->setTime(12, 30, 00);
        $advert3->setDepartureCity('Nantes')
                ->setCityOfArrival('Paris')
                ->setDepartureDate($date)
                ->setUser($this->getReference('user1'))
                ->setNumberOfPlace(3)
                ->setPricePerPersonne(22)
                ->setTravelTime($date->setTime(3, 30, 00));
        $manager->persist($advert3);
        
        
        $manager->flush();
        
        $this->addReference('advert1', $advert1);
        $this->addReference('advert2', $advert2);
        $this->addReference('advert3', $advert3);
                
    }
    
    public function getOrder()
    {
        return 3;
    }
}
