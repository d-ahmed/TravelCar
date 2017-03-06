<?php

namespace TravelCarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
class UserController extends Controller
{
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function viewAllAction(){
        
    }
    
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function removeAction(){
        // Lors de la suppression d'une personne, il faut supprimer toutes les informations concernant la personne
    }
    
    
}
