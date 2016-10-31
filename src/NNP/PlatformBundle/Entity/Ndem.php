<?php

namespace NNP\PlatformBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Ndem
 *
 * @ORM\Table(name="ndem")
 * @ORM\Entity(repositoryClass="NNP\PlatformBundle\Repository\NdemRepository")
 */
class Ndem
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
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="texte", type="text")
     */
    private $texte;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetimetz")
     */
    private $dateCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateModification", type="datetimetz", nullable=true)
     */
    private $dateModification;

    /**
     * @var string
     *
     * @ORM\Column(name="statut", type="string", length=255, nullable=true)
     */
    private $statut;

    /**
     * @var string
     *
     * @ORM\Column(name="firstphoto", type="string", length=255, nullable=true)
     * @Assert\File(
     *      maxSize = "5M",
     *      mimeTypes = {"image/jpeg", "image/gif", "image/png", "image/tiff"},
     *      maxSizeMessage = "The maximum allowed file size is 5MB.",
     *      mimeTypesMessage = "Only the file types image are allowed.")
     */
    private $firstphoto;

    /**
     * @var string
     *
     * @ORM\Column(name="secondphoto", type="string", length=255, nullable=true)
     * @Assert\File(
     *      maxSize = "5M",
     *      mimeTypes = {"image/jpeg", "image/gif", "image/png", "image/tiff"},
     *      maxSizeMessage = "The maximum allowed file size is 5MB.",
     *      mimeTypesMessage = "Only the file types image are allowed.")
     */
    private $secondphoto;

    /**
     *@ORM\ManyToOne(targetEntity = "NNP\PlatformBundle\Entity\User")
     *@ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     *@ORM\ManyToOne(targetEntity = "NNP\PlatformBundle\Entity\Categorie")
     *@ORM\JoinColumn(nullable=true)
     */
    private $categorie;


    public function __construct(){
        $this->dateCreation = new \DateTime();
        $this->dateModification = new \DateTime();
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
     * Set titre
     *
     * @param string $titre
     *
     * @return Ndem
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set texte
     *
     * @param string $texte
     *
     * @return Ndem
     */
    public function setTexte($texte)
    {
        $this->texte = $texte;

        return $this;
    }

    /**
     * Get texte
     *
     * @return string
     */
    public function getTexte()
    {
        return $this->texte;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Ndem
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
     * Set dateModification
     *
     * @param \DateTime $dateModification
     *
     * @return Ndem
     */
    public function setDateModification(\DateTime $dateModification)
    {
        $this->dateModification = $dateModification;

        return $this;
    }

    /**
     * Get dateModification
     *
     * @return \DateTime
     */
    public function getDateModification()
    {
        return $this->dateModification;
    }

    /**
     * Set statut
     *
     * @param string $statut
     *
     * @return Ndem
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
     * Set firstphoto
     *
     * @param string $firstphoto
     *
     * @return User
     */
    public function setFirstphoto($photo)
    {
        $this->firstphoto = $photo;

        return $this;
    }

    /**
     * Get firstphoto
     *
     * @return string
     */
    public function getFirstphoto()
    {
        return $this->firstphoto;
    }

     /**
     * Set secondphoto
     *
     * @param string $secondphoto
     *
     * @return User
     */
    public function setSecondphoto($photo)
    {
        $this->secondphoto = $photo;

        return $this;
    }

    /**
     * Get photo2
     *
     * @return string
     */
    public function getSecondphoto()
    {
        return $this->secondphoto;
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


     /**
     * Set categorie
     *
     */
    public function setCategorie(Categorie $categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     *
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    public function __toString() {
        return $this->titre;
    }


}

