<?php   

require_once __DIR__.'/../config.php';
include_once FS_ROOT.'fileUtils.php';
include_once FS_ROOT.'model/Model.php';
include_once FS_ROOT.'classes/UnassignedObj.php';
include_once FS_ROOT.'classes/UnassignedHolder.php';


class UnassignedModel {//implements Model{
    
    //cache by season id.
    private $seasonRoster = array();
    
    public function __construct(){
        
    }
    
    function findBySeason($seasonId, $seasonType) : UnassignedHolder{

        //already processed. we want to use previous cached result
        if(isset($this->seasonRoster[$seasonId])) return $this->seasonRoster[$seasonId];

        $fileName = _getLeagueFile('Unassigned', $seasonType, $seasonId);
        
        if(!file_exists($fileName)) {
            throw new \Exception('Unassigned file not found. seasonType='.$seasonType.' seasonId='.$seasonId);
        }
        
        $holder = new UnassignedHolder($fileName);

        $this->seasonRoster[$seasonId] = $holder;

        return $holder;
    }

   

}

