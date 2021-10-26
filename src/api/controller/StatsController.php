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