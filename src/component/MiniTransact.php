<?php
$currentTeam = '';
//session_start();
if(isset($_SESSION["team"])) $currentTeam = $_SESSION["team"];
ob_start();
if(isset($_COOKIE['team'])) $currentTeam = $_COOKIE['team'];
ob_end_flush();

require_once 'config.php';
include 'lang.php';
?>

<div style="width:555px; margin-left:auto; margin-right:auto; border:solid 1px<?php echo $couleur_contour; ?>">
<div class="titre"><span class="bold-blanc"><?php echo $transactTitle; ?></span></div>
<table class="tableau">

<?php
include 'phpGetAbbr.php'; // Output $TSabbr

if(!isset($playoff)) $playoff = '';
if($playoff == 1) $playoff = 'PLF';
$matches = glob($folder.'*'.$playoff.'Transact.html');
$folderLeagueURL = '';
$matchesDate = array_map('filemtime', $matches);
arsort($matchesDate);
foreach ($matchesDate as $j => $val) {
	if((!substr_count($matches[$j], 'PLF') && $playoff == '') || (substr_count($matches[$j], 'PLF') && $playoff == 'PLF')) {
		$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'Transact')-strrpos($matches[$j], '/')-1);
		break 1;
	}
}
$Fnm = $folder.$folderLeagueURL.'Transact.html';
$b = 0;
$c = 1;
$d = 0;
if(file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = each($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, '<BR><BR>') && $d < 10){
			if($d == 0) {
				echo '<tr class="tableau-top">';
				echo '<td>'.$transactPlayers.'</td>';
				echo '<td>'.$transactTeam.'</td>';
				echo '<td>'.$transactStatus.'</td>';
				echo '</tr>';
			}
			$reste = substr($val, 0, strpos($val, '<BR>'));
			
			$transPlayer = '';
			$transEquipe = '';
			$transStatus = '';
			
			// suffers injury
			if(substr_count($reste, '(') && substr_count($reste, ' suffers ')) {
				$transPlayer = substr($reste, 0, strpos($reste, '(')-1);
				$reste = trim(substr($reste, strpos($reste, '(')+1));
				$transEquipe = substr($reste, 0, strpos($reste, ')'));
				$reste = trim(substr($reste, strpos($reste, ')')+1));
				$transStatus = ucfirst($reste);
			}
			// returns from injury
			if(substr_count($reste, '(') && substr_count($reste, 'returns from injury')) {
				$transPlayer = substr($reste, 0, strpos($reste, '(')-1);
				$reste = trim(substr($reste, strpos($reste, '(')+1));
				$transEquipe = substr($reste, 0, strpos($reste, ')'));
				$reste = trim(substr($reste, strpos($reste, ')')+1));
				$transStatus = ucfirst($reste);
			}
			// promote to pro roster
			if(substr_count($reste, ' to pro roster')){
				$transEquipe = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$transStatus = ucfirst(substr($reste, 0, strpos($reste, ' ')));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$transPlayer = substr($reste, 0, strpos($reste, ' to '));
				$reste = trim(substr($reste, strpos($reste, ' to ')));
				$transStatus .= ' '.substr($reste, 0);
			}
			// assign to minor
			if(substr_count($reste, ' to minors')){
				$transEquipe = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$transStatus = ucfirst(substr($reste, 0, strpos($reste, ' ')));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$transPlayer = substr($reste, 0, strpos($reste, ' to '));
				$reste = trim(substr($reste, strpos($reste, ' to ')));
				$transStatus .= ' '.substr($reste, 0);
			}
			// Signature
			if(substr_count($reste, ' sign ')){
				$transEquipe = substr($reste, 0, strpos($reste, ' sign '));
				$reste = trim(substr($reste, strpos($reste, ' sign ')));
				$transStatus = ucfirst(substr($reste, 0, strpos($reste, ' ')));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$transPlayer = substr($reste, 0);
			}
			// Coatch Fire
			if(substr_count($reste, ' fire Head Coach ')){
				$transEquipe = substr($reste, 0, strpos($reste, ' fire '));
				$reste = trim(substr($reste, strpos($reste, ' fire ')));
				$transStatus = ucfirst(substr($reste, 0, strpos($reste, 'Coach') + 5));
				$reste = trim(substr($reste, strpos($reste, 'Coach') + 5));
				$transPlayer = substr($reste, 0);
			}
			// Coatch Hire
			if(substr_count($reste, ' hire Head Coach ')){
				$transEquipe = substr($reste, 0, strpos($reste, ' hire '));
				$reste = trim(substr($reste, strpos($reste, ' hire ')));
				$transStatus = ucfirst(substr($reste, 0, strpos($reste, 'Coach') + 5));
				$reste = trim(substr($reste, strpos($reste, 'Coach') + 5));
				$transPlayer = substr($reste, 0);
			}
			
			if($c == 1) $c = 2;
			else $c = 1;
			
			$bold = '';
			if(isset($TSabbr) && ($transEquipe == $TSabbr || $transEquipe == $currentTeam)) $bold = 'font-weight:bold;';
			
			echo '<tr class="hover'.$c.'">';
			echo '<td style="'.$bold.'">'.$transPlayer.'</td>';
			echo '<td style="'.$bold.'">'.$transEquipe.'</td>';
			echo '<td style="'.$bold.'">'.$transStatus.'</td>';
			echo '</tr>';
			
			$d++;
		}
		if(substr($val, 0, 3) == 'To ' && $d < 10){
			if($d == 0) {
				echo '<tr class="tableau-top">';
				echo '<td>'.$transactPlayers.'</td>';
				echo '<td>'.$transactTeam.'</td>';
				echo '<td>'.$transactStatus.'</td>';
				echo '</tr>';
			}
			$reste = substr($val, 0, strpos($val, '<BR>'));
			
			$transEquipe = substr($reste, 0, strpos($reste, ':'));
			$reste = trim(substr($reste, strpos($reste, ':')+1));
			$transStatus = ucfirst($reste);
			
			if($c == 1) $c = 2;
			else $c = 1;
			
			$bold = '';
			if(isset($TSabbr) && ($transEquipe == $TSabbr || $transEquipe == $currentTeam)) $bold = 'font-weight:bold;';
			
			echo '<tr class="hover'.$c.'">';
			echo '<td colspan="2" style="'.$bold.'">'.$transEquipe.'</td>';
			echo '<td style="'.$bold.'">'.$transStatus.'</td>';
			echo '</tr>';
			
			$d++;
		}
	}
}
else echo '<tr><td>'.$allFileNotFound.' - '.$Fnm.'</td></tr>';
if($d == 0) echo '<tr class="hover2"><td colspan="3" style="font-weight:bold; text-align:center;">'.$transactNo.'</td></tr>';
echo '</table></div>';
?>