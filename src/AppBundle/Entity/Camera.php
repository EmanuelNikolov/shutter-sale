<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="make", type="string", length=5)
     */
    private $make;

    /**
     * @var string
     *
     * @ORM\Column(name="model", type="string", length=255)
     */
    private $model;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="smallint")
     */
    private $quantity;

    /**
     * @var int
     *
     * @ORM\Column(name="min_shutter_speed", type="smallint")
     */
    private $minShutterSpeed;

    /**
     * @var int
     *
     * @ORM\Column(name="max_shutter_speed", type="smallint")
     */
    private $maxShutterSpeed;

    /**
     * @var int
     *
     * @ORM\Column(name="min_iso", type="smallint")
     */
    private $minIso;

    /**
     * @var int
     *
     * @ORM\Column(name="max_iso", type="integer")
     */
    private $maxIso;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_full_frame", type="boolean")
     */
    private $isFullFrame;

    /**
     * @var string
     *
     * @ORM\Column(name="video_resolution", type="string", length=15)
     */
    private $videoResolution;

    /**
     * @var string
     *
     * @ORM\Column(name="light_metering", type="string", length=15)
     */
    private $lightMetering;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=6000)
     */
    private $description;

    /**
     * @var string
     *
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
     * @return string
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
}

