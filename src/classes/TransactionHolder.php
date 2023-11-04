<?php



class TransactionHolder implements \JsonSerializable{
    private $lastUpdated;
    private $trades = array();
    private $events = array();
    
    public static $typeInjury = 'INJ';
    public static $typeTransaction = 'TRA';
    public static $typeTrade = 'TRD';
    
    public function __construct(string $file) {

        if(!file_exists($file)) {
            throw new InvalidArgumentException('Transaction File does not exist');
        }
        
        $contents = file($file);
        
        $lastTrade = null;
        foreach ($contents as $cle => $val) {
            $val = encodeToUtf8($val);
            if(substr_count($val, '<P>(As of')){
                $this->lastUpdated = substr($val, strpos($val, '(')+7, strpos($val, ')')-strpos($val, '(')-7);
            }
            //handle transaction event (non trade)
            if(substr_count($val, '<BR><BR>')){

                $reste = substr($val, 0, strpos($val, '<BR>'));
                
                $transPlayer = '';
                $transTeam = '';
                $transStatus = '';
                $transType = TransactionHolder::$typeTransaction;
                
                // suffers injury
                if(substr_count($reste, '(') && substr_count($reste, ' suffers ')) {
                    $transPlayer = substr($reste, 0, strpos($reste, '(')-1);
                    $reste = trim(substr($reste, strpos($reste, '(')+1));
                    $transTeam = substr($reste, 0, strpos($reste, ')'));
                    $reste = trim(substr($reste, strpos($reste, ')')+1));
                    $transStatus = ucfirst($reste);
                    $transType = TransactionHolder::$typeInjury;
                }
                // returns from injury
                else if(substr_count($reste, '(') && substr_count($reste, 'returns from injury')) {
                    $transPlayer = substr($reste, 0, strpos($reste, '(')-1);
                    $reste = trim(substr($reste, strpos($reste, '(')+1));
                    $transTeam = substr($reste, 0, strpos($reste, ')'));
                    $reste = trim(substr($reste, strpos($reste, ')')+1));
                    $transStatus = ucfirst($reste);
                    $transType = TransactionHolder::$typeInjury;
                }
                // promote to pro roster
                else if(substr_count($reste, ' to pro roster')){
                    $transTeam = substr($reste, 0, strpos($reste, ' promote '));
                    $reste = trim(substr($reste, strpos($reste, ' promote ')));
                    $transStatus = ucfirst(substr($reste, 0, strpos($reste, ' ')));
                    $reste = trim(substr($reste, strpos($reste, ' ')));
                    $transPlayer = substr($reste, 0, strpos($reste, ' to '));
                    $reste = trim(substr($reste, strpos($reste, ' to ')));
                    $transStatus .= ' '.substr($reste, 0);
                }
                
                // waivers
                else if(substr_count($reste, ' place ')){
                    $transTeam = substr($reste, 0, strpos($reste, ' place '));
                    $reste = trim(substr($reste, strpos($reste, ' place ')));
                    $transStatus = ucfirst(substr($reste, 0, strpos($reste, ' ')));
                    $reste = trim(substr($reste, strpos($reste, ' ')));
                    $transPlayer = substr($reste, 0, strpos($reste, ' on '));
                    $reste = trim(substr($reste, strpos($reste, ' on ')));
                    $transStatus .= ' '.substr($reste, 0);
                }
                
                // assign to minor
                else if(substr_count($reste, ' to minors')){
                    $transTeam = substr($reste, 0, strpos($reste, ' assign '));
                    $reste = trim(substr($reste, strpos($reste, ' assign ')));
                    $transStatus = ucfirst(substr($reste, 0, strpos($reste, ' ')));
                    $reste = trim(substr($reste, strpos($reste, ' ')));
                    $transPlayer = substr($reste, 0, strpos($reste, ' to '));
                    $reste = trim(substr($reste, strpos($reste, ' to ')));
                    $transStatus .= ' '.substr($reste, 0);
                }
                // Signature
                else if(substr_count($reste, ' sign ')){
                    $transTeam = substr($reste, 0, strpos($reste, ' sign '));
                    $reste = trim(substr($reste, strpos($reste, ' sign ')));
                    $transStatus = ucfirst(substr($reste, 0, strpos($reste, ' ')));
                    $reste = trim(substr($reste, strpos($reste, ' ')));
                    $transPlayer = substr($reste, 0);
                }
                // Coatch Fire
                else if(substr_count($reste, ' fire Head Coach ')){
                    $transTeam = substr($reste, 0, strpos($reste, ' fire '));
                    $reste = trim(substr($reste, strpos($reste, ' fire ')));
                    $transStatus = ucfirst(substr($reste, 0, strpos($reste, 'Coach') + 5));
                    $reste = trim(substr($reste, strpos($reste, 'Coach') + 5));
                    $transPlayer = substr($reste, 0);
                }
                // Coatch Hire
                else if(substr_count($reste, ' hire Head Coach ')){
                    $transTeam = substr($reste, 0, strpos($reste, ' hire '));
                    $reste = trim(substr($reste, strpos($reste, ' hire ')));
                    $transStatus = ucfirst(substr($reste, 0, strpos($reste, 'Coach') + 5));
                    $reste = trim(substr($reste, strpos($reste, 'Coach') + 5));
                    $transPlayer = substr($reste, 0);
                }
                // completes suspension
                else if(substr_count($reste, 'completes suspension')){
                    $transPlayer = substr($reste, 0, strpos($reste, '(')-1);
                    $reste = trim(substr($reste, strpos($reste, '(')+1));
                    $transTeam = substr($reste, 0, strpos($reste, ')'));
                    $reste = trim(substr($reste, strpos($reste, ')')+1));
                    $transStatus = ucfirst($reste);
                }else{
                    
                }

                //$transTeam = trim($transTeam);
                
                $transEvent = new TransactionEventObj();
                $transEvent->setTeam($transTeam);
                $transEvent->setType($transType);
                $transEvent->setAction($transStatus);
                $transEvent->setValue($transPlayer);
 
                if(!empty($transStatus)) array_push($this->events, $transEvent);

            }
            //handle trade
            //each record will span two rows.    
            if(substr($val, 0, 3) == 'To '){

                $reste = substr($val, 0, strpos($val, '<BR>'));
                
                $transTeam = substr($reste, 0, strpos($reste, ':'));
                $transTeam = trim(substr($transTeam, strpos($transTeam, 'To ')+3));
                
                $reste = trim(substr($reste, strpos($reste, ':')+1));
                $transStatus = ucfirst($reste);
                
                if(!isset($lastTrade)){
                    $lastTrade = new TransactionTradeObj();
                    $lastTrade->setType(TransactionHolder::$typeTrade);
                    $lastTrade->setTeam1($transTeam);
                    $lastTrade->setToTeam1(trim($transStatus));

                }else{

                    $lastTrade->setTeam2($transTeam);
                    $lastTrade->setToTeam2(trim($transStatus));
                    
                    if(!empty($transTeam)) array_push($this->trades, $lastTrade);
                   
                    $lastTrade = null;
                }


            }
        }
        
        //reverse from newst to oldest by default
        $this->trades = array_reverse($this->trades);
        $this->events = array_reverse($this->events);
        
    }
    
 
    /**
     * @return string
     */
    public function getLastUpdated()
    {
        return $this->lastUpdated;
    }

