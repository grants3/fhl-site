<?php
if(count(get_included_files()) ==1) die(header('HTTP/1.1 404 Not Found')); //must be included 

require_once __DIR__.'/../../baseConfig.php';
require_once FS_ROOT.'/api/controller/BaseSearchController.php';
require_once FS_ROOT.'/classes/RostersHolder.php';
require_once FS_ROOT.'/model/RostersModel.php';

class RostersController extends BaseSearchController
{
    protected function getDataHolder(){
        $seasonId=null;
        $seasonType = null;
        $team = null;
        $incAvg=false;
        
        if(isset($this->getQueryStringParams()['seasonId'])) {
            $seasonId = $this->getQueryStringParams()['seasonId'];
        }
        
        if(isset($this->getQueryStringParams()['seasonType'])) {
            $seasonType = $this->getQueryStringParams()['seasonType'];
        }
        
        if(isset($this->getQueryStringParams()['team'])) {
            $team = $this->getQueryStringParams()['team'];
        }else{
            throw new \Exception("Invalid request, team required.");
        }
        
      
        if(isset($this->getQueryStringParams()['incAvg'])) {
            $incAvg = $this->getQueryStringParams()['incAvg'];
        }
        
        
        $model = new RostersModel();
        $holder = $model->findBySeason($seasonId, $seasonType, $team, $incAvg );
        
        return $holder;
    }
    
    protected function getData(): array
    {
        return $this->getDataHolder()->getRosters();
    }
    
    protected function getSearchFields(): array {
        return array("name");
    }
    
    protected function getSecondarySort(): string
    {
        return 'name';
    }
}