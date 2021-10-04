<?php
require_once 'config.php';
include 'lang.php';

$csTeam = '';
$csRookie = '';
$csName = '';
$csPos = '';
$csAge1 = '';
$csAge2 = '';
$csHeight1 = '';
$csHeight2 = '';
$csWeight1 = '';
$csWeight2 = '';
$csSalary1 = '';
$csSalary2 = '';
$csContract1 = '';
$csContract2 = '';
$csHand = '';
$csIntensity1 = '';
$csIntensity2 = '';
$csSpeed1 = '';
$csSpeed2 = '';
$csStrenght1 = '';
$csStrenght2 = '';
$csEndurance1 = '';
$csEndurance2 = '';
$csDurability1 = '';
$csDurability2 = '';
$csDiscipline1 = '';
$csDiscipline2 = '';
$csSkating1 = '';
$csSkating2 = '';
$csPassing1 = '';
$csPassing2 = '';
$csPuckControl1 = '';
$csPuckControl2 = '';
$csDefense1 = '';
$csDefense2 = '';
$csOffense1 = '';
$csOffense2 = '';
$csExperience1 = '';
$csExperience2 = '';
$csLeadership1 = '';
$csLeadership2 = '';
$csOverall1 = '';
$csOverall2 = '';
$csFarm = '';
$csSortBy = '';
$csSortWay = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(isset($_GET['csTeam']) || isset($_POST['csTeam'])) {
		$csTeam = ( isset($_GET['csTeam']) ) ? $_GET['csTeam'] : $_POST['csTeam'];
		$csTeam = htmlspecialchars($csTeam);
	}
	if(isset($_GET['csRookie']) || isset($_POST['csRookie'])) {
		$csRookie = ( isset($_GET['csRookie']) ) ? $_GET['csRookie'] : $_POST['csRookie'];
		$csRookie = htmlspecialchars($csRookie);
	}
	if(isset($_GET['csName']) || isset($_POST['csName'])) {
		$csName = ( isset($_GET['csName']) ) ? $_GET['csName'] : $_POST['csName'];
		$csName = htmlspecialchars($csName);
	}
	if(isset($_GET['csPos']) || isset($_POST['csPos'])) {
		$csPos = ( isset($_GET['csPos']) ) ? $_GET['csPos'] : $_POST['csPos'];
		$csPos = htmlspecialchars($csPos);
	}
	if(isset($_GET['csAge1']) || isset($_POST['csAge1'])) {
		$csAge1 = ( isset($_GET['csAge1']) ) ? $_GET['csAge1'] : $_POST['csAge1'];
		$csAge1 = htmlspecialchars($csAge1);
	}
	if(isset($_GET['csAge2']) || isset($_POST['csAge2'])) {
		$csAge2 = ( isset($_GET['csAge2']) ) ? $_GET['csAge2'] : $_POST['csAge2'];
		$csAge2 = htmlspecialchars($csAge2);
	}
	if(isset($_GET['csHeight1']) || isset($_POST['csHeight1'])) {
		$csHeight1 = ( isset($_GET['csHeight1']) ) ? $_GET['csHeight1'] : $_POST['csHeight1'];
		$csHeight1 = htmlspecialchars($csHeight1);
	}
	if(isset($_GET['csHeight2']) || isset($_POST['csHeight2'])) {
		$csHeight2 = ( isset($_GET['csHeight2']) ) ? $_GET['csHeight2'] : $_POST['csHeight2'];
		$csHeight2 = htmlspecialchars($csHeight2);
	}
	if(isset($_GET['csWeight1']) || isset($_POST['csWeight1'])) {
		$csWeight1 = ( isset($_GET['csWeight1']) ) ? $_GET['csWeight1'] : $_POST['csWeight1'];
		$csWeight1 = htmlspecialchars($csWeight1);
	}
	if(isset($_GET['csWeight2']) || isset($_POST['csWeight2'])) {
		$csWeight2 = ( isset($_GET['csWeight2']) ) ? $_GET['csWeight2'] : $_POST['csWeight2'];
		$csWeight2 = htmlspecialchars($csWeight2);
	}
	if(isset($_GET['csSalary1']) || isset($_POST['csSalary1'])) {
		$csSalary1 = ( isset($_GET['csSalary1']) ) ? $_GET['csSalary1'] : $_POST['csSalary1'];
		$csSalary1 = htmlspecialchars($csSalary1);
		$csSalary1Format = $csSalary1 * 1000000;
	}
	if(isset($_GET['csSalary2']) || isset($_POST['csSalary2'])) {
		$csSalary2 = ( isset($_GET['csSalary2']) ) ? $_GET['csSalary2'] : $_POST['csSalary2'];
		$csSalary2 = htmlspecialchars($csSalary2);
		$csSalary2Format = $csSalary2 * 1000000;
	}
	if(isset($_GET['csContract1']) || isset($_POST['csContract1'])) {
		$csContract1 = ( isset($_GET['csContract1']) ) ? $_GET['csContract1'] : $_POST['csContract1'];
		$csContract1 = htmlspecialchars($csContract1);
	}
	if(isset($_GET['csContract2']) || isset($_POST['csContract2'])) {
		$csContract2 = ( isset($_GET['csContract2']) ) ? $_GET['csContract2'] : $_POST['csContract2'];
		$csContract2 = htmlspecialchars($csContract2);
	}
	if(isset($_GET['csHand']) || isset($_POST['csHand'])) {
		$csHand = ( isset($_GET['csHand']) ) ? $_GET['csHand'] : $_POST['csHand'];
		$csHand = htmlspecialchars($csHand);
		$csHandFormat = '';
		if($csHand == 0) $csHandFormat = 'L';
		if($csHand == 2) $csHandFormat = 'R';
	}
	if(isset($_GET['csIntensity1']) || isset($_POST['csIntensity1'])) {
		$csIntensity1 = ( isset($_GET['csIntensity1']) ) ? $_GET['csIntensity1'] : $_POST['csIntensity1'];
		$csIntensity1 = htmlspecialchars($csIntensity1);
	}
	if(isset($_GET['csIntensity2']) || isset($_POST['csIntensity2'])) {
		$csIntensity2 = ( isset($_GET['csIntensity2']) ) ? $_GET['csIntensity2'] : $_POST['csIntensity2'];
		$csIntensity2 = htmlspecialchars($csIntensity2);
	}
	if(isset($_GET['csSpeed1']) || isset($_POST['csSpeed1'])) {
		$csSpeed1 = ( isset($_GET['csSpeed1']) ) ? $_GET['csSpeed1'] : $_POST['csSpeed1'];
		$csSpeed1 = htmlspecialchars($csSpeed1);
	}
	if(isset($_GET['csSpeed2']) || isset($_POST['csSpeed2'])) {
		$csSpeed2 = ( isset($_GET['csSpeed2']) ) ? $_GET['csSpeed2'] : $_POST['csSpeed2'];
		$csSpeed2 = htmlspecialchars($csSpeed2);
	}
	if(isset($_GET['csStrenght1']) || isset($_POST['csStrenght1'])) {
		$csStrenght1 = ( isset($_GET['csStrenght1']) ) ? $_GET['csStrenght1'] : $_POST['csStrenght1'];
		$csStrenght1 = htmlspecialchars($csStrenght1);
	}
	if(isset($_GET['csStrenght2']) || isset($_POST['csStrenght2'])) {
		$csStrenght2 = ( isset($_GET['csStrenght2']) ) ? $_GET['csStrenght2'] : $_POST['csStrenght2'];
		$csStrenght2 = htmlspecialchars($csStrenght2);
	}
	if(isset($_GET['csEndurance1']) || isset($_POST['csEndurance1'])) {
		$csEndurance1 = ( isset($_GET['csEndurance1']) ) ? $_GET['csEndurance1'] : $_POST['csEndurance1'];
		$csEndurance1 = htmlspecialchars($csEndurance1);
	}
	if(isset($_GET['csEndurance2']) || isset($_POST['csEndurance2'])) {
		$csEndurance2 = ( isset($_GET['csEndurance2']) ) ? $_GET['csEndurance2'] : $_POST['csEndurance2'];
		$csEndurance2 = htmlspecialchars($csEndurance2);
	}
	if(isset($_GET['csDurability1']) || isset($_POST['csDurability1'])) {
		$csDurability1 = ( isset($_GET['csDurability1']) ) ? $_GET['csDurability1'] : $_POST['csDurability1'];
		$csDurability1 = htmlspecialchars($csDurability1);
	}
	if(isset($_GET['csDurability2']) || isset($_POST['csDurability2'])) {
		$csDurability2 = ( isset($_GET['csDurability2']) ) ? $_GET['csDurability2'] : $_POST['csDurability2'];
		$csDurability2 = htmlspecialchars($csDurability2);
	}
	if(isset($_GET['csDiscipline1']) || isset($_POST['csDiscipline1'])) {
		$csDiscipline1 = ( isset($_GET['csDiscipline1']) ) ? $_GET['csDiscipline1'] : $_POST['csDiscipline1'];
		$csDiscipline1 = htmlspecialchars($csDiscipline1);
	}
	if(isset($_GET['csDiscipline2']) || isset($_POST['csDiscipline2'])) {
		$csDiscipline2 = ( isset($_GET['csDiscipline2']) ) ? $_GET['csDiscipline2'] : $_POST['csDiscipline2'];
		$csDiscipline2 = htmlspecialchars($csDiscipline2);
	}
	if(isset($_GET['csSkating1']) || isset($_POST['csSkating1'])) {
		$csSkating1 = ( isset($_GET['csSkating1']) ) ? $_GET['csSkating1'] : $_POST['csSkating1'];
		$csSkating1 = htmlspecialchars($csSkating1);
	}
	if(isset($_GET['csSkating2']) || isset($_POST['csSkating2'])) {
		$csSkating2 = ( isset($_GET['csSkating2']) ) ? $_GET['csSkating2'] : $_POST['csSkating2'];
		$csSkating2 = htmlspecialchars($csSkating2);
	}
	if(isset($_GET['csPassing1']) || isset($_POST['csPassing1'])) {
		$csPassing1 = ( isset($_GET['csPassing1']) ) ? $_GET['csPassing1'] : $_POST['csPassing1'];
		$csPassing1 = htmlspecialchars($csPassing1);
	}
	if(isset($_GET['csPassing2']) || isset($_POST['csPassing2'])) {
		$csPassing2 = ( isset($_GET['csPassing2']) ) ? $_GET['csPassing2'] : $_POST['csPassing2'];
		$csPassing2 = htmlspecialchars($csPassing2);
	}
	if(isset($_GET['csPuckControl1']) || isset($_POST['csPuckControl1'])) {
		$csPuckControl1 = ( isset($_GET['csPuckControl1']) ) ? $_GET['csPuckControl1'] : $_POST['csPuckControl1'];
		$csPuckControl1 = htmlspecialchars($csPuckControl1);
	}
	if(isset($_GET['csPuckControl2']) || isset($_POST['csPuckControl2'])) {
		$csPuckControl2 = ( isset($_GET['csPuckControl2']) ) ? $_GET['csPuckControl2'] : $_POST['csPuckControl2'];
		$csPuckControl2 = htmlspecialchars($csPuckControl2);
	}
	if(isset($_GET['csDefense1']) || isset($_POST['csDefense1'])) {
		$csDefense1 = ( isset($_GET['csDefense1']) ) ? $_GET['csDefense1'] : $_POST['csDefense1'];
		$csDefense1 = htmlspecialchars($csDefense1);
	}
	if(isset($_GET['csDefense2']) || isset($_POST['csDefense2'])) {
		$csDefense2 = ( isset($_GET['csDefense2']) ) ? $_GET['csDefense2'] : $_POST['csDefense2'];
		$csDefense2 = htmlspecialchars($csDefense2);
	}
	if(isset($_GET['csOffense1']) || isset($_POST['csOffense1'])) {
		$csOffense1 = ( isset($_GET['csOffense1']) ) ? $_GET['csOffense1'] : $_POST['csOffense1'];
		$csOffense1 = htmlspecialchars($csOffense1);
	}
	if(isset($_GET['csOffense2']) || isset($_POST['csOffense2'])) {
		$csOffense2 = ( isset($_GET['csOffense2']) ) ? $_GET['csOffense2'] : $_POST['csOffense2'];
		$csOffense2 = htmlspecialchars($csOffense2);
	}
	if(isset($_GET['csExperience1']) || isset($_POST['csExperience1'])) {
		$csExperience1 = ( isset($_GET['csExperience1']) ) ? $_GET['csExperience1'] : $_POST['csExperience1'];
		$csExperience1 = htmlspecialchars($csExperience1);
	}
	if(isset($_GET['csExperience2']) || isset($_POST['csExperience2'])) {
		$csExperience2 = ( isset($_GET['csExperience2']) ) ? $_GET['csExperience2'] : $_POST['csExperience2'];
		$csExperience2 = htmlspecialchars($csExperience2);
	}
	if(isset($_GET['csLeadership1']) || isset($_POST['csLeadership1'])) {
		$csLeadership1 = ( isset($_GET['csLeadership1']) ) ? $_GET['csLeadership1'] : $_POST['csLeadership1'];
		$csLeadership1 = htmlspecialchars($csLeadership1);
	}
	if(isset($_GET['csLeadership2']) || isset($_POST['csLeadership2'])) {
		$csLeadership2 = ( isset($_GET['csLeadership2']) ) ? $_GET['csLeadership2'] : $_POST['csLeadership2'];
		$csLeadership2 = htmlspecialchars($csLeadership2);
	}
	if(isset($_GET['csOverall1']) || isset($_POST['csOverall1'])) {
		$csOverall1 = ( isset($_GET['csOverall1']) ) ? $_GET['csOverall1'] : $_POST['csOverall1'];
		$csOverall1 = htmlspecialchars($csOverall1);
	}
	if(isset($_GET['csOverall2']) || isset($_POST['csOverall2'])) {
		$csOverall2 = ( isset($_GET['csOverall2']) ) ? $_GET['csOverall2'] : $_POST['csOverall2'];
		$csOverall2 = htmlspecialchars($csOverall2);
	}
	if(isset($_GET['csFarm']) || isset($_POST['csFarm'])) {
		$csFarm = ( isset($_GET['csFarm']) ) ? $_GET['csFarm'] : $_POST['csFarm'];
		$csFarm = htmlspecialchars($csFarm);
		// 0: Pro | 1: Les deux | 2: Club-école
	}
	if(isset($_GET['csSortBy']) || isset($_POST['csSortBy'])) {
		$csSortBy = ( isset($_GET['csSortBy']) ) ? $_GET['csSortBy'] : $_POST['csSortBy'];
		$csSortBy = htmlspecialchars($csSortBy);
	}
	if(isset($_GET['csSortWay']) || isset($_POST['csSortWay'])) {
		$csSortWay = ( isset($_GET['csSortWay']) ) ? $_GET['csSortWay'] : $_POST['csSortWay'];
		$csSortWay = htmlspecialchars($csSortWay);
	}
	
	$matches = glob($folder.'*PlayerVitals.html');
	$folderLeagueURL = '';
	$matchesDate = array_map('filemtime', $matches);
	arsort($matchesDate);
	foreach ($matchesDate as $j => $val) {
		if(!substr_count($matches[$j], 'PLF')) {
			$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'PlayerVitals')-strrpos($matches[$j], '/')-1);
			break 1;
		}
	}
	$Fnm = $folder.$folderLeagueURL.'Rosters.html';
	$Fnm2 =  $folder.$folderLeagueURL.'PlayerVitals.html';
	if(file_exists($Fnm) && file_exists($Fnm2)) {
		$a = 0;
		$b = 0;
		$i = 0;
		$tableau = file($Fnm2);
		while(list($cle,$val) = each($tableau)) {
			$val = utf8_encode($val);
			if(substr_count($val, 'A NAME='.$csTeam)) {
				$b = 1;
				$reste = substr($val, strpos($val, '='), strpos($val, '</')-strpos($val, '='));
				$lastTeam = trim(substr($reste, strpos($reste, '>')+1));
			}
			if($a == 1 && substr_count($val, '------------------')) {
				$a = 2;
				$b = 0;
			}
			if($a == 1) {
				$tmp_vital_numero = substr($val, 0,  strpos($val, ' '));
				$reste = trim(substr($val, strpos($val, ' ')));
				if(substr_count($reste, '*', 0, 1)) {
					$tmp_recrue = substr($reste, 0, 1);
					$reste = trim(substr($reste, 1));
				}
				else $tmp_recrue = '';
				
				$tmp_vital_name = substr($reste, 0, strpos($reste, '  '));
				$reste = trim(substr($reste, strpos($reste, '  ')));
				$tmp_vital_position = substr($reste, 0, strpos($reste, '  '));
				$aremplacer = array('LW', 'RW');
				$remplace = array($joueursLW, $joueursRW);
				$tmp_vital_position2 = $tmp_vital_position;
				$tmp_vital_position = str_replace($aremplacer, $remplace, $tmp_vital_position);
				$reste = trim(substr($reste, strpos($reste, '  ')));
				
				$tmp_vital_age = substr($reste, 0, strpos($reste, '  '));
				$reste = trim(substr($reste, strpos($reste, '  ')));
				$tmp_vital_grandeur = substr($reste, 0, strpos($reste, '  '));
				$tmp_vital_grandeur = str_replace('ft', '\'', $tmp_vital_grandeur);
				$reste = trim(substr($reste, strpos($reste, '  ')));
				$tmp_vital_poids = substr($reste, 0, strpos($reste, 'lbs')-1);
				$reste = trim(substr($reste, strpos($reste, 'lbs') + 3));
				$tmp_vital_salaire = substr($reste, 0, strpos($reste, '  '));
				$tmp_vital_salaire2 = preg_replace('/\D/', '', $tmp_vital_salaire);
				$reste = trim(substr($reste, strpos($reste, '  ')));
				$tmp_vital_contrat = substr($reste, 0);
				$aremplacer = array('years', 'year');
				$remplace = array('', '');
				$tmp_vital_contrat = trim(str_replace($aremplacer, $remplace, $tmp_vital_contrat));
				
				$tmp_vital_grandeur2 = floatval(substr($tmp_vital_grandeur, 0, strpos($tmp_vital_grandeur, '\''))) * 12 + trim(substr($tmp_vital_grandeur, strpos($tmp_vital_grandeur, '\'')+1));
				
				if(
				($csContract1 <= $tmp_vital_contrat && $csContract2 >= $tmp_vital_contrat) && 
				($csSalary1Format <= $tmp_vital_salaire2 && $csSalary2Format >= $tmp_vital_salaire2) && 
				($csWeight1 <= $tmp_vital_poids && $csWeight2 >= $tmp_vital_poids) && 
				($csHeight1 <= $tmp_vital_grandeur2 && $csHeight2 >= $tmp_vital_grandeur2) && 
				($csAge1 <= $tmp_vital_age && $csAge2 >= $tmp_vital_age) && 
				(($csPos != '' && $csPos == $tmp_vital_position2) || $csPos == '') && 
				(($csRookie == '1' && $tmp_recrue != '') || $csRookie == '0') && 
				(($csName != '' && substr_count(strtoupper($tmp_vital_name), strtoupper($csName))) || $csName == '')
				) {
					$vital_numero[$i] = $tmp_vital_numero;
					$vital_recrue[$i] = $tmp_recrue;
					$vital_name[$i] = $tmp_vital_name;
					$vital_position[$i] = $tmp_vital_position;
					$vital_position2[$i] = $tmp_vital_position2;
					$vital_age[$i] = $tmp_vital_age;
					$vital_grandeur[$i] = $tmp_vital_grandeur.'"';
					$vital_grandeur2[$i] = $tmp_vital_grandeur2;
					$vital_poids[$i] = $tmp_vital_poids;
					$vital_salaire[$i] = $tmp_vital_salaire;
					$vital_salaire2[$i] = $tmp_vital_salaire2;
					$vital_contrat[$i] = $tmp_vital_contrat;
					$vital_team[$i] = $lastTeam;
					$i++;
				}
			}
			if(substr_count($val, 'CONTRACT') && $b == 1) {
				$a = 1;
			}
		}
		
		$a = 0;
		$i = 0;
		$tableau = file($Fnm);
		while(list($cle,$val) = each($tableau)) {
			$val = utf8_encode($val);
			if(substr_count($val, 'A NAME='.$csTeam)) {
				$a = 1;
				$reste = substr($val, strpos($val, '='), strpos($val, '</')-strpos($val, '='));
				$lastTeam = trim(substr($reste, strpos($reste, '>')+1));
			}
			if($a == 4 && substr_count($val, '</PRE>')) {
				$a = 1;
			}
			if($a == 2 && substr_count($val, '</PRE>')) {
				$a = 3;
			}
			if($a == 2 || $a == 4) {
				$reste = trim($val);
				$tmp_roster_numero = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$tmp_roster_name = substr($reste, 0, strpos($reste, '  '));
				$reste = trim(substr($reste, strpos($reste, '  ')));
				$aremplacer = array('L ', 'R ', 'LW ', 'RW ');
				$remplace = array($rostersLeft.' ', $rostersRight.' ', $rostersLW.' ', $rostersRW.' ');
				$tmp_roster_position = substr($reste, 0, strpos($reste, ' '));
				$tmp_roster_position2 = str_replace($aremplacer, $remplace, $tmp_roster_position);
				$reste = trim(substr($reste, strpos($reste, ' ')));
				if(substr_count($tmp_roster_position, 'G')) $tmp_roster_positions = 5;
				if(substr_count($tmp_roster_position, 'D')) $tmp_roster_positions = 4;
				if(substr_count($tmp_roster_position, 'LW') || substr_count($tmp_roster_position, 'LW')) $tmp_roster_positions = 2;
				if(substr_count($tmp_roster_position, 'RW') || substr_count($tmp_roster_position, 'RW')) $tmp_roster_positions = 3;
				if(substr_count($tmp_roster_position, 'C')) $tmp_roster_positions = 1;
				$tmp_roster_lance = substr($reste, 0, strpos($reste, '  '));
				$tmp_roster_lance2 = str_replace($aremplacer, $remplace, $tmp_roster_lance);
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$tmp_roster_condition = substr($reste, 0, strpos($reste, ' '));
				$reste = substr($reste, strpos($reste, ' '));
				$count = strlen($reste);
				$j = 3;
				while( $j < $count ) {
					if( ctype_digit($reste[$j]) ) {
						$pos = $j;
						$j = 1000;
					}
					$j++;
				}
				$tmp_roster_blessure = trim(substr($reste, 0, $pos));
				$reste = trim(substr($reste, $pos));
				$tmp_roster_intensite = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$tmp_roster_vitesse = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$tmp_roster_force = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$tmp_roster_endurance = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$tmp_roster_durabilite = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$tmp_roster_discipline = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$tmp_roster_patinage = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$tmp_roster_passe = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$tmp_roster_controle = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$tmp_roster_defense = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$tmp_roster_offense = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$tmp_roster_experience = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$tmp_roster_leadership = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$tmp_roster_total = substr($reste, strpos($reste, ' '));
				
				if(
				($csOverall1 <= $tmp_roster_total && $csOverall2 >= $tmp_roster_total) && 
				($csLeadership1 <= $tmp_roster_leadership && $csLeadership2 >= $tmp_roster_leadership) && 
				($csExperience1 <= $tmp_roster_experience && $csExperience2 >= $tmp_roster_experience) && 
				(($csOffense1 <= $tmp_roster_offense && $csOffense2 >= $tmp_roster_offense) || $tmp_roster_position2 == 'G') && 
				(($csDefense1 <= $tmp_roster_defense && $csDefense2 >= $tmp_roster_defense) || $tmp_roster_position2 == 'G') && 
				($csPuckControl1 <= $tmp_roster_controle && $csPuckControl2 >= $tmp_roster_controle) && 
				($csPassing1 <= $tmp_roster_passe && $csPassing2 >= $tmp_roster_passe) && 
				($csSkating1 <= $tmp_roster_patinage && $csSkating2 >= $tmp_roster_patinage) && 
				($csDiscipline1 <= $tmp_roster_discipline && $csDiscipline2 >= $tmp_roster_discipline) && 
				($csDurability1 <= $tmp_roster_durabilite && $csDurability2 >= $tmp_roster_durabilite) && 
				($csEndurance1 <= $tmp_roster_endurance && $csEndurance2 >= $tmp_roster_endurance) && 
				($csStrenght1 <= $tmp_roster_force && $csStrenght2 >= $tmp_roster_force) && 
				($csSpeed1 <= $tmp_roster_vitesse && $csSpeed2 >= $tmp_roster_vitesse) && 
				($csIntensity1 <= $tmp_roster_intensite && $csIntensity2 >= $tmp_roster_intensite) && 
				(($csHandFormat != '' && $csHandFormat == $tmp_roster_lance2) || $csHandFormat == '') && 
				(($csPos != '' && $csPos == $tmp_roster_position2) || $csPos == '') && 
				(($csName != '' && substr_count(strtoupper($tmp_roster_name), strtoupper($csName))) || $csName == '') &&
				(($csFarm != 1 && ($csFarm == 0 && $a == 2) || ($csFarm == 2 && $a == 4)) || $csFarm == 1) 
				) {
					$rosters_numero[$i] = $tmp_roster_numero;
					$rosters_name[$i] = $tmp_roster_name;
					$rosters_position[$i] = $tmp_roster_position;
					$rosters_positions[$i] = $tmp_roster_positions;
					$rosters_lance[$i] = $tmp_roster_lance;
					$rosters_condition[$i] = $tmp_roster_condition;
					$rosters_blessure[$i] = $tmp_roster_blessure;
					$rosters_intensite[$i] = $tmp_roster_intensite;
					$rosters_vitesse[$i] = $tmp_roster_vitesse;
					$rosters_force[$i] = $tmp_roster_force;
					$rosters_endurance[$i] = $tmp_roster_endurance;
					$rosters_durabilite[$i] = $tmp_roster_durabilite;
					$rosters_discipline[$i] = $tmp_roster_discipline;
					$rosters_patinage[$i] = $tmp_roster_patinage;
					$rosters_passe[$i] = $tmp_roster_passe;
					$rosters_controle[$i] = $tmp_roster_controle;
					$rosters_defense[$i] = $tmp_roster_defense;
					$rosters_offense[$i] = $tmp_roster_offense;
					$rosters_experience[$i] = $tmp_roster_experience;
					$rosters_leadership[$i] = $tmp_roster_leadership;
					$rosters_total[$i] = $tmp_roster_total;
					$rosters_team[$i] = $lastTeam;
					$i++;
				}
			}
			if($a == 1 && substr_count($val, '<PRE>')) {
				$a = 2;
			}
			if($a == 3 && substr_count($val, '<PRE>')) {
				$a = 4;
			}
		}
	}
}

