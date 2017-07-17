<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Option;
use AppBundle\Entity\Player;
use AppBundle\Entity\PlayerGame;
use AppBundle\Entity\Scoring;
use AppBundle\Entity\Game;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class GameController extends Controller
{
    /**
     * @Route("/game", name="game")
     */
    public function indexAction(Request $request)
    {
		return $this->render('default/index.html.twig');
    }
	
	/**
	 * @Route("/save_game", name="save_game")
	 */
	public function saveGameResult(Request $request)
	{
		$data = (object)$request->request->get('data');
		
		if ($data->computer_option === $data->player_option) {
			return new JsonResponse([
				'option_played' => null,
				'result' => 'Tie Game, try again',
				'winner' => 'Nobody'
			]);
		}
		
		$this->createNewPlayersIfNotExists();
		$this->createOptionsIfNotExists();
		$this->createScoringIfNotExists();
		
		$result = $this->savePlayersResult($data);
		
		return new JsonResponse($result);
	}
	
	/**
	 * @param object $data
	 *
	 * @return array
	 */
	private function savePlayersResult($data)
	{
		$em = $this->getDoctrine()->getManager();
		$scored = $em->getRepository(Scoring::class)->findResult($data);
		list($player, $computer) = $this->getPlayers();

		$game = new Game();
		$game->setWinningOptionId($scored[0]['option_a']);
		$game->setLosingOptionId($scored[0]['option_b']);
		if ($scored[0]['option_a'] === (int) $data->computer_option) {
			$game->setWinnerId($computer->getId());
			$game->setLoserId($player->getId());
		} else {
			$game->setWinnerId($player->getId());
			$game->setLoserId($computer->getId());
		}
		
		$em->persist($game);
		$em->flush();
		
		$this->saveOptionsByGame([$computer->getId(), $player->getId()], [$data->computer_option, $data->player_option], $game->getId());
		$options_played = $em->getRepository(PlayerGame::class)->findTotalsByGame();
		$totals = $em->getRepository(Game::class)->findResultsByGame([$player->getId(), $computer->getId()]);
		$winner = $computer->getId() === $game->getWinnerId() ? $computer->getName() : $player->getName();
		
		return [
			'result' => $scored[0]['result'],
			'winner' => $winner,
			'options_played' => $options_played,
			'computer_wins' => $totals[1][1],
			'player_wins' => $totals[0][1]
		];
	}
	
	private function createNewPlayersIfNotExists()
	{
		$em = $this->getDoctrine()->getManager();
		$players = [
			'Player',
			'Computer'
		];
		
		for ($i = 0; $i < count($players); ++$i) {
			if (($player = $em->getRepository(Player::class)->findOneByName($players[$i])) == null) {
				$player = new Player();
				$player->setName($players[$i]);
				$em->persist($player);
			}
		}
		$em->flush();
		$em->clear();
	}
    
    private function createOptionsIfNotExists()
	{
		$em = $this->getDoctrine()->getManager();
		$options = [
			'rock',
			'paper',
			'scissors',
			'spock',
			'lizard'
		];
		
		for ($i = 0; $i < count($options); ++$i) {
			if (($option = $em->getRepository(Option::class)->findOneByName($options[$i])) == null) {
				$option = new Option();
				$option->setName($options[$i]);
				$em->persist($option);
			}
		}
		$em->flush();
		$em->clear();
	}
	
	private function createScoringIfNotExists()
	{
		$em = $this->getDoctrine()->getManager();
		$scores = [
			[3, 2, 'Scissors cuts Paper'],
			[2, 1, 'Paper covers Rock'],
			[1, 5, 'Rock crushes Lizard'],
			[5, 4, 'Lizard poisons Spock'],
			[4, 3, 'Spock smashes Scissors'],
			[3, 5, 'Scissors decapitates Lizard'],
			[5, 2, 'Lizard eats Paper'],
			[2, 4, 'Paper disproves Spock'],
			[4, 1, 'Spock vaporizes Rock'],
			[1, 3, 'Rock crushes Scissors'],
		];

		for ($i = 0; $i < count($scores); ++$i) {
			if (($score = $em->getRepository(Scoring::class)->findOneBy(['option_a' => $scores[$i][0], 'option_b' => $scores[$i][1]])) == null) {
				$score = new Scoring();
				$score->setOptionA($scores[$i][0]);
				$score->setOptionB($scores[$i][1]);
				$score->setResult($scores[$i][2]);
				$em->persist($score);
			}
		}
		$em->flush();
		$em->clear();
	}
	
	/**
	 * @param array $ids
	 * @param array $options
	 * @param int $game_id
	 */
	private function saveOptionsByGame(array $ids, array $options, $game_id)
	{
		$em = $this->getDoctrine()->getManager();
		
		for ($i = 0; $i < count($ids); ++$i) {
			$played_options = new PlayerGame();
			$played_options->setGameId($game_id);
			$played_options->setPlayerId($ids[$i]);
			$played_options->setOptionId($options[$i]);
			$em->persist($played_options);
		}
		$em->flush();
		$em->clear();
	}
	
	/***
	 * @return array
	 */
	private function getPlayers()
	{
		$player_repository = $this->getDoctrine()->getRepository(Player::class);
		$player = $player_repository->findOneByName('Player');
		$computer = $player_repository->findOneByName('Computer');
		
		return array($player, $computer);
	}
}
