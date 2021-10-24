<?php
require_once __DIR__.'/../../baseConfig.php';
require_once FS_ROOT.'api/controller/BaseController.php';
require_once FS_ROOT.'model/PlayerStatsModel.php';
require_once FS_ROOT.'classes/ScoringAccumulator.php';



class StatsController extends BaseController
{
    /**
     * "/user/list" Endpoint - Get list of users
     */
    public function find()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try {

                $seasonId='';
                $seasonType = '';
                $type = '';
                
                if(isset($arrQueryStringParams['seasonId'])) {
                    $seasonId = $arrQueryStringParams['seasonId'];
                }
                
                if(isset($arrQueryStringParams['seasonType'])) {
                    $seasonType = $arrQueryStringParams['seasonType'];
                }
                
                //type goalie or default to skater
                if(isset($arrQueryStringParams['type'])) {
                    $type = $arrQueryStringParams['type'];
                }

                $model = new PlayerStatsModel();
                $scoringHolder = $model->getSeason($seasonId, $seasonType);

                $startIndex = isset($arrQueryStringParams['start']) ? $arrQueryStringParams['start'] : 0;
                $draw = isset($arrQueryStringParams['draw']) ? $arrQueryStringParams['draw'] : 0;
                $length = isset($arrQueryStringParams['length']) ? $arrQueryStringParams['length'] : 25;
   
                if(isset($type) && 'goalie' == $type){
                    $data = $scoringHolder->getFilteredGoalies();
                }else{
                    $data = $scoringHolder->getFilteredSkaters();
                }
                
                //count unfilteed
                $total = count($data);
                
                //search value support
                //hardcode to name field for now.
                if(isset($arrQueryStringParams['search']) && $arrQueryStringParams['search']['value']){
                    
                    $searchValue = htmlspecialchars($arrQueryStringParams['search']['value']);
                    $searchRegex = true; //hard code to contains matching.
                    
                    $data = $this->dynamicFiltering($data, 'name', $searchValue, $searchRegex);
                }
                
                
                //column filtering
                if(isset($arrQueryStringParams['columns'])){
                    foreach($arrQueryStringParams['columns'] as $column){
                        
                        if(isset($column['search']) && !empty($column['search']['value'])){
                            
                            $columnData = htmlspecialchars($column['data']);
                            $searchValue = htmlspecialchars($column['search']['value']);
                            $searchRegex = isset($column['search']['regex']) ? htmlspecialchars($column['search']['regex']) : false;
                            
                            if(DEBUG_MODE){
                                error_log('filtering column '.$columnData .' search value '. $searchValue);
                            }
                            
                            $data = $this->dynamicFiltering($data, $columnData, $searchValue, $searchRegex);
                        }
                    }
                }
                
                //only support single ordering for now.
                if(isset($arrQueryStringParams['order']) && $arrQueryStringParams['order'][0]){
                    $orderColumnIndex = $arrQueryStringParams['order'][0]['column'];
                    $orderDirection = $arrQueryStringParams['order'][0]['dir'];
                    
                    $orderColumn = $arrQueryStringParams['columns'][$orderColumnIndex]['name'];
                    
                    usort( $data,  function($a, $b) use($orderColumn,$orderDirection){
                        
                        $a = (array) $a;
                        $b = (array) $b;
                        
                        //multi sort with attribute and then name.
                        if($orderDirection == 'asc'){
                            //return [$a[$orderColumn], $a['name']] <=> [$b[$orderColumn], $b['name']];
                            if($a[$orderColumn] === $b[$orderColumn]){
                                return $a['name'] <=>  $b['name'];
                            }
                            
                            return $a[$orderColumn] <=> $b[$orderColumn];
                        }else{
                            if($a[$orderColumn] === $b[$orderColumn]){
                                return $a['name'] <=>  $b['name'];
                            }
                            
                            return $b[$orderColumn] <=> $a[$orderColumn];
                        }
                        
                        
                    } );
                        
                        
                }
           
                //count filtered records
                $filtered = count($data);
                
                if($total > $length){
                    $data = array_slice($data, $startIndex, $length);
                }
                
                $output = array(
                    "draw" 				=> $draw,
                    "recordsTotal" 		=> $total,
                    "recordsFiltered"	=> $filtered,
                    "data" 				=> $data,
                );

                $responseData = json_encode($output);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
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
}