$CurrentHTML = 'SearchPlayers.php';
$CurrentTitle = $searchPlayerTitle;
$CurrentPage = 'SearchPlayers';
include 'head.php';

// Recherche des équipes - Current Season
$matches = glob($folder.'*GMs.html');
$folderLeagueURL = '';
$matchesDate = array_map('filemtime', $matches);
arsort($matchesDate);
foreach ($matchesDate as $j => $val) {
	if(!substr_count($matches[$j], 'PLF')) {
		$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'GMs')-strrpos($matches[$j], '/')-1);
		break 1;
	}
}
$FnmGMs = $folder.$folderLeagueURL.'GMs.html';
$i = 0;
if(file_exists($FnmGMs)) {
	$tableau = file($FnmGMs);
	while(list($cle,$val) = myeach($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, 'HREF') && !substr_count($val, '<BR>')) {
			$gmequipe[$i] = trim(substr($val, 0, 10));
			$i++;
		}
	}
}
else echo $allFileNotFound.' - '.$FnmGMs;

?>

<script type="text/javascript">
<!--
function csHeight() {
	document.getElementById("csHeight").textContent = Math.floor(Number(document.getElementById("csHeight1").value) / 12) + "'" + Math.round(((Number(document.getElementById("csHeight1").value) / 12) - Math.floor(Number(document.getElementById("csHeight1").value) / 12)) * 12) + "\"";
	document.getElementById("csHeight").textContent += ' to ' + Math.floor(Number(document.getElementById("csHeight2").value) / 12) + "'" + Math.round(((Number(document.getElementById("csHeight2").value) / 12) - Math.floor(Number(document.getElementById("csHeight2").value) / 12)) * 12) + "\"";
}
function csWeight() {
	document.getElementById("csWeight").textContent = Math.round(Number(document.getElementById("csWeight1").value) * 0.453592 * 10) /10;
	document.getElementById("csWeight").textContent += "kg to " + Math.round(Number(document.getElementById("csWeight2").value) * 0.453592 * 10) / 10 + "kg";
}
function csSalary() {
	var number1 = (Number(document.getElementById("csSalary1").value) * 1000000);
	number1 = number1.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	var number2 = (Number(document.getElementById("csSalary2").value) * 1000000);
	number2 = number2.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	document.getElementById("csSalary").textContent = number1 + "$ to " + number2 + "$";
}

