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
 * @ORM\Table(name="tek_info")
 * @ORM\Entity()
 */
class Info{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable = true)
     */
    private $leftSide;

    /**
     * @ORM\Column(type="text", nullable = true)
     */
    private $centerSide;

    /**
     * @ORM\Column(type="text", nullable = true)
     */
    private $rightSide;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="info")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="last_user_editor_id", referencedColumnName="id")
     */
    private $lastUserEditor;

    public function __construct()
    {
        $this->content = "";
    }

    public function _toString()
    {
        return $this->title;
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
     * Set lastUserEditor
     *
     * @param \Tecnotek\RetoAprenderBundle\Entity\User $lastUserEditor
     */
    public function setLastUserEditor(\Tecnotek\RetoAprenderBundle\Entity\User $lastUserEditor)
    {
        $this->lastUserEditor = $lastUserEditor;
    }

    /**
     * Get lastUserEditor
     *
     * @return \Tecnotek\RetoAprenderBundle\Entity\User
     */
    public function getLastUserEditor()
    {
        return $this->lastUserEditor;
    }


    /**
     * Set leftSide
     *
     * @param string $leftSide
     */
    public function setleftSide($leftSide)
    {
        $this->leftSide = $leftSide;
    }

    /**
     * Get leftSide
     *
     * @return string
     */
    public function getleftSide()
    {
        return $this->leftSide;
    }


    /**
     * Set centerSide
     *
     * @param string $centerSide
     */
    public function setcenterSide($centerSide)
    {
        $this->centerSide = $centerSide;
    }

    /**
     * Get centerSide
     *
     * @return string
     */
    public function getcenterSide()
    {
        return $this->centerSide;
    }


    /**
     * Set rightSide
     *
     * @param string $rightSide
     */
    public function setrightSide($rightSide)
    {
        $this->rightSide = $rightSide;
    }

    /**
     * Get rightSide
     *
     * @return string
     */
    public function getrightSide()
    {
        return $this->rightSide;
    }
}