<?php
if(count(get_included_files()) ==1) die(header('HTTP/1.1 404 Not Found')); //must be included 

require_once __DIR__.'/../../baseConfig.php';
require_once FS_ROOT.'api/controller/BaseController.php';
require_once FS_ROOT.'model/ProspectsModel.php';
require_once FS_ROOT.'classes/ProspectHolder.php';

class ProspectsController extends BaseController
{

    public function get(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        
        if (strtoupper($requestMethod) == 'GET') {
            try {
                
                $seasonId='';
                $seasonType = '';
                $team = '';
                
                if(isset($arrQueryStringParams['seasonId'])) {
                    $seasonId = $arrQueryStringParams['seasonId'];
                }
                
                if(isset($arrQueryStringParams['seasonType'])) {
                    $seasonType = $arrQueryStringParams['seasonType'];
                }
                
                //type goalie or default to skater
                if(isset($arrQueryStringParams['team'])) {
                    $team = $arrQueryStringParams['team'];
                }
                
                $model = new ProspectsModel();
                $holder = $model->findBySeason($seasonId, $seasonType, $team);
           
                $responseData = json_encode($holder);
                
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