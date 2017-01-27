<?php

namespace TravelCarBundle\Entity;
use TravelCarBundle\Entity\Advert;
use TravelCarBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;


/**
* @ORM\Entity(repositoryClass="TravelCarBundle\Entity\Repository\ReservationRepository")
* @ORM\Table(name="travelCar_reservations")
*/
class Reservation
{
    
    /**
    * @ORM\ID
    * @ORM\ManyToOne(targetEntity="TravelCarBundle\Entity\User", inversedBy="reservations", cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */
    private $user;
    
    /**
    * @ORM\ID
    * @ORM\ManyToOne(targetEntity="TravelCarBundle\Entity\Advert", cascade={"persist"})
    * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
    */
    private $advert;
    
    /**
     * 
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numberOfPlace;

    


    /**
     * Set numberOfPlace
     *
     * @param integer $numberOfPlace
     *
     * @return Reservation
     */
    public function setNumberOfPlace($numberOfPlace)
    {
        $this->numberOfPlace = $numberOfPlace;

        return $this;
    }

    /**
     * Get numberOfPlace
     *
     * @return integer
     */
    public function getNumberOfPlace()
    {
        return $this->numberOfPlace;
    }

    /**
     * Set user
     *
     * @param \TravelCarBundle\Entity\User $user
     *
     * @return Reservation
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \TravelCarBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set advert
     *
     * @param \TravelCarBundle\Entity\Advert $advert
     *
     * @return Reservation
     */
    public function setAdvert(Advert $advert)
    {
        $this->advert = $advert;

        return $this;
    }

    /**
     * Get advert
     *
     * @return \TravelCarBundle\Entity\Advert
     */
    public function getAdvert()
    {
        return $this->advert;
    }
}
