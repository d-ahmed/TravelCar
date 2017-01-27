<?php

namespace TravelCarBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AnnonceControllerTest extends WebTestCase
{
    public function testAjouter()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'annonce/ajouter');
    }

}
