<?php
require_once 'config.php';
include 'lang.php';
include_once 'common.php';
include_once 'fileUtils.php';
include_once 'classes/GameHolder.php';
include_once 'classes/RosterObj.php';
include_once 'classes/RostersHolder.php';
include_once 'classes/TeamAbbrHolder.php';


$matchNumber ='';
$round = '';
$seasonId = '';
$linkHTML = '';

if(isset($_GET['num']) || isset($_POST['num'])) {
    $matchNumber = htmlspecialchars($_GET['num']);
}

if(isset($_GET['rnd']) || isset($_POST['rnd'])) {
    $round = htmlspecialchars($_GET['rnd']);
}

if(isset($_GET['seasonId']) || isset($_POST['seasonId'])) {
    $seasonId = ( isset($_GET['seasonId']) ) ? $_GET['seasonId'] : $_POST['seasonId'];
}


$baseFolder = '';
$awayTeamAbbr='';
$homeTeamAbbr='';

$roundDisplay = '';
if($round != '') $roundDisplay = ' - '.$scheldRound.' '.$round;

$Fnm = getGameFile($matchNumber, $seasonId, $round);

error_log(print_r(getLeaguePrefix('PLF'),TRUE));
error_log($Fnm);

//override filename
if(isset($_GET['override']) || isset($_POST['override'])) {
    $override = ( isset($_GET['override']) ) ? $_GET['override'] : $_POST['override'];

    $Fnm = getLeagueFileAbsolute($override.'.html',$seasonId);
}



$CurrentHTML = $linkHTML;
$CurrentTitle = $gamesTitle.' #'.$matchNumber.$roundDisplay;
$CurrentPage = 'games';
include 'head.php';

if(file_exists($Fnm)) {
    
    $gameHolder = new GameHolder($Fnm,$matchNumber);

}
else {
    echo $allFileNotFound.' - '.$Fnm;
    exit($allFileNotFound.' - '.$Fnm);
}
?>

<style>

/*don't want whitespace to wrap*/
.table {
	width: 100%;
	white-space: normal;
	line-height: 20px;
}

.teamheader {
	background: var(--header-gradient);
	/* 	height: 68px; */
	overflow: hidden;
	width: 100%;
	float: left;
	moz-border-radius-bottomright: 5px;
	-webkit-border-bottom-right-radius: 5px;
	-border-bottom-right-radius: 5px;
	-moz-border-radius-bottomleft: 5px;
	-webkit-border-bottom-left-radius: 5px;
	border-bottom-left-radius: 5px;
}

.team .header-container {
	background: var(--header-gradient);
	height: 68px;
}

.teamheader .logo-gradient {
	background: var(--header-gradient);
}

.teamheader .gloss {
	height: 34px;
	background: linear-gradient(to bottom, rgba(255, 255, 255, 0.6) 0%,
		rgba(255, 255, 255, 0.5) 35%, rgba(255, 255, 255, 0.1) 100%);
}

.teamheader .team-logo {
	float: left;
	vertical-align: middle;
	text-align: center;
	width: 68px;
	height: 68px;
	-moz-border-radius-bottomleft: 5px;
	-webkit-border-bottom-left-radius: 5px;
	border-bottom-left-radius: 5px;
}

.teamheader .team-right {
	float: right;
	-moz-border-radius-bottomright: 5px;
	-webkit-border-bottom-right-radius: 5px;
	border-bottom-right-radius: 5px;
}

.teamheader .header {
	vertical-align: middle;
	line-height: 20px;
	padding: 5px 10px;
	color: #fff;
	text-transform: uppercase;
	margin-top: -32px;
	text-align: center;
}

.teamheader .score {
	vertical-align: middle;
	color: black;
	font-weight: 800;
	/*     line-height: 20px; */
	padding: 10px 10px;
	font-size: 2rem;
}

.teamheader .gradient-score {
	/* 	background: linear-gradient(rgb(0, 39, 79) 0%, rgb(0, 39, 79) 60%, */
	/* 		rgb(27, 98, 162) 100%); */
	background-image: linear-gradient(rgb(255, 255, 255) 0%,
		rgb(255, 255, 255) 50%, rgb(242, 242, 243) 51%, rgb(242, 242, 243)
		100%);
}

.shootout-winner{
    text-align: center; 
    text-transform: uppercase;
    font-size: 80%;
}


 .table-dark2>thead th { 
 	background-color: rgb(50, 52, 54);
 } 

.table-dark2>tbody td {
  background-color: rgb(24, 26, 29);

    padding: 1px 7px;
    padding-top: 3px;
    border-bottom: 1px solid #27292b;
}

.table-dark2 .teamName {
  border-right: 1px solid #27292b;
}

.table-dark2 .teamTotal {
  border-left: 1px solid #27292b;
}

.table-dark2 {
	-bottom-color: rgb(128, 128, 128);
	graytable border-collapse: collapse;
	border-left-color: rgb(128, 128, 128);
	border-right-color: rgb(128, 128, 128);
	border-top-color: rgb(128, 128, 128);
	box-sizing: border-box;
/* 	color: rgb(173, 173, 178); */
    color: rgb(208, 208, 209);
	display: table;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
/* 	text-align: center; */
	text-size-adjust: 100%;
	-webkit-border-horizontal-spacing: 0px;
	-webkit-border-vertical-spacing: 0px;
	width: 100%;
	line-height:25px;
	margin-bottom:0px;
}

table.table-sm>thead>tr>th:first-of-type {
	padding-left: 0.34rem;
	padding-right: inherit;
}

.table-dark2.table-striped>tbody>tr:nth-child(odd)>td{
   background-color: rgb(24, 26, 29);
 }
 
.table-dark2.table-striped>tbody>tr:nth-child(even)>td{
 background-color: rgb(50, 52, 54);
}

.nav-tabs-dark .nav-link{
    color:rgb(173, 173, 178);
   
    border: 1px solid transparent;
    border-top-left-radius: .25rem;
    border-top-right-radius: .25rem;
    background-color: rgb(24, 26, 29);
}

.nav-tabs-dark .nav-link.active {
/*     color: var(--color-primary-1); */
/*     background-color: var(--color-alternate-2); */
    border-color: #dee2e6 #dee2e6 #fff;
    
    background-color:var(--color-primary-1);
    color:var(--color-alternate-1);

}

.nav-tabs-dark a:focus{
    color:var(--color-primary-1);
    background-color:var(--color-alternate-2);
    filter: initial;
}


