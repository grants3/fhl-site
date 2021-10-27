
<!-- <div class="col"> -->
<div class = "table-responsive scrollable-table">
<table id ="miniStandings" class="table table-sm table-striped tableFixHead table-rounded text-center">

<?php
require_once __DIR__.'/../config.php';

include FS_ROOT.'assets.php';

//default these so warnings are not throw. clean this up
$playoff = '';
$farm = '';
$shootoutMode = false;

$Fnm =  getCurrentLeagueFile('Standings','Farm');

$c = 1;
$d = 0;
$e = 0;

if(file_exists($Fnm)) {
	$tableau = file($Fnm);
	
	//determine shootout mode.
	foreach($tableau as $line)
	{
	    if(strpos($line, 'W  L OT') !== false){
	        $shootoutMode = true;
	        break;
	    }
	    
	}
	
	
	while(list($cle,$val) = myEach($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, '<P>(As of')){
			$pos = strpos($val, ')');
			$pos = $pos - 10;
			$val2 = substr($val, 10, $pos);
		}
		if(substr_count($val, 'STK') && (substr_count($val, 'OL') || substr_count($val, 'OTL'))) {
			$e = 1;
		}
		if($d == 0 && substr_count($val, 'Conference</H3>') && !substr_count($val, '<H3>By Conference</H3>')) {
			$d = 0;
			$b = 0;
		}
		if(substr_count($val, 'Conference</H3>') && !substr_count($val, '<H3>By Conference</H3>')) {
			$b = 0;
		}
		if(substr_count($val, '<H3>By Division</H3>')) {
			break 1;
		}
		if(substr_count($val, 'HREF=')) {
			$reste = trim($val);
			if(substr_count($reste, 'WIDTH')) {
				$reste = substr($reste, strpos($reste, '<A '));
			}
			$serie[$d] = '';

			$serie[$d] = substr($reste, 0, strpos($reste, '<'));
			$reste = trim(substr($reste, strpos($reste, '>')+1));
			$equipe[$d] = substr($reste, 0, strpos($reste, '</A>'));
			$reste = trim(substr($reste, strpos($reste, '</A>')+4));

			$pj[$d] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$standingsW[$d] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$standingsL[$d] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			if(!$shootoutMode){
			    $standingsT[$d] = substr($reste, 0, strpos($reste, ' '));
			    $reste = trim(substr($reste, strpos($reste, ' ')));
			}
			$standingsOL[$d] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$standingsPts[$d] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			
			$reste = trim(substr($reste, strpos($reste, ' ')));	
			$fieldLength = $shootoutMode ? 10 : 9;
			for ($z = 0; $z < $fieldLength; $z ++) {
			    $reste = trim(substr($reste, strpos($reste, ' ')));
			}
			$standingsL10[$d] = substr($reste, 0, strpos($reste, ' '));
			
			$data[] = array('id' => $d, 'pts' => $standingsPts[$d], 'gp' => $pj[$d]);
			
			$d++;
		}
	}
	echo '<thead>';
	echo '<tr>';
	echo '<th class="text-left" style="padding-left:1rem">' . $standingTeam . '</th>';
	echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingGPFull.'">'. $standingGP .'</th>';
	echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingWFull.'">' . $standingW . '</th>';
	echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingLFull.'">' . $standingL . '</th>';
	if(!$shootoutMode){
	    echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingEFull.'">' . $standingE . '</th>';
	}else{
	    echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingOTFull.'">' . $standingOT . '</th>';
	}
	echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingPTSFull.'">' . $standingPTS . '</th>';
	echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingL10Full.'">' . $standingL10 . '</th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
	
	function array_orderby() {
		$args = func_get_args();
		$data = array_shift($args);
		foreach ($args as $n => $field) {
			if (is_string($field)) {
				$tmp = array();
				foreach ($data as $key => $row)
					$tmp[$key] = $row[$field];
				$args[$n] = $tmp;
				}
		}
		$args[] = &$data;
		call_user_func_array('array_multisort', $args);
		return array_pop($args);
	}

	$sorted = array_orderby($data, 'pts', SORT_DESC, 'gp', SORT_ASC);
	
	for($d=0;$d<count($sorted);$d++) {
		$key = $sorted[$d]['id'];
		$pos = $d + 1;
		echo '<tr class="hover'.$c.'">';
		echo '<td class="text-left"><a style="display:block; width:100%;" href="TeamRosters.php?team='.urlencode($equipe[$key]).'">'.$equipe[$key].'</a></td>';
		echo '<td>'.$pj[$key].'</td>';
		echo '<td>'.$standingsW[$key].'</td>';
		echo '<td>'.$standingsL[$key].'</td>';
		if(!$shootoutMode){
		    echo '<td>'.$standingsT[$key].'</td>';
		}else{
		    echo '<td>'.$standingsOL[$key].'</td>';
		}
		echo '<td>'.$standingsPts[$key].'</td>';
		echo '<td>'.$standingsL10[$key].'</td>';
		echo '</tr>';
	}
	
}
else { 
	echo '<tr><td>'.$allFileNotFound.' - '.$Fnm.'</td></tr>';
}

?>
</tbody>
</table>
</div>

<script>

$(document).ready(function() 
    { 
        $("#miniStandings").tablesorter({ 
            sortInitialOrder: 'desc'
    	}); 
    } 
); 

</script>
<!-- </div> -->

<!-- </body> -->
	
<style>
.scrollable-table {  
    height: 250px !important;
	overflow-y:scroll;
}
</style>

<!-- </html> -->
