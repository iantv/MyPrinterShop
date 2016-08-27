<?php 
namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\OrderElemsRepository")
 * @ORM\Table(name="app_orderelems")
 */
class OrderElem{

	/**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	private $id;

	/**
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="productList")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
	private $order;

    /**
     * @ORM\Column(type="decimal", scale=0)
     */
    private $productId;

	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $productName;

	/**
     * @ORM\Column(type="decimal", scale=0)
     */
	private $price;

	/**
     * @ORM\Column(type="decimal", scale=0)
     */
	private $count;

	/**
     * @ORM\Column(type="decimal", scale=0)
     */
	private $sum;

    public function __toString(){
        return "(".$this->id.")".$this->productName.": ".$this->price."x".$this->count."=".$this->sum;
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
     * Set productName
     *
     * @param string $productName
     *
     * @return OrderElems
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;

        return $this;
    }

    /**
     * Get productName
     *
     * @return string
     */
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return OrderElems
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
     * Set count
     *
     * @param string $count
     *
     * @return OrderElems
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return string
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set sum
     *
     * @param string $sum
     *
     * @return OrderElems
     */
    public function setSum($sum)
    {
        $this->sum = $sum;

        return $this;
    }

    /**
     * Get sum
     *
     * @return string
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * Set order
     *
     * @param \AppBundle\Entity\Order $order
     *
     * @return OrderElems
     */
    public function setOrder(\AppBundle\Entity\Order $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \AppBundle\Entity\Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set productId
     *
     * @param string $productId
     *
     * @return OrderElem
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;

        return $this;
    }

    /**
     * Get productId
     *
     * @return string
     */
    public function getProductId()
    {
        return $this->productId;
    }
}
