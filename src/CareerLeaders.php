<?php
require_once 'config.php';
include_once 'common.php';
include_once 'fileUtils.php';
include_once 'lang.php';
include_once 'classes/TeamAbbrHolder.php';

$CurrentHTML = 'CareerLeaders.php';
$CurrentTitle = $langCareerLeadersTitle;
$CurrentPage = 'CareerLeaders';
//$ctlOneLink = '?one=1';
$ctlOneTeams = '';

$teamFilter = '';
if(isset($_GET['team'])) {
    $teamFilter = $_GET['team'];
    $ctlOneTeams == 1;
    $scoringFile = getCurrentLeagueFile('TeamScoring');

    $teamAbbrHolder = new TeamAbbrHolder($scoringFile);
    $TSabbr = $teamAbbrHolder->getAbbr($teamFilter);

}

include 'head.php';

//if($ctlOneTeams == 1) $ctlOneLink = "window.location.href.split('?')[0]";

// Recherche des saisons antérieurs
if(CAREER_STATS_DIR != '0') {
	$hashFolder = '';
	$tmpLong = 0;
	for($i=0;$i<substr_count(CAREER_STATS_DIR, '/');$i++) {
		if($hashFolder != '') $tmpLong = strlen($hashFolder)+1;
		$hashFolder = substr(CAREER_STATS_DIR, 0+$tmpLong, strpos(CAREER_STATS_DIR, '/'));
		if(substr_count($hashFolder, '#') > 0) break 1;
	}
	$Fnm = str_replace("#/","*",CAREER_STATS_DIR);
// 	$NumberSeason = 0;
// 	$dirs = glob($Fnm, GLOB_ONLYDIR);
// 	for($j=0;$j<count($dirs);$j++) {
// 		if(substr_count($dirs[$j], $hashFolder)) {
// 			$tmpYear = substr($dirs[$j], strlen(CAREER_STATS_DIR)-2);
// 			if($NumberSeason < $tmpYear) $NumberSeason = $tmpYear;
// 		}
// 	}
	$NumberSeason = count(getPreviousSeasons(CAREER_STATS_DIR));
}
//echo "Total Seasons: ".$NumberSeason."<br>";
if(DEBUG_MODE){
   // echo "Total Seasons: ".$NumberSeason."<br>";
}

$FnmCurrentSeason = getCurrentRegSeasonFile('TeamScoring');
$FnmCurrentPlayoff = getCurrentPlayoffLeagueFile('TeamScoring');

$i = 0;
$j = 0;
$iPLF = 0;
$jPLF = 0;

