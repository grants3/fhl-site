<?php
require_once 'config.php';
include_once 'lang.php';
include_once 'fileUtils.php';
// $matches = glob($folder.'*Schedule.html');
// $folderLeagueURL = '';
// $matchesDate = array_map('filemtime', $matches);
// arsort($matchesDate);
// foreach ($matchesDate as $j => $val) {
// 	if(!substr_count($matches[$j], 'PLF')) {
// 		$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'Schedule')-strrpos($matches[$j], '/')-1);
// 		break 1;
// 	}
// }
// $Fnm = $folder.$folderLeagueURL.'Schedule.html';
$Fnm = getLeagueFile('Schedule');
$linkSchedule = 'TeamSchedule';
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

$CurrentHTML = 'TeamSchedule.php';
$CurrentTitle = $schedTitle;
$CurrentPage = 'TeamSchedule';
include 'head.php';
include 'TeamHeader.php';

?>

<style>
.thumbnail {
    position: relative;
}

.caption {
    position: absolute;
    top: 45%;
    left: 0;
    width: 100%;
}
</style>

<div class = "container px-0">


	<div class="card">

		<div class="card-header p-1">

              <?php include 'TeamCardHeader.php' ?>
			
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
				<div class="tableau-top">Team Schedule</div>
				<div class = "table-responsive">
					<table class="table table-sm table-striped table-rounded-bottom">
					

					<?php
					
					$a = 0;
					$c = 1;
					$i = 0;
					$scheduleWin = 0;
					$scheduleLoose = 0;
					$scheduleTie = 0;
					$scheduleGF = 0;
					$scheduleGA = 0;
					
					$currentDay = 0;
					$dayArray = array();

					if(isset($teamList)) {
						for($j=0;$j<count($teamList);$j++) {
							$teamListWin[$j] = 0;
							$teamListLoose[$j] = 0;
							$teamListTie[$j] = 0;
							$teamListLeft[$j] = 0;
							$teamListGA[$j] = 0;
							$teamListGF[$j] = 0;
							
						}
						if (file_exists($Fnm)) {
							$tableau = file($Fnm);
							while(list($cle,$val) = myEach($tableau)) {
								if(substr_count($val, 'Day')){
									$status[$i] = 'Jour';
									$reste = trim(substr($val, strpos($val, 'Day')));
									$day[$i] = trim(substr($reste, strpos($reste, 'Day')+4, strpos($reste, '< ')-strpos($reste, 'Day')-4));

									$currentDay = $day[$i];

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
									if($equipe1[$i] == $currentTeam || $equipe2[$i] == $currentTeam) {
									    $dayArray[$i] = $currentDay;
									    
										for($j=0;$j<count($teamList);$j++) {
											if($teamList[$j] != $currentTeam && ($teamList[$j] == $equipe1[$i] || $teamList[$j] == $equipe2[$i])) {
												$teamListLeft[$j]++;
											}
										}
										
										
										
										//echo $dayArray[$i].' ';
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
									
									//shootout support.
									$isShootout = false;
									$isOt = false;
									if(substr_count($score2[$i], 'SO)')){
									    $isShootout = true;
									}else if(substr_count($score2[$i], '(OT)')){
									    $isOt = true;
									}
									
									$score2[$i] = explode(' ',trim($score2[$i]))[0]; //shootout support

									if($equipe1[$i] == $currentTeam || $equipe2[$i] == $currentTeam) {
									    $dayArray[$i] = $currentDay;
									    //echo $dayArray[$i].' ';

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
											
											if($isShootout){
											    $scheduleTie++;
											}
										}

										$scheduleRecord[$i] = $scheduleWin.'-'.$scheduleLoose.'-'.$scheduleTie;
										$scheduleGFGA[$i] = $scheduleGF.'-'.$scheduleGA;
										for($j=0;$j<count($teamList);$j++) {
											if($teamList[$j] != $currentTeam && ($teamList[$j] == $equipe1[$i] || $teamList[$j] == $equipe2[$i])) {
												if($teamList[$j] == $equipe1[$i]) {
													if($score1[$i] < $score2[$i]) $teamListWin[$j] += 1;
													if($score1[$i] > $score2[$i]) $teamListLoose[$j] += 1;
													$teamListGA[$j] += $score1[$i];
													$teamListGF[$j] += $score2[$i];
												}
												if($teamList[$j] == $equipe2[$i]) {
													if($score1[$i] < $score2[$i]) $teamListLoose[$j] += 1;
													if($score1[$i] > $score2[$i]) $teamListWin[$j] += 1;
													$teamListGA[$j] += $score2[$i];
													$teamListGF[$j] += $score1[$i];
												}
												if($score1[$i] == $score2[$i]) $teamListTie[$j] += 1;
											}
										}
									}
									$i++;
								}
								if(substr_count($val, 'SO)')){
								    $i--;
								    $prol[$i] = 'SO';
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
								    echo '<thead>';
								    echo '<tr>';
								    //echo '<td>'.$ScheldGameNum.'</td>';
								    echo '<th class="text-center" style="width:5%">Day</th>';
								    echo '<th class="text-center" style="width:10%">'.$ScheldVisitor.'</th>';
								    echo '<th class="text-center" style="width:5%"></td>';
								    echo '<th class="text-center" style="width:10%">'.$ScheldHome.'</th>';
								    echo '<th class="text-center" style="width:10%">Score</th>';
								    echo '<th class="text-center" style="width:6%">'.$schedOT.'</th>';
								    echo '<th class="text-center" style="width:10%">'.$ScheldRes.'</th>';
								    echo '<th class="text-center" style="width:10%">'.$ScheldRecord.'</th>';
								    echo '<th class="text-center" style="width:10%">'.$ScheldGAGF.'</th>';
								    echo '</tr>';
								    echo '</thead>';
								    echo '<tbody>';
								}

								if($status[$i] == 'Trade'){
									$tmpColSpan = 9;
									echo '<tr class="tableau-top text-center"><td class="py-3" colspan="'.$tmpColSpan.'">'.$schedTradeDeadline.'</td></tr>';
								}
								if($status[$i] == 'game'){
								    if($equipe1[$i] == $currentTeam || $equipe2[$i] == $currentTeam) {
										if($c == 1) $c = 2;
										else $c = 1;
										echo '<tr class="hover'.$c.'">';
										$linkRnd = '';
										if($rnd != 0) {
											$linkRnd = '&rnd='.$rnd;
										}
										
										echo '<td class="text-center"><a href="games.php?num='.$number[$i].$linkRnd.'">'.$dayArray[$i].'</a></td>';
										echo '<td class="text-center">'.$equipe1[$i].'</td>';
										echo '<td class="text-center">@</td>';
										echo '<td class="text-center">'.$equipe2[$i].'</td>';
										echo '<td class="text-center">'.$score1[$i].'-'.$score2[$i].'</td>';
										if(isset($prol[$i]) && $prol[$i] == 'PROL') echo '<td class="text-center">'.$schedOT.'</td>';
										else if(isset($prol[$i]) && $prol[$i] == 'SO') echo '<td class="text-center">SO</td>';
										else echo '<td></td>';
										$replaceOrigin = array('W', 'L', 'T');
										$replaceBy = array($ScheldW, $ScheldL, $ScheldT);
										$schelduleResult[$i] = str_replace($replaceOrigin, $replaceBy, $schelduleResult[$i]);
										echo '<td class="text-center">'.$schelduleResult[$i].'</td>';
										echo '<td class="text-center">'.$scheduleRecord[$i].'</td>';
										echo '<td class="text-center">'.$scheduleGFGA[$i].'</td>';
										echo '</tr>';
									}
								}
								if($status[$i] == 'at'){
								    if($equipe1[$i] == $currentTeam || $equipe2[$i] == $currentTeam) {
										if($c == 1) $c = 2;
										else $c = 1;
										echo '<tr>';
										echo '<td class="text-center">'.$dayArray[$i].'</td>';
										echo '<td class="text-center">'.$equipe1[$i].'</td>';
										echo '<td class="text-center">@</td>';
										echo '<td class="text-center">'.$equipe2[$i].'</td>';
										echo '<td colspan="5"></td>';
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
					</tbody>
					</table>
				</div>

				<?php
				/* echo '<div class="titre"><span class="bold-blanc">'.$ScheldMatchups.'</span></div>'; */
				//echo '<div><span>'.$ScheldMatchups.'</span></div>';
				echo '<div class="tableau-top">'.$ScheldMatchups.'</div>';
				echo '<div class="table-responsive">';
				echo '<table class="table table-sm table-striped table-rounded-bottom">';
				echo '<thead>';
				echo '<tr>';
				echo '<th>'.$ScheldTeam.'</th>';
				echo '<th class="text-center">'.$ScheldGP.'</th>';
				echo '<th class="text-center">'.$ScheldW.'</th>';
				echo '<th class="text-center">'.$ScheldL.'</th>';
				echo '<th class="text-center">'.$ScheldT.'</th>';
				echo '<th class="text-center">'.$ScheldLeft.'</th>';
				echo '<th class="text-center">'.$ScheldGAGF.'</th>';
				echo '</tr>';
				echo '</thead>';
				$c = 1;
				for($j=0;$j<count($teamList);$j++) {
				    if($teamList[$j] != $currentTeam) {
				        if($c == 1) $c = 2;
				        else $c = 1;

				        $GP = $teamListWin[$j]+$teamListLoose[$j]+$teamListTie[$j];
				        if($GP == 0 && $teamListLeft[$j] == 0) continue; //skip team if not scheduled.
				        
				        echo '<tr>';
				        echo '<td>'.$teamList[$j].'</td>';
				        echo '<td class="text-center">'.$GP.'</td>';
				        echo '<td class="text-center">'.$teamListWin[$j].'</td>';
				        echo '<td class="text-center">'.$teamListLoose[$j].'</td>';
				        echo '<td class="text-center">'.$teamListTie[$j].'</td>';
				        echo '<td class="text-center"d>'.$teamListLeft[$j].'</td>';
				        /* echo '<td>'.$teamListGA[$j].'-'.$teamListGF[$j].'</td>'; */
				        echo '<td class="text-center">'.$teamListGF[$j].'-'.$teamListGA[$j].'</td>';
				        echo '</tr>';
				    }
				}
				echo '</tbody>';
				echo '</table>';
				echo '</div>';
				?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include 'footer.php'; ?>
