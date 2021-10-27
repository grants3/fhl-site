<?php
if(count(get_included_files()) ==1) die(header('HTTP/1.1 404 Not Found')); //must be included

require_once __DIR__.'/../config.php';
include_once FS_ROOT.'common.php';
include_once FS_ROOT.'fileUtils.php';
include_once FS_ROOT.'model/Model.php';
include_once FS_ROOT.'classes/TransactionHolder.php';
include_once FS_ROOT.'classes/TransactionTradeObj.php';
include_once FS_ROOT.'classes/TransactionEventObj.php';
include_once FS_ROOT.'classes/SimFileNotFoundException.php';

class TransactionModel {//implements Model{
    
    //cache of stats by season id.
    private $season = array();
    
    public function __construct(){
        
    }
    
    function findBySeason($seasonId = null, $seasonType = null) : TransactionHolder {
        
        //already processed. we want to use previous cached result
        if(isset($this->season[$seasonId])) return $this->season[$seasonId];
        
        $fileName = _getLeagueFile('Transact', $seasonType, $seasonId);
        
        if(!file_exists($fileName)) {
            throw new SimFileNotFoundException('Transact file not found. seasonType='.$seasonType.' seasonId='.$seasonId);
        }
        
        $scoringHolder = new TransactionHolder($fileName);
        
        $this->season[$seasonId] = $scoringHolder;
        
        return $scoringHolder;
    }
    
    
    
}

