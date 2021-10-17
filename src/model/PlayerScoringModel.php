<?php

require_once __DIR__.'/../config.php';
include_once FS_ROOT.'common.php';

include_once FS_ROOT.'classes/ScoringHolder.php';
include_once FS_ROOT.'classes/ScoringPlayerObj.php';
include_once FS_ROOT.'classes/ScoringGoalieObj.php';
include_once FS_ROOT.'classes/ScoringObj.php';
include_once FS_ROOT.'classes/ScoringAccumulator.php';

class PlayerScoringModel {//implements Model{
    
    //cache of stats by season id.
    private $seasonStats = array();
    
    public function __construct(){
        
    }
    
    function getSeason($seasonId, $seasonType) : ScoringHolder{
        
//         //already processed. we want to use previous cached result
//         foreach($seasons as $season){
//             if (array_key_exists($season, $this->seasonStats)) continue; 
//             $scoringHolder = new ScoringHolder($this->fileName);
//             $scoringAcc = new ScoringAccumulator($this->scoringHolder);
//         }

        //already processed. we want to use previous cached result
        if(isset($this->seasonStats[$seasonId])) return $this->seasonStats[$seasonId];
        
        $seasonId = '0';
        $playoff='';
        $fileName=null;
        
        if('PLF' == $seasonType){
            $playoff = $seasonType;
        }
        
        if(trim($seasonId) == false){
            $fileName = getLeagueFile(TRANSFER_DIR, $playoff, 'TeamScoring.html', 'TeamScoring');
        }else{
            $seasonFolder =  str_replace("#",$seasonId,CAREER_STATS_DIR);
            $fileName = getLeagueFile($seasonFolder, $playoff, 'TeamScoring.html', 'TeamScoring');
        }
        
        $scoringHolder = new ScoringHolder($fileName);
        
        $this->seasonStats[$seasonId] = $scoringHolder;

        return $scoringHolder;
    }

    public function getAll(int $seasonId, string $seasonType): array{
        $startIndex = isset($this->requestData['start']) ? $this->requestData['start'] : 0;
        $draw = isset($this->requestData['draw']) ? $this->requestData['draw'] : 0;
        $length = isset($this->requestData['length']) ? $this->requestData['length'] : 100;
        
        //load and init data
        $data = $this->getSeason($seasonId, $seasonType);
        
        //count unfilteed
        $total = count($data);    
        
        //search value support
        //hardcode to name field for now.
        if(isset($this->requestData['search']) && $this->requestData['search']['value']){
            
            $searchValue = $this->requestData['search']['value'];
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
        
        return $output;
    }


    

}