function openSearch() {
	document.getElementById("windowSearch").style.display = "block";
	document.getElementById("windowResult").style.display = "none";
}

function openResult() {
	document.getElementById("windowSearch").style.display = "none";
	document.getElementById("windowResult").style.display = "block";
}
document.addEventListener("DOMContentLoaded", function() { 
	csHeight();
	csWeight();
	csSalary();
	
	<?php 
	if($_SERVER['REQUEST_METHOD'] != 'POST') {
		echo 'document.getElementById("windowSearch").style.display = "block";';
	}
	else {
		echo 'document.getElementById("windowResult").style.display = "block";';
		echo 'document.getElementById("windowSearchResult").style.display = "block";';
	}
	?>
});

//-->
</script>

<h3><?php echo $searchPlayerSearchPlayers; ?></h3>
</br>
<div style="display:none; margin-left:auto; margin-right:auto; width:480px;" id="windowSearch">
<div id="windowSearchResult" style="display:none;"></div>
<form method="post">
	<table class="table table-sm table-striped" style="width:480px;">
	<tbody>
		<tr class="hover2">
			<td><?php echo $rostersName; ?></td>
			<td><input style="width:300px;" name="csName" type="text" value="<?php echo $csName; ?>"></td>
		</tr>
		<tr class="hover1">
			<td><?php echo $scoringTM; ?></td>
			<td>
			<select name="csTeam" style="width:300px;">
			<option value=""><?php echo $careerStatsTeams; ?></option>
			<?php
			for($i=0;$i<count($gmequipe);$i++) {
				$selected = '';
				if($csTeam != '' && $gmequipe[$i] == $csTeam) $selected = ' selected="selected"';
				echo '<option value="'.$gmequipe[$i].'"'.$selected.'>'.$gmequipe[$i].'</option>';
			}
			?>
			</select>
			</td>
		</tr>
		<tr class="hover2">
			<td>Position</td>
			<td>
			<select name="csPos" style="width:300px;">
				<option value="">Position</option>
				<option value="C"<?php if($csPos == 'C') echo ' selected="selected"'; ?>><?php echo $careerStatsCenters; ?></option>
				<option value="RW"<?php if($csPos == 'RW') echo ' selected="selected"'; ?>><?php echo $careerStatsRightWings; ?></option>
				<option value="LW"<?php if($csPos == 'LW') echo ' selected="selected"'; ?>><?php echo $careerStatsLeftWings; ?></option>
				<option value="D"<?php if($csPos == 'D') echo ' selected="selected"'; ?>><?php echo $careerStatsDefenseman; ?></option>
				<option value="G"<?php if($csPos == 'G') echo ' selected="selected"'; ?>><?php echo $careerStatsGoalies; ?></option>
			</select>
			</td>
		</tr>
		<tr class="hover1">
			<td>Age</td>
			<td>
				<input style="width:50px;" type="number" name="csAge1" min="1" max="99" step="1" value="<?php if($csAge1 != '') echo $csAge1; else echo '16' ?>">
				<input style="width:50px;" type="number" name="csAge2" min="1" max="99" step="1" value="<?php if($csAge2 != '') echo $csAge2; else echo '50' ?>">
			</td>
		</tr>
		<tr class="hover2">
			<td><?php echo $joueursHeightF; ?> (<?php echo $searchPlayerInch; ?>)</td>
			<td>
				<input style="width:50px;" onkeyup="javascript:csHeight();" onchange="javascript:csHeight();" type="number" id="csHeight1" name="csHeight1" min="1" max="99" step="1" value="<?php if($csHeight1 != '') echo $csHeight1; else echo '50' ?>">
				<input style="width:50px;" onkeyup="javascript:csHeight();" onchange="javascript:csHeight();" type="number" id="csHeight2" name="csHeight2" min="1" max="99" step="1" value="<?php if($csHeight2 != '') echo $csHeight2; else echo '90' ?>">
				<span id="csHeight"></span>
			</td>
		</tr>
		<tr class="hover1">
			<td><?php echo $joueursWeight; ?> (lbs)</td>
			<td>
				<input style="width:50px;" onkeyup="javascript:csWeight();" onchange="javascript:csWeight();" type="number" id="csWeight1" name="csWeight1" min="100" max="300" step="1" value="<?php if($csWeight1 != '') echo $csWeight1; else echo '150' ?>">
				<input style="width:50px;" onkeyup="javascript:csWeight();" onchange="javascript:csWeight();" type="number" id="csWeight2" name="csWeight2" min="100" max="300" step="1" value="<?php if($csWeight2 != '') echo $csWeight2; else echo '250' ?>">
				<span id="csWeight"></span>
			</td>
		</tr>
		<tr class="hover2">
			<td><?php echo $joueursSalary; ?> (0,0 Million $)</td>
			<td>
				<input style="width:50px;" onkeyup="javascript:csSalary();" onchange="javascript:csSalary();" type="number" id="csSalary1" name="csSalary1" min="0" max="100" step="0.1" value="<?php if($csSalary1 != '') echo $csSalary1; else echo '0' ?>">
				<input style="width:50px;" onkeyup="javascript:csSalary();" onchange="javascript:csSalary();" type="number" id="csSalary2" name="csSalary2" min="0" max="100" step="0.1" value="<?php if($csSalary2 != '') echo $csSalary2; else echo '50' ?>">
				<span id="csSalary"></span>
			</td>
		</tr>
		<tr class="hover1">
			<td><?php echo $joueursContrat; ?></td>
			<td>
				<input style="width:50px;" type="number" name="csContract1" min="0" max="20" step="1" value="<?php if($csContract1 != '') echo $csContract1; else echo '0' ?>">
				<input style="width:50px;" type="number" name="csContract2" min="0" max="20" step="1" value="<?php if($csContract2 != '') echo $csContract2; else echo '20' ?>">
				<span id="csContract"></span>
			</td>
		</tr>
		<tr class="hover2">
			<td><?php echo $rostersHDF; ?></td>
			<td>
				<span style="cursor:pointer; display:block; float:left; height:20px; padding-top:2px;" onclick="javascript:document.getElementById('csHand').value = 0;">Left </span>
				<input style="display:block; float:left; width:50px;" type="range" id="csHand" name="csHand" min="0" max="2" step="1" value="<?php if($csHand != '') echo $csHand; else echo '1' ?>">
				<span style="cursor:pointer; display:block; float:left; height:20px; padding-top:2px;" onclick="javascript:document.getElementById('csHand').value = 2;"> Right</span>
				<span id="csContract"></span>
			</td>
		</tr>
		<tr class="hover1">
			<td><?php echo $rostersITF; ?></td>
			<td>
				<input style="width:50px;" type="number" name="csIntensity1" min="0" max="100" step="1" value="<?php if($csIntensity1 != '') echo $csIntensity1; else echo '0' ?>">
				<input style="width:50px;" type="number" name="csIntensity2" min="0" max="100" step="1" value="<?php if($csIntensity2 != '') echo $csIntensity2; else echo '100' ?>">
			</td>
		</tr>
		<tr class="hover2">
			<td><?php echo $rostersSPF; ?></td>
			<td>
				<input style="width:50px;" type="number" name="csSpeed1" min="0" max="100" step="1" value="<?php if($csSpeed1 != '') echo $csSpeed1; else echo '0' ?>">
				<input style="width:50px;" type="number" name="csSpeed2" min="0" max="100" step="1" value="<?php if($csSpeed2 != '') echo $csSpeed2; else echo '100' ?>">
			</td>
		</tr>
		<tr class="hover1">
			<td><?php echo $rostersSTF; ?></td>
			<td>
				<input style="width:50px;" type="number" name="csStrenght1" min="0" max="100" step="1" value="<?php if($csStrenght1 != '') echo $csStrenght1; else echo '0' ?>">
				<input style="width:50px;" type="number" name="csStrenght2" min="0" max="100" step="1" value="<?php if($csStrenght2 != '') echo $csStrenght2; else echo '100' ?>">
			</td>
		</tr>
		<tr class="hover2">
			<td><?php echo $rostersENF; ?></td>
			<td>
				<input style="width:50px;" type="number" name="csEndurance1" min="0" max="100" step="1" value="<?php if($csEndurance1 != '') echo $csEndurance1; else echo '0' ?>">
				<input style="width:50px;" type="number" name="csEndurance2" min="0" max="100" step="1" value="<?php if($csEndurance2 != '') echo $csEndurance2; else echo '100' ?>">
			</td>
		</tr>
		<tr class="hover1">
			<td><?php echo $rostersDUF; ?></td>
			<td>
				<input style="width:50px;" type="number" name="csDurability1" min="0" max="100" step="1" value="<?php if($csDurability1 != '') echo $csDurability1; else echo '0' ?>">
				<input style="width:50px;" type="number" name="csDurability2" min="0" max="100" step="1" value="<?php if($csDurability2 != '') echo $csDurability2; else echo '100' ?>">
			</td>
		</tr>
		<tr class="hover2">
			<td><?php echo $rostersDIF; ?></td>
			<td>
				<input style="width:50px;" type="number" name="csDiscipline1" min="0" max="100" step="1" value="<?php if($csDiscipline1 != '') echo $csDiscipline1; else echo '0' ?>">
				<input style="width:50px;" type="number" name="csDiscipline2" min="0" max="100" step="1" value="<?php if($csDiscipline2 != '') echo $csDiscipline2; else echo '100' ?>">
			</td>
		</tr>
		<tr class="hover1">
			<td><?php echo $rostersSKF; ?></td>
			<td>
				<input style="width:50px;" type="number" name="csSkating1" min="0" max="100" step="1" value="<?php if($csSkating1 != '') echo $csSkating1; else echo '0' ?>">
				<input style="width:50px;" type="number" name="csSkating2" min="0" max="100" step="1" value="<?php if($csSkating2 != '') echo $csSkating2; else echo '100' ?>">
			</td>
		</tr>
		<tr class="hover2">
			<td><?php echo $rostersPAF; ?></td>
			<td>
				<input style="width:50px;" type="number" name="csPassing1" min="0" max="100" step="1" value="<?php if($csPassing1 != '') echo $csPassing1; else echo '0' ?>">
				<input style="width:50px;" type="number" name="csPassing2" min="0" max="100" step="1" value="<?php if($csPassing2 != '') echo $csPassing2; else echo '100' ?>">
			</td>
		</tr>
		<tr class="hover1">
			<td><?php echo $rostersPCF; ?></td>
			<td>
				<input style="width:50px;" type="number" name="csPuckControl1" min="0" max="100" step="1" value="<?php if($csPuckControl1 != '') echo $csPuckControl1; else echo '0' ?>">
				<input style="width:50px;" type="number" name="csPuckControl2" min="0" max="100" step="1" value="<?php if($csPuckControl2 != '') echo $csPuckControl2; else echo '100' ?>">
			</td>
		</tr>
		<tr class="hover2">
			<td><?php echo $rostersDFF; ?></td>
			<td>
				<input style="width:50px;" type="number" name="csDefense1" min="0" max="100" step="1" value="<?php if($csDefense1 != '') echo $csDefense1; else echo '0' ?>">
				<input style="width:50px;" type="number" name="csDefense2" min="0" max="100" step="1" value="<?php if($csDefense2 != '') echo $csDefense2; else echo '100' ?>">
			</td>
		</tr>
		<tr class="hover1">
			<td><?php echo $rostersOFF; ?></td>
			<td>
				<input style="width:50px;" type="number" name="csOffense1" min="0" max="100" step="1" value="<?php if($csOffense1 != '') echo $csOffense1; else echo '0' ?>">
				<input style="width:50px;" type="number" name="csOffense2" min="0" max="100" step="1" value="<?php if($csOffense2 != '') echo $csOffense2; else echo '100' ?>">
			</td>
		</tr>
		<tr class="hover2">
			<td><?php echo $rostersEXF; ?></td>
			<td>
				<input style="width:50px;" type="number" name="csExperience1" min="0" max="100" step="1" value="<?php if($csExperience1 != '') echo $csExperience1; else echo '0' ?>">
				<input style="width:50px;" type="number" name="csExperience2" min="0" max="100" step="1" value="<?php if($csExperience2 != '') echo $csExperience2; else echo '100' ?>">
			</td>
		</tr>
		<tr class="hover1">
			<td><?php echo $rostersLDF; ?></td>
			<td>
				<input style="width:50px;" type="number" name="csLeadership1" min="0" max="100" step="1" value="<?php if($csLeadership1 != '') echo $csLeadership1; else echo '0' ?>">
				<input style="width:50px;" type="number" name="csLeadership2" min="0" max="100" step="1" value="<?php if($csLeadership2 != '') echo $csLeadership2; else echo '100' ?>">
			</td>
		</tr>
		<tr class="hover2">
			<td><?php echo $rostersOVF; ?></td>
			<td>
				<input style="width:50px;" type="number" name="csOverall1" min="0" max="100" step="1" value="<?php if($csOverall1 != '') echo $csOverall1; else echo '0' ?>">
				<input style="width:50px;" type="number" name="csOverall2" min="0" max="100" step="1" value="<?php if($csOverall2 != '') echo $csOverall2; else echo '100' ?>">
			</td>
		</tr>
		<tr class="hover1">
			<td><?php echo $joueursRookie; ?></td>
			<td>
				<span style="cursor:pointer; display:block; float:left; height:20px; padding-top:2px;" onclick="javascript:document.getElementById('csRookie').value = 0;">All Players </span>
				<input style="display:block; float:left; width:50px;" type="range" id="csRookie" name="csRookie" min="0" max="1" step="1" value="<?php if($csRookie != '') echo $csRookie; else echo '0' ?>">
				<span style="cursor:pointer; display:block; float:left; height:20px; padding-top:2px;" onclick="javascript:document.getElementById('csRookie').value = 1;"> Rookies Only</span>
			</td>
		</tr>
		<tr class="hover2">
			<td><?php echo $searchPlayerProFarm; ?></td>
			<td>
				<span style="cursor:pointer; display:block; float:left; height:20px; padding-top:2px;" onclick="javascript:document.getElementById('csFarm').value = 0;">Pro </span>
				<input style="display:block; float:left; width:50px;" type="range" id="csFarm" name="csFarm" min="0" max="2" step="1" value="<?php if($csFarm != '') echo $csFarm; else echo '1' ?>">
				<span style="cursor:pointer; display:block; float:left; height:20px; padding-top:2px;" onclick="javascript:document.getElementById('csFarm').value = 2;"> <?php echo $searchPlayerFarm; ?></span>
			</td>
		</tr>
		<tr class="hover1">
			<td>Sort By</td>
			<td>
				<span style="display:block; float:left;">
					<select style="width:100px; margin-right:10px;" name="csSortBy">
						<option value="0"<?php if($csSortBy == '0') echo ' selected="selected"'; ?>><?php echo $rostersName; ?></option>
						<option value="1"<?php if($csSortBy == '1') echo ' selected="selected"'; ?>><?php echo $scoringTM; ?></option>
						<option value="2"<?php if($csSortBy == '2') echo ' selected="selected"'; ?>>Position</option>
						<option value="3"<?php if($csSortBy == '3') echo ' selected="selected"'; ?>>Age</option>
						<option value="4"<?php if($csSortBy == '4') echo ' selected="selected"'; ?>><?php echo $joueursHeightF; ?></option>
						<option value="5"<?php if($csSortBy == '5') echo ' selected="selected"'; ?>><?php echo $joueursWeight; ?></option>
						<option value="6"<?php if($csSortBy == '6') echo ' selected="selected"'; ?>><?php echo $joueursSalary; ?></option>
						<option value="7"<?php if($csSortBy == '7') echo ' selected="selected"'; ?>><?php echo $joueursContrat; ?></option>
						<option value="8"<?php if($csSortBy == '8') echo ' selected="selected"'; ?>><?php echo $rostersHDF; ?></option>
						<option value="9"<?php if($csSortBy == '9') echo ' selected="selected"'; ?>><?php echo $rostersITF; ?></option>
						<option value="10"<?php if($csSortBy == '10') echo ' selected="selected"'; ?>><?php echo $rostersSPF; ?></option>
						<option value="11"<?php if($csSortBy == '11') echo ' selected="selected"'; ?>><?php echo $rostersSTF; ?></option>
						<option value="12"<?php if($csSortBy == '12') echo ' selected="selected"'; ?>><?php echo $rostersENF; ?></option>
						<option value="13"<?php if($csSortBy == '13') echo ' selected="selected"'; ?>><?php echo $rostersDUF; ?></option>
						<option value="14"<?php if($csSortBy == '14') echo ' selected="selected"'; ?>><?php echo $rostersDIF; ?></option>
						<option value="15"<?php if($csSortBy == '15') echo ' selected="selected"'; ?>><?php echo $rostersSKF; ?></option>
						<option value="16"<?php if($csSortBy == '16') echo ' selected="selected"'; ?>><?php echo $rostersPAF; ?></option>
						<option value="17"<?php if($csSortBy == '17') echo ' selected="selected"'; ?>><?php echo $rostersPCF; ?></option>
						<option value="18"<?php if($csSortBy == '18') echo ' selected="selected"'; ?>><?php echo $rostersDFF; ?></option>
						<option value="19"<?php if($csSortBy == '19') echo ' selected="selected"'; ?>><?php echo $rostersOFF; ?></option>
						<option value="20"<?php if($csSortBy == '20') echo ' selected="selected"'; ?>><?php echo $rostersEXF; ?></option>
						<option value="21"<?php if($csSortBy == '21') echo ' selected="selected"'; ?>><?php echo $rostersLDF; ?></option>
						<option value="22"<?php if($csSortBy == '22') echo ' selected="selected"'; ?>><?php echo $rostersOVF; ?></option>
					</select>
				</span>
				<span style="cursor:pointer; display:block; float:left; height:20px; padding-top:2px;" onclick="javascript:document.getElementById('csSortWay').value = 0;"><?php echo $searchPlayerDescending; ?> </span>
				<input style="display:block; float:left; width:50px;" type="range" id="csSortWay" name="csSortWay" min="0" max="1" step="1" value="<?php if($csSortWay != '') echo $csSortWay; else echo '1' ?>">
				<span style="cursor:pointer; display:block; float:left; height:20px; padding-top:2px;" onclick="javascript:document.getElementById('csSortWay').value = 1;"> <?php echo $searchPlayerAscending; ?></span>
			</td>
		</tr>
		<tr class="tableau-top">
			<td colspan="2" style="text-align:right;"><input type="submit" value="Search"><input onclick="javascript:window.open('SearchPlayers.php','_self');" type="button" value="<?php echo $careerStatsReset; ?>"></td>
		</tr>
	</tbody>
	</table>
