<?php
require_once __DIR__.'/../baseConfig.php';
include_once FS_ROOT.'classes/TeamHolder.php';

class TeamAbbrHolder {
    var $teamAbbrArray = array();
    
    public function __construct(string $teamScoringFile) {
       
        if(!file_exists($teamScoringFile)) {
            throw new InvalidArgumentException('Scoring File does not exist');
        }
        
        $b = 0;
        $d = 0;
        $curTeam = null;
        $teamSearchHtml = 'A NAME=';
        $contents = file($teamScoringFile);
        foreach ($contents as $cle => $val) {
            
            $val = utf8_encode($val);
            //signifies the start of new team line. (but not the first team)
            if (substr_count($val, '</PRE><BR>') && $b) {
                $d = 0;
                
                //only reset team if getting all teams
                $curTeam = null;
            }
            //if (substr_count($val, 'A NAME=' . $searchTeam) && $d) {
            //  if (substr_count($val, 'A NAME=') && $d && !isset($curTeam)) {
            if (substr_count($val, $teamSearchHtml) && $d && !isset($curTeam)) {

                $pos = strpos($val, '</A>');
                $pos = $pos - 23;
                $curTeam = substr($val, 23, $pos);
                $b = 1;

                //if(isset($searchTeam) && $curTeam != $searchTeam) continue;
                
            }
            if($b == 1 && $d == 1) {
                $reste = trim($val);
                $reste = trim(substr($reste, strpos($reste, ' ')));
                $reste = trim(substr($reste, strpos($reste, ' ')));
                if(substr($reste, 0, 1) == '*') {
                    $reste = trim(substr($reste, 1));
                }
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                
                $teamAbbr = trim(substr($reste, strrpos($reste, ' ')));

                if(!empty($teamAbbr)){
                    //add first record to array and then set team to null to skip the rest of the players (only need once per team)
                    $this->teamAbbrArray[$curTeam] = $teamAbbr;
                    
                    $curTeam = null;
                }

            }
            if($b == 1 && substr_count($val, 'PCTG')) {
                $d = 1;
            }
            
            //restart loop if current team not set.
            //will be reset to null everytime the start of a new team is finished processing.
            if (!isset($curTeam)) {
                $b = 0;
                $d = 1;
            }
        }
        
    }
    
    public function getAbbr(string $teamName){
        //return $this->teamAbbrArray[$teamName];
        return isset($this->teamAbbrArray[$teamName]) ? $this->teamAbbrArray[$teamName] : null;
    }
    
    public function getTeamName(string $teamAbbr){
        return array_search ($teamAbbr, $this->teamAbbrArray);
    }
    
}


