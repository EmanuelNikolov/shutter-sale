<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{

    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Type("alpha", message="Your username can contain only letters (case-insensitive)")
     * @Assert\Length(
     *      min = 4,
     *      max = 20,
     *      minMessage = "Your username must be at least {{ limit }} characters long",
     *      maxMessage = "Your username cannot be longer than {{ limit }} characters"
     * )
     * @ORM\Column(name="username", type="string", length=20, unique=true)
     */
    private $username;

    /**
     * @var string
     * @Assert\Email(message = "The email '{{ value }}' is not a valid email.")
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * The plain password from user input on registration.
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 3,
     *      minMessage = "Your password must be at least {{ limit }} characters long",
     * )
     * @Assert\Regex(
     *     pattern="/[a-z0-9]+/",
     *     message="Your password can only contain lowercase letter and digits"
     * )
     */
    private $plainPassword;

    /**
     * @var string
     * @Assert\Regex(
     *     pattern="/^\+\d{10,12}$/",
     *     message="Your phone number must start with a + followed by 10 to 12 digits"
     * )
     * @ORM\Column(name="phone", type="string", length=13, unique=true)
     */
    private $phone;

    /**
     * @var bool
     * @ORM\Column(name="is_restricted", type="boolean")
     */
    private $isRestricted;

    /**
     * One User has many Cameras.
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Camera", mappedBy="user")
     */
    private $cameras;

    /**
     * @ORM\Column(type="json_array")
     */
    private $roles;

    public function __construct()
    {
        $this->cameras = new ArrayCollection();
        $this->setIsRestricted(false);
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     *
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
     * Set email
     *
     * @param string $email
     *
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
     * Set password
     *
     * @param string $password
     *
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
     * Set phone
     *
     * @param string $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     *
     * @return User
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCameras()
    {
        return $this->cameras;
    }

    /**
     * @param mixed $cameras
     *
     * @return User
     */
    public function setCameras($cameras)
    {
        $this->cameras = $cameras;
        return $this;
    }

    public function serialize()
    {
        return serialize([
          $this->getId(),
          $this->getUsername(),
          $this->getPassword(),
        ]);
    }

    public function unserialize($serialized)
    {
        list(
          $this->id,
          $this->username,
          $this->password,
          ) = unserialize($serialized);
    }

    public function getRoles()
    {
        $roles = $this->roles;
        // give everyone ROLE_USER!
        if (!in_array('ROLE_USER', $roles)) {
            $roles[] = 'ROLE_USER';
        }
        return $roles;
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    /**
     * Get cameras in stock.
     */
    public function getAllInStock()
    {
        return $this->cameras->filter(function (Camera $camera) {
            return $camera->getQuantity() > 0;
        });
    }

    /**
     * Get cameras out of stock
     */
    public function getAllOutOfStock()
    {
        return $this->cameras->filter(function (Camera $camera) {
            return $camera->getQuantity() < 1;
        });
    }

    /**
     * @return bool
     */
    public function isRestricted(): bool
    {
        return $this->isRestricted;
    }

    /**
     * @param bool $isRestricted
     *
     * @return User
     */
    public function setIsRestricted(bool $isRestricted): User
    {
        $this->isRestricted = $isRestricted;
        return $this;
    }
}