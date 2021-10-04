<?php

function myEach($seasonId) {
    
    $Fnm = '';
    
    if(trim($seasonId) == false){
        $baseFolder = $folder;
    }else{
        $baseFolder = str_replace("#",$seasonId,$folderCarrerStats);
    }
    
    if($currentPLF){
        
        if(isset($_GET['plf']) || isset($_POST['plf']) || $currentPLF) {
            $matches = glob($baseFolder.'*PLF-Round1-Schedule.html');
            $folderLeagueURL2 = '';
            $matchesDate = array_map('filemtime', $matches);
            arsort($matchesDate);
            foreach ($matchesDate as $j => $val) {
                if(substr_count($matches[$j], 'PLF')) {
                    $folderLeagueURL2 = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'PLF-Round1-Schedule.html')-strrpos($matches[$j], '/')-1);
                    break 1;
                }
            }
            if (file_exists($baseFolder.$folderLeagueURL2.'PLF-Round1-Schedule.html')) {
                $Fnm = $baseFolder.$folderLeagueURL2.'PLF-Round1-Schedule.html';
                $linkSchedule = '-Round1-Schedule';
                $rnd = 1;
                $existRnd = 1;
            }
            if (file_exists($baseFolder.$folderLeagueURL2.'PLF-Round2-Schedule.html')) {
                $Fnm = $baseFolder.$folderLeagueURL2.'PLF-Round2-Schedule.html';
                $linkSchedule = '-Round2-Schedule';
                $rnd = 2;
                $existRnd = 2;
            }
            if (file_exists($baseFolder.$folderLeagueURL2.'PLF-Round3-Schedule.html')) {
                $Fnm = $baseFolder.$folderLeagueURL2.'PLF-Round3-Schedule.html';
                $linkSchedule = '-Round3-Schedule';
                $rnd = 3;
                $existRnd = 3;
            }
            if (file_exists($baseFolder.$folderLeagueURL2.'PLF-Round4-Schedule.html')) {
                $Fnm = $baseFolder.$folderLeagueURL2.'PLF-Round4-Schedule.html';
                $linkSchedule = '-Round4-Schedule';
                $rnd = 4;
                $existRnd = 4;
            }
            if(isset($_GET['rnd']) || isset($_POST['rnd'])) {
                $currentRND = ( isset($_GET['rnd']) ) ? $_GET['rnd'] : $_POST['rnd'];
                $Fnm = $baseFolder.$folderLeagueURL2.'PLF-Round'.$currentRND.'-Schedule.html';
                $linkSchedule = '-Round'.$currentRND.'-Schedule';
                $rnd = $currentRND;
            }
        }
        
        if($rnd) $schedTitlePlayoff = ' - '.$scheldRound.' '.$rnd;
    }else{
        $Fnm = getLeagueFile($baseFolder, $playoff, 'Schedule.html', 'Schedule');
    }
    
    return $Fnm;
}


?>

