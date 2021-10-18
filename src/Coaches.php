<?php
require_once 'config.php';
include 'lang.php';
$CurrentHTML = 'Coaches';
$CurrentTitle = $CoachesTitle;
$CurrentPage = 'Coaches';
include 'head.php';

?>

<div class="container">
<div class="row no-gutters">
<div class="col-sm-12 col-md-10 offset-md-1 col-lg-6 offset-lg-3"> 	
<div class="card">
	<?php include 'SectionHeader.php';?>
	<div class="card-body p-2 px-lg-4">

<?php

$fileName = getLeagueFile($folder, $playoff, 'Coaches.html', 'Coaches');

$a = 0;
$c = 1;
$lastUpdated = '';
if(file_exists($fileName)) {
    $tableau = file($fileName);
	while(list($cle,$val) = myEach($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, '<P>(As of')){
			$pos = strpos($val, ')');
			$pos = $pos - 10;
			$val = substr($val, 10, $pos);
			$lastUpdated = $val;
	
			echo '<div class="table-responsive">';
			echo '<table id ="coachTable" class="table table-sm table-striped table-hover text-center table-rounded">';
		}
		if($a == 1 && substr_count($val, '(')) {
			$reste = trim($val);
			$coachName = substr($reste, 0, strpos($reste, '(')-1);
			$reste = trim(substr($reste, strpos($reste, '(')+1));
			$coachTeam = substr($reste, 0, strpos($reste, ')'));
			$reste = trim(substr($reste, strpos($reste, ')')+1));
			$coachOf = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$coachDf = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$coachEx = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$coachLd = substr($reste, 0, 2);
			$reste = trim(substr($reste, 2));
			$coachSalary = $reste;
		
			if($coachTeam == 'Available') $coachTeam = str_replace('Available', $CoachesAvailable, $coachTeam);

			if($c == 1) $c = 2;
			else $c =  1; 
			echo '
			<tr>
    			<td class="text-left">'.$coachName.'</td>
    			<td class="text-left">'.$coachTeam.'</td>
    			<td>'.$coachOf.'</td>
    			<td>'.$coachDf.'</td>
    			<td>'.$coachEx.'</td>
    			<td>'.$coachLd.'</td>
    			<td>$'.$coachSalary.'</td>
			</tr>';
		}
		if(substr_count($val, '                                   ')) {
			echo '
            <thead>
			<tr>
			<th class="text-left">'.$CoachesName.'</th>
			<th class="text-left">'.$CoachesTeam.'</th>
			<th data-toggle="tooltip" data-placement="top" title="'.$CoachesOff.'">OF</th>
			<th data-toggle="tooltip" data-placement="top" title="'.$CoachesDef.'">DF</th>
			<th data-toggle="tooltip" data-placement="top" title="'.$CoachesExp.'">EX</th>
			<th data-toggle="tooltip" data-placement="top" title="'.$CoachesLead.'">LD</th>
			<th>'.$CoachesSalary.'</th>
			</tr>
            </thead>
			<tbody>';
			$a = 1;
		}
	}
}
else echo '<tr><td>'.$allFileNotFound.' - '.$Fnm.'</td></tr>';

echo '</tbody></table></div>

<h5 class = "text-center">'.$allLastUpdate.' '.$lastUpdated.'</h5>
			    
';
?>
</div></div></div></div></div>

<script>

$(document).ready(function() 
	    { 
	        $("#coachTable").tablesorter({ 
	            sortInitialOrder: 'desc'
	    	}); 

	    } 
	); 

// $(document).ready(function() {  
//     $(function () {
//         $("body").tooltip({
//             selector: '[data-toggle="tooltip"]',
//             container: 'body',
//             trigger: 'hover focus',
//             delay:{hide:0}
//         });
//     })
// });

</script>

<?php include 'footer.php'; ?>