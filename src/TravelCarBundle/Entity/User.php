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
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $style;

    /**
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $font;

    /**
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $facebookId;

    /**
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $googleId;

    /**
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $twitterId;
    
    /**
    * @ORM\ManyToMany(targetEntity="TravelCarBundle\Entity\Vehicle", cascade={"persist"})
    * @ORM\JoinTable(name="users_vehicles",
    *      joinColumns={@ORM\JoinColumn(referencedColumnName="id")},
    *      inverseJoinColumns={@ORM\JoinColumn(name="vehicle_id", referencedColumnName="id_number", unique=true)}
    * )
    */
     private $vehicles;

     /**
     *
     * @ORM\Column(type="string", nullable=true)
     */
     private $img;

    
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
        $this->adverts->add($advert);

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
        $this->reservations->add($reservation);

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

    /**
     * Set style
     *
     * @param string $style
     *
     * @return User
     */
    public function setStyle($style)
    {
        $this->style = $style;

        return $this;
    }

    /**
     * Get style
     *
     * @return string
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * Set font
     *
     * @param string $font
     *
     * @return User
     */
    public function setFont($font)
    {
        $this->font = $font;

        return $this;
    }

    /**
     * Get font
     *
     * @return string
     */
    public function getFont()
    {
        return $this->font;
    }

    /**
     * Set facebookId
     *
     * @param string $facebookId
     *
     * @return User
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;

        return $this;
    }

    /**
     * Get facebookId
     *
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * Set googleId
     *
     * @param string $googleId
     *
     * @return User
     */
    public function setGoogleId($googleId)
    {
        $this->googleId = $googleId;

        return $this;
    }

    /**
     * Get googleId
     *
     * @return string
     */
    public function getGoogleId()
    {
        return $this->googleId;
    }

    /**
     * Set twitterId
     *
     * @param string $twitterId
     *
     * @return User
     */
    public function setTwitterId($twitterId)
    {
        $this->twitterId = $twitterId;

        return $this;
    }

    /**
     * Get twitterId
     *
     * @return string
     */
    public function getTwitterId()
    {
        return $this->twitterId;
    }

    /**
     * Set img
     *
     * @param string $img
     *
     * @return User
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Get img
     *
     * @return string
     */
    public function getImg()
    {
        return $this->img;
    }
}
