<?php
require_once 'config.php';
include_once 'common.php';
include_once 'lang.php';


$csName = '';
if(isset($_GET['csName']) || isset($_POST['csName'])) {
	$csName = ( isset($_GET['csName']) ) ? $_GET['csName'] : $_POST['csName'];
	$csName = trim(htmlspecialchars($csName));
}

$CurrentHTML = '';
$CurrentTitle = $careerStatsTitle.' - '.$csName;
$CurrentPage = 'CareerStatsPlayer';
include 'head.php';


// Recherche des saisons antérieurs (get previous seasons)
if($folderCarrerStats != '0') {
	$hashFolder = '';
	$tmpLong = 0;
	for($i=0;$i<substr_count($folderCarrerStats, '/');$i++) {
		if($hashFolder != '') $tmpLong = strlen($hashFolder)+1;
		$hashFolder = substr($folderCarrerStats, 0+$tmpLong, strpos($folderCarrerStats, '/'));
		if(substr_count($hashFolder, '#') > 0) break 1;
	}
	$Fnm = str_replace("#/","*",$folderCarrerStats);
// 	$NumberSeason = 0;
// 	$dirs = glob($Fnm, GLOB_ONLYDIR);
// 	for($j=0;$j<count($dirs);$j++) {
// 		if(substr_count($dirs[$j], $hashFolder)) {
// 			$tmpYear = substr($dirs[$j], strlen($folderCarrerStats)-2);
// 			if($NumberSeason < $tmpYear) $NumberSeason = $tmpYear;
// 		}
// 	}
	$NumberSeason = count(getPreviousSeasons($folderCarrerStats));
	
}

// PlayerVitals - Current Season
if($csName != '') {
	$matches = glob($folder.'*'.$playoff.'PlayerVitals.html');
	$folderLeagueURL = '';
	$matchesDate = array_map('filemtime', $matches);
	arsort($matchesDate);
	foreach ($matchesDate as $j => $val) {
		if((!substr_count($matches[$j], 'PLF') && $playoff == '') || (substr_count($matches[$j], 'PLF') && $playoff == 'PLF')) {
			$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'PlayerVitals')-strrpos($matches[$j], '/')-1);
			break 1;
		}
	}
	$Fnm = $folder.$folderLeagueURL.'PlayerVitals.html';
	
	$a = 0;
	if(file_exists($Fnm)) {
		$tableau = file($Fnm);
		while(list($cle,$val) = myEach($tableau)) {
			$val = utf8_encode($val);
			if(substr_count($val, '------------------')) {
				$a = 0;
			}
			if($a == 1 && substr_count($val, $csName)) {
				$playerVitalsNumero = substr($val, 0,  strpos($val, ' '));
				$reste = trim(substr($val, strpos($val, ' ')));
				if(substr_count($reste, '*', 0, 1)) {
					$playerVitalsRecrue = substr($reste, 0, 1);
					$reste = trim(substr($reste, 1));
				}
				else $playerVitalsRecrue = '';
				
				$playerVitalsName = substr($reste, 0, strpos($reste, '  '));
				$reste = trim(substr($reste, strpos($reste, '  ')));
				$playerVitalsPosition = substr($reste, 0, strpos($reste, '  '));
				$aremplacer = array('LW', 'RW');
				$remplace = array($joueursLW, $joueursRW);
				$playerVitalsPosition = str_replace($aremplacer, $remplace, $playerVitalsPosition);
				$reste = trim(substr($reste, strpos($reste, '  ')));
				$playerVitalsAge = substr($reste, 0, strpos($reste, '  '));
				$reste = trim(substr($reste, strpos($reste, '  ')));
				$playerVitalsGrandeur = substr($reste, 0, strpos($reste, '  '));
				$playerVitalsGrandeur = str_replace('ft', '\'', $playerVitalsGrandeur);
				$reste = trim(substr($reste, strpos($reste, '  ')));
				$playerVitalsPoids = substr($reste, 0, strpos($reste, 'lbs')-1);
				//$playerVitalsPoids = substr($reste, 0, strpos($reste, '  '));
				$reste = trim(substr($reste, strpos($reste, 'lbs') + 3));
				//$reste = trim(substr($reste, strpos($reste, '  ')));
				$playerVitalsSalaire = substr($reste, 0, strpos($reste, '  '));
				if(!substr_count($val, ',')) {
					$playerVitalsSalaire = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u','',$playerVitalsSalaire);
					$playerVitalsSalaire = preg_replace('/\s+/u', ',', $playerVitalsSalaire);
				}
				$playerVitalsSalaire .= '$';
				$reste = trim(substr($reste, strpos($reste, '  ')));
				$playerVitalsContrat = substr($reste, 0);
				$aremplacer = array('0 years', '1 year', 'years');
				$remplace = array($joueurs0Year, $joueurs1Year, $joueursYears);
				$playerVitalsContrat = str_replace($aremplacer, $remplace, $playerVitalsContrat);
				if($playerVitalsPosition == 'G') $matchType = 2;
				else $matchType = 1;
			}
			if(substr_count($val, 'CONTRACT')) {
				$a = 1;
			}
		}
	}
	else echo $allFileNotFound.' - '.$Fnm;
	
	// PlayerVitals - Previous Season
	$workSeason = $NumberSeason;
	for($n=0;$n<$NumberSeason;$n++) {
		$workSeason--;
		if($workSeason == 0) break 1;
		$Fnmtmp = str_replace("#",$workSeason,$folderCarrerStats);
		$matches = glob($Fnmtmp.'*PlayerVitals.html');
		$folderLeagueURL = '';
		for($j=0;$j<count($matches);$j++) {
			if(!substr_count($matches[$j], 'PLF')) {
				$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'PlayerVitals')-strrpos($matches[$j], '/')-1);
				break 1;
			}
		}
		if($folderLeagueURL != '' && !isset($playerVitalsName)) {
			$Fnm = $Fnmtmp.$folderLeagueURL.'PlayerVitals.html';
			$a = 0;
			if(file_exists($Fnm)) {
				$tableau = file($Fnm);
				while(list($cle,$val) = myEach($tableau)) {
					$val = utf8_encode($val);
					if(substr_count($val, '------------------')) {
						$a = 0;
					}
					if($a == 1 && substr_count($val, $csName)) {
						$playerVitalsNumero = substr($val, 0,  strpos($val, ' '));
						$reste = trim(substr($val, strpos($val, ' ')));
						if(substr_count($reste, '*', 0, 1)) {
							$playerVitalsRecrue = substr($reste, 0, 1);
							$reste = trim(substr($reste, 1));
						}
						else $playerVitalsRecrue = '';
						
						$playerVitalsName = substr($reste, 0, strpos($reste, '  '));
						$reste = trim(substr($reste, strpos($reste, '  ')));
						$playerVitalsPosition = substr($reste, 0, strpos($reste, '  '));
						$aremplacer = array('LW', 'RW');
						$remplace = array($joueursLW, $joueursRW);
						$playerVitalsPosition = str_replace($aremplacer, $remplace, $playerVitalsPosition);
						$reste = trim(substr($reste, strpos($reste, '  ')));
						$playerVitalsAge = substr($reste, 0, strpos($reste, '  '));
						$reste = trim(substr($reste, strpos($reste, '  ')));
						$playerVitalsGrandeur = substr($reste, 0, strpos($reste, '  '));
						$playerVitalsGrandeur = str_replace('ft', '\'', $playerVitalsGrandeur);
						$reste = trim(substr($reste, strpos($reste, '  ')));
						$playerVitalsPoids = substr($reste, 0, strpos($reste, 'lbs') + 3);
						$reste = trim(substr($reste, strpos($reste, 'lbs') + 3));
						$playerVitalsSalaire = substr($reste, 0, strpos($reste, '  ')).'$';
						$reste = trim(substr($reste, strpos($reste, '  ')));
						$playerVitalsContrat = substr($reste, 0);
						$aremplacer = array('0 years', '1 year', 'years');
						$remplace = array($joueurs0Year, $joueurs1Year, $joueursYears);
						$playerVitalsContrat = str_replace($aremplacer, $remplace, $playerVitalsContrat);
					}
					if(substr_count($val, 'CONTRACT')) {
						$a = 1;
					}
				}
			}
			else echo $allFileNotFound.' - '.$Fnm;
		}
	}
}