.stats-type-header{
 background-color: rgb(24, 26, 29);;
}

.stats-type-header h5{
 color:white;
 text-align:left;
 margin-left:0.3rem;
 margin-bottom:0;
 margin-top:3px;
}

#scoreMain{
    background-image: linear-gradient(rgb(73, 74, 76) 0%, rgb(73, 74, 76) 50%, rgb(52, 53, 55) 51%, rgb(52, 53, 55) 100%);
}

.scoreMainText{
 color:white;
 font-weight:bold;
}

/* // Small devices (landscape phones, 576px and up) */
/* @media ( min-width : 576px) { */

/* } */

/* // Medium devices (tablets, 768px and up) */
@media (min-width: 768px) { 
	#awayHeader .score {
		float: left;
	}
	#awayHeader .logo-home {
		float: right;
	}

} 

@media (min-width: 768px) and (max-width: 991px){
	.teamheader .header h3{
	   font-size: 1.4rem;
	   margin-top: 3px;
	}
}

@media (max-width: 415px) { 
	.teamheader .header h3{
	   font-size: 1.3rem;
	   margin-top: 5px;
	}
	
	.teamheader .header{
	   font-size:0.9rem;
	}
}

</style>

	
<?php 
    include_once 'classes/TeamInfo.php';

    //we want to get info from that particular season if set.
    $seasonType = (isset($round) && $round) ? 'PLF' : null;
    //$standingsFile = _getLeagueFile('Standings',$seasonType,$seasonId,'Farm');
    $standingsFile = _getLeagueFile('Standings','REG',$seasonId,'Farm'); //always show reg season record.
    
    $awayTeam = $gameHolder->getAwayTeam();
    $homeTeam = $gameHolder->getHomeTeam();
    $teamInfoAway = new TeamInfo($standingsFile, $awayTeam);
    $teamInfoHome = new TeamInfo($standingsFile, $homeTeam);
    $isOvertime= $gameHolder->isOvertime();

    $seasonType = $round ? 'PLF' : null;
    $teamScoringFile = _getLeagueFile('TeamScoring', $seasonType, $seasonId);
    if(file_exists($teamScoringFile)) {
        $teamAbbrHolder = new TeamAbbrHolder($teamScoringFile);
        $awayTeamAbbr = $teamAbbrHolder->getAbbr($awayTeam);
        $homeTeamAbbr = $teamAbbrHolder->getAbbr($homeTeam);
    }

    //if not set default abbr to first 3 chars (all star games etc)
    if(!$awayTeamAbbr){
        $awayTeamAbbr = strtoupper(substr($awayTeam,'0','3'));
        $homeTeamAbbr = strtoupper(substr($homeTeam,'0','3'));
    }

?>

