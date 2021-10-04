<?php
require_once __DIR__.'/../baseConfig.php';
include_once FS_ROOT.'classes/TeamHolder.php';

if(!function_exists('search')) {
    function search($Fnm,$currentTeam) {
        $b = 0;
        $d = 0;
        $contents = file($Fnm);
        foreach ($contents as $cle => $val) {
           
            $val = utf8_encode($val);
            if(substr_count($val, 'A NAME='.$currentTeam)) {
                $b = 1;
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
                return $TSabbr = trim(substr($reste, strrpos($reste, ' ')));
            }
            if($b == 1 && substr_count($val, 'PCTG')) {
                $d = 1;
            }
        }
    }
}

class TeamAbbrHolder {
    var $teamAbbrArray = array();

    public function __construct(string $gmFile, string $teamScoringFile) {

        //init TeamHolder;
        $teamHolder = new TeamHolder($gmFile);

        foreach ($teamHolder->get_teams() as $team) {
        $this->teamAbbrArray[$team] = search($teamScoringFile,$team);
        }

    }

    public function getAbbr(string $teamName){
        return $this->teamAbbrArray[$teamName];
    }
    
    public function getTeamName(string $teamAbbr){
        return array_search ($teamAbbr, $this->teamAbbrArray);
    }
    
}


