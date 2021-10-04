<?php
require_once __DIR__.'/../baseConfig.php';
include_once FS_ROOT.'common.php';

include_once FS_ROOT.'classes/ScoringHolder.php';
include_once FS_ROOT.'classes/ScoringPlayerObj.php';
include_once FS_ROOT.'classes/ScoringGoalieObj.php';
include_once FS_ROOT.'classes/ScoringObj.php';
include_once FS_ROOT.'classes/ScoringAccumulator.php';

class PlayerScoringController {

    private $requestMethod;
    private $requestData;
    private $team;
    private $fileName;
    
    private $scoringHolder;
    private $scoringAcc;
    
    public function __construct(string $requestMethod, array $requestData, $fileName, string $team = null)
    {
        $this->requestMethod = $requestMethod;
        $this->requestData = $requestData;
        $this->fileName = $fileName;
        $this->team = $team;

    }
    
    private function load(){
        $this->scoringHolder = new ScoringHolder($this->fileName);
        $this->scoringAcc = new ScoringAccumulator($this->scoringHolder);
    }
    
    public function processRequest()
    {
        
        
        
        switch ($this->requestMethod) {
            case 'GET':
//                 if ($this->userId) {
//                     $response = $this->getUser($this->userId);
//                 } else {
//                     $response = $this->getAllUsers();
//                 };
                $response = $this->getAll();
                break;
            case 'POST':
                $response = $this->notFoundResponse();
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        
        if(isset($response['status_code_header'])){
            header($response['content_type']);
        }else{
            header($response['HTTP/1.1 404 Not Found']);
        }
        if(isset($response['content_type'])){
            header($response['content_type']);
        }

        if ($response['body']) {
            echo $response['body'];
        }
    }
    
    private function getAll()
    {
        
        $startIndex = isset($this->requestData['start']) ? $this->requestData['start'] : 0;
        $draw = isset($this->requestData['draw']) ? $this->requestData['draw'] : 0;
        $length = isset($this->requestData['length']) ? $this->requestData['length'] : 25;
        
        //load and init data
        $this->load();
        $data = $this->scoringHolder->getFilteredSkaters();

        //count unfilteed
        $total = count($data);

 
        //search value support
        //hardcode to name field for now.
        if(isset($this->requestData['search']) && $this->requestData['search']['value']){

            $searchValue = htmlspecialchars($this->requestData['search']['value']);
            $searchRegex = true; //hard code to contains matching.

            $data = $this->dynamicFiltering($data, 'name', $searchValue, $searchRegex);
        }
        

        //column filtering       
        if(isset($this->requestData['columns'])){
            foreach($this->requestData['columns'] as $column){

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
        if(isset($this->requestData['order']) && $this->requestData['order'][0]){
            $orderColumnIndex = $this->requestData['order'][0]['column'];
            $orderDirection = $this->requestData['order'][0]['dir'];
            
            $orderColumn = $this->requestData['columns'][$orderColumnIndex]['name'];
            
            usort( $data,  function($a, $b) use($orderColumn,$orderDirection){
                
                $a = (array) $a;
                $b = (array) $b;
                
                if($orderDirection == 'asc'){
                    return $a[$orderColumn] <=> $b[$orderColumn];
                }else{
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

        $response = array();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['content_type'] = 'Content-Type: application/json';
        $response['body'] = json_encode($output);
        
        return $response;
    }
    
    /*
     * filter based on data column name which should match the object property getter.
     * via reflection to get the value.
     */
    private function dynamicFiltering(array $data, string $columnData, $searchValue, bool $searchRegex){
        return array_filter($data, function ($var) use($searchValue,$searchRegex,$columnData) {
            
            $_search = call_user_func(array($var, 'get'.ucfirst($columnData)));
            
            if($searchRegex)  return preg_match('/(?i)'.$searchValue.'/', $_search);
            
            //return (strpos(strtolower($var->getPosition()),strtolower($searchValue)) !== false);
            return $_search == $searchValue;
            
        });
    }
    
    private function sortAttribs($a, $b, $orderColumn, $orderDirection)
    {
        if($orderDirection == 'asc'){
            return $a->goals <=> $b->goals;
        }else{
            return $b->goals <=> $a->goals;
        }
        
    }
    
    
    private function getUser($id)
    {
        $result = $this->personGateway->find($id);
        if (! $result) {
            return $this->notFoundResponse();
        }

        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['content_type'] = 'Content-Type: application/json';
        $response['body'] = json_encode($result);
        return $response;
    }
    
    
    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }
    
    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}
?>