<div class="container px-0">
	<div class="row2 no-gutters2">
		<div class="col2">
			<div class="card">
				<div class="card-header p-1 text-center text-white" style="background-color: rgb(50, 52, 54); border-color:rgb(128, 128, 128);">
					<span>FINAL<?php 
					//if($gameHolder->isOvertime()) echo ' (OT)';
					if($gameHolder->isShootout()){
					    echo ' (OT SO)';
					}else if($gameHolder->isOvertime()){
					    echo ' (OT)';
					}
					?></span>
				</div>
				<!-- <div class="card-body p-3" style="background-color: rgb(220, 222, 224);"> -->
				<div class="card-body p-3" style="background-color: rgb(50, 52, 54);">
				
					<div class="mb-3 border-bottom" style="border-color:rgb(128, 128, 128) !important;">
					
					<div id="scoreMain">
						<div class="row no-gutters">
    						<!-- start main score -->
    						<div class="col-12 col-md-6 pr-md-1 pb-2 pb-md-0">
    							<div class="teamheader logo-gradient border">
                                	<?php
                                	//$teamCardLogoSrc = glob($folderTeamLogos . strtolower($awayTeam) . '.*');
                                	$teamCardLogoSrc = getTeamLogoUrl($awayTeam);
                                	error_log($teamCardLogoSrc);
                                ?>
                                 	<div class="team-logo gloss logo-gradient">
                                        <?php
                                        if (isset($teamCardLogoSrc)) {
                                            echo '<img src="' . $teamCardLogoSrc . '" alt="' . $awayTeam . '">';
                                        }
                                        ?>
                                     </div>
    								<div class="team-logo gloss gradient-score team-right score">
    									<div><?php echo $gameHolder->getAwayScore()?></div>
    								</div>
    
    								<div class="header-container">
    
    									<div class="gloss"></div>
    									<div class="header">
    										<h3 class="mb-0"><?php echo $awayTeam ?></h3>
                                			<?php echo $teamInfoAway->getWins().'-'.$teamInfoAway->getLosses().'-'.$teamInfoAway->getTies() ?>
                                			<?php echo '('.$teamInfoAway->getPlaceString().' '.$teamInfoAway->getConferenceSafeString().')' ?>
                                			
                                		</div>
    								</div>
    							</div>
    						</div>
    
    						<div id="awayHeader" class="col-12 col-md-6 pl-md-1">
    							<div class="teamheader logo-gradient border">
                                	<?php
                                	//$teamCardLogoSrc = glob($folderTeamLogos . strtolower($homeTeam) . '.*');
                                	$teamCardLogoSrc = getTeamLogoUrl($homeTeam);
                                ?>
                                 	<div
    									class="team-logo gloss logo-gradient logo-home">
                                        <?php
                                        if (isset($teamCardLogoSrc)) {
                                            echo '<img src="' . $teamCardLogoSrc . '" alt="' . $homeTeam . '">';
                                        }
                                        ?>
                                     </div>
    								<div class="team-logo gloss gradient-score team-right score">
    									<div><?php echo $gameHolder->getHomeScore()?></div>
    								</div>
    
    								<div class="header-container">
    
    									<div class="gloss"></div>
    									<div class="header">
    										<h3 class="mb-0"><?php echo $homeTeam ?></h3>
                                			<?php echo $teamInfoHome->getWins().'-'.$teamInfoHome->getLosses().'-'.$teamInfoHome->getTies() ?>
                                			<?php echo '('.$teamInfoHome->getPlaceString().' '.$teamInfoHome->getConferenceSafeString().')' ?>
                                			
                                		</div>
    								</div>
    							</div>
    						</div>
							
						</div><!-- end row -->
						<div class="text-center mt-1 pb-1 border-bottom" style="font-size:0.8rem;border-color:rgb(128, 128, 128) !important;"><?php echo $teamInfoHome->getArena(); ?></div> 						
    						
					</div>
					<!-- end main score row -->


					<div class="row mt-2">
						<!-- start mini scores -->
						<div class="col-12 col-md-4 pr-md-1">
							<table class="table-dark2 table-sm text-center">
								<!--                         	 <table class = " table table-sm table-striped table-rounded" > -->

								<thead>
									<tr style="text-transform: uppercase;">
										<th class="text-left" style="width: 30%">SCORING</th>
										<th style="width: 14%">1st</th>
										<th style="width: 14%">2nd</th>
										<th style="width: 14%">3rd</th>
                    				    <?php if ($isOvertime) {?>
                    				        <th class="text-center"
											style="width: 14%">OT</th>
                    				    <?php }?>
                    				    <th class="text-center" style="width: 14%">T</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="scoreMainText teamName text-left pl-3">
                                             <?php echo $awayTeamAbbr;?>
                                          </td>

										<td><?php echo $gameHolder->getAwayGoals()[0]?></td>
										<td><?php echo $gameHolder->getAwayGoals()[1]?></td>
										<td><?php echo $gameHolder->getAwayGoals()[2]?></td>
                                    <?php if ($isOvertime) {?>
                                        <td><?php echo $gameHolder->getAwayGoals()[3]?></td>
                                    <?php } ?>
                                    <td class="teamTotal"><strong><?php echo $gameHolder->getAwayScore()?></strong></td>
									</tr>

									<tr>
										<td class="scoreMainText teamName text-left pl-3">
                                             <?php echo $homeTeamAbbr;?>
                                          </td>

										<td><?php echo $gameHolder->getHomeGoals()[0]?></td>
										<td><?php echo $gameHolder->getHomeGoals()[1]?></td>
										<td><?php echo $gameHolder->getHomeGoals()[2]?></td>
                                    <?php if ($isOvertime) { ?>
                                        <td><?php echo $gameHolder->getHomeGoals()[3]?></td>
                                    <?php } ?>
                                    <td class="teamTotal"><strong><?php echo $gameHolder->getHomeScore()?></strong></td>
									</tr>

								</tbody>
							</table>

						</div>
						<!-- end score by period -->
                        
                        <?php

                        $awayScorers = array();
                        $homeScorers = array();

                        $allScorers = array_merge($gameHolder->getScoringFirstPeriod(), $gameHolder->getScoringSecondPeriod(), $gameHolder->getScoringThirdPeriod(), $gameHolder->getScoringOtPeriod());

                        foreach ($allScorers as $scoring) {
                            $name = substr($scoring['SCORE'], 0, strpos($scoring['SCORE'], ' '));

                            if ($scoring['TEAM'] == strtoupper($homeTeam)) {
                                array_push($homeScorers, $name);
                            } else {
                                array_push($awayScorers, $name);
                            }
                        }

                        $scorersHomeCount = array_count_values($homeScorers);
                        $scorersAwayCount = array_count_values($awayScorers);

                        arsort($scorersHomeCount); // sort by goals
                        arsort($scorersAwayCount); // sort by goals

                        $awayScorersFormatted = '';
                        $homeScorersFormatted = '';

                        while (list ($key, $val) = myEach($scorersAwayCount)) {
                            $awayScorersFormatted .= $key . '&nbsp;(' . $val . '), ';
                            ;
                            // $awayScorersFormatted .= $key.' ('.$val.'), ';
                        }

                        while (list ($key, $val) = myEach($scorersHomeCount)) {

                            $homeScorersFormatted .= $key . '&nbsp;(' . $val . '), ';
                            ;
                            // $homeScorersFormatted .= $key.' ('.$val.'), ';
                        }

                        if ($awayScorersFormatted == '')
                            $awayScorersFormatted = 'NONE';
                        else
                            $awayScorersFormatted = substr($awayScorersFormatted, 0, - 2); // remove last comma
                        if ($homeScorersFormatted == '')
                            $homeScorersFormatted = 'NONE';
                        else
                            $homeScorersFormatted = substr($homeScorersFormatted, 0, - 2); // remove last comma

                        ?>
                        
                        <div class="col-12 col-md-4 px-md-1">

							<table class="table-dark2 table-sm">
								<!--                         	 <table class = " table table-sm table-striped table-rounded" > -->
								<thead>
									<tr>
										<th>GOALS</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><?php echo $awayTeam?> - <span class="scoreMainText"><?php echo $awayScorersFormatted ?></span></td>
									</tr>
									<tr>
										<td><?php echo $homeTeam?> - <span class="scoreMainText"><?php echo $homeScorersFormatted ?></span></td>
									</tr>
								</tbody>
							</table>

						</div>
						<!-- end goals smmary -->

						<div class="col-12 col-md-4 pl-md-1">
							<table class="table-dark2 table-sm text-center">
								<thead>
									<tr>
										<th class="text-left">SHOTS</th>
										<th>1ST</th>
										<th>2ND</th>
										<th>3RD</th>
                            			<?php if ($isOvertime) {?>
                                        <th>OT</th>
                                        <?php } ?>
                            			
                            			<th>T</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="scoreMainText teamName text-left pl-3">
                                         <?php echo $awayTeamAbbr;?>
                                        </td>

										<td><?php echo $gameHolder->getAwayShots()[0]?></td>
										<td><?php echo $gameHolder->getAwayShots()[1]?></td>
										<td><?php echo $gameHolder->getAwayShots()[2]?></td>
                                        <?php if ($isOvertime) {?>
                                            <td><?php echo $gameHolder->getAwayShots()[3]?></td>
                                        <?php } ?>
                                        <td class="teamTotal"><strong><?php echo $gameHolder->getAwayShotsTotal()?></strong></td>
									</tr>
									<tr>
										<td class="scoreMainText teamName text-left pl-3">
                                         <?php echo $homeTeamAbbr;?>
                                        </td>

										<td><?php echo $gameHolder->getHomeShots()[0]?></td>
										<td><?php echo $gameHolder->getHomeShots()[1]?></td>
										<td><?php echo $gameHolder->getHomeShots()[2]?></td>
                                        <?php if ($isOvertime) {?>
                                            <td><?php echo $gameHolder->getHomeShots()[3]?></td>
                                        <?php } ?>
                                        <td class="teamTotal"><strong><?php echo $gameHolder->getHomeShotsTotal()?></strong></td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- end shots summary-->
					</div>
					<!-- end main summary row -->
					<div class="row mb-2">
                      
                            <?php
                            //error_log(print_r($gameHolder->getGoalieStats(),true));
                            
                            $awayGoalieFormatted = '';
                            $homeGoalieFormatted = '';
                            foreach ($gameHolder->getGoalieStats() as $goalieState) {
                                if ($goalieState['TEAM'] == $awayTeamAbbr && ! empty($goalieState["STATUS"])) {
                                    $awayGoalieFormatted = $goalieState['PLAYER'] . ' (' . $goalieState["SAVES"] . ' SV) ' . $goalieState["STATUS"];
                                    $awayGoalieFormatted = str_replace(' ', '&nbsp;', $awayGoalieFormatted);
                                } else if ($goalieState['TEAM'] == $homeTeamAbbr && ! empty($goalieState["STATUS"])) {
                                    $homeGoalieFormatted = $goalieState['PLAYER'] . ' (' . $goalieState["SAVES"] . ' SV) ' . $goalieState["STATUS"];
                                    $homeGoalieFormatted = str_replace(' ', '&nbsp;', $homeGoalieFormatted);
                                }
                            }

                            ?>
                            
                            <div class="col-12 col-md-4 pr-md-1">
							<table class="table-dark2 table-sm">
								<thead>
									<tr>
										<th>GOALTENDERS</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><?php echo $awayTeam?> - <span class="scoreMainText"><?php echo $awayGoalieFormatted ?></span></td>
									</tr>
									<tr>
										<td><?php echo $homeTeam?> - <span class="scoreMainText"><?php echo $homeGoalieFormatted ?></span></td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- end goalie smmary-->


						<div class="col-6 col-md-4 pr-1 px-md-1">
							<table class="table-dark2 table-sm">
								<thead>
									<tr>
										<th colspan="2">POWER PLAY</th>
									</tr>
								</thead>
								<tbody>
                                		<?php foreach($gameHolder->getPowerPlaySummary() as $ppTemp){ ?>
                                		<tr>
										<td><?php echo $ppTemp['TEAM']?></td>
										<td><?php echo $ppTemp['RESULT']?></td>
									</tr>
                                		<?php } ?>
                                	
                                		
                            		</tbody>
							</table>
						</div>
						<!-- powerplay-->
                           
                           <?php

                        $profitTemp = $gameHolder->getTeamProfit();
                        $profitTemp = substr($profitTemp, 0, - 3);

                        ?>
                           
                           <div class="col-6 col-md-4 pl-1 pr-1 pl-md-1">
							<table class="table-dark2 table-sm">
								<thead>
									<tr>
										<th colspan="2">FINANCIALS</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Attendance</td>
										<td><?php echo $gameHolder->getAttendence()?></td>
									</tr>
									<tr>
										<td>Net Profit</td>
										<td><?php echo $profitTemp?></td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- financials-->
                        </div>
					</div>

					<div class="row no-gutters">
						<!-- start scoring summary-->
						<div class="col-sm-12 col-lg-8 offset-lg-2 mb-3">
							<div class="card border" style="background-color:rgb(50, 52, 54); border-color: var(--color-primary-1) !important;">
								<div id="summaryTabs" class="card-header text-white px-2 px-lg-4 pb-0 pt-2">
									<div class="text-center"><h5 class="mb-1">GAME SUMMARY</h5></div>
									<ul class="nav nav-tabs nav-tabs-dark nav-fill pt-1">
										<li class="nav-item"><a class="nav-link active"
											href="#ScoringSummary" data-toggle="tab">SCORING</a>
										</li>
										<li class="nav-item"><a class="nav-link" href="#PenaltySummary"
											data-toggle="tab">PENALITY</a></li>
									</ul>
								</div>
								<div class="card-body tab-content p-2">        	
      
     							 <div class="tab-pane" id="PenaltySummary">
