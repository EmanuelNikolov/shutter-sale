<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Camera
 *
 * @ORM\Table(name="cameras")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CameraRepository")
 */
class Camera
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
     * @Assert\Choice(callback="getMakes")
     * @ORM\Column(name="make", type="string", length=5)
     */
    private $make;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/[A-Z\d-]+/",
     *     message="Model can contain only uppercase letters, digits and dashes
     *   (-)"
     * )
     * @ORM\Column(name="model", type="string", length=255)
     */
    private $model;

    /**
     * @var float
     * @Assert\Type("float")
     * @Assert\GreaterThan(0)
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var int
     * @Assert\Range(
     *      min = 0,
     *      max = 100,
     *      minMessage = "Quantity must be at least {{ limit }}",
     *      maxMessage = "Quantity must be at most {{ limit }}"
     * )
     * @ORM\Column(name="quantity", type="smallint")
     */
    private $quantity;

    /**
     * @var int
     * @Assert\Range(
     *      min = 0,
     *      max = 30,
     *      minMessage = "Minimum Shutter Speed must be at least {{ limit }}",
     *      maxMessage = "Minimum Shutter Speed must be at most {{ limit }}"
     * )
     * @ORM\Column(name="min_shutter_speed", type="smallint")
     */
    private $minShutterSpeed;

    /**
     * @var int
     * @Assert\Range(
     *      min = 2000,
     *      max = 8000,
     *      minMessage = "Maximum Shutter Speed must be at least {{ limit }}",
     *      maxMessage = "Maximum Shutter Speed must be at most {{ limit }}"
     * )
     * @ORM\Column(name="max_shutter_speed", type="smallint")
     */
    private $maxShutterSpeed;

    /**
     * @var int
     * @Assert\Choice(callback="getMinIsos")
     * @ORM\Column(name="min_iso", type="smallint")
     */
    private $minIso;

    /**
     * @var int
     * @Assert\Range(
     *      min = 200,
     *      max = 409600,
     *      minMessage = "Max ISO must be at least {{ limit }}",
     *      maxMessage = "Max ISO must be at most {{ limit }}"
     * )
     * @ORM\Column(name="max_iso", type="integer")
     */
    private $maxIso;

    /**
     * @var bool
     * @Assert\Type("bool")
     * @ORM\Column(name="is_full_frame", type="boolean")
     */
    private $isFullFrame;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = 20,
     *      maxMessage = "Video Resolution cannot be longer than {{ limit }} characters"
     * )
     * @ORM\Column(name="video_resolution", type="string", length=15)
     */
    private $videoResolution;

    /**
     * @var array
     * @Assert\NotBlank()
     * @Assert\Choice(callback="getLightMeterings", multiple=true)
     * @ORM\Column(name="light_metering", type="simple_array")
     */
    private $lightMetering;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(
     *      max = 6000,
     *      maxMessage = "Description cannot be longer than {{ limit }} characters"
     * )
     * @ORM\Column(name="description", type="string", length=6000)
     */
    private $description;

    /**
     * @var string
     * @Assert\Url(checkDNS = "ANY")
     * @ORM\Column(name="image_url", type="string", length=255)
     */
    private $imageUrl;

    /**
     * Many cameras have one user.
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="cameras")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

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
     * Set make
     *
     * @param string $make
     *
     * @return Camera
     */
    public function setMake($make)
    {
        $this->make = $make;

        return $this;
    }

    /**
     * Get make
     *
     * @return string
     */
    public function getMake()
    {
        return $this->make;
    }

    /**
     * Set model
     *
     * @param string $model
     *
     * @return Camera
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Camera
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Camera
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set minShutterSpeed
     *
     * @param integer $minShutterSpeed
     *
     * @return Camera
     */
    public function setMinShutterSpeed($minShutterSpeed)
    {
        $this->minShutterSpeed = $minShutterSpeed;

        return $this;
    }

    /**
     * Get minShutterSpeed
     *
     * @return int
     */
    public function getMinShutterSpeed()
    {
        return $this->minShutterSpeed;
    }

    /**
     * Set maxShutterSpeed
     *
     * @param integer $maxShutterSpeed
     *
     * @return Camera
     */
    public function setMaxShutterSpeed($maxShutterSpeed)
    {
        $this->maxShutterSpeed = $maxShutterSpeed;

        return $this;
    }

    /**
     * Get maxShutterSpeed
     *
     * @return int
     */
    public function getMaxShutterSpeed()
    {
        return $this->maxShutterSpeed;
    }

    /**
     * Set minIso
     *
     * @param integer $minIso
     *
     * @return Camera
     */
    public function setMinIso($minIso)
    {
        $this->minIso = $minIso;

        return $this;
    }

    /**
     * Get minIso
     *
     * @return int
     */
    public function getMinIso()
    {
        return $this->minIso;
    }

    /**
     * Set maxIso
     *
     * @param integer $maxIso
     *
     * @return Camera
     */
    public function setMaxIso($maxIso)
    {
        $this->maxIso = $maxIso;

        return $this;
    }

    /**
     * Get maxIso
     *
     * @return int
     */
    public function getMaxIso()
    {
        return $this->maxIso;
    }

    /**
     * Set isFullFrame
     *
     * @param boolean $isFullFrame
     *
     * @return Camera
     */
    public function setIsFullFrame($isFullFrame)
    {
        $this->isFullFrame = $isFullFrame;

        return $this;
    }

    /**
     * Get isFullFrame
     *
     * @return bool
     */
    public function getIsFullFrame()
    {
        return $this->isFullFrame;
    }

    /**
     * Set videoResolution
     *
     * @param string $videoResolution
     *
     * @return Camera
     */
    public function setVideoResolution($videoResolution)
    {
        $this->videoResolution = $videoResolution;

        return $this;
    }

    /**
     * Get videoResolution
     *
     * @return string
     */
    public function getVideoResolution()
    {
        return $this->videoResolution;
    }

    /**
     * Set lightMetering
     *
     * @param string $lightMetering
     *
     * @return Camera
     */
    public function setLightMetering($lightMetering)
    {
        $this->lightMetering = $lightMetering;

        return $this;
    }

    /**
     * Get lightMetering
     *
     */
    public function getLightMetering()
    {
        return $this->lightMetering;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Camera
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set imageUrl
     *
     * @param string $imageUrl
     *
     * @return Camera
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * Get imageUrl
     *
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     *
     * @return Camera
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Callback for Make Assert annotation
     */
    public static function getMakes()
    {
        return [
          'Canon',
          'Nikon',
          'Penta',
          'Sony',
        ];
    }

    /**
     * Callback for Light Metering Assert annotation
     */
    public static function getLightMeterings()
    {
        return [
          'spot',
          'center-weighted',
          'evaluative',
        ];
    }

    /**
     * Callback for Min ISO Assert annotation
     */
    public static function getMinIsos()
    {
        return [
          50,
          100,
        ];
    }

    /**
     * Checks if max ISO is divisible by 100.
     * @Assert\Callback
     * @param \Symfony\Component\Validator\Context\ExecutionContextInterface $context
     * @param $payload
     */
    public function maxIsoDivisibleBy(ExecutionContextInterface $context, $payload)
    {
        if ($this->getMaxIso() % 100 !== 0) {
            $context->buildViolation('Number must be divisible by 100')
                ->atPath('maxIso')
                ->addViolation();
        }
    }
}