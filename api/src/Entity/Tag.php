<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Bukashk0zzz\FilterBundle\Annotation\FilterAnnotation as Filter;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Tag
 *
 * @ApiResource
 *
 * @ORM\Table(name="tag")
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 *
 * @UniqueEntity("id")
 * @UniqueEntity("name")
 */
class Tag
{
    /**
     * @var int
     *
     * @Groups({"product"})
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
     * @Groups({"product"})
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     *
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(max = 255)
     * @Filter("StripTags")
     */
    private $name;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\ManyToMany(targetEntity="Product", mappedBy="tags")
	 */
    private $products;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new ArrayCollection;
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
     * Set name
     *
     * @param string $name
     *
     * @return Tag
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
     * Add product
     *
     * @param \App\Entity\Product $product
     */
    public function addProduct(Product $product)
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
        }
    }

    /**
     * Remove product
     *
     * @param \App\Entity\Product $product
     *
     * @return self
     */
    public function removeProduct(\App\Entity\Product $product)
    {
        $this->products->removeElement($product);

        return $this;
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->products;
    }
}
