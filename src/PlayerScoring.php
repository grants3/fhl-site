<?php
require_once 'config.php';
include_once 'lang.php';
include_once 'common.php';

include_once 'classes/ScoringHolder.php';
include_once 'classes/ScoringPlayerObj.php';
include_once 'classes/ScoringGoalieObj.php';
include_once 'classes/ScoringObj.php';
include_once 'classes/ScoringAccumulator.php';
//include_once 'api/scoring/PlayerScoringController.php';

$CurrentHTML = 'PlayerScoring.php';
$CurrentTitle = 'Player Statistics';
$CurrentPage = 'PlayerScoring';

$seasonId = '';
$playoff = '';

$dataTablesRequired = 1; //require datatables import

if(isset($_GET['seasonId']) || isset($_POST['seasonId'])) {
    $seasonId = htmlspecialchars(( isset($_GET['seasonId']) ) ? $_GET['seasonId'] : $_POST['seasonId']);
}

if(isset($_GET['seasonType']) || isset($_POST['seasonType'])) {
    $seasonType = ( isset($_GET['seasonType']) ) ? $_GET['seasonType'] : $_POST['seasonType'];
    
    $playoff = htmlspecialchars($seasonType);
}

// if(isset($_GET['team']) || isset($_POST['team'])) {
//     $currentTeam = ( isset($_GET['team']) ) ? $_GET['team'] : $_POST['team'];
//     $currentTeam = htmlspecialchars($currentTeam);
    
// }
//$controller = new PlayerScoringController('GET', array(), $fileName, $team);

include 'head.php';

?>
<div class="container">

	<div class="card">
		<?php include 'SectionHeader.php';?>
    	<div class="card-body p-2">
			<div class="row" id="searchFields">
				<div class="col">
					<!-- position -->
					<div class="row">
						<div class="input-group mb-3 col-sm-6">
							<div class="input-group-prepend">
								<label class="input-group-text" for="positionInputField">Position</label>
							</div>
							<select class="custom-select" id="positionInputField">
								<option value="">All Players</option>
								<option value="Skaters">All Skaters</option>
								<option value="Forwards">All Forwards</option>
								<option value="C">Center</option>
								<option value="RW">Right Wing</option>
								<option value="LW">Left Wing</option>
								<option value="D">Defense</option>
								<option value="G">Goalie</option>
							</select>
						</div>
					</div>
				</div>
			</div>

			<div>
				<table id="player-scoring-table" class="table table-sm table-sm-px table-striped dt-responsive nowrap w-100">
					<thead>
						<tr>
							<th data-toggle="tooltip" data-placement="top"
								title="<?php echo $scoringName?>" class="text-left"><?php echo $scoringName?></th>
							<th data-toggle="tooltip" data-placement="top"
								title="<?php echo $scoringTM?>"><?php echo $scoringTMm ?></th>
							<th data-toggle="tooltip" data-placement="top"
								title="<?php echo $rostersPosition?>">PO</th>
							<th data-toggle="tooltip" data-placement="top"
								title="<?php echo $scoringGP?>"><?php echo $scoringGPm ?></th>
							<th data-toggle="tooltip" data-placement="top"
								title="<?php echo $scoringG?>"><?php echo $scoringGm?></th>
							<th data-toggle="tooltip" data-placement="top"
								title="<?php echo $scoringAssits?>">A</th>
							<th data-toggle="tooltip" data-placement="top"
								title="<?php echo 'Points'?>">P</th>
							<th data-toggle="tooltip" data-placement="top"
								title="<?php echo $scoringDiff?>">+/-</th>
							<th data-toggle="tooltip" data-placement="top"
								title="<?php echo $scoringPIM?>"><?php echo $scoringPIMm?></th>
							<th data-toggle="tooltip" data-placement="top"
								title="<?php echo $scoringPP?>"><?php echo $scoringPPm?></th>
							<th data-toggle="tooltip" data-placement="top"
								title="<?php echo $scoringSH?>"><?php echo $scoringSHm?></th>
							<th data-toggle="tooltip" data-placement="top"
								title="<?php echo $scoringGW?>"><?php echo $scoringGWm?></th>
							<th data-toggle="tooltip" data-placement="top"
								title="<?php echo $scoringGT?>"><?php echo $scoringGTm?></th>
							<th data-toggle="tooltip" data-placement="top"
								title="<?php echo $scoringHT?>"><?php echo $scoringHTm?></th>
							<th data-toggle="tooltip" data-placement="top"
								title="<?php echo $scoringS?>"><?php echo $scoringSm?></th>
							<th data-toggle="tooltip" data-placement="top"
								title="<?php echo $scoringPCTG?>"><?php echo $scoringPCTGm?></th>
							<th data-toggle="tooltip" data-placement="top"
								title="<?php echo $scoringGS?>"><?php echo $scoringGSm?></th>
							<th data-toggle="tooltip" data-placement="top"
								title="<?php echo $scoringPS?>"><?php echo $scoringPSm?></th>

						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div><!--row-->
			
		</div><!--card-body-->
	</div><!--card-->
