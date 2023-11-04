<?php

function getMaxGp($standingsFile) :int{
    
    $maxGp=0;
    $e = 0;
    
    if (file_exists($standingsFile)) {
        $contents = file($standingsFile);
        // $placeCount = 1;
        
        foreach ($contents as $cle => $val) {
            $val = encodeToUtf8($val);
            
            
            if (substr_count($val, 'Conference') && !substr_count($val, 'By Conference')) {
                $reste = trim($val);
                $reste = trim(substr($reste, strpos($reste, '>') + 1));
                $conf = substr($reste, 0, strpos($reste, '</H3>'));
                //$placeCount = 1;
            }
            
            if (substr_count($val, 'HREF=')) {
                
                
                $reste = trim($val);
                
                if(substr_count($val, '<HR')){
                    $reste = trim(substr($reste, strposX($reste, '>',2) + 1));
                }else{
                    $reste = trim(substr($reste, strpos($reste, '>') + 1));
                }
                
                $equipe = substr($reste, 0, strpos($reste, '</A>'));
                
                $reste = trim(substr($reste, strpos($reste, '</A>') + 4));
                
                $gp = substr($reste, 0, strpos($reste, ' '));
                $reste = trim(substr($reste, strpos($reste, ' ')));
                $standingsW = substr($reste, 0, strpos($reste, ' '));
                $reste = trim(substr($reste, strpos($reste, ' ')));
                $standingsL = substr($reste, 0, strpos($reste, ' '));
                $reste = trim(substr($reste, strpos($reste, ' ')));
                $standingsT = substr($reste, 0, strpos($reste, ' '));
                $reste = trim(substr($reste, strpos($reste, ' ')));
                
                $standingsOL=0;
                if ($e == 1) {
                    $standingsOL = substr($reste, 0, strpos($reste, ' '));
                    $reste = trim(substr($reste, strpos($reste, ' ')));
                }
                $standingsPts = substr($reste, 0, strpos($reste, ' '));
                $reste = trim(substr($reste, strpos($reste, ' ')));
                $standingsGF = substr($reste, 0, strpos($reste, ' '));
                $reste = trim(substr($reste, strpos($reste, ' ')));
                $standingsGA = substr($reste, 0, strpos($reste, ' '));
                $reste = trim(substr($reste, strpos($reste, ' ')));
                $reste = trim(substr($reste, strpos($reste, ' ')));
                //$standingsDiff = $standingsGF - $standingsGA;
                $standingsPCT = substr($reste, 0, strpos($reste, ' '));
                $reste = trim(substr($reste, strpos($reste, ' ')));
                for ($z = 0; $z < 9; $z ++) {
                    $reste = trim(substr($reste, strpos($reste, ' ')));
                }
                $standingsL10 = substr($reste, 0, strpos($reste, ' '));
                $reste = trim(substr($reste, strpos($reste, ' ')));
                $standingsSTK = $reste;
                
                $maxGp = max($maxGp, $gp);
                
            }
        }
        
        
    } 
    
    return $maxGp;
}

?>
