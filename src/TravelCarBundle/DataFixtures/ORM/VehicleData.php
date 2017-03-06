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

use TravelCarBundle\Entity\Vehicle;

/**
 * Description of VehicleData
 *
 * @author danielahmed
 */
class VehicleData extends AbstractFixture implements OrderedFixtureInterface
{
    //put your code here
    public function getOrder()
    {
        return 1;
    }

    public function load(ObjectManager $manager)
    {
        $vehicle1 = new Vehicle();
        $vehicle1->setIdNumber('AZE23A')
                ->setColor('Rouge')
                ->setModel('BMW')
                ->setFuel('essence');
        $manager->persist($vehicle1);
        
        $vehicle2 = new Vehicle();
        $vehicle2->setIdNumber('AZE23B')
                ->setColor('Bleu')
                ->setModel('Twingo')
                ->setFuel('essence');
        $manager->persist($vehicle2);
        
        $vehicle3 = new Vehicle();
        $vehicle3->setIdNumber('AZE23C')
                ->setColor('Noir')
                ->setModel('Porche')
                ->setFuel('essence');
        $manager->persist($vehicle3);
        
        $manager->flush();
        
        $this->addReference('vehicle1', $vehicle1);
        $this->addReference('vehicle2', $vehicle2);
        $this->addReference('vehicle3', $vehicle3);
    }
}
