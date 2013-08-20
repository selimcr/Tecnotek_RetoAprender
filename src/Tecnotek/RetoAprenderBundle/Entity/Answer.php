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
 * @ORM\Table(name="tek_answers")
 * @ORM\Entity()
 * @UniqueEntity("name")
 */
class Answer
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
    private $answerLabel;

    /**
     * @ORM\Column(type="integer", nullable = true)
     */
    private $type;

    /**
     * @ManyToOne(targetEntity="Question", inversedBy="options", cascade={"all"})
     * @JoinColumn(name="question_id", referencedColumnName="id")
     */
    private $question;

    public function __construct()
    {
        $this->answerLabel = "";
    }

    public function __toString()
    {
        return $this->answerLabel;
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
     * Set answerLabel
     *
     * @param string $answerLabel
     */
    public function setAnswerLabel($answerLabel)
    {
        $this->answerLabel = $answerLabel;
    }

    /**
     * Get answerLabel
     *
     * @return string
     */
    public function getAnswerLabel()
    {
        return $this->answerLabel;
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
     * Set question
     *
     * @param \Tecnotek\RetoAprenderBundle\Entity\Question $question
     */
    public function setQuestion(\Tecnotek\RetoAprenderBundle\Entity\Question $question)
    {
        $this->question = $question;
    }

    /**
     * Get question
     *
     * @return \Tecnotek\RetoAprenderBundle\Entity\Question
     */
    public function getQuestion()
    {
        return $this->question;
    }
}