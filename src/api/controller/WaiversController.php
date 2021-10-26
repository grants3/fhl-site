<?php
if(count(get_included_files()) ==1) die(header('HTTP/1.1 404 Not Found')); //must be included 

require_once __DIR__.'/../../baseConfig.php';
require_once FS_ROOT.'/api/controller/BaseSearchController.php';
require_once FS_ROOT.'/model/WaiversModel.php';
require_once FS_ROOT.'/classes/WaiversHolder.php';

class WaiversController extends BaseSearchController
{
    
    protected function getDataHolder(){
        $seasonId= null;
        $seasonType = null;
        
        if(isset($this->getQueryStringParams()['seasonId'])) {
            $seasonId = $this->getQueryStringParams()['seasonId'];
        }
        
        if(isset($this->getQueryStringParams()['seasonType'])) {
            $seasonType = $this->getQueryStringParams()['seasonType'];
        }
        
        $model = new WaiversModel();
        $holder = $model->findBySeason($seasonId, $seasonType);
        
        return $holder;
    }
    
    protected function getData(): array
    {        
        return $this->getDataHolder()->get_waivers();
    }
    
    protected function getSearchFields(): array {
        return array("player");
    }

    protected function getSecondarySort(): string
    {
        return 'player';
    }

}