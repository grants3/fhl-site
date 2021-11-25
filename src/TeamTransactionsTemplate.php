<?php
require_once 'config.php';
include_once 'lang.php';
include_once 'common.php';
include_once 'fileUtils.php';

include_once 'classes/TransactionHolder.php';
include_once 'classes/TransactionTradeObj.php';
include_once 'classes/TransactionEventObj.php';
include_once 'classes/TeamAbbrHolder.php';

$seasonId = '';
$seasonType= null;

if(isset($_GET['seasonId']) || isset($_POST['seasonId'])) {
    $seasonId = ( isset($_GET['seasonId']) ) ? $_GET['seasonId'] : $_POST['seasonId'];
    $seasonId = filter_var($seasonId, FILTER_VALIDATE_INT);
}

if(isset($_GET['seasonType']) || isset($_POST['seasonType'])) {
    $seasonType = ( isset($_GET['seasonType']) ) ? $_GET['seasonType'] : $_POST['seasonType'];
}

if(isset($_GET['team']) || isset($_POST['team'])) {
    $team = ( isset($_GET['team']) ) ? $_GET['team'] : $_POST['team'];
    //$team = filter_var($seasonId, FILTER_SANITIZE_STRING);
}

$fileName = _getLeagueFile('Transact', $seasonType,$seasonId);
$scoringFile = _getLeagueFile('TeamScoring', $seasonType,$seasonId);

if(empty($team)){
    http_response_code(400);
    exit('team not found');
}

if(!file_exists($fileName)) {
    echo '<div class="card"><div class="card-body"><h6 class="text-center">'.$allNoSeasonDataFound.'</h6></div></div>';
    
    exit;
}

$transactionHolder = new TransactionHolder($fileName);
$teamAbbrHolder = new TeamAbbrHolder($scoringFile);

$teamAbbr = $teamAbbrHolder->getAbbr($team);

?>

<style>

#TeamTrades td,
#TeamEvents td {
  white-space: normal !important; 
  word-wrap: break-word;  
}
#TeamTrades table,
#TeamEvents table {
  table-layout: fixed;
}
</style>

