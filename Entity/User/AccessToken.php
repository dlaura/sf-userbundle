<?php

namespace Onfan\UserBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Onfan\UserBundle\Util\CodeGenerator;

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
     * @var \DateTime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;

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
     * Set created_at
     *
     * @param \DateTime $created_at
     * @return AccessToken
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    
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
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setEnabled(true);
        $this->setCreatedAt(new \DateTime);
        $this->setAccessToken(CodeGenerator::generateSessionAccessToken());
    }
}