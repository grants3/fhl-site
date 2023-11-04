<?php
require_once 'config.php';
include 'lang.php';
include 'fileUtils.php';
$CurrentHTML = 'TeamStats.php';
$CurrentTitle = $teamStatsTitle;
$CurrentPage = 'TeamStats';

//sort support
$sort = '';
if(isset($_GET['sort']) || isset($_POST['sort'])) {
    $sort = ( isset($_GET['sort']) ) ? $_GET['sort'] : $_POST['sort'];
    $sort = htmlspecialchars($sort);
}

$teamStatsFile = getCurrentLeagueFile('TeamStats');
$OrigHTML = $teamStatsFile;

include 'head.php';

?>

<div class="container px-0">
<div class="card p-1">
	<?php include 'SectionHeader.php';?>
	<div class="card-body p-1 px-lg-4">
<div class="row no-gutters">
<div class="col-sm-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2"> 	


<?php

// $round = 1;
// // collect PPG PPO PKGA PKO

// if(!PLAYOFF_MODE) {
//     $Fnm = getLeagueFile('Schedule');
//     $baseFileName = 'Schedule';
// }else{
//     $round = getPlayoffRound();
// }


$baseFileName='';
$round=1;
if(PLAYOFF_MODE) {
    $round = getPlayoffRound();
}else{
    $baseFileName = 'Schedule';
    $Fnm = getCurrentRegSeasonFile($baseFileName);
}



for($j=1;$j<=$round;$j++) {
    if(PLAYOFF_MODE) {
		//$Fnm = $folder.$folderLeagueURL2.'PLF-Round'.$j.'-Schedule.html';
        $baseFileName = '-Round'.$j.'-Schedule';
        $Fnm = getCurrentPlayoffLeagueFile($baseFileName);
	}

	if(file_exists($Fnm)) {
		// DÉTECTER LES PARTIES JOUÉES
		$i = 0;
		unset($schelduleNumber);
		$tableau = file($Fnm);
		while(list($cle,$val) = myEach($tableau)) {
			if(substr_count($val, ' at ') && !substr_count($val, '<strike>')){
				break 1;
			}
			if(substr_count($val, 'A HREF=')){
				$reste = trim(substr($val, strpos($val, '> ')+1));
				$schelduleNumber[$i] = substr($reste, 0, strpos($reste, ' '));
				$i++;
			}
		}
		// OUVRIR CHAQUE PARTIE POUR VOIR LES RÉSULTATS PP/PK
		if(isset($schelduleNumber)) {
			for($i=0;$i<count($schelduleNumber);$i++) {
				$matchNumber = $schelduleNumber[$i];

				if(PLAYOFF_MODE){
				    $Fnm = getGameFile($matchNumber, null, $j);
				}else{
				    $Fnm = getGameFile($matchNumber);
				}
				
				$a = 0;
				if(file_exists($Fnm)) {
					$tableau = file($Fnm);
					while(list($cle,$val) = myEach($tableau)) {
						$val = encodeToUtf8($val);
						if(substr_count($val, ' at ') && $a == 0){
							$pos = strpos($val, ' at ');
							$pos_apres = strpos($val, '</H3>');
							$pos_avant = strpos($val, '<H3>') + 4;
							$long1 = $pos - $pos_avant;
							$pos = $pos + 4;
							$long2 = $pos_apres - $pos;
							$tmpGameTeam1 = trim(substr($val, $pos_avant, $long1));
							$tmpGameTeam2 = trim(substr($val, $pos, $long2));
							$a = 1;
						}
						if(substr_count($val, 'Power Play Conversions') && $a == 1) {
							$a = 2;
							$b = 0;
						}
						if(substr_count($val, 'Game Stars') && $a == 2) {
							break 1;
						}
						if(substr_count($val, 'for') && $a == 2) {
							
							if(substr_count($val, $tmpGameTeam1)) {
								$tmpTeam1PPG = trim(substr($val, strlen($tmpGameTeam1)+1, strpos($val, 'for')-1-strlen($tmpGameTeam1)-1));
								$tmpTeam1PPGO = trim(substr($val, strpos($val, 'for')+4, strpos($val, '<')-strpos($val, 'for')-4));
							}
							if(substr_count($val, $tmpGameTeam2)) {
								$tmpTeam2PPG = trim(substr($val, strlen($tmpGameTeam2)+1, strpos($val, 'for')-1-strlen($tmpGameTeam2)-1));
								$tmpTeam2PPGO = trim(substr($val, strpos($val, 'for')+4, strpos($val, '<')-strpos($val, 'for')-4));
							}
							
							$b++;
							
							if($b == 2) {
								$d = 0;
								for($k = 0; $k < count($teamList) ; $k++) {
									if($tmpGameTeam1 == $teamList[$k]) {
										$d++;
										if(isset($gameStatsFilePPG[$k])) $gameStatsFilePPG[$k] += $tmpTeam1PPG;
										else $gameStatsFilePPG[$k] = $tmpTeam1PPG;
										if(isset($gameStatsFilePPGO[$k])) $gameStatsFilePPGO[$k] += $tmpTeam1PPGO;
										else $gameStatsFilePPGO[$k] = $tmpTeam1PPGO;
										if(isset($gameStatsFilePKGA[$k])) $gameStatsFilePKGA[$k] += $tmpTeam2PPG;
										else $gameStatsFilePKGA[$k] = $tmpTeam2PPG;
										if(isset($gameStatsFilePKOA[$k])) $gameStatsFilePKOA[$k] += $tmpTeam2PPGO;
										else $gameStatsFilePKOA[$k] = $tmpTeam2PPGO;
									}
									if($tmpGameTeam2 == $teamList[$k]) {
										$d++;
										if(isset($gameStatsFilePPG[$k])) $gameStatsFilePPG[$k] += $tmpTeam2PPG;
										else $gameStatsFilePPG[$k] = $tmpTeam2PPG;
										if(isset($gameStatsFilePPGO[$k])) $gameStatsFilePPGO[$k] += $tmpTeam2PPGO;
										else $gameStatsFilePPGO[$k] = $tmpTeam2PPGO;
										if(isset($gameStatsFilePKGA[$k])) $gameStatsFilePKGA[$k] += $tmpTeam1PPG;
										else $gameStatsFilePKGA[$k] = $tmpTeam1PPG;
										if(isset($gameStatsFilePKOA[$k])) $gameStatsFilePKOA[$k] += $tmpTeam1PPGO;
										else $gameStatsFilePKOA[$k] = $tmpTeam1PPGO;
									}
									if($d == 2) break 1;
								}
							}
						}
					}
				}
				//else echo $allFileNotFound.' - Game file missing <br>';
				else{
				    if(DEBUG_MODE){
				        error_log('Game file missing match number: '.$matchNumber);
				    }
				}
			}
		}
	}
	else echo $allFileNotFound.' - '.$baseFileName.'<br>';
}

