<?php

namespace Onfan\UserBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * Onfan\UserBundle\Entity\User\AccessToken
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Onfan\UserBundle\Entity\User\AccessTokenRepository")
 */
class AccessToken
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
     * @var string $access_token
     *
     * @ORM\Column(name="access_token", type="string", length=255)
     */
    private $access_token;

    /**
     * @var \DateTime $expiration_time
     *
     * @ORM\Column(name="expiration_time", type="datetime")
     */
    private $expiration_time;

    /**
     * @var boolean $enabled
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="access_tokens")
     */
    protected $user;


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
     * Set access_token
     *
     * @param string $accessToken
     * @return AccessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->access_token = $accessToken;
    
        return $this;
    }

    /**
     * Get access_token
     *
     * @return string 
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * Set expiration_time
     *
     * @param \DateTime $expirationTime
     * @return AccessToken
     */
    public function setExpirationTime($expirationTime)
    {
        $this->expiration_time = $expirationTime;
    
        return $this;
    }

    /**
     * Get expiration_time
     *
     * @return \DateTime 
     */
    public function getExpirationTime()
    {
        return $this->expiration_time;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return AccessToken
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    
        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set user
     *
     * @param Onfan\UserBundle\Entity\User\User $user
     * @return AccessToken
     */
    public function setUser(\Onfan\UserBundle\Entity\User\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return Onfan\UserBundle\Entity\User\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}