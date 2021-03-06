<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="order_state")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\OrderStateRepository")
 */
class OrderState{
	/**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	private $id;

	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $Name;

    /**
     * @ORM\OneToMany(targetEntity="Order", mappedBy="state")
     */
    private $Orders;

    /**
     * @ORM\Column(type="decimal", scale=0)
     */
    private $level;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Orders = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString(){
        return $this->Name;
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
     * @return OrderState
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
     * Add order
     *
     * @param \AppBundle\Entity\Order $order
     *
     * @return OrderState
     */
    public function addOrder(\AppBundle\Entity\Order $order)
    {
        $this->Orders[] = $order;

        return $this;
    }

    /**
     * Remove order
     *
     * @param \AppBundle\Entity\Order $order
     */
    public function removeOrder(\AppBundle\Entity\Order $order)
    {
        $this->Orders->removeElement($order);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrders()
    {
        return $this->Orders;
    }

    /**
     * Set level
     *
     * @param string $level
     *
     * @return OrderState
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }
}
