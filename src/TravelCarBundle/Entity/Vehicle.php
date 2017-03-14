<?php

namespace TravelCarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="TravelCarBundle\Entity\Repository\VehicleRepository")
* @ORM\Table(name="travelCar_vehicles")
*/
class Vehicle
{
 
    
    /**
    * @ORM\Id
    * @ORM\Column(type="string")
    */
    private $idNumber;
    
    /**
    *
    * @ORM\Column(type="string", nullable=true)
    */
    private $model;
    
    /**
    *
    * @ORM\Column(type="string", nullable=true)
    */
    private $color;
    
    /**
    *
    * @ORM\Column(type="string", nullable=true)
    */
    private $fuel;



    

    /**
     * Set idNumber
     *
     * @param string $idNumber
     *
     * @return Vehicle
     */
    public function setIdNumber($idNumber)
    {
        $this->idNumber = $idNumber;

        return $this;
    }

    /**
     * Get idNumber
     *
     * @return string
     */
    public function getIdNumber()
    {
        return $this->idNumber;
    }

    /**
     * Set model
     *
     * @param string $model
     *
     * @return Vehicle
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return Vehicle
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set fuel
     *
     * @param string $fuel
     *
     * @return Vehicle
     */
    public function setFuel($fuel)
    {
        $this->fuel = $fuel;

        return $this;
    }

    /**
     * Get fuel
     *
     * @return string
     */
    public function getFuel()
    {
        return $this->fuel;
    }
}