for($workSeason=$NumberSeason+1;$workSeason>0;$workSeason--) {
    for($z=0;$z<2;$z++) {
        $Fnm = '';
        if($NumberSeason < $workSeason) {
            //echo "IN - Current Season/Playoff ".$workSeason."!<br>";
            if($z == 0) $Fnm = $FnmCurrentSeason;
            if(isset($FnmCurrentPlayoff) && $z == 1) $Fnm = $FnmCurrentPlayoff;
            if(!isset($FnmCurrentPlayoff) && $z == 1) break 1;
        }
        else {
            if($z == 0) {
                $Fnm = _getLeagueFile('TeamScoring', 'REG', $workSeason);
            }
            if($z == 1) {
                $Fnm = _getLeagueFile('TeamScoring', 'PLF', $workSeason);
            }
        }
        $b = 0;
        $e = 0;
        $f = 0;
        if(file_exists($Fnm)) {
            //echo "File: ".$Fnm."<br>";
            //if($z == 0) echo 'Season #'.$workSeason.'<br>';
            //if($z == 1) echo 'Playoff #'.$workSeason.'<br>';
            $tableau = file($Fnm);
            foreach ($tableau as $cle => $val) {
                //while(list($cle,$val) = each($tableau)) {
                $val = utf8_encode($val);
                if(substr_count($val, 'A NAME=') || substr_count($val, 'a name=')) {
                    //$reste = substr($val, strpos($val, '='), strpos($val, '</')-strpos($val, '='));
                    //$lastTeam = trim(substr($reste, strpos($reste, '>')+1));
                    $b = 1;
                }
                if($b && substr_count($val, '------------')) {
                    $e = 0;
                    if($f == 1) {
                        $b = 0;
                        $f = 0;
                    }
                }
                if($b && $e) {
                    $reste = trim($val);
                    if(!substr_count($val, '                         ')) {
                        $tmpFwdPosition = trim(substr($reste, 0, strpos($reste, ' ')));
                        $reste = trim(substr($reste, strpos($reste, ' ')));
                        $tmpFwdNumber = trim(substr($reste, 0, strpos($reste, ' ')));
                        $reste = trim(substr($reste, strpos($reste, ' ')));
                        if(substr($reste, 0, 1) == '*') {
                            $tmpFwdRookie = trim(substr($reste, 0, 1));
                            $reste = trim(substr($reste, 1));
                        }
                        else $tmpFwdRookie = '';
                        $tmpFwdHT2 = 0;
                    }
                    $tmpFwdPS = floatval(trim(substr($reste, strrpos($reste, ' ')))) * 1;
                    $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                    $tmpFwdGS = floatval(trim(substr($reste, strrpos($reste, ' ')))) * 1;
                    $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                    $tmpFwdPCTG = floatval(trim(substr($reste, strrpos($reste, ' ')))) * 1;
                    $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                    $tmpFwdS = floatval(trim(substr($reste, strrpos($reste, ' ')))) * 1;
                    $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                    $tmpFwdHT = floatval(trim(substr($reste, strrpos($reste, ' ')))) * 1;
                    $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                    $tmpFwdGT = floatval(trim(substr($reste, strrpos($reste, ' ')))) * 1;
                    $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                    $tmpFwdGW = floatval(trim(substr($reste, strrpos($reste, ' ')))) * 1;
                    $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                    $tmpFwdSHG = floatval(trim(substr($reste, strrpos($reste, ' ')))) * 1;
                    $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                    $tmpFwdPPG = floatval(trim(substr($reste, strrpos($reste, ' ')))) * 1;
                    $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                    $tmpFwdPIM = floatval(trim(substr($reste, strrpos($reste, ' ')))) * 1;
                    
                    $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                    $tmpFwdDiff = floatval(trim(substr($reste, strrpos($reste, ' ')))) * 1;
                    $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                    $tmpFwdP = floatval(trim(substr($reste, strrpos($reste, ' ')))) * 1;
                    $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                    $tmpFwdA = floatval(trim(substr($reste, strrpos($reste, ' ')))) * 1;
                    $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                    $tmpFwdG = floatval(trim(substr($reste, strrpos($reste, ' ')))) * 1;
                    $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                    $tmpFwdGP = floatval(trim(substr($reste, strrpos($reste, ' ')))) * 1;
                    $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                    $tmpFwdTeam = trim(substr($reste, strrpos($reste, ' ')));
                    if(!substr_count($val, '                         ')) {
                        $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                        $tmpFwdName = $reste;
                        if(substr_count($tmpFwdName, 'xtrastats.html')) {
                            $tmpFwdName = trim(substr($tmpFwdName, strpos($tmpFwdName, '"')+1, strpos($tmpFwdName, '>')-1-strpos($tmpFwdName, '"')-1));
                        }
                    }
                    
                    if((isset($TSabbr) && $TSabbr == $tmpFwdTeam) || ($ctlOneTeams == '' && $tmpFwdTeam != 'TOT')) {
                        $tmpVal = $tableau[$cle+1];
                        if(!substr_count($val, '                         ') && substr_count($tmpVal, '                         ')) {
                            $keyNumber = 0;
                            $tmpVal = '';
                            do {
                                if($tmpVal != '') {
                                    $reste2 = trim($tmpVal);
                                    $reste2 = trim(substr($reste2, 0, strrpos($reste2, ' ')));
                                    $reste2 = trim(substr($reste2, 0, strrpos($reste2, ' ')));
                                    $reste2 = trim(substr($reste2, 0, strrpos($reste2, ' ')));
                                    $reste2 = trim(substr($reste2, 0, strrpos($reste2, ' ')));
                                    $tmpFwdHTNext = substr($reste2, strrpos($reste2, ' '));
                                    $tmpFwdHTArray[] = $tmpFwdHTNext;
                                }
                                $keyNumber++;
                                $tmpVal = $tableau[$cle+$keyNumber];
                            }
                            while(substr_count($tmpVal, '                         '));
                            if(isset($tmpFwdHTArray)) {
                                $totHit = end($tmpFwdHTArray);
                                for($y=0;$y<count($tmpFwdHTArray)-1;$y++) {
                                    $totHit -= $tmpFwdHTArray[$y];
                                }
                                $tmpFwdHT = $totHit;
                                unset($tmpFwdHTArray);
                            }
                        }
                        
                        $tmpFound = 0;
                        if($z == 0) {
                            if(isset($statsFwdName)) {
                                for($v=0;$v<count($statsFwdName);$v++) {
                                    if($statsFwdName[$v] == $tmpFwdName) {
                                        //if($tmpFwdName == "Jarome Iginla") echo $workSeason.". ".$tmpFwdHT."<br>";
                                        $statsFwdPS[$v] += $tmpFwdPS;
                                        $statsFwdGS[$v] += $tmpFwdGS;
                                        //$statsFwdPCTG[$v] += $tmpFwdPCTG;
                                        $statsFwdS[$v] += $tmpFwdS;
                                        $statsFwdHT[$v] += $tmpFwdHT;
                                        $statsFwdGT[$v] += $tmpFwdGT;
                                        $statsFwdGW[$v] += $tmpFwdGW;
                                        $statsFwdSHG[$v] += $tmpFwdSHG;
                                        $statsFwdPPG[$v] += $tmpFwdPPG;
                                        $statsFwdPIM[$v] += $tmpFwdPIM;
                                        $statsFwdDiff[$v] += $tmpFwdDiff;
                                        $statsFwdP[$v] += $tmpFwdP;
                                        $statsFwdA[$v] += $tmpFwdA;
                                        $statsFwdG[$v] += $tmpFwdG;
                                        $statsFwdGP[$v] += $tmpFwdGP;
                                        $statsFwdPCTG[$v] = 0;
                                        if($statsFwdS[$v] != 0) {
                                            $statsFwdPCTG[$v] = round(($statsFwdG[$v] / $statsFwdS[$v] * 100), 1);
                                        }
                                        $tmpFound = 1;
                                        break 1;
                                    }
                                }
                            }
                            if($tmpFound == 0) {
                                //if($tmpFwdName == "Jarome Iginla") echo $workSeason.". ".$tmpFwdHT."<br>";
                                $statsFwdPosition[$i] = $tmpFwdPosition;
                                $statsFwdNumber[$i] = $tmpFwdNumber;
                                $statsFwdRookie[$i] = $tmpFwdRookie;
                                $statsFwdPS[$i] = $tmpFwdPS;
                                $statsFwdGS[$i] = $tmpFwdGS;
                                //$statsFwdPCTG[$i] = $tmpFwdPCTG;
                                $statsFwdS[$i] = $tmpFwdS;
                                $statsFwdHT[$i] = $tmpFwdHT;
                                $statsFwdGT[$i] = $tmpFwdGT;
                                $statsFwdGW[$i] = $tmpFwdGW;
                                $statsFwdSHG[$i] = $tmpFwdSHG;
                                $statsFwdPPG[$i] = $tmpFwdPPG;
                                $statsFwdPIM[$i] = $tmpFwdPIM;
                                $statsFwdDiff[$i] = $tmpFwdDiff;
                                $statsFwdP[$i] = $tmpFwdP;
                                $statsFwdA[$i] = $tmpFwdA;
                                $statsFwdG[$i] = $tmpFwdG;
                                $statsFwdGP[$i] = $tmpFwdGP;
                                $statsFwdTeam[$i] = $tmpFwdTeam;
                                $statsFwdName[$i] = $tmpFwdName;
                                $statsFwdPCTG[$i] = 0;
                                if($statsFwdS[$i] != 0) {
                                    $statsFwdPCTG[$i] = round(($statsFwdG[$i] / $statsFwdS[$i] * 100), 1);
                                }
                                $statsFwdSeason[$i] = $workSeason;
                                $i++;
                            }
                        }
                        if($z == 1) {
                            if(isset($statsFwdPLFName)) {
                                for($v=0;$v<count($statsFwdPLFName);$v++) {
                                    if($statsFwdPLFName[$v] == $tmpFwdName) {
                                        $statsFwdPLFPS[$v] += $tmpFwdPS;
                                        $statsFwdPLFGS[$v] += $tmpFwdGS;
                                        //$statsFwdPLFPCTG[$v] += $tmpFwdPCTG;
                                        $statsFwdPLFS[$v] += $tmpFwdS;
                                        $statsFwdPLFHT[$v] += $tmpFwdHT;
                                        $statsFwdPLFGT[$v] += $tmpFwdGT;
                                        $statsFwdPLFGW[$v] += $tmpFwdGW;
                                        $statsFwdPLFSHG[$v] += $tmpFwdSHG;
                                        $statsFwdPLFPPG[$v] += $tmpFwdPPG;
                                        $statsFwdPLFPIM[$v] += $tmpFwdPIM;
                                        $statsFwdPLFDiff[$v] += $tmpFwdDiff;
                                        $statsFwdPLFP[$v] += $tmpFwdP;
                                        $statsFwdPLFA[$v] += $tmpFwdA;
                                        $statsFwdPLFG[$v] += $tmpFwdG;
                                        $statsFwdPLFGP[$v] += $tmpFwdGP;
                                        $statsFwdPLFPCTG[$v] = 0;
                                        if($statsFwdPLFS[$v] != 0) {
                                            $statsFwdPLFPCTG[$v] = round(($statsFwdPLFG[$v] / $statsFwdPLFS[$v] * 100), 1);
                                        }
                                        $tmpFound = 1;
                                        break 1;
                                    }
                                }
                            }
                            if($tmpFound == 0) {
                                $statsFwdPLFPosition[$iPLF] = $tmpFwdPosition;
                                $statsFwdPLFNumber[$iPLF] = $tmpFwdNumber;
                                $statsFwdPLFRookie[$iPLF] = $tmpFwdRookie;
                                $statsFwdPLFPS[$iPLF] = $tmpFwdPS;
                                $statsFwdPLFGS[$iPLF] = $tmpFwdGS;
                                //$statsFwdPLFPCTG[$iPLF] = $tmpFwdPCTG;
                                $statsFwdPLFS[$iPLF] = $tmpFwdS;
                                $statsFwdPLFHT[$iPLF] = $tmpFwdHT;
                                $statsFwdPLFGT[$iPLF] = $tmpFwdGT;
                                $statsFwdPLFGW[$iPLF] = $tmpFwdGW;
                                $statsFwdPLFSHG[$iPLF] = $tmpFwdSHG;
                                $statsFwdPLFPPG[$iPLF] = $tmpFwdPPG;
                                $statsFwdPLFPIM[$iPLF] = $tmpFwdPIM;
                                $statsFwdPLFDiff[$iPLF] = $tmpFwdDiff;
                                $statsFwdPLFP[$iPLF] = $tmpFwdP;
                                $statsFwdPLFA[$iPLF] = $tmpFwdA;
                                $statsFwdPLFG[$iPLF] = $tmpFwdG;
                                $statsFwdPLFGP[$iPLF] = $tmpFwdGP;
                                $statsFwdPLFTeam[$iPLF] = $tmpFwdTeam;
                                $statsFwdPLFName[$iPLF] = $tmpFwdName;
                                $statsFwdPLFSeason[$iPLF] = $workSeason;
                                $statsFwdPLFPCTG[$iPLF] = 0;
                                if($statsFwdPLFS[$iPLF] != 0) {
                                    $statsFwdPLFPCTG[$iPLF] = round(($statsFwdPLFG[$iPLF] / $statsFwdPLFS[$iPLF] * 100), 1);
                                }
                                $iPLF++;
                            }
                        }
                        
                    }
                }
                if($b && $f) {
                    $reste = trim($val);
                    if(!substr_count($val, '                         ')) {
                        $tmpGoalPosition = 'G';
                        $tmpGoalNumber = trim(substr($reste, 0, strpos($reste, ' ')));
                        $reste = trim(substr($reste, strpos($reste, ' ')));
                        if(substr($reste, 0, 1) == '*') {
                            $tmpGoalRookie = trim(substr($reste, 0, 1));
                            $reste = trim(substr($reste, 1));
                        }
                        else $tmpGoalRookie = '';
                    }
                    $tmpGoalAS = floatval(trim(substr($reste, strrpos($reste, ' ')))) * 1;
                    $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                    $tmpGoalPIM = floatval(trim(substr($reste, strrpos($reste, ' ')))) * 1;
                    $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                    $tmpGoalPCT = floatval(trim(substr($reste, strrpos($reste, ' ')))) * 1;
                    $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                    $tmpGoalSA = floatval(trim(substr($reste, strrpos($reste, ' ')))) * 1;
                    $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                    $tmpGoalGA = floatval(trim(substr($reste, strrpos($reste, ' ')))) * 1;
                    $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                    $tmpGoalSO = floatval(trim(substr($reste, strrpos($reste, ' ')))) * 1;
                    $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                    $tmpGoalT = floatval(trim(substr($reste, strrpos($reste, ' ')))) * 1;
                    $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                    $tmpGoalL = floatval(trim(substr($reste, strrpos($reste, ' ')))) * 1;
                    $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                    $tmpGoalW = floatval(trim(substr($reste, strrpos($reste, ' ')))) * 1;
                    $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                    $tmpGoalAVG = floatval(trim(substr($reste, strrpos($reste, ' ')))) * 1;
                    $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                    $tmpGoalMin = floatval(trim(substr($reste, strrpos($reste, ' ')))) * 1;
                    $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                    $tmpGoalGP = floatval(trim(substr($reste, strrpos($reste, ' ')))) * 1;
                    $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                    $tmpGoalTeam = trim(substr($reste, strrpos($reste, ' ')));
                    if(!substr_count($val, '                         ')) {
                        $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                        $tmpGoalName = $reste;
                        if(substr_count($tmpGoalName, 'xtrastats.html')) {
                            $tmpGoalName = trim(substr($tmpGoalName, strpos($tmpGoalName, '"')+1, strpos($tmpGoalName, '>')-1-strpos($tmpGoalName, '"')-1));
                        }
                    }
                    
                    if((isset($TSabbr) && $TSabbr == $tmpGoalTeam) || ($ctlOneTeams == '' && $tmpFwdTeam != 'TOT')) {
                        //if($ctlOneTeams != '') echo 'Key:'.$cle.' - Season #'.$workSeason.' - Team Abbr:'.$TSabbr.' - Team Found:'.$tmpGoalTeam.' - Player:'.$tmpGoalName.'<br>';
                        $tmpCle = $cle + 1;
                        $tmpVal = $tableau[$tmpCle];
                        $tmpFound = 0;
                        if($z == 0) {
                            if(isset($statsGoalName) && $NumberSeason >= $workSeason) {
                                for($v=0;$v<count($statsGoalName);$v++) {
                                    if($statsGoalName[$v] == $tmpGoalName) {
                                        $statsGoalAS[$v] += $tmpGoalAS;
                                        $statsGoalPIM[$v] += $tmpGoalPIM;
                                        //$statsGoalPCT[$v] += $tmpGoalPCT;
                                        $statsGoalSA[$v] += $tmpGoalSA;
                                        $statsGoalGA[$v] += $tmpGoalGA;
                                        $statsGoalSO[$v] += $tmpGoalSO;
                                        $statsGoalT[$v] += $tmpGoalT;
                                        $statsGoalL[$v] += $tmpGoalL;
                                        $statsGoalW[$v] += $tmpGoalW;
                                        //$statsGoalAVG[$v] += $tmpGoalAVG;
                                        $statsGoalMin[$v] += $tmpGoalMin;
                                        $statsGoalGP[$v] += $tmpGoalGP;
                                        $statsGoalAVG[$v] = 0;
                                        if($statsGoalMin[$v] != 0) $statsGoalAVG[$v] = round($statsGoalGA[$v] * 60 / $statsGoalMin[$v], 2);
                                        $statsGoalPCT[$v] = 0;
                                        if($statsGoalSA[$v] != 0) $statsGoalPCT[$v] = round(($statsGoalSA[$v] - $statsGoalGA[$v]) / $statsGoalSA[$v], 3);
                                        $tmpFound = 1;
                                        break 1;
                                    }
                                }
                            }
                            if($tmpFound == 0) {
                                $statsGoalPosition[$j] = $tmpGoalPosition;
                                $statsGoalNumber[$j] = $tmpGoalNumber;
                                $statsGoalRookie[$j] = $tmpGoalRookie;
                                $statsGoalAS[$j] = $tmpGoalAS;
                                $statsGoalPIM[$j] = $tmpGoalPIM;
                                //$statsGoalPCT[$j] = $tmpGoalPCT;
                                $statsGoalSA[$j] = $tmpGoalSA;
                                $statsGoalGA[$j] = $tmpGoalGA;
                                $statsGoalSO[$j] = $tmpGoalSO;
                                $statsGoalT[$j] = $tmpGoalT;
                                $statsGoalL[$j] = $tmpGoalL;
                                $statsGoalW[$j] = $tmpGoalW;
                                //$statsGoalAVG[$j] = $tmpGoalAVG;
                                $statsGoalMin[$j] = $tmpGoalMin;
                                $statsGoalGP[$j] = $tmpGoalGP;
                                $statsGoalTeam[$j] = $tmpGoalTeam;
                                $statsGoalName[$j] = $tmpGoalName;
                                $statsGoalSeason[$j] = $workSeason;
                                $statsGoalAVG[$j] = 0;
                                if($statsGoalMin[$j] != 0) $statsGoalAVG[$j] = round($statsGoalGA[$j] * 60 / $statsGoalMin[$j], 2);
                                $statsGoalPCT[$j] = 0;
                                if($statsGoalSA[$j] != 0) $statsGoalPCT[$j] = round(($statsGoalSA[$j] - $statsGoalGA[$j]) / $statsGoalSA[$j], 3);
                                $j++;
                            }
                        }
                        if($z == 1) {
                            if(isset($statsGoalPLFName) && $NumberSeason >= $workSeason) {
                                for($v=0;$v<count($statsGoalPLFName);$v++) {
                                    if($statsGoalPLFName[$v] == $tmpGoalName) {
                                        $statsGoalPLFAS[$v] += $tmpGoalAS;
                                        $statsGoalPLFPIM[$v] += $tmpGoalPIM;
                                        //$statsGoalPLFPCT[$v] += $tmpGoalPCT;
                                        $statsGoalPLFSA[$v] += $tmpGoalSA;
                                        $statsGoalPLFGA[$v] += $tmpGoalGA;
                                        $statsGoalPLFSO[$v] += $tmpGoalSO;
                                        $statsGoalPLFT[$v] += $tmpGoalT;
                                        $statsGoalPLFL[$v] += $tmpGoalL;
                                        $statsGoalPLFW[$v] += $tmpGoalW;
                                        //$statsGoalPLFAVG[$v] += $tmpGoalAVG;
                                        $statsGoalPLFMin[$v] += $tmpGoalMin;
                                        $statsGoalPLFGP[$v] += $tmpGoalGP;
                                        $statsGoalPLFAVG[$v] = 0;
                                        if($statsGoalPLFMin[$v] != 0) $statsGoalPLFAVG[$v] = round($statsGoalPLFGA[$v] * 60 / $statsGoalPLFMin[$v], 2);
                                        $statsGoalPLFPCT[$v] = 0;
                                        if($statsGoalPLFSA[$v] != 0) $statsGoalPLFPCT[$v] = round(($statsGoalPLFSA[$v] - $statsGoalPLFGA[$v]) / $statsGoalPLFSA[$v], 3);
                                        $tmpFound = 1;
                                        break 1;
                                    }
                                }
                            }
                            if($tmpFound == 0) {
                                $statsGoalPLFPosition[$jPLF] = $tmpGoalPosition;
                                $statsGoalPLFNumber[$jPLF] = $tmpGoalNumber;
                                $statsGoalPLFRookie[$jPLF] = $tmpGoalRookie;
                                $statsGoalPLFAS[$jPLF] = $tmpGoalAS;
                                $statsGoalPLFPIM[$jPLF] = $tmpGoalPIM;
                                //$statsGoalPLFPCT[$jPLF] = $tmpGoalPCT;
                                $statsGoalPLFSA[$jPLF] = $tmpGoalSA;
                                $statsGoalPLFGA[$jPLF] = $tmpGoalGA;
                                $statsGoalPLFSO[$jPLF] = $tmpGoalSO;
                                $statsGoalPLFT[$jPLF] = $tmpGoalT;
                                $statsGoalPLFL[$jPLF] = $tmpGoalL;
                                $statsGoalPLFW[$jPLF] = $tmpGoalW;
                                //$statsGoalPLFAVG[$jPLF] = $tmpGoalAVG;
                                $statsGoalPLFMin[$jPLF] = $tmpGoalMin;
                                $statsGoalPLFGP[$jPLF] = $tmpGoalGP;
                                $statsGoalPLFTeam[$jPLF] = $tmpGoalTeam;
                                $statsGoalPLFName[$jPLF] = $tmpGoalName;
                                $statsGoalPLFSeason[$jPLF] = $workSeason;
                                $statsGoalPLFAVG[$jPLF] = 0;
                                if($statsGoalPLFMin[$jPLF] != 0) $statsGoalPLFAVG[$jPLF] = round($statsGoalPLFGA[$jPLF] * 60 / $statsGoalPLFMin[$jPLF], 2);
                                $statsGoalPLFPCT[$jPLF] = 0;
                                if($statsGoalPLFSA[$jPLF] != 0) $statsGoalPLFPCT[$jPLF] = round(($statsGoalPLFSA[$jPLF] - $statsGoalPLFGA[$jPLF]) / $statsGoalPLFSA[$jPLF], 3);
                                $jPLF++;
                            }
                        }
                        
                    }
                }
                if($b && substr_count($val, 'PCTG') ) {
                    $e = 1;
                }
                if($b && substr_count($val, 'AVG') ) {
                    $f = 1;
                }
            }
        }
        else {
           // if($z == 0) echo $allFileNotFound.' - Season #'.$workSeason."<br>"; 
           // if($z == 1) echo $allFileNotFound.' - Playoff #'.$workSeason."<br>";
            if(DEBUG_MODE){
                if($z == 0) echo $allFileNotFound.' - Season #'.$workSeason."<br>";
                if($z == 1) echo $allFileNotFound.' - Playoff #'.$workSeason."<br>";
            }
        }
    }
}

