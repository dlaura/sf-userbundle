<?php

namespace Onfan\UserBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;

use Symfony\Component\Validator\Constraints as Assert;
//use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


use JMS\SerializerBundle\Annotation\ExclusionPolicy;
use JMS\SerializerBundle\Annotation\Expose;

use Onfan\UserBundle\Util\CodeGenerator;


/**
 * Onfan\UserBundle\Entity\User\User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Onfan\UserBundle\Entity\User\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields="username", message="Username is already used")
 * @ExclusionPolicy("all")
 */
class User implements AdvancedUserInterface
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     */
    private $id;

    /**
     * @var string $username
     *
     * @ORM\Column(name="username", type="string", unique=true, length=255, nullable=false)
     * @Assert\NotBlank()
     * @Expose
     */
    private $username;
    
    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     * @Assert\Email(message="Invalid email address.")
     * @Expose
     */
    private $email;

    /**
     * @var string $password
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     */
    private $password;
    
    /**
     * @var string $salt
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=true)
     */
    private $salt;

    /**
     * @var string $facebooUsername
     *
     * @ORM\Column(name="facebook_username", type="string", length=255, nullable=true)
     * @Expose
     */
    private $facebookUsername;

    /**
     * @var integer $facebookId
     *
     * @ORM\Column(name="facebook_id", type="integer", nullable=true)
     * @Expose
     */
    private $facebookId;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     * @Expose
     */
    private $name;

    /**
     * @var string $surname
     *
     * @ORM\Column(name="surname", type="string", length=255, nullable=true)
     * @Expose
     */
    private $surname;
    
    /**
     * @var string $isActive
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=false)
     * @Expose
     */
    private $isActive;
    
    /**
     * @var string $isVerified
     *
     * @ORM\Column(name="is_verified", type="boolean", nullable=false)
     * @Expose
     */
    private $isVerified;
    
    /**
     * @var string $verificationCode
     *
     * @ORM\Column(name="verification_code", type="string", length=255, nullable=true)
     */
    private $verificationCode;
    
    /**
     * @var string $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     * @Expose
     */
    private $createdAt;
    
    /**
     * @var string $updatedAt
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @Expose
     */
    private $updatedAt;
    
    /**
     * @var string $lastLogin
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     * @Expose
     */
    private $lastLogin;
    
    /**
     * @ORM\OneToMany(targetEntity="AccessToken", mappedBy="user")
     */
    protected $accessTokens;

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
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
    
        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set facebookUsername
     *
     * @param string $facebookUsername
     * @return User
     */
    public function setFacebookUsername($facebookUsername)
    {
        $this->facebookUsername = $facebookUsername;
    
        return $this;
    }

    /**
     * Get facebookUsername
     *
     * @return string 
     */
    public function getFacebookUsername()
    {
        return $this->facebookUsername;
    }

    /**
     * Set facebookId
     *
     * @param integer $facebookId
     * @return User
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;
    
        return $this;
    }

    /**
     * Get facebookId
     *
     * @return integer 
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
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
     * Set surname
     *
     * @param string $surname
     * @return User
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    
        return $this;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname()
    {
        return $this->surname;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setIsActive(true);
        $this->setSalt(CodeGenerator::generateSalt());
        $this->accessTokens = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add accessTokens
     *
     * @param Onfan\UserBundle\Entity\User\AccessToken $accessTokens
     * @return User
     */
    public function addAccessToken(\Onfan\UserBundle\Entity\User\AccessToken $accessTokens)
    {
        $this->accessTokens[] = $accessTokens;
    
        return $this;
    }

    /**
     * Remove accessTokens
     *
     * @param Onfan\UserBundle\Entity\User\AccessToken $accessTokens
     */
    public function removeAccessToken(\Onfan\UserBundle\Entity\User\AccessToken $accessTokens)
    {
        $this->accessTokens->removeElement($accessTokens);
    }

    /**
     * Get accessTokens
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAccessTokens()
    {
        return $this->accessTokens;
    }
    

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    
        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set isVerified
     *
     * @param boolean $isVerified
     * @return User
     */
    public function setIsVerified($isVerified)
    {
        $this->isVerified = $isVerified;
    
        return $this;
    }

    /**
     * Get isVerified
     *
     * @return boolean 
     */
    public function getIsVerified()
    {
        return $this->isVerified;
    }

    /**
     * Set verificationCode
     *
     * @param string $verificationCode
     * @return User
     */
    public function setVerificationCode($verificationCode)
    {
        $this->verificationCode = $verificationCode;
    
        return $this;
    }

    /**
     * Get verificationCode
     *
     * @return string 
     */
    public function getVerificationCode()
    {
        return $this->verificationCode;
    }

    /**
     * Set createdAt
     *
     * @ORM\PrePersist
     */
    public function setCreatedAt()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @ORM\PreUpdate
     */
    public function setUpdatedAt()
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set lastLogin
     *
     * @param \DateTime $lastLogin
     * @return User
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
    
        return $this;
    }

    /**
     * Get lastLogin
     *
     * @return \DateTime 
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    
        return $this;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        //return $this->salt;
        return null;
    }
    
    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array('ROLE_USER', 'ROLE_API_USER');
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
    public function isAccountNonExpired()
    {
        return true;
    }
    
    /**
     * @inheritDoc
     */
    public function isAccountNonLocked()
    {
        return $this->isVerified;
    }
    
    /**
     * @inheritDoc
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }
    
    /**
     * @inheritDoc
     */
    public function isEnabled()
    {
        return $this->isActive;
    }

    /**
     * @inheritDoc
     */    
    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof User) {
            return false;
        }
        
        if ($this->username !== $user->getUsername()) {
            return false;
        }
        
        return true;
    }
    
}