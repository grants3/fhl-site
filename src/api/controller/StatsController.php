<?php
if(count(get_included_files()) ==1) die(header('HTTP/1.1 404 Not Found')); //must be included 

require_once __DIR__.'/../../baseConfig.php';
require_once FS_ROOT.'/api/controller/BaseSearchController.php';
require_once FS_ROOT.'/model/PlayerStatsModel.php';
require_once FS_ROOT.'/classes/ScoringAccumulator.php';

class StatsController extends BaseSearchController
{
    
    protected function getDataHolder(){
        $seasonId=null;
        $seasonType = null;
        $team = null;
        
        if(isset($this->getQueryStringParams()['seasonId'])) {
            $seasonId = $this->getQueryStringParams()['seasonId'];
        }
        
        if(isset($this->getQueryStringParams()['seasonType'])) {
            $seasonType = $this->getQueryStringParams()['seasonType'];
        }
        
        if(isset($this->getQueryStringParams()['team'])) {
            $team = $this->getQueryStringParams()['team'];
        }

        $model = new PlayerStatsModel();
        $holder = $model->findBySeason($seasonId, $seasonType, $team);

        return $holder;
    }
    
    public function get2(){
        
        $seasonId=null;
        $seasonType = null;
        $team = null;
        
        $model = new PlayerStatsModel();
        
        if(isset($this->getQueryStringParams()['seasonId'])) {
            $seasonId = $this->getQueryStringParams()['seasonId'];
        }
        
        if(isset($this->getQueryStringParams()['seasonType'])) {
            $seasonType = $this->getQueryStringParams()['seasonType'];
        }
        
        if(isset($this->getQueryStringParams()['team'])) {
            $team = $this->getQueryStringParams()['team'];
        }
        
        $type = null;
        if(isset($this->getQueryStringParams()['type'])) {
            $type = $this->getQueryStringParams()['type'];
        }
                
        $data = $this->getData(); //get initial data
        
        //get previous season
        $previousSeasons = getPreviousSeasons(CAREER_STATS_DIR);
        if (!empty($previousSeasons)) {
            foreach ($previousSeasons as $prevSeason) {
                error_log($prevSeason);
                $holder = $model->findBySeason($prevSeason, $seasonType, $team);
                
                if(isset($type) && 'goalie' == $type){
                    $result = $holder->getFilteredGoalies();
                }else{
                    $result = $holder->getFilteredSkaters();
                }
                
                $data = array_merge($data, $result);
            }
        }
        
        //reduce to map by name.
        $mappedData = array();
        foreach($data as $player){
            //error_log(print_r($player,1));
            $mappedData[$player->getName()][] = $player;
        }
        
        //aggregate totals
        $aggregatedData = array();
        foreach($mappedData as $playerArray){
            
            if (!($playerArray[0] instanceof ScoringPlayerObj)) continue;

            $playerSum = array_reduce($playerArray, function($carry, $player)
            {
                $carry['gamesPlayed'] += $player->getGamesPlayed();
                $carry['goals'] += $player->getGoals();
                $carry['assists'] += $player->getAssists();
                $carry['points'] += $player->getPoints();
                $carry['plusMinus'] += $player->getPlusMinus();
                
                $carry['pim'] += $player->getPim();
                $carry['ppg'] += $player->getPpg();
                $carry['shg'] += $player->getShg();
                $carry['gwg'] += $player->getGwg();
                $carry['gtg'] += $player->getGtg();
                $carry['hits'] += $player->getHits();
                $carry['shots'] += $player->getShots();
                $carry['shotPct'] =  $carry['goals'] ? (round($carry['shots'] / $carry['goals'], 3)) : 0;

                return $carry;
            },[
                'gamesPlayed'=>0,
                'goals'=>0,
                'assists'=>0,
                'points'=>0,
                'plusMinus'=>0,
                'pim'=>0,
                'ppg'=>0,
                'shg'=>0,
                'gwg'=>0,
                'gtg'=>0,
                'hits'=>0,
                'shots'=>0,
                'shotPct'=>0,
                
            ]);
            
            $player = $playerArray[0];
            
            $scoring = new ScoringPlayerObj();
            
            $scoring->setNumber($player->getNumber());
            $scoring->setTeam($player->getTeam());
            $scoring->setTeamAbbr($player->getTeamAbbr()); 
            $scoring->setPosition($player->getPosition());
            $scoring->setRookieStatus($player->getRookieStatus());
            $scoring->setName($player->getName());
            $scoring->setGamesPlayed($playerSum['gamesPlayed']);
            $scoring->setGoals($playerSum['goals']);
            $scoring->setAssists($playerSum['assists']);
            $scoring->setPoints($playerSum['points']);
            $scoring->setPlusMinus($playerSum['plusMinus']);
            $scoring->setPim($playerSum['pim']);
            $scoring->setPpg($playerSum['ppg']);
            $scoring->setShg($playerSum['shg']);
            $scoring->setGwg($playerSum['gwg']);
            $scoring->setGtg($playerSum['gtg']);
            $scoring->setHits($playerSum['hits']);
            $scoring->setShots($playerSum['shots']);
            $scoring->setShotPct($playerSum['shotPct']);
            $scoring->setGoalStreak('');
            $scoring->setPointStreak('');
            
            array_push($aggregatedData, $scoring);
        }
        
        $data = null;
        $responseData = json_encode($aggregatedData);
      
     
        
        $this->sendOutput(
            $responseData,
            array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
    }
    
    protected function getData(): array
    {
        //type goalie or default to skater if empty
        $type = null;
        if(isset($this->getQueryStringParams()['type'])) {
            $type = $this->getQueryStringParams()['type'];
        }
        
        $data = array();
        if(isset($type) && 'goalie' == $type){
            $data = $this->getDataHolder()->getFilteredGoalies();
        }else{
            $data = $this->getDataHolder()->getFilteredSkaters();
        }

        return $data;
    }
    
    protected function getSearchFields(): array {
        return array("name","team");
    }
    
    protected function getSecondarySort(): string
    {
        return 'name';
    }
    
}