<style>

#treeRow { display: flex; align-items: center; }

.roundHeader {
    font-size:20pt;
    margin:20px;
}

</style>

<?php
require_once 'config.php';
include_once 'lang.php';
include_once 'common.php';

$baseFolder = '';
$seasonId = '';
if(isset($_GET['seasonId']) || isset($_POST['seasonId'])) {
    $seasonId = ( isset($_GET['seasonId']) ) ? $_GET['seasonId'] : $_POST['seasonId'];
}

if(trim($seasonId) == false){
    $baseFolder = TRANSFER_DIR;
}else{
    $baseFolder = str_replace("#",$seasonId,CAREER_STATS_DIR);
}


$Fnm = '';
$existRnd = 0;
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
if(file_exists($baseFolder.$folderLeagueURL2.'PLF-Round1-Schedule.html')) {
	$existRnd = 1;
	if(file_exists($baseFolder.$folderLeagueURL2.'PLF-Round2-Schedule.html')) {
		$existRnd = 2;
		if(file_exists($baseFolder.$folderLeagueURL2.'PLF-Round3-Schedule.html')) {
			$existRnd = 3;
			if(file_exists($baseFolder.$folderLeagueURL2.'PLF-Round4-Schedule.html')) {
				$existRnd = 4;
			}
		}
	}
}


?>

<?php 
if(trim($seasonId) == false && $existRnd == 0){
    echo '<col>';
    echo '<h5 class="text-center">Playoffs have not started</h5>';
    echo '</col>';
}
?>

<div id = "treeRow" class="row">

<?php

