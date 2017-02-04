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

use TravelCarBundle\Entity\Reservation;

class ReservationData extends AbstractFixture implements OrderedFixtureInterface{
    //put your code here
    public function getOrder(){
        return 4;
    }

    public function load(ObjectManager $manager) {
        $reservation1 = new Reservation();
        $reservation1->setAdvert($this->getReference('advert1'))
                ->setUser($this->getReference('user2'))
                ->setNumberOfPlace(2);
        $manager->persist($reservation1);
        
        $reservation2 = new Reservation();
        $reservation2->setAdvert($this->getReference('advert3'))
                ->setUser($this->getReference('user2'))
                ->setNumberOfPlace(2);
        $manager->persist($reservation2);
        
        $reservation2 = new Reservation();
        $reservation2->setAdvert($this->getReference('advert2'))
                ->setUser($this->getReference('user1'))
                ->setNumberOfPlace(2);
        $manager->persist($reservation2);
        
        $manager->flush();
    }

}
