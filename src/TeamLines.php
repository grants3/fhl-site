<?php
require_once 'config.php';
include 'lang.php';
$CurrentHTML = 'TeamLines.php';
$CurrentTitle = $linesTitle;
$CurrentPage = 'TeamLines';
include 'head.php';
include 'TeamHeader.php';
?>

<div class="container px-0">

<?php

//$Fnm = getLeagueFile($folder, $playoff, 'Lines.html', 'Lines');
$Fnm = getCurrentLeagueFile('Lines');

$a = 0;
$b = 0;
$c = 1;
$d = 1;
$i = 0;
$z = 0;
$y = 0;
$lastUpdated = '';
if(file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = myEach($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, '<P>(As of')){
			$pos = strpos($val, ')');
			$pos = $pos - 10;
			$val = substr($val, 10, $pos);
			$lastUpdated = $val;

			echo '<div class="card">';
			echo '<div class="card-header p-1" >';

			    include 'TeamCardHeader.php';
			
			echo' </div>';
			echo '<div class="card-body">';

			//echo '<h5 class = "text-center">'.$allLastUpdate.' '.$val.'</h5>';	
			
			echo '<div class = "row">';
			echo '<div class="col-sm-12 col-md-8 col-lg-8 offset-md-2 offset-lg-2 text-center">';
			//echo '<table class="table table-sm table-striped">';

		}
		if(substr_count($val, 'A NAME=') && $b) {
			$d = 0;
		}
		if(substr_count($val, 'A NAME='.$currentTeam) && $d) {
			$pos = strpos($val, '</A>');
			$pos = $pos - 23;
			$equipe = substr($val, 23, $pos);
			//echo '<tr class="titre"><td colspan="4" class="text-blanc bold-blanc">'.$equipe.'</td></tr>';
			$b = 1;
		}
		if($a == 8 && $b && $d) {
			if(substr_count($val, '</PRE>'))$a = 0;
			else {
				if($y == 0) {
				    echo '</tbody>';
				    echo '</table>';
				    echo '<div class="tableau-top text-center">'.$linesScratches.'</div>';
				    echo '<table class="table table-sm table-striped table-rounded-bottom">';
				    echo '<thead>';
					
					$y++;
				}
				if(substr_count($val, 'None')) echo '<tr><td colspan="4" style="text-align:center;">'.$linesNoPlayer.'</td></tr>';
				else {
					if($y == 1) {
						echo '<tr class="tableau-top"><th colspan="2">'.$linesPlayers.'</th><th colspan="2">'.$linesCondition.'</th></tr>';
						echo '</thead>';
						echo '<tbody>';
						$y++;
					}
					$pos = strpos($val, '(');
					$pos2 = $pos - 4;
					$goal = substr($val, 4, $pos2);
					$pos3 = strpos($val, ')');
					$pos++;
					$pos3 = $pos3 - $pos;
					$goal2 = substr($val, $pos, $pos3);
					$aremplacer = array('Injured', 'Suspended', 'Healthy');
					$remplace = array($linesInjured, $linesSuspended, $linesHealthy);
					$goal2 = str_replace($aremplacer, $remplace, $goal2);
					if($c == 1) $c = 2;
					else $c = 1;
					echo '<tr><td colspan="2">'.$goal.'</td><td colspan="2">'.$goal2.'</td></tr>';
				}
			}
		}
		if(substr_count($val, 'SCRATCHES') && $b && $d) {
			$a = 8;
			$z = 0;
			$c = 1;
		}
		if($a == 7 && $b && $d) {
			$goal = substr($val, 4, 22);
			echo '<tr><td colspan="4" class="text-center">'.$goal.'</td></tr>';
		}
		if(substr_count($val, 'STARTING') && $b && $d) {
		    echo '</tbody>';
		    echo '</table>';
		    echo '<div class="tableau-top text-center">'.$linesStartingGoalie.'</div>';
		    echo '<table class="table table-sm table-striped table-rounded-bottom">';
		    echo '<thead>';
			echo '</thead>';
			echo '<tbody>';
			$a = 7;
			$z = 0;
		}
		if(substr_count($val, 'DESIGNATED EXTRA SKATER') && $b && $d) {
            //PROPERLY IMPLEMENT SO SUPPORT
            //WILL JUST SKIP FOR NOW
		    $a = 5;
		    $z = 0;
		}
		if($a == 3 && $b && $d) {
			$c2 = substr($val, 4, 22);
			$g2 = substr($val, 26, 22);
			$d2 = substr($val, 48, 22);
			$def3 = substr($val, 70, 22);
			if($z == 0) {
				$def4 = substr($val, 92, 22);
			}
			$a++;
			if($z == 1)$a = 6;
		}
		if($a == 6 && $b && $d) {
			echo '
			<tr>
			<td>C</td>
			<td>'.$c1.'</td>
			<td>C</td>
			<td>'.$c2.'</td>
			</tr>
			<tr>
			<td>'.$linesWings.'</td>
			<td>'.$g1.'</td>
			<td>'.$linesWings.'</td>
			<td>'.$g2.'</td>
			</tr>
			<tr>
			<td>D</td>
			<td>'.$d1.'</td>
			<td>D</td>
			<td>'.$d2.'</td>
			</tr>
			<tr>
			<td>D</td>
			<td>'.$def1.'</td>
			<td>D</td>
			<td>'.$def3.'</td>
			</tr>';
			$a = 1;
		}
		if($a == 4 && $b && $d) {
			if($i == 1) {
				echo '<tr class="tableau-top">
				<td>POS</td>
				<td>'.$linesL3.'</td>
				<td>POS</td>
				<td>'.$linesL4.'</td>
				</tr>';
			}
			echo '
			<tr>
			<td>C</td>
			<td>'.$c1.'</td>
			<td>C</td>
			<td>'.$c2.'</td>
			</tr>
			<tr>
			<td>'.$linesLW.'</td>
			<td>'.$g1.'</td>
			<td>'.$linesLW.'</td>
			<td>'.$g2.'</td>
			</tr>
			<tr>
			<td>'.$linesRW.'</td>
			<td>'.$d1.'</td>
			<td>'.$linesRW.'</td>
			<td>'.$d2.'</td>
			</tr>
			<tr>
			<td>D</td>
			<td>'.$def1.'</td>
			<td>D</td>
			<td>'.$def3.'</td>
			</tr>
			<tr>
			<td>D</td>
			<td>'.$def2.'</td>
			<td>D</td>
			<td>'.$def4.'</td>
			</tr>';
			$a = 1;
			$i = 1;
		}
		if($a == 2 && $b && $d) {
			$c1 = substr($val, 4, 22);
			$g1 = substr($val, 26, 22);
			$d1 = substr($val, 48, 22);
			$def1 = substr($val, 70, 22);
			if($z == 0) {
				$def2 = substr($val, 92, 22);
			}
			$a++;
		}
		if($a == 1 && $b && $d) {
			$a++;
		}
		if(substr_count($val, 'POWER') && $b && $d) {
		    echo '</tbody>';
		    echo '</table>';
		    echo '<div class="tableau-top text-center">'.$linesPP.'</div>';
		    echo '<table class="table table-sm table-striped table-rounded-bottom">';
		    echo '<thead>';
			echo '<tr class="tableau-top">
			<th>POS</th>
			<th>'.$linesL1.'</th>
			<th>POS</th>
			<th>'.$linesL2.'</th>
			</tr>
			';
			echo '</thead>';
			echo '<tbody>';
			$a = 1;
			$i = 0;
		}
		if(substr_count($val, '<PRE>') && $b && $d) {
		    echo '<div class="tableau-top text-center">'.$linesEvenStrenght.'</div>';
		    echo '<table class="table table-sm table-striped table-rounded-bottom">';
		    echo '<thead>';
		    echo '
			<tr class="tableau-top">
			<th>POS</th>
			<th>'.$linesL1.'</th>
			<th>POS</th>
			<th>'.$linesL2.'</th>
			</tr>
			';
		    echo '</thead>';
		    echo '<tbody>';
			$a = 1;
		}
		if(substr_count($val, 'PENALTY') && $b && $d) {
		    echo '</tbody>';
		    echo '</table>';
		    echo '<div class="tableau-top text-center">'.$linesPK.'</div>';
		    echo '<table class="table table-sm table-striped table-rounded-bottom">';
		    echo '<thead>';
		    echo '
			<tr class="tableau-top">
			<th>POS</th>
			<th>'.$linesL1.'</th>
			<th>POS</th>
			<th>'.$linesL2.'</th>
			</tr>
			';
		    echo '</thead>';
		    echo '<tbody>';
			$a = 1;
			$i = 0;
			$z = 1;
		}
		
		if(substr_count($val, 'DESIGNATED EXTRA SKATER') && $b && $d) {
		
		}
		
		if(substr_count($val, 'TOP 3 SHOOTOUT SHOOTERS') && $b && $d) {
		    
		}
		
	}
}
else echo '<tr><td>'.$allFileNotFound.' - '.$Fnm.'</td></tr>';
echo '</tbody></table>';
echo '<h5 class = "text-center">'.$allLastUpdate.' '.$lastUpdated.'</h5>';	
echo '</div></div></div></div></div>';
?>

<?php include 'footer.php'; ?>
