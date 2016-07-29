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
     * @ORM\Column(name="product_list", type="string", length=500)
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
}
