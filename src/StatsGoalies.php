<?php
require_once __DIR__.'/config.php';
include_once FS_ROOT.'lang.php';
include_once FS_ROOT.'common.php';

include_once 'classes/ScoringHolder.php';
include_once 'classes/ScoringPlayerObj.php';
include_once 'classes/ScoringGoalieObj.php';
include_once 'classes/ScoringObj.php';
include_once 'classes/ScoringAccumulator.php';

$CurrentHTML = 'StatsGoalies.php';
$CurrentTitle = 'Statistics';
$CurrentPage = 'StatsGoalies';

$dataTablesRequired = 1; //require datatables import

if(isset($_GET['seasonId']) || isset($_POST['seasonId'])) {
    $seasonId = htmlspecialchars(( isset($_GET['seasonId']) ) ? $_GET['seasonId'] : $_POST['seasonId']);
}

if(isset($_GET['seasonType']) || isset($_POST['seasonType'])) {
    $seasonType = ( isset($_GET['seasonType']) ) ? $_GET['seasonType'] : $_POST['seasonType'];
    
    $playoff = htmlspecialchars($seasonType);
}

//gaa is column5. handles this better
$sort = 5;
if(isset($_GET['sort']) || isset($_POST['sort'])) {
    $sort = htmlspecialchars(( isset($_GET['sort']) ) ? $_GET['sort'] : $_POST['sort']);
}

$sortOrder='asc';
if(isset($_GET['sortOrder']) || isset($_POST['sortOrder'])) {
    $sortOrder = htmlspecialchars(( isset($_GET['sortOrder']) ) ? $_GET['sortOrder'] : $_POST['sortOrder']);
    $sortOrder = strtolower($sortOrder);
}


//tab activation
$goaliesActive = 'active';

if(trim($seasonId) == false){
    $fileName = getLeagueFile($folder, $playoff, 'TeamScoring.html', 'TeamScoring');
}else{
    $seasonFolder =  str_replace("#",$seasonId,CAREER_STATS_DIR);
    $fileName = getLeagueFile($seasonFolder, $playoff, 'TeamScoring.html', 'TeamScoring');
}

$scoringHolder = new ScoringHolder($fileName, $currentTeam);
$shootoutMode = $scoringHolder->isShootoutMode();
$tieLabel = $shootoutMode ? $scoringOTLm : $scoringTm;
$tieTitle = $shootoutMode ? $scoringOTL : $scoringT;

include 'head.php';

?>


<div class="container px-0">

	<div class="card">
		<?php include 'SectionHeader.php';?>
		 <div class="card-header pt-0">
          <?php include 'StatsHeader.php';?>
        </div>
    	<div class="card-body p-2">
			
			<div class="row no-gutters" id="searchFields">
<!-- 				<div class="col"> -->
					<!-- position -->
<!-- 					<div class="row no-gutters"> -->
<!-- 						<div class="input-group mb-3 col-sm-6"> -->
<!-- 							<div class="input-group-prepend"> -->
<!-- 								<label class="input-group-text" for="positionInputField">Position</label> -->
<!-- 							</div> -->
<!-- 							<select class="custom-select" id="positionInputField"> -->
<!-- 								<option value="">All Players</option> -->
<!-- 								<option value="Skaters">All Skaters</option> -->
<!-- 								<option value="Forwards">All Forwards</option> -->
<!-- 								<option value="C">Center</option> -->
<!-- 								<option value="RW">Right Wing</option> -->
<!-- 								<option value="LW">Left Wing</option> -->
<!-- 								<option value="D">Defense</option> -->
<!-- 								<option value="G">Goalie</option> -->
<!-- 							</select> -->
<!-- 						</div> -->
<!-- 					</div> -->
<!-- 				</div> -->
			</div>
			
			<div>
				<table id="goalie-stats-table" class="table table-sm table-sm-px table-striped dt-responsive nowrap w-100">
					<thead>
						<tr>
						   	<th data-toggle="tooltip" data-placement="top" title="<?php echo $scoringName ?>" class="text-left"><?php echo $scoringName ?></th>
                			<th data-toggle="tooltip" data-placement="top" title="<?php echo $scoringTM?>"><?php echo $scoringTM ?></th>
                			<th data-toggle="tooltip" data-placement="top" title="<?php echo $rostersPosition ?>">PO</th>
                			<th data-toggle="tooltip" data-placement="top" title="<?php echo $scoringRookie?>">R</th>
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
					<tbody>
					</tbody>
				</table>
			</div><!--row-->
			
		</div><!--card-body-->
	</div><!--card-->
