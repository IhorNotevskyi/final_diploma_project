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
 * Product
 *
 * @ApiResource(attributes={
 *     "normalization_context"={"groups"={"product"}}
 * })
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 *
 * @UniqueEntity("id")
 * @UniqueEntity("image")
 */
class Product
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
     * @ORM\Column(name="title", type="string", length=255)
     *
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(max = 255)
     * @Filter("StripTags")
     */
    private $title;

    /**
     * @var string
     *
     * @Groups({"product"})
     *
     * @ORM\Column(name="description", type="text")
     *
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(max = 5000)
     * @Filter("StripTags")
     */
    private $description;

    /**
     * @var string
     *
     * @Groups({"product"})
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2)
     *
     * @Assert\NotBlank()
     * @Assert\Type("numeric")
     * @Assert\Regex(pattern="/^[0-9]{1,8}(\.[0-9][0-9]?)?$/", match=true)
     * @Filter("StripTags")
     */
    private $price;

    /**
     * @var bool
     *
     * @Groups({"product"})
     *
     * @ORM\Column(name="active", type="boolean", options={"user": true})
     *
     * @Assert\Type("bool")
     */
    private $active = true;

    /**
     * @var string
     *
     * @Groups({"product"})
     *
     * @ORM\Column(name="image", type="string", length=255, unique=true)
     *
     * @Assert\NotBlank(groups={"add_product"}, message="Please, upload the product image.")
     * @Assert\File(
     *     maxSize = "3M",
     *     mimeTypes={ "image/jpeg", "image/png" }
     * )
     */
    private $image;
    
    /**
     * @var Category|null
     *
     * @Groups({"product"})
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     */
    private $category;

	/**
	 * @var ArrayCollection
     *
     * @Groups({"product"})
	 *
	 * @ORM\ManyToMany(targetEntity="Tag", inversedBy="products", cascade={"persist"})
	 */
    protected $tags;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tags = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     *
     * @return Product
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
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
     * Set price
     *
     * @param string $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Product
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Set title
     *
     * @param string $image
     *
     * @return Product
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return Product
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return Category|null
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Add tag
     *
     * @param Tag $tag
     * @return $this
     */
    public function addTag(Tag $tag)
    {
        $tag->addProduct($this);
        $this->tags->add($tag);

        return $this;
    }

    /**
     * Remove tag
     *
     * @param Tag $tag
     * @return $this
     */
    public function removeTag(Tag $tag)
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    /**
     * Get tags
     *
     * @return ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }
}