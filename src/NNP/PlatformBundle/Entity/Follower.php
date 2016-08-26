<?php

namespace NNP\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Follower
 *
 * @ORM\Table(name="follower")
 * @ORM\Entity(repositoryClass="NNP\PlatformBundle\Repository\FollowerRepository")
 */
class Follower
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="idFollower", type="integer")
     */
    private $idFollower;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFollow", type="datetimetz")
     */
    private $dateFollow;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateUnfollow", type="datetimetz", nullable=true)
     */
    private $dateUnfollow;

    /**
     * @var string
     *
     * @ORM\Column(name="statut", type="string", length=255, nullable=true)
     */
    private $statut;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idFollower
     *
     * @param integer $idFollower
     *
     * @return Follower
     */
    public function setIdFollower($idFollower)
    {
        $this->idFollower = $idFollower;

        return $this;
    }

    /**
     * Get idFollower
     *
     * @return int
     */
    public function getIdFollower()
    {
        return $this->idFollower;
    }

    /**
     * Set dateFollow
     *
     * @param \DateTime $dateFollow
     *
     * @return Follower
     */
    public function setDateFollow($dateFollow)
    {
        $this->dateFollow = $dateFollow;

        return $this;
    }

    /**
     * Get dateFollow
     *
     * @return \DateTime
     */
    public function getDateFollow()
    {
        return $this->dateFollow;
    }

    /**
     * Set dateUnfollow
     *
     * @param \DateTime $dateUnfollow
     *
     * @return Follower
     */
    public function setDateUnfollow($dateUnfollow)
    {
        $this->dateUnfollow = $dateUnfollow;

        return $this;
    }

    /**
     * Get dateUnfollow
     *
     * @return \DateTime
     */
    public function getDateUnfollow()
    {
        return $this->dateUnfollow;
    }

    /**
     * Set statut
     *
     * @param string $statut
     *
     * @return Follower
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return string
     */
    public function getStatut()
    {
        return $this->statut;
    }
}