<div class="card">
	<div id="standingsTabs" class="card-header p-1">
		<ul class="nav nav-tabs nav-fill">
        	<?php
			$eventsActive = '';
			if(TRANSACTIONS_TRADES_ENABLED){?>
			<li class="nav-item"><a	class="nav-link active" href="#TeamTrades"	data-toggle="tab"><?php echo $transactTrades;?></a></li>
			<?php }else{ $eventsActive = 'active';}?>
			
			<li class="nav-item"><a	class="nav-link <?php echo $eventsActive;?>" href="#TeamEvents" data-toggle="tab"><?php echo $transactTitle;?></a></li>
			<li class="nav-item"><a	class="nav-link" href="#TransactInjuries" data-toggle="tab"><?php echo $transactInj;?></a></li>
		</ul>
	</div>
	
	
	<div class="card-body tab-content p-1">
		<?php if(TRANSACTIONS_TRADES_ENABLED){?>
		<div class="tab-pane active" id="TeamTrades">
			<div id="ExtensionsInner">
				<div class="row no-gutters">
                	<div class="col">
<!--                 		<div class="tableau-top">Trades</div> -->
                		<div class="table-responsive">
                    		<table id = "trades-table" class="table table-sm table-striped table-hover table-rounded-bottom">
                    			<thead class="text-uppercase">
                                    <tr>
										
										<th class="col-2"><?php echo $transactTeam;?></th>
										<th class="col-5"><?php echo $transactTraded?></th>
										<th class="col-5"><?php echo $transactReceiving?></th>
                                    </tr>
                    			</thead>
                    			<tbody>
									<?php foreach (array_reverse($transactionHolder->getTeamTrades($team)) as $trade) { ?>
             						  	    <tr>
             						  	    	<!-- current team could be team 1 or team 2 from a transaction. Only show team info from the 'other' team -->
             						  	    	<?php if($team == $trade->getTeam1()) {
                 						  	    	
             						  	    	    $teamPlayers = $trade->getToTeam2();
                 						  	    	$tradingTeam = $trade->getTeam2();
                 						  	    	$tradingPlayers = $trade->getToTeam1();
             						  	    	}else{
             						  	    	    $teamPlayers = $trade->getToTeam1();
             						  	    	    $tradingTeam = $trade->getTeam1();
             						  	    	    $tradingPlayers = $trade->getToTeam2();
             						  	    	}
             						  	    	    
             						  	    	?>
             						  	    	<td><?php echo $tradingTeam ?></td>
												<td><?php echo $teamPlayers ?></td>
												
												<td><?php echo $tradingPlayers ?></td>
											</tr> 
            						<?php }?>
                    			</tbody>	
                    		</table>
                		</div>
                	</div>
                
                </div> <!-- end table -->
			</div>
		</div> <!-- end tab pane -->
		<?php }?>
		
		<div class="tab-pane <?php echo $eventsActive;?>" id="TeamEvents">
			<div id="SigningsInner">
				<div class="row no-gutters">
                	<div class="col">
                		<!-- <div class="tableau-top">Transactions</div> -->
                		<div class="table-responsive">
                    		<table id = "team-events-table" class="table table-sm table-striped table-hover table-rounded-bottom ">
                    			<thead class="text-uppercase">
                                    <tr>
             							<th class="col-4"><?php echo $transactTitle;?></th> 
             							<th class="col-8"><?php echo $transactDetails;?></th> 
                                    </tr>
                    			</thead>
                    			<tbody>
            						<?php 
            						$reversedEvents = array_reverse($transactionHolder->getTeamEventsByType($team, $teamAbbr, TransactionHolder::$typeTransaction), true);
            						foreach ($reversedEvents as $event) { ?>
             						    <tr> 
            						    	<td><?php echo $event->getAction(); ?></td>
            						    	<td><?php echo $event->getValue(); ?></td>
             						    </tr> 
            						<?php }?>
                    			</tbody>	
                    		</table>
                		</div>
                	</div>
                
                </div> <!-- end table -->
			</div>
		</div>
		
		<div class="tab-pane" id="TransactInjuries">
			<div id="InjuriesInner">
				<div class="row no-gutters">
                	<div class="col">
<!--                 		<div class="tableau-top">Injuries</div> -->
                		<div class="table-responsive">
                    		<table id = "team-injuries-table" class="table table-sm table-striped table-hover table-rounded-bottom ">
                    			<thead class="text-uppercase">
                                    <tr>
                                    	<th class="col-4"><?php echo $transactPlayers?></th> 
             							<th class="col-8"><?php echo $transactStatus?></th> 
             							
                                    </tr>
                    			</thead>
                    			<tbody>
            						<?php 
            						$reversedEvents = array_reverse($transactionHolder->getTeamEventsByType($team, $teamAbbr, TransactionHolder::$typeInjury), true);
            						foreach ($reversedEvents as $event) { ?>
             						    <tr> 
             						   		<td><?php echo $event->getValue(); ?></td>
            						    	<td><?php echo $event->getAction(); ?></td>
             						    </tr> 
            						<?php }?>
                    			</tbody>	
                    		</table>
                		</div>
                	</div>
                
                </div> <!-- end table -->
			</div>
		</div>

	</div>

</div>



<script>

$("#trades-table").tablesorter({ 
    sortInitialOrder: 'asc'
}); 

$("#team-events-table").tablesorter({ 
    sortInitialOrder: 'asc'
}); 

$("#team-injuries-table").tablesorter({ 
    sortInitialOrder: 'asc'
}); 

// $("#trades-table").tablesorter({ 
//     sortInitialOrder: 'asc'
// }); 

	

</script>