<!--      								<div class="tableau-top">1ST PERIOD</div> -->

									<table class="table table-dark2 table-sm ">
<!-- 									<table class="table table-sm table-striped table-rounded-bottom"> -->
<!-- 										<thead> -->
<!-- 											<tr> -->
<!-- 												<th>SUMMARY</th> -->
<!-- 											</tr> -->
<!-- 										</thead> -->

										<thead>
											<tr>
												<th>1ST PERIOD</th>
											</tr>
										</thead>
										<tbody>
                                        	<?php
      
                                        if (array_key_exists('1',$gameHolder->getPenaltySummary())) {
                                            foreach ($gameHolder->getPenaltySummary()['1'] as $penaltyTemp) {

                                                
                                                echo '<tr >
                                                    <td>' . $penaltyTemp . '</td>
                                                </tr>';
                                            }
                                        }else{
                                            echo '<tr><td class="text-center" colspan="4">NO PENALTIES</td></tr>';
                                        }
                                        ?>
                                        </tbody>
									</table>
									
<!-- 								    <div class="tableau-top">2ND PERIOD</div> -->

									<table class="table table-dark2 table-sm ">
<!-- 									<table class="table table-sm table-striped table-rounded-bottom"> -->
<!-- 										<thead> -->
<!-- 											<tr> -->
<!-- 												<th>SUMMARY</th> -->
<!-- 											</tr> -->
<!-- 										</thead> -->

										<thead>
											<tr>
												<th>2ND PERIOD</th>
											</tr>
										</thead>
										<tbody>
                                        	<?php
      
                                        if (array_key_exists('2',$gameHolder->getPenaltySummary())) {
                                            foreach ($gameHolder->getPenaltySummary()['2'] as $penaltyTemp) {

                                                
                                                echo '<tr >
                                                    <td>' . $penaltyTemp . '</td>
                                                </tr>';
                                            }
                                        }else{
                                            echo '<tr><td class="text-center" colspan="4">NO PENALTIES</td></tr>';
                                        }
                                        ?>
                                        </tbody>
									</table>
									
<!-- 									<div class="tableau-top">3RD PERIOD</div> -->

									<table class="table table-dark2 table-sm">
