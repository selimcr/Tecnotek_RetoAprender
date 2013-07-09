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
 * @ORM\Table(name="tek_levels")
 * @ORM\Entity()
 * @ORM\Entity(repositoryClass="Tecnotek\RetoAprenderBundle\Repository\LevelRepository")
 */
class Level
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
     * @ManyToOne(targetEntity="Topic", inversedBy="topics")
     * @JoinColumn(name="topic_id", referencedColumnName="id")
     */
    private $topic;

    /**
     * @var Unit
     *
     * @ORM\OneToMany(targetEntity="Unit", mappedBy="level", cascade={"all"})
     * @ORM\OrderBy({"number" = "ASC"})
     */
    private $units;

    public function __construct()
    {
    }

    public function __toString()
    {
        return $this->topic . " :: " . $this->name;
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
     * Set topic
     *
     * @param \Tecnotek\RetoAprenderBundle\Entity\Topic $topic
     */
    public function setTopic(\Tecnotek\RetoAprenderBundle\Entity\Topic $topic)
    {
        $this->topic = $topic;
    }

    /**
     * Get topic
     *
     * @return \Tecnotek\RetoAprenderBundle\Entity\Topic
     */
    public function getTopic()
    {
        return $this->topic;
    }

    public function getUnits(){
        return $this->units;
    }
}