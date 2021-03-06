<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * SubCategory
 *
 * @ORM\Table(name="sub_category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SubCategoryRepository")
 */
class SubCategory
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
     * @ORM\Column(name="Name", type="string", length=255)
     */
    private $Name;
    
    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="SubCategory")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $Category;   

    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="SubCategory")
     */
    private $Products;

    /**
    * @ORM\OneToMany(targetEntity="BlogPost", mappedBy="subcategory")
    */
    private $blogPosts;

    public function getBlogPosts()
    {
        return $this->blogPosts;
    }

    public function __construct()
    {
        $this->blogPosts = new ArrayCollection();
        $this->Products = new ArrayCollection();
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
     * @return SubCategory
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
     * Add product
     *
     * @param \AppBundle\Entity\Product $product
     *
     * @return SubCategory
     */
    public function addProduct(\AppBundle\Entity\Product $product)
    {
        $this->Products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \AppBundle\Entity\Product $product
     */
    public function removeProduct(\AppBundle\Entity\Product $product)
    {
        $this->Products->removeElement($product);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->Products;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return SubCategory
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->Category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->Category;
    }

    /**
     * Add blogPost
     *
     * @param \AppBundle\Entity\BlogPost $blogPost
     *
     * @return SubCategory
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
