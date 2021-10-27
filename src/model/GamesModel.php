<?php
if(count(get_included_files()) ==1) die(header('HTTP/1.1 404 Not Found')); //must be included 

require_once __DIR__.'/../config.php';
include_once FS_ROOT.'fileUtils.php';
include_once FS_ROOT.'model/Model.php';
include_once FS_ROOT.'classes/GameHolder.php';
include_once FS_ROOT.'classes/SimFileNotFoundException.php';

class GamesModel {//implements Model{
    
    //cache by season id.
    private $season = array();
    
    public function __construct(){
        
    }
    
    function findGame($matchNumber, $seasonId, $round) : GameHolder{

        //already processed. we want to use previous cached result
        if(isset($this->season[$matchNumber.'-'.$seasonId.'-'.$round])) return $this->season[$matchNumber.'-'.$seasonId.'-'.$round];

        $fileName = getGameFile($matchNumber, $seasonId, $round);
        
        if(!file_exists($fileName)) {
            throw new SimFileNotFoundException('Game file not found. seasonId='.$seasonId.' round='.$round);
        }
        
        $holder = new GameHolder($fileName, $matchNumber, $seasonId, $round);

        $this->season[$matchNumber.'-'.$seasonId.'-'.$round] = $holder;

        return $holder;
    }

   

}

