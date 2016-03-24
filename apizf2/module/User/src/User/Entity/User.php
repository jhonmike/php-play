<?php

namespace User\Entity;

use Base\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;
use Zend\Hydrator;
use Zend\Math\Rand;
use Zend\Crypt\Key\Derivation\Pbkdf2;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="User\Entity\UserRepository")
 */
class User extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=45, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="password_clue", type="string", length=45, nullable=true)
     */
    private $passwordClue;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=false)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="activation_key", type="string", length=255, nullable=false)
     */
    private $activationKey;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=false)
     */
    private $status = false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=false)
     */
    private $lastLogin;

    /**
     * Constructor
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $this->salt = base64_encode(Rand::getBytes(8, true));

        $hydrator = new Hydrator\ClassMethods();
        $hydrator->hydrate($options, $this);

        $this->activationKey = md5($this->email.$this->salt);

        $this->created = new \DateTime("now");
        $this->lastLogin = new \DateTime("now");
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
        $this->password = $this->encryptPassword($password);

        return $this;
    }

    public function encryptPassword($password)
    {
        return base64_encode(Pbkdf2::calc('sha256', $password, $this->salt, 10000, strlen($password*2)));
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
     * Set passwordClue
     *
     * @param string $passwordClue
     * @return User
     */
    public function setPasswordClue($passwordClue)
    {
        $this->passwordClue = $passwordClue;

        return $this;
    }

    /**
     * Get passwordClue
     *
     * @return string
     */
    public function getPasswordClue()
    {
        return $this->passwordClue;
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
        return $this->salt;
    }

    /**
     * Set activationKey
     *
     * @param string $activationKey
     * @return User
     */
    public function setActivationKey($activationKey)
    {
        $this->activationKey = $activationKey;

        return $this;
    }

    /**
     * Get active
     *
     * @return string
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return User
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get activationKey
     *
     * @return string
     */
    public function getActivationKey()
    {
        return $this->activationKey;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return User
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set created
     * @return User
     * @internal param \DateTime $created
     */
    public function setCreated()
    {
        $this->created = new \DateTime("now");

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set lastLogin
     *
     * @ORM\PrePersist
     * @return User
     * @internal param \DateTime $lastLogin
     */
    public function setLastLogin()
    {
        $this->lastLogin = new \DateTime("now");

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
     * @return array
     */
    public function toArray()
    {
        $hydrator = new Hydrator\ClassMethods();
        $array = $hydrator->extract($this);
        unset($array['password']);

        return $array;
    }
}
