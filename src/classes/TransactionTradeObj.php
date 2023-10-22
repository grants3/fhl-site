<?php
class TransactionTradeObj implements \JsonSerializable{
    private $type;
    private $team1;
    private $toTeam1;
    private $team2;
    private $toTeam2;
    
    function __get($name)
    {
        return$this->$name;
    }  

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getTeam1()
    {
        return $this->team1;
    }

    /**
     * @return mixed
     */
    public function getToTeam1()
    {
        return $this->toTeam1;
    }

    /**
     * @return mixed
     */
    public function getTeam2()
    {
        return $this->team2;
    }

    /**
     * @return mixed
     */
    public function getToTeam2()
    {
        return $this->toTeam2;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @param mixed $team1
     */
    public function setTeam1($team1)
    {
        $this->team1 = $team1;
    }

    /**
     * @param mixed $toTeam1
     */
    public function setToTeam1($toTeam1)
    {
        $this->toTeam1 = $toTeam1;
    }

    /**
     * @param mixed $team2
     */
    public function setTeam2($team2)
    {
        $this->team2 = $team2;
    }

    /**
     * @param mixed $toTeam2
     */
    public function setToTeam2($toTeam2)
    {
        $this->toTeam2 = $toTeam2;
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}
