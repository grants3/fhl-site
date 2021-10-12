<?php

//namespace classes;

//include_once 'common.php';
require_once __DIR__.'/../baseConfig.php';

require_once FS_ROOT.'classes/ScoringObj.php';
require_once FS_ROOT.'classes/ScoringGoalieObj.php';

class ScoringHolder{
    
    private $lastUpdated;
    private $skaters = array();
    private $goalies = array();
    private $shootoutMode = false;
    
    private $filteredSkaters;
    private $filteredGoalies;
    
    public function __construct(string $teamScoringFile, string $searchTeam = null) {
        
        if(!file_exists($teamScoringFile)) {
            throw new \InvalidArgumentException('Team scoring File does not exist at: '.$teamScoringFile);
        }

        $contents = file($teamScoringFile);

        $b = 0;
        $c = 1;
        $d = 1;
        $e = 0;
        $f = 0;
        $curTeam = null;
        
        $teamSearchHtml = 'A NAME=';
        if(isset($searchTeam)) $teamSearchHtml = 'A NAME='.$searchTeam;

        foreach ($contents as $cle => $val) {
            $val = utf8_encode($val);
            if (substr_count($val, '<P>(As of')) {
                $pos = strpos($val, ')');
                $pos = $pos - 10;
                $val = substr($val, 10, $pos);

                $this->lastUpdated = $val;

            }
            
            //signifies the start of new team line. (but not the first team)
            if (substr_count($val, '</PRE><BR>') && $b) {
                $d = 0;
             
                //only reset team if getting all teams
                if(!isset($searchTeam)) $curTeam = null;
            }
            //if (substr_count($val, 'A NAME=' . $searchTeam) && $d) {
          //  if (substr_count($val, 'A NAME=') && $d && !isset($curTeam)) {
            if (substr_count($val, $teamSearchHtml) && $d && !isset($curTeam)) {
                

   
                $pos = strpos($val, '</A>');
                $pos = $pos - 23;
                $curTeam = substr($val, 23, $pos);
                $b = 1;
                
                if(isset($searchTeam) && $curTeam != $searchTeam) continue;
                
            }
            
            //team scoring start (stats including goalies)
            if ($b && $d && substr_count($val, '------------')) {
                $e = 0;
                $c = 1;
            }
            
            //individual scorer stats, will loop here until completed all the rows.
            if ($b && $d && $e) {
                if ($c == 1)
                    $c = 2;
                else
                    $c = 1;
                $reste = trim($val);
                if (substr_count($val, '                         ')) {
                    $tmpFwdPosition = '';
                    $tmpFwdNumber = '';
                    $tmpFwdRookie = '';
                    $tmpFwdName = '';
                } else {
                    $tmpFwdPosition = substr($reste, 0, strpos($reste, ' '));
                    $reste = trim(substr($reste, strpos($reste, ' ')));
                    $tmpFwdNumber = substr($reste, 0, strpos($reste, ' '));
                    $reste = trim(substr($reste, strpos($reste, ' ')));
                    if (substr($reste, 0, 1) == '*') {
                        $tmpFwdRookie = substr($reste, 0, 1);
                        $reste = trim(substr($reste, 1));
                    } else
                        $tmpFwdRookie = '';
                    $tmpFwdHT2 = 0;
                }
                $tmpFwdPS = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $tmpFwdGS = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $tmpFwdPCTG = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $tmpFwdS = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $tmpFwdHT = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $tmpFwdGT = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $tmpFwdGW = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $tmpFwdSHG = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $tmpFwdPPG = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $tmpFwdPIM = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $tmpFwdDiff = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $tmpFwdP = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $tmpFwdA = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $tmpFwdG = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $tmpFwdGP = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $tmpFwdTeam = substr($reste, strrpos($reste, ' '));
                if (! substr_count($val, '                         ')) {
                    $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                    $tmpFwdName = $reste;
                    if (substr_count($tmpFwdName, 'xtrastats.html')) {
                        $tmpFwdName = trim(substr($tmpFwdName, strpos($tmpFwdName, '"') + 1, strpos($tmpFwdName, '>') - 1 - strpos($tmpFwdName, '"') - 1));
                    }
                }
                $tmpVal = $contents[$cle + 1];
                if (substr_count($tmpVal, '                         ') || (! substr_count($val, '                         ') && ! substr_count($tmpVal, '                         '))) {
                    $tmpFwdHT2 += $tmpFwdHT;
                } else
                    $tmpFwdHT = $tmpFwdHT2;

                //fix position
                if('R' == $tmpFwdPosition) $tmpFwdPosition = 'RW';
                if('L' == $tmpFwdPosition) $tmpFwdPosition = 'LW';

                $scoring = new ScoringPlayerObj();
                
                $scoring->setNumber($tmpFwdNumber);
                $scoring->setTeam($curTeam);
                $scoring->setTeamAbbr($tmpFwdTeam); //team state line by abbreviate (can have multiple lines)
                $scoring->setPosition($tmpFwdPosition);
                if($tmpFwdRookie == '*') $scoring->setRookieStatus(true);
                $scoring->setName($tmpFwdName);
                $scoring->setGamesPlayed($tmpFwdGP);
                $scoring->setGoals($tmpFwdG);
                $scoring->setAssists($tmpFwdA);
                $scoring->setPoints($tmpFwdP);
                $scoring->setPlusMinus($tmpFwdDiff);
                $scoring->setPim($tmpFwdPIM);
                $scoring->setPpg($tmpFwdPPG);
                $scoring->setShg($tmpFwdSHG);
                $scoring->setGwg($tmpFwdGW);
                $scoring->setGtg($tmpFwdGT);
                $scoring->setHits($tmpFwdHT);
                $scoring->setShots($tmpFwdS);
                $scoring->setShotPct($tmpFwdPCTG);
                $scoring->setGoalStreak($tmpFwdGS);
                $scoring->setPointStreak($tmpFwdPS);
                
                array_push($this->skaters, $scoring);
                
            }
            
            //goalie stats start 
            if ($b && $d && substr_count($val, '------------')) {
                $f = 0;
            }
            //individual goalies stats, will loop here until completed all the rows.
            if ($b && $d && $f) {
                if ($c == 1)
                    $c = 2;
                else
                    $c = 1;
                $reste = trim($val);
                if (substr_count($val, '                         ')) {
                    $tmpGoalPosition = '';
                    $tmpGoalNumber = '';
                    $tmpGoalRookie = '';
                    $tmpGoalName = '';
                } else {
                    $tmpGoalPosition = 'G';
                    $tmpGoalNumber = substr($reste, 0, strpos($reste, ' '));
                    $reste = trim(substr($reste, strpos($reste, ' ')));
                    if (substr($reste, 0, 1) == '*') {
                        $tmpGoalRookie = substr($reste, 0, 1);
                        $reste = trim(substr($reste, 1));
                    } else
                        $tmpGoalRookie = '';
                }
                $tmpGoalAS = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $tmpGoalPIM = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $tmpGoalPCT = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $tmpGoalSA = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $tmpGoalGA = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $tmpGoalSO = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $tmpGoalT = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $tmpGoalL = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $tmpGoalW = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $tmpGoalAVG = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $tmpGoalMin = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $tmpGoalGP = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $tmpGoalTeam = substr($reste, strrpos($reste, ' '));
                if (! substr_count($val, '                         ')) {
                    $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                    $tmpGoalName = $reste;
                    if (substr_count($tmpGoalName, 'xtrastats.html')) {
                        $tmpGoalName = trim(substr($tmpGoalName, strpos($tmpGoalName, '"') + 1, strpos($tmpGoalName, '>') - 1 - strpos($tmpGoalName, '"') - 1));
                    }
                }

                
                
                $goalie = new ScoringGoalieObj();
                $goalie->setNumber($tmpGoalNumber);
                $goalie->setTeam($curTeam);
                $goalie->setTeamAbbr($tmpGoalTeam); //team state line by abbreviate (can have multiple lines)
                $goalie->setPosition($tmpGoalPosition);
                if($tmpGoalRookie == '*') $scoring->setRookieStatus(true);
                $goalie->setName($tmpGoalName);
                $goalie->setGamesPlayed($tmpGoalGP);
                
                $goalie->setMinutes($tmpGoalMin);
                $goalie->setGaa($tmpGoalAVG);
                $goalie->setWins($tmpGoalW);
                $goalie->setLosses($tmpGoalL);
                $goalie->setTies($tmpGoalT);
                $goalie->setShutouts($tmpGoalSO);
                $goalie->setGoalsAgainst($tmpGoalGA);
                $goalie->setSavesAttempted($tmpGoalSA);
                $goalie->setSavePct($tmpGoalPCT);
                
                $goalie->setPim($tmpGoalPIM);
                $goalie->setAssists($tmpGoalAS);
                  
                array_push($this->goalies, $goalie);
            }

            
            if ($b && $d && substr_count($val, 'PCTG')) {
                $e = 1;
                //start of plyaer scoring
            }
            if ($b && $d && substr_count($val, 'AVG')) {
                $f = 1;
                
                if(substr_count($val, 'OT') > 0){
                    $this->shootoutMode=true;
                }
                    
                //start of goalie scoring
            }
            
            
            //restart loop if current team not set.
            //will be reset to null everytime the start of a new team is found above. 
            if (!isset($curTeam)) {
                $b = 0;
                $c = 1;
                $d = 1;
                $e = 0;
                $f = 0;
            }

        }

        //end;

    }
    
