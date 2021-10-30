<?php
require_once 'config.php';
include 'lang.php';
include 'fileUtils.php';

$CurrentHTML = 'Individual.php';
$CurrentTitle = $individualTitle;
$CurrentPage = 'Individual';
include 'head.php';
?>


<div class="container px-0">

<div class="card">

	<?php include 'SectionHeader.php';?>
	
	<div class="card-body p-1">

<?php
function firstNumber($string) {
	$count = strlen($string);
	$start = 0;
	for($j=0;$j<$count;$j++) {
		if( ctype_digit($string[$j]) ) {
			$start = $j;
			$j = 1000;
		}
	}
	return substr($string, $start);
}

$Fnm = getLeagueFile('Individual');

$a = 0;
$c = 1;
$i = 0;
$lastUpdated = '';
if (file_exists($Fnm)) {
	$tableau = file($Fnm);

	foreach ($tableau as $cle => $val) {
		$val = utf8_encode($val);
		if(substr_count($val, '<P>(As of')){
			$pos = strpos($val, ')');
			$pos = $pos - 10;
			$val = substr($val, 10, $pos);
			$lastUpdated = $val;

		}
		if(substr_count($val, '<BR>') && !substr_count($val, '(') && !substr_count($val, '<BR><BR>')) {
			$a++;
		}
		if($a == 45) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$spj2[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$spe2[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$spm2[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$spg2[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 43) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$gaj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$gae[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$gam[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$gag[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 41) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$gmj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$gme[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$gmm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$gmg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 39) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$rcj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$rce[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$rcm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$rcg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 37) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$mjj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$mje[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$mjm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$mjg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 35) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$blj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$ble[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$blm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$blg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 33) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$spj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos;
			$spe[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$spm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$spg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 31) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$htj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$hte[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$htm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$htg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 29) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$rkj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$rke[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$rkm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$rkg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 27) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$dfj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$dfe[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$dfm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$dfg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 25) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$adj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$ade[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$adm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$adg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 23) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$agj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$age[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$agm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$agg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 21) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$cej[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$cee[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$cem[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$ceg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 19) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$psj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$pse[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$psm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$psg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' '),-4));
			$i++;
		}
		if($a == 17) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$gsj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$gse[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$gsm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$gsg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' '),-4));
			$i++;
		}
		if($a == 15) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$pmj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$pme[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$pmm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$pmt[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 13) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$pimj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$pime[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$pimm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$pimt[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 11) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$shotj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$shote[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$shotm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$shott[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 9) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$shpj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$shpe[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$shpm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$shpp[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 7) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$shgj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$shge[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$shgm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$shgg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 5) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$ppgj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$ppge[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$ppgm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$ppgg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 3) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$assistj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$assiste[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$assistm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$assista[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 1) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$goalj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$goale[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$goalm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$goalg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if(substr_count($val, '<PRE>') && !substr_count($val, '<TD>')){
			$a++;
			$i = 0;
		}
	}

$i = 0;
echo '<div class = "row">';
	echo '<div class = "col-sm-12 col-md-4 offset-md-2">
	<div class="tableau-top text-center">'.$individualGoals.'</div>
	<div class = "table-responsive">
	<table class="table table-sm table-striped text-center table-rounded-bottom">
    <thead>
	<tr>
	<th></td>
	<th>'.$individualTM.'</th>
	<th>'.$individualGP.'</th>
	<th>'.$individualG.'</th>
	</tr>
    </thead>
    <tbody>';
	
	if(isset($goalj)) {
	for($i=0;$i<count($goalj);$i++){
		echo '
		<tr>
		<td class="text-left">'.$goalj[$i].'</td>
		<td>'.$goale[$i].'</td>
		<td>'.$goalm[$i].'</td>
		<td>'.$goalg[$i].'</td>
		</tr>';
	}
	}
	echo '</tbody></table></div></div>';

	$c = 1;
	$i = 0;
	echo '<div class = "col-sm-12 col-md-4">
    <div class="tableau-top text-center">'.$individualGSS.'</div>
	<div class = "table-responsive">
	<table class="table table-sm table-striped text-center table-rounded-bottom">
    <thead>
	<tr>
	<th></td>
	<th>'.$individualTM.'</th>
	<th>'.$individualGP.'</th>
	<th>'.$individualStreak.'</th>
	</tr>
    </thead>
    <tbody>';
	if(isset($gsj)) {
	for($i=0;$i<count($gsj);$i++){
		echo '
		<tr>
		<td class="text-left">'.$gsj[$i].'</td>
		<td>'.$gse[$i].'</td>
		<td>'.$gsm[$i].'</td>
		<td>'.$gsg[$i].'</td>
		</tr>';
	}
	}
	echo '</tbody></table></div></div>';
echo '</div>';

$c = 1;
$i = 0;

echo '<div class = "row">';
	echo '<div class = "col-sm-12 col-md-4 offset-md-2">
    <div class="tableau-top text-center">'.$individualAssists.'</div>
	<div class = "table-responsive">
	<table class="table table-sm table-striped text-center table-rounded-bottom">
    <thead>
	<tr>
	<th></td>
	<th>'.$individualTM.'</th>
	<th>'.$individualGP.'</th>
	<th>'.$individualA.'</th>
	</tr>
    </thead>
    <tbody>';
	if(isset($assistj)) {
	for($i=0;$i<count($assistj);$i++){
		echo '
		<tr>
		<td class="text-left">'.$assistj[$i].'</td>
		<td>'.$assiste[$i].'</td>
		<td>'.$assistm[$i].'</td>
		<td>'.$assista[$i].'</td>
		</tr>';
	}
	}
	echo '</tbody></table></div></div>';

	$c = 1;
	$i = 0;
	
	echo '<div class = "col-sm-12 col-md-4">
    <div class="tableau-top text-center">'.$individualPSS.'</div>
	<div class = "table-responsive">';
	echo '<table class="table table-sm table-striped text-center table-rounded-bottom">
	<thead>
	<tr>
	<th></td>
	<th>'.$individualTM.'</th>
	<th>'.$individualGP.'</th>
	<th>'.$individualStreak.'</th>
	</tr>
	</thead>
    <tbody>';
	
	if(isset($psj)) {
	for($i=0;$i<count($psj);$i++){
		echo '
		<tr>
		<td class="text-left">'.$psj[$i].'</td>
		<td>'.$pse[$i].'</td>
		<td>'.$psm[$i].'</td>
		<td>'.$psg[$i].'</td>
		</tr>';
	}
	}
	echo '</table></div></div>';
echo '</div>';

$c = 1;
$i = 0;

echo '<div class = "row">';

	echo '<div class = "col-sm-12 col-md-4 offset-md-2">
    <div class="tableau-top text-center">'.$individualPPG.'</div>
	<div class = "table-responsive">';
	echo '<table class="table table-sm table-striped text-center table-rounded-bottom">
	<thead>
	<tr>
	<th></td>
	<th>'.$individualTM.'</th>
	<th>'.$individualGP.'</th>
	<th>'.$individualG.'</th>
	</tr>
	</thead>
    <tbody>';
	
	if(isset($ppgj)) {
	for($i=0;$i<count($ppgj);$i++){
		echo '
		<tr>
		<td class="text-left">'.$ppgj[$i].'</td>
		<td>'.$ppge[$i].'</td>
		<td>'.$ppgm[$i].'</td>
		<td>'.$ppgg[$i].'</td>
		</tr>';
	}
	}
	echo '</tbody></table></div></div>';

	echo '<div class = "col-sm-12 col-md-4">
    <div class="tableau-top text-center">'.$individualC.'</div>
	<div class = "table-responsive">';
	echo '<table class="table table-sm table-striped text-center table-rounded-bottom">
	<thead>
	<tr>
	<th></td>
	<th>'.$individualTM.'</th>
	<th>'.$individualGP.'</th>
	<th>'.$individualPts.'</th>
	</tr>
	</thead>
    <tbody>';
	
	if(isset($cej)) {
	for($i=0;$i<count($cej);$i++){
		if(isset($TSabbr) && substr_count($cee[$i], $TSabbr)) $bold = 'font-weight:bold;';
		echo '
		<tr>
		<td class="text-left">'.$cej[$i].'</td>
		<td>'.$cee[$i].'</td>
		<td>'.$cem[$i].'</td>
		<td>'.$ceg[$i].'</td>
		</tr>';
	}
	}
	echo '</tbody></table></div></div>';
echo '</div>';


echo '<div class = "row">';

    echo '<div class = "col-sm-12 col-md-4 offset-md-2">
        <div class="tableau-top text-center">'.$individualSHG.'</div>
    	<div class = "table-responsive">';
    echo '<table class="table table-sm table-striped text-center table-rounded-bottom">
    	<thead>
    	<tr>
    	<th></td>
    	<th>'.$individualTM.'</th>
    	<th>'.$individualGP.'</th>
    	<th>'.$individualG.'</th>
    	</tr>
    	</thead>
        <tbody>';

    if(isset($shgj)) {
    for($i=0;$i<count($shgj);$i++){
    	echo '
    	<tr>
    	<td class="text-left">'.$shgj[$i].'</td>
    	<td>'.$shge[$i].'</td>
    	<td>'.$shgm[$i].'</td>
    	<td>'.$shgg[$i].'</td>
    	</tr>';
    }
    }
    echo '</tbody></table></div></div>';

    $c = 1;
    $i = 0;
    
    echo '<div class = "col-sm-12 col-md-4">
        <div class="tableau-top text-center">'.$individualLW.'</div>
    	<div class = "table-responsive">';
    echo '<table class="table table-sm table-striped text-center table-rounded-bottom">
    	<thead>
    	<tr>
    	<th></td>
    	<th>'.$individualTM.'</th>
    	<th>'.$individualGP.'</th>
    	<th>'.$individualPts.'</th>
    	</tr>
    	</thead>
        <tbody>';
    
    if(isset($agj)) {
    for($i=0;$i<count($agj);$i++){
    	echo '
    	<tr>
    	<td class="text-left">'.$agj[$i].'</td>
    	<td >'.$age[$i].'</td>
    	<td >'.$agm[$i].'</td>
    	<td >'.$agg[$i].'</td>
    	</tr>';
    }
    }
    echo '</tbody></table></div></div>';
echo '</div>';


echo '<div class = "row">';

echo '<div class = "col-sm-12 col-md-4 offset-md-2">
        <div class="tableau-top text-center">'.$individualSP.'</div>
    	<div class = "table-responsive">';
echo '<table class="table table-sm table-striped text-center table-rounded-bottom">
    	<thead>
    	<tr>
    	<th></td>
    	<th>'.$individualTM.'</th>
    	<th>'.$individualGP.'</th>
    	<th>%</th>
    	</tr>
    	</thead>
        <tbody>';

    if(isset($shpj)) {
    for($i=0;$i<count($shpj);$i++){
    	echo '
    	<tr>
    	<td class="text-left">'.$shpj[$i].'</td>
    	<td>'.$shpe[$i].'</td>
    	<td>'.$shpm[$i].'</td>
    	<td>'.$shpp[$i].'</td>
    	</tr>';
    }
    }
    echo '</tbody></table></div></div>';
    
    
    echo '<div class = "col-sm-12 col-md-4">
        <div class="tableau-top text-center">'.$individualRW.'</div>
    	<div class = "table-responsive">';
    echo '<table class="table table-sm table-striped text-center table-rounded-bottom">
    	<thead>
    	<tr>
    	<th></td>
    	<th>'.$individualTM.'</th>
    	<th>'.$individualGP.'</th>
    	<th>'.$individualPts.'</th>
    	</tr>
    	</thead>
        <tbody>';

    if(isset($adj)) {
    for($i=0;$i<count($adj);$i++){
        echo '
    	<tr>
    	<td class="text-left">'.$adj[$i].'</td>
    	<td >'.$ade[$i].'</td>
    	<td >'.$adm[$i].'</td>
    	<td >'.$adg[$i].'</td>
    	</tr>';
    }
    }
    echo '</tbody></table></div></div>';
echo '</div>';

echo '<div class = "row">';

    echo '<div class = "col-sm-12 col-md-4 offset-md-2">
            <div class="tableau-top text-center">'.$individualShots.'</div>
        	<div class = "table-responsive">';
    echo '<table class="table table-sm table-striped text-center table-rounded-bottom">
        	<thead>
        	<tr>
        	<th></td>
        	<th>'.$individualTM.'</th>
        	<th>'.$individualGP.'</th>
        	<th>'.$individualShots.'</th>
        	</tr>
        	</thead>
            <tbody>';

    if(isset($shotj)) {
    for($i=0;$i<count($shotj);$i++){
    	echo '
    	<tr class="hover'.$c.'">
        <td class="text-left">'.$shotj[$i].'</td>
    	<td >'.$shote[$i].'</td>
    	<td >'.$shotm[$i].'</td>
    	<td >'.$shott[$i].'</td>
    	</tr>';
    }
    }
    echo '</tbody></table></div></div>';
    
    echo '<div class = "col-sm-12 col-md-4">
            <div class="tableau-top text-center">'.$individualD.'</div>
        	<div class = "table-responsive">';
    echo '<table class="table table-sm table-striped text-center table-rounded-bottom">
        	<thead>
        	<tr>
        	<th></td>
        	<th>'.$individualTM.'</th>
        	<th>'.$individualGP.'</th>
        	<th>'.$individualPts.'</th>
        	</tr>
        	</thead>
            <tbody>';

    if(isset($dfj)) {
    for($i=0;$i<count($dfj);$i++){

    	echo '
    	<tr>
    	<td class="text-left">'.$dfj[$i].'</td>
    	<td>'.$dfe[$i].'</td>
    	<td>'.$dfm[$i].'</td>
    	<td>'.$dfg[$i].'</td>
    	</tr>';
    }
    }
    echo '</tbody></table></div></div>';
echo '</div>';


echo '<div class = "row">';

    echo '<div class = "col-sm-12 col-md-4 offset-md-2">
                <div class="tableau-top text-center">'.$individualPM.'</div>
            	<div class = "table-responsive">';
    echo '<table class="table table-sm table-striped text-center table-rounded-bottom">
            	<thead>
            	<tr>
            	<th></td>
            	<th>'.$individualTM.'</th>
            	<th>'.$individualGP.'</th>
            	<th>'.$individualPIM.'</th>
            	</tr>
            	</thead>
                <tbody>';

    if(isset($pimj)) {
    for($i=0;$i<count($pimj);$i++){
    	echo '
    	<tr>
    	<td class="text-left">'.$pimj[$i].'</td>
    	<td >'.$pime[$i].'</td>
    	<td >'.$pimm[$i].'</td>
    	<td >'.$pimt[$i].'</td>
    	</tr>';
    }
    }
    echo '</tbody></table></div></div>';

    echo '<div class = "col-sm-12 col-md-4">
                <div class="tableau-top text-center">'.$individualRookies.'</div>
            	<div class = "table-responsive">';
    echo '<table class="table table-sm table-striped text-center table-rounded-bottom">
            	<thead>
            	<tr>
            	<th></td>
            	<th>'.$individualTM.'</th>
            	<th>'.$individualGP.'</th>
            	<th>'.$individualPts.'</th>
            	</tr>
            	</thead>
                <tbody>';

    if(isset($rkj)) {
    for($i=0;$i<count($rkj);$i++){
    	echo '
    	<tr>
    	<td class="text-left">'.$rkj[$i].'</td>
    	<td >'.$rke[$i].'</td>
    	<td >'.$rkm[$i].'</td>
    	<td >'.$rkg[$i].'</td>
    	</tr>';
    }
    }
    echo '</tbody></table></div></div>';
echo '</div>';
    

echo '<div class = "row">';

    echo '<div class = "col-sm-12 col-md-4 offset-md-2">
                    <div class="tableau-top text-center">+/-</div>
                	<div class = "table-responsive">';
    echo '<table class="table table-sm table-striped text-center table-rounded-bottom">
                	<thead>
                	<tr>
                	<th></td>
                	<th>'.$individualTM.'</th>
                	<th>'.$individualGP.'</th>
                	<th>+/-</th>
                	</tr>
                	</thead>
                    <tbody>';

    if(isset($pmj)) {
    for($i=0;$i<count($pmj);$i++){
    	if($c == 1) $c = 2;
    	else $c = 1;
    	$bold = '';
    	if(isset($TSabbr) && substr_count($pme[$i], $TSabbr)) $bold = 'font-weight:bold;';
    	echo '
    	<tr>
    	<td class="text-left">'.$pmj[$i].'</td>
    	<td>'.$pme[$i].'</td>
    	<td>'.$pmm[$i].'</td>
    	<td>'.$pmt[$i].'</td>
    	</tr>';
    }
    }
    echo '</tbody></table></div></div>';
    
    echo '<div class = "col-sm-12 col-md-4">
                    <div class="tableau-top text-center">'.$individualHT.'</div>
                	<div class = "table-responsive">';
    echo '<table class="table table-sm table-striped text-center table-rounded-bottom">
                	<thead>
                	<tr>
                	<th></td>
                	<th>'.$individualTM.'</th>
                	<th>'.$individualGP.'</th>
                	<th>'.$individualHTm.'</th>
                	</tr>
                	</thead>
                    <tbody>';

    if(isset($htj)) {
    for($i=0;$i<count($htj);$i++){
    	if($c == 1) $c = 2;
    	else $c = 1;
    	$bold = '';
    	if(isset($TSabbr) && substr_count($hte[$i], $TSabbr)) $bold = 'font-weight:bold;';
    	echo '
    	<tr>
    	<td class="text-left">'.$htj[$i].'</td>
    	<td>'.$hte[$i].'</td>
    	<td>'.$htm[$i].'</td>
    	<td>'.$htg[$i].'</td>
    	</tr>';
    }
    }
    echo '</tbody></table></div></div>';
echo '</div>';

echo '<div class = "row">';

    echo '<div class = "col-sm-12 col-md-4 offset-md-2">
                        <div class="tableau-top text-center">'.$individualSPG.'</div>
                    	<div class = "table-responsive">';
    echo '<table class="table table-sm table-striped text-center table-rounded-bottom">
                    	<thead>
                    	<tr>
                    	<th></td>
                    	<th>'.$individualTM.'</th>
                    	<th>'.$individualGP.'</th>
                    	<th>%</th>
                    	</tr>
                    	</thead>
                        <tbody>';

    if(isset($spj)) {
    for($i=0;$i<count($spj);$i++){
    	echo '
    	<tr>
    	<td class="text-left">'.$spj[$i].'</td>
    	<td>'.$spe[$i].'</td>
    	<td>'.$spm[$i].'</td>
    	<td>'.$spg[$i].'</td>
    	</tr>';
    }
    }
    echo '</tbody></table></div></div>';
    
    
    echo '<div class = "col-sm-12 col-md-4">
                        <div class="tableau-top text-center">'.$individualRec.'</div>
                    	<div class = "table-responsive">';
    echo '<table class="table table-sm table-striped text-center table-rounded-bottom">
                    	<thead>
                    	<tr>
                    	<th></td>
                    	<th>'.$individualTM.'</th>
                    	<th>'.$individualGP.'</th>
                    	<th>REC</th>
                    	</tr>
                    	</thead>
                        <tbody>';

    if(isset($rcj)) {
    for($i=0;$i<count($rcj);$i++){
    	echo '
    	<tr>
    	<td class="text-left">'.$rcj[$i].'</td>
    	<td>'.$rce[$i].'</td>
    	<td>'.$rcm[$i].'</td>
    	<td>'.$rcg[$i].'</td>
    	</tr>';
    }
    }
    echo '</tbody></table></div></div>';
echo '</div>';

echo '<div class = "row">';

    echo '<div class = "col-sm-12 col-md-4 offset-md-2">
                            <div class="tableau-top text-center">'.$individualSO.'</div>
                        	<div class = "table-responsive">';
    echo '<table class="table table-sm table-striped text-center table-rounded-bottom">
                        	<thead>
                        	<tr>
                        	<th></td>
                        	<th>'.$individualTM.'</th>
                        	<th>'.$individualGP.'</th>
                        	<th>'.$individualSOm.'</th>
                        	</tr>
                        	</thead>
                            <tbody>';

    if(isset($blj)) {
    for($i=0;$i<count($blj);$i++){
    	echo '
    	<tr>
    	<td class="text-left">'.$blj[$i].'</td>
    	<td>'.$ble[$i].'</td>
    	<td>'.$blm[$i].'</td>
    	<td>'.$blg[$i].'</td>
    	</tr>';
    }
    }
    echo '</tbody></table></div></div>';
    
    echo '<div class = "col-sm-12 col-md-4">
                            <div class="tableau-top text-center">'.$individualPM.'</div>
                        	<div class = "table-responsive">';
    echo '<table class="table table-sm table-striped text-center table-rounded-bottom">
                        	<thead>
                        	<tr>
                        	<th></td>
                        	<th>'.$individualTM.'</th>
                        	<th>'.$individualGP.'</th>
                        	<th>'.$individualPIM.'</th>
                        	</tr>
                        	</thead>
                            <tbody>';

    if(isset($gmj)) {
    for($i=0;$i<count($gmj);$i++){
    	echo '
    	<tr>
    	<td class="text-left">'.$gmj[$i].'</td>
    	<td>'.$gme[$i].'</td>
    	<td>'.$gmm[$i].'</td>
    	<td>'.$gmg[$i].'</td>
    	</tr>';
    }
    }
    echo '</tbody></table></div></div>';
echo '</div>';


echo '<div class = "row">';

    echo '<div class = "col-sm-12 col-md-4 offset-md-2">
                                <div class="tableau-top text-center">'.$individualMP.'</div>
                            	<div class = "table-responsive">';
    echo '<table class="table table-sm table-striped text-center table-rounded-bottom">
                            	<thead>
                            	<tr>
                            	<th></td>
                            	<th>'.$individualTM.'</th>
                            	<th>'.$individualGP.'</th>
                            	<th>MIN</th>
                            	</tr>
                            	</thead>
                                <tbody>';
        
    if(isset($mjj)) {
    for($i=0;$i<count($mjj);$i++){
    	echo '
    	<tr>
    	<td class="text-left">'.$mjj[$i].'</td>
    	<td>'.$mje[$i].'</td>
    	<td>'.$mjm[$i].'</td>
    	<td>'.$mjg[$i].'</td>
    	</tr>';
    }
    }
    echo '</tbody></table></div></div>';
    
    echo '<div class = "col-sm-12 col-md-4">
    <div class="tableau-top text-center">'.$individualAssists.'</div>
	<div class = "table-responsive">';
    echo '<table class="table table-sm table-striped text-center table-rounded-bottom">
                            	<thead>
                            	<tr>
                            	<th></td>
                            	<th>'.$individualTM.'</th>
                            	<th>'.$individualGP.'</th>
                            	<th>'.$individualA.'</th>
                            	</tr>
                            	</thead>
                                <tbody>';

    if(isset($gaj)) {
    for($i=0;$i<count($gaj);$i++){
    	echo '
    	<tr>
    	<td class="text-left">'.$gaj[$i].'</td>
    	<td>'.$gae[$i].'</td>
    	<td>'.$gam[$i].'</td>
    	<td>'.$gag[$i].'</td>
    	</tr>';
    }
    }
    echo '</tbody></table></div></div>';
echo '</div>';

echo '<div class = "row">';

    echo '<div class = "col-sm-12 col-md-4 offset-md-2">
                                    <div class="tableau-top text-center">'.$individualStar.'</div>
                                	<div class = "table-responsive">';
    echo '<table class="table table-sm table-striped text-center table-rounded-bottom">
                                	<thead>
                                	<tr>
                                	<th></td>
                                	<th>'.$individualTM.'</th>
                                	<th>'.$individualGP.'</th>
                                	<th>SP</th>
                                	</tr>
                                	</thead>
                                    <tbody>';

    if(isset($spj2)) {
    for($i=0;$i<count($spj2);$i++){
    	echo '
    	<tr>
    	<td class="text-left">'.$spj2[$i].'</td>
    	<td>'.$spe2[$i].'</td>
    	<td>'.$spm2[$i].'</td>
    	<td>'.$spg2[$i].'</td>
    	</tr>';
    }
    }
    echo '</tbody></table></div></div>';
echo '</div>';
    
    
    
echo '<h6 class = "text-center">'.$allLastUpdate.' '.$lastUpdated.'</h6>';


}
else  echo '<h5 class = "text-center">'. $allFileNotFound.' - '.$Fnm.'</h5>';

?>

</div>
</div>
</div>

<?php include 'footer.php'; ?>