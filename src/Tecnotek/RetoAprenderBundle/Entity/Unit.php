<?php
namespace Tecnotek\RetoAprenderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne as ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn as JoinColumn;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 *
 * @ORM\Table(name="tek_units")
 * @ORM\Entity()
 * @UniqueEntity("name")
 */
class Unit
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     * @Assert\NotBlank()
     * @Assert\MinLength(limit = 3)
     * @Assert\MaxLength(limit = 60)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=120, nullable = true)
     * @Assert\MaxLength(limit = 120)
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable = true)
     */
    private $number;

    /**
     * @ManyToOne(targetEntity="Level", inversedBy="levels")
     * @JoinColumn(name="level_id", referencedColumnName="id")
     */
    private $level;

    /**
     * @var Activity
     *
     * @ORM\OneToMany(targetEntity="Activity", mappedBy="unit", cascade={"all"})
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $activities;

    public function __construct()
    {
    }

    public function __toString()
    {
        return $this->name;
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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set number
     *
     * @param number $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * Set level
     *
     * @param \Tecnotek\RetoAprenderBundle\Entity\Level $level
     */
    public function setLevel(\Tecnotek\RetoAprenderBundle\Entity\Level $level)
    {
        $this->level = $level;
    }

    /**
     * Get level
     *
     * @return \Tecnotek\RetoAprenderBundle\Entity\Level
     */
    public function getLevel()
    {
        return $this->level;
    }

    public function getActivities(){
        return $this->activities;
    }
}