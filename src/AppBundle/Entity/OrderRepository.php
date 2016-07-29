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
	function findAllByUserId($userId)
	{
		$query = $this->getEntityManager()
	        ->createQuery(
	            'SELECT p FROM AppBundle:Order p
	            WHERE p.user = :id'
	        )->setParameter('id', $userId);

	    try {
	        return $query->getResult();
	    } catch (\Doctrine\ORM\NoResultException $e) {
	        return null;
	    }
	}
}