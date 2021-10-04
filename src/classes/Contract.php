<?php

class Contract implements \JsonSerializable{
    
    private $team;
    private $name;
    private $type;
    private $term;
    private $salary;
    private $bonus;
    private $aav;
    private $total; 
    private $date;
    
    public function __construct(string $team, string $name, string $type, int $term = 0, $salary = 0, $bonus = 0, $date) {
        $this->team = $team;
        $this->name = $name;
        $this->type = $type;
        $this->term = $term;
        $this->salary = $salary;
        $this->date = $date;
     
        if($bonus > 0){
            $aav = round(($bonus / $term) + $salary,2);
        }else{
            $aav = $salary;
            $bonus = 0;
        }
        $this->bonus = $bonus;

        $total = $aav * $term;
        
        $this->aav = $aav;
        $this->total = $total;
    }
   

    /**
     * @return string
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getTerm()
    {
        return $this->term;
    }
    
    public function getTermDisplay()
    {
        return $this->term.'Y';
    }

    /**
     * @return number
     */
    public function getSalary()
    {
        return $this->salary;
    }
    
    public function getSalaryDisplay(){
        if($this->getSalary() >= 1){
            return $this->getSalary().'M';
        }else{
            return ($this->getSalary() * 1000).'K';
        }
        
        
    }

    /**
     * @return number
     */
    public function getBonus()
    {
        return $this->bonus;
    }
    
    public function getBonusDisplay(){
        if(!$this->getBonus()){
            return '';   
        }
        
        if($this->getBonus() >= 1){
            return $this->getBonus().'M';
        }else{
            return ($this->getBonus() * 1000).'K';
        }
        
        
    }

    /**
     * @return number
     */
    public function getAav()
    {
        return $this->aav;
    }
    
    public function getAavDisplay(){
        if($this->getAav() >= 1){
            return $this->getAav().'M';
        }else{
            return ($this->getAav() * 1000).'K';
        }
        
        
    }

    /**
     * @return number
     */
    public function getTotal()
    {
        return $this->total;
    }
    
    public function getTotalDisplay(){
        if($this->getTotal() >= 1){
            return $this->getTotal().'M';
        }else{
            return ($this->getTotal() * 1000).'K';
        }
        
        
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
    
}