</div>
<script>


$(function() {
	var table = $('#player-scoring-table').DataTable({
		//dom: 'lftBip',
		dom:'<"row"<"col-sm-12 col-md-4"l><"col-sm-12 col-md-8"f>><ti><"row"<"col-sm-12 col-md-8"p><"col-sm-12 col-md-4"B>>',
		"processing":false,
		"serverSide":true,  
		"responsive": true,
		searchDelay: 500,
		scrollY:        true,
        scrollX:        true,
        scrollCollapse: false,
        order: [[ "points", "desc" ]],
        fixedColumns:   {
            leftColumns: 1
        },
		"lengthMenu": [[25, 50, 100, 200, -1], [25, 50, 100, 200, "All"]],
        language: {
            "lengthMenu": "Display _MENU_ records"
        },   
		"order": [[ "6", "desc" ]],
		"ajax": {
			url : '<?php echo BASE_URL.'api/scoring'; ?>',
				type: "GET"  
			},
			"columns": [
				{ name: "name" ,data: "name" },
				{ name: "team" ,data: "team" },
				//{ name: "number" ,data: "number" },
                { name: "position" ,data: "position" },
                { name: "gamesPlayed" , data: "gamesPlayed" },
                { name: "goals" , data: "goals" },
                { name: "assists" , data: "assists" },
                { name: "points" , data: "points" },
                { name: "plusMinus" , data: "plusMinus" },
                { name: "pim" , data: "pim" },
                { name: "ppg" , data: "ppg" },
                { name: "shg" , data: "shg" },
                { name: "gwg" , data: "gwg" },
                { name: "gtg" , data: "gtg" },
                { name: "hits" , data: "hits" },
                { name: "shots" , data: "shots" },
                { name: "shotPct" , data: "shotPct" },
                { name: "goalStreak" , data: "goalStreak" },
                { name: "pointStreak" , data: "pointStreak" },
            ],
			"columnDefs":[  
				{  
// 					"targets":[0],  
// 					"orderable":false,
				},  
			],
			"initComplete": function () {
		        	//$("#table-news").show(); 
		        },
		    "buttons": [
		        	'copy',
		            {
		                extend: 'excel',
		                title: 'Skater Statistics',
		                className: 'btn btn-primary',
		                exportOptions: {
		                    modifier: {
		                    	order : 'current', // 'current', 'applied','index', 'original'
		                        page : 'all', // 'all', 'current'
		                        search : 'applied' // 'none', 'applied', 'removed' 
		                    }
		                }
			                
		            },
		            {
		                extend: 'csv',
		                title: 'Skater Statistics',
		                exportOptions: {
		                    modifier: {
		                    	order : 'current', // 'current', 'applied','index', 'original'
		                        page : 'all', // 'all', 'current'
		                        search : 'applied' // 'none', 'applied', 'removed' 
		                    }
		                }
		            }
		        ]
		            
		         
		});

        $("#positionInputField").on('change', function() {  
            var pos = $(this).val();
            if(pos == 'Skaters'){
            	table.column('position:name').search('[C]|[RW]|[LW]|[D]', true, false).draw();
            }else if(pos == 'Forwards'){
            	table.column( 'position:name' ).search('[C]|[RW]|[LW]', true, false).draw();
            }else{
            	table.column('position:name').search(pos).draw() ; 
            }    
            
        } );

	});


	</script>


<?php include 'footer.php'; ?>
