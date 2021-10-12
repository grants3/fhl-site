<?php

require_once __DIR__.'/../baseConfig.php';

require_once FS_ROOT.'classes/ScoringObj.php';


class ScoringGoalieObj implements \JsonSerializable, ScoringObj{
    
    var $number;
    var $team;
    var $teamAbbr;
    var $position;
    var $rookieStatus = false;
    var $name;
    var $gamesPlayed;
    var $minutes;
    var $gaa;
    var $wins;
    var $losses;
    var $ties;
    var $shutouts;
    var $savesAttempted;
    var $goalsAgainst;
    var $savePct;
    var $pim;
    var $assists;
 
    function __get($name)
    {
        return$this->$name;
    } 

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return mixed
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @return mixed
     */
    public function getTeamAbbr()
    {
        return $this->teamAbbr;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return mixed
     */
    public function getRookieStatus()
    {
        return $this->rookieStatus;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getGamesPlayed()
    {
        return $this->gamesPlayed;
    }

    /**
     * @return mixed
     */
    public function getMinutes()
    {
        return $this->minutes;
    }

    /**
     * @return mixed
     */
    public function getGaa()
    {
        return $this->gaa;
    }

    /**
     * @return mixed
     */
    public function getWins()
    {
        return $this->wins;
    }

    /**
     * @return mixed
     */
    public function getLosses()
    {
        return $this->losses;
    }

    /**
     * @return mixed
     */
    public function getTies()
    {
        return $this->ties;
    }

    /**
     * @return mixed
     */
    public function getShutouts()
    {
        return $this->shutouts;
    }

    /**
     * @return mixed
     */
    public function getSavesAttempted()
    {
        return $this->savesAttempted;
    }

    /**
     * @return mixed
     */
    public function getGoalsAgainst()
    {
        return $this->goalsAgainst;
    }

    /**
     * @return mixed
     */
    public function getSavePct()
    {
        return $this->savePct;
    }

    /**
     * @return mixed
     */
    public function getPim()
    {
        return $this->pim;
    }

    /**
     * @return mixed
     */
    public function getAssists()
    {
        return $this->assists;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @param mixed $team
     */
    public function setTeam($team)
    {
        $this->team = $team;
    }

    /**
     * @param mixed $teamAbbr
     */
    public function setTeamAbbr($teamAbbr)
    {
        $this->teamAbbr = $teamAbbr;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @param mixed $rookieStatus
     */
    public function setRookieStatus($rookieStatus)
    {
        $this->rookieStatus = $rookieStatus;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $gamesPlayed
     */
    public function setGamesPlayed($gamesPlayed)
    {
        $this->gamesPlayed = $gamesPlayed;
    }

    /**
     * @param mixed $minutes
     */
    public function setMinutes($minutes)
    {
        $this->minutes = $minutes;
    }

    /**
     * @param mixed $gaa
     */
    public function setGaa($gaa)
    {
        $this->gaa = $gaa;
    }

    /**
     * @param mixed $wins
     */
    public function setWins($wins)
    {
        $this->wins = $wins;
    }

    /**
     * @param mixed $losses
     */
    public function setLosses($losses)
    {
        $this->losses = $losses;
    }

    /**
     * @param mixed $ties
     */
    public function setTies($ties)
    {
        $this->ties = $ties;
    }

    /**
     * @param mixed $shutouts
     */
    public function setShutouts($shutouts)
    {
        $this->shutouts = $shutouts;
    }

    /**
     * @param mixed $savesAttempted
     */
    public function setSavesAttempted($savesAttempted)
    {
        $this->savesAttempted = $savesAttempted;
    }

    /**
     * @param mixed $goalsAgainst
     */
    public function setGoalsAgainst($goalsAgainst)
    {
        $this->goalsAgainst = $goalsAgainst;
    }

    /**
     * @param mixed $savePct
     */
    public function setSavePct($savePct)
    {
        $this->savePct = $savePct;
    }

    /**
     * @param mixed $pim
     */
    public function setPim($pim)
    {
        $this->pim = $pim;
    }

    /**
     * @param mixed $assists
     */
    public function setAssists($assists)
    {
        $this->assists = $assists;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

}


