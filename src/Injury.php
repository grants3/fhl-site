<?php
require_once 'config.php';
include 'lang.php';
$CurrentHTML = 'Injury.php';
$CurrentTitle = $injuryTitle;
$CurrentPage = 'Injury';
include 'head.php';
?>

<div class = "container px-0">
<div class="card">
<?php include 'SectionHeader.php' ?>
<div class ="card-body p-1">




<?php
$Fnm= getLeagueFile('Injury');
$OrigHTML = $Fnm;

$b = 0;
$c = 1;
$d = 0;
$lastUpdated = '';
if(file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = myEach($tableau)) {
		$val = encodeToUtf8($val);
		if(substr_count($val, '<P>(As of')){
			$pos = strpos($val, ')');
			$pos = $pos - 10;
			$val = substr($val, 10, $pos);
			$lastUpdated = $val;
			
			echo '<div class="row">';
			echo '<div class="col-sm-12 col-md-6 offset-md-3">';
			echo '<table class="table table-sm table-striped table-rounded"">';
			echo '<tbody>';
		}
		if(substr_count($val, 'NAME=')){
			$pos = strpos($val, '</A>');
			$pos = $pos - 23;
			$equipe = substr($val, 23, $pos);
		}

		if(substr_count($val, '<BR><BR><BR><BR>') || substr_count($val, 'suspended')) {
			//echo '<tr class="titre"><td class="text-blanc bold-blanc">'.$equipe.'</td></tr>';
			echo '<tr class="titre"><td><h5>'.$equipe.'</h5></td></tr>';
			$b = 0;
			$cpt2 = strlen($val); // Longeur de la variable
			$tmpCpt = substr_count(substr($val, 0, -12), '<BR>') - 1;
			$cpt2 = $cpt2 - (4*$tmpCpt);
			$val = substr($val, 0, $cpt2); // Les <BR> de trop sont retirés
			$cpt3 = substr_count($val, '<BR>'); // Compte le nombre de <BR> restant
			$c = 1;
			$d = 1;
			while($cpt3 != $b) {
				$pos = strpos($val, '<'); // ou est le premier <BR>
				$val2 = substr($val, 0, $pos);
				if(substr_count($val2, 'sidelined')) {
					$aremplacer = array('sidelined', 'weeks', 'months', 'indefinitely', 'day-to-day', '(Injured)');
					$remplace = array($injurySidelined, $injuryWeeks, $injuryMonths, $injuryIndefinitely, $injuryDaytoday, $injuryInjured);
					$val2 = str_replace($aremplacer, $remplace, $val2);
					if($c == 1) $c = 2;
					else $c = 1;
					echo '<tr class="hover'.$c.'"><td>'.$val2.'</td></tr>';
				}
				if(substr_count($val2, 'suspended')) {
						$aremplacer = array('suspended', 'games');
						$remplace = array($injurySuspended, $injuryGames);
						$val2 = str_replace($aremplacer, $remplace, $val2);
						if($c == 1) $c = 2;
						else $c = 1;
						echo '<tr class="hover'.$c.'"><td>'.$val2.'</td></tr>';
				}
				$b++;
				$pos = $pos + 4;
				$cpt = strlen($val);
				$cpt = $cpt - $pos;
				$val = substr($val, $pos, $cpt);
			}
		}
	}
}
else echo '<tr><td>'.$allFileNotFound.' - '.$Fnm.'</td></tr>';
if(!$d)echo '<tr><td>'.$injuryNoInjury.'</td></tr>';
echo '</tbody></table></div></div>';
echo '<h5>'.$allLastUpdate.' '.$lastUpdated.'</h5>';
?>

</div></div></div></div></div>

<?php include 'footer.php'; ?>
