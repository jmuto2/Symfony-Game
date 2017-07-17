<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * Class Scoring
 * @package AppBundle\Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ScoringRepository")
 * @ORM\Table(name="scoring",
 *        uniqueConstraints={@UniqueConstraint(name="search_idx", columns={"option_a", "option_b"})})
 *)
 */
class Scoring
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
    private $option_a;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $option_b;
    
    /**
     * @ORM\Column(type="string")
     */
    private $result;
    
    /**
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }
    
    /**
     * @param string $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }
    
    /**
     * @return int
     */
    public function getOptionA()
    {
        return $this->option_a;
    }
    
    /**
     * @param int $option_a
     */
    public function setOptionA($option_a)
    {
        $this->option_a = $option_a;
    }
    
    /**
     * @return int
     */
    public function getOptionB()
    {
        return $this->option_b;
    }
    
    /**
     * @param int $option_b
     */
    public function setOptionB($option_b)
    {
        $this->option_b = $option_b;
    }
    
    public function __toString()
    {
        return (string)$this->result;
    }
}