<?php

//line length = 31
//pos1 = homeId
//pos2 = home score
//pos3 = away 1
//pos4 = away score
//pos7 = game number counter?
//pos13 = ot

/*
 * Parse schedule info from sim schedule(scx) file.
 */
class ScheduleHolder2  implements \JsonSerializable{
    
    private $schedule = array();
    private $lastDayPlayed = 0;
    private $lastGamePlayed = 0;
    private $totalSimDays = 0;
    
    public function __construct(string $file) {
        if(!file_exists($file)) {
            throw new InvalidArgumentException('File does not exist');
        }

        $handle = fopen ($file, "r");
        $load_contents = '';
        
        while (!feof($handle)) {
            $load_contents .= fread($handle, 8192);
        }
        fclose ($handle);
        $hex = bin2hex($load_contents);
        
        $teamArray = array();
        $game = 1;
        $day = 1;
        for($x=0;$x<strlen($hex);$x=$x+62) {
            $homeTeamId = hexdec(substr($hex, $x, 2));
            $homeScore = hexdec(substr($hex, $x+2, 2));
            $awayTeamId = hexdec(substr($hex, $x+4, 2));
            $awayScore = hexdec(substr($hex, $x+6, 2));
            $counter = hexdec(substr($hex, $x+12, 2));
            $isOt = hexdec(substr($hex, $x+24, 2));
            
            if($homeScore > 0 || $homeScore > 0 ||  $isOt == 1){
                $this->lastDayPlayed = $day;
                $this->lastGamePlayed = $game;
            }
            
            if (in_array($homeTeamId, $teamArray) || in_array($awayTeamId, $teamArray)) {
                $day++;
                $teamArray = array();
            }
            
            array_push($teamArray, $homeTeamId, $awayTeamId);
            
            $scheduleTemp = array();
            $scheduleTemp['GAME'] = $game;
            $scheduleTemp['HOME'] = $homeTeamId;
            $scheduleTemp['HOMESCORE'] = $homeScore;
            $scheduleTemp['AWAY'] = $awayTeamId;
            $scheduleTemp['AWAYSCORE'] = $awayScore;
            $scheduleTemp['COUNTER'] = $counter;
            $scheduleTemp['OT'] = $isOt;
            $scheduleTemp['DAY'] = $day;
            
            array_push($this->schedule, $scheduleTemp);

            $game++;
              

        }
        
        $this->totalSimDays = $day;
       
        
        
    }
    
    
    
    /**
     * @return multitype:
     */
    public function getSchedule() : array
    {
        return $this->schedule;
    }

    /**
     * @return number
     */
    public function getLastDayPlayed():int
    {
        return $this->lastDayPlayed;
    }

    public function isSeasonStarted() :bool
    {
        return $this->lastDayPlayed > 0;
    }
    
    public function isSeasonOver() :bool
    {
        return $this->isSeasonStarted() && $this->lastDayPlayed == $this->totalSimDays;
    }

    /**
     * @return number
     */
    public function getLastGamePlayed() :int
    {
        return $this->lastGamePlayed;
    }

    /**
     * @return number
     */
    public function getTotalSimDays()
    {
        return $this->totalSimDays;
    }
    
    public function playsInDays($teamId, int $days) : bool{
        $searchDay = $this->getLastDayPlayed() + $days;
        //error_log('search day:'.$searchDay.' for teamid='.$teamId);
        foreach($this->schedule as $sched){
            if($sched['DAY'] == $searchDay){
                if($sched['HOME'] == $teamId || $sched['AWAY'] == $teamId){
                    return true;
                }
            }
        }
        
        return false;
    }
    
    public function getGameByTeamAndDay($teamId, int $searchDay){

        //error_log('search day:'.$searchDay.' for teamid='.$teamId);
        foreach($this->schedule as $sched){
            if($sched['DAY'] == $searchDay){
                if($sched['HOME'] == $teamId || $sched['AWAY'] == $teamId){
                    return $sched;
                }
            }
        }
        
        return null;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
