<?php
if(count(get_included_files()) ==1) die(header('HTTP/1.1 404 Not Found')); //must be included 

require_once __DIR__.'/../../baseConfig.php';
require_once FS_ROOT.'api/controller/BaseController.php';

abstract class BaseSearchController extends BaseController
{
    abstract protected function getDataHolder();
    abstract protected function getData() :array;
    abstract protected function getSearchFields() :array;
    abstract protected function getSecondarySort() :string;
    
    public function get(){
        
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        
        if (strtoupper($requestMethod) == 'GET') {
            try {

                $holder = $this->getDataHolder();
                
                $responseData = json_encode($holder);
  
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
                );
        }
    }

    public function find(){
        $this->_find();
    }
    
    //placeholder want to split off normal search to have simple search/filter/order parameters for 'normal api'.
    //will cutover to dt version on site.
    public function findDt(){
        $this->_find();
    }
    
    protected function _find(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        
        if (strtoupper($requestMethod) == 'GET') {
            try {
                 
                $draw = isset($arrQueryStringParams['draw']) ? $arrQueryStringParams['draw'] : 0; //for async support
                $startIndex = isset($arrQueryStringParams['start']) ? $arrQueryStringParams['start'] : 0; //paging start
                $length = isset($arrQueryStringParams['length']) ? $arrQueryStringParams['length'] : 25; //paging max records
                
               // $data = $this->getData();
                //we want to return a blank dataset if the file is not found.
                try{
                    $data = $this->getData();
                }catch (SimFileNotFoundException $e) {
                    
                    $output = array(
                        "draw" 				=> $draw,
                        "records"           => 0,
                        "recordsTotal" 		=> 0,
                        "recordsFiltered"	=> 0,
                        "data" 				=> array(),
                        "message"           => $e->getMessage()
                    );
                    
                    $this->sendOutput(
                        json_encode($output),
                        array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                        );
                }
                
                //count unfiltered
                $total = count($data);
                
                //search support
                $this->searchData($data);

                //column filtering
                $this->filterData($data);
                
                //data ordering
                $this->orderData($data);
                
                //count filtered records
                $filtered = count($data);
                
                //paging support
                if($total > $length && $startIndex >= 0){
                    $data = array_slice($data, $startIndex, $length);
                }
                
                //records returned payload 
                $recordsReturned = count($data);
                
                $output = array(
                    "draw" 				=> $draw,
                    "records"           => $recordsReturned,
                    "recordsTotal" 		=> $total,
                    "recordsFiltered"	=> $filtered,
                    "data" 				=> $data,
                );
                
                $responseData = json_encode($output);
                
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
                );
        }
    }
    
    //simple search support based on single value.
    //will search one or many fields based on getSeachField return value.
    protected function searchData(array &$data){
        //search value support
        //hardcode to name field for now.
        if(isset($this->getQueryStringParams()['search']) && $this->getQueryStringParams()['search']['value']){
            
            $searchValue = htmlspecialchars($this->getQueryStringParams()['search']['value']);
            $searchRegex = true; //hard code to contains matching.
            
            //$data = $this->dynamicFiltering($data, $this->getSearchField(), $searchValue, $searchRegex);
            $searchData = array();
            
            //used defined search fields if set.
            if($this->getSearchFields()){
                foreach($this->getSearchFields() as $searchField){
                    $searchData = array_merge($this->dynamicFiltering($data, $searchField, $searchValue, $searchRegex),$searchData);
                }
            }else{
               // otherwise use column data.
                if(isset($this->getQueryStringParams()['columns'])){
                    foreach($this->getQueryStringParams()['columns'] as $column){
                        if(isset($column['search'])){
    
                            $searchable =  htmlspecialchars($column['searchable']);
                            if(isset($searchable) && !$searchable){
                                continue; //skip if marked as non searchable.
                            }
                            $columnData =  htmlspecialchars($column['data']);
  
                            //override if set at column level
                            if(isset($column['search']['regex'])) $searchRegex = htmlspecialchars($column['search']['regex']);
    
                            if(DEBUG_MODE){
                                error_log('filtering column '.$columnData .' search value '. $searchValue);
                            }

                            //$data = $this->dynamicFiltering($data, $columnData, $searchValue, $searchRegex);
                            $searchData = array_merge($this->dynamicFiltering($data, $columnData, $searchValue, $searchRegex),$searchData);
                        }
                    }
                }
            }
  

            


            $data = $searchData;
        }
        
  
        
        //return $data;
    }
    
    //column based advanced search 
    protected function filterData(array &$data){
        
        if(isset($this->getQueryStringParams()['columns'])){
            foreach($this->getQueryStringParams()['columns'] as $column){
                
                if(isset($column['search']) && !empty($column['search']['value'])){
                    
                    $searchable =  htmlspecialchars($column['searchable']);
                    if(isset($searchable) && !$searchable){
                        continue; //skip if marked as non searchable.
                    }
                    $columnData =  htmlspecialchars($column['data']);
                    $searchValue = htmlspecialchars($column['search']['value']);
                    $searchRegex = isset($column['search']['regex']) ? htmlspecialchars($column['search']['regex']) : false;
                    
                    if(DEBUG_MODE){
                        error_log('filtering column '.$columnData .' search value '. $searchValue);
                    }

                    $data = $this->dynamicFiltering($data, $columnData, $searchValue, $searchRegex);
                }
            }
        }
        
        // return $data;
    }
    
    protected function orderData(array &$data){
        //only support single ordering for now.
        if(isset($this->getQueryStringParams()['order']) && $this->getQueryStringParams()['order'][0]){
            $orderColumnIndex = htmlspecialchars($this->getQueryStringParams()['order'][0]['column']);
            $orderDirection = htmlspecialchars($this->getQueryStringParams()['order'][0]['dir']);
            
            $orderColumn = htmlspecialchars($this->getQueryStringParams()['columns'][$orderColumnIndex]['data']);

            usort( $data,  function($a, $b) use($orderColumn,$orderDirection){

                //multi sort with attribute and then secondary if equal.
                if($orderDirection == 'asc'){
                    
                    $comp = $a->__get($orderColumn) <=> $b->__get($orderColumn);
                    if($comp != 0) return $comp;
                    
                    if($this->getSecondarySort()){
                        return $a->__get($this->getSecondarySort()) <=>  $b->__get($this->getSecondarySort());
                    }else{
                        return 0;
                    }

                }else{
                    
                    $comp = $b->__get($orderColumn) <=> $a->__get($orderColumn);
                    if($comp != 0) return $comp;
                    
                    if($this->getSecondarySort()){
                        return $a->__get($this->getSecondarySort()) <=>  $b->__get($this->getSecondarySort());
                    }else{
                        return 0;
                    }

                }
                
                
            } );
                
                
        }
        
    }
    
}

