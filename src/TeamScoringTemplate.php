<?php
require_once 'config.php';
include_once 'lang.php';
include_once 'common.php';
include_once 'fileUtils.php';

include_once 'classes/ScoringHolder.php';
include_once 'classes/ScoringPlayerObj.php';
include_once 'classes/ScoringGoalieObj.php';
include_once 'classes/ScoringObj.php';
include_once 'classes/TeamAbbrHolder.php';
//include_once 'classes/ScoringAccumulator.php';

$seasonId = null;
//$playoff = '';
$seasonType= null;

if(isset($_GET['seasonId']) || isset($_POST['seasonId'])) {
    $seasonId = ( isset($_GET['seasonId']) ) ? $_GET['seasonId'] : $_POST['seasonId'];
}

if(isset($_GET['seasonType']) || isset($_POST['seasonType'])) {
    $seasonType = ( isset($_GET['seasonType']) ) ? $_GET['seasonType'] : $_POST['seasonType'];
}

if(isset($_GET['team']) || isset($_POST['team'])) {
    $currentTeam = ( isset($_GET['team']) ) ? $_GET['team'] : $_POST['team'];
    $currentTeam = htmlspecialchars($currentTeam);

}

?>

<?php

if(empty($currentTeam)){
    http_response_code(400);
    exit('team not found');
}

$fileName = _getLeagueFile('TeamScoring', $seasonType, $seasonId);

if(!file_exists($fileName)) {
    if($seasonType == "PLF"){
        echo '<div class="card"><div class="card-body"><h6 class="text-center">'.$allPlayoffsNotStarted.'</h6></div></div>';
    }else{
        echo '<div class="card"><div class="card-body"><h6 class="text-center">'.$allNoSeasonDataFound.'</h6></div></div>';
    }

    exit;
}
$scoringHolder = new ScoringHolder($fileName, $currentTeam);
//$teamAbbrHolder = new TeamAbbrHolder($fileName);

$shootoutMode = $scoringHolder->isShootoutMode();
$tieLabel = $shootoutMode ? $scoringOTLm : $scoringTm;
$tieTitle = $shootoutMode ? $scoringOTL : $scoringT;

