<?php

namespace TravelCarBundle\Entity;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use TravelCarBundle\Entity\Advert;
use TravelCarBundle\Entity\Reservation;



/**
* @ORM\Entity(repositoryClass="TravelCarBundle\Entity\Repository\UserRepository")
* @ORM\Table(name="travelCar_users")
*/
class User extends BaseUser
{
   /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue(strategy="AUTO")
    */
   protected $id;
   
   
   /**
    * 
    * @ORM\Column(type="string", nullable=true)
    */
    private $name;
    
    /**
    * 
    * @ORM\Column(type="string", nullable=true)
    */
    private $lastName;
    
    
    /**
    * 
    * @ORM\Column(type="integer", nullable=true)
    */
    private $phoneNumber;
    
    /**
    * 
    * @ORM\Column(type="date", nullable=true)
    */
    private $birthDate;
    
    /**
    * 
    * @ORM\OneToMany(targetEntity="TravelCarBundle\Entity\Advert", mappedBy="users")
    */
    private $advert;
    
    
    /**
    * 
    * @ORM\OneToMany(targetEntity="TravelCarBundle\Entity\Reservation", mappedBy="users")
    */
    private $reservations;
    
   public function __construct()
   {
       parent::__construct();
       $this->advert = new ArrayCollection();
       $this->reservations = new ArrayCollection();
       
   }


    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set phoneNumber
     *
     * @param integer $phoneNumber
     *
     * @return User
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return integer
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     *
     * @return User
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Add advert
     *
     * @param \TravelCarBundle\Entity\Advert $advert
     *
     * @return User
     */
    public function addAdvert(Advert $advert)
    {
        $this->advert[] = $advert;

        return $this;
    }

    /**
     * Remove advert
     *
     * @param \TravelCarBundle\Entity\Advert $advert
     */
    public function removeAdvert(Advert $advert)
    {
        $this->advert->removeElement($advert);
    }

    /**
     * Get advert
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdvert()
    {
        return $this->advert;
    }

    /**
     * Add reservation
     *
     * @param \TravelCarBundle\Entity\Reservation $reservation
     *
     * @return User
     */
    public function addReservation(Reservation $reservation)
    {
        $this->reservations[] = $reservation;

        return $this;
    }

    /**
     * Remove reservation
     *
     * @param \TravelCarBundle\Entity\Reservation $reservation
     */
    public function removeReservation(Reservation $reservation)
    {
        $this->reservations->removeElement($reservation);
    }

    /**
     * Get reservations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReservations()
    {
        return $this->reservations;
    }
}
