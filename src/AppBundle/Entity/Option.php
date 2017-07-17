<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * Class Option
 * @package AppBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="options",
 *     uniqueConstraints={@UniqueConstraint(name="name_unique",columns={"name"})},
 *)
 */
class Option
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $name;
	
	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}
	
	/**
	 * @param mixed $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}
	
	public function __toString()
	{
		return (string)$this->name;
	}
}