<?php
require_once 'config.php';
require_once 'common.php';
include 'lang.php';
$CurrentHTML = 'Waivers.php';
$CurrentTitle = $waiversTitle;
$CurrentPage = 'Waivers';
include 'head.php';
?>

<div class = "container px-0">
	
	<div class = "card">
		<?php include 'SectionHeader.php';?>
		
		<div class = "card-body p-1">
		<div class="row">
			<div class="col-sm-12 col-md-6 offset-md-3">
			<table class="table table-sm table-striped table-rounded-bottom">

<?php
// $matches = glob($folder.'*'.$playoff.'Waivers.html');
// $folderLeagueURL = '';
// $matchesDate = array_map('filemtime', $matches);
// arsort($matchesDate);
// foreach ($matchesDate as $j => $val) {
//    if((!substr_count($matches[$j], 'PLF') && $playoff == '') || (substr_count($matches[$j], 'PLF') && $playoff == 'PLF')) {
// 		$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'Waivers')-strrpos($matches[$j], '/')-1);
// 		break 1;
// 	}
// }
// $Fnm = $folder.$folderLeagueURL.'Waivers.html';
$Fnm = getLeagueFile('Waivers');
$b = 0;
$c = 1;
$d = 0;
$e = 0;
$lastUpdated = '';
if(file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = myEach($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, '(As of')){
		    $lastUpdated = substr($val, strpos($val, '(')+7, strpos($val, ')')-strpos($val, '(')-7);
			//echo '<tr><td colspan="4" style="padding-bottom:20px;">'.$allLastUpdate.' '.$date.'</td></tr>';
		}
		
		if(substr_count($val, 'NO PLAYERS ON WAIVERS')){
			$d = 3;
			if($e == 0) echo '<tr class="text-center hover2"><td class="text-bold" colspan="4">'.$waiversNothing.'</td></tr>';
		}
		
		if($d == 2 && !substr_count($val, '<')) {
			if($c == 1) $c = 2;
			else $c = 1;
			$reste = trim($val);
			$waivName = substr($reste, 0, strpos($reste, '  '));
			$reste = trim(substr($reste, strpos($reste, '  ')));
			$waivDate = substr($reste, 0, strpos($reste, '  '));
			$reste = trim(substr($reste, strpos($reste, '  ')));
			$waivBy = substr($reste, 0, strpos($reste, '  '));
			$reste = trim(substr($reste, strpos($reste, '  ')));
			$waivClaim = $reste;
			
			$bold = '';
			if($waivBy == $currentTeam) $bold = 'font-weight:bold;';
			
			echo '<tr class="hover'.$c.'">
			<td style="'.$bold.'">'.$waivName.'</td>
			<td style="'.$bold.'">'.$waivDate.'</td>
			<td style="'.$bold.'">'.$waivBy.'</td>
			<td style="'.$bold.'">'.$waivClaim.'</td>
			</tr>';
			$e = 1;
		}
		
		if($d == 1 && (substr_count($val, '<br>') || substr_count($val, '<BR>'))){
			$d = 2;
			$c = 1;
		}
		
		if(substr_count($val, '<pre>') || substr_count($val, '<PRE>')){
			echo '<thead><tr class="tableau-top text-left">';
			echo '<td>'.$waiversPlayer.'</td>';
			echo '<td>'.$waiversDate.'</td>';
			echo '<td>'.$waiversBy.'</td>';
			echo '<td>'.$waiversClaimed.'</td>';
			echo '</tr></thead><tbody>';
			$d = 1;
		}
		
		if($d == 4 && (substr_count($val, '<br>') || substr_count($val, '<BR>'))) {
			if(substr_count($val, '<br>')) $reste = substr($val, 0, strpos($val, '<br>'));
			if(substr_count($val, '<BR>')) $reste = substr($val, 0, strpos($val, '<BR>'));
			$waivNum = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$waivTeam = $reste;
			if($c == 1) $c = 2;
			else $c = 1;
			
			$bold = '';
			if($waivTeam == $currentTeam) $bold = 'font-weight:bold;';
			
			echo '<tr class="hover'.$c.'">
			<td style="'.$bold.'">'.$waivNum.'</td>
			<td class="text-left" style="'.$bold.'">'.$waivTeam.'</td>
			</tr>';
		}
		
		if(substr_count($val, 'PRIORITY LIST')){
			$d = 4;
			$c = 1;
			echo '</tbody></table>';
            echo '<table class="table table-sm table-striped table-rounded-bottom text-center"><thead><tr class="tableau-top">';
			echo '<td>#</td>';
			echo '<td class="text-left">'.$waiversPriority.'</td>';
			echo '</tr></thead><tbody>';
		}
	}
}
else echo '<tr><td>'.$allFileNotFound.' - '.$Fnm.'</td></tr>';
echo '</tbody>';
?>

</table></div></div></div></div></div>

<?php include 'footer.php'; ?>