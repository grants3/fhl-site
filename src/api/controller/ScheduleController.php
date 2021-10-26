<?php
if(count(get_included_files()) ==1) die(header('HTTP/1.1 404 Not Found')); //must be included 

require_once __DIR__.'/../../baseConfig.php';
require_once FS_ROOT.'/api/controller/BaseSearchController.php';
require_once FS_ROOT.'/model/ScheduleModel.php';
require_once FS_ROOT.'/classes/ScheduleHolder.php';

class ScheduleController extends BaseSearchController
{
    
    protected function getDataHolder(){
        $seasonId= null;
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
        
        $model = new ScheduleModel();
        $holder = $model->findBySeason($seasonId, $seasonType, $team);
        
        return $holder;
    }
    
    protected function getData(): array
    {        
        return $this->getDataHolder()->getSchedule();
    }
    
    protected function getSearchFields(): array {
        return array();
    }

    protected function getSecondarySort(): string
    {
        return '';
    }

}