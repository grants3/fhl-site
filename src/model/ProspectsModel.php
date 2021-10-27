<?php
if(count(get_included_files()) ==1) die(header('HTTP/1.1 404 Not Found')); //must be included 

require_once __DIR__.'/../config.php';
include_once FS_ROOT.'fileUtils.php';
include_once FS_ROOT.'model/Model.php';
include_once FS_ROOT.'classes/ProspectObj.php';
include_once FS_ROOT.'classes/ProspectHolder.php';
include_once FS_ROOT.'classes/SimFileNotFoundException.php';

class ProspectsModel {//implements Model{
    
    //cache by season id.
    private $seasons = array();
    
    public function __construct(){
        
    }
    
    function findBySeason($seasonId = null, $seasonType = null, $team = null) : ProspectHolder{
        
        //already processed. we want to use previous cached result
        if(isset($this->seasons[$seasonId])) return $this->seasons[$seasonId];
        
        $fileName = _getLeagueFile('Futures', $seasonType, $seasonId);
        
        if(!file_exists($fileName)) {
            throw new SimFileNotFoundException('Futures not found. seasonType='.$seasonType.' seasonId='.$seasonId);
        }
        
        $holder = new ProspectHolder($fileName,$team);
        
        $this->seasons[$seasonId] = $holder;
        
        return $holder;
    }
    
    
    
}