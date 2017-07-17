<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class GameRespository extends EntityRepository
{
	public function findResultsByGame($ids)
	{
		$qb = $this->getEntityManager()->createQueryBuilder();
		
		return $qb->select('g')
			->from('AppBundle:Game', 'g')
			->innerJoin('AppBundle:Player', 'p', 'WITH', 'p.id = g.winner_id')
			->addSelect('p.name, COUNT(g.winner_id)')
			->where('p.id = g.winner_id')
			->groupBy('p.id')
			->getQuery()->getArrayResult();
	}
}