?>
<div class = "row no-gutters">
	<div class="col-sm-12 col-md-10 offset-md-1">

    	<div class="row no-gutters">
        	<div class="col">
        		<div class="tableau-top"><?php echo $scoringScoring?></div>
        		<div class="table-responsive">
        			<table id="forward-scoring" class="table table-sm table-striped table-hover table-rounded-bottom fixed-column text-center">
                        <thead>
                            <tr>
                    			<th data-toggle="tooltip" data-placement="top" title="<?php echo $scoringName?>" class="text-left"><?php echo $scoringName?></th>
                    			<th data-toggle="tooltip" data-placement="top" title="<?php echo $scoringTM?>"><?php echo $scoringTMm;?></th>
                    			<th data-toggle="tooltip" data-placement="top" title="<?php echo $rostersPosition?>">PO</th>
                    			<th data-toggle="tooltip" data-placement="top" title="<?php echo $scoringRookie?>">R</th>
        			            <th data-toggle="tooltip" data-placement="top" title="<?php echo $scoringGP?>"><?php echo $scoringGPm ?></th>
                    			<th data-toggle="tooltip" data-placement="top" title="<?php echo $scoringG?>"><?php echo $scoringGm?></th>
                    			<th data-toggle="tooltip" data-placement="top" title="<?php echo $scoringAssits?>">A</th>
                    			<th data-toggle="tooltip" data-placement="top" title="Points">P</th>
                    			<th data-toggle="tooltip" data-placement="top" title="<?php echo $scoringDiff?>">+/-</th>
                    			<th data-toggle="tooltip" data-placement="top" title="<?php echo $scoringPIM?>"><?php echo $scoringPIMm?></th>
                    			<th data-toggle="tooltip" data-placement="top" title="<?php echo $scoringPP?>"><?php echo $scoringPPm?></th>
                    			<th data-toggle="tooltip" data-placement="top" title="<?php echo $scoringSH?>"><?php echo $scoringSHm?></th>
                    			<th data-toggle="tooltip" data-placement="top" title="<?php echo $scoringGW?>"><?php echo $scoringGWm?></th>
                    			<th data-toggle="tooltip" data-placement="top" title="<?php echo $scoringGT?>"><?php echo $scoringGTm?></th>
                    			<th data-toggle="tooltip" data-placement="top" title="<?php echo $scoringHT?>"><?php echo $scoringHTm?></th>
                    			<th data-toggle="tooltip" data-placement="top" title="<?php echo $scoringS?>"><?php echo $scoringSm?></th>
                    			<th data-toggle="tooltip" data-placement="top" title="<?php echo $scoringPCTG?>"><?php echo $scoringPCTGm?></th>
                    			<th data-toggle="tooltip" data-placement="top" title="<?php echo $scoringGS?>"><?php echo $scoringGSm?></th>
                    			<th data-toggle="tooltip" data-placement="top" title="<?php echo $scoringPS?>"><?php echo $scoringPSm?></th>
                			</tr>
                        </thead>
                        <tbody style="font-weight:normal">
                        	<?php foreach ($scoringHolder->getSkaters() as $skater) {
                        	
                        	    $position = $skater->getPosition();
                        	    if(LEAGUE_LANG == 'FR'){
                        	        if('RW' === $position){
                        	            $position = 'AD';
                        	        }else if('LW' === $position){
                        	            $position = 'AG';
                        	        }
                        	    }
                        	    
                        	    echo '<tr>
                    			<td class="text-left">'.$skater->getName().'</td>
                                <td>'.$skater->getTeamAbbr().'</td>
                    			<td>'.$position.'</td>
                    			<td>'.($skater->getRookieStatus() ? '*' : '').'</td>
                    			<td>'.$skater->getGamesPlayed().'</td>
                    			<td>'.$skater->getGoals().'</td>
                    			<td>'.$skater->getAssists().'</td>
                    			<td>'.$skater->getPoints().'</td>
                    			<td>'.$skater->getPlusMinus().'</td>
                    			<td>'.$skater->getPim().'</td>
                    			<td>'.$skater->getPpg().'</td>
                    			<td>'.$skater->getShg().'</td>
                    			<td>'.$skater->getGwg().'</td>
                    			<td>'.$skater->getGtg().'</td>
                    			<td>'.$skater->getHits().'</td>
                    			<td>'.$skater->getShots().'</td>
                    			<td>'.$skater->getShotPct().'</td>
                    			<td>'.$skater->getGoalStreak().'</td>
                    			<td>'.$skater->getPointStreak().'</td>
                    			</tr>';
                        	    
                        	}?>
                        </tbody>
        			</table>
        		</div>	
            </div>
    	</div>  	

    	
    	<div class="row no-gutters">
        	<div class="col">
            	<div class="tableau-top"><?php echo $scoringGoalie?></div>
        		<div class="table-responsive">
        			<table id="goalie-stats" class="table table-sm table-striped table-hover table-rounded-bottom fixed-column text-center">
                        <thead>
                            <tr>
                    			<th data-toggle="tooltip" data-placement="top" title="<?php echo $scoringName ?>" class="text-left"><?php echo $scoringName ?></th>
                    			<th data-toggle="tooltip" data-placement="top" title="<?php echo $scoringTM?>"><?php echo $scoringTMm;?></th>
                    			<th data-toggle="tooltip" data-placement="top" title="<?php echo $rostersPosition ?>">PO</th>
                    			<th data-toggle="tooltip" data-placement="top" title="<?php echo $scoringRookie ?>">R</th>
                    			<th data-toggle="tooltip" data-placement="top" title="<?php echo $scoringGP ?>"><?php echo $scoringGPm ?></th>
                    			<th data-toggle="tooltip" data-placement="top" title="<?php echo $scoringMIN?>">MIN</th>
                    			<th data-toggle="tooltip" data-placement="top" title="<?php echo $scoringAVG?>"><?php echo $scoringAVGm ?></th>
                    			<th data-toggle="tooltip" data-placement="top" title="<?php echo $scoringW?>"><?php echo $scoringWm ?></th>
                    			<th data-toggle="tooltip" data-placement="top" title="<?php echo $scoringL?>"><?php echo $scoringLm ?></th>
                    			<th data-toggle="tooltip" data-placement="top" title="<?php echo $tieTitle?>"><?php echo $tieLabel ?></th>
                    			<th data-toggle="tooltip" data-placement="top" title="<?php echo $scoringSO?>"><?php echo $scoringSOm ?></th>
                    			<th data-toggle="tooltip" data-placement="top" title="<?php echo $scoringGA?>"><?php echo $scoringGAm ?></th>
                    			<th data-toggle="tooltip" data-placement="top" title="<?php echo $scoringSA?>"><?php echo $scoringSAm ?></th>
                    			<th data-toggle="tooltip" data-placement="top" title="<?php echo $scoringPCT?>">PCT</th>
                    			<th data-toggle="tooltip" data-placement="top" title="<?php echo $scoringPIM?>"><?php echo $scoringPIMm ?></th>
                    			<th data-toggle="tooltip" data-placement="top" title="<?php echo $scoringAssits?>">AS</th>
                			</tr>
                        </thead>
                        <tbody style="font-weight:normal">
                    
                        <?php foreach ($scoringHolder->getGoalies() as $goalie) {
                            
//                             //want to add other teams and total.
//                             $goalieName = '';
//                             $goalieNameAlign = 'text-left';
//                             if(!empty($goalie->getName())){
//                                 $goalieName = '<a href="CareerStatsPlayer.php?csName='.urlencode($goalie->getName()).'">'.$goalie->getName().'</a>';
//                             }else{
                                
// //                                 $goalieName = '';
// //                                 if($goalie->getTeamAbbr() == 'TOT'){
// //                                     $goalieName = 'Total';
// //                                 }else{
// //                                     $skaterTeamAbbr = $teamAbbrHolder->getTeamName($goalie->getTeamAbbr());
// //                                     $goalieName = !empty($skaterTeamAbbr) ? $skaterTeamAbbr : $goalie->getTeamAbbr();
// //                                     //$skaterName =  ucwords(strtolower($skaterName));
// //                                 }

//                                 if($skater->getTeamAbbr() == 'TOT'){
//                                     $goalieName = 'TOTAL';
//                                 }else{
//                                     $goalieName = $goalie->getTeamAbbr();
//                                     //just leave abbreviation as is
//                                 }
//                             }
                            
//                         	echo '<tr>
//                             <td class="'.$goalieNameAlign.'">'.$goalieName.'</td>
                            echo '<tr>
                            <td class="text-left">'.$goalie->getName().'</td>
                            <td>'.$goalie->getTeamAbbr().'</td>
                			<td>G</td>
                			<td>'.$goalie->getRookieStatus().'</td>
                			<td>'.$goalie->getGamesPlayed().'</td>
                			<td>'.$goalie->getMinutes().'</td>
                			<td>'.$goalie->getGaa().'</td>
                			<td>'.$goalie->getWins().'</td>
                			<td>'.$goalie->getLosses().'</td>
                			<td>'.$goalie->getTies().'</td>
                			<td>'.$goalie->getShutouts().'</td>
                			<td>'.$goalie->getGoalsAgainst().'</td>
                			<td>'.$goalie->getSavesAttempted().'</td>
                			<td>'.$goalie->getSavePct().'</td>
                			<td>'.$goalie->getPim().'</td>
                			<td>'.$goalie->getAssists().'</td>
                			</tr>';
                        }
    
                        ?>
                        </tbody>
        			</table>
        		</div>	
        	</div>
    	</div>
    	
    	<div class="row no-gutters">
    		<div class="col">
     			<h5 class = "text-center"><?php echo $allLastUpdate.' '.$scoringHolder->getLastUpdated()?></h5> 
     		</div>
    	</div>
  
    		
		

	</div> <!-- end main col -->
</div> <!-- end main row -->

<script>

    $("#forward-scoring").tablesorter({ 
        sortInitialOrder: 'desc'
    }); 
    $("#goalie-stats").tablesorter({ 
        sortInitialOrder: 'desc'
    }); 



</script>

