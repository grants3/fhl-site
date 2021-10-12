<?php
require_once __DIR__.'/../baseConfig.php';

require_once FS_ROOT.'classes/ScoringObj.php';


class ScoringPlayerObj implements \JsonSerializable, ScoringObj{
    
    var $number;
    var $team;
    var $teamAbbr;
    var $position;
    var $rookieStatus = false;
    var $name;
    var $gamesPlayed;
    var $goals;
    var $assists;
    var $points;
    var $plusMinus;
    var $pim;
    var $ppg;
    var $shg;
    var $gwg;
    var $gtg;
    var $hits;
    var $shots;
    var $shotPct;
    var $goalStreak;
    var $pointStreak;
    
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
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
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
     * @param mixed $teamAbbr
     */
    public function setTeamAbbr($teamAbbr)
    {
        $this->teamAbbr = $teamAbbr;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return boolean
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
    public function getGoals()
    {
        return $this->goals;
    }

    /**
     * @return mixed
     */
    public function getAssists()
    {
        return $this->assists;
    }

    /**
     * @return mixed
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @return mixed
     */
    public function getPlusMinus()
    {
        return $this->plusMinus;
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
    public function getPpg()
    {
        return $this->ppg;
    }

    /**
     * @return mixed
     */
    public function getShg()
    {
        return $this->shg;
    }

    /**
     * @return mixed
     */
    public function getGwg()
    {
        return $this->gwg;
    }

    /**
     * @return mixed
     */
    public function getGtg()
    {
        return $this->gtg;
    }

    /**
     * @return mixed
     */
    public function getHits()
    {
        return $this->hits;
    }

    /**
     * @return mixed
     */
    public function getShots()
    {
        return $this->shots;
    }

    /**
     * @return mixed
     */
    public function getShotPct()
    {
        return $this->shotPct;
    }

    /**
     * @return mixed
     */
    public function getGoalStreak()
    {
        return $this->goalStreak;
    }

    /**
     * @return mixed
     */
    public function getPointStreak()
    {
        return $this->pointStreak;
    }

    /**
     * @param mixed $team
     */
    public function setTeam($team)
    {
        $this->team = $team;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @param boolean $rookieStatus
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
     * @param mixed $goals
     */
    public function setGoals($goals)
    {
        $this->goals = $goals;
    }

    /**
     * @param mixed $assists
     */
    public function setAssists($assists)
    {
        $this->assists = $assists;
    }

    /**
     * @param mixed $points
     */
    public function setPoints($points)
    {
        $this->points = $points;
    }

    /**
     * @param mixed $plusMinus
     */
    public function setPlusMinus($plusMinus)
    {
        $this->plusMinus = $plusMinus;
    }

    /**
     * @param mixed $pim
     */
    public function setPim($pim)
    {
        $this->pim = $pim;
    }

    /**
     * @param mixed $ppg
     */
    public function setPpg($ppg)
    {
        $this->ppg = $ppg;
    }

    /**
     * @param mixed $shg
     */
    public function setShg($shg)
    {
        $this->shg = $shg;
    }

    /**
     * @param mixed $gwg
     */
    public function setGwg($gwg)
    {
        $this->gwg = $gwg;
    }

    /**
     * @param mixed $gtg
     */
    public function setGtg($gtg)
    {
        $this->gtg = $gtg;
    }

    /**
     * @param mixed $hits
     */
    public function setHits($hits)
    {
        $this->hits = $hits;
    }

    /**
     * @param mixed $shots
     */
    public function setShots($shots)
    {
        $this->shots = $shots;
    }

    /**
     * @param mixed $shotPct
     */
    public function setShotPct($shotPct)
    {
        $this->shotPct = $shotPct;
    }

    /**
     * @param mixed $goalStreak
     */
    public function setGoalStreak($goalStreak)
    {
        $this->goalStreak = $goalStreak;
    }

    /**
     * @param mixed $pointStreak
     */
    public function setPointStreak($pointStreak)
    {
        $this->pointStreak = $pointStreak;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
    
    
}


