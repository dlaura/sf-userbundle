<?php

namespace Onfan\UserBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

use Onfan\UserBundle\Util\CodeGenerator;


/**
 * Onfan\UserBundle\Entity\User\User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Onfan\UserBundle\Entity\User\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 * @DoctrineAssert\UniqueEntity(fields="username", message="Username is already used")
 */
class User implements AdvancedUserInterface
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $username
     *
     * @ORM\Column(name="username", type="string", unique=true, length=255, nullable=false)
     */
    private $username;
    
    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     * @Assert\Email(message="Invalid email address.")
     * 
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
     * @var string $facebook_username
     *
     * @ORM\Column(name="facebook_username", type="string", length=255, nullable=true)
     */
    private $facebook_username;

    /**
     * @var integer $facebook_id
     *
     * @ORM\Column(name="facebook_id", type="integer", nullable=true)
     */
    private $facebook_id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string $surname
     *
     * @ORM\Column(name="surname", type="string", length=255, nullable=true)
     */
    private $surname;
    
    /**
     * @var string $isActive
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=false)
     */
    private $isActive;
    
    /**
     * @var string $isVerified
     *
     * @ORM\Column(name="is_verified", type="boolean", nullable=false)
     */
    private $isVerified;
    
    /**
     * @var string $verification_code
     *
     * @ORM\Column(name="verification_code", type="string", length=255, nullable=true)
     */
    private $verification_code;
    
    /**
     * @var string $created_at
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $created_at;
    
    /**
     * @var string $updated_at
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updated_at;
    
    /**
     * @var string $last_login
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    private $last_login;
    
    /**
     * @ORM\OneToMany(targetEntity="AccessToken", mappedBy="user")
     */
    protected $access_tokens;
    
    
    private $enabled;
    private $verified;


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
     * Set facebook_username
     *
     * @param string $facebookUsername
     * @return User
     */
    public function setFacebookUsername($facebookUsername)
    {
        $this->facebook_username = $facebookUsername;
    
        return $this;
    }

    /**
     * Get facebook_username
     *
     * @return string 
     */
    public function getFacebookUsername()
    {
        return $this->facebook_username;
    }

    /**
     * Set facebook_id
     *
     * @param integer $facebookId
     * @return User
     */
    public function setFacebookId($facebookId)
    {
        $this->facebook_id = $facebookId;
    
        return $this;
    }

    /**
     * Get facebook_id
     *
     * @return integer 
     */
    public function getFacebookId()
    {
        return $this->facebook_id;
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
        $this->access_tokens = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add access_tokens
     *
     * @param Onfan\UserBundle\Entity\User\AccessToken $accessTokens
     * @return User
     */
    public function addAccessToken(\Onfan\UserBundle\Entity\User\AccessToken $accessTokens)
    {
        $this->access_tokens[] = $accessTokens;
    
        return $this;
    }

    /**
     * Remove access_tokens
     *
     * @param Onfan\UserBundle\Entity\User\AccessToken $accessTokens
     */
    public function removeAccessToken(\Onfan\UserBundle\Entity\User\AccessToken $accessTokens)
    {
        $this->access_tokens->removeElement($accessTokens);
    }

    /**
     * Get access_tokens
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAccessTokens()
    {
        return $this->access_tokens;
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
     * Set verification_code
     *
     * @param string $verificationCode
     * @return User
     */
    public function setVerificationCode($verificationCode)
    {
        $this->verification_code = $verificationCode;
    
        return $this;
    }

    /**
     * Get verification_code
     *
     * @return string 
     */
    public function getVerificationCode()
    {
        return $this->verification_code;
    }

    /**
     * Set created_at
     *
     * @ORM\PrePersist
     * @param \DateTime $createdAt
     * @return User
     */
    public function setCreatedAt()
    {
        $this->created_at = new \DateTime();
    
        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @ORM\PreUpdate
     * @param \DateTime $updatedAt
     * @return User
     */
    public function setUpdatedAt()
    {
        $this->updated_at = new \DateTime();
    
        return $this;
    }

    /**
     * Get updated_at
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set last_login
     *
     * @param \DateTime $lastLogin
     * @return User
     */
    public function setLastLogin($lastLogin)
    {
        $this->last_login = $lastLogin;
    
        return $this;
    }

    /**
     * Get last_login
     *
     * @return \DateTime 
     */
    public function getLastLogin()
    {
        return $this->last_login;
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

    
    /*
    public function isEqualTo(UserInterface $user)
    {
        return $this->username === $user->getUsername();
    }
    */
}