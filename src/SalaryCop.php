<?php
require_once 'config.php';
include 'lang.php';
$CurrentHTML = 'SalaryCop.php';
$CurrentTitle = $salaryCopTitle;
$CurrentPage = 'SalaryCop';
include 'head.php';

include_once 'classes/TeamHolder.php';
include_once 'classes/PlayerVitalsHolder.php';
include_once 'classes/PlayerVitalObj.php';

include_once 'classes/RostersHolder.php';
include_once 'classes/RosterObj.php';
include_once 'classes/RosterAvgObj.php';
//include_once 'classes/RosterAvgObj.php';

$v = 'background-color:green;'; // Good Salary Cap
$o = 'background-color:orange;'; // Close Salary Cap
$r = 'background-color:red;color:white'; // Over Salary Cap
$dr = 'background-color:#8B0000;'; // Under Floor Salary Cap
?>

<div class = "container">
<div class="row no-gutters">
<div class = "col-sm-12 col-lg-10 offset-lg-1">

<div class="card">
	<?php include 'SectionHeader.php'?>
	<div class="card-body p-2 px-lg-4">

<div class="table-responsive">
<table class="table table-sm table-striped table-hover table-rounded">

<?php

$gmFile = getLeagueFile('GMs');

function isValidRoster(RostersHolder $rosters, PlayerVitalsHolder $vitals, int $rosterMin = 20): bool{
    
    $center = 0;
    $lw = 0;
    $rw = 0;
    $defense = 0;
    $goalie = 0;
    $total = 0;
    
    foreach($rosters->getProRosters() as $roster){
        if(empty($roster->getInjStatus())){
            
            $vital = $vitals->findVital($roster->getNumber(), $roster->getName());
            if($vital->getContractLength() > 0){
                if($roster->getPosition() == 'C') $center++;
                if($roster->getPosition() == 'RW') $rw++;
                if($roster->getPosition() == 'LW') $lw++;
                if($roster->getPosition() == 'D') $defense++;
                if($roster->getPosition() == 'G') $goalie++;
                $total++;
            }
        }
    }
    
    
    return $total >= $rosterMin && $center >= 3 && $rw >= 3 && $lw >= 3 && $defense >= 4 && $goalie >= 2 ;
    
    //return $center >= 3 && $rw >= 3 && $lw >= 3 && $defense >= 4 && $goalie >= 2 ;
}


if (file_exists($gmFile)) {
    
    $teams = new TeamHolder($gmFile);
    $rostersFile = getLeagueFile('Rosters');
    $vitalsFile = getLeagueFile('PlayerVitals');

    $length = count($teams->get_teams());
    for ($i = 0; $i < $length; $i++) {
        $rosters = new RostersHolder($rostersFile, $teams->get_teams()[$i], true);
        $vitals = new PlayerVitalsHolder($vitalsFile, $teams->get_teams()[$i]);
        $totalSalary = 0;
        $injurySalary = 0;
        $activeProCount = 0;
        foreach($rosters->getProRosters() as $roster){
            
//             if($roster->getInjStatus() == ''){
//                 $vital = $vitals->findVital($roster->getNumber(), $roster->getName());
//                 $totalSalary+=$vital->getSalary();
//             }
            $vital = $vitals->findVital($roster->getNumber(), $roster->getName());
            
            if($roster->getInjStatus() != 'HO' && $vital->getContractLength() > 0){
                $totalSalary+=$vital->getSalary();
                
                if($roster->getInjStatus() != ''){
                    $injurySalary+=$vital->getSalary();
                 
                }else{
                    $activeProCount += 1;
                }
              

            }
  
    
        }

        //$activePro[$i+1] = $rosters->getActivePro();
        $activePro[$i+1] = $activeProCount;
        //$rosterValid[$i+1] = $rosters->isValidRoster() ? 'YES' : 'NO';
        $rosterValid[$i+1] = isValidRoster($rosters,$vitals,MIN_ACTIVE_PLAYERS) ? 'YES' : 'NO';
        $teamSalary[$i+1] = $totalSalary;
        $teamInjurySalary[$i+1] = $injurySalary;
        $teamOvAvg[$i+1] = $rosters->getProAverages()->getAvgOv();

    }
    
    //get rosters from file
    
}else{
    die("Unable to find GM files");
}




$i = 0;

