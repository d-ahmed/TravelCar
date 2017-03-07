<?php

namespace TravelCarBundle\Entity;

use TravelCarBundle\Entity\Advert;
use TravelCarBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="TravelCarBundle\Entity\Repository\PostRepository")
* @ORM\Table(name="travelCar_posts")
*/

class Post
{
    /**
     * @ORM\ID
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="TravelCarBundle\Entity\User",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="TravelCarBundle\Entity\Advert", inversedBy="posts", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $advert;

    /**
     * @ORM\Column(type="string")
     */
    private $comment;
    
    /**
     * @ORM\Column(type="string", nullable=true )
     */
    private $response;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    public function __construct()
    {
        $this->date = new \DateTime();
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
     * Set comment
     *
     * @param string $comment
     *
     * @return Post
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set response
     *
     * @param string $response
     *
     * @return Post
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Get response
     *
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Post
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
     * Set user
     *
     * @param \TravelCarBundle\Entity\User $user
     *
     * @return Post
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
     * @return Post
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
