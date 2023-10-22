<?php

class ScheduleObj implements \JsonSerializable{
    
    var $isPlayed = false;
    var $isRequired = true;
    var $gameNumber;
    var $gameDay;
    var $team1;
    var $team1Score;
    var $team2;
    var $team2Score;
    var $isOt;
    var $gameTitle;
    
    function __get($name)
    {
        return$this->$name;
    }  
    
    /**
     * @return boolean
     */
    public function getIsPlayed()
    {
        return $this->isPlayed;
    }

    /**
     * @param boolean $isPlayed
     */
    public function setIsPlayed($isPlayed)
    {
        $this->isPlayed = $isPlayed;
    }
    
    /**
     * @return boolean
     */
    public function getIsRequired()
    {
        return $this->isRequired;
    }

    /**
     * @param boolean $isRequired
     */
    public function setIsRequired($isRequired)
    {
        $this->isRequired = $isRequired;
    }

    /**
     * @return mixed
     */
    public function getGameNumber()
    {
        return $this->gameNumber;
    }

    /**
     * @return mixed
     */
    public function getGameDay()
    {
        return $this->gameDay;
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
    public function getTeam1Score()
    {
        return $this->team1Score;
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
    public function getTeam2Score()
    {
        return $this->team2Score;
    }

    /**
     * @return mixed
     */
    public function getIsOt()
    {
        return $this->isOt;
    }

    /**
     * @param mixed $gameNumber
     */
    public function setGameNumber($gameNumber)
    {
        $this->gameNumber = $gameNumber;
    }

    /**
     * @param mixed $gameDay
     */
    public function setGameDay($gameDay)
    {
        $this->gameDay = $gameDay;
    }

    /**
     * @param mixed $team1
     */
    public function setTeam1($team1)
    {
        $this->team1 = $team1;
    }

    /**
     * @param mixed $team1Score
     */
    public function setTeam1Score($team1Score)
    {
        $this->team1Score = $team1Score;
    }

    /**
     * @param mixed $team2
     */
    public function setTeam2($team2)
    {
        $this->team2 = $team2;
    }

    /**
     * @param mixed $team2Score
     */
    public function setTeam2Score($team2Score)
    {
        $this->team2Score = $team2Score;
    }

    /**
     * @param mixed $isOt
     */
    public function setIsOt($isOt)
    {
        $this->isOt = $isOt;
    }
    /**
     * @return mixed
     */
    public function getGameTitle()
    {
        return $this->gameTitle;
    }

    /**
     * @param mixed $gameTitle
     */
    public function setGameTitle($gameTitle)
    {
        $this->gameTitle = $gameTitle;
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
       
}