</div>

<script>


$(function() {
	var table = $('#goalie-stats-table').DataTable({
		//dom: 'lftBip',
		dom:'<"row no-gutters"<"col-sm-12 col-md-4"l><"col-sm-12 col-md-8"f>><ti><"row no-gutters"<"col-sm-12 col-md-8"p><"col-sm-12 col-md-4"B>>',
		"processing":false,
		"serverSide":true,  
		"responsive": true,
		searchDelay: 500,
		scrollY:        true,
        scrollX:        true,
        scrollCollapse: false,
        fixedColumns:   {
            leftColumns: 1
        },
		"lengthMenu": [[25, 50, 100, 200, -1], [25, 50, 100, 200, "All"]],
        language: {
            "lengthMenu": "Display _MENU_ records"
        },   
		"order": [[ "<?php echo $sort;?>", "<?php echo $sortOrder;?>" ]],
		"ajax": {
			//url : '<?php echo BASE_URL.'api/scoring'; ?>',
			url : '<?php echo BASE_URL.'api?api=stats&type=goalie'; ?>',
				type: "GET"  
			},
			"columns": [
				//{ name: "name" ,data: "name" },
				{"name": "name" ,data: "name",
                    "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                        $(nTd).html("<a href='<?php echo BASE_URL?>CareerStatsPlayer.php?csName="+ encodeURIComponent(oData.name)+"'>"+oData.name+"</a>");
                    }
                },
				{ name: "team" ,data: "team" },
                { name: "position" ,data: "position" },
                {"name": "rookieStatus" ,data: "rookieStatus",
                    "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                        $(nTd).html((oData.rookieStatus > 0 ) ? "*":"");
                    }
                },
                { name: "gamesPlayed" , data: "gamesPlayed", "orderSequence": [ "desc","asc" ] },
                { name: "minutes" , data: "minutes", "orderSequence": [ "desc","asc" ] },
                { name: "gaa" , data: "gaa", "orderSequence": [ "asc","desc" ] },
                { name: "wins" , data: "wins", "orderSequence": [ "desc","asc" ] },
                { name: "losses" , data: "losses", "orderSequence": [ "desc","asc" ] },
                { name: "ties" , data: "ties", "orderSequence": [ "desc","asc" ] },
                { name: "shutouts" , data: "shutouts", "orderSequence": [ "desc","asc" ] },
                { name: "goalsAgainst" , data: "goalsAgainst", "orderSequence": [ "desc","asc" ] },
                { name: "savesAttempted" , data: "savesAttempted", "orderSequence": [ "desc","asc" ] },
                { name: "savePct" , data: "savePct", "orderSequence": [ "desc","asc" ] },
                { name: "pim" , data: "pim", "orderSequence": [ "desc","asc" ] },
                { name: "assists" , data: "assists", "orderSequence": [ "desc","asc" ] },
            ],
			"columnDefs":[  
				{  
// 					"targets":[0],  
// 					"orderable":false,
				},  
				{
                	"targets": [ 2 ],
                	"visible": false
            	},
				{ "orderSequence": [ "<?php echo $sortOrder;?>" ], "targets": [ <?php echo $sort;?> ] },
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


	});


</script>


<?php include 'footer.php'; ?>
