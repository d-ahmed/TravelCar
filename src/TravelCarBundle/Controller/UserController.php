<?php

namespace TravelCarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
