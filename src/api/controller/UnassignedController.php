<?php
if(count(get_included_files()) ==1) die(header('HTTP/1.1 404 Not Found')); //must be included 

require_once __DIR__.'/../../baseConfig.php';
require_once FS_ROOT.'/api/controller/BaseSearchController.php';
require_once FS_ROOT.'/model/UnassignedModel.php';
require_once FS_ROOT.'/classes/UnassignedHolder.php';

class UnassignedController extends BaseSearchController
{
    
    protected function getDataHolder(){
        $seasonId='';
        $seasonType = '';
        
        if(isset($this->getQueryStringParams()['seasonId'])) {
            $seasonId = $this->getQueryStringParams()['seasonId'];
        }
        
        if(isset($this->getQueryStringParams()['seasonType'])) {
            $seasonType = $this->getQueryStringParams()['seasonType'];
        }
        
        $model = new UnassignedModel();
        $holder = $model->findBySeason($seasonId, $seasonType);
        
        return $holder;
    }
    
    protected function getData(): array
    {        
        return $this->getDataHolder()->getUnassigned();
    }
    
    protected function getSearchFields(): array {
        return array("name");
    }

    protected function getSecondarySort(): string
    {
        return 'name';
    }

}