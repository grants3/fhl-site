<?php
require_once 'config.php';
include 'lang.php';
$CurrentHTML = 'Leaders.php';
$CurrentTitle = $leaderTitle;
$CurrentPage = 'Leaders';
include 'head.php';
?>

<div class="container">
<div class="row no-gutters">
<div class="col-sm-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2"> 	
<div class="card p-1">
	<?php include 'SectionHeader.php';?>
	<div class="card-body p-2 px-lg-4">


<?php
$tableColScoring = 12;
$tableColGoaltending = 14;
if($currentFarm == 1) {
	$tableColScoring = 7;
	$tableColGoaltending = 4;
	$playoff = '';
}
include 'phpGetAbbr.php'; // Output $TSabbr

$a = 0;
$b = 0;
$c = 1;
$i = 0;
$lastUpdated = '';
$matches = glob($folder.'*'.$playoff.$farm.'Leaders.html');
$folderLeagueURL = '';
$matchesDate = array_map('filemtime', $matches);
arsort($matchesDate);
foreach ($matchesDate as $j => $val) {
	if((!substr_count($matches[$j], 'Farm') && $farm == '') || (substr_count($matches[$j], 'Farm') && $farm == 'Farm')) {
	if((!substr_count($matches[$j], 'PLF') && $playoff == '') || (substr_count($matches[$j], 'PLF') && $playoff == 'PLF')) {
		$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], $farm.'Leaders')-strrpos($matches[$j], '/')-1);
		break 1;
	}
	}
}
$Fnm = $folder.$folderLeagueURL.$farm.'Leaders.html';
if(file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = myEach($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, '<P>(As of')){
			$pos = strpos($val, ')');
			$pos = $pos - 10;
			$val = substr($val, 10, $pos);
			$lastUpdated = $val;
			
			//echo '<h5 class = "text-center">'.$allLastUpdate.' '.$val.'</h5>';

			echo '<div class="table-responsive">';
			echo '<table id = "leadersScTable" class="table table-sm table-striped table-hover text-center table-rounded-bottom">';
		
		}
		if(substr_count($val, '</PRE>')) {
			$a = 0;
		}
		if(substr_count($val, '</PRE>')) {
			$b = 0;
		}
		if($a) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')') - $pos;
			$joueur[$i] = trim(substr($val, 0, $pos));
			$equipes[$i] = substr($val, $pos+1, $pos2-1);
			
			$reste = trim(substr($val, strpos($val, ')')+1));
			$gp[$i] = substr($reste, 0, strpos($reste, ' '));
			
			$reste = trim(substr($reste, strpos($reste, ' ')+1));
			$goal[$i] = substr($reste, 0, strpos($reste, ' '));
			
			$reste = trim(substr($reste, strpos($reste, ' ')+1));
			$ass[$i] = substr($reste, 0, strpos($reste, ' '));
			
			$reste = trim(substr($reste, strpos($reste, ' ')+1));
			$points[$i] = substr($reste, 0, strpos($reste, ' '));
			
			$reste = trim(substr($reste, strpos($reste, ' ')+1));
			if($currentFarm == 1) $pun[$i] = $reste;
			if($currentFarm == 0) {
				$diff[$i] = substr($reste, 0, strpos($reste, ' '));
				
				$reste = trim(substr($reste, strpos($reste, ' ')+1));
				$pun[$i] = substr($reste, 0, strpos($reste, ' '));
				
				$reste = trim(substr($reste, strpos($reste, ' ')+1));
				$pp[$i] = substr($reste, 0, strpos($reste, ' '));
				
				$reste = trim(substr($reste, strpos($reste, ' ')+1));
				$sh[$i] = substr($reste, 0, strpos($reste, ' '));
				
				$reste = trim(substr($reste, strpos($reste, ' ')+1));
				$shots[$i] = substr($reste, 0, strpos($reste, ' '));
				
				$reste = trim(substr($reste, strpos($reste, ' ')+1));
				$shp[$i] = $reste;
			}
			$i++;
		}
		if($b == 2) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')') - $pos;
			$joueur2[$i] = trim(substr($val, 0, $pos));
			$equipes2[$i] = substr($val, $pos+1, $pos2-1);
			
			$reste = trim(substr($val, strpos($val, ')')+1));
			$gp2[$i] = substr($reste, 0, strpos($reste, ' '));
			
			$reste = trim(substr($reste, strpos($reste, ' ')+1));
			if($currentFarm == 1) $avg[$i] = $reste;
			if($currentFarm == 0) {
				$win[$i] = substr($reste, 0, strpos($reste, ' '));
				
				$reste = trim(substr($reste, strpos($reste, ' ')+1));
				$loose[$i] = substr($reste, 0,strpos($reste, ' '));
				
				$reste = trim(substr($reste, strpos($reste, ' ')+1));
				$tie[$i] = substr($reste, 0, strpos($reste, ' '));
				
				$reste = trim(substr($reste, strpos($reste, ' ')+1));
				$min[$i] = substr($reste, 0, strpos($reste, ' '));
				
				$reste = trim(substr($reste, strpos($reste, ' ')+1));
				$ga[$i] = substr($reste, 0, strpos($reste, ' '));
				
				$reste = trim(substr($reste, strpos($reste, ' ')+1));
				$so[$i] = substr($reste, 0, strpos($reste, ' '));
				
				$reste = trim(substr($reste, strpos($reste, ' ')+1));
				$avg[$i] = substr($reste, 0, strpos($reste, ' '));
				
				$reste = trim(substr($reste, strpos($reste, ' ')+1));
				$pun2[$i] = substr($reste, 0, strpos($reste, ' '));
				
				$reste = trim(substr($reste, strpos($reste, ' ')+1));
				$sh2[$i] = substr($reste, 0, strpos($reste, ' '));
				
				$reste = trim(substr($reste, strpos($reste, ' ')+1));
				$pct[$i] = substr($reste, 0, strpos($reste, ' '));
				
				$reste = trim(substr($reste, strpos($reste, ' ')+1));
				$ass2[$i] = $reste;
			}
			$i++;
		}
		if(substr_count($val, '<PRE> Player')) {
			$a++;
		}
		if(substr_count($val, '<PRE>Minimum')) {
			$b++;
			$i = 0;
			$pos = strpos($val, ' Games');
			$pos = $pos - 13;
			$games = substr($val, 13, $pos);
		}
		if(substr_count($val, 'AVG PIM Shots') || substr_count($val, 'GP  AVG')) {
			$b++;
		}
	}
	$i = 0;
	echo '<div class="tableau-top text-center">'.$leaderScoring.'</div>';
	
	echo '<thead>';
    echo '<tr>';
    echo '<th class="text-left">Name</th>';
	echo '<th>'.$leaderTeam.'</th>';
	echo '<th>'.$leaderGP.'</th>';
	echo '<th>'.$leaderGoal.'</th>';
	echo '<th>'.$leaderAssist.'</th>';
	echo '<th>'.$leaderPoints.'</th>';
	if($currentFarm == 0) echo '<th>+/-</th>';
	echo '<th>'.$leaderPIM.'</th>';
	if($currentFarm == 0) {
		echo '<th>'.$leaderPP.'</th>';
		echo '<th>'.$leaderSH.'</th>';
		echo '<th>'.$leaderShots.'</th>';
		echo '<th>'.$leaderShotsAcc.'</th>';
	}
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
	if(isset($joueur)) {
		for($i=0;$i<count($joueur);$i++) {
			echo '<tr>';
			echo '<td class="text-left">'.$joueur[$i].'</td>';
			echo '<td >'.$equipes[$i].'</td>';
			echo '<td>'.$gp[$i].'</td>';
			echo '<td>'.$goal[$i].'</td>';
			echo '<td>'.$ass[$i].'</td>';
			echo '<td>'.$points[$i].'</td>';
			if($currentFarm == 0) echo '<td>'.$diff[$i].'</td>';
			echo '<td>'.$pun[$i].'</td>';
			if($currentFarm == 0) {
				echo '<td>'.$pp[$i].'</td>';
				echo '<td>'.$sh[$i].'</td>';
				echo '<td>'.$shots[$i].'</td>';
				echo '<td>'.$shp[$i].'</td>';
			}
			echo '</tr>';
		}
	}
	echo '</tbody></table></div><br>';

	echo '<div class="tableau-top text-center">';
	   echo '<div>'.$leaderGoalies.'</div>';
	   echo '<div style="font-size:0.8rem;">'.$leaderminGames.' '.$games.' '.$leaderminGames2.'.</div>';
    echo '</div>';
	
	echo '<div class="table-responsive">';
	echo '<table id ="leadersGoalieTable" class="table table-sm table-striped table-hover text-center  table-rounded-bottom">';
    echo '<thead>'; 
    echo '<tr>';
	echo '<th class="text-left">Name</th>';
	echo '<th>'.$leaderTeam.'</th>';
	echo '<th>'.$leaderGP.'</th>';
	if($currentFarm == 0) {
		echo '<th>'.$leaderWin.'</th>';
		echo '<th>'.$leaderLost.'</th>';
		echo '<th>'.$leaderTie.'</th>';
		echo '<th>'.$leaderMin.'</th>';
		echo '<th>'.$leaderGA.'</th>';
		echo '<th>'.$leaderSO.'</th>';
	}
	echo '<th>'.$leaderAVG.'</th>';
	if($currentFarm == 0) {
		echo '<th>'.$leaderPIM.'</th>';
		echo '<th>'.$leaderShots.'</th>';
		echo '<th>'.$leaderPct.'</th>';
		echo '<th>'.$leaderAssist.'</th>';
	}
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';

	if(isset($joueur2)) {
		for($i=0;$i<count($joueur2);$i++) {

			echo '<tr>';
			echo '<td>'.$joueur2[$i].'</td>';
			echo '<td>'.$equipes2[$i].'</td>';
			echo '<td>'.$gp2[$i].'</td>';
			if($currentFarm == 0) {
				echo '<td>'.$win[$i].'</td>';
				echo '<td>'.$loose[$i].'</td>';
				echo '<td>'.$tie[$i].'</td>';
				echo '<td>'.$min[$i].'</td>';
				echo '<td>'.$ga[$i].'</td>';
				echo '<td>'.$so[$i].'</td>';
			}
			echo '<td>'.$avg[$i].'</td>';
			if($currentFarm == 0) {
				echo '<td>'.$pun2[$i].'</td>';
				echo '<td>'.$sh2[$i].'</td>';
				echo '<td>'.$pct[$i].'</td>';
				echo '<td>'.$ass2[$i].'</td>';
			}
			echo '</tr>';
		}
	}
	
	
}
else{
    echo '<tr><td>'.$allFileNotFound.' - '.$Fnm.'</td></tr>';
}
echo '</tbody></table></div>';

    if(isset($lastUpdated)){
        echo '<h6 class = "text-center">'.$allLastUpdate.' '.$lastUpdated.'</h6>';
    }

echo'</div></div></div></div></div>';
?>

<script>
$(document).ready(function() 
    { 
        $("#leadersGoalieTable").tablesorter({ 
            sortInitialOrder: 'desc'
    	}); 
        $("#leadersScTable").tablesorter({ 
            sortInitialOrder: 'desc'
    	}); 
    } 
); 

</script>


<?php include 'footer.php'; ?>