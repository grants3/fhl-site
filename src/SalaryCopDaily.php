<?php
require_once 'config.php';
include 'lang.php';
$CurrentHTML = 'Finance';
$CurrentTitle = $langSalaryCopDailyTitle;
$CurrentPage = 'SalaryCopDaily';
include 'head.php';

$v = 'background-color:green;'; // Good Salary Cap
$o = 'background-color:orange;'; // Close Salary Cap
$r = 'background-color:red;'; // Over Salary Cap
$dr = 'background-color:#8B0000;'; // Under Floor Salary Cap
?>

<div style="clear:both; width:555px; margin-left:auto; margin-right:auto; border:solid 1px<?php echo $couleur_contour; ?>">
<div class="titre"><span class="bold-blanc"><?php echo $langSalaryCopDailyTitle; ?></span></div>
<div style="padding:0px 0px 0px 0px;">
<table class="tableau">

<?php
$i = 0;
$matches = glob(TRANSFER_DIR.'*Schedule.html');
$folderLeagueURL = '';
$matchesDate = array_map('filemtime', $matches);
arsort($matchesDate);
foreach ($matchesDate as $j => $val) {
	$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'Schedule')-strrpos($matches[$j], '/')-1);
	break 1;
}

// Number of Days detection and Trade Deadline
$leagueDays = 0;
$leagueCurrentDays = 0;
$Fnm = TRANSFER_DIR.$folderLeagueURL.'Schedule.html';
if (file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = each($tableau)) {
		if(substr_count($val, 'Day')) {
			$leagueDays++;
		}
		if(substr_count($val, 'A HREF=')){
			$leagueCurrentDays = $leagueDays;
		}
		if(substr_count($val, 'TRADE DEADLINE')) {
			$leagueTradeDeadline = $leagueDays+1;
		}
	}
}
else echo $allFileNotFound.' - '.$Fnm;

