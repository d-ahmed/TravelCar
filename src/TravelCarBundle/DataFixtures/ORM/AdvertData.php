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
class AdvertData extends AbstractFixture implements OrderedFixtureInterface
{
    //put your code here
    public function load(ObjectManager $manager)
    {
        $date1 = new \DateTime();
        
        $advert1 = new Advert();
        $date1->setDate(2017, 02, 28);
        $date1->setTime(06, 30, 00);
        $advert1->setDepartureCity('Nantes')
                ->setCityOfArrival('Paris')
                ->setDepartureDate($date1)
                ->setUser($this->getReference('user1'))
                ->setNumberOfPlace(3)
                ->setPricePerPersonne(21)
                ->setTravelTime($date1);
        $manager->persist($this->getReference('user1')->addAdvert($advert1));
        
        $date2 = new \DateTime();
        $advert2 = new Advert();
        $date2->setDate(2017, 02, 20);
        $date2->setTime(12, 30, 00);
        $advert2->setDepartureCity('Nantes')
                ->setCityOfArrival('Marseille')
                ->setDepartureDate($date2)
                ->setUser($this->getReference('user2'))
                ->setNumberOfPlace(3)
                ->setPricePerPersonne(21)
                ->setTravelTime($date2->setTime(3, 30, 00));
        $manager->persist($this->getReference('user2')->addAdvert($advert2));
        
        $date3 = new \DateTime();
        $advert3 = new Advert();
        $date3->setDate(2017, 02, 20);
        $date3->setTime(12, 30, 00);
        $advert3->setDepartureCity('Nantes')
                ->setCityOfArrival('Paris')
                ->setDepartureDate($date3)
                ->setUser($this->getReference('user1'))
                ->setNumberOfPlace(3)
                ->setPricePerPersonne(22)
                ->setTravelTime($date3->setTime(3, 30, 00));
        $manager->persist($this->getReference('user1')->addAdvert($advert3));
        
        $date4 = new \DateTime();
        $advert4 = new Advert();
        $date4->setDate(2017, 01, 20);
        $date4->setTime(12, 30, 00);
        $advert4->setDepartureCity('Nantes')
                ->setCityOfArrival('Paris')
                ->setDepartureDate($date4)
                ->setUser($this->getReference('user2'))
                ->setNumberOfPlace(3)
                ->setPricePerPersonne(22)
                ->setTravelTime($date4->setTime(3, 30, 00));
        $manager->persist($this->getReference('user2')->addAdvert($advert4));
        
        
        $manager->flush();
        
        $this->addReference('advert1', $advert1);
        $this->addReference('advert2', $advert2);
        $this->addReference('advert3', $advert3);
        $this->addReference('advert4', $advert4);
    }
    
    public function getOrder()
    {
        return 3;
    }
}
