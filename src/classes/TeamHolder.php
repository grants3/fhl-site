<?php

class TeamHolder {
    var $teams = array();
    
    public function __construct(string $gmFile) {
        
        $i = 0;
        if(file_exists($gmFile)) {
            $contents = file($gmFile);
            foreach ($contents as $cle => $val) {
                $val = utf8_encode($val);
                if(substr_count($val, 'HREF') && !substr_count($val, '<BR>')) {
                    $team = trim(substr($val, 0, 10));
                    
                    array_push($this->teams, $team);
                    
                    $i++;
                }
            }
        }
          
    }
    
    public function get_teams() {
        return $this->teams;
    }
    

    
}