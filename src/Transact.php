<?php

require_once 'config.php';
require_once 'common.php';
require_once 'lang.php';
$dataTablesRequired = 1;

$CurrentHTML = 'Transact.php';
$CurrentTitle = $transactTitle;
$CurrentPage = 'Transact';

include 'phpGetAbbr.php'; // Output $TSabbr

include_once 'classes/TransactionHolder.php';
include_once 'classes/TransactionTradeObj.php';
include_once 'classes/TransactionEventObj.php';

include 'head.php';

$fileName = getLeagueFile('Transact');
$transactionHolder = new TransactionHolder($fileName);

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

<div class="container px-0">

	<div class="card">
		<?php include 'SectionHeader.php';?>
		
		<div class="card-body p-1">

            <div class="card">
            	<div id="transactTabs" class="card-header px-2 px-lg-4 pb-1 pt-2">
            		<ul class="nav nav-tabs nav-fill">
            			<li class="nav-item"><a	class="nav-link" href="#TransactTrades"	data-toggle="tab">Trades</a></li>
            			<li class="nav-item"><a	class="nav-link active" href="#TransactEvents"	data-toggle="tab">Transactions</a></li>
            			<li class="nav-item"><a	class="nav-link" href="#TransactInjuries" data-toggle="tab">Injuries</a></li>
            		</ul>
            	</div>
            	<div class="card-body tab-content m-0 p-0 pt-2">
            		
            		<div class="tab-pane" id="TransactTrades">
						<div id="TransactTradesInner">
							<div class="row no-gutters">
								<div class="col">
									<table id="trades-table" class="table table-sm table-striped table-rounded-bottom" style="width:100%">
										<thead>
											<tr>
												<th class="col-1">Team 1</th>
												<th class="col-5">Players 1</th>
												<th class="col-1">Team 2</th>
												<th class="col-5">Players 2</th>
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
					
					<div class="tab-pane active" id="TransactEvents">
						<div id="TransactEventsInner">
							<div class="row no-gutters">
								<div class="col">
									<table id="events-table" class="table table-sm table-striped table-rounded-bottom" style="width:100%">
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
						<div id="TransactInjuriesInner">
							<div class="row no-gutters">
								<div class="col">
									<table id="inj-table" class="table table-sm table-striped table-rounded-bottom" style="width:100%">
										<thead style="width:100%">
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
            	
            		
            	
            	</div> <!-- end card body -->
            
            </div>
		</div>
	</div>
</div>

<script>

$(function() {

	var transTables = [
      "#trades-table",
      "#events-table",
      "#inj-table"
    ];
    
    for (let index = 0; index < transTables.length; ++index) {
    	var test =  $(transTables[index]).DataTable({
		//dom: 'lftBip',
		dom:'<"row no-gutters"<"col-sm-6 col-md-4"l><"col-sm-6 col-md-8"f>><ti><"row no-gutters"<"col-sm-12 col-md-8"p><"col-sm-12 col-md-4">>',
		scrollY:        false,
        scrollX:        false,
        scrollCollapse: false,
        order: [],
        paging:         true,
        pagingType: "numbers",
        lengthMenu: [[25, 50, 100, 200, -1], [25, 50, 100, 200, "All"]],
        language: {
            "lengthMenu": "_MENU_"
        },   
        search: {
            "regex": true
          },    
        initComplete: function () {
        	$(transTables[index]).show(); 
        	
        	
        }
	});
	}
	
	//need to adjust columns if datatable initialized while hidden.
	$('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
        $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
    });


   
});




</script>

<?php include 'footer.php'; ?>