$Fnm = getLeagueFile('Injury');
if (file_exists($Fnm)) {
	$tableau = file($Fnm);
	foreach ($tableau as $cle => $val) {
		if(substr_count($val, 'A NAME')) {
			$i++;
			$blessure[$i] = '';
			$suspension[$i] = '';
		}
		//if(substr_count($val, 'Injured')) {
		if(substr_count($val, 'sidelined')) {
			//$blessure[$i] = $salaryCapYes;
			$blessure[$i] = substr_count($val, 'sidelined');
		}
		if(substr_count($val, 'suspended')) {
			//$suspension[$i] = $salaryCapYes;
			$suspension[$i] = substr_count($val, 'suspended');
		}
	}
}
else echo $allFileNotFound.' - '.$Fnm;
$rougeFloor = 0;
$rouge = 0;
$jaune = 0;
$vert = 0;
$i = 0;
$a = 0;
$c = 1;
$no = 0;
$nv = 0;
$nr = 0;
$nrFloor = 0;

$Fnm = getLeagueFile('Finance');
//$colspan = 8;
//if(CAP_MODE == 1) $colspan = 7;
$colspan = (CAP_INJ_MODE == 1) ? 10: 9;
if(CAP_MODE == 1) $colspan = (CAP_INJ_MODE == 1) ? 11 : 10;

