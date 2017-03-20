<?php


namespace TravelCarBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use TravelCarBundle\Entity\User;

class UserData extends AbstractFixture implements OrderedFixtureInterface
{
    //put your code here
    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setUsername('admin')
                ->setEmail('admin@admin.com')
                ->setPlainPassword('admin')
                ->setRoles(array('ROLE_ADMIN'))
                ->setLastName('Ahmed')
                ->setName('Daniel')
                ->setPhoneNumber(0602457898)
                ->setEnabled(true)
                ->addVehicle($this->getReference('vehicle2'));
        
        $manager->persist($user1);
        
        
        $user2 = new User();
        $user2->setUsername('test')
                ->setEmail('anasse@gmail.com')
                ->setPlainPassword('user')
                ->setRoles(array('ROLE_USER'))
                ->setName('Anasse')
                ->setLastName('Zougarh')
                ->setPhoneNumber(0602457898)
                ->setEnabled(true)
                ->addVehicle($this->getReference('vehicle1'))
                ->addVehicle($this->getReference('vehicle3'));
        
        $manager->persist($user2);
        
        $manager->flush();
        
        $this->addReference('user1', $user1);
        $this->addReference('user2', $user2);
    }
    
    public function getOrder()
    {
        return 2;
    }
}