// Financial
$Fnm = TRANSFER_DIR.$folderLeagueURL.'Finance.html';
if(file_exists($Fnm)) {
	$i = 0;
	$tableau = file($Fnm);
	while(list($cle,$val) = each($tableau)) {
		$val = encodeToUtf8($val);
		if(substr_count($val, '<P>(As of')){
			$pos = strpos($val, ')');
			$pos = $pos - 10;
			$val = substr($val, 10, $pos);
			
			// Affichage du plafond salariale
			$leagueSalaryClose2 = SALARY_CAP - SALARY_CAP_WARN;
			$leagueSalaryCap_ca = number_format(SALARY_CAP, 0, ' ', ',');
			$leagueSalaryCap_ca2 = number_format(SALARY_CAP_FLOOR, 0, ' ', ',');
			$leagueSalaryClose_ca = number_format(SALARY_CAP_WARN, 0, ' ', ',');
			echo '<tr><td colspan="6" style="padding-bottom:20px;">'.$allLastUpdate.' '.$val.'<br><br>';
			echo $langSalaryCopDailySeasonLength.': '.$leagueDays.'<br>';
			echo $langSalaryCopDailyCurrentDay.': '.$leagueCurrentDays.'<br>';
			echo $langSalaryCopDailyTradeDeadline.': '.$leagueTradeDeadline.'<br>';
			echo $salaryCopSalaryCap.' '.$leagueSalaryCap_ca.'$<br>';
			echo $salaryCopFloor.' '.$leagueSalaryCap_ca2.'$<br>';
			echo $salaryCopNear.' '.$leagueSalaryClose_ca.'$ '.$salaryCopNearTo.' '.$leagueSalaryCap_ca.'$</td></tr>';
			
			// Affichage des titres du tableau
			echo '<tr class="tableau-top"><td style="text-align:left;">'.$salaryCopTeam.'</td>
			<td style="text-align:center;">'.$langSalaryCopDailyCapSpent.'</td>
			<td style="text-align:center;">'.$langSalaryCopDailyAVGDay.'</td>
			<td style="text-align:center;">'.$langSalaryCopDailySalaryCap.'</td>
			<td style="text-align:center;">'.$langSalaryCopDailyMaxCapSpent.'</td>
			<td style="text-align:center;">'.$langSalaryCopDailyMaxCapSpentTrade.'</td>
			<td style="text-align:center;">S</td></tr>';
		}
		if(substr_count($val, 'A NAME')) {
			if(isset($salaryCap[$i])) $i++;
			$pos = strpos($val, '</A>');
			$pos = $pos - 23;
			$SalaryCopTeam[$i] = trim(substr($val, 23, $pos));
		}
		if(substr_count($val, '<TD>Pro Payroll</TD>')) {
			$pos = strpos($val, '</TD></TR>');
			$pos = $pos - 69;
			$propayroll = substr($val, 69, $pos);
			$propayroll2 = preg_replace('/\D/', '', $propayroll);
		}
		if(substr_count($val, '<TD>Farm Payroll</TD>')) {
			$pos = strpos($val, '</TD></TR>');
			$pos = $pos - 30;
			$farmpayroll = substr($val, 30, $pos);
			$farmpayroll2 = preg_replace('/\D/', '', $farmpayroll);
			
			if(CAP_MODE == 0) {
				$salaryCap[$i] = $propayroll2;
			}
			if(CAP_MODE == 1) {
				$salaryCap[$i] = $propayroll2;
			}
			
			$z[$i] = '';
			if(substr_count($SalaryCopTeam[$i], $currentTeam)) $z[$i] = ' font-weight:bold;';
			
			$salaryCapSpentToday[$i] = $salaryCap[$i] / $leagueDays;
		}
	}
	
	// Create / Modify SalaryCopDaily.txt
	$Fnm = 'SalaryCopDaily.txt';
	
	// Lecture du JOUR de calendrier et enregistre les données du fichier dans une variable
	$fileCurrentDays = 0;
	if(file_exists($Fnm)) {
		$SalaryCopDailyRead = file($Fnm);
		$SalaryCopDailyReadCount = count($SalaryCopDailyRead);
		for($i=0;$i<count($SalaryCopDailyRead);$i++) {
			if($i != 0) {
				$salaryCapSpentString[$i-1] = substr($SalaryCopDailyRead[$i], 0, -1);
			}
			if($i == 0) $fileCurrentDays = $SalaryCopDailyRead[$i];
		}
	}
	
	// Écriture
	if($fileCurrentDays < $leagueCurrentDays && isset($salaryCapSpentToday)) {
		$error = 0;
		$SalaryCopDailyFile = fopen($Fnm, "w") or $error = 1;
		if($error == 1) {
			chmod(".", 0755);
			$SalaryCopDailyFile = fopen($Fnm, "w") or die("Unable to open file!<br>");
		}
		$chatBoxFileTxt = $leagueCurrentDays."\n";
		for($i=0;$i<count($SalaryCopTeam);$i++) {
			if(!isset($salaryCapSpentString[$i])) $salaryCapSpentString[$i] = "";
			$chatBoxFileTxt .= $salaryCapSpentString[$i].round($salaryCapSpentToday[$i]).";\n";
		}
		fwrite($SalaryCopDailyFile, $chatBoxFileTxt);
		fclose($SalaryCopDailyFile);
	}
	if($fileCurrentDays > $leagueCurrentDays) {
		echo '<tr><td colspan="6" style="padding-bottom:20px;">New Season detected, please delete your SalaryCopDaily.txt!</td></tr>';
	}
	
	// Lecture après écriture
	if(file_exists($Fnm)) {
		$SalaryCopDailyRead = file($Fnm);
		$SalaryCopDailyReadCount = count($SalaryCopDailyRead);
		for($i=0;$i<count($SalaryCopDailyRead);$i++) {
			if($i != 0) {
				if(isset($salaryCapSpentTmp)) unset($salaryCapSpentTmp);
				$salaryCapSpentTmp = explode(";",$SalaryCopDailyRead[$i]);
				$salaryCapSpent[$i-1] = 0;
				for($j=0;$j<count($salaryCapSpentTmp);$j++) {
					$salaryCapSpent[$i-1] += $salaryCapSpentTmp[$j];
				}
			}
		}
	}
	
	// Afficher les données
	if(isset($salaryCapSpent)) {
		$c = 1;
		for($i=0;$i<count($salaryCapSpent);$i++) {
			if($c == 1) $c = 2;
			else $c = 1;
			// Cap Spent = Previous Total of Daily Spent Salary + Current Sim Day Salary Spent (Payroll/Season Length)
			// Avg Per Day = Cap Spent / Current Day
			// Season Cap Pace = Cap Spent + [(Payroll/Season Length) x Days Remaining]
			// Max Spendable Cap / Day = (League Salary Cap - Cap Spent) * Season Length / (Season Length - Current Day)
			// Max Spendable Trade Deadline = (League Salary Cap - (Cap spent + ((Deadline Day - Current day)*(Current Payroll / Season Length))))/(Season Length - Deadline Day) * Season Length
			if($leagueCurrentDays != 0) $salaryCapAvgPerDay = $salaryCapSpent[$i] / $leagueCurrentDays;
			else $salaryCapAvgPerDay = 0;
			$salarySeasonCapPace = $salaryCapSpent[$i] + ($salaryCap[$i]/$leagueDays*($leagueDays-$leagueCurrentDays));
			if($leagueDays-$leagueCurrentDays > 0) $salaryMaxSpendableCap = (SALARY_CAP - $salaryCapSpent[$i]) * $leagueDays / ($leagueDays-$leagueCurrentDays);
			else $salaryMaxSpendableCap = 0;
			if($leagueTradeDeadline-$leagueCurrentDays > 0) $salaryMaxSpendableCapTrade = (SALARY_CAP - ($salaryCapSpent[$i] + (($leagueTradeDeadline - $leagueCurrentDays) * ($salaryCap[$i] / $leagueDays)))) / ($leagueDays - $leagueTradeDeadline) * $leagueDays;
			else $salaryMaxSpendableCapTrade = 0;
			
			if($salarySeasonCapPace < SALARY_CAP_FLOOR && SALARY_CAP_FLOOR != 0) {
				$b = $dr;
			}
			if($salarySeasonCapPace <= SALARY_CAP_WARN && ($salarySeasonCapPace >= SALARY_CAP_FLOOR || SALARY_CAP_FLOOR == 0)) {
				$b = $v;
			}
			if($salarySeasonCapPace >= SALARY_CAP_WARN && $salarySeasonCapPace <= SALARY_CAP) {
				$b = $o;
			}
			if($salarySeasonCapPace > SALARY_CAP) {
				$b = $r;
			}
			
			$salaryCapSpent[$i] = number_format($salaryCapSpent[$i], 0, '', ',');
			$salaryCapAvgPerDay = number_format($salaryCapAvgPerDay, 0, '', ',');
			$salarySeasonCapPace = number_format($salarySeasonCapPace, 0, '', ',');
			$salaryMaxSpendableCap = number_format($salaryMaxSpendableCap, 0, '', ',');
			$salaryMaxSpendableCapTrade = number_format($salaryMaxSpendableCapTrade, 0, '', ',');
			echo '
			<tr class="hover'.$c.'"><td style="text-align:left;'.$z[$i].'">'.$SalaryCopTeam[$i].'</td>
			<td style="text-align:center;'.$z[$i].'">$'.$salaryCapSpent[$i].'</td>
			<td style="text-align:center;'.$z[$i].'">$'.$salaryCapAvgPerDay.'</td>
			<td style="text-align:center;'.$z[$i].'">$'.$salarySeasonCapPace.'</td>
			<td style="text-align:center;'.$z[$i].'">$'.$salaryMaxSpendableCap.'</td>
			<td style="text-align:center;'.$z[$i].'">$'.$salaryMaxSpendableCapTrade.'</td>
			<td><div style="'.$b.'"><br></div></td></tr>';
		}
	}
	if(($fileCurrentDays < $leagueCurrentDays) && isset($salaryCapSpentToday)) {
		echo '<tr><td colspan="7">Those values should be added in the text file...</td></tr>';
		for($i=0;$i<count($salaryCapSpentToday);$i++) {
			echo '<tr><td>'.$SalaryCopTeam[$i].'</td><td colspan="6">'.$salaryCapSpentToday[$i].'</td></tr>';
		}
	}
}
else echo $allFileNotFound.' - '.$Fnm;
echo '</table><br>'.$langSalaryCopDailyHowTo;
?>
</div></div>
