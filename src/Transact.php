<?php

require_once 'config.php';
require_once 'common.php';
require_once 'lang.php';

$CurrentHTML = 'Transact.php';
$CurrentTitle = $transactTitle;
$CurrentPage = 'Transact';

include 'phpGetAbbr.php'; // Output $TSabbr

include_once 'classes/TransactionHolder.php';
include_once 'classes/TransactionTradeObj.php';
include_once 'classes/TransactionEventObj.php';

include 'head.php';

$matches = glob($folder.'*'.$playoff.'Transact.html');
$folderLeagueURL = '';
$matchesDate = array_map('filemtime', $matches);
arsort($matchesDate);
foreach ($matchesDate as $j => $val) {
    if((!substr_count($matches[$j], 'PLF') && $playoff == '') || (substr_count($matches[$j], 'PLF') && $playoff == 'PLF')) {
        $folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'Transact')-strrpos($matches[$j], '/')-1);
        break 1;
    }
}
$filename = $folder.$folderLeagueURL.'Transact.html';

$transactionHolder = new TransactionHolder($filename);

if(DEBUG_MODE){
    error_log(jsonPrettify(json_encode($transactionHolder )));
}


?>

<style>

#TransactInjuries td, 
#TransactEvents td, 
#TransactTrades td {
  white-space: normal !important; 
  word-wrap: break-word;  
}

#TransactInjuries table, 
#TransactEvents table,
#TransactTrades table {
  table-layout: fixed;
}
</style>

<div class="container">

	<div class="card">
		<?php include 'SectionHeader.php';?>
		
		<div class="card-body">

            <div class="card">
            	<div id="transactTabs" class="card-header px-2 px-lg-4 pb-1 pt-2">
            		<ul class="nav nav-tabs nav-fill">
            			<li class="nav-item"><a	class="nav-link active" href="#TransactTrades"	data-toggle="tab">Trades</a></li>
            			<li class="nav-item"><a	class="nav-link" href="#TransactEvents"	data-toggle="tab">Transactions</a></li>
            			<li class="nav-item"><a	class="nav-link" href="#TransactInjuries" data-toggle="tab">Injuries</a></li>
            		</ul>
            	</div>
            	<div class="card-body tab-content m-0 p-0 pt-2">
            		
            		<div class="tab-pane active" id="TransactTrades">
						<div id="TransactTradesInner">
							<div class="row no-gutters">
								<div class="col-sm-12 col-md-12">
									<table
										class="table table-sm table-striped table-rounded-bottom">
										<thead>
											<tr>
												<th class="col-2">Team 1</th>
												<th class="col-4">Players 1</th>
												<th class="col-2">Team 2</th>
												<th class="col-4">Players 2</th>
											</tr>
										</thead>
										<tbody> 
            							
            						<?php foreach ($transactionHolder->getTrades() as $trade) { ?>
             						    <tr>
												<td><?php echo $trade->getTeam1(); ?></td>
												<td><?php echo $trade->getToTeam1(); ?></td>
												<td><?php echo $trade->getTeam2(); ?></td>
												<td><?php echo $trade->getToTeam2(); ?></td>
											</tr> 
            						<?php }?>
            						
             						</tbody>

									</table>
								</div>
							</div>
						</div>
					</div>
            		
            		<div class="tab-pane" id="TransactEvents">
            			<div id="TransactEventsInner">
            				 			<div class="row no-gutters"> 
             				<div class="col-sm-12 col-md-12"> 
             					<table class="table table-sm table-striped table-rounded-bottom"> 
             						<thead> 
             							<tr> 
             								<th class="col-2">Team</th> 
             								<th class="col-3">Transaction</th> 
             								<th class="col-7">Details</th> 
             							</tr> 
             						</thead> 
             						<tbody> 
            							
            						<?php foreach ($transactionHolder->getEventsByType(TransactionHolder::$typeTransaction) as $event) { ?>
             						    <tr> 
            						    	<td><?php echo $event->getTeam(); ?></td>
            						    	<td><?php echo $event->getAction(); ?></td>
            						    	<td><?php echo $event->getValue(); ?></td>
             						    </tr> 
            						<?php }?>
            						
             						</tbody> 
            
             					</table> 
             				</div> 
             			</div> 
            			</div>	
            		</div>
            		
            		<div class="tab-pane" id="TransactInjuries">
            			<div id="TransactEventsInner">
            				 			<div class="row no-gutters"> 
             				<div class="col-sm-12 col-md-12"> 
             					<table class="table table-sm table-striped table-rounded-bottom"> 
             						<thead> 
             							<tr> 
             								<th class="col-2">Team</th> 
             								<th class="col-3">Player</th> 
             								<th class="col-7">Status</th> 
             								
             							</tr> 
             						</thead> 
             						<tbody> 
            							
            						<?php foreach ($transactionHolder->getEventsByType(TransactionHolder::$typeInjury) as $event) { ?>
             						    <tr> 
            						    	<td><?php echo $event->getTeam(); ?></td>
            						    	<td><?php echo $event->getValue(); ?></td>
            						    	<td><?php echo $event->getAction(); ?></td>
             						    </tr> 
            						<?php }?>
            						
             						</tbody> 
            
             					</table> 
             				</div> 
             			</div> 
            			</div>	
            		</div>
            	</div>
            
            </div>
		</div>
	</div>
</div>

<?php include 'footer.php'; ?>