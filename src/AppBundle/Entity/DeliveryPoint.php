<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="delivery_point")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\DeliveryPointRepository")
 */
class DeliveryPoint{
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
	private $pathName;

	/**
     * @ORM\Column(type="float")
     */
	private $nothLatitude;

	/**
     * @ORM\Column(type="float")
     */
	private $eastLongitude;

	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $address;

    /**
     * @ORM\OneToMany(targetEntity="Order", mappedBy="endDeliveryPoint")
     */
    private $orders;

    /**
     * @ORM\OneToMany(targetEntity="Order", mappedBy="currentDeliveryPoint")
     */
    private $tempOrders;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->orders = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getFieldsValue()
    {
        $result = [
            'pathName' => $this->pathName,
            'nothLatitude' => $this->nothLatitude,
            'eastLongitude' => $this->eastLongitude,
            'address' => $this->address
        ];
        return json_encode($result, JSON_UNESCAPED_UNICODE);
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
     * Set pathName
     *
     * @param string $pathName
     *
     * @return DeliveryPoint
     */
    public function setPathName($pathName)
    {
        $this->pathName = $pathName;

        return $this;
    }

    /**
     * Get pathName
     *
     * @return string
     */
    public function getPathName()
    {
        return $this->pathName;
    }

    /**
     * Set nothLatitude
     *
     * @param float $nothLatitude
     *
     * @return DeliveryPoint
     */
    public function setNothLatitude($nothLatitude)
    {
        $this->nothLatitude = $nothLatitude;

        return $this;
    }

    /**
     * Get nothLatitude
     *
     * @return float
     */
    public function getNothLatitude()
    {
        return $this->nothLatitude;
    }

    /**
     * Set eastLongitude
     *
     * @param float $eastLongitude
     *
     * @return DeliveryPoint
     */
    public function setEastLongitude($eastLongitude)
    {
        $this->eastLongitude = $eastLongitude;

        return $this;
    }

    /**
     * Get eastLongitude
     *
     * @return float
     */
    public function getEastLongitude()
    {
        return $this->eastLongitude;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return DeliveryPoint
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }
    

    /**
     * Add order
     *
     * @param \AppBundle\Entity\Order $order
     *
     * @return DeliveryPoint
     */
    public function addOrder(\AppBundle\Entity\Order $order)
    {
        $this->orders[] = $order;

        return $this;
    }

    /**
     * Remove order
     *
     * @param \AppBundle\Entity\Order $order
     */
    public function removeOrder(\AppBundle\Entity\Order $order)
    {
        $this->orders->removeElement($order);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * Add tempOrder
     *
     * @param \AppBundle\Entity\Order $tempOrder
     *
     * @return DeliveryPoint
     */
    public function addTempOrder(\AppBundle\Entity\Order $tempOrder)
    {
        $this->tempOrders[] = $tempOrder;

        return $this;
    }

    /**
     * Remove tempOrder
     *
     * @param \AppBundle\Entity\Order $tempOrder
     */
    public function removeTempOrder(\AppBundle\Entity\Order $tempOrder)
    {
        $this->tempOrders->removeElement($tempOrder);
    }

    /**
     * Get tempOrders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTempOrders()
    {
        return $this->tempOrders;
    }
}