    /**
     * @return multitype:
     */
    public function getTrades()
    {
        return $this->trades;
    }

    /**
     * @return multitype:
     */
    public function getEvents()
    {
        return $this->events;
    }
    
    public function getEventsByType(string $type)
    {
        $filteredArray = array();
        foreach($this->getEvents() as $event){
            if($event->getType() == $type){
                array_push($filteredArray, $event);
            }
        }
        
        return $filteredArray;
    }
    
    public function getTeamTrades(string $team)
    {
        
        $filteredArray = array();
        foreach($this->getTrades() as $trade){
            if($trade->getTeam1() == $team || $trade->getTeam2() == $team){
                array_push($filteredArray, $trade);
            }
        }

        return $filteredArray;
    }
    
    public function getTeamEvents(string $team, string $teamAbbr)
    {

        $filteredArray = array();
        foreach($this->getEvents() as $event){
            if($event->getTeam() == $team || $event->getTeam() == $teamAbbr){
                array_push($filteredArray, $event);
            }
        }
        
        return $filteredArray;
    }
    
    public function getTeamEventsByType(string $team, string $teamAbbr, string $type)
    {
        
        $filteredArray = array();
        foreach($this->getEvents() as $event){
            if($event->getTeam() == $team || $event->getTeam() == $teamAbbr){
                if($event->getType() == $type){
                    array_push($filteredArray, $event);
                }
                
            }
        }
        
        return $filteredArray;
    }


    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
    
}