</form>
</div>

<!--<div id="windowResult" style="display:none; margin-left:auto; margin-right:auto; width:950px; border:solid 1px<?php echo $couleur_contour; ?>">-->
<div id="windowResult" class = "container">
<!--<a class="lien-noir" href="javascript:openSearch();"><?php echo $searchPlayerEditSearch; ?></a><br>-->
<a href="javascript:openSearch();" class="btn btn-primary btn-lg" role="button" aria-pressed="true"><?php echo $searchPlayerEditSearch; ?></a>
<?php

if(isset($vital_name) && isset($rosters_name)) {
	$s1 = $s2 = $s3 = $s4 = $s5 = $s6 = $s7 = $s8 = $s9 = $s10 = $s11 = $s12 = $s13 = $s14 = $s15 = $s16 = $s17 = $s18 = $s19 = $s20 = $s21 = $s22 = $s23 = $s24 = $s25 = $s26 = '';
	$ss = 'font-weight: bold;';
	
	for($i=0;$i<count($vital_name);$i++) {
		for($j=0;$j<count($rosters_name);$j++) {
			if($vital_name[$i] == $rosters_name[$j] && $vital_team[$i] == $rosters_team[$j]) {
				$rosters_vital_age[$j] = $vital_age[$i];
				$rosters_vital_recrue[$j] = $vital_recrue[$i];
				$rosters_vital_salaire[$j] = $vital_salaire[$i];
				$rosters_vital_salaire2[$j] = $vital_salaire2[$i];
				$rosters_vital_contrat[$j] = $vital_contrat[$i];
				$rosters_vital_grandeur[$j] = $vital_grandeur[$i];
				$rosters_vital_grandeur2[$j] = $vital_grandeur2[$i];
				$rosters_vital_poids[$j] = $vital_poids[$i];
				break 1;
			}
		}
	}
	
	?>
	<div class="titre"><span class="bold-blanc"><?php echo $searchPlayerFound; ?>&nbsp;(<?php if(isset($rosters_vital_age)) echo count($rosters_vital_age); ?>)</span></div>
	<div class = "table-responsive">
	<table class="table table-sm table-striped">
	<?php
	
	if($csSortBy == '0') {
		$sortVar = $rosters_name;
		$s2 = $ss;
	}
	if($csSortBy == '1') {
		$sortVar = $rosters_team;
		$s26 = $ss;
	}
	if($csSortBy == '2') {
		$sortVar = $rosters_positions;
		$s3 = $ss;
	}
	if($csSortBy == '3') {
		$sortVar = $rosters_vital_age;
		$s21 = $ss;
	}
	if($csSortBy == '4') {
		$sortVar = $rosters_vital_grandeur2;
		$s25 = $ss;
	}
	if($csSortBy == '5') {
		$sortVar = $rosters_vital_poids;
		$s24 = $ss;
	}
	if($csSortBy == '6') {
		$sortVar = $rosters_vital_salaire2;
		$s23 = $ss;
	}
	if($csSortBy == '7') {
		$sortVar = $rosters_vital_contrat;
		$s22 = $ss;
	}
	if($csSortBy == '8') {
		$sortVar = $rosters_lance;
		$s4 = $ss;
	}
	if($csSortBy == '9') {
		$sortVar = $rosters_intensite;
		$s7 = $ss;
	}
	if($csSortBy == '10') {
		$sortVar = $rosters_vitesse;
		$s8 = $ss;
	}
	if($csSortBy == '11') {
		$sortVar = $rosters_force;
		$s9 = $ss;
	}
	if($csSortBy == '12') {
		$sortVar = $rosters_endurance;
		$s10 = $ss;
	}
	if($csSortBy == '13') {
		$sortVar = $rosters_durabilite;
		$s11 = $ss;
	}
	if($csSortBy == '14') {
		$sortVar = $rosters_discipline;
		$s12 = $ss;
	}
	if($csSortBy == '15') {
		$sortVar = $rosters_patinage;
		$s13 = $ss;
	}
	if($csSortBy == '16') {
		$sortVar = $rosters_passe;
		$s14 = $ss;
	}
	if($csSortBy == '17') {
		$sortVar = $rosters_controle;
		$s15 = $ss;
	}
	if($csSortBy == '18') {
		$sortVar = $rosters_defense;
		$s16 = $ss;
	}
	if($csSortBy == '19') {
		$sortVar = $rosters_offense;
		$s17 = $ss;
	}
	if($csSortBy == '20') {
		$sortVar = $rosters_experience;
		$s18 = $ss;
	}
	if($csSortBy == '21') {
		$sortVar = $rosters_leadership;
		$s19 = $ss;
	}
	if($csSortBy == '22') {
		$sortVar = $rosters_total;
		$s20 = $ss;
	}
	
	natsort($sortVar);
	if($csSortWay == '0') $sortVar = array_reverse ($sortVar, TRUE);
	
	echo '
    <thead>
	<tr class="tableau-top">
	<th style="width:20px;'.$s1.'"><a href="javascript:return;" class="info">#<span>'.$rostersNumber.'</span></a></th>
	<th style="'.$s2.'"><a href="javascript:return;" class="info">'.$rostersName.'</a></th>
	<th style="'.$s26.'"><a href="javascript:return;" class="info">TEAM</a></th>
	<th style="width:20px;"><a href="javascript:return;" class="info">R<span>'.$joueursRookie.'</span></a></th>
	<th style="width:22px;'.$s3.'"><a class="info">PO<span>'.$rostersPosition.'</span></a></th>
	<th style="width:15px;'.$s4.'"><a class="info">'.$rostersHD.'<span>'.$rostersHDF.'</span></a></th>
	<th style="width:22px;'.$s5.'"><a class="info">CD<span>Condition</span></a></th>
	<th style="width:20px; text-align:center;'.$s6.'"><a href="javascript:return;" class="info">'.$rostersIJ.'<span>'.$rostersIJF.'</span></a></th>
	<th style="width:20px; text-align:center;'.$s7.'"><a href="javascript:return;" class="info">'.$rostersIT.'<span>'.$rostersITF.'</span></a></th>
	<th style="width:20px; text-align:center;'.$s8.'"><a href="javascript:return;" class="info">'.$rostersSP.'<span>'.$rostersSPF.'</span></a></th>
	<th style="width:20px; text-align:center;'.$s9.'"><a href="javascript:return;" class="info">'.$rostersST.'<span>'.$rostersSTF.'</span></a></th>
	<th style="width:20px; text-align:center;'.$s10.'"><a href="javascript:return;" class="info">'.$rostersEN.'<span>'.$rostersENF.'</span></a></th>
	<th style="width:20px; text-align:center;'.$s11.'"><a href="javascript:return;" class="info">'.$rostersDU.'<span>'.$rostersDUF.'</span></a></th>
	<th style="width:20px; text-align:center;'.$s12.'"><a href="javascript:return;" class="info">'.$rostersDI.'<span>'.$rostersDIF.'</span></a></th>
	<th style="width:20px; text-align:center;'.$s13.'"><a href="javascript:return;" class="info">'.$rostersSK.'<span>'.$rostersSKF.'</span></a></th>
	<th style="width:20px; text-align:center;'.$s14.'"><a href="javascript:return;" class="info">'.$rostersPA.'<span>'.$rostersPAF.'</span></a></th>
	<th style="width:20px; text-align:center;'.$s15.'"><a href="javascript:return;" class="info">'.$rostersPC.'<span>'.$rostersPCF.'</span></a></th>
	<th style="width:20px; text-align:center;'.$s16.'"><a href="javascript:return;" class="info">'.$rostersDF.'<span>'.$rostersDFF.'</span></a></th>
	<th style="width:20px; text-align:center;'.$s17.'"><a href="javascript:return;" class="info">'.$rostersOF.'<span>'.$rostersOFF.'</span></a></th>
	<th style="width:20px; text-align:center;'.$s18.'"><a href="javascript:return;" class="info">'.$rostersEX.'<span>'.$rostersEXF.'</span></a></th>
	<th style="width:20px; text-align:center;'.$s19.'"><a href="javascript:return;" class="info">'.$rostersLD.'<span>'.$rostersLDF.'</span></a></th>
	<th style="width:20px; text-align:center;'.$s20.'"><a href="javascript:return;" class="info">'.$rostersOV.'<span>'.$rostersOVF.'</span></a></th>
	<th style="width:20px; text-align:center;'.$s21.'"><a href="javascript:return;" class="info">AGE</a></th>
	<th style="width:70px; text-align:right;'.$s23.'"><a href="javascript:return;" class="info">'.$joueursSalary.'</a></th>
	<th style="width:20px; text-align:center;'.$s22.'"><a href="javascript:return;" class="info">'.$linkedYear.'<span>'.$linkedYearF.'</span></a></th>
	<th style="width:40px; text-align:center;'.$s25.'"><a href="javascript:return;" class="info">'.$linkedHeightm.'<span>'.$joueursHeightF.'</span></a></th>
	<th style="width:50px; text-align:center;'.$s24.'"><a href="javascript:return;" class="info">'.$linkedWeightm.'<span>'.$joueursWeight.'</span></a></th>
	</tr>
	</thead>
    <tbody>';
	
	$c = 1;
	while(list ($key, $val) = each($sortVar)) {
		if(isset($rosters_vital_age[$key])) {
			if($c == 1) $c = 2;
			else $c = 1;
			echo '
			<tr class="hover'.$c.'">
			<td style="'.$s1.'">'.$rosters_numero[$key].'</td>
			<td style="'.$s2.'">';
			echo '<a class="lien-noir" style="display:block; width:100%;"
			href="CareerStatsPlayer.php?csName='.urlencode($rosters_name[$key]).'">';
			echo $rosters_name[$key];
			echo '</a>';
			echo '</td>
			<td style="'.$s26.'">'.$rosters_team[$key].'</td>
			<td style="">'.$rosters_vital_recrue[$key].'</td>
			<td style="'.$s3.'">'.$rosters_position[$key].'</td>
			<td style="'.$s4.'">'.$rosters_lance[$key].'</td>
			<td style="'.$s5.'">'.$rosters_condition[$key].'</td>
			<td style="text-align:center;'.$s6.'">'.$rosters_blessure[$key].'</td>
			<td style="text-align:center;'.$s7.'">'.$rosters_intensite[$key].'</td>
			<td style="text-align:center;'.$s8.'">'.$rosters_vitesse[$key].'</td>
			<td style="text-align:center;'.$s9.'">'.$rosters_force[$key].'</td>
			<td style="text-align:center;'.$s10.'">'.$rosters_endurance[$key].'</td>
			<td style="text-align:center;'.$s11.'">'.$rosters_durabilite[$key].'</td>
			<td style="text-align:center;'.$s12.'">'.$rosters_discipline[$key].'</td>
			<td style="text-align:center;'.$s13.'">'.$rosters_patinage[$key].'</td>
			<td style="text-align:center;'.$s14.'">'.$rosters_passe[$key].'</td>
			<td style="text-align:center;'.$s15.'">'.$rosters_controle[$key].'</td>
			<td style="text-align:center;'.$s16.'">'.$rosters_defense[$key].'</td>
			<td style="text-align:center;'.$s17.'">'.$rosters_offense[$key].'</td>
			<td style="text-align:center;'.$s18.'">'.$rosters_experience[$key].'</td>
			<td style="text-align:center;'.$s19.'">'.$rosters_leadership[$key].'</td>
			<td style="text-align:center;'.$s20.'">'.$rosters_total[$key].'</td>
			<td style="text-align:center;'.$s21.'">'.$rosters_vital_age[$key].'</td>
			<td style="text-align:right;'.$s23.'">'.$rosters_vital_salaire[$key].'$</td>
			<td style="text-align:center;'.$s22.'">'.$rosters_vital_contrat[$key].'</td>
			<td style="text-align:right;'.$s25.'">'.$rosters_vital_grandeur[$key].'</td>
			<td style="text-align:right;'.$s24.'">'.$rosters_vital_poids[$key].' lbs</td>
			</tr>';
		}
	}
}
else {
	echo '<tr class="hover2"><td colspan="27" style="text-align:center;">'.$searchPlayerNotFound.'</td></tr>';
}

?>
</tbody>
</table>
</div>
</div>

<?php include 'footer.php'; ?>