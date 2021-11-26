<?php
require_once 'config.php';
include 'lang.php';
include_once 'common.php';
include_once 'fileUtils.php';
include_once FS_ROOT.'classes/TeamAbbrHolder.php';

$CurrentHTML = 'OverallStandings.php';
$CurrentTitle = $standingOVTitle;
$CurrentPage = 'OverallStandings';

$seasonId='';
$seasonType='';
$type='PRO';
$currentFarm=0;
if(isset($_GET['seasonId']) || isset($_POST['seasonId'])) {
    $seasonId = htmlspecialchars(( isset($_GET['seasonId']) ) ? $_GET['seasonId'] : $_POST['seasonId']);
}

if(isset($_GET['seasonType']) || isset($_POST['seasonType'])) {
    $seasonType = ( isset($_GET['seasonType']) ) ? $_GET['seasonType'] : $_POST['seasonType'];
}else{
    if(PLAYOFF_MODE) $seasonType='PLF';
}

if(isset($_GET['type']) || isset($_POST['type'])) {
    $type = htmlspecialchars(( isset($_GET['type']) ) ? $_GET['type'] : $_POST['type']);
    if('FARM'==$type){
        $currentFarm=1;
    }
}


include 'head.php';

//get seasons which will be used to populate previous season dropdown if they exist
$previousSeasons = getPreviousSeasons(CAREER_STATS_DIR);

if(!$currentFarm){
    $standingsFile = _getLeagueFile('Standings',$seasonType,$seasonId,'Farm');
}else{
    $standingsFile = _getLeagueFile('FarmStandings',$seasonType,$seasonId);
}
$OrigHTML = $standingsFile;

$teamScoringFile = getCurrentLeagueFile('TeamScoring');
$teamAbbrHolder = new TeamAbbrHolder($teamScoringFile);


?>

