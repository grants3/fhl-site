<?php
if(count(get_included_files()) ==1) die(header('HTTP/1.1 404 Not Found')); //must be included 

require_once __DIR__.'/../config.php';
include_once FS_ROOT.'fileUtils.php';
include_once FS_ROOT.'model/Model.php';
include_once FS_ROOT.'classes/RosterObj.php';
include_once FS_ROOT.'classes/RosterAvgObj.php';
include_once FS_ROOT.'classes/RostersHolder.php';


class RostersModel {//implements Model{
    
    //cache by season id.
    private $seasonRoster = array();
    
    public function __construct(){
        
    }
    
    function findBySeason($seasonId, $seasonType, $team, $generateAvg = true) : RostersHolder{

        //already processed. we want to use previous cached result
        if(isset($this->seasonRoster[$seasonId])) return $this->seasonRoster[$seasonId];

        $fileName = _getLeagueFile('Rosters', $seasonType, $seasonId);
        
        if(!file_exists($fileName)) {
            throw new \Exception('Rosters not found. seasonType='.$seasonType.' seasonId='.$seasonId);
        }
        
        $rostersHolder = new RostersHolder($fileName,$team);

        $this->seasonRoster[$seasonId] = $rostersHolder;

        return $rostersHolder;
    }

   

}

