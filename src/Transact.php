<?php

require_once 'config.php';
require_once 'lang.php';
require_once 'common.php';
include_once 'fileUtils.php';

$dataTablesRequired = 1;

$CurrentHTML = 'Transact.php';
$CurrentTitle = $transactTitle;
$CurrentPage = 'Transact';

//get seasons which will be used to populate previous season dropdown if they exist
$previousSeasons = getPreviousSeasons(CAREER_STATS_DIR);

include 'head.php';

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
			<div class="row selection-content2 justify-content-left no-gutters">
				<div class="col col-md-8 col-lg-6">
					<div class="row no-gutters">
						<div class="col py-1 pr-1">
							<div class="input-group">
								<div class="input-group-prepend">
									<label class="input-group-text" for="seasonMenu"><?php echo $homeSeason;?></label>
								</div>

								<select class="col custom-select" id="seasonMenu">
									<option selected value="Current"><?php echo $allCurrent;?></option>
									<?php 

									if (!empty($previousSeasons)) {
									    foreach ($previousSeasons as $prevSeason) {
									        echo '<option value='.$prevSeason.'>'.$prevSeason.'</option>';
									    }
									}
								
									?>
								</select>
							</div>
						</div>


						<div class="col py-1">
							<div class="input-group">
								<div class="input-group-prepend">
									<label class="input-group-text" for="typeMenu"><?php echo $seasonType;?></label>
								</div>
								<select class="custom-select" id="typeMenu">
                                        <?php 
                                        //if(isPlayoffs($folder, $playoffMode)){
                                        if(PLAYOFF_MODE){
                                            echo '<option value=REG>'.$seasonRegular.'</option>';
                                            echo '<option selected value=PLF>'.$seasonPLF.'</option> ';
                                        }else{
                                            echo '<option selected value=REG>'.$seasonRegular.'</option>';
                                            echo '<option disabled value=PLF >'.$seasonPLF.'</option> ';
                                        }
                                        ?>
								</select>
							</div>
						</div>

					</div>
				</div>

			</div>
			
            <div class="card">
            	<div id="transactTabs" class="card-header px-2 px-lg-4 pb-1 pt-2">
            		<ul class="nav nav-tabs nav-fill">
            			<?php
            			$eventsActive = '';
            			if(TRANSACTIONS_TRADES_ENABLED){?>
            			<li class="nav-item"><a	class="nav-link active" href="#TransactTrades"	data-toggle="tab"><?php echo $transactTrades;?></a></li>
            			<?php }else{ $eventsActive = 'active';}?>
            			<li class="nav-item"><a	class="nav-link <?php echo $eventsActive;?>" href="#TransactEvents"	data-toggle="tab"><?php echo $transactTitle;?></a></li>
            			<li class="nav-item"><a	class="nav-link" href="#TransactInjuries" data-toggle="tab"><?php echo $transactInj;?></a></li>
            		</ul>
            	</div>
            	<div class="card-body tab-content m-0 p-0 pt-2">
            		
            		<?php if(TRANSACTIONS_TRADES_ENABLED){?>
            		<div class="tab-pane active" id="TransactTrades">
						<div id="TransactTradesInner">
							<div class="row no-gutters">
								<div class="col">
									<table id="trades-table" class="table table-sm table-striped table-rounded-bottom" style="width:100%">
										<thead class="text-uppercase">
											<tr>
												<th class="col-1"><?php echo $transactTeam;?> 1</th>
												<th class="col-5"><?php echo $transactTeam;?> 1 <?php echo $transactReceiving?></th>
												<th class="col-1"><?php echo $transactTeam;?> 2</th>
												<th class="col-5"><?php echo $transactTeam;?> 2 <?php echo $transactReceiving?></th>
											</tr>
										</thead>
										<tbody> 

            						
             						</tbody>

									</table>
								</div>
							</div>
						</div>
					</div>
					<?php }?>
					
					<div class="tab-pane <?php echo $eventsActive;?>" id="TransactEvents">
						<div id="TransactEventsInner">
							<div class="row no-gutters">
								<div class="col">
									<table id="events-table" class="table table-sm table-striped table-rounded-bottom" style="width:100%">
										<thead class="text-uppercase">
											<tr>
												<th class="col-2"><?php echo $transactTeam;?></th> 
                 								<th class="col-3"><?php echo $transactTitle;?></th> 
                 								<th class="col-7"><?php echo $transactDetails;?></th> 
											</tr>
										</thead>
										<tbody> 
            		
            						
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
										<thead style="width:100%" class="text-uppercase">
											<tr>
												<th class="col-2"><?php echo $transactTeam;?></th> 
                 								<th class="col-3"><?php echo $transactPlayers;?></th> 
                 								<th class="col-7"><?php echo $transactStatus?></th> 
											</tr>
										</thead>
										<tbody> 
    
            						
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

