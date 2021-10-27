<?php
if(count(get_included_files()) ==1) die(header('HTTP/1.1 404 Not Found')); //must be included

require_once __DIR__.'/../../baseConfig.php';
require_once FS_ROOT.'/api/controller/BaseSearchController.php';
require_once FS_ROOT.'/model/TransactionModel.php';
require_once FS_ROOT.'/classes/TransactionHolder.php';

class TransactionController extends BaseSearchController
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
        
        $model = new TransactionModel();
        $holder = $model->findBySeason($seasonId, $seasonType);
        
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
        if(isset($type) && $type){
            if('trade' == $type){
                $data = $this->getDataHolder()->getTrades();
            }else if('trans' == $type){
                $data = $this->getDataHolder()->getEventsByType(TransactionHolder::$typeTransaction);
            }else if('inj' == $type){
                $data = $this->getDataHolder()->getEventsByType(TransactionHolder::$typeInjury);
            }
        }else{
            $data = array_merge($this->getDataHolder()->getTrades(), $this->getDataHolder()->getEvents());
        }
        
        return $data;
    }
    
    protected function getSearchFields(): array {
        //search based on column data.
        return array();
    }
    
    protected function getSecondarySort(): string
    {
        return '';
    }
    
}