<!-- 									<table class="table table-sm table-striped table-rounded-bottom"> -->
										<thead>
											<tr>
												<th>3RD PERIOD</th>
											</tr>
										</thead>
										<tbody>
                                        	<?php
      
                                        if (array_key_exists('3',$gameHolder->getPenaltySummary())) {
                                            foreach ($gameHolder->getPenaltySummary()['3'] as $penaltyTemp) {

                                                
                                                echo '<tr >
                                                    <td>' . $penaltyTemp . '</td>
                                                </tr>';
                                            }
                                        }else{
                                            echo '<tr><td class="text-center" colspan="4">NO PENALTIES</td></tr>';
                                        }
                                        ?>
                                        </tbody>
									</table>
									
									<?php if($isOvertime){ ?>
										
<!-- 									<div class="tableau-top">OVERTIME PERIOD</div> -->

										<table class="table table-dark2 table-sm">
<!-- 									<table class="table table-sm table-striped table-rounded-bottom"> -->
	<!-- 										<thead> -->
<!-- 											<tr> -->
<!-- 												<th>SUMMARY</th> -->
<!-- 											</tr> -->
<!-- 										</thead> -->
	     								<thead>
											<tr>
												<th>OVERTIME PERIOD</th>
											</tr>
										</thead>
										<tbody>
                                        	<?php
      
                                        if (array_key_exists('OT',$gameHolder->getPenaltySummary())) {
                                            foreach ($gameHolder->getPenaltySummary()['OT'] as $penaltyTemp) {

                                                
                                                echo '<tr >
                                                    <td>' . $penaltyTemp . '</td>
                                                </tr>';
                                            }
                                        }else{
                                            echo '<tr><td class="text-center" colspan="4">NO PENALTIES</td></tr>';
                                        }
                                        ?>
                                        </tbody>
									</table>
									<?php } ?>
									
									
     						    </div> <!-- end penalty summary -->
                        	
                        		<div class="tab-pane active" id="ScoringSummary"> <!-- start scoring summary -->
                        		        <?php
                                        $awayScoreCounter = 0;
                                        $homeScoreCounter = 0;
                                        ?>
<!-- 										<div class="tableau-top">1ST PERIOD</div> -->

										<table class="table table-dark2 table-sm">
<!-- 									<table class="table table-sm table-striped table-rounded-bottom"> -->
									   <!--<thead>
												<tr>
													<th style="width: 10%">Time</th>
													<th style="width: 20%">Team</th>
													<th style="width: 60%">Details</th>
													<th style="width: 10%">Score</th>
												</tr>
											</thead>-->
											<thead>
												<tr>
													<th colspan="4">1ST PERIOD</th>
												</tr>
											</thead>
											<tbody>
                                        	<?php
                                        foreach ($gameHolder->getScoringFirstPeriod() as $scoringTemp) {
                                            if ($scoringTemp['TEAM'] == strtoupper($homeTeam)) {
                                                $homeScoreCounter ++;
                                            } else {
                                                $awayScoreCounter ++;
                                            }

                                            echo '<tr >
                                                    <td style="width:23%">' . $scoringTemp['TEAM'] . '</td>
                                                    <td class="text-center" style="width:8%">' . $scoringTemp['TIME'] . '</td>
                                                    <td style="width:60%">' . $scoringTemp['SCORE'] . '</td>
                                                    <td class="text-center" style="width:9%">' . $awayScoreCounter . '-' . $homeScoreCounter . '</td>
                                                </tr>';
                                        }

                                        if (empty($gameHolder->getScoringFirstPeriod())) {
                                            echo '<tr><td class="text-center" colspan="4">NO SCORING</td></tr>';
                                        }
                                        ?>
                                        </tbody>
										</table>

<!-- 										<div class="tableau-top">2ND PERIOD</div> -->

<!-- 										<table class="table table-sm table-striped table-rounded-bottom"> -->
                                        <table class="table table-dark2 table-sm">
											
									   <!--<thead>
												<tr>
													<th style="width: 10%">Time</th>
													<th style="width: 20%">Team</th>
													<th style="width: 60%">Details</th>
													<th style="width: 10%">Score</th>
												</tr>
											</thead>-->
											<thead>
												<tr>
													<th colspan="4">2ND PERIOD</th>
												</tr>
											</thead>
											<tbody>
                                        	<?php
                                        foreach ($gameHolder->getScoringSecondPeriod() as $scoringTemp) {

                                            if ($scoringTemp['TEAM'] == strtoupper($homeTeam)) {
                                                $homeScoreCounter ++;
                                            } else {
                                                $awayScoreCounter ++;
                                            }

                                            echo '<tr >
                                                    <td style="width:23%">' . $scoringTemp['TEAM'] . '</td>
                                                    <td class="text-center" style="width:8%">' . $scoringTemp['TIME'] . '</td>
                                                    <td style="width:60%">' . $scoringTemp['SCORE'] . '</td>
                                                    <td class="text-center" style="width:9%">' . $awayScoreCounter . '-' . $homeScoreCounter . '</td>
                                                </tr>';
                                        }
                                        if (empty($gameHolder->getScoringSecondPeriod())) {
                                            echo '<tr><td class="text-center" colspan="4">NO SCORING</td></tr>';
                                        }
                                        ?>
                                        </tbody>
										</table>

<!-- 										<div class="tableau-top">3RD PERIOD</div> -->

										<table class="table table-dark2  table-sm">