if(isset($statsFwdName)) {
	for($i=0;$i<count($statsFwdName);$i++) {
		$statsFwdCount[$i] = $i;
	}
}
if(isset($statsGoalName)) {
	for($i=0;$i<count($statsGoalName);$i++) {
		$statsGoalCount[$i] = $i;
	}
}
if(isset($statsFwdPLFName)) {
	for($i=0;$i<count($statsFwdPLFName);$i++) {
		$statsFwdPLFCount[$i] = $i;
	}
}
if(isset($statsGoalPLFName)) {
	for($i=0;$i<count($statsGoalPLFName);$i++) {
		$statsGoalPLFCount[$i] = $i;
	}
}

if(!isset($statsFwdPosition)) {
	$statsFwdPosition = array();
	$statsFwdNumber = array();
	$statsFwdRookie = array();
	$statsFwdPCTG = array();
	$statsFwdS = array();
	$statsFwdHT = array();
	$statsFwdGT = array();
	$statsFwdGW = array();
	$statsFwdSHG = array();
	$statsFwdPPG = array();
	$statsFwdPIM = array();
	$statsFwdDiff = array();
	$statsFwdP = array();
	$statsFwdA = array();
	$statsFwdG = array();
	$statsFwdGP = array();
	$statsFwdTeam = array();
	$statsFwdName = array();
	$statsFwdSeason = array();
	$statsFwdCount = array();
}
if(!isset($statsGoalPosition)) {
	$statsGoalPosition = array();
	$statsGoalNumber = array();
	$statsGoalRookie = array();
	$statsGoalAS = array();
	$statsGoalPIM = array();
	$statsGoalPCT = array();
	$statsGoalSA = array();
	$statsGoalGA = array();
	$statsGoalSO = array();
	$statsGoalT = array();
	$statsGoalL = array();
	$statsGoalW = array();
	$statsGoalMin = array();
	$statsGoalAVG = array();
	$statsGoalGP = array();
	$statsGoalTeam = array();
	$statsGoalName = array();
	$statsGoalSeason = array();
	$statsGoalCount = array();
}

