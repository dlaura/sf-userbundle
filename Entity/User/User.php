<?php

namespace Onfan\UserBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * Onfan\UserBundle\Entity\User\User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Onfan\UserBundle\Entity\User\UserRepository")
 */
class User
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
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var string $password
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string $facebook_username
     *
     * @ORM\Column(name="facebook_username", type="string", length=255)
     */
    private $facebook_username;

    /**
     * @var integer $facebook_id
     *
     * @ORM\Column(name="facebook_id", type="integer")
     */
    private $facebook_id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string $surname
     *
     * @ORM\Column(name="surname", type="string", length=255)
     */
    private $surname;
    
    /**
     * @ORM\OneToMany(targetEntity="AccessToken", mappedBy="user")
     */
   protected $access_tokens;


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
}