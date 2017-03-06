<?php

namespace TravelCarBundle\Entity;

use TravelCarBundle\Entity\Vehicle;
use TravelCarBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity(repositoryClass="TravelCarBundle\Entity\Repository\AdvertRepository")
 * @ORM\Table(name="travelCar_advert")
 */
class Advert
{
    /**
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
   /**
   * @ORM\ManyToOne(targetEntity="TravelCarBundle\Entity\Vehicle", cascade={"persist"})
   * @ORM\JoinColumn(referencedColumnName="id_number", nullable=true)
   */
    private $vehicle;
    
    /**
   * @ORM\ManyToOne(targetEntity="TravelCarBundle\Entity\User", inversedBy="adverts", cascade={"persist"})
   * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
   * @Assert\Valid()
   */
    private $user;
    
    
    /**
    *
    * @ORM\Column(type="datetime", nullable=false)
    * @Assert\DateTime()
    */
    private $date;
    
    /**
     *
     * @ORM\Column(type="datetime", nullable=false)
     *
     *
     */
    private $departureDate;
    
    /**
     *
     * @ORM\Column(type="time", nullable=false)
     *
     */
    private $travelTime;


    /**
     *
     * @ORM\Column(type="string", nullable=false, length=50)
     */
    private $departureCity;
    
    /**
     *
     * @ORM\Column(type="string", nullable=false, length=50)
     *
     */
    private $cityOfArrival;
    
    /**
     *
     */
    private $departureTime;
    
    
    /**
     *
     *
     * @ORM\Column(type="float", nullable=false)
     */
    private $pricePerPersonne;
    
    
    /**
     *
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $numberOfPlace;
    
    /**
     *
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numberOfReservation;

    /**
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $detail;
    
    public function __construct()
    {
        $this->date = new \Datetime();
        $this->numberOfReservation = 0;
    }
    
    /**
     * increase nbPlaces
     *
     * @return Annonce
     */
    public function increaseNbPlaces($numberOfPlace = null)
    {
        if ($numberOfPlace) {
            $this->numberOfReservation-=$numberOfPlace;
        } else {
            $this->numberOfReservation--;
        }
        return $this;
    }
    
    /**
     * decrease nbPlaces
     *
     * @return Annonce
     */
    public function decreaseNbPlaces($numberOfPlace = null)
    {
        if ($numberOfPlace) {
            $this->numberOfReservation+=$numberOfPlace;
        } else {
            $this->numberOfReservation++;
        }
        return $this;
    }
    
    /**
     * Get departureTime
     *
     * @return \DateTime
     */
    public function getDepartureTime()
    {
        return $this->departureDate->format('h:m');
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Advert
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set departureDate
     *
     * @param \DateTime $departureDate
     *
     * @return Advert
     */
    public function setDepartureDate($departureDate)
    {
        $this->departureDate = $departureDate;

        return $this;
    }

    /**
     * Get departureDate
     *
     * @return \DateTime
     */
    public function getDepartureDate()
    {
        return $this->departureDate;
    }

    /**
     * Set travelTime
     *
     * @param \DateTime $travelTime
     *
     * @return Advert
     */
    public function setTravelTime($travelTime)
    {
        $this->travelTime = $travelTime;

        return $this;
    }

    /**
     * Get travelTime
     *
     * @return \DateTime
     */
    public function getTravelTime()
    {
        return $this->travelTime;
    }

    /**
     * Set departureCity
     *
     * @param string $departureCity
     *
     * @return Advert
     */
    public function setDepartureCity($departureCity)
    {
        $this->departureCity = $departureCity;

        return $this;
    }

    /**
     * Get departureCity
     *
     * @return string
     */
    public function getDepartureCity()
    {
        return $this->departureCity;
    }

    /**
     * Set cityOfArrival
     *
     * @param string $cityOfArrival
     *
     * @return Advert
     */
    public function setCityOfArrival($cityOfArrival)
    {
        $this->cityOfArrival = $cityOfArrival;

        return $this;
    }

    /**
     * Get cityOfArrival
     *
     * @return string
     */
    public function getCityOfArrival()
    {
        return $this->cityOfArrival;
    }

    /**
     * Set pricePerPersonne
     *
     * @param float $pricePerPersonne
     *
     * @return Advert
     */
    public function setPricePerPersonne($pricePerPersonne)
    {
        $this->pricePerPersonne = $pricePerPersonne;

        return $this;
    }

    /**
     * Get pricePerPersonne
     *
     * @return float
     */
    public function getPricePerPersonne()
    {
        return $this->pricePerPersonne;
    }

    /**
     * Set numberOfPlace
     *
     * @param integer $numberOfPlace
     *
     * @return Advert
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
     * Set vehicle
     *
     * @param \TravelCarBundle\Entity\Vehicle $vehicle
     *
     * @return Advert
     */
    public function setVehicle(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    /**
     * Get vehicle
     *
     * @return \TravelCarBundle\Entity\Vehicle
     */
    public function getVehicle()
    {
        return $this->vehicle;
    }

    /**
     * Set user
     *
     * @param \TravelCarBundle\Entity\User $user
     *
     * @return Advert
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
     * Set detail
     *
     * @param string $detail
     *
     * @return Advert
     */
    public function setDetail($detail)
    {
        $this->detail = $detail;

        return $this;
    }

    /**
     * Get detail
     *
     * @return string
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * Set numberOfReservation
     *
     * @param integer $numberOfReservation
     *
     * @return Advert
     */
    public function setNumberOfReservation($numberOfReservation)
    {
        $this->numberOfReservation = $numberOfReservation;

        return $this;
    }

    /**
     * Get numberOfReservation
     *
     * @return integer
     */
    public function getNumberOfReservation()
    {
        return $this->numberOfReservation;
    }
}