if(!isset($statsFwdPLFPosition)) {
	$statsFwdPLFPosition = array();
	$statsFwdPLFNumber = array();
	$statsFwdPLFRookie = array();
	$statsFwdPLFPCTG = array();
	$statsFwdPLFS = array();
	$statsFwdPLFHT = array();
	$statsFwdPLFGT = array();
	$statsFwdPLFGW = array();
	$statsFwdPLFSHG = array();
	$statsFwdPLFPPG = array();
	$statsFwdPLFPIM = array();
	$statsFwdPLFDiff = array();
	$statsFwdPLFP = array();
	$statsFwdPLFA = array();
	$statsFwdPLFG = array();
	$statsFwdPLFGP = array();
	$statsFwdPLFTeam = array();
	$statsFwdPLFName = array();
	$statsFwdPLFSeason = array();
	$statsFwdPLFCount = array();
}
if(!isset($statsGoalPLFPosition)) {
	$statsGoalPLFPosition = array();
	$statsGoalPLFNumber = array();
	$statsGoalPLFRookie = array();
	$statsGoalPLFAS = array();
	$statsGoalPLFPIM = array();
	$statsGoalPLFPCT = array();
	$statsGoalPLFSA = array();
	$statsGoalPLFGA = array();
	$statsGoalPLFSO = array();
	$statsGoalPLFT = array();
	$statsGoalPLFL = array();
	$statsGoalPLFW = array();
	$statsGoalPLFMin = array();
	$statsGoalPLFAVG = array();
	$statsGoalPLFGP = array();
	$statsGoalPLFTeam = array();
	$statsGoalPLFName = array();
	$statsGoalPLFSeason = array();
	$statsGoalPLFCount = array();
}
?>

<script type="text/javascript">
<!--

// Season - Foward
var seasonFwdPO = <?php echo json_encode($statsFwdPosition)?>;
//var seasonFwdNB = <?php echo json_encode($statsFwdNumber)?>;
//var seasonFwdRK = <?php echo json_encode($statsFwdRookie)?>;
var seasonFwdPG = <?php echo json_encode($statsFwdPCTG)?>;
var seasonFwdST = <?php echo json_encode($statsFwdS)?>;
var seasonFwdHT = <?php echo json_encode($statsFwdHT)?>;
var seasonFwdGT = <?php echo json_encode($statsFwdGT)?>;
var seasonFwdGW = <?php echo json_encode($statsFwdGW)?>;
var seasonFwdSH = <?php echo json_encode($statsFwdSHG)?>;
var seasonFwdPP = <?php echo json_encode($statsFwdPPG)?>;
var seasonFwdPM = <?php echo json_encode($statsFwdPIM)?>;
var seasonFwdDF = <?php echo json_encode($statsFwdDiff)?>;
var seasonFwdPT = <?php echo json_encode($statsFwdP)?>;
var seasonFwdAT = <?php echo json_encode($statsFwdA)?>;
var seasonFwdGO = <?php echo json_encode($statsFwdG)?>;
var seasonFwdGP = <?php echo json_encode($statsFwdGP)?>;
//var seasonFwdTM = <?php echo json_encode($statsFwdTeam)?>;
var seasonFwdNM = <?php echo json_encode($statsFwdName)?>;
var seasonFwdSE = <?php echo json_encode($statsFwdSeason)?>;
var seasonFwdCP = <?php echo json_encode($statsFwdCount)?>;

