<?php

require_once __DIR__.'/../baseConfig.php';
require_once FS_ROOT.'classes/ScoringHolder.php';
require_once FS_ROOT.'classes/ScoringPlayerObj.php';
require_once FS_ROOT.'classes/ScoringGoalieObj.php';
require_once FS_ROOT.'classes/ScoringObj.php';
include_once FS_ROOT.'classes/TeamAbbrHolder.php';

class ScoringAccumulator
{
    private $scoringHolder;
    
    public function __construct(ScoringHolder $scoringHolder) {
        $this->scoringHolder = $scoringHolder;
    }

    public function getTopGoals(int $limit = null) 
    {
        return $this->getScorers('sortGoals', $limit);
    }
    
    public function getTopAssists(int $limit = null)
    {
        
        return $this->getScorers('sortAssists', $limit);
        
    }
    
    public function getTopPoints(int $limit = null)
    {
        
        return $this->getScorers('sortPoints', $limit);
        
    }
    
    public function getScorers(string $sortFunction, int $limit = null)
    {
        
        $skaters = $this->scoringHolder->getFilteredSkaters();
        
        usort( $skaters, $sortFunction );
        
        if(isset($limit) && $limit > 0){
            if(sizeof($skaters) > $limit){
                return array_slice($skaters, 0, $limit);
            }
        }
        
        return $skaters;
        
    }
    
   

}

function sortGoals($a, $b)
{
    return $b->goals <=> $a->goals;
}

function sortAssists($a, $b)
{
    return $b->assists <=> $a->assists;
}

function sortPoints($a, $b)
{
    return $b->points <=> $a->points;
}

