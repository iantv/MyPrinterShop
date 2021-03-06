<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
/**
 * OrderRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OrderRepository extends \Doctrine\ORM\EntityRepository
{
	function findAllByUserIdOrderedByDate($userId)
	{
		$query = $this->getEntityManager()
	        ->createQuery(
	            'SELECT p FROM AppBundle:Order p
	            WHERE p.user = :id ORDER BY p.orderDate DESC'
	        )->setParameter('id', $userId);

	    try {
	        return $query->getResult();
	    } catch (\Doctrine\ORM\NoResultException $e) {
	        return null;
	    }
	}

	function findOpenedOrdersByUserId($userId){
		$query = $this->getEntityManager()->createQuery(
				'SELECT O FROM AppBundle:Order O JOIN O.state S WHERE (O.user = :id and (S.level = 0 or S.level = 2)) ORDER BY O.orderDate DESC'
			)->setParameter('id', $userId);

		try {
			return $query->getResult();
		} catch (\Doctrine\ORM\NoResultException $e) {
			return null;
		}	
	}

	function findBoughtOrdersByUserId($userId){
		$query = $this->getEntityManager()->createQuery(
				'SELECT O FROM AppBundle:Order O JOIN O.state S WHERE (O.user = :id and S.level = 1) ORDER BY O.orderDate DESC'
			)->setParameter('id', $userId);

		try {
			return $query->getResult();
		} catch (\Doctrine\ORM\NoResultException $e) {
			return null;
		}	
	}

	function findCanceledOrdersByUserId($userId){
		$query = $this->getEntityManager()->createQuery(
				'SELECT O FROM AppBundle:Order O JOIN O.state S WHERE (O.user = :id and S.level = 3) ORDER BY O.orderDate DESC'
			)->setParameter('id', $userId);

		try {
			return $query->getResult();
		} catch (\Doctrine\ORM\NoResultException $e) {
			return null;
		}	
	}
}