<div class="container px-0">

	<div class="card">
	
		<?php include 'SectionHeader.php';?>
		
		<div class="card-body p-1">

			<div class="row no-gutters justify-content-left ">
            	<div class="col col-md-8 col-lg-6">
            		<div class="row no-gutters">
            			<div class="col py-1 pr-1">
            				<div class="input-group">
            					<div class="input-group-prepend">
            						<label class="input-group-text" for="seasonMenu"><?php echo $homeSeason;?></label>
            					</div>
            
            					<?php 	
            					$currentSeason = $seasonId ? $seasonId : 'Current';
            					?>
            					<select class="col custom-select" id="seasonMenu">
            						<option <?php echo ($currentSeason == 'Current' ? 'selected' : '');?> <?php echo ($currentSeason == 'Current' && $seasonType == 'PLF' && !PLAYOFF_MODE ? 'disabled' : '');?> value="Current"><?php echo $allCurrent;?></option>
            						<?php 
            						//get seasons which will be used to populate previous season dropdown if they exist
            						$previousSeasons = getPreviousSeasons(CAREER_STATS_DIR);
            					
            
            						if (!empty($previousSeasons)) {
            						    foreach ($previousSeasons as $prevSeason) {
            						        echo '<option '.($currentSeason == $prevSeason ? 'selected' : '').' value='.$prevSeason.'>'.$prevSeason.'</option>';
            						    }
            						}
            					
            						?>
            					</select>
            				</div>
            			</div>
            
            
            			<div class="col py-1">
            				<div class="input-group">
            					<div class="input-group-prepend">
            						<label class="input-group-text" for="typeMenu">Type</label>
            					</div>
            					<select class="custom-select" id="typeMenu">
            						
            						<option value=PRO <?php echo (!$currentFarm) ? 'selected' : ''?>><?php echo $allPro;?></option>
            						<option value=FARM <?php echo ($currentFarm) ? 'selected' : ''?>><?php echo $allFarm;?></option>
                                    
            					</select>
            				</div>
            			</div>
            
            		</div>
            	</div>
            </div>


			<div id="SeasonInner">
				
				<?php 
				
				$tableCol = 15;
				if($currentFarm == 1) {
				    $tableCol = 11;
				}
				$c = 1;
				$d = 0;
				$e = 0;
				$lastUpdated = '';
				$shootoutMode = false;
				$e=1;
				if(file_exists($standingsFile)) {
                	$tableau = file($standingsFile);
                	
                	echo '<table id="OverallStandings" class="table table-sm table-striped text-center table-rounded-bottom">';
                	
                	//check playoff mode first if in shootoutmode
                	//still need to be able to support the old style if seasons are mixed between both types so don't look based on mode..
                	foreach($tableau as $line)
                	{
                	    if(strpos($line, 'W  L OT') !== false){
                	        $shootoutMode = true;
                	        break;
                	    }
                	    
                	}

                	foreach ($tableau as $cle => $val) {
                	//while(list($cle,$val) = each($tableau)) {
                		$val = utf8_encode($val);
                		if(substr_count($val, '<P>(As of')){
                			$pos = strpos($val, ')');
                			$pos = $pos - 10;
                			//$val2 = substr($val, 10, $pos);
                			
                			$lastUpdated= substr($val, 10, $pos);
                			//echo '<tr><td colspan="'.$tableCol.'" style="padding-bottom:20px;">'.$allLastUpdate.' '.$val2.'</td></tr>';
                		}
                		if(substr_count($val, 'STK') && (substr_count($val, 'OL') || substr_count($val, 'OTL') || substr_count($val, 'OT'))) {
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
                		if(substr_count($val, 'HREF=') || ($currentFarm == 1 && substr_count($val, '<') == false)) {
                			$reste = trim($val);
                			if(substr_count($reste, 'WIDTH')) {
                				$reste = substr($reste, strpos($reste, '<A '));
                			}
                			$serie[$d] = '';
                			if($currentFarm == 0) {
                				$serie[$d] = substr($reste, 0, strpos($reste, '<'));
                				$reste = trim(substr($reste, strpos($reste, '>')+1));
                				$equipe[$d] = substr($reste, 0, strpos($reste, '</A>'));
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
                				$equipe[$d] = trim(substr($reste, 0, $pos));
                				$reste = trim(substr($reste, $pos));
                			}
                			$pj[$d] = substr($reste, 0, strpos($reste, ' '));
                			$reste = trim(substr($reste, strpos($reste, ' ')));
                			$standingsW[$d] = substr($reste, 0, strpos($reste, ' '));
                			$reste = trim(substr($reste, strpos($reste, ' ')));
                			$standingsL[$d] = substr($reste, 0, strpos($reste, ' '));
                			$reste = trim(substr($reste, strpos($reste, ' ')));
                			
                			//not needed in shootout mode.
                			if(!$shootoutMode){
                			    $standingsT[$d] = substr($reste, 0, strpos($reste, ' '));
                			    $reste = trim(substr($reste, strpos($reste, ' ')));
                			}

                			if($currentFarm == 0 && $e == 1) {
                				$standingsOL[$d] = substr($reste, 0, strpos($reste, ' '));
                				$reste = trim(substr($reste, strpos($reste, ' ')));
                			}
                			                			
                			$standingsPts[$d] = substr($reste, 0, strpos($reste, ' '));
                			$reste = trim(substr($reste, strpos($reste, ' ')));
                			$standingsGF[$d] = substr($reste, 0, strpos($reste, ' '));
                			$reste = trim(substr($reste, strpos($reste, ' ')));
                			$standingsGA[$d] = substr($reste, 0, strpos($reste, ' '));
                			$reste = trim(substr($reste, strpos($reste, ' ')));
                			$standingsDiff[$d] = $standingsGF[$d] - $standingsGA[$d];
                			$sortingDiff = $standingsDiff[$d];
                			if($standingsDiff[$d] > 0) $standingsDiff[$d] = '+'.$standingsDiff[$d];
                			if($currentFarm == 1) {
                				$standingsPCT[$d] = $reste;
                			}
                			if($currentFarm == 0) {
                				$standingsPCT[$d] = substr($reste, 0, strpos($reste, ' '));
                				$reste = trim(substr($reste, strpos($reste, ' ')));
//                 				for($z=0;$z<9;$z++) {
//                 					$reste = trim(substr($reste, strpos($reste, ' ')));
//                 				}
                				$lastCounter = ($shootoutMode) ? 10 : 9;
                				for ($z = 0; $z < $lastCounter; $z ++) {
                				    $reste = trim(substr($reste, strpos($reste, ' ')));
                				}
                				$standingsL10[$d] = substr($reste, 0, strpos($reste, ' '));
                				$reste = trim(substr($reste, strpos($reste, ' ')));
                				$standingsSTK[$d] = $reste;
                			}
                			if($serie[$d] != ''){
                				if($serie[$d] == 'z') $serie[$d] = '<a href="javascript:return;" class="info" style="color:#000000">'.$standingZ.'<span>'.$standingZFull.'</span></a>';
                				if($serie[$d] == 'y') $serie[$d] = '<a href="javascript:return;" class="info" style="color:#000000">'.$standingY.'<span>'.$standingYFull.'</span></a>';
                				if($serie[$d] == 'x') $serie[$d] = '<a href="javascript:return;" class="info" style="color:#000000">'.$standingX.'<span>'.$standingXFull.'</span></a>';
                				$b++;
                			}
                			else {
                				if($b > 7) $serie[$d] = '<a href="javascript:return;" class="info" style="color:#000000">'.$standingN.'<span>'.$standingNFull.'</span></a>';
                			}
                			if($equipe[$d] == $currentTeam || ($currentFarm == 1 && substr_count($val, '('.$teamAbbrHolder->getAbbr($currentTeam)))) $bold = 'font-weight:bold;';
                			else $bold = '';
                			
                			$data[] = array('id' => $d, 'pts' => $standingsPts[$d], 'gp' => $pj[$d], 'win' => $standingsW[$d], 'diff' => $sortingDiff);
                			
                			$d++;
                		}
                	}
//                 	echo '<tr class="tableau-top">';
//                 	echo '<td></td>';
//                 	if($currentFarm == 0) echo '<td></td>';
//                 	echo '<td>'.$standingTeam.'</td>';
//                 	echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$standingGP.'<span>'.$standingGPFull.'</span></a></td>';
//                 	echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$standingW.'<span>'.$standingWFull.'</span></a></td>';
//                 	echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$standingL.'<span>'.$standingLFull.'</span></a></td>';
//                 	echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$standingE.'<span>'.$standingEFull.'</span></a></td>';
//                 	if($currentFarm == 0 && $e == 1) echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$standingOT.'<span>'.$standingOTFull.'</span></a></td>';
//                 	echo '<td style="text-align:right;"><a href="javascript:return;" class="info"><b>'.$standingPTS.'</b><span>'.$standingPTSFull.'</span></a></td>';
//                 	echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$standingGF.'<span>'.$standingGFFull.'</span></a></td>';
//                 	echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$standingGA.'<span>'.$standingGAFull.'</span></a></td>';
//                 	echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$standingDiff.'<span>'.$standingDiffFull.'</span></a></td>';
//                 	echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$standingPCT.'<span>'.$standingPCTFull.'</span></a></td>';
//                 	if($currentFarm == 0) echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$standingL10.'<span>'.$standingL10Full.'</span></a></td>';
//                 	if($currentFarm == 0) echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$standingSTRK.'<span>'.$standingSTRKFull.'</span></a></td>';
                	echo '<thead>';
                	echo '<tr>';
                	if($currentFarm == 0) echo '<th></th>';
                	echo '<th></th>';
                	echo '<th class="text-left">' . $standingTeam . '</th>';
                	echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingGPFull.'">'. $standingGP .'</th>';
                	echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingWFull.'">' . $standingW . '</th>';
                	echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingLFull.'">' . $standingL . '</th>';
                	if(!$shootoutMode){
                	    echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingEFull.'">' . $standingE . '</th>';
                	}
                	
                	if ($e == 1){
                	    
                	    if($currentFarm == 0) echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingOTFull.'">' . $standingOT . '</th>';
                	    echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingPTSFull.'">' . $standingPTS . '</th>';
                	    echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingGFFull.'">' . $standingGF . '</th>';
                	    echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingGAFull.'">' . $standingGA . '</th>';
                	    echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingDiffFull.'">' . $standingDiff . '</th>';
                	    echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingPCTFull.'">' . $standingPCT . '</th>';
                	    if($currentFarm == 0) echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingL10Full.'">' . $standingL10 . '</th>';
                	    if($currentFarm == 0) echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingSTRKFull.'">' . $standingSTRK . '</th>';
                	    
                	}
                	echo '</tr>';
                	echo '</thead>';
                	echo '<tbody>';

                	echo '</tr>';
                	
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
                	$sorted = array_orderby($data, 'pts', SORT_DESC, 'gp', SORT_ASC, 'win', SORT_DESC, 'diff', SORT_DESC);
                	
                	for($d=0;$d<count($sorted);$d++) {
                		$key = $sorted[$d]['id'];
                		if($equipe[$key] == $currentTeam || ($currentFarm == 1 && substr_count($val, '('.$teamAbbrHolder->getAbbr($currentTeam)))) $bold = 'font-weight:bold;';
                		else $bold = '';
                		if($c == 1) $c = 2;
                		else $c = 1;
                		$pos = $d + 1;
                		echo '<tr>';
                		echo '<td>'.$pos.'</td>';
                		if($currentFarm == 0) echo '<td>'.$serie[$key].'</td>';
                		if($currentFarm == 0) echo '<td class="text-left"><a style="display:block;" href="LinkedRosters.php?team='.$equipe[$key].'">'.$equipe[$key].'</a></td>';
                		if($currentFarm == 1) echo '<td class="text-left">'.$equipe[$key].'</td>';
                		echo '<td>'.$pj[$key].'</td>';
                		echo '<td>'.$standingsW[$key].'</td>';
                		echo '<td>'.$standingsL[$key].'</td>';
   
                		if(!$shootoutMode){
                		    echo '<td>'.$standingsT[$key].'</td>';
                		}
                		
                		if ($e == 1){
                    		if($currentFarm == 0) echo '<td>'.$standingsOL[$key].'</td>';
                    		echo '<td><b>'.$standingsPts[$key].'</b></td>';
                    		echo '<td>'.$standingsGF[$key].'</td>';
                    		echo '<td>'.$standingsGA[$key].'</td>';
                    		echo '<td>'.$standingsDiff[$key].'</td>';
                    		echo '<td>'.$standingsPCT[$key].'</td>';
                		}
                		if($currentFarm == 0) echo '<td>'.$standingsL10[$key].'</td>';
                		if($currentFarm == 0) echo '<td>'.$standingsSTK[$key].'</td>';
                		echo '</tr>';
                	}
                	echo '</table>';
                	echo '<h6 class = "text-center">'.$allLastUpdate.' '. $lastUpdated.'</h6>';
				}else{
				    echo '<div class="card"><div class="card-body"><h6 class="text-center">'.$allNoSeasonDataFound.'</h6></div></div>';
				}
                ?>
               
                
                
			</div>
		</div>
	</div>
</div>


<script>

$("#seasonMenu").on('change', function() {  
    var seasonSelection = $(this).val();

	if(seasonSelection == 'Current'){
	  seasonSelection = '';
	}

	var newParams = {'seasonId': seasonSelection};
    window.location.href = addParametersToURL(newParams);
    
} );

$("#typeMenu").on('change', function() {  
    var typeSelection = $(this).val();

	var newParams = {'type': typeSelection};
    window.location.href = addParametersToURL(newParams);
    
} );

$(document).ready(function() 
    { 
        $("#OverallStandings").tablesorter({ 
            sortInitialOrder: 'desc'
    	}); 
    } 
); 


</script>


<?php include 'footer.php'; ?>
