<?php

namespace TravelCarBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use TravelCarBundle\Entity\Advert;
use TravelCarBundle\Entity\Reservation;
use TravelCarBundle\Entity\Vehicle;

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
    * @ORM\OneToMany(targetEntity="TravelCarBundle\Entity\Advert", mappedBy="user", cascade={"persist"})
    */
    private $adverts;
    
    
    /**
    *
    * @ORM\OneToMany(targetEntity="TravelCarBundle\Entity\Reservation", mappedBy="user", cascade={"persist"})
    */
    private $reservations;
    
    /**
    * @ORM\ManyToMany(targetEntity="TravelCarBundle\Entity\Vehicle", cascade={"persist"})
    * @ORM\JoinTable(name="users_vehicles",
    *      joinColumns={@ORM\JoinColumn(referencedColumnName="id")},
    *      inverseJoinColumns={@ORM\JoinColumn(name="vehicle_id", referencedColumnName="id_number", unique=true)}
    * )
    */
     private $vehicles;
    
    public function __construct()
    {
        parent::__construct();
        $this->adverts = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->vehicles = new ArrayCollection();
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
        $this->adverts[] = $advert;

        return $this;
    }

    /**
     * Remove advert
     *
     * @param \TravelCarBundle\Entity\Advert $advert
     */
    public function removeAdvert(Advert $advert)
    {
        $this->adverts->removeElement($advert);
    }

    /**
     * Get advert
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdvert()
    {
        return $this->adverts;
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

    /**
     * Get adverts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdverts()
    {
        return $this->adverts;
    }

    /**
     * Add vehicle
     *
     * @param \TravelCarBundle\Entity\Vehicle $vehicle
     *
     * @return User
     */
    public function addVehicle(Vehicle $vehicle)
    {
        $this->vehicles[] = $vehicle;

        return $this;
    }

    /**
     * Remove vehicle
     *
     * @param \TravelCarBundle\Entity\Vehicle $vehicle
     */
    public function removeVehicle(Vehicle $vehicle)
    {
        $this->vehicles->removeElement($vehicle);
    }

    /**
     * Get vehicles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVehicles()
    {
        return $this->vehicles;
    }
}
