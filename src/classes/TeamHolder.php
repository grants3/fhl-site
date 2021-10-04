<?php

class TeamHolder {
    var $teams = array();
    
    public function __construct(string $file) {
        
        $i = 0;
        if(file_exists($file)) {
            $contents = file($file);
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