if(file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = myEach($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, '<P>(As of')){
			$pos = strpos($val, ')');
			$pos = $pos - 10;
			$val = substr($val, 10, $pos);
			$leagueSalaryClose2 = SALARY_CAP - SALARY_CAP_WARN;
			$leagueSalaryCap_ca = number_format(SALARY_CAP, 0, ' ', ',');
			$leagueSalaryCap_ca2 = number_format(SALARY_CAP_FLOOR, 0, ' ', ',');
			$leagueSalaryClose_ca = number_format(SALARY_CAP_WARN, 0, ' ', ',');
			
			
			
			echo '<thead>';
			echo '<tr><th colspan="'.$colspan.'">'.$allLastUpdate.' '.$val.'<br>';
			echo $salaryCopSalaryCap.' '.$leagueSalaryCap_ca.'$<br>';
			echo $salaryCopFloor.' '.$leagueSalaryCap_ca2.'$<br>';
			echo $salaryCopNear.' '.$leagueSalaryClose_ca.'$ '.$salaryCopNearTo.' '.$leagueSalaryCap_ca.'$<br>';
			echo 'Minimum Active Pro Players: '.MIN_ACTIVE_PLAYERS.'';
            echo '</th></tr>';
			echo '<tr>
            <th class="text-left">'.$salaryCopTeam.'</th>
			<th class="text-right">'.$salaryCopProPayroll.'</th>';
			if(CAP_MODE == 1) echo '<th class="text-right">'.$salaryCopFarmPayroll.'</th>';
			echo '<th class="text-right">'.$salaryCopRemaining.'</th>';
       
			if(CAP_INJ_MODE == 1)
            echo '<th class="text-center">IR $</th>';
            
			echo '<th class="text-center">'.$salaryCopStatus.'</th>
			<th class="text-center">'.$salaryCopInjured.'</th>
			<th class="text-center">'.$salaryCopSuspended.'</th>
			<th class="text-center">Active</th>
			<th class="text-center">Valid Ros</th>
            <th class="text-center">OV Avg</th></tr>';
			echo '</thead>';
		}
		if(substr_count($val, 'A NAME')) {
			$pos = strpos($val, '</A>');
			$pos = $pos - 23;
			$equipe = substr($val, 23, $pos);
			$i++;
		}
		if(substr_count($val, '<TD>Pro Payroll</TD>')) {
			$pos = strpos($val, '</TD></TR>');
			$pos = $pos - 69;
			//$propayroll = substr($val, 69, $pos);
			//$propayroll2 = preg_replace('/\D/', '', $propayroll);
	
			if(CAP_INJ_MODE == 1){
			    $propayroll = $teamSalary[$i] - $teamInjurySalary[$i];
			    $propayroll2 = $propayroll;
			    $ltirSalary = $teamInjurySalary[$i];
			}else{
			    $propayroll = substr($val, 69, $pos);
			    $propayroll2 = preg_replace('/\D/', '', $propayroll);
			}
		}
		if(substr_count($val, '<TD>Farm Payroll</TD>')) {
			$pos = strpos($val, '</TD></TR>');
			$pos = $pos - 30;
			$farmpayroll = substr($val, 30, $pos);
			$farmpayroll2 = preg_replace('/\D/', '', $farmpayroll);

			if(CAP_MODE == 0) {
			    $restant = SALARY_CAP - $propayroll2;
				$salaryCap = $propayroll2;
			}
			if(CAP_MODE == 1) {
			    $restant = SALARY_CAP - ($propayroll2 + $farmpayroll2);
				$salaryCap = $farmpayroll2;
			}
			if(CAP_INJ_MODE == 1){
			    $restant = ($restant + $ltirSalary);
			}
			
			if($salaryCap < SALARY_CAP_FLOOR && SALARY_CAP_FLOOR != 0) {
				$nrFloor++;
				$b = $dr;
				$rougeFloor = $rougeFloor + $restant;
			}
			if($salaryCap <= SALARY_CAP_WARN && ($salaryCap >= SALARY_CAP_FLOOR || SALARY_CAP_FLOOR == 0)) {
				$nv++;
				$b = $v;
				$vert = $vert + $restant;
			}
			if($salaryCap >= SALARY_CAP_WARN && $salaryCap <= SALARY_CAP) {
				$no++;
				$b = $o;
				$jaune = $jaune + $restant;
			}
			if($salaryCap > SALARY_CAP) {
				$nr++;
				$b = $r;
				$rouge = $rouge + $restant;
			}

			$restant = number_format($restant, 0, ' ', ',');
			
			$z = '';
			//if(substr_count($equipe, $currentTeam)) $z = ' font-weight:bold;';
			
			//$activeStyle = (MIN_ACTIVE_PLAYERS > 0 && $activePro[$i] < MIN_ACTIVE_PLAYERS ) ? $r : '';
			$activeStyle = ''; 
			$rosterValidStyle = $rosterValid[$i] == 'NO' ? $r : '';
			
			if($c == 1) $c = 2;
			else $c = 1;
			echo '
			<tr><td class="text-left">'.$equipe.'</td>
			<td class="text-right">$'.number_format($propayroll2).'</td>';
			if(CAP_MODE == 1) echo '<td class="text-right">$'.$farmpayroll.'</td>';
			echo '<td class="text-right">$'.$restant.'</td>';
			
			if(CAP_INJ_MODE == 1) echo '<td><div class="text-right">$'.number_format($ltirSalary).'</td>';
	
	        echo '<td><div style="'.$b.'"><br></div></td>
			<td class="text-center">'.$blessure[$i].'</td>
			<td class="text-center">'.$suspension[$i].'</td>
		    <td class="text-center" style = "'.$activeStyle.'">'.$activePro[$i].'</td>
		    <td class="text-center" style = "'.$rosterValidStyle.'">'.$rosterValid[$i].'</td>
            <td class="text-center" style = "">'.$teamOvAvg[$i].'</td></tr>';
		}
	}
	$vert = number_format($vert, 0, '', ',');
	$jaune = number_format($jaune, 0, '', ',');
	$rouge = number_format($rouge, 0, '', ',');
	$rougeFloor = number_format($rougeFloor, 0, '', ',');
	echo '</table><br>
	<table class="table table-sm table-striped">
    <thead>
        <tr>
            <th>'.$salaryCopStatus.'</th>
            <th class="text-left">'.$salaryCopDesc.'</th>
            <th>'.$salaryCopNumber.'</th>
            <th class="text-right">'.$salaryCopRemaining.'</th>
        </tr>
    </thead>
	<tr><td><div style="'.$v.'"><br></div></td><td class="text-left">'.$salaryCopGoodSalaryCap.'</td><td>'.$nv.'</td><td class="text-right">'.$vert.'$</td></tr>
	<tr><td><div style="'.$o.'"><br></div></td><td class="text-left">'.$salaryCapNearSalaryCap.'</td><td>'.$no.'</td><td class="text-right">'.$jaune.'$</td></tr>
	<tr><td><div style="'.$r.'"><br></div></td><td class="text-left">'.$salaryCapOverSalaryCap.'</td><td>'.$nr.'</td><td class="text-right">'.$rouge.'$</td></tr>';
	if(SALARY_CAP_FLOOR != 0) echo '<tr class="hover1"><td><div style="'.$dr.'"><br></div></td><td class="text-left">'.$salaryCopFloorUnder.'</td><td>'.$nrFloor.'</td><td class="text-right">'.$rougeFloor.'$</td></tr>';
	echo '</table>';
}
else echo '</table>'.$allFileNotFound.' - '.$Fnm;
?>
</div>
</div>
</div>
</div>
</div>
</div>
<?php include 'footer.php'; ?>