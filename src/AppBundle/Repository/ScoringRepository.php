<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ScoringRepository extends EntityRepository
{
	public function findResult($data)
	{
		$qb = $this->getEntityManager()->createQueryBuilder();
		$qb->setParameters(array('option_a' => (int) $data->computer_option, 'option_b' => (int) $data->player_option));
		$params = $qb->getParameters();
		
		return $qb->select('s')
			->from('AppBundle:Scoring', 's')
			->where('s.option_a = :option_a AND s.option_b = :option_b')
			->orWhere('s.option_a = :option_b AND s.option_b = :option_a')
			->setParameters($params)
			->getQuery()->getArrayResult();
	}
}