<!-- 									<table class="table table-sm table-striped table-rounded-bottom"> -->
										   <!--<thead>
												<tr>
													<th style="width: 10%">Time</th>
													<th style="width: 20%">Team</th>
													<th style="width: 60%">Details</th>
													<th style="width: 10%">Score</th>
												</tr>
											</thead>-->
											<thead>
												<tr>
													<th colspan="4">3RD PERIOD</th>
												</tr>
											</thead>
											<tbody>
                                        	<?php

                                        foreach ($gameHolder->getScoringThirdPeriod() as $scoringTemp) {

                                            if ($scoringTemp['TEAM'] == strtoupper($homeTeam)) {
                                                $homeScoreCounter ++;
                                            } else {
                                                $awayScoreCounter ++;
                                            }

                                            echo '<tr >
                                                    <td style="width:23%">' . $scoringTemp['TEAM'] . '</td>
                                                    <td class="text-center" style="width:8%">' . $scoringTemp['TIME'] . '</td>
                                                    <td style="width:60%">' . $scoringTemp['SCORE'] . '</td>
                                                    <td class="text-center" style="width:9%">' . $awayScoreCounter . '-' . $homeScoreCounter . '</td>
                                                </tr>';
                                        }
                                        if (empty($gameHolder->getScoringThirdPeriod())) {
                                            echo '<tr><td class="text-center" colspan="4">NO SCORING</td></tr>';
                                        }
                                        ?>
                                        </tbody>
										</table>
                                    
                                    <?php if($isOvertime){ ?>
                                    
<!--                                         <div class="tableau-top">OVERTIME PERIOD</div> -->

										<table class="table table-dark2 table-sm">
<!-- 									<table class="table table-sm table-striped table-rounded-bottom"> -->
									   <!--<thead>
												<tr>
													<th style="width: 10%">Time</th>
													<th style="width: 20%">Team</th>
													<th style="width: 60%">Details</th>
													<th style="width: 10%">Score</th>
												</tr>
											</thead>-->
											<thead>
												<tr>
													<th colspan="4">OVERTIME PERIOD</th>
												</tr>
											</thead>
											<tbody>
                                        	<?php

                                        if (empty($gameHolder->getScoringOtPeriod())) {
                                            echo '<tr><td class="text-center" colspan="4">NO SCORING</td></tr>';
                                        } else {
                                            foreach ($gameHolder->getScoringOtPeriod() as $scoringTemp) {
                                                if ($scoringTemp['TEAM'] == strtoupper($homeTeam)) {
                                                    $homeScoreCounter ++;
                                                } else {
                                                    $awayScoreCounter ++;
                                                }

                                                echo '<tr >
                                                    <td style="width:23%">' . $scoringTemp['TEAM'] . '</td>
                                                    <td class="text-center" style="width:8%">' . $scoringTemp['TIME'] . '</td>
                                                    <td style="width:60%">' . $scoringTemp['SCORE'] . '</td>
                                                    <td class="text-center" style="width:9%">' . $awayScoreCounter . '-' . $homeScoreCounter . '</td>
                                                </tr>';
                                            }
                                        }
                                        ?>
                                        </tbody>
										</table>
                                   
                                    <?php }?>
                                   </div>
								</div>
							</div>
						</div>
					</div>

					<!-- end scoring summary -->


					<div class="row no-gutters">
						<div class="col-sm-12 col-lg-8 offset-lg-2">
							<div class="card border text-center" style="background-color:rgb(50, 52, 54); border-color: var(--color-primary-1) !important;" >
								<div id="rosterTabs" class="card-header text-white px-2 px-lg-4 pb-0 pt-2">
									<div class="text-center"><h5 class="mb-1">STATISTICS</h5></div>
									<ul class="nav nav-tabs nav-tabs-dark nav-fill pt-1">
										<li class="nav-item"><a class="nav-link active"
											href="#AwayTeamStats" data-toggle="tab"><?php echo $awayTeam?></a>
										</li>
										<li class="nav-item"><a class="nav-link" href="#HomeTeamStats"
											data-toggle="tab"><?php echo $homeTeam?></a></li>
									</ul>
								</div>
                                
                                <?php

                                $awayStats = $gameHolder->getAwayStats();
                                $homeStats = $gameHolder->getHomeStats();

                                // set initial sort (Points/G/A/Name)
                                function statCompare($stat1, $stat2)
                                {
                                    $returnValue = $stat2['P'] <=> $stat1['P'];

                                    if ($returnValue == 0) {
                                        $returnValue = $stat2['G'] <=> $stat1['G'];
                                    }

                                    if ($returnValue == 0) {
                                        $returnValue = $stat2['A'] <=> $stat1['A'];
                                    }

                                    if ($returnValue == 0) {
                                        $returnValue = $stat1['NAME'] <=> $stat2['NAME'];
                                    }

                                    return $returnValue;
                                }
                                ;

                                usort($awayStats, 'statCompare');
                                usort($homeStats, 'statCompare');

                                ?>
                                
                                <div
									class="card-body tab-content p-2">
									<div class="tab-pane active" id="AwayTeamStats">
<!-- 										<table id="tblAwayStats" class="table table-sm table-striped text-center"> -->
                                        <div class="stats-type-header"><h5>SKATERS</h5></div>
										<table id="tblAwayStats" class="table table-dark2 table-sm table-striped text-center">
											<thead>
												<tr>
													<th class="text-left">NAME</th>
													<th>G</th>
													<th>A</th>
													<th>PTS</th>
													<th>+/-</th>
													<th>SOG</th>
													<th>PIM</th>
													<th>HT</th>
													<th>IT</th>

												</tr>
											</thead>
											<tbody>
                                            	<?php
                                            foreach ($awayStats as $scoringTemp) {

                                                echo '<tr >
                                                        <td class="text-left">' . $scoringTemp['NAME'] . '</td>
                                                        <td>' . $scoringTemp['G'] . '</td>
                                                        <td>' . $scoringTemp['A'] . '</td>
                                                        <td>' . $scoringTemp['P'] . '</td>
                                                        <td>' . $scoringTemp['PLUSMINUS'] . '</td>
                                                        <td>' . $scoringTemp['S'] . '</td>
                                                        <td>' . $scoringTemp['PIM'] . '</td>
                                                        <td>' . $scoringTemp['HT'] . '</td>
                                                        <td>' . $scoringTemp['IT'] . '</td>
                                                    </tr>';
                                            }
                                            ?>
                                            </tbody>
										</table>
										<div class="stats-type-header"><h5>GOALIES</h5></div>
										<table id="goalieStatsAway" class="table table-dark2 table-sm table-striped text-center">	
        									<thead>
        										<tr>
        											<th class="text-left">NAME</th>
        											<th>S</th>
        											<th>SA</th>
        											<th>PCT</th>
        											<th>W/L</th>
        											<th>REC</th>
        										</tr>
        									</thead>
        									<tbody>
                                            	<?php
                                            	foreach ($gameHolder->getGoalieStats() as $goalieTemp) {
                                            	    
                                            	    if($goalieTemp['TEAM'] != $awayTeamAbbr) continue;
                                            	    
                                            	    $savePctTemp = round($goalieTemp['SAVES'] / $goalieTemp['SA'], 3);
                                            	 
                        
                                                    echo '<tr >
                                                            <td class="text-left">' . $goalieTemp['PLAYER'] . '</td>
                                                            <td>' . $goalieTemp['SAVES'] . '</td>
                                                            <td>' . $goalieTemp['SA'] . '</td>
                                                            <td>' . $savePctTemp . '</td>
                                                            <td>' . $goalieTemp['STATUS'] . '</td>
                                                            <td>' . $goalieTemp['RECORD'] . '</td>
                                                        </tr>';
                                            }
                                            ?>
                                            </tbody>
        								</table>
									</div>
									<div class="tab-pane" id="HomeTeamStats">
