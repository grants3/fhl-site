<?php
require_once 'config.php';
include 'lang.php';

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
$linkSchedule = 'Schedule';
$rnd = 0;
$existRnd = 0;
if(isset($_GET['plf']) || isset($_POST['plf'])) {
	$matches = glob($folder.'*PLF-Round1-Schedule.html');
	$folderLeagueURL2 = '';
	$matchesDate = array_map('filemtime', $matches);
	arsort($matchesDate);
	foreach ($matchesDate as $j => $val) {
		if(substr_count($matches[$j], 'PLF')) {
			$folderLeagueURL2 = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'PLF-Round1-Schedule.html')-strrpos($matches[$j], '/')-1);
			break 1;
		}
	}
	if (file_exists($folder.$folderLeagueURL2.'PLF-Round1-Schedule.html')) {
		$Fnm = $folder.$folderLeagueURL2.'PLF-Round1-Schedule.html';
		$linkSchedule = '-Round1-Schedule';
		$rnd = 1;
		$existRnd = 1;
	}
	if (file_exists($folder.$folderLeagueURL2.'PLF-Round2-Schedule.html')) {
		$Fnm = $folder.$folderLeagueURL2.'PLF-Round2-Schedule.html';
		$linkSchedule = '-Round2-Schedule';
		$rnd = 2;
		$existRnd = 2;
	}
	if (file_exists($folder.$folderLeagueURL2.'PLF-Round3-Schedule.html')) {
		$Fnm = $folder.$folderLeagueURL2.'PLF-Round3-Schedule.html';
		$linkSchedule = '-Round3-Schedule';
		$rnd = 3;
		$existRnd = 3;
	}
	if (file_exists($folder.$folderLeagueURL2.'PLF-Round4-Schedule.html')) {
		$Fnm = $folder.$folderLeagueURL2.'PLF-Round4-Schedule.html';
		$linkSchedule = '-Round4-Schedule';
		$rnd = 4;
		$existRnd = 4;
	}
	if(isset($_GET['rnd']) || isset($_POST['rnd'])) {
		$currentRND = ( isset($_GET['rnd']) ) ? $_GET['rnd'] : $_POST['rnd'];
		$Fnm = $folder.$folderLeagueURL2.'PLF-Round'.$currentRND.'-Schedule.html';
		$linkSchedule = '-Round'.$currentRND.'-Schedule';
		$rnd = $currentRND;
	}
}
$schedTitlePlayoff = '';
if($rnd) $schedTitlePlayoff = ' - '.$scheldRound.' '.$rnd;

$CurrentHTML = $linkSchedule;
$CurrentTitle = $schedTitle;
$CurrentPage = 'Schedule';
include 'head.php';

if($checked != ''){
    include 'TeamHeader.php';
}

?>

<!--<div style="clear:both; width:555px; margin-left:auto; margin-right:auto; border: solid 1px <?php echo $couleur_contour; ?>;"-->
<!--<div class = "row" style="clear:both; width:555px; margin-left:auto; margin-right:auto;">-->
<!--<h3 class = "text-center"><?php echo $schedTitle.$schedTitlePlayoff; ?></h3>-->

