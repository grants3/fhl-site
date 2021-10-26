<?php
if(count(get_included_files()) ==1) die(header('HTTP/1.1 404 Not Found')); //must be included 

require_once __DIR__.'/../config.php';
include_once FS_ROOT.'fileUtils.php';
include_once FS_ROOT.'model/Model.php';
include_once FS_ROOT.'classes/ScheduleObj.php';
include_once FS_ROOT.'classes/ScheduleHolder.php';


class ScheduleModel {//implements Model{
    
    //cache by season id.
    private $season = array();
    
    public function __construct(){
        
    }
    
    function findBySeason($seasonId = null, $seasonType = null, $team = null) : ScheduleHolder{

        //already processed. we want to use previous cached result
        if(isset($this->season[$seasonId])) return $this->season[$seasonId];

        $fileName = _getLeagueFile('Schedule', $seasonType, $seasonId);
        
        if(!file_exists($fileName)) {
            throw new \Exception('Schedule file not found. seasonType='.$seasonType.' seasonId='.$seasonId);
        }
        
        $holder = new ScheduleHolder($fileName, $team);

        $this->season[$seasonId] = $holder;

        return $holder;
    }

   

}

