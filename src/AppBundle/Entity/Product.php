<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ProductRepository")
 * @ORM\Table(name="product")
 */
class Product
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

    /**
     * @ORM\ManyToOne(targetEntity="SubCategory", inversedBy="Products")
     * @ORM\JoinColumn(name="subcategory_id", referencedColumnName="id")
     */
    private $SubCategory;

	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $Name;
	
	/**
	 * @ORM\Column(type="decimal", scale=0)
	 */
	private $Count;

    /**
     * @ORM\Column(type="decimal", scale=0)
     */
    private $RetailPrice;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $Path; // category_id.subcategory_id

    /**
     * @ORM\OneToMany(targetEntity="BlogPost", mappedBy="product")
     */
    private $blogPosts;

    public function __construct()
    {
        $this->blogPosts = new ArrayCollection();
    }

    public function getBlogPosts()
    {
        return $this->blogPosts;
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
     * Set name
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName($name)
    {
        $this->Name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->Name;
    }

    /**
     * Set count
     *
     * @param string $count
     *
     * @return Product
     */
    public function setCount($count)
    {
        $this->Count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return string
     */
    public function getCount()
    {
        return $this->Count;
    }

    /**
     * Set retailPrice
     *
     * @param string $retailPrice
     *
     * @return Product
     */
    public function setRetailPrice($retailPrice)
    {
        $this->RetailPrice = $retailPrice;

        return $this;
    }

    /**
     * Get retailPrice
     *
     * @return string
     */
    public function getRetailPrice()
    {
        return $this->RetailPrice;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return Product
     */
    public function setPath($path)
    {
        $this->Path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->Path;
    }

    /**
     * Set subCategory
     *
     * @param \AppBundle\Entity\SubCategory $subCategory
     *
     * @return Product
     */
    public function setSubCategory(\AppBundle\Entity\SubCategory $subCategory = null)
    {
        $this->SubCategory = $subCategory;

        return $this;
    }

    /**
     * Get subCategory
     *
     * @return \AppBundle\Entity\SubCategory
     */
    public function getSubCategory()
    {
        return $this->SubCategory;
    }

    /**
     * Add blogPost
     *
     * @param \AppBundle\Entity\BlogPost $blogPost
     *
     * @return Product
     */
    public function addBlogPost(\AppBundle\Entity\BlogPost $blogPost)
    {
        $this->blogPosts[] = $blogPost;

        return $this;
    }

    /**
     * Remove blogPost
     *
     * @param \AppBundle\Entity\BlogPost $blogPost
     */
    public function removeBlogPost(\AppBundle\Entity\BlogPost $blogPost)
    {
        $this->blogPosts->removeElement($blogPost);
    }
}
