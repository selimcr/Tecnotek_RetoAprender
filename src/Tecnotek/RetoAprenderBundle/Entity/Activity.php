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
 * @ORM\Table(name="tek_activities")
 * @ORM\Entity()
 * @UniqueEntity("name")
 */
class Activity
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
    private $type;

    /**
     * @ORM\Column(type="integer", nullable = true)
     */
    private $orderA;


    /**
     * @ORM\Column(type="string", length=60, nullable = true)
     */
    private $previewA;

    /**
     * @ORM\Column(type="string", nullable = true)
     * @Assert\MaxLength(limit = 1024)
     */
    private $includeText;

    /**
     * @ManyToOne(targetEntity="Unit", inversedBy="activities", cascade={"all"})
     * @JoinColumn(name="unit_id", referencedColumnName="id")
     */
    private $unit;

    public function __construct()
    {
        $this->includeText = "";
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
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set type
     *
     * @param type $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get orderA
     *
     * @return integer
     */
    public function getOrderA()
    {
        return $this->orderA;
    }

    /**
     * Set orderA
     *
     * @param type $orderA
     */
    public function setOrderA($orderA)
    {
        $this->orderA = $orderA;
    }

    /**
     * Get previewA
     *
     * @return integer
     */
    public function getPreviewA()
    {
        return $this->previewA;
    }

    /**
     * Set previewA
     *
     * @param type $previewA
     */
    public function setPreviewA($previewA)
    {
        $this->previewA = $previewA;
    }


    /**
     * Get includeText
     *
     * @return string
     */
    public function getIncludeText()
    {
        return $this->includeText;
    }

    /**
     * Set includeText
     *
     * @param string $includeText
     */
    public function setIncludeText($includeText)
    {
        $this->includeText = $includeText;
    }

    /**
     * Set unit
     *
     * @param \Tecnotek\RetoAprenderBundle\Entity\Unit $unit
     */
    public function setUnit(\Tecnotek\RetoAprenderBundle\Entity\Unit $unit)
    {
        $this->unit = $unit;
    }

    /**
     * Get unit
     *
     * @return \Tecnotek\RetoAprenderBundle\Entity\Unit
     */
    public function getUnit()
    {
        return $this->unit;
    }
}