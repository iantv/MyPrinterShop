<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="order")
 */
class Order{
	/**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="Order")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
	 */
	private $userId;

	/**
     * @var string
     *
     * @ORM\Column(name="product_list", type="json_array")
     */
	private $productList;

	/**
	 * @ORM\Column(type="decimal", scale=0)
	 */
	private $sum;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $date;

	/**
	 * @ORM\ManyToOne(targetEntity="State", inversedBy="Order")
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
     * @param array $productList
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
     * @return array
     */
    public function getProductList()
    {
        return $this->productList;
    }

    /**
     * Set sum
     *
     * @param string $sum
     *
     * @return Order
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Order
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set userId
     *
     * @param \AppBundle\Entity\User $userId
     *
     * @return Order
     */
    public function setUserId(\AppBundle\Entity\User $userId = null)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return \AppBundle\Entity\User
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set state
     *
     * @param \AppBundle\Entity\State $state
     *
     * @return Order
     */
    public function setState(\AppBundle\Entity\State $state = null)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return \AppBundle\Entity\State
     */
    public function getState()
    {
        return $this->state;
    }
}
