<?php   

require_once __DIR__.'/../config.php';
include_once FS_ROOT.'common.php';
include_once FS_ROOT.'fileUtils.php';
include_once FS_ROOT.'model/Model.php';
include_once FS_ROOT.'classes/ScoringHolder.php';
include_once FS_ROOT.'classes/ScoringPlayerObj.php';
include_once FS_ROOT.'classes/ScoringGoalieObj.php';
include_once FS_ROOT.'classes/ScoringObj.php';
include_once FS_ROOT.'classes/ScoringAccumulator.php';


class PlayerStatsModel {//implements Model{
    
    //cache of stats by season id.
    private $seasonStats = array();
    
    public function __construct(){
        
    }
    
    function findBySeason($seasonId, $seasonType) : ScoringHolder{

        //already processed. we want to use previous cached result
        if(isset($this->seasonStats[$seasonId])) return $this->seasonStats[$seasonId];

        $fileName = _getLeagueFile('TeamScoring', $seasonType, $seasonId);
        
        if(!file_exists($fileName)) {
            throw new \Exception('Team scoring not found. seasonType='.$seasonType.' seasonId='.$seasonId);
        }
        
        $scoringHolder = new ScoringHolder($fileName);
        
        $this->seasonStats[$seasonId] = $scoringHolder;

        return $scoringHolder;
    }

   

}

