<?php

class PlayerScoringModel {//implements Model{
    
    //cache of stats by season id.
    private $seasonStats = array();
    
    public function __construct(){
        
    }
    
    function init(array $seasons){
        
        //already processed. we want to use previous cached result
        foreach($seasons as $season){
            if (array_key_exists($season, $this->seasonStats)) continue; 
            $scoringHolder = new ScoringHolder($this->fileName);
            $scoringAcc = new ScoringAccumulator($this->scoringHolder);
        }
        

    }

    public function getAll(): array{
        $startIndex = isset($this->requestData['start']) ? $this->requestData['start'] : 0;
        $draw = isset($this->requestData['draw']) ? $this->requestData['draw'] : 0;
        $length = isset($this->requestData['length']) ? $this->requestData['length'] : 100;
        
        //load and init data
        $this->load();
        $data = $this->scoringAcc->getFilteredSkaters();
        
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

    public function get($identifier)
    {
        return null;
    }
    
    

}

