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

use TravelCarBundle\Entity\Post;

/**
 * Description of PostData
 *
 * @author danielahmed
 */
class PostData extends AbstractFixture implements OrderedFixtureInterface
{
    //put your code here
    public function getOrder()
    {
        return 5;
    }

    public function load(ObjectManager $manager)
    {
        $post1 = new Post();
        $post1->setAdvert($this->getReference('advert1'))
                ->setUser($this->getReference('user2'))
                ->setComment('Tu passes par quelle ville ?');
        $manager->persist($post1);
        
        $post2 = new Post();
        $post2->setAdvert($this->getReference('advert1'))
                ->setUser($this->getReference('user2'))
                ->setComment('Tu part d ou?')
                ->setResponse('Je part de la Gare');
        $manager->persist($post2);
        
        $post3 = new Post();
        $post3->setAdvert($this->getReference('advert3'))
                ->setUser($this->getReference('user2'))
                ->setComment('Tu part d ou?')
                ->setResponse('Je part de la Gare');
        $manager->persist($post3);
        
        $post4 = new Post();
        $post4->setAdvert($this->getReference('advert3'))
                ->setUser($this->getReference('user1'))
                ->setComment('Tu part d ou?')
                ->setResponse('Je part de la Gare');
        $manager->persist($post4);
        
        $manager->flush();
    }
}
