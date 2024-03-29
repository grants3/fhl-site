<style>

#tree-nav > a.active{
    font-weight: 1000;
	font-size: large;
}

</style>

<?php
require_once __DIR__.'/../config.php';
include_once FS_ROOT.'lang.php';
include_once FS_ROOT.'fileUtils.php';

include FS_ROOT.'assets.php';

//$Fnm = getCurrentPlayoffLeagueFile('-Round1-Schedule.html');
$existRnd = getPlayoffRound();

//if(!$existRnd) exit('<h5>The Playoffs have not started</h5>');

?>


<style>
nav a,
nav a:hover,
nav a:focus {
    color: var(--color-primary-2);
}

</style>


<?php
echo '<div class="fhlElement">';

if($existRnd){


echo '<div class = "row">';
echo '<div class = "col">';

echo '<nav id ="tree-nav" class="nav nav-justified-center justify-content-center">';
if($existRnd >= 4)echo'<a class="nav-item nav-link" href="'.BASE_URL.'Schedule.php?rnd=4">'.$StandingsTreeFinals.'</a>';
if($existRnd >= 3)echo'<a class="nav-item nav-link" href="'.BASE_URL.'Schedule.php?rnd=3">'.$scheldRound.' 3</a>';
if($existRnd >= 2)echo'<a class="nav-item nav-link" href="'.BASE_URL.'Schedule.php?rnd=2">'.$scheldRound.' 2</a>';
if($existRnd >= 1)echo'<a class="nav-item nav-link" href="'.BASE_URL.'Schedule.php?rnd=1">'.$scheldRound.' 1</a>';
echo '</nav>';

echo '</div>';
echo '</div>';

$fileFound = false;
$k = 0;
$j = $existRnd;
//for($j=1;$j<=$existRnd;$j++) {
	//echo '<td>';
	$TeamNumber = 100;
	$currentTeamCpt = 0;
	$equipe1 = '';
	//$Fnm = $folder.$folderLeagueURL2.'PLF-Round'.$j.'-Schedule.html';
	$Fnm = getCurrentPlayoffLeagueFile('-Round'.$j.'-Schedule');
	if(file_exists($Fnm)) {
	    $fileFound = true;
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
				echo '<table class="table table-sm table-striped text-center" >';
				echo '<thead>';
				echo '<tr class="tableau-top">';
				echo '<td style="width:20%"></td>';
				//for($w=1;$w<=$m;$w++) {
				for($w=1;$w<=8;$w++) {
					if(isset($day[$w]) && isset($score1[$w])) echo '<td style="width:5%" class = "col-xs-1"><a class="lien-blanc" href="'.BASE_URL.'games.php?num='.$day[$w].'&rnd='.$j.'" >'.$w.'</a></td>';
					//else echo '<td>'.$w.'</td>';
					elseif($w == 8) echo '<th style="width:5%"><a class="lien-blanc" href="'.BASE_URL.'Schedule.php">Series</a></th>';
					else echo '<th style="width:5%"></th>';
				}
				//echo '<td></td>';
				echo '</tr>';
				echo '</thead>';
				echo '<tbody>';

				echo '<tr class="hover2"><td class="text-left">'.$equipe2.'</td>';
				for($w=1;$w<=$m;$w++) {
					if(!isset($score2[$w])) $score2[$w] = '';
					else if($score2[$w] > $score1[$w]) $tmpTot2++;
					echo '<td>'.$score2[$w].'</td>';
				}
				echo '<td style="font-weight:bold;">'.$tmpTot2.'</td>';
				echo '</tr>';

				echo '<tr class="hover1"><td class="text-left">'.$equipe1.'</td>';
				for($w=1;$w<=$m;$w++) {
					if(!isset($score1[$w])) $score1[$w] = '';
					else if($score2[$w] < $score1[$w]) $tmpTot1++;
					echo '<td>'.$score1[$w].'</td>';
				}
				echo '<td style="font-weight:bold;">'.$tmpTot1.'</td>';
				echo '</tr>';
				echo '</tbody>';
				echo '</table>';
			}
			else echo "Errors!";
		}
	}
	else { 
		//echo '<tr><td>'.$allFileNotFound.' - '.$Fnm.'</td></tr>';
	    if(DEBUG_MODE)  echo $allFileNotFound;
	   
	}
	//echo '</td>';
//}
} else{
	    echo '<div class="card"><div class="card-body"><h5>The Playoffs have not started</h5></div></div>';
}
	 
?>
</div>
<script>

<?php if($fileFound){?>
$(document).ready(function() {

	$('a', $('#tree-nav')).each(function () {

		var href = $(this).attr('href');
		if(typeof href !== "undefined"){
			if(href.indexOf("rnd=<?php echo $existRnd;?>") > -1){
				$(this).addClass('active');
			}
		}

	});

});
<?php }?>

</script>
