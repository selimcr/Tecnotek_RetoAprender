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
 * @ORM\Table(name="tek_payments")
 * @ORM\Entity()
 * @UniqueEntity("transaccionId")
 */
class Payment{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\MinLength(limit = 3)
     * @Assert\MaxLength(limit = 255)
     */
    private $transactionId;

    /**
     * @ORM\Column(type="integer", nullable = true)
     */
    private $type;

    /**
     * @ORM\Column(name="date", type="datetime", nullable = true)
     */
    private $date;

    /**
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ManyToOne(targetEntity="Level")
     * @JoinColumn(name="level_id", referencedColumnName="id")
     */
    private $level;

    public function __construct()
    {
        $this->content = "";
        $this->date = new \DateTime();
    }

    public function __toString()
    {
        return $this->transactionId;
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
     * Set user
     *
     * @param \Tecnotek\RetoAprenderBundle\Entity\User $user
     */
    public function setUser(\Tecnotek\RetoAprenderBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return \Tecnotek\RetoAprenderBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
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

    /**
     * Set date
     *
     * @param date $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get date
     *
     * @return date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set transactionId
     *
     * @param string $transactionId
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
    }

    /**
     * Get transactionId
     *
     * @return string 
     */
    public function getTransactionId()
    {
        return $this->transactionId;
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
}