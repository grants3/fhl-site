<?php
require_once 'config.php';
include 'lang.php';

$CurrentPage = 'Schedule2';

include 'head.php';

//echo 'Playoffs?: '. isPlayoffs($folder, $playoffMode);

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

$baseFolder = '';
$seasonId = '';
if(isset($_GET['seasonId']) || isset($_POST['seasonId'])) {
    $seasonId = ( isset($_GET['seasonId']) ) ? $_GET['seasonId'] : $_POST['seasonId'];
}

if(trim($seasonId) == false){
    $baseFolder = $folder;
}else{
    $baseFolder = str_replace("#",$seasonId,$folderCarrerStats);
}

$Fnm = '';
$linkSchedule = 'Schedule';
$rnd = 0;
$existRnd = 0;
$schedTitlePlayoff = '';
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
    
    if($rnd) $schedTitlePlayoff = $scheldRound.' '.$rnd;
}else{
    $Fnm = getLeagueFile($baseFolder, $playoff, 'Schedule.html', 'Schedule');
}



$CurrentHTML = $linkSchedule;
$CurrentTitle = $schedTitle;

if($currentPLF){
    //$CurrentTitle = 'Playoff '.$CurrentTitle.' '.$schedTitlePlayoff;
    $CurrentTitle = $schedTitlePlayoff;
}

?>

<div class = "container">


	<div class="card">
				
		<?php include 'SectionHeader.php';?>
		<div class="card-body">
		
        	<?php 
        	if($currentPLF == 1 && isset($existRnd)) {
        	    echo '<div class = "row">';
        	    echo '<div class = "col">';
        	    
        	    echo '<nav id ="header-nav" class="nav justify-content-center">';
        	    if($existRnd >= 4)echo'<a class="nav-item nav-link" href="'.$CurrentPage.'.php?plf=1&rnd=4">Cup Finals</a>';
        	    if($existRnd >= 3)echo'<a class="nav-item nav-link" href="'.$CurrentPage.'.php?plf=1&rnd=3">'.$scheldRound.' 3</a>';
        	    if($existRnd >= 2)echo'<a class="nav-item nav-link" href="'.$CurrentPage.'.php?plf=1&rnd=2">'.$scheldRound.' 2</a>';
        	    if($existRnd >= 1)echo'<a class="nav-item nav-link" href="'.$CurrentPage.'.php?plf=1&rnd=1">'.$scheldRound.' 1</a>';
        	    echo '</nav>';
        	    
        	    echo '</div>';
        	    echo '</div>';
        	}
        	?>

			<div class = "row">
				<div class="col-sm-12 col-md-6 offset-md-3">
				<div class = "table-responsive">
					<table class="table table-sm table-striped table-rounded">

					<?php
					$a = 0;
					$i = 0;

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
					            echo '<th style="width:5%">'.$ScheldGameNum.'</th>';
					            echo '<th style="width:10%">'.$ScheldVisitor.'</th>';
					            echo '<th style="width:5%"</th>';
					            echo '<th style="width:10%">'.$ScheldHome.'</th>';
					            echo '<th class="text-center" style="width:5%">'.$ScheldScore.'</th>';
					            echo '<th class="text-center">'.$schedOT.'</th>';
					            echo '</tr>';
					            echo '</thead>';
					            echo '<tbody>';
					        }
					        if($status[$i] == 'Jour'){
					            echo '<tr class="tableau-top text-center"><td colspan="6">'.$schedDay.' '.$day[$i].'</td></tr>';
					            $c = 1;
					        }
					        if($status[$i] == 'Trade'){
					            $tmpColSpan = 9;
					            $tmpColSpan = 6;
					            echo '<tr><td colspan="'.$tmpColSpan.'" style="padding-top:15px; padding-bottom:15px; text-align:center; font-weight:bold;">'.$schedTradeDeadline.'</td></tr>';
					        }

					        if($status[$i] == 'game'){
					            echo '<tr>';
					            $linkRnd = '';
					            if($rnd != 0) {
					                $linkRnd = '&rnd='.$rnd;
					            }
					            echo '<td><a class="lien-noir" style="display:block; width:100%;" href="games.php?num='.$number[$i].$linkRnd.'">'.$number[$i].'</a></td>';
					            echo '<td class="text-left">'.$equipe1[$i].'</td>';
					            echo '<td class="text-center">@</td>';
					            //echo '<td>'.$score1[$i].'</td>';
					            echo '<td class="text-left">'.$equipe2[$i].'</td>';
					            //echo '<td>'.$score2[$i].'</td>';
					            echo '<td class="text-center">'.$score1[$i].'-'.$score2[$i].'</td>';
					            if(isset($prol[$i]) && $prol[$i] == 'PROL') echo '<td style="text-align:center; width:40px;">'.$schedOT.'</td>';
					            else echo '<td></td>';
					            echo '</tr>';
					        }
					        if($status[$i] == 'at'){
					            echo '<tr>';
					            echo '<td style="width:40px;">'.$number[$i].'</td>';
					            echo '<td style="width:100px;">'.$equipe1[$i].'</td>';
					            echo '<td class="text-center" style="width:20px;">@</td>';
					            echo '<td colspan="3">'.$equipe2[$i].'</td>';
					            echo '</tr>';
					        }
					    }
					}
					else {
					    echo '<tr><td>'.$allFileNotFound.' - '.$Fnm.'</td></tr>';
					}
					
					?>
					</tbody>
					</table>
				</div>

				</div>
			</div>
		</div>
	</div>
</div>

<?php include 'footer.php'; ?>