<?php if(TRANSACTIONS_TRADES_ENABLED){?>
var tradesTable = $('#trades-table').DataTable({
	dom:'<"row no-gutters"<"col-sm-12 col-md-4"l><"col-sm-12 col-md-8"f>><ti><"row no-gutters"<"col-sm-12 col-md-8"p><"col-sm-12 col-md-4"B>>',
	"processing":false,
	"serverSide":true,  
	"responsive": true,
	searchDelay: 500,
	scrollY:        true,
    scrollX:        true,
    scrollCollapse: false,
	"lengthMenu": [[25, 50, 100, 200, -1], [25, 50, 100, 200, "All"]],
    language: {
        emptyTable: "Sim data not found",
        <?php if($leagueLang == 'FR') echo 'url: \''.BASE_URL.'assets/other/dt.lang.fr\','?>
    },   
    "order": [],
	"ajax": {
		url : '<?php echo 'api?api=trans&action=find&type=trade'; ?>',
			type: "GET",
            "data": function ( d ) {
               d.seasonId = getSeasonSelection();
               d.seasonType = getSeasonTypeSelection();
        	},
    		error: function (xhr, error, thrown) {

            }
		},
		"columns": [
				{ name: "team1" ,data: "team1" },
				{ name: "toTeam1" ,data: "toTeam1" },
				{ name: "team2" ,data: "team2" },
				{ name: "toTeam2" ,data: "toTeam2" },
            ],
			"columnDefs":[  

			]
    
		}); 
<?php }?>


var eventsTable = $('#events-table').DataTable({
	dom:'<"row no-gutters"<"col-sm-12 col-md-4"l><"col-sm-12 col-md-8"f>><ti><"row no-gutters"<"col-sm-12 col-md-8"p><"col-sm-12 col-md-4"B>>',
	"processing":false,
	"serverSide":true,  
	"responsive": true,
	searchDelay: 500,
	scrollY:        true,
    scrollX:        true,
    scrollCollapse: false,
	"lengthMenu": [[25, 50, 100, 200, -1], [25, 50, 100, 200, "All"]],
    language: {
        emptyTable: "Sim data not found",
        <?php if($leagueLang == 'FR') echo 'url: \''.BASE_URL.'assets/other/dt.lang.fr\','?>
    },   
    "order": [],
	"ajax": {
		url : '<?php echo 'api?api=trans&action=find&type=trans'; ?>',
		type: "GET",
        "data": function ( d ) {
           d.seasonId = getSeasonSelection();
           d.seasonType = getSeasonTypeSelection();
    	},
		error: function (xhr, error, thrown) {

        }
	},
	"columns": [
			{ name: "team" ,data: "team" },
			{ name: "transaction" ,data: "action" },
			{ name: "details" ,data: "value" },
        ],
	"columnDefs":[]

	});
		
var injuriesTable = $('#inj-table').DataTable({
	dom:'<"row no-gutters"<"col-sm-12 col-md-4"l><"col-sm-12 col-md-8"f>><ti><"row no-gutters"<"col-sm-12 col-md-8"p><"col-sm-12 col-md-4"B>>',
	"processing":false,
	"serverSide":true,  
	"responsive": true,
	searchDelay: 500,
	scrollY:        true,
    scrollX:        true,
    scrollCollapse: false,
	"lengthMenu": [[25, 50, 100, 200, -1], [25, 50, 100, 200, "All"]],
    language: {
        emptyTable: "Sim data not found",
        <?php if($leagueLang == 'FR') echo 'url: \''.BASE_URL.'assets/other/dt.lang.fr\','?>
        
    },   
    "order": [],
	"ajax": {
		url : '<?php echo 'api?api=trans&action=find&type=inj'; ?>',
			type: "GET",
        	"data": function ( d ) {
           		d.seasonId = getSeasonSelection();
           		d.seasonType = getSeasonTypeSelection();
    		},
    		error: function (xhr, error, thrown) {

            }
		},
		"columns": [
				{ name: "team" ,data: "team" },
				{ name: "player" ,data: "value" },
				{ name: "status" ,data: "action" },
            ],
			"columnDefs":[  

			]
    
		});

	
//need to adjust columns if datatable initialized while hidden.
$('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
    $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
});


//selection handling
var currentTeam = '<?php echo $currentTeam?>';
var playoffMode = <?php echo $currentPLF?>;

$(window).on('pageshow', function(){

	if (window.performance && window.performance.navigation.type == window.performance.navigation.TYPE_BACK_FORWARD) {
	    var seasonSelection = $('#seasonMenu').find(":selected").val();
	    var typeSelection = $('#typeMenu').find(":selected").val();
		handleSelection(seasonSelection, typeSelection);
	}
});


$("#seasonMenu").on('change', function() {  
    var selection = $(this).val();
    var typeSelection = $('#typeMenu').find(":selected").val();



	var seasonSelection = $('#seasonMenu').find(":selected").val();
	if(seasonSelection == 'Current'){
		if(!playoffMode){
			$("#typeMenu option[value=PLF").attr("disabled", true);
		}else{
			$("#typeMenu option[value=PLF").removeAttr('disabled');	
		}
	}else{
		$("#typeMenu option[value=PLF").removeAttr('disabled');	
	}
	
	handleSelection(selection, typeSelection);
    
} );

$("#typeMenu").on('change', function() {  
    var selection = $(this).val();
    var seasonSelection = $('#seasonMenu').find(":selected").val();

	handleSelection(seasonSelection, selection);
 
} );

function handleSelection(season, type){

	var hash = generateHash(season, type);
	
	if(season == 'Current'){
		season = '';
	}

	if(type == 'REG'){
		type = '';
	}
	
	$('.table').DataTable().ajax.reload();

	window.location.hash = hash;
}

function getSeasonSelection(){
    var season = null;
	var seasonSelection = $('#seasonMenu').find(":selected").val();
	 
	if(seasonSelection != 'Current'){
		season = seasonSelection;
	}
	
	return season;
}

function getSeasonTypeSelection(){
	return $('#typeMenu').find(":selected").val();
}


function generateHash(season, type) {
	return season + '-' + type;
}


   
});




</script>

<?php include 'footer.php'; ?>