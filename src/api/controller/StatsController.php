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
                $holder = $model->findBySeason($prevSeason, $seasonType, $team);
                
                if(isset($type) && 'goalie' == $type){
                    $result = $holder->getFilteredGoalies();
                }else{
                    $result = $holder->getFilteredSkaters();
                }
                
                $data = array_merge($data, $result);
            }
        }
        
        //reduce.
        $responseData = array();
        foreach($data as $player){
            //error_log(print_r($player,1));
            $responseData[$player->getName()][] = $player;
        }
        
        foreach($responseData as $playerArray){
            $goalsSum = array_reduce($playerArray, function($carry, $player)
            {
                return $carry + $player->__get('goals');
            });
            error_log($player->__get('goals').' goals='.$goalsSum);
        }
        
        $data = null;
        $responseData = json_encode($responseData);
      
     
        
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