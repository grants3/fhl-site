<?php

class TeamInfo
{
    var $wins = 0;
    private $gp = 0;
    private $losses= 0;
    private $ties= 0;
    private $otlosses= 0;
    private $points= 0;
    private $goalsFor= 0;
    private $goalsAgainst= 0;
    private $conference = '';
    private $place = 0;
    private $pct = '';
    private $last10='';
    private $streak='';
    private $arena='';

    public function __construct(string $standingsFile, string $team, string $seasonType=null, $seasonId = null) {
        
        //$fileName = getLeagueFile2($rootFolder, $playoff, 'Standings.html', 'Standings', 'Farm'); // exclude farm
        //$fileName = getLeagueFile('Standings','',0,'Farm'); // exclude farm
        
        $e = 0;
        
        if (file_exists($standingsFile)) {
            $contents = file($standingsFile);
            $placeCount = 1;

            foreach ($contents as $cle => $val) {
                $val = utf8_encode($val);
                
                
                if (substr_count($val, 'Conference') && !substr_count($val, 'By Conference')) {
                    $reste = trim($val);
                    $reste = trim(substr($reste, strpos($reste, '>') + 1));
                    $conf = substr($reste, 0, strpos($reste, '</H3>'));
                    $placeCount = 1;
                }
                
                if (substr_count($val, 'HREF=')) {

                    
                    $reste = trim($val);

                    if(substr_count($val, '<HR')){
                        $reste = trim(substr($reste, strposX($reste, '>',2) + 1));
                    }else{
                        $reste = trim(substr($reste, strpos($reste, '>') + 1));
                    }

                    $equipe = substr($reste, 0, strpos($reste, '</A>'));

                    if($equipe != $team){

                 
                        $placeCount++;
                        
               
                        
                        continue;
                    }
                    
                    $reste = trim(substr($reste, strpos($reste, '</A>') + 4));
                    
                    $pj = substr($reste, 0, strpos($reste, ' '));
                    $reste = trim(substr($reste, strpos($reste, ' ')));
                    $standingsW = substr($reste, 0, strpos($reste, ' '));
                    $reste = trim(substr($reste, strpos($reste, ' ')));
                    $standingsL = substr($reste, 0, strpos($reste, ' '));
                    $reste = trim(substr($reste, strpos($reste, ' ')));
                    $standingsT = substr($reste, 0, strpos($reste, ' '));
                    $reste = trim(substr($reste, strpos($reste, ' ')));
                    
                    $standingsOL=0;
                    if ($e == 1) {
                        $standingsOL = substr($reste, 0, strpos($reste, ' '));
                        $reste = trim(substr($reste, strpos($reste, ' ')));
                    }
                    $standingsPts = substr($reste, 0, strpos($reste, ' '));
                    $reste = trim(substr($reste, strpos($reste, ' ')));
                    $standingsGF = substr($reste, 0, strpos($reste, ' '));
                    $reste = trim(substr($reste, strpos($reste, ' ')));
                    $standingsGA = substr($reste, 0, strpos($reste, ' '));
                    $reste = trim(substr($reste, strpos($reste, ' ')));
                    $reste = trim(substr($reste, strpos($reste, ' ')));
                    //$standingsDiff = $standingsGF - $standingsGA;
                    $standingsPCT = substr($reste, 0, strpos($reste, ' '));
                    $reste = trim(substr($reste, strpos($reste, ' ')));
                    for ($z = 0; $z < 9; $z ++) {
                        $reste = trim(substr($reste, strpos($reste, ' ')));
                    }
                    $standingsL10 = substr($reste, 0, strpos($reste, ' '));
                    $reste = trim(substr($reste, strpos($reste, ' ')));
                    $standingsSTK = $reste;
                    
                    $this->gp = $pj;
                    $this->wins = $standingsW;
                    $this->losses = $standingsL;
                    $this->ties = $standingsT;
                    $this->otlosses = $standingsOL;
                    $this->points = $standingsPts;
                    $this->goalsFor = $standingsGF;
                    $this->goalsAgainst = $standingsGA;
                    $this->conference = $conf;
                    $this->place = $placeCount;
                    $this->pct = $standingsPCT;
                    $this->last10 = $standingsL10;
                    $this->streak = $standingsSTK;
                    
                    break;
                }
            }
            
            
        } 

        $a = 0;
        $b = 0;
        $c = 1;
        $d = 1;
        $e = 0;
        $i = 0;
        $j = 0;
        $k = 0;
        //$financeFileName = getLeagueFile($rootFolder, $playoff, 'Finance.html', 'Finance'); // exclude farm
        $financeFileName = getCurrentLeagueFile('Finance');
        if (file_exists($financeFileName)) {
            $tableau = file($financeFileName);

            while (list ($cle, $val) = myEach($tableau)) {
                $val = utf8_encode($val);
                
                if(substr_count($val, 'A NAME='.$team) && $d) {
                    $pos = strpos($val, '</A>');
                    $pos = $pos - 23;
                    $equipe = substr($val, 23, $pos);
                    $b = 1;
                    
                }
                
                if(substr_count($val, 'Arena') && $b && $d) {
                    $this->arena = trim(substr($val, 52, 30));

                    break;
                }
            }
            
        }
    }
    /**
     * @return <number, string>
     */
    public function getWins()
    {
        return $this->wins;
    }

