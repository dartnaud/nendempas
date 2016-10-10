<?php

namespace NNP\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire")
 * @ORM\Entity(repositoryClass="NNP\PlatformBundle\Repository\CommentaireRepository")
 */
class Commentaire
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
     * @var string
     *
     * @ORM\Column(name="commentaire", type="text")
     */
    private $commentaire;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetimetz")
     */
    private $dateCreation;

    /**
     * @var string
     *
     * @ORM\Column(name="statut", type="string", length=255, nullable=true)
     */
    private $statut;

    /**
     *@ORM\ManyToOne(targetEntity = "NNP\PlatformBundle\Entity\Ndem")
     *@ORM\JoinColumn(nullable=false)
     */
    private $ndem;

    /**
     *@ORM\ManyToOne(targetEntity = "NNP\PlatformBundle\Entity\User", cascade={"persist", "remove"})
     *@ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $user;

    public function __construct(){
        $this->dateCreation = new \DateTime();
    }

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
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return Commentaire
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Commentaire
     */
    public function setDateCreation(\DateTime $dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set statut
     *
     * @param string $statut
     *
     * @return Commentaire
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


    /**
     * Set ndem
     *
     */
    public function setNdem(Ndem $ndem)
    {
        $this->ndem = $ndem;

        return $this;
    }

    /**
     * Get ndem
     *
     * @return string
     */
    public function getNdem()
    {
        return $this->ndem;
    }

     /**
     * Set user
     *
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     *
     */
    public function getUser()
    {
        return $this->user;
    }
    
}

