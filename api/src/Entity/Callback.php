<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Bukashk0zzz\FilterBundle\Annotation\FilterAnnotation as Filter;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Callback
 *
 * @ApiResource
 *
 * @ORM\Table(name="callback")
 * @ORM\Entity(repositoryClass="App\Repository\CallbackRepository")
 *
 * @UniqueEntity("id")
 */
class Callback
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Assert\Type("integer")
     * @Assert\Length(max = 11)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=true, options={"default" = ""})
     *
     * @Assert\Type("string")
     * @Assert\Length(max=50)
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z ']{0,50}$/",
     *     match=true,
     *     message="This value can contain only the Latin alphabet, space and '."
     * )
     * @Filter("StripTags")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=14)
     *
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(min=14, max=14)
     * @Assert\Regex(pattern="/^\(\w{3}\) \w{3}-\w{4}$/", match=true)
     * @Filter("StripTags")
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=255, nullable=true, options={"default" = ""})
     *
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     * @Assert\Regex(
     *     pattern="/^[^а-яА-Я<>]{0,255}$/",
     *     match=true,
     *     message="This value can contain the Latin alphabet, digits and all characters except > and <."
     * )
     * @Filter("StripTags")
     */
    private $message;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean")
     *
     * @Assert\Type("bool")
     */
    private $active = true;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     *
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $created;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->created = new \DateTime();
        $this->active = true;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     *
     * @return self
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return self
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param string $created
     *
     * @return self
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return self
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }
}