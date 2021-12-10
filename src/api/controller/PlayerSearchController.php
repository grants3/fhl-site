<?php
if(count(get_included_files()) ==1) die(header('HTTP/1.1 404 Not Found')); //must be included 

require_once __DIR__.'/../../baseConfig.php';
require_once FS_ROOT.'api/controller/BaseSearchController.php';
require_once FS_ROOT.'model/PlayerSearchModel.php';

class PlayerSearchController extends BaseSearchController
{
    
    protected function getDataHolder(){
        return null; //not supported.
    }
    
    public function get(){
        $this->sendOutput(json_encode(array('error' => 'get not supported')),
            array('Content-Type: application/json', 'HTTP/1.1 400')
            );
    }
    
    protected function getData(): array
    { 
        
        $seasonType = null;
        $seasonId = null;
        $type = null;
        $team = null;
        
        if(isset($_GET['seasonId']) || isset($_POST['seasonId'])) {
            $seasonId = (int)( isset($_GET['seasonId']) ) ? $_GET['seasonId'] : $_POST['seasonId'];
        }
        
        if(isset($_GET['seasonType']) || isset($_POST['seasonType'])) {
            $seasonType = ( isset($_GET['seasonType']) ) ? $_GET['seasonType'] : $_POST['seasonType'];
        }
        
        if(isset($_GET['team']) || isset($_POST['team'])) {
            $team = ( isset($_GET['team']) ) ? $_GET['team'] : $_POST['team'];
        }
        
        if(isset($_GET['type']) || isset($_POST['type'])) {
            $type = ( isset($_GET['type']) ) ? $_GET['type'] : $_POST['type'];
        }

        
        $model = new PlayerSearchModel();
        return $model->findBySeason($seasonId, $seasonType, $type, $team);
    }
    
    protected function filterData(array &$data){
        parent::filterData($data); //perform normal filtering
     
        if(isset($this->getQueryStringParams()['advFilter'])){
           
            foreach($this->getQueryStringParams()['advFilter'] as $filter){
 
                if(isset($filter['data']) && isset($filter['min']) && isset($filter['max']) ){
               
                    $columnData =  htmlspecialchars($filter['data']);
                    $minValue = htmlspecialchars($filter['min']);
                    $maxValue = htmlspecialchars($filter['max']);
              

                    $data = $this->filterMinMax($data, $columnData, $minValue, $maxValue);
                }
            }
        }
    }
    
    
    protected function filterMinMax(array $data, string $columnData, $minValue, $maxValue){
        return array_filter($data, function ($var) use($minValue,$maxValue,$columnData) {
      
            if(empty($columnData)) return false;
//            if(empty($minValue)) return false;
//             if(empty($maxValue)) return false;
            
            $_search = call_user_func(array($var, 'get'.ucfirst($columnData)));
    
            return  ($minValue <= $_search) && ($_search <= $maxValue);
            
        });
    }
    
    protected function getSearchFields(): array {
        return array("name");
    }
    
    protected function getSecondarySort(): string
    {
        return 'name';
    }
  
}