    /**
     * @return  <number, string>
     */
    public function getLosses()
    {
        return $this->losses;
    }

    /**
     * @return  <number, string>
     */
    public function getTies()
    {
        return $this->ties;
    }

    /**
     * @return  <number, string>
     */
    public function getOtlosses()
    {
        return $this->otlosses;
    }

    /**
     * @return  <number, string>
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @return  <number, string>
     */
    public function getGoalsFor()
    {
        return $this->goalsFor;
    }

    /**
     * @return  <number, string>
     */
    public function getGoalsAgainst()
    {
        return $this->goalsAgainst;
    }

    /**
     * @param Ambigous <number, string> $wins
     */
    public function setWins($wins)
    {
        $this->wins = $wins;
    }

    /**
     * @param Ambigous <number, string> $losses
     */
    public function setLosses($losses)
    {
        $this->losses = $losses;
    }

    /**
     * @param Ambigous <number, string> $ties
     */
    public function setTies($ties)
    {
        $this->ties = $ties;
    }

    /**
     * @param Ambigous <number, string> $otlosses
     */
    public function setOtlosses($otlosses)
    {
        $this->otlosses = $otlosses;
    }

    /**
     * @param Ambigous <number, string> $points
     */
    public function setPoints($points)
    {
        $this->points = $points;
    }

    /**
     * @param Ambigous <number, string> $goalsFor
     */
    public function setGoalsFor($goalsFor)
    {
        $this->goalsFor = $goalsFor;
    }

    /**
     * @param Ambigous <number, string> $goalsAgainst
     */
    public function setGoalsAgainst($goalsAgainst)
    {
        $this->goalsAgainst = $goalsAgainst;
    }
    /**
     * @return string
     */
    public function getConference()
    {
        return $this->conference;
    }
    
    public function getConferenceSafeString()
    {
        if (substr_count($this->conference, 'EAST')) {
            return 'EAST';
        }else if(substr_count($this->conference, 'WEST')) {
            return 'WEST';
        }
        
        return $this->conference;
    }

    /**
     * @return number
     */
    public function getPlace()
    {
        return $this->place;
    }
    
    public function getPlaceString()
    {
       
        $abbr = 'th';
        
        if($this->place == 1){
            $abbr = 'st';
        }else if($this->place == 2){
            $abbr = 'nd';
        }else if ($this->place == 3){
            $abbr = 'rd';
        }
        
        return $this->place.$abbr;
    }

    /**
     * @param string $conference
     */
    public function setConference($conference)
    {
        $this->conference = $conference;
    }

    /**
     * @param number $place
     */
    public function setPlace($place)
    {
        $this->place = $place;
    }
    /**
     * @return string
     */
    public function getPct()
    {
        return $this->pct;
    }

    /**
     * @return string
     */
    public function getLast10()
    {
        return $this->last10;
    }

    /**
     * @return string
     */
    public function getStreak()
    {
        return $this->streak;
    }

    /**
     * @param string $pct
     */
    public function setPct($pct)
    {
        $this->pct = $pct;
    }

    /**
     * @param string $last10
     */
    public function setLast10($last10)
    {
        $this->last10 = $last10;
    }

    /**
     * @param string $streak
     */
    public function setStreak($streak)
    {
        $this->streak = $streak;
    }
    /**
     * @return string
     */
    public function getArena()
    {
        return $this->arena;
    }

    /**
     * @return <number, string>
     */
    public function getGp()
    {
        return $this->gp;
    }


    
   
}


?>


