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
 * @ORM\Table(name="tek_questions")
 * @ORM\Entity()
 * @UniqueEntity("name")
 */
class Question
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
    private $questionLabel;

    /**
     * @ORM\Column(type="string", length=255, nullable = true)
     */
    private $explanation;

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
     * @ManyToOne(targetEntity="Test", inversedBy="questions", cascade={"all"})
     * @JoinColumn(name="test_id", referencedColumnName="id")
     */
    private $test;

    /**
     * @var Answer
     *
     * @ORM\OneToMany(targetEntity="Answer", mappedBy="question", cascade={"all"})
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private $options;

    public function __construct()
    {
        $this->questionLabel = "";
    }

    public function __toString()
    {
        return $this->questionLabel;
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
     * Set questionLabel
     *
     * @param string $questionLabel
     */
    public function setQuestionLabel($questionLabel)
    {
        $this->questionLabel = $questionLabel;
    }

    /**
     * Get questionLabel
     *
     * @return string
     */
    public function getQuestionLabel()
    {
        return $this->questionLabel;
    }

    /**
     * Set explanation
     *
     * @param string $explanation
     */
    public function setExplanation($explanation)
    {
        $this->explanation = $explanation;
    }

    /**
     * Get explanation
     *
     * @return string
     */
    public function getExplanation()
    {
        return $this->explanation;
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
     * Set test
     *
     * @param \Tecnotek\RetoAprenderBundle\Entity\Test $test
     */
    public function setTest(\Tecnotek\RetoAprenderBundle\Entity\Test $test)
    {
        $this->test = $test;
    }

    /**
     * Get test
     *
     * @return \Tecnotek\RetoAprenderBundle\Entity\Test
     */
    public function getTest()
    {
        return $this->test;
    }

    public function getOptions(){
        return $this->options;
    }
}