$k = 0;
for($j=1;$j<=$existRnd;$j++) {
	//echo '<td>';
    
    if($j == 4){
        $roundName = $StandingsTreeFinals;
    }else{
        $roundName = $StandingsTreeRound.' '.$j;
    }
    
    $order = $existRnd - $j;
    if($order <= 0){
        $order = 1;
    }else{
        $order++;
    }
    
    echo '<div class="col-12 order-'.$order.' col-md-12 col-lg-3 order-lg-1">';
	echo '<div class = "tableau-top">'.$roundName.'</div>';

	$TeamNumber = 100;
	$currentTeamCpt = 0;
	$equipe1 = '';
	$Fnm = $baseFolder.$folderLeagueURL2.'PLF-Round'.$j.'-Schedule.html';

	if(file_exists($Fnm)) {
		for($x=0;$x<$TeamNumber;$x++) {
			$tableau = file($Fnm);
			$k = 0;
			$l = 0;
			$m = 0; // DAY
			$tmpTot1 = 0;
			$tmpTot2 = 0;
			unset($score1);
			unset($score2);
			unset($day);
			while(list($cle,$val) = myEach($tableau)) {
				$val = encodeToUtf8($val);
				if(substr_count($val, 'Day ')){
					$l = 0;
					$m++;
				}
				if(substr_count($val, 'Day 1')){
					$TeamNumber = 0;
					$currentTeamCpt++;
				}
				if($m < 2 && (substr_count($val, 'A HREF=') || substr_count($val, ' at '))){
					$TeamNumber++;
				}
				if($l == 0 && substr_count($val, 'A HREF=')){
					$reste = trim(substr($val, strpos($val, '> ')+1));
					$tmpDay = substr($reste, 0, strpos($reste, ' '));
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
					$tmpTeam1 = substr($reste, 0, $pos3-1);
					$reste = trim(substr($reste, $pos3));
					$tmpScore1 = substr($reste, 0, strpos($reste, ' '));
					$reste = trim(substr($reste, strpos($reste, ' ')));
					$z = 0;
					while( $z < $count ) {
						if( ctype_digit($reste[$z]) ) {
							$pos3 = $z;
							break 1;
						}
						$z++;
					}
					$tmpTeam2 = substr($reste, 0, $pos3-1);
					$reste = trim(substr($reste, $pos3));
					$tmpScore2 = $reste;
				
					if($k == 0) {
						if($currentTeamCpt == $TeamNumber) {
							$k = 1;
							$l = 1;
							unset($score1);
							unset($score2);
							$score1 = array();
							$score2 = array();
							$day = array();
							$equipe1 = $tmpTeam1;
							$equipe2 = $tmpTeam2;
							$day[$m] = $tmpDay;
							$score1[$m] = $tmpScore1;
							$score2[$m] = $tmpScore2;
						}
					}
					else {
						if($equipe1 == $tmpTeam1) {
							$day[$m] = $tmpDay;
							$score1[$m] = $tmpScore1;
							$score2[$m] = $tmpScore2;
							$l = 1;
						}
						if($equipe1 == $tmpTeam2) {
							$day[$m] = $tmpDay;
							$score1[$m] = $tmpScore2;
							$score2[$m] = $tmpScore1;
							$l = 1;
						}
					}
				}
				if($l == 0 && substr_count($val, ' at ')){
					$reste = trim(str_replace('<br>','', $val));
					$reste = trim(str_replace('<BR>','', $reste));
					$tmpDay = substr($reste, 0, strpos($reste, ' '));
					$reste = trim(substr($reste, strpos($reste, ' ')));
					$tmpTeam1 = substr($reste, 0, strpos($reste, ' at '));
					$reste = trim(substr($reste, strpos($reste, ' at ')+4));
					$tmpTeam2 = $reste;
				
					if($k == 0) {
						if($currentTeamCpt == $TeamNumber) {
							$k = 1;
							$l = 1;
							$day = array();
							$equipe1 = $tmpTeam1;
							$equipe2 = $tmpTeam2;
							$day[$m] = $tmpDay;
						}
					}
					else {
						if($equipe1 == $tmpTeam1) {
							$day[$m] = $tmpDay;
							$l = 1;
						}
						if($equipe1 == $tmpTeam2) {
							$day[$m] = $tmpDay;
							$l = 1;
						}
					}
				}
			}
			if($TeamNumber != 0) {
			    //echo '<table style="width:25%" class="table table-sm" >';
			    //echo '<div class="col-3">';
			    echo '<table class="table table-sm table-striped table-rounded" text-center" >';
			    echo '<thead>';
			    echo '<tr class="tableau-top">';
			    echo '<th style="width:20%"></th>';
			    
			    //for($w=1;$w<=$m;$w++) {
			    for($w=1;$w<=8;$w++) {
			        if(isset($day[$w]) && isset($score1[$w])) echo '<th style="width:5%"><a class="lien-blanc" href="games.php?seasonId='.$seasonId.'&num='.$day[$w].'&rnd='.$j.'" >'.$w.'</a></th>';
			        //else echo '<td>'.$w.'</td>';
			        elseif($w == 8) echo '<th style="width:5%"><a class="lien-blanc" href="Schedule.php?seasonId='.$seasonId.'&rnd='.$j.'">Series</a></th>';
			        else echo '<th style="width:5%"></th>';
			    }
			   
			    echo '</tr>';
			    echo '</thead>';
			    echo '<tbody>';
			    echo '<tr class="hover2"><td class="text-left">'.$equipe2.'</td>';
			    for($w=1;$w<=$m;$w++) {
			        if(!isset($score2[$w])) $score2[$w] = '';
			        else if($score2[$w] > $score1[$w]) $tmpTot2++;
			        echo '<td class="text-center">'.$score2[$w].'</td>';
			    }
			    echo '<td class="text-center" style="font-weight:bold;">'.$tmpTot2.'</td>';
			    echo '</tr>';
			    echo '<tr class="hover1"><td class="text-left">'.$equipe1.'</td>';
			    for($w=1;$w<=$m;$w++) {
			        if(!isset($score1[$w])) $score1[$w] = '';
			        else if($score2[$w] < $score1[$w]) $tmpTot1++;
			        echo '<td class="text-center">'.$score1[$w].'</td>';
			    }
			    echo '<td class="text-center" style="font-weight:bold;">'.$tmpTot1.'</td>';
			    echo '</tr>';
			    echo '</tbody>';
			    echo '</table>';
			    //echo '</div>';
			}
			else echo "Errors!";
		}
	}
	else { 
	    
	    if(trim($seasonId) == false){
	        echo '<div class="card"><div class="card-body"><h6 class="text-center">Playoffs have not started or data not found</h6></div></div>';
	    }else{
	        echo '<div class="card"><div class="card-body"><h6 class="text-center">'.$allFileNotFound.' - '.$Fnm.'</h6></div></div>';
	    }
	    
		
	}
	//echo '</td>';
	
	echo '</div>';

}
?>

</div>