// Season - Goaltender
var seasonGoalPO = <?php echo json_encode($statsGoalPosition)?>;
//var seasonGoalNB = <?php echo json_encode($statsGoalNumber)?>;
//var seasonGoalRK = <?php echo json_encode($statsGoalRookie)?>;
var seasonGoalAS = <?php echo json_encode($statsGoalAS)?>;
var seasonGoalPM = <?php echo json_encode($statsGoalPIM)?>;
var seasonGoalPC = <?php echo json_encode($statsGoalPCT)?>;
var seasonGoalSA = <?php echo json_encode($statsGoalSA)?>;
var seasonGoalGA = <?php echo json_encode($statsGoalGA)?>;
var seasonGoalSO = <?php echo json_encode($statsGoalSO)?>;
var seasonGoalTI = <?php echo json_encode($statsGoalT)?>;
var seasonGoalLO = <?php echo json_encode($statsGoalL)?>;
var seasonGoalWI = <?php echo json_encode($statsGoalW)?>;
var seasonGoalMN = <?php echo json_encode($statsGoalMin)?>;
var seasonGoalAV = <?php echo json_encode($statsGoalAVG)?>;
var seasonGoalGP = <?php echo json_encode($statsGoalGP)?>;
//var seasonGoalTM = <?php echo json_encode($statsGoalTeam)?>;
var seasonGoalNM = <?php echo json_encode($statsGoalName)?>;
var seasonGoalSE = <?php echo json_encode($statsGoalSeason)?>;
var seasonGoalCP = <?php echo json_encode($statsGoalCount)?>;

// Playoff - Foward
var playoffFwdPO = <?php echo json_encode($statsFwdPLFPosition)?>;
var playoffFwdNB = <?php echo json_encode($statsFwdPLFNumber)?>;
var playoffFwdRK = <?php echo json_encode($statsFwdPLFRookie)?>;
var playoffFwdPG = <?php echo json_encode($statsFwdPLFPCTG)?>;
var playoffFwdST = <?php echo json_encode($statsFwdPLFS)?>;
var playoffFwdHT = <?php echo json_encode($statsFwdPLFHT)?>;
var playoffFwdGT = <?php echo json_encode($statsFwdPLFGT)?>;
var playoffFwdGW = <?php echo json_encode($statsFwdPLFGW)?>;
var playoffFwdSH = <?php echo json_encode($statsFwdPLFSHG)?>;
var playoffFwdPP = <?php echo json_encode($statsFwdPLFPPG)?>;
var playoffFwdPM = <?php echo json_encode($statsFwdPLFPIM)?>;
var playoffFwdDF = <?php echo json_encode($statsFwdPLFDiff)?>;
var playoffFwdPT = <?php echo json_encode($statsFwdPLFP)?>;
var playoffFwdAT = <?php echo json_encode($statsFwdPLFA)?>;
var playoffFwdGO = <?php echo json_encode($statsFwdPLFG)?>;
var playoffFwdGP = <?php echo json_encode($statsFwdPLFGP)?>;
var playoffFwdTM = <?php echo json_encode($statsFwdPLFTeam)?>;
var playoffFwdNM = <?php echo json_encode($statsFwdPLFName)?>;
var playoffFwdSE = <?php echo json_encode($statsFwdPLFSeason)?>;
var playoffFwdCP = <?php echo json_encode($statsFwdPLFCount)?>;

// Playoff - Goaltender
var playoffGoalPO = <?php echo json_encode($statsGoalPLFPosition)?>;
var playoffGoalNB = <?php echo json_encode($statsGoalPLFNumber)?>;
var playoffGoalRK = <?php echo json_encode($statsGoalPLFRookie)?>;
var playoffGoalAS = <?php echo json_encode($statsGoalPLFAS)?>;
var playoffGoalPM = <?php echo json_encode($statsGoalPLFPIM)?>;
var playoffGoalPC = <?php echo json_encode($statsGoalPLFPCT)?>;
var playoffGoalSA = <?php echo json_encode($statsGoalPLFSA)?>;
var playoffGoalGA = <?php echo json_encode($statsGoalPLFGA)?>;
var playoffGoalSO = <?php echo json_encode($statsGoalPLFSO)?>;
var playoffGoalTI = <?php echo json_encode($statsGoalPLFT)?>;
var playoffGoalLO = <?php echo json_encode($statsGoalPLFL)?>;
var playoffGoalWI = <?php echo json_encode($statsGoalPLFW)?>;
var playoffGoalMN = <?php echo json_encode($statsGoalPLFMin)?>;
var playoffGoalAV = <?php echo json_encode($statsGoalPLFAVG)?>;
var playoffGoalGP = <?php echo json_encode($statsGoalPLFGP)?>;
var playoffGoalTM = <?php echo json_encode($statsGoalPLFTeam)?>;
var playoffGoalNM = <?php echo json_encode($statsGoalPLFName)?>;
var playoffGoalSE = <?php echo json_encode($statsGoalPLFSeason)?>;
var playoffGoalCP = <?php echo json_encode($statsGoalPLFCount)?>;

