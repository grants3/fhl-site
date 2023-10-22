<?php

class TradeObj implements \JsonSerializable{
    private $team1;
    private $team1Players;
    private $team1Prosepcts;
    private $team1Picks;
    private $team1Cash;
    
    private $team2;
    private $team2Players;
    private $team2Prosepcts;
    private $team2Picks;
    private $team2Cash;
    
    private $date;
    
    
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
    public function getTeam1Players()
    {
        return $this->team1Players;
    }

    /**
     * @return mixed
     */
    public function getTeam1Prosepcts()
    {
        return $this->team1Prosepcts;
    }

    /**
     * @return mixed
     */
    public function getTeam1Picks()
    {
        return $this->team1Picks;
    }

    /**
     * @return mixed
     */
    public function getTeam1Cash()
    {
        return $this->team1Cash;
    }
    
    public function getTeam1CashDisplay(){
        
        if(!$this->getTeam1Cash()) return '';
        
        if($this->getTeam1Cash() >= 1){
            return $this->getTeam1Cash().'M';
        }else{
            return ($this->getTeam1Cash() * 1000).'K';
        }
        
        
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
    public function getTeam2Players()
    {
        return $this->team2Players;
    }

    /**
     * @return mixed
     */
    public function getTeam2Prosepcts()
    {
        return $this->team2Prosepcts;
    }

    /**
     * @return mixed
     */
    public function getTeam2Picks()
    {
        return $this->team2Picks;
    }

    /**
     * @return mixed
     */
    public function getTeam2Cash()
    {
        return $this->team2Cash;
    }
    
    public function getTeam2CashDisplay(){
        
        if(!$this->getTeam2Cash()) return '';
        
        if($this->getTeam2Cash() >= 1){
            return $this->getTeam2Cash().'M';
        }else{
            return ($this->getTeam2Cash() * 1000).'K';
        }
        
        
    }

    /**
     * @param mixed $team1
     */
    public function setTeam1($team1)
    {
        $this->team1 = $team1;
    }

    /**
     * @param mixed $team1Players
     */
    public function setTeam1Players($team1Players)
    {
        $this->team1Players = $team1Players;
    }

    /**
     * @param mixed $team1Prosepcts
     */
    public function setTeam1Prosepcts($team1Prosepcts)
    {
        $this->team1Prosepcts = $team1Prosepcts;
    }

    /**
     * @param mixed $team1Picks
     */
    public function setTeam1Picks($team1Picks)
    {
        $this->team1Picks = $team1Picks;
    }

    /**
     * @param mixed $team1Cash
     */
    public function setTeam1Cash($team1Cash)
    {
        $this->team1Cash = $team1Cash;
    }

    /**
     * @param mixed $team2
     */
    public function setTeam2($team2)
    {
        $this->team2 = $team2;
    }

    /**
     * @param mixed $team2Players
     */
    public function setTeam2Players($team2Players)
    {
        $this->team2Players = $team2Players;
    }

    /**
     * @param mixed $team2Prosepcts
     */
    public function setTeam2Prosepcts($team2Prosepcts)
    {
        $this->team2Prosepcts = $team2Prosepcts;
    }

    /**
     * @param mixed $team2Picks
     */
    public function setTeam2Picks($team2Picks)
    {
        $this->team2Picks = $team2Picks;
    }

    /**
     * @param mixed $team2Cash
     */
    public function setTeam2Cash($team2Cash)
    {
        $this->team2Cash = $team2Cash;
    }
    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }
    
    public function concatTrade1(){
        
        $returnValue = $this->getTeam1Players();
        
        if($this->getTeam1Prosepcts()){
            if($returnValue) $returnValue .= ', ';
            $returnValue .= $this->getTeam1Prosepcts();
        }
        
        if($this->getTeam1Picks()){
            if($returnValue) $returnValue .= ', ';
            $returnValue .= $this->getTeam1Picks();
        }
        
        if($this->getTeam1Cash()){
            if($returnValue) $returnValue .= ', ';
            $returnValue .= $this->getTeam1CashDisplay();
        }
        
        return $returnValue;
        
    }
    
    public function concatTrade2(){
        
        $returnValue = $this->getTeam2Players();
        
        if($this->getTeam2Prosepcts()){
            if($returnValue) $returnValue .= ', ';
            $returnValue .= $this->getTeam2Prosepcts();
        }
        
        if($this->getTeam2Picks()){
            if($returnValue) $returnValue .= ', ';
            $returnValue .= $this->getTeam2Picks();
        }
        
        if($this->getTeam2Cash()){
            if($returnValue) $returnValue .= ', ';
            $returnValue .= $this->getTeam2CashDisplay();
        }
        
        return $returnValue;
        
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
    
    
    
}

