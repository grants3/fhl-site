<?php
if(count(get_included_files()) ==1) die(header('HTTP/1.1 404 Not Found')); //must be included

require_once __DIR__.'/../../baseConfig.php';
require_once FS_ROOT.'api/controller/BaseSearchController.php';
require_once FS_ROOT.'model/GamesModel.php';
require_once FS_ROOT.'classes/GameHolder.php';

class GameController extends BaseSearchController
{
    protected function getDataHolder(){
        $seasonId=null;
        $matchNumber = null;
        $round = null;
        
        if(isset($this->getQueryStringParams()['matchNumber'])) {
            $matchNumber = $this->getQueryStringParams()['matchNumber'];
        }
        
        if(isset($this->getQueryStringParams()['seasonId'])) {
            $seasonId = $this->getQueryStringParams()['seasonId'];
        }
     
        if(isset($this->getQueryStringParams()['round'])) {
            $round = $this->getQueryStringParams()['round'];
        }
        
        $model = new GamesModel();
        $holder = $model->findGame($matchNumber, $seasonId, $round);
        
        return $holder;
    }
    
    public function find(){
        //not supported.
        die(header('HTTP/1.1 405 Method Not Allowed'));
    }
    
    protected function getData(): array
    {
        return null;
    }
    
    protected function getSearchFields(): array {
        return null;
    }
    
    protected function getSecondarySort(): string
    {
        return null;
    }
    
    
}