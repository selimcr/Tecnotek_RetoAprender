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
class News{

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
    private $title;

    /**
     * @ORM\Column(type="text", nullable = true)
     */
    private $content;

    /**
     * @ORM\Column(name="date", type="datetime", nullable = true)
     */
    private $date;

    /**
     * @ORM\Column(name="enabled", type="boolean", nullable = true)
     */
    private $enabled;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="news")
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
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set enabled
     *
     * @param string $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * Get enabled
     *
     * @return string
     */
    public function isEnabled()
    {
        return $this->enabled;
    }
}