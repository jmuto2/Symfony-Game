<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PlayerGameRepository extends EntityRepository
{
	public function findTotalsByGame()
	{
		$qb = $this->getEntityManager()->createQueryBuilder();
		
		$player_options = [];
		
		$results = $qb->select('pg')
			->from('AppBundle:PlayerGame', 'pg')
			->innerJoin('AppBundle:Option', 'o', 'WITH', 'o.id = pg.option_id')
			->innerJoin('AppBundle:Player', 'p', 'WITH', 'p.id = pg.player_id')
			->addSelect('p.name as player, o.name as option, COUNT(pg.option_id) as played')
			->groupBy('pg.player_id, pg.option_id')
			->getQuery()->getArrayResult();
		
		for ($i = 0; $i < count($results); $i++) {
			$data = [
				'option' => $results[$i]['option'],
				'played' => (int)$results[$i]['played']
			];
			
			if ($results[$i]['player'] == 'Player') {
				$player_options['Player'][$i] = $data;
			} else {
				$player_options['Computer'][$i] = $data;
			}
		}
		
		return $player_options;
	}
}