<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class PlayerGame
 * @package AppBundle\Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlayerGameRepository")
 * @ORM\Table(name="player_games")
 */
class PlayerGame
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
	private $game_id;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	private $player_id;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	private $option_id;
	
	/**
	 * @return mixed
	 */
	public function getGameId()
	{
		return $this->game_id;
	}
	
	/**
	 * @param mixed $game_id
	 */
	public function setGameId($game_id)
	{
		$this->game_id = $game_id;
	}
	
	/**
	 * @return mixed
	 */
	public function getPlayerId()
	{
		return $this->player_id;
	}
	
	/**
	 * @param mixed $player_id
	 */
	public function setPlayerId($player_id)
	{
		$this->player_id = $player_id;
	}
	
	/**
	 * @return mixed
	 */
	public function getOptionId()
	{
		return $this->option_id;
	}
	
	/**
	 * @param mixed $option_id
	 */
	public function setOptionId($option_id)
	{
		$this->option_id = $option_id;
	}
}