<!-- 										<table id="tblHomeStats" class="table table-sm table-striped text-center"> -->
                                        <div class="stats-type-header"><h5>SKATERS</h5></div>
                                        <table id="tblHomeStats" class="table table-dark2 table-sm table-striped text-center">
											
											<thead>
												<tr>
													<th class="text-left">NAME</th>
													<th>G</th>
													<th>A</th>
													<th>PTS</th>
													<th>+/-</th>
													<th>SOG</th>
													<th>PIM</th>
													<th>HT</th>
													<th>IT</th>

												</tr>
											</thead>
											<tbody>
                                            	<?php
                                            foreach ($homeStats as $scoringTemp) {

                                                echo '<tr >
                                                        <td class="text-left">' . $scoringTemp['NAME'] . '</td>
                                                        <td>' . $scoringTemp['G'] . '</td>
                                                        <td>' . $scoringTemp['A'] . '</td>
                                                        <td>' . $scoringTemp['P'] . '</td>
                                                        <td>' . $scoringTemp['PLUSMINUS'] . '</td>
                                                        <td>' . $scoringTemp['S'] . '</td>
                                                        <td>' . $scoringTemp['PIM'] . '</td>
                                                        <td>' . $scoringTemp['HT'] . '</td>
                                                        <td>' . $scoringTemp['IT'] . '</td>
                                                    </tr>';
                                            }
                                            ?>
                                            </tbody>
										</table>
										
										<div class="stats-type-header"><h5>GOALIES</h5></div>
										<table id="goalieStatsHome" class="table table-dark2 table-sm table-striped text-center">	
        									<thead>
       
        										<tr>
        											<th class="text-left">NAME</th>
        											<th>S</th>
        											<th>SA</th>
        											<th>PCT</th>
        											<th>W/L</th>
        											<th>REC</th>
        										</tr>
        									</thead>
        									<tbody>
                                            	<?php
                                            	foreach ($gameHolder->getGoalieStats() as $goalieTemp) {
                                            	    
                                            	    if($goalieTemp['TEAM'] != $homeTeamAbbr) continue;
                                            	    
                                            	    $savePctTemp = round($goalieTemp['SAVES'] / $goalieTemp['SA'], 3);
                                            	 
                        
                                                    echo '<tr >
                                                            <td class="text-left">' . $goalieTemp['PLAYER'] . '</td>
                                                            <td>' . $goalieTemp['SAVES'] . '</td>
                                                            <td>' . $goalieTemp['SA'] . '</td>
                                                            <td>' . $savePctTemp . '</td>
                                                            <td>' . $goalieTemp['STATUS'] . '</td>
                                                            <td>' . $goalieTemp['RECORD'] . '</td>
                                                        </tr>';
                                            }
                                            ?>
                                            </tbody>
        								</table>
									</div>
								</div>
							</div>
						</div>
						<script>

                		<!-- enable table sorting for stats tables -->
                        $(document).ready(function() 
                            { 
                                $("#tblAwayStats").tablesorter({ 
                                    sortInitialOrder: 'desc'
                            	}); 
                                $("#tblHomeStats").tablesorter({ 
                                    sortInitialOrder: 'desc'
                            	}); 
                            } 
                        ); 
      
                        </script>
					</div>
					<!-- end player statistics -->

                    <!-- shootout results notes -->
   
					<?php if($gameHolder->isShootout()){?>
					<div class="row no-gutters mt-3">
						
						<div class=" col col-lg-8 offset-lg-2">
							<div class="card border text-center p-2" style="background-color:rgb(50, 52, 54); border-color: var(--color-primary-1) !important;">
								<!--div class="card-header text-white px-2 py-1 pb-2">
									<div class="text-center">SHOOTOUT RESULTS</div>
								</div-->
									<div class="text-center"><h5 class="mb-1 text-white">SHOOTOUT RESULTS</h5></div>
								<!-- div class="card-body"-->
								
									<div class="p-2 text-white shootout-winner">SHOOTOUT WINNER: <?php echo $gameHolder->getShootoutWinner() ?></div>
								<table
									class="table table-dark2 table-sm table-striped text-center">
									<thead>

										<tr>
											<th>Shot #</th>
											<th><?php echo $awayTeam?></th>
											<th><?php echo $homeTeam?></th>
										</tr>
									</thead>
									<tbody>
                            			<?php
                                            $counter = 0;
                                            $row = 1;
                                    
                                            foreach ($gameHolder->getShootoutSummary() as $shootOutResult) {
 
                                                if ($counter % 2 == 0) {
                                                    echo '<tr role="row">';
                                                    echo '<td>'.$row.'</td>';
                                                }
                                    
                                                echo '<td>'.$shootOutResult.'</td>';
                                                
                                                if ($counter % 2 != 0) {
                                                    echo '</tr>';
                                                    $row++;
                                                } 
                                                
                                                $counter++;
                
                                            }
                                    
                                         ?>

                            		</tbody>
								</table>
								<!-- /div-->
            					
							</div>
						</div>

					</div>
					<?php }?>
					<!-- end game notes -->
					
					<div class="row no-gutters mt-3">
						<!-- game notes -->
						<div class=" col col-lg-8 offset-lg-2">
							<div class="card border text-center p-2" style="background-color:rgb(50, 52, 54); border-color: var(--color-primary-1) !important;">
								<div class="card-header text-white px-2 py-1 pb-2">
									<div class="text-center">GAME NOTES</div>
								</div>
