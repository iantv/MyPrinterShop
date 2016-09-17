<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\OrderRepository")
 * @ORM\Table(name="app_orders")
 */
class Order{

	/**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="Orders")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
	 */
	private $user;

	/**
     * @ORM\OneToMany(targetEntity="OrderElem", mappedBy="order")
     */
	private $productList;

	/**
	 * @ORM\Column(type="decimal", scale=2)
	 */
	private $totalSum;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $orderDate;

	/**
	 * @ORM\ManyToOne(targetEntity="OrderState", inversedBy="Orders")
	 * @ORM\JoinColumn(name="state_id", referencedColumnName="id")
	 */
	private $state;

    public function __toString(){
        return '#'.$this->id; //Used in admin when listing orderelems
    }

    /**
     * @ORM\ManyToOne(targetEntity="DeliveryPoint", inversedBy="orders")
     * @ORM\JoinColumn(name="end_delivery_id", referencedColumnName="id")
     */
    private $endDeliveryPoint;

    /**
     * @ORM\ManyToOne(targetEntity="DeliveryPoint", inversedBy="tempOrders")
     * @ORM\JoinColumn(name="current_delivery_id", referencedColumnName="id")
     */
    private $currentDeliveryPoint;

    /**
     * @ORM\ManyToOne(targetEntity="DeliveryState", inversedBy="orders")
     * @ORM\JoinColumn(name="delivery_state_id", referencedColumnName="id")
     */
    private $deliveryState;

    /**
     * @ORM\Column(type="datetime")
     */
    private $deliveryDate;

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
     * Set productList
     *
     * @param string $productList
     *
     * @return Order
     */
    public function setProductList($productList)
    {
        $this->productList = $productList;

        return $this;
    }

    /**
     * Get productList
     *
     * @return string
     */
    public function getProductList()
    {
        return $this->productList;
    }

    /**
     * Set totalSum
     *
     * @param string $totalSum
     *
     * @return Order
     */
    public function setTotalSum($totalSum)
    {
        $this->totalSum = $totalSum;

        return $this;
    }

    /**
     * Get totalSum
     *
     * @return string
     */
    public function getTotalSum()
    {
        return $this->totalSum;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Order
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set state
     *
     * @param \AppBundle\Entity\OrderState $state
     *
     * @return Order
     */
    public function setState(\AppBundle\Entity\OrderState $state = null)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return \AppBundle\Entity\OrderState
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set orderDate
     *
     * @param \DateTime $orderDate
     *
     * @return Order
     */
    public function setOrderDate($orderDate)
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    /**
     * Get orderDate
     *
     * @return \DateTime
     */
    public function getOrderDate()
    {
        return $this->orderDate;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->productList = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add productList
     *
     * @param \AppBundle\Entity\OrderElem $productList
     *
     * @return Order
     */
    public function addProductList(\AppBundle\Entity\OrderElem $productList)
    {
        $this->productList[] = $productList;

        return $this;
    }

    /**
     * Remove productList
     *
     * @param \AppBundle\Entity\OrderElem $productList
     */
    public function removeProductList(\AppBundle\Entity\OrderElem $productList)
    {
        $this->productList->removeElement($productList);
    }

    /**
     * Set deliveryDate
     *
     * @param \DateTime $deliveryDate
     *
     * @return Order
     */
    public function setDeliveryDate($deliveryDate)
    {
        $this->deliveryDate = $deliveryDate;

        return $this;
    }

    /**
     * Get deliveryDate
     *
     * @return \DateTime
     */
    public function getDeliveryDate()
    {
        return $this->deliveryDate;
    }

    /**
     * Set endDeliveryPoint
     *
     * @param \AppBundle\Entity\DeliveryPoint $endDeliveryPoint
     *
     * @return Order
     */
    public function setEndDeliveryPoint(\AppBundle\Entity\DeliveryPoint $endDeliveryPoint = null)
    {
        $this->endDeliveryPoint = $endDeliveryPoint;

        return $this;
    }

    /**
     * Get endDeliveryPoint
     *
     * @return \AppBundle\Entity\DeliveryPoint
     */
    public function getEndDeliveryPoint()
    {
        return $this->endDeliveryPoint;
    }

    /**
     * Set currentDeliveryPoint
     *
     * @param \AppBundle\Entity\DeliveryPoint $currentDeliveryPoint
     *
     * @return Order
     */
    public function setCurrentDeliveryPoint(\AppBundle\Entity\DeliveryPoint $currentDeliveryPoint = null)
    {
        $this->currentDeliveryPoint = $currentDeliveryPoint;

        return $this;
    }

    /**
     * Get currentDeliveryPoint
     *
     * @return \AppBundle\Entity\DeliveryPoint
     */
    public function getCurrentDeliveryPoint()
    {
        return $this->currentDeliveryPoint;
    }

    /**
     * Set deliveryState
     *
     * @param \AppBundle\Entity\DeliveryState $deliveryState
     *
     * @return Order
     */
    public function setDeliveryState(\AppBundle\Entity\DeliveryState $deliveryState = null)
    {
        $this->deliveryState = $deliveryState;
        $this->deliveryDate = new \DateTime("now");
        return $this;
    }

    /**
     * Get deliveryState
     *
     * @return \AppBundle\Entity\DeliveryState
     */
    public function getDeliveryState()
    {
        return $this->deliveryState;
    }
}
