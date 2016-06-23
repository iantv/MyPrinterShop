<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="Products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $Category;

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
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
        $this->Category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->Category;
    }

    /**
     * Set subCategory
     *
     * @param string $subCategory
     *
     * @return Product
     */
    public function setSubCategory($subCategory)
    {
        $this->SubCategory = $subCategory;

        return $this;
    }

    /**
     * Get subCategory
     *
     * @return string
     */
    public function getSubCategory()
    {
        return $this->SubCategory;
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
}