<!--     							<table class="table table-sm table-striped table-rounded"> -->
            					<table class="table table-dark2 table-sm table-striped text-center">

    								<tbody>
                                		
                                			<?php foreach($gameHolder->getGameNotes() as $gameNote){?>
                                    		<tr>
    										<td><?php echo $gameNote ?></td>
    									</tr>
                                    		<?php } ?>
                                    		
                                    		<?php if(empty($gameHolder->getGameNotes())){ ?>
                                    		<tr>
    										<td class="text-center">NONE</td>
    									</tr>
                                    		<?php } ?>
                                		</tbody>
    							</table>
							</div>
						</div>

					</div>
					<!-- end game notes -->
					
					<div class="row no-gutters mt-3">
						<!-- three stars -->
						<div class=" col col-lg-8 offset-lg-2">
							<div class="card border text-center p-2" style="background-color:rgb(50, 52, 54); border-color: var(--color-primary-1) !important;">
								<div class="card-header text-white px-2 py-1 pb-2">
									<div class="text-center">GAME STARS</div>
								</div>
            					<table class="table table-dark2 table-sm table-striped text-center">

    								<tbody>
                                		
                                		
                                    		
                                    		<?php foreach($gameHolder->getThreeStars() as $stars){?>
                                    		<tr>
    											<td><?php echo $stars['NUM'] ?></td>
    											<td class="text-left"><?php echo $stars['PLAYER'] ?></td>
    											<td class="text-left"><?php echo $stars['TEAM'] ?></td>
        									</tr>
                                        	<?php } ?>
 
                                		</tbody>
    							</table>
							</div>
						</div>

					</div>

				</div>
				<!-- end card body -->
			</div>
			<!-- end card -->
		</div>
		<!-- main col -->
	</div>
	<!-- end main row -->

	<!-- start farm -->
	<div class="row no-gutters mt-1">
		<div class="col">

			<div class="accordion" id="farmAccordian">
				<div class="card">
					<div id="headingOne" class="card-header p-1 text-center text-white"
						style="background-color: rgb(50, 52, 54);">

						<h5 class="mb-0 border-bottom" style="border-color: rgb(128, 128, 128) !important;">
							<button class="btn btn-link text-white" type="button" data-toggle="collapse"
								data-target="#collapseOne" aria-expanded="true"
								aria-controls="collapseOne">
                          	MINOR LEAGUE BOX SCORE <?php //echo $gameHolder->getFarmAwayScore().' '.$gameHolder->getFarmHomeScore().' FINAL' ?>
                        </button>
						</h5>
					</div>

					<div id="collapseOne" class="collapse"
						aria-labelledby="headingOne" data-parent="#farmAccordian">
						<div class="card-body pt-0"
							style="background-color: rgb(50, 52, 54);">
							<div id="scoreMain border-bottom">
								<div class="row no-gutters py-3 border-bottom" style="border-color: rgb(128, 128, 128) !important;">
									<!-- start main score -->
									<div class="col-12 col-md-6 pr-md-1 pb-2 pb-md-0">
										<div class="teamheader logo-gradient border">
                                        	<?php
                                        //$teamCardLogoSrc = glob($folderTeamLogos . 'farm/' . strtolower($awayTeam) . '.*');
                                        	$teamCardLogoSrc = getTeamLogoUrl($awayTeam, true);
                                        	
                                        ?>
                                         	<div
												class="team-logo gloss logo-gradient">
                                                <?php
                                                if (isset($teamCardLogoSrc)) {
                                                    echo '<img src="' . $teamCardLogoSrc . '" alt="' . $awayTeam . '">';
                                                }
                                                ?>
                                             </div>
											<div class="team-logo gloss gradient-score team-right score">
												<div><?php echo $gameHolder->getFarmAwayScore()?></div>
											</div>

											<div class="header-container">

												<div class="gloss"></div>
												<div class="header">
													<h3 style="margin-top: 13px"><?php echo $gameHolder->getFarmAwayTeam() ?></h3>
                                        			<?php //echo $teamInfoAway->getWins().'-'.$teamInfoAway->getLosses().'-'.$teamInfoAway->getTies() ?>
                                        			<?php //echo '('.$teamInfoAway->getPlaceString().' '.$teamInfoAway->getConferenceSafeString().')' ?>
                                        			
                                        		</div>
											</div>
										</div>
									</div>

									<div id="awayHeader" class="col-12 col-md-6 pl-md-1">
										<div class="teamheader logo-gradient border">
                                        	<?php
                                        //$teamCardLogoSrc = glob($folderTeamLogos . 'farm/' . strtolower($homeTeam) . '.*');
                                        	$teamCardLogoSrc = getTeamLogoUrl($homeTeam, true);
                                        ?>
                                         	<div
												class="team-logo gloss logo-gradient logo-home">
                                                <?php
                                                if (isset($teamCardLogoSrc)) {
                                                    echo '<img src="' . $teamCardLogoSrc . '" alt="' . $homeTeam . '">';
                                                }
                                                ?>
                                             </div>
											<div class="team-logo gloss gradient-score team-right score">
												<div><?php echo $gameHolder->getFarmHomeScore()?></div>
											</div>

											<div class="header-container">

												<div class="gloss"></div>
												<div class="header">
													<h3 style="margin-top: 13px"><?php echo $gameHolder->getFarmHomeTeam() ?></h3>
                                        			<?php //echo $teamInfoHome->getWins().'-'.$teamInfoHome->getLosses().'-'.$teamInfoHome->getTies() ?>
                                        			<?php //echo '('.$teamInfoHome->getPlaceString().' '.$teamInfoHome->getConferenceSafeString().')' ?>
                                        			
                                        		</div>
											</div>
										</div>
									</div>

								</div>
								<!-- end row -->

								<div class="row no-gutters mt-2">

									<div class="col-12 col-md-6 offset-md-3 pr-md-1 pb-2 pb-md-0">

										<table class="table-dark2 table-sm">
											<thead>
												<tr>
													<th>GOALIES</th>
												</tr>
											</thead>
											<tbody>
                                            		
                                            			<?php foreach($gameHolder->getFarmGoalies() as $farmGoalieTemp){?>
                                                			<tr>
													<td><?php echo $farmGoalieTemp ?></td>
												</tr>
                                                		<?php } ?>
    
                                            		</tbody>
										</table>

										<table class="table-dark2 table-sm">
											<thead>
												<tr>
													<th>SCORING SUMMARY</th>
												</tr>
											</thead>
											<tbody>
                                            		
                                            			<?php foreach($gameHolder->getFarmScoringSummary() as $farmScoringTemp){?>
                                                		<tr>
													<td><?php echo $farmScoringTemp ?></td>
												</tr>
                                                		<?php } ?>
                                                		
                                                		<?php if(empty($gameHolder->getFarmScoringSummary())){ ?>
                                                		<tr>
													<td class="text-center">NONE</td>
												</tr>
                                                		<?php } ?>
                                            		</tbody>
										</table>

									</div>



								</div>
								<!-- end farm summary -->

							</div>
						</div>

					</div>

				</div>
			</div>

		</div>
	</div>


</div>
<!-- end contaainer -->

<script>

$(document).ready(function() 
	    { 
        	$('.collapse').on('shown.bs.collapse', function(e) {
        	    var $card = $(this).closest('.card');
        	    $('html,body').animate({
        	        scrollTop: $card.offset().top - 55
        	    }, 500);
        	});
	    } 
	); 
	
</script>




<?php include 'footer.php'; ?>