// Recherche Seasons TeamScoring - Current Season
if($csName != '') {
	$matches = glob($folder.'*TeamScoring.html');
	$folderLeagueURL = '';
	$matchesDate = array_map('filemtime', $matches);
	arsort($matchesDate);
	foreach ($matchesDate as $j => $val) {
		if(!substr_count($matches[$j], 'PLF')) {
			$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'TeamScoring')-strrpos($matches[$j], '/')-1);
			break 1;
		}
	}
	$Fnm = $folder.$folderLeagueURL.'TeamScoring.html';
	$b = 0;
	$e = 0;
	$f = 0;
	$i = 0;
	$lastTeam = '';
	$tmpFound = 0;
	$type = 0;
	$workSeason = $NumberSeason + 1;
	if(file_exists($Fnm)) {
		$tableau = file($Fnm);
		while(list($cle,$val) = myEach($tableau)) {
			$val = utf8_encode($val);
			if(substr_count($val, 'A NAME=')) {
				$reste = substr($val, strpos($val, '='), strpos($val, '</')-strpos($val, '='));
				$lastTeam = trim(substr($reste, strpos($reste, '>')+1));
				$b = 1;
			}
			if($b && substr_count($val, '------------')) {
				$e = 0;
				if($f == 1) {
					$b = 0;
					$f = 0;
					if($tmpFound != 0) break 1;
				}
			}
			if($tmpFound == 1 && substr_count($val, '                         ') != 1) $tmpFound = 2;
			if($b && $e && $type != 2 && (substr_count($val, $csName) || ($tmpFound == 1 && substr_count($val, '                         '))) && !substr_count(substr($val, 0, 1), 'G')) {
				$tmpFound = 1;
				$type = 1;
				$reste = trim($val);
				if(substr_count($val, '                         ')) {
					$statsPosition[$i] = '';
					$statsNumber[$i] = '';
					$statsRookie[$i] = '';
					//$statsName[$i] = '';
					$bold[$i] = '';
				}
				else {
					$statsPosition[$i] = substr($reste, 0, strpos($reste, ' '));
					$reste = trim(substr($reste, strpos($reste, ' ')));
					$statsNumber[$i] = substr($reste, 0, strpos($reste, ' '));
					$reste = trim(substr($reste, strpos($reste, ' ')));
					if(substr($reste, 0, 1) == '*') {
						$statsRookie[$i] = substr($reste, 0, 1);
						$reste = trim(substr($reste, 1));
					}
					else $statsRookie[$i] = '';
					//$reste = trim(substr($reste, strpos($reste, '  ')));
					$tmpFwdHT2 = 0;
				}
				$statsPS[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsGS[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsPCTG[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsS[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsHT[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsGT[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsGW[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsSHG[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsPPG[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsPIM[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsDiff[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsP[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsA[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsG[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsGP[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsTeam[$i] = trim(substr($reste, strrpos($reste, ' ')));
				if(!substr_count($val, '                         ')) {
					$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
					/*
					$statsName[$i] = $reste;
					if(substr_count($statsName[$i], 'xtrastats.html')) {
						$statsName[$i] = trim(substr($statsName[$i], strpos($statsName[$i], '"')+1, strpos($statsName[$i], '>')-1-strpos($statsName[$i], '"')-1));
					}
					*/
				}
				$tmpVal = $tableau[$cle+1];
				if(substr_count($tmpVal, '                         ') || (!substr_count($val, '                         ') && !substr_count($tmpVal, '                         '))) {
					$tmpFwdHT2 += $statsHT[$i];
				}
				else $statsHT[$i] = $tmpFwdHT2;
				$statsSeason[$i] = $workSeason;
				$i++;
			}
			if($b && $f && $type != 1 && (substr_count($val, $csName) || ($tmpFound == 1 && substr_count($val, '                         ')))) {
				$tmpFound = 1;
				$type = 2;
				$reste = trim($val);
				if(substr_count($val, '                         ')) {
					$statsPosition[$i] = '';
					$statsNumber[$i] = '';
					$statsRookie[$i] = '';
					//$statsName[$i] = '';
				}
				else {
					$statsPosition[$i] = 'G';
					$statsNumber[$i] = substr($reste, 0, strpos($reste, ' '));
					$reste = trim(substr($reste, strpos($reste, ' ')));
					if(substr($reste, 0, 1) == '*') {
						$statsRookie[$i] = substr($reste, 0, 1);
						$reste = trim(substr($reste, 1));
					}
					else $statsRookie[$i] = '';
				}
				$statsAS[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsPIM[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsPCT[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsSA[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsGA[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsSO[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsT[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsL[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsW[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsAVG[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsMin[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsGP[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsTeam[$i] = trim(substr($reste, strrpos($reste, ' ')));
				if(!substr_count($val, '                         ')) {
					$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
					/*
					$statsName[$i] = $reste;
					if(substr_count($statsName[$i], 'xtrastats.html')) {
						$statsName[$i] = trim(substr($statsName[$i], strpos($statsName[$i], '"')+1, strpos($statsName[$i], '>')-1-strpos($statsName[$i], '"')-1));
					}
					*/
				}
				$statsSeason[$i] = $workSeason;
				$i++;
			}
			if($b && substr_count($val, 'PCTG') ) {
				$e = 1;
			}
			if($b && substr_count($val, 'AVG') ) {
				$f = 1;
			}
		}
	}
	else echo $allFileNotFound.' - '.$Fnm;
	
	if($i == 0) $lastTeam = '-';
	// TeamScoring - Previous Seasons
	for($n=0;$n<$NumberSeason;$n++) {
		$workSeason--;
		$Fnmtmp = str_replace("#",$workSeason,$folderCarrerStats);
		$matches = glob($Fnmtmp.'*TeamScoring.html');
		$folderLeagueURL = '';
		for($j=0;$j<count($matches);$j++) {
			if(!substr_count($matches[$j], 'PLF')) {
				$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'TeamScoring')-strrpos($matches[$j], '/')-1);
				break 1;
			}
		}
		if($folderLeagueURL != '') {
			$Fnm = $Fnmtmp.$folderLeagueURL.'TeamScoring.html';
			$b = 0;
			$e = 0;
			$f = 0;
			$type = 0;
			$tmpFound = 0;
			if(file_exists($Fnm)) {
				$tableau = file($Fnm);
				while(list($cle,$val) = myEach($tableau)) {
					$val = utf8_encode($val);
					if(substr_count($val, 'A NAME=')) {
						$reste = substr($val, strpos($val, '='), strpos($val, '</')-strpos($val, '='));
						//if($lastTeam == '') $lastTeam = trim(substr($reste, strpos($reste, '>')+1));
						$b = 1;
					}
					if($b && substr_count($val, '------------')) {
						$e = 0;
						if($f == 1) {
							$b = 0;
							$f = 0;
							if($tmpFound != 0) break 1;
						}
					}
					if($tmpFound == 1 && !substr_count($val, '                         ')) $tmpFound = 2;
					if($b && $e && $type != 2 && (substr_count($val, $csName) || ($tmpFound == 1 && substr_count($val, '                         '))) && !substr_count(substr($val, 0, 1), 'G')) {
						$tmpFound = 1;
						$type = 1;
						$reste = trim($val);
						if(substr_count($val, '                         ')) {
							$statsPosition[$i] = '';
							$statsNumber[$i] = '';
							$statsRookie[$i] = '';
							//$statsName[$i] = '';
							$bold[$i] = '';
						}
						else {
							$statsPosition[$i] = substr($reste, 0, strpos($reste, ' '));
							$reste = trim(substr($reste, strpos($reste, ' ')));
							$statsNumber[$i] = substr($reste, 0, strpos($reste, ' '));
							$reste = trim(substr($reste, strpos($reste, ' ')));
							if(substr($reste, 0, 1) == '*') {
								$statsRookie[$i] = substr($reste, 0, 1);
								$reste = trim(substr($reste, 1));
							}
							else $statsRookie[$i] = '';
							//$reste = trim(substr($reste, strpos($reste, '  ')));
							$tmpFwdHT2 = 0;
						}
						$statsPS[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsGS[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsPCTG[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsS[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsHT[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsGT[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsGW[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsSHG[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsPPG[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsPIM[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsDiff[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsP[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsA[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsG[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsGP[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsTeam[$i] = trim(substr($reste, strrpos($reste, ' ')));
						if(!substr_count($val, '                         ')) {
							$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
							/*
							$statsName[$i] = $reste;
							if(substr_count($statsName[$i], 'xtrastats.html')) {
								$statsName[$i] = trim(substr($statsName[$i], strpos($statsName[$i], '"')+1, strpos($statsName[$i], '>')-1-strpos($statsName[$i], '"')-1));
							}
							*/
						}
						$tmpVal = $tableau[$cle+1];
						if(substr_count($tmpVal, '                         ') || (!substr_count($val, '                         ') && !substr_count($tmpVal, '                         '))) {
							$tmpFwdHT2 += $statsHT[$i];
						}
						else $statsHT[$i] = $tmpFwdHT2;
						$statsSeason[$i] = $workSeason;
						$i++;
					}
					if($b && $f && $type != 1 && (substr_count($val, $csName) || ($tmpFound == 1 && substr_count($val, '                         ')))) {
						$tmpFound = 1;
						$type = 2;
						$reste = trim($val);
						if(substr_count($val, '                         ')) {
							$statsPosition[$i] = '';
							$statsNumber[$i] = '';
							$statsRookie[$i] = '';
							//$statsName[$i] = '';
						}
						else {
							$statsPosition[$i] = 'G';
							$statsNumber[$i] = substr($reste, 0, strpos($reste, ' '));
							$reste = trim(substr($reste, strpos($reste, ' ')));
							if(substr($reste, 0, 1) == '*') {
								$statsRookie[$i] = substr($reste, 0, 1);
								$reste = trim(substr($reste, 1));
							}
							else $statsRookie[$i] = '';
						}
						$statsAS[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsPIM[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsPCT[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsSA[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsGA[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsSO[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsT[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsL[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsW[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsAVG[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsMin[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsGP[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsTeam[$i] = trim(substr($reste, strrpos($reste, ' ')));
						if(!substr_count($val, '                         ')) {
							$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
							/*
							$statsName[$i] = $reste;
							if(substr_count($statsName, 'xtrastats.html')) {
								$statsName[$i] = trim(substr($statsName[$i], strpos($statsName[$i], '"')+1, strpos($statsName[$i], '>')-1-strpos($statsName[$i], '"')-1));
							}
							*/
						}
						$statsSeason[$i] = $workSeason;
						$i++;
					}
					if($b && substr_count($val, 'PCTG') ) {
						$e = 1;
					}
					if($b && substr_count($val, 'AVG') ) {
						$f = 1;
					}
				}
			}
			else echo $allFileNotFound.' - '.$Fnm;
		}
	}
}

// Playoff TeamScorings - Current Playoff
if($csName != '') {
	$matches = glob($folder.'*PLFTeamScoring.html');
	$folderLeagueURL = '';
	$matchesDate = array_map('filemtime', $matches);
	arsort($matchesDate);
	foreach ($matchesDate as $j => $val) {
		if(substr_count($matches[$j], 'PLF')) {
			$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'PLFTeamScoring')-strrpos($matches[$j], '/')-1);
			break 1;
		}
	}
	$Fnm = $folder.$folderLeagueURL.'PLFTeamScoring.html';
	$b = 0;
	$e = 0;
	$f = 0;
	$i = 0;
	$playedCurrentPlayoff = 0;
	$tmpFound = 0;
	$type = 0;
	$workSeason = $NumberSeason + 1;
	if(file_exists($Fnm)) {
		$tableau = file($Fnm);
		while(list($cle,$val) = myEach($tableau)) {
			$val = utf8_encode($val);
			if(substr_count($val, 'A NAME=')) {
				$reste = substr($val, strpos($val, '='), strpos($val, '</')-strpos($val, '='));
				if($lastTeam == '-') $lastTeamtmp = trim(substr($reste, strpos($reste, '>')+1));
				$b = 1;
			}
			if($b && substr_count($val, '------------')) {
				$e = 0;
				if($f == 1) {
					$b = 0;
					$f = 0;
					if($tmpFound != 0) {
						if($lastTeam == '-') $lastTeam = $lastTeamtmp;
						$playedCurrentPlayoff = $statsPLFGP[0];
						break 1;
					}
				}
			}
			if($tmpFound == 1 && !substr_count($val, '                         ')) $tmpFound = 2;
			if($b && $e && $type != 2 && (substr_count($val, $csName) || ($tmpFound == 1 && substr_count($val, '                         '))) && !substr_count(substr($val, 0, 1), 'G') && !substr_count($val, 'TOT')) {
				$tmpFound = 1;
				$type = 1;
				$reste = trim($val);
				if(substr_count($val, '                         ')) {
					$statsPLFPosition[$i] = '';
					$statsPLFNumber[$i] = '';
					$statsPLFRookie[$i] = '';
					//$statsPLFName[$i] = '';
					$bold[$i] = '';
				}
				else {
					$statsPLFPosition[$i] = substr($reste, 0, strpos($reste, ' '));
					$reste = trim(substr($reste, strpos($reste, ' ')));
					$statsPLFNumber[$i] = substr($reste, 0, strpos($reste, ' '));
					$reste = trim(substr($reste, strpos($reste, ' ')));
					if(substr($reste, 0, 1) == '*') {
						$statsPLFRookie[$i] = substr($reste, 0, 1);
						$reste = trim(substr($reste, 1));
					}
					else $statsPLFRookie[$i] = '';
					//$reste = trim(substr($reste, strpos($reste, '  ')));
					$tmpFwdHT2 = 0;
				}
				$statsPLFPS[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsPLFGS[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsPLFPCTG[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsPLFS[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsPLFHT[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsPLFGT[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsPLFGW[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsPLFSHG[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsPLFPPG[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsPLFPIM[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsPLFDiff[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsPLFP[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsPLFA[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsPLFG[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsPLFGP[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsPLFTeam[$i] = trim(substr($reste, strrpos($reste, ' ')));
				if(!substr_count($val, '                         ')) {
					$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
					/*
					$statsPLFName[$i] = $reste;
					if(substr_count($statsPLFName[$i], 'xtrastatsPLF.html')) {
						$statsPLFName[$i] = trim(substr($statsPLFName[$i], strpos($statsPLFName[$i], '"')+1, strpos($statsPLFName[$i], '>')-1-strpos($statsPLFName[$i], '"')-1));
					}
					*/
				}
				$tmpVal = $tableau[$cle+1];
				if(substr_count($tmpVal, '                         ') || (!substr_count($val, '                         ') && !substr_count($tmpVal, '                         '))) {
					$tmpFwdHT2 += $statsPLFHT[$i];
				}
				else $statsPLFHT[$i] = $tmpFwdHT2;
				$statsPLFSeason[$i] = $workSeason;
				$i++;
			}
			if($b && $f && $type != 1 && (substr_count($val, $csName) || ($tmpFound == 1 && substr_count($val, '                         '))) && !substr_count($val, 'TOT')) {
				$tmpFound = 1;
				$type = 2;
				$reste = trim($val);
				if(substr_count($val, '                         ')) {
					$statsPLFPosition[$i] = '';
					$statsPLFNumber[$i] = '';
					$statsPLFRookie[$i] = '';
					//$statsPLFName[$i] = '';
				}
				else {
					$statsPLFPosition[$i] = 'G';
					$statsPLFNumber[$i] = substr($reste, 0, strpos($reste, ' '));
					$reste = trim(substr($reste, strpos($reste, ' ')));
					if(substr($reste, 0, 1) == '*') {
						$statsPLFRookie[$i] = substr($reste, 0, 1);
						$reste = trim(substr($reste, 1));
					}
					else $statsPLFRookie[$i] = '';
				}
				$statsPLFAS[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsPLFPIM[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsPLFPCT[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsPLFSA[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsPLFGA[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsPLFSO[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsPLFT[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsPLFL[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsPLFW[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsPLFAVG[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsPLFMin[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsPLFGP[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsPLFTeam[$i] = trim(substr($reste, strrpos($reste, ' ')));
				if(!substr_count($val, '                         ')) {
					$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
					/*
					$statsPLFName[$i] = $reste;
					if(substr_count($statsPLFName, 'xtrastatsPLF.html')) {
						$statsPLFName[$i] = trim(substr($statsPLFName[$i], strpos($statsPLFName[$i], '"')+1, strpos($statsPLFName[$i], '>')-1-strpos($statsPLFName[$i], '"')-1));
					}
					*/
				}
				$statsPLFSeason[$i] = $workSeason;
				$i++;
			}
			if($b && substr_count($val, 'PCTG') ) {
				$e = 1;
			}
			if($b && substr_count($val, 'AVG') ) {
				$f = 1;
			}
		}
	}
		
	// TeamScoring - Previous Playoff
	for($n=0;$n<$NumberSeason;$n++) {
		$workSeason--;
		$Fnmtmp = str_replace("#",$workSeason,$folderCarrerStats);
		$matches = glob($Fnmtmp.'*PLFTeamScoring.html');
		$folderLeagueURL = '';
		for($j=0;$j<count($matches);$j++) {
			$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'PLFTeamScoring')-strrpos($matches[$j], '/')-1);
			break 1;
		}
		if($folderLeagueURL != '') {
			$Fnm = $Fnmtmp.$folderLeagueURL.'PLFTeamScoring.html';
			$b = 0;
			$e = 0;
			$f = 0;
			$type = 0;
			$tmpFound = 0;
			if(file_exists($Fnm)) {
				$tableau = file($Fnm);
				while(list($cle,$val) = myEach($tableau)) {
					$val = utf8_encode($val);
					if(substr_count($val, 'A NAME=')) {
						$b = 1;
					}
					if($b && substr_count($val, '------------')) {
						$e = 0;
						if($f == 1) {
							$b = 0;
							$f = 0;
							if($tmpFound != 0) break 1;
						}
					}
					if($tmpFound == 1 && !substr_count($val, '                         ')) $tmpFound = 2;
					if($b && $e && $type != 2 && (substr_count($val, $csName) || ($tmpFound == 1 && substr_count($val, '                         '))) && !substr_count(substr($val, 0, 1), 'G') && !substr_count($val, 'TOT')) {
						$tmpFound = 1;
						$type = 1;
						$reste = trim($val);
						if(substr_count($val, '                         ')) {
							$statsPLFPosition[$i] = '';
							$statsPLFNumber[$i] = '';
							$statsPLFRookie[$i] = '';
							//$statsPLFName[$i] = '';
							$bold[$i] = '';
						}
						else {
							$statsPLFPosition[$i] = substr($reste, 0, strpos($reste, ' '));
							$reste = trim(substr($reste, strpos($reste, ' ')));
							$statsPLFNumber[$i] = substr($reste, 0, strpos($reste, ' '));
							$reste = trim(substr($reste, strpos($reste, ' ')));
							if(substr($reste, 0, 1) == '*') {
								$statsPLFRookie[$i] = substr($reste, 0, 1);
								$reste = trim(substr($reste, 1));
							}
							else $statsPLFRookie[$i] = '';
							//$reste = trim(substr($reste, strpos($reste, '  ')));
							$tmpFwdHT2 = 0;
						}
						$statsPLFPS[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsPLFGS[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsPLFPCTG[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsPLFS[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsPLFHT[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsPLFGT[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsPLFGW[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsPLFSHG[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsPLFPPG[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsPLFPIM[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsPLFDiff[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsPLFP[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsPLFA[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsPLFG[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsPLFGP[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsPLFTeam[$i] = trim(substr($reste, strrpos($reste, ' ')));
						if(!substr_count($val, '                         ')) {
							$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
							/*
							$statsPLFName[$i] = $reste;
							if(substr_count($statsPLFName[$i], 'xtrastatsPLF.html')) {
								$statsPLFName[$i] = trim(substr($statsPLFName[$i], strpos($statsPLFName[$i], '"')+1, strpos($statsPLFName[$i], '>')-1-strpos($statsPLFName[$i], '"')-1));
							}
							*/
						}
						$tmpVal = $tableau[$cle+1];
						if(substr_count($tmpVal, '                         ') || (!substr_count($val, '                         ') && !substr_count($tmpVal, '                         '))) {
							$tmpFwdHT2 += $statsPLFHT[$i];
						}
						else $statsPLFHT[$i] = $tmpFwdHT2;
						$statsPLFSeason[$i] = $workSeason;
						$i++;
					}
					if($b && $f && $type != 1 && (substr_count($val, $csName) || ($tmpFound == 1 && substr_count($val, '                         '))) && !substr_count($val, 'TOT')) {
						$tmpFound = 1;
						$type = 2;
						$reste = trim($val);
						if(substr_count($val, '                         ')) {
							$statsPLFPosition[$i] = '';
							$statsPLFNumber[$i] = '';
							$statsPLFRookie[$i] = '';
							//$statsPLFName[$i] = '';
						}
						else {
							$statsPLFPosition[$i] = 'G';
							$statsPLFNumber[$i] = substr($reste, 0, strpos($reste, ' '));
							$reste = trim(substr($reste, strpos($reste, ' ')));
							if(substr($reste, 0, 1) == '*') {
								$statsPLFRookie[$i] = substr($reste, 0, 1);
								$reste = trim(substr($reste, 1));
							}
							else $statsPLFRookie[$i] = '';
						}
						$statsPLFAS[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsPLFPIM[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsPLFPCT[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsPLFSA[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsPLFGA[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsPLFSO[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsPLFT[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsPLFL[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsPLFW[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsPLFAVG[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsPLFMin[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsPLFGP[$i] = substr($reste, strrpos($reste, ' '));
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$statsPLFTeam[$i] = trim(substr($reste, strrpos($reste, ' ')));
						if(!substr_count($val, '                         ')) {
							$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
							/*
							$statsPLFName[$i] = $reste;
							if(substr_count($statsPLFName, 'xtrastatsPLF.html')) {
								$statsPLFName[$i] = trim(substr($statsPLFName[$i], strpos($statsPLFName[$i], '"')+1, strpos($statsPLFName[$i], '>')-1-strpos($statsPLFName[$i], '"')-1));
							}
							*/
						}
						$statsPLFSeason[$i] = $workSeason;
						$i++;
					}
					if($b && substr_count($val, 'PCTG') ) {
						$e = 1;
					}
					if($b && substr_count($val, 'AVG') ) {
						$f = 1;
					}
				}
			}
			else $allFileNotFound.' - '.$Fnm;
		}
	}
}

// Recherche des parties jouées - Current Season/Playoff
if($csName != '' && $lastTeam != '-') {
	$existRnd = 0;
	if($playedCurrentPlayoff != 0) {
		$matches = glob($folder.'*PLF-Round1-Schedule.html');
		$folderLeagueURL = '';
		$matchesDate = array_map('filemtime', $matches);
		arsort($matchesDate);
		foreach ($matchesDate as $j => $val) {
			if(substr_count($matches[$j], 'PLF')) {
				$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'PLF-Round1')-strrpos($matches[$j], '/')-1);
				break 1;
			}
		}
		if (file_exists($folder.$folderLeagueURL.'PLF-Round1-Schedule.html')) {
			$Fnm = $folder.$folderLeagueURL.'PLF-Round1-Schedule.html';
			$linkSchedule = '-Round1-Schedule';
			$existRnd = 1;
		}
		if (file_exists($folder.$folderLeagueURL.'PLF-Round2-Schedule.html')) {
			$Fnm = $folder.$folderLeagueURL.'PLF-Round2-Schedule.html';
			$linkSchedule = '-Round2-Schedule';
			$existRnd = 2;
		}
		if (file_exists($folder.$folderLeagueURL.'PLF-Round3-Schedule.html')) {
			$Fnm = $folder.$folderLeagueURL.'PLF-Round3-Schedule.html';
			$linkSchedule = '-Round3-Schedule';
			$existRnd = 3;
		}
		if (file_exists($folder.$folderLeagueURL.'PLF-Round4-Schedule.html')) {
			$Fnm = $folder.$folderLeagueURL.'PLF-Round4-Schedule.html';
			$linkSchedule = '-Round4-Schedule';
			$existRnd = 4;
		}
	}
	$i = 0;
	$matchPlayed[0] = 0;
	for($rnd=0;$rnd<=$existRnd;$rnd++) {
		if($rnd != 0) {
			$matches = glob($folder.'*PLF-Round'.$rnd.'-Schedule.html');
			$folderLeagueURL = '';
			$matchesDate = array_map('filemtime', $matches);
			arsort($matchesDate);
			foreach ($matchesDate as $j => $val) {
				if(substr_count($matches[$j], 'PLF')) {
					$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'PLF-Round')-strrpos($matches[$j], '/')-1);
					break 1;
				}
			}
			$Fnm = $folder.$folderLeagueURL.'PLF-Round'.$rnd.'-Schedule.html';
		}
		else {
			$matches = glob($folder.'*Schedule.html');
			$folderLeagueURL = '';
			$matchesDate = array_map('filemtime', $matches);
			arsort($matchesDate);
			foreach ($matchesDate as $j => $val) {
				if(!substr_count($matches[$j], 'PLF')) {
					$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'Schedule')-strrpos($matches[$j], '/')-1);
					break 1;
				}
			}
			$Fnm = $folder.$folderLeagueURL.'Schedule.html';
		}
		if (file_exists($Fnm)) {
			$tableau = file($Fnm);
			while(list($cle,$val) = myEach($tableau)) {
				$val = utf8_encode($val);
				if(substr_count($val, 'A HREF=') && substr_count($val, $lastTeam)){
					$reste = trim(substr($val, strpos($val, '> ')+1));
					$scheduleNumber[$i] = substr($reste, 0, strpos($reste, ' '));
					$reste = trim(substr($reste, strpos($reste, ' ')));
					$count = strlen($reste);
					$z = 0;
					while( $z < $count ) {
						if( ctype_digit($reste[$z]) ) {
							$pos3 = $z;
							break 1;
						}
						$z++;
					}
					$equipe1[$i] = substr($reste, 0, $pos3-1);
					$reste = trim(substr($reste, $pos3));
					$score1[$i] = substr($reste, 0, strpos($reste, ' '));
					$reste = trim(substr($reste, strpos($reste, ' ')));
					$z = 0;
					while( $z < $count ) {
						if( ctype_digit($reste[$z]) ) {
							$pos3 = $z;
							break 1;
						}
						$z++;
					}
					$equipe2[$i] = substr($reste, 0, $pos3-1);
					$reste = trim(substr($reste, $pos3));
					$score2[$i] = $reste;
					$matchRnd[$i] = $rnd;
					
					if($rnd != '') {
						$matches = glob($folder.$folderGames.'*PLF-R'.$rnd.'-'.$scheduleNumber[$i].'.html');
						$folderLeagueURL = '';
						for($j=0;$j<count($matches);$j++) {
							if(substr_count($matches[$j], 'PLF')) {
								$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'PLF-R')-strrpos($matches[$j], '/')-1);
								break 1;
							}
						}
						$Fnm2 = $folder.$folderGames.$folderLeagueURL.'PLF-R'.$rnd.'-'.$scheduleNumber[$i].'.html';
					}
					else {
						$matches = glob($folder.$folderGames.'*'.$scheduleNumber[$i].'.html');
						$folderLeagueURL = '';
						natsort($matches);
						foreach($matches as $j => $val) {
							if(!substr_count($val, 'PLF')) {
								$folderLeagueURL = substr($val, strrpos($val, '/')+1,  strpos($val, $scheduleNumber[$i])-strrpos($val, '/')-1);
								break 1;
							}
						}
						$Fnm2 = $folder.$folderGames.$folderLeagueURL.$scheduleNumber[$i].'.html';
					}
					$a = 0;
					//echo $scheduleNumber[$i].' - ';
					if(file_exists($Fnm2)) {
						//echo $Fnm2.'<br>';
						$tableau2 = file($Fnm2);
						while(list($cle2,$val2) = myEach($tableau2)) {
							$val2 = utf8_encode($val2);
							if(substr_count($val2, '</TD><TD><PRE>')) {
								$a = 4;
							}
							if(substr_count($val2, '<BR><BR><PRE>')) {
								$tmpTeam = substr($val2, 0, strpos($val2, '<'));
							}
							if($a == 3 && substr_count($val2, $csName) && $tmpTeam == $lastTeam) {
								$matchPlayed[$i] = 1;
								$matchType = 1;
								$count = strlen($val2);
								$z = 0;
								while( $z < $count ) {
									if( ctype_digit($val2[$z]) ) {
										$pos3 = $z;
										break 1;
									}
									$z++;
								}
								$reste = trim(substr($val2, $pos3));
								$matchG[$i] = substr($reste, 0, strpos($reste, ' '));
								$reste = trim(substr($reste, strpos($reste, ' ')));
								$matchA[$i] = substr($reste, 0, strpos($reste, ' '));
								$reste = trim(substr($reste, strpos($reste, ' ')));
								$matchP[$i] = substr($reste, 0, strpos($reste, ' '));
								$reste = trim(substr($reste, strpos($reste, ' ')));
								$matchDiff[$i] = substr($reste, 0, strpos($reste, ' '));
								$matchDiff[$i] = str_replace('Even', '0', $matchDiff[$i]);
								$reste = trim(substr($reste, strpos($reste, ' ')));
								$matchPIM[$i] = substr($reste, 0, strpos($reste, ' '));
								$reste = trim(substr($reste, strpos($reste, ' ')));
								$matchS[$i] = substr($reste, 0, strpos($reste, ' '));
								$reste = trim(substr($reste, strpos($reste, ' ')));
								$matchHT[$i] = substr($reste, 0, strpos($reste, ' '));
								$reste = trim(substr($reste, strpos($reste, ' ')));
								$matchIT[$i] = $reste;
								
								break 1;
							}
							if($a == 1 && substr_count($val2, $csName)) {
								$matchPlayed[$i] = 1;
								$matchType = 2;
								$reste = trim(substr($val2, strpos($val2, ',')+1));
								$matchSave[$i] = substr($reste, 0, strpos($reste, ' '));
								$reste = trim(substr($reste, strpos($reste, 'of')+2));
								$matchShots[$i] = substr($reste, 0, strpos($reste, ' '));
								$matchResult[$i] = $matchShots[$i] - $matchSave[$i];
								if(substr_count($reste, ',')) {
									$reste = trim(substr($reste, strpos($reste, ',')+1));
									$reste = trim(substr($reste, strpos($reste, ',')+1));
									$matchFiche[$i] = substr($reste, 0, strpos($reste, '<BR>'));
								}
								else {
									$matchFiche[$i] = '-';
								}
								
								break 1;
							}
							if(substr_count($val2, 'Goalie Statistics')) {
								$a = 1;
							}
							if(substr_count($val2, 'Power Play Conversions')) {
								$a = 2;
							}
							if(substr_count($val2, '-------------------------------------------------')) {
								$a = 3;
							}
						}
					}
					$i++;
					$matchPlayed[$i] = 0;
				}
			}
		}
		else { 
			echo '<tr><td>'.$allFileNotFound.' - '.$Fnm.'</td></tr>';
		}
	}
}
?>

<style>
.heading-footer { 
	background-image: url(assets/img/player_header.jpg); 
	background-size: cover; 
	height: 175px; 
	-webkit-box-shadow: none; 
	box-shadow: none; 
	border: 0px; 
	border-radius: 0px; 
}   
 
.panel-profile-img { 
	max-width: 250px; 
	margin-top: -160px; 
	margin-bottom: 5px; 
	border: 3px solid #fff; 
	border-radius: 0%; 
}
</style>

<?php

// Entête
//echo '<img src="http://tsnimages.tsn.ca/ImageProvider/PlayerHeadshot?seoId='.$csNametmp.'&width=200&height=200" alt="'.$csName.'"><br>';
if($csName != '') {
	$csNametmp = strtolower($csName);
	$csNametmp = str_replace(' ', '-', $csNametmp);
	$csNametmpFirst = substr($csNametmp, 0, 1);
	
	echo '<div class="container">';
	
	echo '<div class="card">';

 	echo '<div class="card-header heading-footer"></div>';
			echo '<div class="card-block text-center">';

			if(URL_exists('https://assets1.sportsnet.ca/wp-content/uploads/players/nhl/'.$csNametmpFirst.'/'.$csNametmp.'.png')) echo '<img src="http://assets1.sportsnet.ca/wp-content/uploads/players/nhl/'.$csNametmpFirst.'/'.$csNametmp.'.png" style="height:180px;" alt="'.$csName.'">';
			//else echo '<img class="panel-profile-img rounded-circle" src="https://tsnimages.tsn.ca/ImageProvider/PlayerHeadshot?seoId='.$csNametmp.'&width=200&height=180" " alt="'.$csName.'">';
			else echo '<img class="panel-profile-img rounded-circle" src="'.getBaseUrl().'assets/img/unknown-player.png" alt="'.$csName.'">';

			echo '<div class ="col">';
				echo '<span style="font-size:30px;">'.$csName.'</span><br>';
				if(isset($statsNumber) && isset($playerVitalsNumero)) echo '<span style="font-size:18px;">#'.$playerVitalsNumero.', '.$playerVitalsPosition.', '.$lastTeam.'</span><br>';
				if(!isset($statsNumber) && isset($statsPLFNumber) && isset($playerVitalsNumero)) echo '<span style="font-size:18px;">#'.$playerVitalsNumero.', '.$playerVitalsPosition.', '.$lastTeam.'</span><br>';
				if(isset($playerVitalsNumero)) {
					echo '<span style="font-size:16px;">Age: '.$playerVitalsAge.' - '.$careerStatsHeight.': '.$playerVitalsGrandeur.' - '.$careerStatsWeight.': '.$playerVitalsPoids.'<br>';
					echo $careerStatsSalary.': '.$playerVitalsSalaire.' - '.$careerStatsLenght.': '.$playerVitalsContrat.'</span>';
				}

			echo '</div>';

	echo '</div>'; 

	
}	

if($csName != '' && (isset($statsNumber) || isset($statsPLFNumber))) {
	if(isset($statsPLFNumber) || isset($statsNumber)){

		echo '
		<div class="card-body">
		<div class = "row">
		<div class = "col-sm-12 col-md-12 col-lg-8 offset-lg-2">
        <h3 class = "tableau-top text-center">'.$careerStatsTitle.'</h3>
		<div class="table-responsive">
        <table class="table table-sm table-striped table-hover text-center">';
	}
	
	// Season TeamScoring
	if(isset($statsNumber)){
		if(isset($statsP)) {
            echo '<thead>';
			echo '<tr class="tableau-top">
			<td>S</td>
			<td>P</td>
			<td>#</td>
			<td>R</td>
			<td class="text-left">'.$scoringTMm.'</td>
			<td>'.$scoringGPm.'</td>
			<td>'.$scoringGm.'</td>
			<td>A<span></td>
			<td>P</td>
			<td>+/-</td>
			<td>'.$scoringPIMm.'</td>
			<td>'.$scoringPPm.'</td>
			<td>'.$scoringSHm.'</td>
			<td>'.$scoringGWm.'</td>
			<td>'.$scoringGTm.'</td>
			<td>'.$scoringHTm.'</td>
			<td>'.$scoringSm.'</td>
			<td>'.$scoringPCTGm.'</td>
			<td>'.$scoringGSm.'</td>
			<td>'.$scoringPSm.'</td>
			</tr>';
			echo '</thead>';
			for($i=0;$i<count($statsTeam)+1;$i++) {
				$tmpTeamCount[$i] = $statsTGP[$i]= $statsTG[$i]= $statsTA[$i]= $statsTP[$i]= $statsTDiff[$i]= $statsTPIM[$i]= $statsTPPG[$i]= $statsTSHG[$i]= $statsTGW[$i]= $statsTGT[$i]= $statsTHT[$i]= $statsTS[$i]= $statsTPCTG[$i]= $statsTGS[$i]= $statsTPS[$i] = 0;
			}
			for($i=0;$i<count($statsTeam);$i++) {
				echo '<tr>
				<td>'.$statsSeason[$i].'</td>
				<td>'.$statsPosition[$i].'</td>
				<td>'.$statsNumber[$i].'</td>
				<td>'.$statsRookie[$i].'</td>
				<td class="text-left">'.$statsTeam[$i].'</td>
				<td>'.$statsGP[$i].'</td>
				<td>'.$statsG[$i].'</td>
				<td>'.$statsA[$i].'</td>
				<td>'.$statsP[$i].'</td>
				<td>'.$statsDiff[$i].'</td>
				<td>'.$statsPIM[$i].'</td>
				<td>'.$statsPPG[$i].'</td>
				<td>'.$statsSHG[$i].'</td>
				<td>'.$statsGW[$i].'</td>
				<td>'.$statsGT[$i].'</td>
				<td>'.$statsHT[$i].'</td>
				<td>'.$statsS[$i].'</td>
				<td>'.$statsPCTG[$i].'</td>
				<td>'.$statsGS[$i].'</td>
				<td>'.$statsPS[$i].'</td>
				</tr>';
				if($statsTeam[$i] != 'TOT') {
					$tmpTeamName[0] = $statsTeam[$i];
					$statsTGP[0] += $statsGP[$i];
					$statsTG[0] += $statsG[$i];
					$statsTA[0] += $statsA[$i];
					$statsTP[0] += $statsP[$i];
					$statsTDiff[0] += $statsDiff[$i];
					$statsTPIM[0] += $statsPIM[$i];
					$statsTPPG[0] += $statsPPG[$i];
					$statsTSHG[0] += $statsSHG[$i];
					$statsTGW[0] += $statsGW[$i];
					$statsTGT[0] += $statsGT[$i];
					$statsTHT[0] += $statsHT[$i];
					$statsTS[0] += $statsS[$i];
					if($statsTS[0] != 0) $statsTPCTG[0] = round($statsTG[0] / $statsTS[0] * 100, 1);
					else $statsTPCTG[0] = 0;
					$statsTGS[0] += $statsGS[$i];
					$statsTPS[0] += $statsPS[$i];
					
					$tmpFound = 0;
					for($j=1;$j<=count($tmpTeamName);$j++) {
						if(!isset($tmpTeamName[$j])) break 1;
						if($statsTeam[$i] == $tmpTeamName[$j]) {
							$tmpFound = 1;
							break 1;
						}
					}
					if($tmpFound == 0) $j = count($tmpTeamName);
					$tmpTeamName[$j] = $statsTeam[$i];
					$tmpTeamCount[$j]++;
					$statsTGP[$j] += $statsGP[$i];
					$statsTG[$j] += $statsG[$i];
					$statsTA[$j] += $statsA[$i];
					$statsTP[$j] += $statsP[$i];
					$statsTDiff[$j] += $statsDiff[$i];
					$statsTPIM[$j] += $statsPIM[$i];
					$statsTPPG[$j] += $statsPPG[$i];
					$statsTSHG[$j] += $statsSHG[$i];
					$statsTGW[$j] += $statsGW[$i];
					$statsTGT[$j] += $statsGT[$i];
					$statsTHT[$j] += $statsHT[$i];
					$statsTS[$j] += $statsS[$i];
					if($statsTS[$j] != 0) $statsTPCTG[$j] = round($statsTG[$j] / $statsTS[$j] * 100, 1);
					else $statsTPCTG[$j] = 0;
					$statsTGS[$j] += $statsGS[$i];
					$statsTPS[$j] += $statsPS[$i];
				}
			}

			for($i=0;$i<count($tmpTeamName);$i++) {

				if($i == 0) echo '<tr class="tableau-top">';
				else echo '<tr>';
				if($i == 0) echo '<td class="text-left" colspan="5">'.$careerStatsSeasonCareer.'</td>';
				else echo '<td>'.$tmpTeamCount[$i].'</td><td class="text-left" colspan="4">'.$tmpTeamName[$i].'</td>';
				echo '<td>'.$statsTGP[$i].'</td>
				<td>'.$statsTG[$i].'</td>
				<td>'.$statsTA[$i].'</td>
				<td>'.$statsTP[$i].'</td>
				<td>'.$statsTDiff[$i].'</td>
				<td>'.$statsTPIM[$i].'</td>
				<td>'.$statsTPPG[$i].'</td>
				<td>'.$statsTSHG[$i].'</td>
				<td>'.$statsTGW[$i].'</td>
				<td>'.$statsTGT[$i].'</td>
				<td>'.$statsTHT[$i].'</td>
				<td>'.$statsTS[$i].'</td>
				<td>'.$statsTPCTG[$i].'</td>
				<td>'.$statsTGS[$i].'</td>
				<td>'.$statsTPS[$i].'</td>
				</tr>';
			}
		}
		
		if(isset($statsAVG)) {
			echo '<tr class="tableau-top">
			<td>S</td>
			<td>P</td>
			<td>#</td>
			<td>R</td>
			<td class="text-left">'.$scoringTMm.'</td>
			<td>'.$scoringGPm.'</td>
			<td>MIN</td>
			<td>'.$scoringAVGm.'</td>
			<td>'.$scoringWm.'</td>
			<td>'.$scoringLm.'</td>
			<td>'.$scoringTm.'</td>
			<td>'.$scoringSOm.'</td>
			<td>'.$scoringGAm.'</td>
			<td>'.$scoringSAm.'</td>
			<td>PCT</td>
			<td>'.$scoringPIMm.'</td>
			<td>AS</td>
			</tr>';
			
			for($i=0;$i<count($statsTeam)+1;$i++) {
				$tmpTeamCount[$i] = $statsTOTGP[$i] = $statsTOTMin[$i] = $statsTOTAVG[$i] = $statsTOTW[$i] = $statsTOTL[$i] = $statsTOTT[$i] = $statsTOTSO[$i] = $statsTOTGA[$i] = $statsTOTSA[$i] = $statsTOTPCT[$i] = $statsTOTPIM[$i] = $statsTOTAS[$i] = 0;
			}
			
			for($i=0;$i<count($statsTeam);$i++) {
				echo '<tr>
				<td>'.$statsSeason[$i].'</td>
				<td>G</td>
				<td>'.$statsNumber[$i].'</td>
				<td>'.$statsRookie[$i].'</td>
				<td class="text-left">'.$statsTeam[$i].'</td>
				<td>'.$statsGP[$i].'</td>
				<td>'.$statsMin[$i].'</td>
				<td>'.$statsAVG[$i].'</td>
				<td>'.$statsW[$i].'</td>
				<td>'.$statsL[$i].'</td>
				<td>'.$statsT[$i].'</td>
				<td>'.$statsSO[$i].'</td>
				<td>'.$statsGA[$i].'</td>
				<td>'.$statsSA[$i].'</td>
				<td>'.$statsPCT[$i].'</td>
				<td>'.$statsPIM[$i].'</td>
				<td>'.$statsAS[$i].'</td>
				</tr>';
				if($statsTeam[$i] != 'TOT') {
					$tmpTeamName[0] = $statsTeam[$i];
					$statsTOTGP[0] += $statsGP[$i];
					$statsTOTMin[0] += $statsMin[$i];
					$statsTOTW[0] += $statsW[$i];
					$statsTOTL[0] += $statsL[$i];
					$statsTOTT[0] += $statsT[$i];
					$statsTOTSO[0] += $statsSO[$i];
					$statsTOTGA[0] += $statsGA[$i];
					if($statsTOTMin[0] != 0) $statsTOTAVG[0] = round($statsTOTGA[0] * 60 / $statsTOTMin[0], 2);
					else $statsTOTAVG[0] = 0;
					$statsTOTSA[0] += $statsSA[$i];
					if($statsTOTSA[0] != 0) $statsTOTPCT[0] = round(($statsTOTSA[0] - $statsTOTGA[0]) / $statsTOTSA[0], 3);
					else $statsTOTPCT[0] = 0;
					$statsTOTPIM[0] += $statsPIM[$i];
					$statsTOTAS[0] += $statsAS[$i];
					
					$tmpFound = 0;
					for($j=1;$j<=count($tmpTeamName);$j++) {
						if(!isset($tmpTeamName[$j])) break 1;
						if($statsTeam[$i] == $tmpTeamName[$j]) {
							$tmpFound = 1;
							break 1;
						}
					}
					if($tmpFound == 0) $j = count($tmpTeamName);
					$tmpTeamName[$j] = $statsTeam[$i];
					$tmpTeamCount[$j]++;
					$statsTOTGP[$j] += $statsGP[$i];
					$statsTOTMin[$j] += $statsMin[$i];
					$statsTOTW[$j] += $statsW[$i];
					$statsTOTL[$j] += $statsL[$i];
					$statsTOTT[$j] += $statsT[$i];
					$statsTOTSO[$j] += $statsSO[$i];
					$statsTOTGA[$j] += $statsGA[$i];
					if($statsTOTMin[$j] != 0) $statsTOTAVG[$j] = round($statsTOTGA[$j] * 60 / $statsTOTMin[$j], 2);
					else $statsTOTAVG[$j] = 0;
					$statsTOTSA[$j] += $statsSA[$i];
					if($statsTOTSA[$j] != 0) $statsTOTPCT[$j] = round(($statsTOTSA[$j] - $statsTOTGA[$j]) / $statsTOTSA[$j], 3);
					else $statsTOTPCT[$j] = 0;
					$statsTOTPIM[$j] += $statsPIM[$i];
					$statsTOTAS[$j] += $statsAS[$i];
				}
			}
			$c = 2;
			for($i=0;$i<count($tmpTeamName);$i++) {
				if($c == 1) $c = 2;
				else $c = 1;
				if($i == 0) echo '<tr class="tableau-top">';
				else echo '<tr>';
				if($i == 0) echo '<td style="" colspan="5">'.$careerStatsSeasonCareer.'</td>';
				else echo '<td>'.$tmpTeamCount[$i].'</td><td class="text-left" colspan="4">'.$tmpTeamName[$i].'</td>';
				echo '<td>'.$statsTOTGP[$i].'</td>
				<td>'.$statsTOTMin[$i].'</td>
				<td>'.$statsTOTAVG[$i].'</td>
				<td>'.$statsTOTW[$i].'</td>
				<td>'.$statsTOTL[$i].'</td>
				<td>'.$statsTOTT[$i].'</td>
				<td>'.$statsTOTSO[$i].'</td>
				<td>'.$statsTOTGA[$i].'</td>
				<td>'.$statsTOTSA[$i].'</td>
				<td>'.$statsTOTPCT[$i].'</td>
				<td>'.$statsTOTPIM[$i].'</td>
				<td>'.$statsTOTAS[$i].'</td>
				</tr>';
			}
		}
		if(!isset($statsPLFNumber)) echo '</tbody></table></div>';
		else echo '<tr><td colspan="20" style="height:20px;"></td></tr>';
	}
	// Playoff TeamScoring
	if(isset($statsPLFNumber)){
		$c = 1;
		if(isset($statsPLFP)) {
			echo '<tr class="tableau-top">
			<td>S</td>
			<td>P</td>
			<td>#</td>
			<td>R</td>
			<td class="text-left">'.$scoringTMm.'</td>
			<td>'.$scoringGPm.'</td>
			<td>'.$scoringGm.'</td>
			<td>A</td>
			<td>Points</td>
			<td>+/-</td>
			<td>'.$scoringPIMm.'</td>
			<td>'.$scoringPPm.'</td>
			<td>'.$scoringSHm.'</td>
			<td>'.$scoringGWm.'</td>
			<td>'.$scoringGTm.'</td>
			<td>'.$scoringHTm.'</td>
			<td>'.$scoringSm.'</td>
			<td>'.$scoringPCTGm.'</td>
			<td>'.$scoringGSm.'</td>
			<td>'.$scoringPSm.'</td>
			</tr>';
			
			for($i=0;$i<count($statsPLFTeam)+1;$i++) {
				$tmpPLFTeamCount[$i] = $statsPLFTGP[$i] = $statsPLFTG[$i] = $statsPLFTA[$i] = $statsPLFTP[$i] = $statsPLFTDiff[$i] = $statsPLFTPIM[$i] = $statsPLFTPPG[$i] = $statsPLFTSHG[$i] = $statsPLFTGW[$i] = $statsPLFTGT[$i] = $statsPLFTHT[$i] = $statsPLFTS[$i] = $statsPLFTPCTG[$i] = $statsPLFTGS[$i] = $statsPLFTPS[$i] = 0;
			}
			
			for($i=0;$i<count($statsPLFTeam);$i++) {
				if($c == 1) $c = 2;
				else $c = 1;
				echo '<tr>
				<td>'.$statsPLFSeason[$i].'</td>
				<td>'.$statsPLFPosition[$i].'</td>
				<td>'.$statsPLFNumber[$i].'</td>
				<td>'.$statsPLFRookie[$i].'</td>
				<td class="text-left">'.$statsPLFTeam[$i].'</td>
				<td>'.$statsPLFGP[$i].'</td>
				<td>'.$statsPLFG[$i].'</td>
				<td>'.$statsPLFA[$i].'</td>
				<td>'.$statsPLFP[$i].'</td>
				<td>'.$statsPLFDiff[$i].'</td>
				<td>'.$statsPLFPIM[$i].'</td>
				<td>'.$statsPLFPPG[$i].'</td>
				<td>'.$statsPLFSHG[$i].'</td>
				<td>'.$statsPLFGW[$i].'</td>
				<td>'.$statsPLFGT[$i].'</td>
				<td>'.$statsPLFHT[$i].'</td>
				<td>'.$statsPLFS[$i].'</td>
				<td>'.$statsPLFPCTG[$i].'</td>
				<td>'.$statsPLFGS[$i].'</td>
				<td>'.$statsPLFPS[$i].'</td>
				</tr>';
				if($statsPLFTeam[$i] != 'TOT') {
					$tmpPLFTeamName[0] = $statsPLFTeam[$i];
					$statsPLFTGP[0] += $statsPLFGP[$i];
					$statsPLFTG[0] += $statsPLFG[$i];
					$statsPLFTA[0] += $statsPLFA[$i];
					$statsPLFTP[0] += $statsPLFP[$i];
					$statsPLFTDiff[0] += $statsPLFDiff[$i];
					$statsPLFTPIM[0] += $statsPLFPIM[$i];
					$statsPLFTPPG[0] += $statsPLFPPG[$i];
					$statsPLFTSHG[0] += $statsPLFSHG[$i];
					$statsPLFTGW[0] += $statsPLFGW[$i];
					$statsPLFTGT[0] += $statsPLFGT[$i];
					$statsPLFTHT[0] += $statsPLFHT[$i];
					$statsPLFTS[0] += $statsPLFS[$i];
					if($statsPLFTS[0] != 0) $statsPLFTPCTG[0] = round($statsPLFTG[0] / $statsPLFTS[0] * 100, 1);
					else $statsPLFTPCTG[0] = 0;
					$statsPLFTGS[0] += $statsPLFGS[$i];
					$statsPLFTPS[0] += $statsPLFPS[$i];
					
					$tmpFound = 0;
					for($j=1;$j<=count($tmpPLFTeamName);$j++) {
						if(!isset($tmpPLFTeamName[$j])) break 1;
						if($statsPLFTeam[$i] == $tmpPLFTeamName[$j]) {
							$tmpFound = 1;
							break 1;
						}
					}
					if($tmpFound == 0) $j = count($tmpPLFTeamName);
					$tmpPLFTeamName[$j] = $statsPLFTeam[$i];
					$tmpPLFTeamCount[$j]++;
					$statsPLFTGP[$j] += $statsPLFGP[$i];
					$statsPLFTG[$j] += $statsPLFG[$i];
					$statsPLFTA[$j] += $statsPLFA[$i];
					$statsPLFTP[$j] += $statsPLFP[$i];
					$statsPLFTDiff[$j] += $statsPLFDiff[$i];
					$statsPLFTPIM[$j] += $statsPLFPIM[$i];
					$statsPLFTPPG[$j] += $statsPLFPPG[$i];
					$statsPLFTSHG[$j] += $statsPLFSHG[$i];
					$statsPLFTGW[$j] += $statsPLFGW[$i];
					$statsPLFTGT[$j] += $statsPLFGT[$i];
					$statsPLFTHT[$j] += $statsPLFHT[$i];
					$statsPLFTS[$j] += $statsPLFS[$i];
					if($statsPLFTS[$j] != 0) $statsPLFTPCTG[$j] = round($statsPLFTG[$j] / $statsPLFTS[$j] * 100, 1);
					else $statsPLFTPCTG[$j] = 0;
					$statsPLFTGS[$j] += $statsPLFGS[$i];
					$statsPLFTPS[$j] += $statsPLFPS[$i];
				}
			}
			$c = 2;
			for($i=0;$i<count($tmpPLFTeamName);$i++) {
				if($c == 1) $c = 2;
				else $c = 1;
				if($i == 0) echo '<tr class="tableau-top">';
				else echo '<tr>';
				if($i == 0) echo '<td style="" colspan="5">'.$careerStatsPlayoffCareer.'</td>';
				else echo '<td>'.$tmpPLFTeamCount[$i].'</td><td class="text-left" colspan="4">'.$tmpPLFTeamName[$i].'</td>';
				echo '<td>'.$statsPLFTGP[$i].'</td>
				<td>'.$statsPLFTG[$i].'</td>
				<td>'.$statsPLFTA[$i].'</td>
				<td>'.$statsPLFTP[$i].'</td>
				<td>'.$statsPLFTDiff[$i].'</td>
				<td>'.$statsPLFTPIM[$i].'</td>
				<td>'.$statsPLFTPPG[$i].'</td>
				<td>'.$statsPLFTSHG[$i].'</td>
				<td>'.$statsPLFTGW[$i].'</td>
				<td>'.$statsPLFTGT[$i].'</td>
				<td>'.$statsPLFTHT[$i].'</td>
				<td>'.$statsPLFTS[$i].'</td>
				<td>'.$statsPLFTPCTG[$i].'</td>
				<td>'.$statsPLFTGS[$i].'</td>
				<td>'.$statsPLFTPS[$i].'</td>
				</tr>';
			}
		}
		
		if(isset($statsPLFAVG)) {
			echo '<tr class="tableau-top">
			<td>S</td>
			<td>P</td>
			<td>#</td>
			<td>R</td>
			<td class="text-left">'.$scoringTMm.'</td>
			<td>'.$scoringGPm.'</td>
			<td>MIN</td>
			<td>'.$scoringAVGm.'</td>
			<td>'.$scoringWm.'</td>
			<td>'.$scoringLm.'</td>
			<td>'.$scoringTm.'</td>
			<td>'.$scoringSOm.'</td>
			<td>'.$scoringGAm.'</td>
			<td>'.$scoringSAm.'</td>
			<td>PCT</td>
			<td>'.$scoringPIMm.'</td>
			<td>AS</td>
			</tr>';
			
			for($i=0;$i<count($statsPLFTeam)+1;$i++) {
				$tmpPLFTeamCount[$i] = $statsPLFTOTGP[$i] = $statsPLFTOTMin[$i] = $statsPLFTOTAVG[$i] = $statsPLFTOTW[$i] = $statsPLFTOTL[$i] = $statsPLFTOTT[$i] = $statsPLFTOTSO[$i] = $statsPLFTOTGA[$i] = $statsPLFTOTSA[$i] = $statsPLFTOTPCT[$i] = $statsPLFTOTPIM[$i] = $statsPLFTOTAS[$i] = 0;
			}
			
			for($i=0;$i<count($statsPLFTeam);$i++) {
				echo '<tr>
				<td >'.$statsPLFSeason[$i].'</td>
				<td>G</td>
				<td>'.$statsPLFNumber[$i].'</td>
				<td>'.$statsPLFRookie[$i].'</td>
				<td class="text-left">'.$statsPLFTeam[$i].'</td>
				<td>'.$statsPLFGP[$i].'</td>
				<td>'.$statsPLFMin[$i].'</td>
				<td>'.$statsPLFAVG[$i].'</td>
				<td>'.$statsPLFW[$i].'</td>
				<td>'.$statsPLFL[$i].'</td>
				<td>'.$statsPLFT[$i].'</td>
				<td>'.$statsPLFSO[$i].'</td>
				<td>'.$statsPLFGA[$i].'</td>
				<td>'.$statsPLFSA[$i].'</td>
				<td>'.$statsPLFPCT[$i].'</td>
				<td>'.$statsPLFPIM[$i].'</td>
				<td>'.$statsPLFAS[$i].'</td>
				</tr>';
				if($statsPLFTeam[$i] != 'TOT') {
					$tmpPLFTeamName[0] = $statsPLFTeam[$i];
					$statsPLFTOTGP[0] += $statsPLFGP[$i];
					$statsPLFTOTMin[0] += $statsPLFMin[$i];
					$statsPLFTOTW[0] += $statsPLFW[$i];
					$statsPLFTOTL[0] += $statsPLFL[$i];
					$statsPLFTOTT[0] += $statsPLFT[$i];
					$statsPLFTOTSO[0] += $statsPLFSO[$i];
					$statsPLFTOTGA[0] += $statsPLFGA[$i];
					$statsPLFTOTAVG[0] = round($statsPLFTOTGA[0] * 60 / $statsPLFTOTMin[0], 2);
					$statsPLFTOTSA[0] += $statsPLFSA[$i];
					if($statsPLFTOTSA[0] != 0) $statsPLFTOTPCT[0] = round(($statsPLFTOTSA[0] - $statsPLFTOTGA[0]) / $statsPLFTOTSA[0], 3);
					else $statsPLFTOTPCT[0] = 0;
					$statsPLFTOTPIM[0] += $statsPLFPIM[$i];
					$statsPLFTOTAS[0] += $statsPLFAS[$i];
					
					$tmpFound = 0;
					for($j=1;$j<=count($tmpPLFTeamName);$j++) {
						if(!isset($tmpPLFTeamName[$j])) break 1;
						if($statsPLFTeam[$i] == $tmpPLFTeamName[$j]) {
							$tmpFound = 1;
							break 1;
						}
					}
					if($tmpFound == 0) $j = count($tmpPLFTeamName);
					$tmpPLFTeamName[$j] = $statsPLFTeam[$i];
					$tmpPLFTeamCount[$j]++;
					$statsPLFTOTGP[$j] += $statsPLFGP[$i];
					$statsPLFTOTMin[$j] += $statsPLFMin[$i];
					$statsPLFTOTW[$j] += $statsPLFW[$i];
					$statsPLFTOTL[$j] += $statsPLFL[$i];
					$statsPLFTOTT[$j] += $statsPLFT[$i];
					$statsPLFTOTSO[$j] += $statsPLFSO[$i];
					$statsPLFTOTGA[$j] += $statsPLFGA[$i];
					$statsPLFTOTAVG[$j] = round($statsPLFTOTGA[$j] * 60 / $statsPLFTOTMin[$j], 2);
					$statsPLFTOTSA[$j] += $statsPLFSA[$i];
					if($statsPLFTOTSA[$j] != 0) $statsPLFTOTPCT[$j] = round(($statsPLFTOTSA[$j] - $statsPLFTOTGA[$j]) / $statsPLFTOTSA[$j], 3);
					else $statsPLFTOTPCT[$j] = 0;
					$statsPLFTOTPIM[$j] += $statsPLFPIM[$i];
					$statsPLFTOTAS[$j] += $statsPLFAS[$i];
				}
			}
			$c = 2;
			for($i=0;$i<count($tmpPLFTeamName);$i++) {
				if($c == 1) $c = 2;
				else $c = 1;
				if($i == 0) echo '<tr class="tableau-top">';
				else echo '<tr>';
				if($i == 0) echo '<td colspan="5">'.$careerStatsPlayoffCareer.'</td>';
				else echo '<td>'.$tmpPLFTeamCount[$i].'</td><td class="text-left" colspan="4">'.$tmpPLFTeamName[$i].'</td>';
				echo '<td>'.$statsPLFTOTGP[$i].'</td>
				<td>'.$statsPLFTOTMin[$i].'</td>
				<td>'.$statsPLFTOTAVG[$i].'</td>
				<td>'.$statsPLFTOTW[$i].'</td>
				<td>'.$statsPLFTOTL[$i].'</td>
				<td>'.$statsPLFTOTT[$i].'</td>
				<td>'.$statsPLFTOTSO[$i].'</td>
				<td>'.$statsPLFTOTGA[$i].'</td>
				<td>'.$statsPLFTOTSA[$i].'</td>
				<td>'.$statsPLFTOTPCT[$i].'</td>
				<td>'.$statsPLFTOTPIM[$i].'</td>
				<td>'.$statsPLFTOTAS[$i].'</td>
				</tr>';
			}
		}
		echo '</tbody></table></div>';
	}
	
	// Last 10 Games
	if(isset($scheduleNumber)) {
		$c = 1;
		$matchPlayedFirst = 0;

		echo '<h3 class="tableau-top">'.$careerStatsGameLog.'</h3>';

		echo '<div class="table-responsive"><table class="table table-sm table-striped table-hover">';
		echo '<thead>';
		echo '<tr class="tableau-top">
		<th>#</th>
		<th>OPP.</th>
		<th>SCORE</th>';
		if($matchType == 1) {
			echo '<th>'.$gamesGoal.'</th>
			<th>'.$gamesAss.'</th>
			<th>'.$gamesPoints.'</th>
			<th>+/-</th>
			<th>'.$gamesPIM.'</th>
			<th>'.$gamesShots.'</th>
			<th>'.$gamesHT.'</th>
			<th>'.$gamesIceTime.'</th>';
		}
		if($matchType == 2) {
			echo '<th>'.$careerStatsSAVES.'</th>
			<th>'.$careerStatsSHOTS.'</th>
			<th>'.$careerStatsGOALS.'</th>
			<th>'.$careerStatsRECORD.'</th>';
		}
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
		for($i=0;$i<count($scheduleNumber);$i++) {
			if($matchPlayed[$i] == 1 || $matchPlayedFirst == 1) {
				if($c == 1) $c = 2;
				else $c = 1;
				echo '<tr>';
				$tmpLink = '';
				if($matchRnd[$i] != 0) $tmpLink = '&rnd='.$matchRnd[$i];
				echo '<td style="width:40px;"><a href="games.php?num='.$scheduleNumber[$i].$tmpLink.'">'.$scheduleNumber[$i].'</a></td>';
				if($equipe1[$i] == $lastTeam) echo '<td>@'.$equipe2[$i].'</td>';
				if($equipe2[$i] == $lastTeam) echo '<td>'.$equipe1[$i].'</td>';
				$tmpScore = 'L';
				if($equipe1[$i] == $lastTeam && $score1[$i] > $score2[$i]) $tmpScore = 'W';
				if($equipe2[$i] == $lastTeam && $score1[$i] < $score2[$i]) $tmpScore = 'W';
				echo '<td>'.$tmpScore.' '.$score1[$i].'-'.$score2[$i].'</td>';
				if($matchPlayed[$i] == 1) {
					if(isset($matchG[$i])) {
						echo '<td>'.$matchG[$i].'</td>';
						echo '<td>'.$matchA[$i].'</td>';
						echo '<td>'.$matchP[$i].'</td>';
						echo '<td>'.$matchDiff[$i].'</td>';
						echo '<td>'.$matchPIM[$i].'</td>';
						echo '<td>'.$matchS[$i].'</td>';
						echo '<td>'.$matchHT[$i].'</td>';
						echo '<td>'.$matchIT[$i].'</td>';
					}
					else {
						echo '<td>'.$matchSave[$i].'</td>';
						echo '<td>'.$matchShots[$i].'</td>';
						echo '<td>'.$matchResult[$i].'</td>';
						echo '<td>'.$matchFiche[$i].'</td>';
					}
					$matchPlayedFirst = 1;
				}
				else {
					if($matchType == 1) echo '<td colspan="8">'.$careerStatsNotPlayed.'</td>';
					if($matchType == 2) echo '<td colspan="4">'.$careerStatsNotPlayed.'</td>';
				}
				echo '</tr>';
			}
		}
		echo '</tbody></table></div>';
	}
	echo '</div>';
// 	echo '</div>';
// 	echo '</div>';
// 	echo '</div>';
// 	echo '</div>';
}
else {
	echo '<div style="display:block; clear:both; margin-left:auto; margin-right:auto; width:555px; text-align:center;">'.$careerStatsNoStatsFoundFor.' '.$csName.'</div>';
}

echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';

?>

<?php include 'footer.php'; ?>