function result(tmpSearch) {
	document.getElementById("windowResult").textContent = "";
	
	var select = document.getElementById('position');
	var currentPosition = select.options[select.selectedIndex].value; 

	//var currentPosition = document.querySelector('input[name="position"]:checked').value;
	//var currentSeason = document.querySelector('input[name="season"]:checked').value;
	var selectSeason = document.getElementById('season');
	var currentSeason = selectSeason.options[selectSeason.selectedIndex].value; 

	
	
	var currentType = 0;
	if(tmpSearch != 'X') var currentSearch = tmpSearch;
	if(tmpSearch == 'X') var currentSearch = 'PT';
	if(currentPosition == 'G') {
		currentType = 1;
		if(tmpSearch == 'X') var currentSearch = 'MN';
	}
	var result = document.getElementById("windowResult");
	var tbl = document.createElement('table');
		tbl.style.width='100%';
		tbl.className = "table table-sm table-striped table-rounded";
	var thead = document.createElement('thead');
	var tbdy = document.createElement('tbody');
	// Entête - Header
	if(currentType == 0) {
		var tr = document.createElement('tr');
			tr.className = "tableau-top";
		var td = document.createElement('th');
			td.appendChild(document.createTextNode(''));
			tr.appendChild(td);
		var td = document.createElement('th');
			td.style.textAlign = "left";
			td.setAttribute("data-toggle","tooltip");
			td.setAttribute("data-placement","top");
			td.setAttribute("title","<?php echo $rostersPosition?>");
			td.innerHTML = 'PO';
			tr.appendChild(td);
		var td = document.createElement('th');
			td.style.textAlign = "left";
			td.setAttribute("data-toggle","tooltip");
			td.setAttribute("data-placement","top");
			td.setAttribute("title","<?php echo $scoringName?>");
			td.innerHTML = '<?php echo $scoringName;?>';
			tr.appendChild(td);
		var td = document.createElement('th');
			td.style.textAlign = "center";
			td.setAttribute("data-search","GP");
			td.setAttribute("data-toggle","tooltip");
			td.setAttribute("data-placement","top");
			td.setAttribute("title","<?php echo $scoringGP?>");
			td.innerHTML = '<?php echo $scoringGPm;?>';
			tr.appendChild(td);
		var td = document.createElement('th');
			td.style.textAlign = "center";
			td.setAttribute("data-search","GO");
			td.setAttribute("data-toggle","tooltip");
			td.setAttribute("data-placement","top");
			td.setAttribute("title","<?php echo $scoringG?>");
			td.innerHTML = '<?php echo $scoringGm;?>';
			tr.appendChild(td);
		
		var td = document.createElement('th');
			td.style.textAlign = "center";
			td.setAttribute("data-search","AT");
			td.setAttribute("data-toggle","tooltip");
			td.setAttribute("data-placement","top");
			td.setAttribute("title","<?php echo $scoringAssits?>");
			td.innerHTML = 'A';
			tr.appendChild(td);

		var td = document.createElement('th');
			td.style.textAlign = "center";
			td.setAttribute("data-search","PT");
			td.setAttribute("data-toggle","tooltip");
			td.setAttribute("data-placement","top");
			td.setAttribute("title","Points");
			td.innerHTML = 'P';
			tr.appendChild(td);
			
		var td = document.createElement('th');
			td.style.textAlign = "center";
			td.setAttribute("data-search","DF");
			td.setAttribute("data-toggle","tooltip");
			td.setAttribute("data-placement","top");
			td.setAttribute("title","<?php echo $scoringDiff?>");
			td.innerHTML = '+/-';
			tr.appendChild(td);

		var td = document.createElement('th');
			td.style.textAlign = "center";
			td.setAttribute("data-search","PM");
			td.setAttribute("data-toggle","tooltip");
			td.setAttribute("data-placement","top");
			td.setAttribute("title","<?php echo $scoringPIM?>");
			td.innerHTML = '<?php echo $scoringPIMm; ?>';
			tr.appendChild(td);
		
		var td = document.createElement('th');
			td.style.textAlign = "center";
			td.setAttribute("data-search","PP");
			td.setAttribute("data-toggle","tooltip");
			td.setAttribute("data-placement","top");
			td.setAttribute("title","<?php echo $scoringPP?>");
			td.innerHTML = '<?php echo $scoringPPm; ?>';
			tr.appendChild(td);
		
		var td = document.createElement('th');
			td.style.textAlign = "center";
			td.setAttribute("data-search","SH");
			td.setAttribute("data-toggle","tooltip");
			td.setAttribute("data-placement","top");
			td.setAttribute("title","<?php echo $scoringSH?>");
			td.innerHTML = '<?php echo $scoringSHm; ?>';
			tr.appendChild(td);

		var td = document.createElement('th');
			td.style.textAlign = "center";
			td.setAttribute("data-search","GW");
			td.setAttribute("data-toggle","tooltip");
			td.setAttribute("data-placement","top");
			td.setAttribute("title","<?php echo $scoringGW?>");
			td.innerHTML = '<?php echo $scoringGWm; ?>';
			tr.appendChild(td);

		var td = document.createElement('th');
			td.style.textAlign = "center";
			td.setAttribute("data-search","GT");
			td.setAttribute("data-toggle","tooltip");
			td.setAttribute("data-placement","top");
			td.setAttribute("title","<?php echo $scoringGT?>");
			td.innerHTML = '<?php echo $scoringGTm; ?>';
			tr.appendChild(td);
		
		var td = document.createElement('th');
			td.style.textAlign = "center";
			td.setAttribute("data-search","HT");
			td.setAttribute("data-toggle","tooltip");
			td.setAttribute("data-placement","top");
			td.setAttribute("title","<?php echo $scoringHT?>");
			td.innerHTML = '<?php echo $scoringHTm; ?>';
			tr.appendChild(td);
			
		var td = document.createElement('th');
			td.style.textAlign = "center";
			td.setAttribute("data-search","ST");
			td.setAttribute("data-toggle","tooltip");
			td.setAttribute("data-placement","top");
			td.setAttribute("title","<?php echo $scoringS?>");
			td.innerHTML = '<?php echo $scoringSm; ?>';
			tr.appendChild(td);
			
		var td = document.createElement('th');
			td.style.textAlign = "center";
			td.setAttribute("data-search","PG");
			td.setAttribute("data-toggle","tooltip");
			td.setAttribute("data-placement","top");
			td.setAttribute("title","<?php echo $scoringPCTG?>");
			td.innerHTML = '<?php echo $scoringPCTGm; ?>';
			tr.appendChild(td);
			td.style.textAlign = "center";
			
		thead.appendChild(tr);
		if(typeof seasonFwdNM != 'undefined') {
			var zipped = [];
			var tmpTransF = [];
			if(currentSeason == 0) {
				if(currentSearch == 'GP') tmpTransF = seasonFwdGP;
				if(currentSearch == 'GO') tmpTransF = seasonFwdGO;
				if(currentSearch == 'AT') tmpTransF = seasonFwdAT;
				if(currentSearch == 'PT') tmpTransF = seasonFwdPT;
				if(currentSearch == 'DF') tmpTransF = seasonFwdDF;
				if(currentSearch == 'PM') tmpTransF = seasonFwdPM;
				if(currentSearch == 'PP') tmpTransF = seasonFwdPP;
				if(currentSearch == 'SH') tmpTransF = seasonFwdSH;
				if(currentSearch == 'GW') tmpTransF = seasonFwdGW;
				if(currentSearch == 'GT') tmpTransF = seasonFwdGT;
				if(currentSearch == 'HT') tmpTransF = seasonFwdHT;
				if(currentSearch == 'ST') tmpTransF = seasonFwdST;
				if(currentSearch == 'PG') tmpTransF = seasonFwdPG;
				for(i=0; i<seasonFwdNM.length; ++i) {
					zipped.push({
						attr: tmpTransF[i],
						id: seasonFwdCP[i]
					});
				}
			}
			if(currentSeason == 1) {
				if(currentSearch == 'GP') tmpTransF = playoffFwdGP;
				if(currentSearch == 'GO') tmpTransF = playoffFwdGO;
				if(currentSearch == 'AT') tmpTransF = playoffFwdAT;
				if(currentSearch == 'PT') tmpTransF = playoffFwdPT;
				if(currentSearch == 'DF') tmpTransF = playoffFwdDF;
				if(currentSearch == 'PM') tmpTransF = playoffFwdPM;
				if(currentSearch == 'PP') tmpTransF = playoffFwdPP;
				if(currentSearch == 'SH') tmpTransF = playoffFwdSH;
				if(currentSearch == 'GW') tmpTransF = playoffFwdGW;
				if(currentSearch == 'GT') tmpTransF = playoffFwdGT;
				if(currentSearch == 'HT') tmpTransF = playoffFwdHT;
				if(currentSearch == 'ST') tmpTransF = playoffFwdST;
				if(currentSearch == 'PG') tmpTransF = playoffFwdPG;
				for(i=0; i<playoffFwdNM.length; ++i) {
					zipped.push({
						attr: tmpTransF[i],
						id: playoffFwdCP[i]
					});
				}
			}
			zipped.sort(function(left, right) {
				var leftArray1elem = left.attr,
					rightArray1elem = right.attr;
				return leftArray1elem === rightArray1elem ? 0 : (leftArray1elem < rightArray1elem ? -1 : 1);
			});
			zipped.reverse(); 
			
			var c = 1;
			var d = 0;
			if(currentSeason == 0) {
				for(var i=0;i<seasonFwdNM.length;i++) {
					if(zipped[i]['attr'] == 0) break;
					if(currentPosition == '0' || currentPosition == seasonFwdPO[zipped[i]['id']]) {
						if(c == 2) c = 1;
						else c = 2;
						var tr = showPlayer(zipped[i]['id'],c,d,currentSearch);
						tbdy.appendChild(tr);
						d++;
					}
					if(d == 100) break;
				}
			}
			if(currentSeason == 1) {
				for(var i=0;i<playoffFwdNM.length;i++) {
					if(zipped[i]['attr'] == 0) break;
					if(currentPosition == '0' || currentPosition == playoffFwdPO[zipped[i]['id']]) {
						if(c == 2) c = 1;
						else c = 2;
						var tr = showPlayerPLF(zipped[i]['id'],c,d,currentSearch);
						tbdy.appendChild(tr);
						d++;
					}
					if(d == 100) break;
				}
			}
		}
		
	}
	if(currentType == 1) {
		var tr = document.createElement('tr');
			tr.className = "tableau-top";
		var td = document.createElement('td');
				td.appendChild(document.createTextNode(''));
			tr.appendChild(td);
		var td = document.createElement('td');
			var a = document.createElement('a');
				a.href = "javascript:return;";
				a.className = "info";
				a.style.width = "100%";
				a.style.display = "block";
				a.appendChild(document.createTextNode('PO'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('Position'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
		var td = document.createElement('td');
			var a = document.createElement('a');
				a.href = "javascript:return;";
				a.className = "lien-blanc";
				a.appendChild(document.createTextNode('<?php echo $scoringName; ?>'));
				td.appendChild(a);
			tr.appendChild(td);
		var td = document.createElement('td');
			td.style.textAlign = "center";
			if(currentSearch == 'GP') td.style.fontWeight = "bold";
			var a = document.createElement('a');
				a.href = "javascript:search('GP');";
				a.className = "info";
				a.style.width = "100%";
				a.style.display = "block";
				a.appendChild(document.createTextNode('<?php echo $scoringGPm; ?>'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('<?php echo $scoringGP; ?>'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
		var td = document.createElement('td');
			td.style.textAlign = "center";
			if(currentSearch == 'MN') td.style.fontWeight = "bold";
			var a = document.createElement('a');
				a.href = "javascript:search('MN');";
				a.className = "info";
				a.style.width = "100%";
				a.style.display = "block";
				a.appendChild(document.createTextNode('MIN'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('<?php echo $scoringMIN; ?>'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
		var td = document.createElement('td');
			td.style.textAlign = "center";
			if(currentSearch == 'AV') td.style.fontWeight = "bold";
			var a = document.createElement('a');
				a.href = "javascript:search('AV');";
				a.className = "info";
				a.style.width = "100%";
				a.style.display = "block";
				a.appendChild(document.createTextNode('<?php echo $scoringAVGm; ?>'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('<?php echo $scoringAVG; ?>'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
		var td = document.createElement('td');
			td.style.textAlign = "center";
			if(currentSearch == 'WI') td.style.fontWeight = "bold";
			var a = document.createElement('a');
				a.href = "javascript:search('WI');";
				a.className = "info";
				a.style.width = "100%";
				a.style.display = "block";
				a.appendChild(document.createTextNode('<?php echo $scoringWm; ?>'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('<?php echo $scoringW; ?>'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
		var td = document.createElement('td');
			td.style.textAlign = "center";
			if(currentSearch == 'LO') td.style.fontWeight = "bold";
			var a = document.createElement('a');
				a.href = "javascript:search('LO');";
				a.className = "info";
				a.style.width = "100%";
				a.style.display = "block";
				a.appendChild(document.createTextNode('<?php echo $scoringLm; ?>'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('<?php echo $scoringL; ?>'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
		var td = document.createElement('td');
			td.style.textAlign = "center";
			if(currentSearch == 'TI') td.style.fontWeight = "bold";
			var a = document.createElement('a');
				a.href = "javascript:search('TI');";
				a.className = "info";
				a.style.width = "100%";
				a.style.display = "block";
				a.appendChild(document.createTextNode('<?php echo $scoringTm; ?>'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('<?php echo $scoringT; ?>'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
		var td = document.createElement('td');
			td.style.textAlign = "center";
			if(currentSearch == 'SO') td.style.fontWeight = "bold";
			var a = document.createElement('a');
				a.href = "javascript:search('SO');";
				a.className = "info";
				a.style.width = "100%";
				a.style.display = "block";
				a.appendChild(document.createTextNode('<?php echo $scoringSOm; ?>'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('<?php echo $scoringSO; ?>'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
		var td = document.createElement('td');
			td.style.textAlign = "center";
			if(currentSearch == 'GA') td.style.fontWeight = "bold";
			var a = document.createElement('a');
				a.href = "javascript:search('GA');";
				a.className = "info";
				a.style.width = "100%";
				a.style.display = "block";
				a.appendChild(document.createTextNode('<?php echo $scoringGAm; ?>'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('<?php echo $scoringGA; ?>'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
		var td = document.createElement('td');
			td.style.textAlign = "center";
			if(currentSearch == 'SA') td.style.fontWeight = "bold";
			var a = document.createElement('a');
				a.href = "javascript:search('SA');";
				a.className = "info";
				a.style.width = "100%";
				a.style.display = "block";
				a.appendChild(document.createTextNode('<?php echo $scoringSAm; ?>'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('<?php echo $scoringSA; ?>'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
		var td = document.createElement('td');
			td.style.textAlign = "center";
			if(currentSearch == 'PC') td.style.fontWeight = "bold";
			var a = document.createElement('a');
				a.href = "javascript:search('PC');";
				a.className = "info";
				a.style.width = "100%";
				a.style.display = "block";
				a.appendChild(document.createTextNode('PCT'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('<?php echo addslashes($scoringPCT); ?>'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
		var td = document.createElement('td');
			td.style.textAlign = "center";
			if(currentSearch == 'PM') td.style.fontWeight = "bold";
			var a = document.createElement('a');
				a.href = "javascript:search('PM');";
				a.className = "info";
				a.style.width = "100%";
				a.style.display = "block";
				a.appendChild(document.createTextNode('<?php echo $scoringPIMm; ?>'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('<?php echo $scoringPIM; ?>'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
		var td = document.createElement('td');
			td.style.textAlign = "center";
			if(currentSearch == 'AS') td.style.fontWeight = "bold";
			var a = document.createElement('a');
				a.href = "javascript:search('AS');";
				a.className = "info";
				a.style.width = "100%";
				a.style.display = "block";
				a.appendChild(document.createTextNode('AS'));
				td.appendChild(a);
			tr.appendChild(td);
		tbdy.appendChild(tr);
		if(typeof seasonGoalNM != 'undefined') {
			var zipped = [];
			var tmpTransF = [];
			if(currentSeason == 0) {
				if(currentSearch == 'GP') tmpTransF = seasonGoalGP;
				if(currentSearch == 'AV') tmpTransF = seasonGoalAV;
				if(currentSearch == 'MN') tmpTransF = seasonGoalMN;
				if(currentSearch == 'WI') tmpTransF = seasonGoalWI;
				if(currentSearch == 'LO') tmpTransF = seasonGoalLO;
				if(currentSearch == 'TI') tmpTransF = seasonGoalTI;
				if(currentSearch == 'SO') tmpTransF = seasonGoalSO;
				if(currentSearch == 'GA') tmpTransF = seasonGoalGA;
				if(currentSearch == 'SA') tmpTransF = seasonGoalSA;
				if(currentSearch == 'PC') tmpTransF = seasonGoalPC;
				if(currentSearch == 'PM') tmpTransF = seasonGoalPM;
				if(currentSearch == 'AS') tmpTransF = seasonGoalAS;
				for(i=0; i<seasonGoalNM.length; ++i) {
					zipped.push({
						attr: tmpTransF[i],
						id: seasonGoalCP[i]
					});
				}
			}
			if(currentSeason == 1) {
				if(currentSearch == 'GP') tmpTransF = playoffGoalGP;
				if(currentSearch == 'AV') tmpTransF = playoffGoalAV;
				if(currentSearch == 'MN') tmpTransF = playoffGoalMN;
				if(currentSearch == 'WI') tmpTransF = playoffGoalWI;
				if(currentSearch == 'LO') tmpTransF = playoffGoalLO;
				if(currentSearch == 'TI') tmpTransF = playoffGoalTI;
				if(currentSearch == 'SO') tmpTransF = playoffGoalSO;
				if(currentSearch == 'GA') tmpTransF = playoffGoalGA;
				if(currentSearch == 'SA') tmpTransF = playoffGoalSA;
				if(currentSearch == 'PC') tmpTransF = playoffGoalPC;
				if(currentSearch == 'PM') tmpTransF = playoffGoalPM;
				if(currentSearch == 'AS') tmpTransF = playoffGoalAS;
				for(i=0; i<playoffGoalNM.length; ++i) {
					zipped.push({
						attr: tmpTransF[i],
						id: playoffGoalCP[i]
					});
				}
			}
			zipped.sort(function(left, right) {
				var leftArray1elem = left.attr,
					rightArray1elem = right.attr;
				return leftArray1elem === rightArray1elem ? 0 : (leftArray1elem < rightArray1elem ? -1 : 1);
			});
			if(currentSearch != 'AV') zipped.reverse(); 
			var c = 1;
			var d = 0;
			if(currentSeason == 0) {
				for(var i=0;i<seasonGoalNM.length;i++) {
					if(zipped[i]['attr'] != 0) {
						if(c == 2) c = 1;
						else c = 2;
						var tr = showPlayerGoal(zipped[i]['id'],c,i,currentSearch);
						tbdy.appendChild(tr);
						d++;
					}
					if(d == 50) break;
				}
			}
			if(currentSeason == 1) {
				for(var i=0;i<playoffGoalNM.length;i++) {
					if(zipped[i]['attr'] != 0) {
						if(c == 2) c = 1;
						else c = 2;
						var tr = showPlayerGoalPLF(zipped[i]['id'],c,i,currentSearch);
						tbdy.appendChild(tr);
						d++;
					}
					if(d == 50) break;
				}
			}
		}
	}

	tbl.appendChild(thead);
	tbl.appendChild(tbdy);
	result.appendChild(tbl);
	document.getElementById("windowResult").style.display = "block";
}

function showPlayer(i,c,d,currentSearch) {
	d = d + 1;
	var tr = document.createElement('tr');
		tr.className = "hover"+c;
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(d));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(seasonFwdPO[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
			var a = document.createElement('a');
			a.className = "lien-noir";
			a.style.display = "block";
			a.style.width = "100%";
			a.href = "CareerStatsPlayer.php?csName="+encodeURIComponent(seasonFwdNM[i]);
			//a.target = "_blank";
			a.appendChild(document.createTextNode(seasonFwdNM[i]));
			td.appendChild(a);
		td.style.textAlign = "left";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'GP') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(seasonFwdGP[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'GO') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(seasonFwdGO[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'AT') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(seasonFwdAT[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'PT') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(seasonFwdPT[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'DF') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(seasonFwdDF[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'PM') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(seasonFwdPM[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'PP') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(seasonFwdPP[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'SH') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(seasonFwdSH[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'GW') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(seasonFwdGW[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'GT') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(seasonFwdGT[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'HT') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(seasonFwdHT[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'ST') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(seasonFwdST[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'PG') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(seasonFwdPG[i]));
		tr.appendChild(td);
	return tr;
}
function showPlayerGoal(i,c,d,currentSearch) {
	d = d + 1;
	var tr = document.createElement('tr');
		tr.className = "hover"+c;
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(d));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(seasonGoalPO[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
			var a = document.createElement('a');
			a.className = "lien-noir";
			a.style.display = "block";
			a.style.width = "100%";
			a.href = "CareerStatsPlayer.php?csName="+encodeURIComponent(seasonGoalNM[i]);
			a.target = "_blank";
			a.appendChild(document.createTextNode(seasonGoalNM[i]));
			td.appendChild(a);
		td.style.textAlign = "left";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'GP') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(seasonGoalGP[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'MN') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(seasonGoalMN[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'AV') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(seasonGoalAV[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'WI') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(seasonGoalWI[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'LO') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(seasonGoalLO[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'TI') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(seasonGoalTI[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'SO') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(seasonGoalSO[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'GA') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(seasonGoalGA[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'SA') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(seasonGoalSA[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'PC') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(seasonGoalPC[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'PM') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(seasonGoalPM[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'AS') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(seasonGoalAS[i]));
		tr.appendChild(td);
	return tr;
}
function showPlayerPLF(i,c,d,currentSearch) {
	d = d + 1;
	var tr = document.createElement('tr');
		tr.className = "hover"+c;
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(d));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(playoffFwdPO[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
			var a = document.createElement('a');
			a.className = "lien-noir";
			a.style.display = "block";
			a.style.width = "100%";
			a.href = "CareerStatsPlayer.php?csName="+encodeURIComponent(playoffFwdNM[i]);
			a.target = "_blank";
			a.appendChild(document.createTextNode(playoffFwdNM[i]));
			td.appendChild(a);
		td.style.textAlign = "left";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'GP') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(playoffFwdGP[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'GO') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(playoffFwdGO[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'AT') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(playoffFwdAT[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'PT') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(playoffFwdPT[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'DF') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(playoffFwdDF[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'PM') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(playoffFwdPM[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'PP') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(playoffFwdPP[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'SH') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(playoffFwdSH[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'GW') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(playoffFwdGW[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'GT') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(playoffFwdGT[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'HT') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(playoffFwdHT[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'ST') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(playoffFwdST[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'PG') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(playoffFwdPG[i]));
		tr.appendChild(td);
	return tr;
}
function showPlayerGoalPLF(i,c,d,currentSearch) {
	d = d + 1;
	var tr = document.createElement('tr');
		tr.className = "hover"+c;
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(d));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(playoffGoalPO[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
			var a = document.createElement('a');
			a.className = "lien-noir";
			a.style.display = "block";
			a.style.width = "100%";
			a.href = "CareerStatsPlayer.php?csName="+encodeURIComponent(playoffGoalNM[i]);
			a.target = "_blank";
			a.appendChild(document.createTextNode(playoffGoalNM[i]));
			td.appendChild(a);
		td.style.textAlign = "left";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'GP') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(playoffGoalGP[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'MN') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(playoffGoalMN[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'AV') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(playoffGoalAV[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'WI') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(playoffGoalWI[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'LO') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(playoffGoalLO[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'TI') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(playoffGoalTI[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'SO') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(playoffGoalSO[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'GA') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(playoffGoalGA[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'SA') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(playoffGoalSA[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'PC') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(playoffGoalPC[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'PM') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(playoffGoalPM[i]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "center";
		if(currentSearch == 'AS') td.style.fontWeight = "bold";
		td.appendChild(document.createTextNode(playoffGoalAS[i]));
		tr.appendChild(td);
	return tr;
}


// document.addEventListener("DOMContentLoaded", function() { 
// 	search('PT');
// });

//-->
</script>

<div class = "container px-0">

    <div class = "card">
		<?php include 'SectionHeader.php';?>
		<div class = "card-body p-1">
			<div class="container">
			
				<div id="windowSearch" class = "row">
        			<div class="col-sm-12 col-md-8 col-lg-6 offset-md-2 offset-lg-3">
        			  <select onchange="javascript:search('X');" class="form-control mb-3" id="position">
        				  <option value="0" selected><?php echo $langCareerLeadersAllFoward; ?></option>
        				  <option value="C"><?php echo $langCareerLeadersCenter; ?></option>
        				  <option value="L"><?php echo $langCareerLeadersLeft; ?></option>
        				  <option value="R"><?php echo $langCareerLeadersRight; ?></option>
        				  <option value="D"><?php echo $langCareerLeadersDef; ?></option>
        				  <option value="G"><?php echo $langCareerLeadersGoalies; ?></option>
        			  </select>
        			</div>
        			
        			<div class="col-sm-12 col-md-8 col-lg-6 offset-md-2 offset-lg-3">
        			  <select onchange="javascript:search('X');" class="form-control mb-3" id="season">
        				  <option value="0" selected><?php echo $langCareerLeadersSeasons; ?></option>
        				  <option value="1"><?php echo $langCareerLeadersPlayoffs; ?></option>
        			  </select>
        			</div>
        	
        			<div style="clear:both;"></div>
            	</div>
				
			
				<div class = "row">
            	          
            		<div class = "table-responsive">
            				<div id="windowResult">
            		</div>
            	</div>
			</div>
		</div>
	</div>
        			

	
</div>

</div>

<script>

$(function() {
	search('PT');
 
});

function search(type){
	result(type);
	initHeaders();
}

function initHeaders(){
	   $("table thead tr th").each(function(){
		var currentSearch = $(this).attr("data-search")
		var currentValue = $(this).text();
		if(currentSearch != null){
		     $(this).text("");
       		 $(this).append('<a class="info" href="javascript:search(\'' + currentSearch + '\');" style="display:block">'+currentValue+'</a>');
		}


    });
}
  

</script>

<?php include 'footer.php'; ?>
