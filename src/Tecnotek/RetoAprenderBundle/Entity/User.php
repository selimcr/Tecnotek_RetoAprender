<?php
namespace Tecnotek\RetoAprenderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 *
 * @ORM\Table(name="tek_users")
 * @ORM\Entity(repositoryClass="Tecnotek\RetoAprenderBundle\Repository\UserRepository")
 * @UniqueEntity("username")
 * @UniqueEntity("email")
 * @ORM\HasLifecycleCallbacks
 */
class User implements AdvancedUserInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank()
     * @Assert\MinLength(limit = 4)
     * @Assert\MaxLength(limit = 25)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     * @Assert\MinLength(limit = 3)
     * @Assert\MaxLength(limit = 150)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     * @Assert\MinLength(limit = 3)
     * @Assert\MaxLength(limit = 150)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=32)
     * @Assert\MaxLength(limit = 32)
     */
    private $salt;

    /**
     * @ORM\Column(type="string", length=40)
     * @Assert\NotBlank()
     * @Assert\MinLength(limit = 3)
     * @Assert\MaxLength(limit = 40)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     * @Assert\NotBlank()
     * @Assert\MinLength(limit = 3)
     * @Assert\MaxLength(limit = 60)
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     */
    private $email;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(name="last_login", type="datetime", nullable = true)
     */
    private $lastLogin;

    /**
     * @ORM\Column(name="last_password_update", type="datetime", nullable = true)
     */
    private $lastPasswordUpdate;

    /**
     * @ORM\Column(name="premium_access_expiration", type="datetime", nullable = true)
     */
    private $premiumAccessExpiration;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users")
     *
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity="Payment", mappedBy="user")
     * @ORM\OrderBy({"date" = "ASC"})
     */
    private $payments;

    public function __construct()
    {
        $this->isActive = true;
        //$this->salt = md5(uniqid(null, true));
        $this->salt = "";
        $this->roles = new ArrayCollection();
    }
    
    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @inheritDoc
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * @inheritDoc
     */
    public function setEmail($email)
    {
        return $this->email = $email;
    }
    
    /**
     * @inheritDoc
     */
    public function isActive()
    {
        return $this->isActive;
    }
    
    /**
     * @inheritDoc
     */
    public function setActive($value)
    {
        return $this->isActive = $value;
    }
    
    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
    }
    
    /**
     * @inheritDoc
     */
    public function setUsername($username)
    {
        return $this->username = $username;
    }

    /**
     * @inheritDoc
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @inheritDoc
     */
    public function setFirstname($firstname)
    {
        return $this->firstname = $firstname;
    }
    /**
     * @inheritDoc
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @inheritDoc
     */
    public function setLastname($lastname)
    {
        return $this->lastname = $lastname;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * @inheritDoc
     */
    public function setPassword($value)
    {
        return $this->password = $value;
    }
    
    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return $this->roles->toArray();
    }
    
    /**
     * @inheritDoc
     */
    public function getUserRoles()
    {
        return $this->roles;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @inheritDoc
     */
    public function equals(UserInterface $user)
    {
        return $this->username === $user->getUsername();
    }
    
    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }

    public function __toString()
    {
        return $this->username;
    }

    /** @ORM\PrePersist  */
    public function doStuffOnPrePersist()
    {
        $this->password = sha1($this->password);
    }

    public function getEncryptedPassword($password){
        return sha1($password);
    }

    /**
     * Set lastLogin
     *
     * @param date $lastLogin
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
    }

    /**
     * Get lastLogin
     *
     * @return date
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * Set lastPasswordUpdate
     *
     * @param date $lastPasswordUpdate
     */
    public function setLastPasswordUpdate($lastPasswordUpdate)
    {
        $this->lastPasswordUpdate = $lastPasswordUpdate;
    }

    /**
     * Get lastPasswordUpdate
     *
     * @return date
     */
    public function getLastPasswordUpdate()
    {
        return $this->lastPasswordUpdate;
    }

    /**
     * Set premiumAccessExpiration
     *
     * @param date $premiumAccessExpiration
     */
    public function setPremiumAccessExpiration($premiumAccessExpiration)
    {
        $this->premiumAccessExpiration = $premiumAccessExpiration;
    }

    /**
     * Get premiumAccessExpiration
     *
     * @return date
     */
    public function getPremiumAccessExpiration()
    {
        return $this->premiumAccessExpiration;
    }

    /**
     * @inheritDoc
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @inheritDoc
     */
    public function setAvatar($avatar)
    {
        return $this->avatar = $avatar;
    }

    public function getAvatarWebPath()
    {
        return null === $this->avatar
            ? "/images/user.png"
            : $this->getUploadDir().'/'.$this->avatar;
    }

    public function getUploadDir()
    {
        return '/uploads/avatars';
    }

    /**
     * @inheritDoc
     */
    public function getPayments()
    {
        return $this->payments;
    }
}
?>
