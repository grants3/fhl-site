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

    public function getTopGoals(int $limit = null, $filter = null) 
    {
        return $this->getScorers('sortGoals', $limit, $filter);
    }
    
    public function getTopAssists(int $limit = null, $filter = null)
    {
        
        return $this->getScorers('sortAssists', $limit, $filter);
        
    }
    
    public function getTopPoints(int $limit = null, $filter = null)
    {
        
        return $this->getScorers('sortPoints', $limit, $filter);
        
    }
    
    public function getTopGoalies(string $attribute, int $limit = null, string $direction = 'DESC')
    {
        $goalies = $this->scoringHolder->getFilteredGoalies();
        
        //apply 15 game filter unless nobody has reached the threshold.
        $goaliesTemp = array_filter($goalies, function($obj){
            if ($obj->getGamesPlayed() > 3) return true;
            
            return false;
        });
        
        if(!empty($goaliesTemp)){
            $goalies = $goaliesTemp;
        }
        
        usort($goalies, function($a, $b)use(&$attribute, $direction){
            if($direction == 'DESC') {
                return $b->__get($attribute) <=> $a->__get($attribute);
            }
            return $a->__get($attribute) <=> $b->__get($attribute);
            
        });
        
        if(isset($limit) && $limit > 0){
            if(sizeof($goalies) > $limit){
                return array_slice($goalies, 0, $limit);
            }
        }
        
        return $goalies;
        
    }
        
    public function getScorers(string $sortFunction, int $limit = null, string $filter = null)
    {
        $skaters = $this->scoringHolder->getFilteredSkaters();
        
        if(isset($filter)){
            $skaters = array_filter($skaters, function($obj)use(&$filter){
                if ($obj->getPosition() == $filter) return true;
                
                return false;
            });
        }

        
        usort( $skaters, $sortFunction );
        
        if(isset($limit) && $limit > 0){
            if(sizeof($skaters) > $limit){
                return array_slice($skaters, 0, $limit);
            }
        }
        
        return $skaters;
        
    }
    
   

}

// function sortByAttribute(&$terms, $meta) {
//     usort($terms, function($a, $b) use ($meta) {
//         $name_a = get_term_meta($a->term_id, 'artist_lastname', true);
//         $name_b = get_term_meta($b->term_id, 'artist_lastname', true);
//         return strcmp($name_a, $name_b);
//     });
// }

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