<div class = "container">


	<div class="card">

		<div class="card-header" style="padding-bottom: 0px; padding-top: 2px;">
			<div class = "row d-flex align-items-center justify-content-center">
				<?php
				$teamCardLogoSrc = glob($folderTeamLogos.strtolower($currentTeam).'.*');
				if(isset($teamCardLogoSrc[0]) && $checked !='') {
					echo'		<img class="float-left card-img-top" src="'.$teamCardLogoSrc[0].'" alt="'.$currentTeam.'">';
				}?>
				<h3><?php echo $CurrentTitle; ?></h3>
			</div>
		</div>
		<div class="card-body">
		
        	<?php 
        	if($currentPLF == 1 && isset($existRnd)) {
        	    echo '<div class = "row">';
        	    echo '<div class = "col">';
        	    if($existRnd >= 4) echo '<a href="'.$CurrentPage.'.php?plf=1&rnd=4" class="lien-noir">'.$scheldRound.' 4</a>';
        	    if($existRnd >= 3) echo ' - <a href="'.$CurrentPage.'.php?plf=1&rnd=3" class="lien-noir">'.$scheldRound.' 3</a>';
        	    if($existRnd >= 2) echo ' - <a href="'.$CurrentPage.'.php?plf=1&rnd=2" class="lien-noir">'.$scheldRound.' 2</a>';
        	    if($existRnd >= 1) echo ' - <a href="'.$CurrentPage.'.php?plf=1&rnd=1" class="lien-noir">'.$scheldRound.' 1</a>';
        	    echo '</div>';
        	    echo '</div>';
        	}
        	?>

			<div class = "row">
				<div class="col-sm-12 col-md-12 col-lg-8 offset-lg-2">
				<div class = "table-responsive">
					<table class="table table-sm">

					<?php
					$a = 0;
					$c = 1;
					$i = 0;
					$scheduleWin = 0;
					$scheduleLoose = 0;
					$scheduleTie = 0;
					$scheduleGF = 0;
					$scheduleGA = 0;
					if(isset($gmequipe)) {
						for($j=0;$j<count($gmequipe);$j++) {
							$gmequipeWin[$j] = 0;
							$gmequipeLoose[$j] = 0;
							$gmequipeTie[$j] = 0;
							$gmequipeLeft[$j] = 0;
							$gmequipeGA[$j] = 0;
							$gmequipeGF[$j] = 0;
						}
						if (file_exists($Fnm)) {
							$tableau = file($Fnm);
							while(list($cle,$val) = myEach($tableau)) {
								if(substr_count($val, 'Day')){
									$status[$i] = 'Jour';
									$reste = trim(substr($val, strpos($val, 'Day')));
									$day[$i] = trim(substr($reste, strpos($reste, 'Day')+4, strpos($reste, '< ')-strpos($reste, 'Day')-4));
									$i++;
								}
								if(substr_count($val, ' at ') && !substr_count($val, '<strike>')){
									$status[$i] = 'at';
									$reste = trim(str_replace('<br>','', $val));
									$reste = trim(str_replace('<BR>','', $reste));
									$number[$i] = substr($reste, 0, strpos($reste, ' '));
									$reste = trim(substr($reste, strpos($reste, ' ')));
									$equipe1[$i] = substr($reste, 0, strpos($reste, ' at '));
									$reste = trim(substr($reste, strpos($reste, ' at ')+4));
									$equipe2[$i] = $reste;
									if($checked != '' && ($equipe1[$i] == $currentTeam || $equipe2[$i] == $currentTeam)) {
										for($j=0;$j<count($gmequipe);$j++) {
											if($gmequipe[$j] != $currentTeam && ($gmequipe[$j] == $equipe1[$i] || $gmequipe[$j] == $equipe2[$i])) {
												$gmequipeLeft[$j]++;
											}
										}
									}
									$i++;
								}
								if(substr_count($val, 'A HREF=')){
									if($a == 0) $a = $i;
									$status[$i] = 'game';
									$reste = trim(substr($val, strpos($val, '> ')+1));
									$number[$i] = substr($reste, 0, strpos($reste, ' '));
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
									if($checked != '' && ($equipe1[$i] == $currentTeam || $equipe2[$i] == $currentTeam)) {
										if($equipe1[$i] == $currentTeam) {
											if($score1[$i] < $score2[$i]) $schelduleResult[$i] = 'L';
											if($score1[$i] > $score2[$i]) $schelduleResult[$i] = 'W';
											$scheduleGF += $score1[$i];
											$scheduleGA += $score2[$i];
										}
										if($equipe2[$i] == $currentTeam) {
											if($score1[$i] < $score2[$i]) $schelduleResult[$i] = 'W';
											if($score1[$i] > $score2[$i]) $schelduleResult[$i] = 'L';
											$scheduleGF += $score2[$i];
											$scheduleGA += $score1[$i];
										}
										if($score1[$i] == $score2[$i]) {
											$schelduleResult[$i] = 'T';
											$scheduleTie++;
										}
										if($schelduleResult[$i] == 'W') {
											$scheduleWin++;
										}
										if($schelduleResult[$i] == 'L') {
											$scheduleLoose++;
										}
										$scheduleRecord[$i] = $scheduleWin.'-'.$scheduleLoose.'-'.$scheduleTie;
										$scheduleGFGA[$i] = $scheduleGF.'-'.$scheduleGA;
										for($j=0;$j<count($gmequipe);$j++) {
											if($gmequipe[$j] != $currentTeam && ($gmequipe[$j] == $equipe1[$i] || $gmequipe[$j] == $equipe2[$i])) {
												if($gmequipe[$j] == $equipe1[$i]) {
													if($score1[$i] < $score2[$i]) $gmequipeWin[$j] += 1;
													if($score1[$i] > $score2[$i]) $gmequipeLoose[$j] += 1;
													$gmequipeGA[$j] += $score1[$i];
													$gmequipeGF[$j] += $score2[$i];
												}
												if($gmequipe[$j] == $equipe2[$i]) {
													if($score1[$i] < $score2[$i]) $gmequipeLoose[$j] += 1;
													if($score1[$i] > $score2[$i]) $gmequipeWin[$j] += 1;
													$gmequipeGA[$j] += $score2[$i];
													$gmequipeGF[$j] += $score1[$i];
												}
												if($score1[$i] == $score2[$i]) $gmequipeTie[$j] += 1;
											}
										}
									}
									$i++;
								}
								if(substr_count($val, '(OT)')){
									$i--;
									$prol[$i] = 'PROL';
									$i++;
								}
								if(substr_count($val, 'TRADE DEADLINE')){
									$status[$i] = 'Trade';
									$i++;
								}
							}
						
							$a = $a - 1;
							for($i=0;$i<count($status);$i++) {
								if($a == $i){
									if($checked != '') {
										echo '<tr class="tableau-top">';
										echo '<td>'.$ScheldGameNum.'</td>';
										echo '<td>'.$ScheldVisitor.'</td>';
										echo '<td>VS</td>';
										echo '<td>'.$ScheldHome.'</td>';
										echo '<td>HS</td>';
										echo '<td style="text-align:center;">'.$schedOT.'</td>';
										echo '<td style="text-align:center;">'.$ScheldRes.'</td>';
										echo '<td style="text-align:right;">'.$ScheldRecord.'</td>';
										echo '<td style="text-align:right;">'.$ScheldGAGF.'</td>';
										echo '</tr>';
									}
									else {
										echo '<tr class="tableau-top">';
										echo '<td>'.$ScheldGameNum.'</td>';
										echo '<td>'.$ScheldVisitor.'</td>';
										echo '<td style="text-align:center;">'.$ScheldScore.'</td>';
										echo '<td>'.$ScheldHome.'</td>';
										echo '<td style="text-align:center;">'.$ScheldScore.'</td>';
										echo '<td style="text-align:center;">'.$schedOT.'</td>';
										echo '</tr>';
									}
								}
								if($status[$i] == 'Jour' && $checked == ''){
									echo '<tr class="tableau-top"><td colspan="6" style="text-align:center;">'.$schedDay.' '.$day[$i].'</td></tr>';
									$c = 1;
								}
								if($status[$i] == 'Trade'){
									$tmpColSpan = 9;
									if($checked == '') $tmpColSpan = 6;
									echo '<tr><td colspan="'.$tmpColSpan.'" style="padding-top:15px; padding-bottom:15px; text-align:center; font-weight:bold;">'.$schedTradeDeadline.'</td></tr>';
								}
								if(isset($equipe1[$i]) && ( $equipe1[$i] == $currentTeam || $equipe2[$i] == $currentTeam ) && $checked == '') $bold = 'font-weight:bold;';
								else $bold = '';
								if($status[$i] == 'game'){
									if((($equipe1[$i] == $currentTeam || $equipe2[$i] == $currentTeam) && $checked) || $checked == '') {
										if($c == 1) $c = 2;
										else $c = 1;
										echo '<tr class="hover'.$c.'">';
										$linkRnd = '';
										if($rnd != 0) {
											$linkRnd = '&rnd='.$rnd;
										}
										echo '<td '.$bold.'"><a class="lien-noir" style="display:block; width:100%;" href="games.php?num='.$number[$i].$linkRnd.'">'.$number[$i].'</a></td>';
										echo '<td '.$bold.'">'.$equipe1[$i].'</td>';
										echo '<td '.$bold.'">'.$score1[$i].'</td>';
										echo '<td '.$bold.'">'.$equipe2[$i].'</td>';
										echo '<td '.$bold.'">'.$score2[$i].'</td>';
										if(isset($prol[$i]) && $prol[$i] == 'PROL') echo '<td style="text-align:center; width:40px;'.$bold.'">'.$schedOT.'</td>';
										else echo '<td></td>';
										if($checked != '') {
											$replaceOrigin = array('W', 'L', 'T');
											$replaceBy = array($ScheldW, $ScheldL, $ScheldT);
											$schelduleResult[$i] = str_replace($replaceOrigin, $replaceBy, $schelduleResult[$i]);
											echo '<td>'.$schelduleResult[$i].'</td>';
											echo '<td>'.$scheduleRecord[$i].'</td>';
											echo '<td>'.$scheduleGFGA[$i].'</td>';
										}
										echo '</tr>';
									}
								}
								if($status[$i] == 'at'){
									if((($equipe1[$i] == $currentTeam || $equipe2[$i] == $currentTeam) && $checked) || $checked == '') {
										if($c == 1) $c = 2;
										else $c = 1;
										echo '<tr class="hover'.$c.'">';
										echo '<td style="width:40px;'.$bold.'">'.$number[$i].'</td>';
										echo '<td style="width:100px;'.$bold.'">'.$equipe1[$i].'</td>';
										echo '<td style="text-align:center; width:20px;'.$bold.'">@</td>';
										if($checked != '') echo '<td colspan="6">'.$equipe2[$i].'</td>';
										else echo '<td style="'.$bold.'" colspan="3">'.$equipe2[$i].'</td>';
										echo '</tr>';
									}
								}
							}
						}
						else { 
							echo '<tr><td>'.$allFileNotFound.' - '.$Fnm.'</td></tr>';
						}
					}
					?>
					</table>
				</div>

				<?php
				if($checked != '') {
					/* echo '<div class="titre"><span class="bold-blanc">'.$ScheldMatchups.'</span></div>'; */
					echo '<div><span>'.$ScheldMatchups.'</span></div>';
					echo '<div class="table-responsive">';
					echo '<table class="table table-sm">';
					echo '<tr class="tableau-top">';
					echo '<td>'.$ScheldTeam.'</td>';
					echo '<td>'.$ScheldGP.'</td>';
					echo '<td>'.$ScheldW.'</td>';
					echo '<td>'.$ScheldL.'</td>';
					echo '<td>'.$ScheldT.'</td>';
					echo '<td>'.$ScheldLeft.'</td>';
					echo '<td>'.$ScheldGAGF.'</td>';
					echo '</tr>';
					$c = 1;
					for($j=0;$j<count($gmequipe);$j++) {
						if($gmequipe[$j] != $currentTeam) {
							if($c == 1) $c = 2;
							else $c = 1;
							$GP = $gmequipeWin[$j]+$gmequipeLoose[$j]+$gmequipeTie[$j];
							echo '<tr class="hover'.$c.'">';
							echo '<td>'.$gmequipe[$j].'</td>';
							echo '<td>'.$GP.'</td>';
							echo '<td>'.$gmequipeWin[$j].'</td>';
							echo '<td>'.$gmequipeLoose[$j].'</td>';
							echo '<td>'.$gmequipeTie[$j].'</td>';
							echo '<td>'.$gmequipeLeft[$j].'</td>';
							/* echo '<td>'.$gmequipeGA[$j].'-'.$gmequipeGF[$j].'</td>'; */
							echo '<td>'.$gmequipeGF[$j].'-'.$gmequipeGA[$j].'</td>';
							echo '</tr>';
						}
					}
					echo '</table>';
					echo '</div>';
				}
				else 
				?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include 'footer.php'; ?>