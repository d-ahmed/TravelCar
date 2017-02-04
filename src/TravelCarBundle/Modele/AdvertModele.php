<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace TravelCarBundle\Modele;
/**
 * Description of AdvertModele
 *
 * @author danielahmed
 */
class AdvertModele {
    
    public function isValidInformation($departureCity, $cityOfArrival, $departureDate){
        
        preg_match('/[a-zA-Z]+/',$departureCity, $departureCity_match);
        preg_match('/[a-zA-Z]+/',$cityOfArrival, $cityOfArrival_match);
        preg_match('/\d{2} \d{2} \d{4}/',$departureDate, $departureDate_match);

        if((!isset($departureCity_match[0] )            ||
            !isset($cityOfArrival_match[0] )            ||
            !isset($departureDate_match[0] ) )          ||
            ($departureCity_match[0]!=$departureCity    ||
            $cityOfArrival_match[0]!=$cityOfArrival     ||
            $departureDate_match[0]!=$departureDate)
        ){
            return FALSE;
        }
        
        // On split la date en 3 variables , puis on créé un 
        // objet Datetime auquel on attribue ces 3 valeurs pour la BDD

        list($day, $month, $year) = preg_split('/ /', $departureDate);
        $departureDate = new \DateTime();
        $departureDate->setDate($year, $month, $day);
        return $departureDate;
    }
}
