<?php
require_once 'config.php';
include 'lang.php';

$CurrentHTML = 'FarmStandings.php';
$CurrentTitle = $homeStandingsFarm;
$CurrentPage = 'FarmStandings';


include 'head.php';

//hardcode to farm
$currentFarm = 1;
$tableCol = 11;

?>

<div class = "container px-0">

<div class="card">
	<?php include 'SectionHeader.php';?>
	<div class="card-body p-1">


<?php

$Fnm = getCurrentRegSeasonFile('FarmStandings');

$c = 1;
$d = 0;
$e = 0;
$confProcessed = 0;
$lastUpdated='';

if(file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = myEach($tableau)) {
		$val = encodeToUtf8($val);
		if(substr_count($val, '<P>(As of')){
			$pos = strpos($val, ')');
			$pos = $pos - 10;
			//$val2 = substr($val, 10, $pos);
			$lastUpdated= substr($val, 10, $pos);
			
			//echo '<h5 class = "text-center">'.$allLastUpdate.' '.$val2.'</h5>';
			
			echo '<div class="row">';
			echo '<div class="col-sm-12 col-md-8 offset-md-2">';
			//echo '<div class="table-responsive">';
			//echo '<table class="table table-sm table-striped text-center">';
		}
		if(substr_count($val, 'STK') && (substr_count($val, 'OL') || substr_count($val, 'OTL'))) {
			$e = 1;
		}
		if(substr_count($val, 'Conference</H3>') && !substr_count($val, '<H3>By Conference</H3>')) {
			$pos = strpos($val, 'Conference</H3>');
			$pos2 = strpos($val, '<H3>');
			$val2 = substr($val, $pos2+4, $pos-$pos2-5);

			if($confProcessed > 0){
			    echo '</tbody>';
			    echo '</table>';
			    echo '</div>';
			}
			
			echo '<div class = "tableau-top">' . $val2 . ' ' . $standingConference . '</div>';
			echo '<div class="table-responsive">';
			echo '<table class="table table-sm table-striped text-center table-rounded-bottom">';
			
			
			$d = 1;
			$b = 0;
			$final = 0;
			
			$confProcessed++;
			
		}

		if($d == 1 && substr_count($val, '</H3>')) {
			$c = 1;
		}
		if(substr_count($val, 'HREF=') || ($currentFarm == 1 && substr_count($val, '<') == false)) {
			if($d == 1) {
	
				
				echo '<thead>';
				echo '<tr>';
				echo '<th></th>';
				echo '<th class="text-left">' . $standingTeam . '</th>';
				echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingGPFull.'">'. $standingGP .'</th>';
				echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingWFull.'">' . $standingW . '</th>';
				echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingLFull.'">' . $standingL . '</th>';
				echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingEFull.'">' . $standingE . '</th>';
				echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingPTSFull.'">' . $standingPTS . '</th>';
				echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingGFFull.'">' . $standingGF . '</th>';
				echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingGAFull.'">' . $standingGA . '</th>';
				echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingDiffFull.'">' . $standingDiff . '</th>';
				echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingPCTFull.'">' . $standingPCT . '</th>';
				
				
				echo '</tr>';
				echo '</thead>';
				echo '<tbody>';
			}
			$reste = trim($val);
			if(substr_count($reste, 'WIDTH')) {
				echo '<tr><td colspan="'.$tableCol.'" style="height:2px; background-color:'.$couleur_contour.';"></td></tr>';
				$reste = substr($reste, strpos($reste, '<A '));
			}
			$serie = '';
			if($currentFarm == 0) {
				$serie = substr($reste, 0, strpos($reste, '<'));
				$reste = trim(substr($reste, strpos($reste, '>')+1));
				$equipe = substr($reste, 0, strpos($reste, '</A>'));
				$reste = trim(substr($reste, strpos($reste, '</A>')+4));
			}
			if($currentFarm == 1) {
				$count = strlen($reste);
				$z = 0;
				while( $z < $count ) {
					if( ctype_digit($reste[$z]) ) {
						$pos = $z;
						break 1;
					}
					$z++;
				}
				$equipe = trim(substr($reste, 0, $pos));
				$reste = trim(substr($reste, $pos));
			}
			$pj = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$standingsW = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$standingsL = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$standingsT = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			if($currentFarm == 0 && $e == 1) {
				$standingsOL = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
			}
			$standingsPts = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$standingsGF = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$standingsGA = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$standingsDiff = $standingsGF - $standingsGA;
			if($standingsDiff > 0) $standingsDiff = '+'.$standingsDiff;
			if($currentFarm == 1) {
				$standingsPCT = $reste;
			}
			if($currentFarm == 0) {
				$standingsPCT = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				for($z=0;$z<9;$z++) {
					$reste = trim(substr($reste, strpos($reste, ' ')));
				}
				$standingsL10 = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$standingsSTK = $reste;
			}
			if($serie != ''){
				if($serie == 'z') $serie = '<a href="javascript:return;" class="info" style="color:#000000">'.$standingZ.'<span>'.$standingZFull.'</span></a>';
				if($serie == 'y') $serie = '<a href="javascript:return;" class="info" style="color:#000000">'.$standingY.'<span>'.$standingYFull.'</span></a>';
				if($serie == 'x') $serie = '<a href="javascript:return;" class="info" style="color:#000000">'.$standingX.'<span>'.$standingXFull.'</span></a>';
				if($d == 3) $final = 1;
				if($d == 8) $b = 1;
			}
			if(($currentFarm == 1 && isset($TSabbr) && substr_count($val, '('.$TSabbr))) $bold = 'font-weight:bold;';
			else $bold = '';
			if($b && $d > 8 && $final) $serie = '<a href="javascript:return;" class="info" style="color:#000000">'.$standingN.'<span>'.$standingNFull.'</span></a>';
			if($c == 1) $c = 2;
			else $c = 1;

			echo '<td style="'.$bold.'">'.$d.'</td>';
			echo '<td class="text-left">'.$equipe.'</td>';
			echo '<td>' . $pj . '</td>';
			echo '<td>' . $standingsW . '</td>';
			echo '<td>' . $standingsL . '</td>';
			echo '<td>' . $standingsT . '</td>';
			
			echo '<td>' . $standingsPts . '</td>';
			echo '<td>' . $standingsGF . '</td>';
			echo '<td>' . $standingsGA . '</td>';
			echo '<td>' . $standingsDiff . '</td>';
			echo '<td>' . $standingsPCT . '</td>';

			echo '</tr>';
			
			$d++;
		}
	}
	
}
else { 
	echo '<tr><td>'.$allFileNotFound.' - '.$Fnm.'</td></tr>';
}
?>
</tbody>
</table>
</div>
</div>
</div>
<?php echo '<h6 class = "text-center">' . $allLastUpdate . ' ' . $lastUpdated . '</h56>';?>
</div>
</div>
</div>



<?php include 'footer.php'; ?>
