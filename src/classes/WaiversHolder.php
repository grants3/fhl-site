<?php

class WaiversHolder {
    var $waivers = array();
    
    public function __construct(string $file) {
        
        $c = 1;
        $d = 0;
        $g = 0;
        $waivName = '';
        $waivDate = '';
        $waivBy = '';
        $waivClaim = '';
        
        if(!file_exists($file)) {
            throw new InvalidArgumentException('File does not exist');
        }
        
        $contents = file($file);
        
        foreach ($contents as $cle => $val) {
            $val = utf8_encode($val);
            //no players on waivers
            if(substr_count($val, 'NO PLAYERS ON WAIVERS')){
                break;
            }
            
            $counter = 1;
            //interate through each waiver entry and add to array
            if($d == 2 && $g < 5 && !substr_count($val, '<')) {
                if($c == 1) $c = 2;
                else $c = 1;
                $reste = trim($val);
                $waivName = substr($reste, 0, strpos($reste, '  '));
                $reste = trim(substr($reste, strpos($reste, '  ')));
                $waivDate = substr($reste, 0, strpos($reste, '  '));
                $reste = trim(substr($reste, strpos($reste, '  ')));
                $waivBy = substr($reste, 0, strpos($reste, '  '));
                $reste = trim(substr($reste, strpos($reste, '  ')));
                $waivClaim = $reste;
                
                $waiver = new WaiverObj();
                $waiver->player = $waivName;
                $waiver->waiveDate = $waivDate;
                $waiver->waivedBy = $waivBy;
                $waiver->claimedBy = $waivClaim;
                
                array_push($this->waivers, $waiver);
  
                $g++;
                $counter++;
            }
            
            if($d == 1 && (substr_count($val, '<br>') || substr_count($val, '<BR>'))){
                $d = 2;
                $c = 1;
            }
            
            //header
            if(substr_count($val, '<pre>') || substr_count($val, '<PRE>')){
                $d = 1;
            }
            
            
        }
        
    }
    
    public function get_waivers() {
        return $this->waivers;
    }
    
}