    /**
     * @return mixed
     */
    public function getLastUpdated() : string
    {
        return $this->lastUpdated;
    }

    /**
     * @return multitype:
     */
    public function getSkaters()  : array
    {
        return $this->skaters;
    }

    /**
     * @return multitype:
     */
    public function getGoalies()  : array
    {
        return $this->goalies;
    }

    public function getAll()  : array
    {
        return array_merge($this->getSkaters(),  $this->getGoalies()); 
    }
    
    /**
     * @return boolean
     */
    public function isShootoutMode()
    {
        return $this->shootoutMode;
    }
       
    public function getFilteredSkaters(){
        if(isset($this->filteredSkaters)){
            return $this->filteredSkaters;
        }
        
        $this->filteredSkaters = $this->getFiltered($this->getSkaters());
        
        return $this->filteredSkaters;
    }
    
    public function getFilteredGoalies(){
        if(isset($this->filteredGoalies)){
            return $this->filteredGoalies;
        }
        
        $this->filteredGoalies = $this->getFiltered($this->getGoalies());
        
        return $this->filteredGoalies;
    }
    /*
     * we want to accumulate stats and only include totals.
     * This will cache on the first time it runs. Subsequent calls will get the cached array.
     */
    public function getFiltered(array $players){
        
//         if(isset($this->filteredSkaters)){
//             return $this->filteredSkaters;
//         }
        
        $buffered = null;
        $result = array();
        foreach($players as $ps){
            
            if(isset($buffered)){
                if(!IsNullOrEmptyString($ps->getName())){
                    array_push($result, $buffered);
                    $buffered = $ps;
                }else if($ps->getTeamAbbr() == 'TOT'){
                    $ps->setTeamAbbr($buffered->getTeamAbbr());
                    $ps->setName($buffered->getName());
                    $ps->setPosition($buffered->getPosition());
                    $ps->setNumber($buffered->getNumber());
                    
                    array_push($result, $ps);
                    $buffered = null;
                }else{
                    //skip blank rows (partial team stats)
                }
            }else{
                $buffered = $ps;
            }
        }
        //get last buffered entry
        if(isset($buffered)){
            array_push($result, $buffered);
        }
        
//         if(!isset($this->filteredSkaters)){
//             $this->filteredSkaters = $result;
//         }
        
        return $result;
    }

    public function findSkater(string $name){
        return array_search($name, $this->getSkaters());
    }
    
    public function findGoalie(string $name){
        return array_search($name, $this->getGoalies());
    }
}

?>