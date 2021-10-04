<?php
require_once 'config.php';
include_once FS_ROOT.'lang.php';
include_once FS_ROOT.'common.php';
?>

<div class="row">

<?php

include 'phpGetAbbr.php'; // Output $TSabbr
if(!function_exists('firstNumber')) {
	function firstNumber($string) {
		$count = strlen($string);
		$start = 0;
		for($j=0;$j<$count;$j++) {
			if( ctype_digit($string[$j]) ) {
				$start = $j;
				break 1;
			}
		}
		return substr($string, $start);
	}
}

$playoff = isPlayoffs($folder, $playoffMode);
if($playoff == 1) {
	$playoff = 'PLF';
}

$Fnm = getLeagueFile($folder, $playoff, 'Individual.html', 'Individual');
$a = 0;
$c = 1;
$i = 0;

if(isset($goalj)) unset($goalj);
if(isset($spj)) unset($spj);


if (file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = myEach($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, '<BR>') && !substr_count($val, '(') && !substr_count($val, '<BR><BR>')) {
			$a++;
		}
		// Save %
		if($a == 33 && $i < 5) {
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
		// Points Recrue
		if($a == 29 && $i == 0) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$rkj[$i] = substr($val, 1, $pos-1);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$rke[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$rkm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$rkg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$rkg[$i] =  substr($rkg[$i], strrpos($rkg[$i], '-')+1);
			$i++;
		}
		// Points D
		if($a == 27 && $i == 0) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$dfj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$dfe[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$dfm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$dfg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$dfg[$i] =  substr($dfg[$i], strrpos($dfg[$i], '-')+1);
			$i++;
		}
		// Points AD
		if($a == 25 && $i == 0) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$adj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$ade[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$adm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$adg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$adg[$i] =  substr($adg[$i], strrpos($adg[$i], '-')+1);
			$i++;
		}
		// Points AG
		if($a == 23 && $i == 0) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$agj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$age[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$agm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$agg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$agg[$i] =  substr($agg[$i], strrpos($agg[$i], '-')+1);
			$i++;
		}
		// Points Centre
		if($a == 21 && $i == 0) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$cej[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$cee[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$cem[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$ceg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$ceg[$i] =  substr($ceg[$i], strrpos($ceg[$i], '-')+1);
			$i++;
		}
		// Buts
		if($a == 1 && $i < 5) {
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
	
	if(!empty($goalj)){
	    $i = 0;
	    echo '<div class = "col">
    	<div class="tableau-top text-center">'.$top5Goals.'</div>
    	<table class="table table-sm table-striped table-rounded-bottom">
        <thead>
    	<tr>
    	<th>NAME</th>
    	<th>'.$individualTM.'</th>
    	<th>'.$individualG.'</th>
    	</tr>
        </thead>
        <tbody>';
    	    for($i=0;$i<count($goalj);$i++){
    	        if($c == 1) $c = 2;
    	        else $c = 1;
    	        $bold = '';
    	        if(isset($TSabbr) && $goale[$i] == $TSabbr) $bold = 'font-weight:bold;';
    	        echo '
    		<tr class="hover'.$c.'">
    		<td style="'.$bold.'">'.$goalj[$i].'</td>
    		<td style="text-align:right;'.$bold.'">'.$goale[$i].'</td>
    		<td style="text-align:right;'.$bold.'">'.$goalg[$i].'</td>
    		</tr>';
    	    }
    	    echo '</tbody></table></div>';
    	    
    	    echo '<div class = "col">
    	<div class="tableau-top text-center">'.$top5Points.'</div>
    	<table class="table table-sm table-striped table-rounded-bottom">
        <thead>
    	<tr>
    	<th>P</th>
    	<th>NAME</th>
    	<th>'.$individualTM.'</th>
    	<th>'.$top5Pts.'</th>
    	</tr>
        </thead>
    	<tbody>';
    	    
    	    
    	    echo '
    	<tr class="hover2">
    	<td>C</td>
    	<td>'.$cej[0].'</td>
    	<td style="text-align:right;">'.$cee[0].'</td>
    	<td style="text-align:right;">'.$ceg[0].'</td>
    	</tr>';
    	    echo '
    	<tr class="hover1">
    	<td>'.$top5LW.'</td>
    	<td>'.$agj[0].'</td>
    	<td style="text-align:right;">'.$age[0].'</td>
    	<td style="text-align:right;">'.$agg[0].'</td>
    	</tr>';
    	    echo '
    	<tr class="hover2">
    	<td>'.$top5RW.'</td>
    	<td>'.$adj[0].'</td>
    	<td style="text-align:right;">'.$ade[0].'</td>
    	<td style="text-align:right;">'.$adg[0].'</td>
    	</tr>';
    	    echo '
    	<tr class="hover1">
    	<td>D</td>
    	<td>'.$dfj[0].'</td>
    	<td style="text-align:right;">'.$dfe[0].'</td>
    	<td style="text-align:right;">'.$dfg[0].'</td>
    	</tr>';
    	    echo '
    	<tr class="hover2">
    	<td>*</td>
    	<td>'.$rkj[0].'</td>
    	<td style="text-align:right;">'.$rke[0].'</td>
    	<td style="text-align:right;">'.$rkg[0].'</td>
    	</tr>';
    	    
    	    echo '</tbody></table></div>';
    	    
    	    $c = 1;
    	    $i = 0;
    	    echo '<div class = "col">
    	<div class="tableau-top text-center">'.$top5SavePct.'</div>
    	<table class="table table-sm table-striped table-rounded-bottom">
        <thead>
    	<tr>
    	<th>NAME</th>
    	<th>'.$individualTM.'</th>
    	<th>%</th>
    	</tr>
        </thead>
        <tbody>';
    	    for($i=0;$i<count($spj);$i++){
    	        if($c == 1) $c = 2;
    	        else $c = 1;
    	        $bold = '';
    	        if(isset($TSabbr) && $spe[$i] == $TSabbr) $bold = 'font-weight:bold;';
    	        echo '
    	<tr class="hover'.$c.'">
    	<td style="'.$bold.'">'.$spj[$i].'</td>
    	<td style="'.$bold.'">'.$spe[$i].'</td>
    	<td style="'.$bold.'">'.$spg[$i].'</td>
    	</tr>';
	    }
	    echo '</tbody></table></div>';
	}else{
	    echo '<div class = "col">';
	    echo '<h5>No Games</h5>';
	    echo '</div>';
	}
	
    
	
	
}
else{
    echo $allFileNotFound.' - '.$Fnm;
}

echo '<div style="clear:both"></div></div>';
?>