// Team Stats
$a = 0;
$c = 1;
$lastUpdated = '';

if(file_exists($teamStatsFile)) {
    $tableau = file($teamStatsFile);
	while(list($cle,$val) = myEach($tableau)) {
		$val = encodeToUtf8($val);
		if(substr_count($val, '<P>(As of')){
			$pos = strpos($val, ')');
			$pos = $pos - 10;
			$val = substr($val, 10, $pos);
			$lastUpdated = $val;
			//echo '<h5 class = "text-center">'.$allLastUpdate.' '.$val.'</h5>';
			
	
			echo '<div class="table-responsive">';
			echo '<table id="teamStatsTable" class="table table-sm table-striped table-hover text-center table-rounded">';
			echo '<thead>';
		}
		if(substr_count($val, '</PRE>')){
			$a++;
		}
		if($a == 1){
			$tmpTeam = trim(substr($val, 0, 10));
			$tmpGP = substr($val, 14, 2);
			$tmpPP = substr($val, 18, 5);
			$tmpPK = substr($val, 24, 5);
			$tmpPIMP = substr($val, 32, 5);
			$tmpGFG = substr($val, 39, 5);
			$tmpGAG = substr($val, 45, 5);
			$tmpSFG = substr($val, 52, 5);
			$tmpSAG = substr($val, 59, 5);
			
			for($k = 0; $k < count($teamList) ; $k++) {
				if($tmpTeam == $teamList[$k]) {
					$teamStatsFileGP[$k] = $tmpGP;
					$teamStatsFilePP[$k] = $tmpPP;
					$teamStatsFilePK[$k] = $tmpPK;
					$teamStatsFilePIMP[$k] = $tmpPIMP;
					$teamStatsFileGFG[$k] = $tmpGFG;
					$teamStatsFileGAG[$k] = $tmpGAG;
					$teamStatsFileSFG[$k] = $tmpSFG;
					$teamStatsFileSAG[$k] = $tmpSAG;
					break 1;
				}
			}
		}
		if(substr_count($val, '<PRE>')){
			$a++;
		}
	}
	
	if(isset($teamStatsFileGP)) {
	    $tableaut = $teamStatsFileGP;
		
		echo '<tr>
			
			<th class="text-left">'.$teamStatsTEAM.'</th>
			<th>'.$teamStatsGPm.'</th>
			<th>'.$teamStatsPPGm.'</th>
			<th>'.$teamStatsPPOm.'</th>
			<th>'.$teamStatsPPm.'</th>
			<th>'.$teamStatsPKGAm.'</th>
			<th>'.$teamStatsPKOm.'</th>
			<th>'.$teamStatsPKm.'</th>
			<th>'.$teamStatsPIMGm.'</th>
			<th>'.$teamStatsGFGm.'</th>
			<th>'.$teamStatsGAGm.'</th>
			<th>'.$teamStatsSFGm.'</th>
			<th>'.$teamStatsSAGm.'</th>
			</tr>';
		echo '</thead>';
		echo '<tbody>';
		if($sort) natsort($tableaut);
		if($sort == 'pja' || $sort == 'ana' || $sort == 'dna' || $sort == 'ppa' || $sort == 'bpa' || $sort == 'bca' || $sort == 'tpa' || $sort == 'tca' || $sort == 'ppga' || $sort == 'ppoa' || $sort == 'pkga' || $sort == 'pkoa') $tableaut = array_reverse ($tableaut, TRUE);
		$key = key($tableaut);
		$val = current($tableaut);
		
		$i = 0;
		while(list ($key, $val) = myEach($tableaut)) {
			if($c == 1) $c = 2;
			else $c = 1;
			$equipe = $teamList[$key];

			$position = $i + 1;
			echo '<tr>
			
			<td class="text-left">'.$equipe.'</td>
			<td>'.$teamStatsFileGP[$key].'</td>';
			if($teamStatsFilePP[$key] == 'N/A') {
				$gameStatsFilePPG[$key] = 0;
				$gameStatsFilePPGO[$key] = 0;
			}
			echo '<td>'.$gameStatsFilePPG[$key].'</td>';
			echo '<td>'.$gameStatsFilePPGO[$key].'</td>';
			echo '<td>'.$teamStatsFilePP[$key].'</td>';
			if($teamStatsFilePK[$key] == 'N/A') {
				$gameStatsFilePKGA[$key] = 0;
				$gameStatsFilePKOA[$key] = 0;
			}
			echo '<td>'.$gameStatsFilePKGA[$key].'</td>';
			echo '<td>'.$gameStatsFilePKOA[$key].'</td>';
			echo '<td>'.$teamStatsFilePK[$key].'</td>
			<td >'.$teamStatsFilePIMP[$key].'</td>
			<td>'.$teamStatsFileGFG[$key].'</td>
			<td>'.$teamStatsFileGAG[$key].'</td>
			<td>'.$teamStatsFileSFG[$key].'</td>
			<td>'.$teamStatsFileSAG[$key].'</td>
			</tr>';
			$i++;
		}
	}
	else echo '<tr><td>'.$teamStatsStarted.'</td></tr>';
}
else{
    echo '<tr><td>'.$allFileNotFound.' - '.$Fnm.'</td></tr>';
}
echo '</tbody></table></div>';

if(isset($lastUpdated)){
    echo '<h6 class = "text-center">'.$allLastUpdate.' '.$lastUpdated.'</h6>';
}

echo '</div></div></div></div></div>';
?>

<script>
$(document).ready(function() 
    { 
        $("#teamStatsTable").tablesorter({ 
            sortInitialOrder: 'desc'
    	}); 

    } 
); 



</script>


<?php include 'footer.php'; ?>
