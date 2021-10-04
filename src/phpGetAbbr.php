<?php
if(!function_exists('search')) {
	function search($Fnm,$currentTeam) {
		$b = 0;
		$d = 0;
		$tableau = file($Fnm);
		while(list($cle,$val) = myEach($tableau)) {
			$val = utf8_encode($val);
			if(substr_count($val, 'A NAME='.$currentTeam)) {
				$b = 1;
			}
			if($b == 1 && $d == 1) {
				$reste = trim($val);
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				if(substr($reste, 0, 1) == '*') {
					$reste = trim(substr($reste, 1));
				}
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				return $TSabbr = trim(substr($reste, strrpos($reste, ' ')));
			}
			if($b == 1 && substr_count($val, 'PCTG')) {
				$d = 1;
			}
		}
	}
}

if(isset($currentTeam) && $currentTeam != '') {
	$matches = glob($folder.'*TeamScoring.html');
	$folderLeagueURL2 = '';
	$matchesDate = array_map('filemtime', $matches);
	arsort($matchesDate);
	foreach ($matchesDate as $j => $val) {
		if(!substr_count($matches[$j], 'PLF')) {
			$folderLeagueURL2 = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'TeamScoring')-strrpos($matches[$j], '/')-1);
			break 1;
		}
	}
	$TSabbr = '';
	$Fnm = $folder.$folderLeagueURL2.'TeamScoring.html';
	if(file_exists($Fnm)) {
		$TSabbr = search($Fnm,$currentTeam);
	}
	else echo $allFileNotFound.' - '.$Fnm;
	
	// Recherche des saisons antérieurs
	if($folderCarrerStats != '0' && $TSabbr == '') {
		$hashFolder = '';
		$tmpLong = 0;
		for($i=0;$i<substr_count($folderCarrerStats, '/');$i++) {
			if($hashFolder != '') $tmpLong = strlen($hashFolder)+1;
			$hashFolder = substr($folderCarrerStats, 0+$tmpLong, strpos($folderCarrerStats, '/'));
			if(substr_count($hashFolder, '#') > 0) break 1;
		}
		$Fnm = str_replace("#/","*",$folderCarrerStats);
		$NumberSeason = 0;
		$dirs = glob($Fnm, GLOB_ONLYDIR);
		for($j=0;$j<count($dirs);$j++) {
			if(substr_count($dirs[$j], $hashFolder)) {
				$tmpYear = substr($dirs[$j], strlen($folderCarrerStats)-2);
				if($NumberSeason < $tmpYear) $NumberSeason = $tmpYear;
			}
		}
		$Fnmtmp = str_replace("#",$NumberSeason,$folderCarrerStats);
		$matches = glob($Fnmtmp.'*TeamScoring.html');
		$folderLeagueURL3 = '';
		for($k=0;$k<count($matches);$k++) {
			if(!substr_count($matches[$k], 'PLF')) {
				$folderLeagueURL3 = substr($matches[$k], strrpos($matches[$k], '/')+1,  strpos($matches[$k], 'TeamScoring')-strrpos($matches[$k], '/')-1);
				$Fnm = $Fnmtmp.$folderLeagueURL3.'TeamScoring.html';
				break 1;
			}
		}
		if(file_exists($Fnm)) {
			$TSabbr = search($Fnm,$currentTeam);
		}
		//else echo $allFileNotFound.' - '.$Fnm;
	}
}
?>