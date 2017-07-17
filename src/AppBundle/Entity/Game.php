<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Game
 * @package AppBundle\Entitys
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GameRepository")
 * @ORM\Table(name="games")
 */
class Game
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	private $winner_id;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	private $loser_id;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	private $winning_option_id;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	private $losing_option_id;
	
	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * @return int
	 */
	public function getWinnerId()
	{
		return $this->winner_id;
	}
	
	/**
	 * @param int $winner_id
	 */
	public function setWinnerId($winner_id)
	{
		$this->winner_id = $winner_id;
	}
	
	/**
	 * @return int
	 */
	public function getLoserId()
	{
		return $this->loser_id;
	}
	
	/**
	 * @param int $loser_id
	 */
	public function setLoserId($loser_id)
	{
		$this->loser_id = $loser_id;
	}
	
	/**
	 * @return int
	 */
	public function getWinningOptionId()
	{
		return $this->winning_option_id;
	}
	
	/**
	 * @param int $winning_option_id
	 */
	public function setWinningOptionId($winning_option_id)
	{
		$this->winning_option_id = $winning_option_id;
	}
	
	/**
	 * @return int
	 */
	public function getLosingOptionId()
	{
		return $this->losing_option_id;
	}
	
	/**
	 * @param int $losing_option_id
	 */
	public function setLosingOptionId($losing_option_id)
	{
		$this->losing_option_id = $losing_option_id;
	}
}