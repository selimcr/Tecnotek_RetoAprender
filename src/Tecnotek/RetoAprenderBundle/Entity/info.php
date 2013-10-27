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
 * @ORM\Table(name="tek_news")
 * @ORM\Entity()
 * @UniqueEntity("title")
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
    private $left;

    /**
     * @ORM\Column(type="text", nullable = true)
     */
    private $center;

    /**
     * @ORM\Column(type="text", nullable = true)
     */
    private $right;

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
        $this->date = new \DateTime();
        $this->enabled = false;
    }

    public function __toString()
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
     * Set left
     *
     * @param string $left
     */
    public function setLeft($left)
    {
        $this->left = $left;
    }

    /**
     * Get left
     *
     * @return string
     */
    public function getLeft()
    {
        return $this->left;
    }


    /**
     * Set center
     *
     * @param string $center
     */
    public function setCenter($center)
    {
        $this->center = $center;
    }

    /**
     * Get center
     *
     * @return string
     */
    public function getCenter()
    {
        return $this->center;
    }


    /**
     * Set right
     *
     * @param string $right
     */
    public function setRight($right)
    {
        $this->right = $right;
    }

    /**
     * Get right
     *
     * @return string
     */
    public function getRight()
    {
        return $this->right;
    }
}