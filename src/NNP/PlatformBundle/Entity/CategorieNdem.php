<?php

namespace NNP\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategorieNdem
 *
 * @ORM\Table(name="categorie_ndem")
 * @ORM\Entity(repositoryClass="NNP\PlatformBundle\Repository\CategorieNdemRepository")
 */
class CategorieNdem
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

