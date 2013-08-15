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
 * @ORM\Table(name="tek_tests")
 * @ORM\Entity()
 * @UniqueEntity("name")
 */
class Test
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
     * @Assert\MaxLength(limit = 600)
     */
    private $testDescription;

    /**
     * @ORM\Column(type="integer", nullable = true)
     */
    private $type;

    /**
     * @ORM\Column(type="string", nullable = true)
     * @Assert\MaxLength(limit = 100)
     */
    private $urlImage;

    /**
     * @ManyToOne(targetEntity="Unit", inversedBy="questions", cascade={"all"})
     * @JoinColumn(name="unit_id", referencedColumnName="id")
     */
    private $unit;

    public function __construct()
    {
        $this->testDescription = "";
    }

    public function __toString()
    {
        return $this->testDescription;
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
     * Set testDescription
     *
     * @param string $testDescription
     */
    public function setTestDescription($testDescription)
    {
        $this->testDescription = $testDescription;
    }

    /**
     * Get testDescription
     *
     * @return string
     */
    public function getTestDescription()
    {
        return $this->testDescription;
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
     * Get urlImage
     *
     * @return string
     */
    public function getUrlImage()
    {
        return $this->urlImage;
    }

    /**
     * Set urlImage
     *
     * @param string $urlImage
     */
    public function setUrlImage($urlImage)
    {
        $this->urlImage = $urlImage;
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