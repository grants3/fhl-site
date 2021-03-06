<?php
if(count(get_included_files()) ==1) die(header('HTTP/1.1 404 Not Found')); //must be included 

require_once __DIR__.'/../../baseConfig.php';
require_once FS_ROOT.'api/controller/BaseSearchController.php';
require_once FS_ROOT.'model/ProspectsModel.php';
require_once FS_ROOT.'classes/ProspectHolder.php';

class ProspectsController extends BaseSearchController
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
        
        $model = new ProspectsModel();
        $holder = $model->findBySeason($seasonId, $seasonType, $team );
        
        return $holder;
    }
    
    protected function getData(): array
    {
        return $this->getDataHolder()->getProspects();
    }
    
    protected function getSearchFields(): array {
        return array("name");
    }
    
    protected function getSecondarySort(): string
    {
        return 'name';
    }

    
}