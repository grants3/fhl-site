<?php
require_once __DIR__.'/config.php';
include_once FS_ROOT.'lang.php';
include_once FS_ROOT.'common.php';

include_once 'classes/ScoringHolder.php';
include_once 'classes/ScoringPlayerObj.php';
include_once 'classes/ScoringGoalieObj.php';
include_once 'classes/ScoringObj.php';
include_once 'classes/ScoringAccumulator.php';

$CurrentHTML = 'StatsSkaters.php';
$CurrentTitle = 'Statistics';
$CurrentPage = 'StatsSkaters';

$dataTablesRequired = 1; //require datatables import

//tab activation
$skatersActive = 'active';

include 'head.php';

$seasonId = null;
$seasonType = LEAGUE_MODE;
$position = '';
$rookie = '';

if(isset($_GET['seasonId']) || isset($_POST['seasonId'])) {
    $seasonId = htmlspecialchars(( isset($_GET['seasonId']) ) ? $_GET['seasonId'] : $_POST['seasonId']);
}

if(isset($_GET['seasonType']) || isset($_POST['seasonType'])) {
    $seasonType = ( isset($_GET['seasonType']) ) ? $_GET['seasonType'] : $_POST['seasonType'];
}

if(isset($_GET['position']) || isset($_POST['position'])) {
    $position = ( isset($_GET['position']) ) ? $_GET['position'] : $_POST['position'];
}

if(isset($_GET['rookie']) || isset($_POST['rookie'])) {
    $rookie = ( isset($_GET['rookie']) ) ? $_GET['rookie'] : $_POST['rookie'];
}

//points is column7. handles this better
$sort = 7;
if(isset($_GET['sort']) || isset($_POST['sort'])) {
    $sort = htmlspecialchars(( isset($_GET['sort']) ) ? $_GET['sort'] : $_POST['sort']);
}

?>

<style>

</style>

<div class="container px-0">

	<div class="card">
		<?php include 'SectionHeader.php';?>
		 <div class="card-header pt-0">
          <?php include 'StatsHeader.php';?>
        </div>
    	<div class="card-body p-2">
			
			<div class="row no-gutters" id="searchFields">
				<div class="col">
					<!-- position -->
					<div class="row no-gutters">
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
								title="<?php echo $scoringTM?>"><?php echo $scoringTM ?></th>
							<th data-toggle="tooltip" data-placement="top"
								title="<?php echo $rostersPosition?>">PO</th>
							<th data-toggle="tooltip" data-placement="top"
								title="<?php echo $scoringRookie?>">R</th>
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

<?php if($position){?>
	//needs to be set before datatable initializes
	$("#positionInputField option[value=D]").attr('selected', 'selected');

<?php }?>

$(function() {
	var table = $('#player-scoring-table').DataTable({
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
		"order": [[ "<?php echo $sort?>", "desc" ]],
       
        "searchCols": [
            null,
            null,
             <?php if($position){?>
            { "search": "<?php echo $position;?>"},
                <?php }else{ echo 'null,';}?>
            <?php if($rookie){?>
            { "search": "<?php echo $rookie;?>"},
                <?php }else{ echo 'null,';}?>
          ],
    
		
		"ajax": {
			url : '<?php echo BASE_URL.'api?api=stats&action=find'; ?>',
				type: "GET",
				data: function ( d ) {
					d.seasonId = '<?php echo $seasonId?>';
               		d.seasonType = '<?php echo $seasonType?>';
        		}
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
                //{ name: "rookieStatus" ,data: "rookieStatus" },
                {"name": "rookieStatus" ,data: "rookieStatus",
                    "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                        $(nTd).html((oData.rookieStatus > 0 ) ? "*":"");
                    }
                },
                { name: "gamesPlayed" , data: "gamesPlayed", "orderSequence": [ "desc","asc" ] },
                { name: "goals" , data: "goals", "orderSequence": [ "desc","asc" ] },
                { name: "assists" , data: "assists", "orderSequence": [ "desc","asc" ] },
                { name: "points" , data: "points", "orderSequence": [ "desc","asc" ] },
                { name: "plusMinus" , data: "plusMinus", "orderSequence": [ "desc","asc" ] },
                { name: "pim" , data: "pim", "orderSequence": [ "desc","asc" ] },
                { name: "ppg" , data: "ppg", "orderSequence": [ "desc","asc" ] },
                { name: "shg" , data: "shg", "orderSequence": [ "desc","asc" ] },
                { name: "gwg" , data: "gwg", "orderSequence": [ "desc","asc" ] },
                { name: "gtg" , data: "gtg", "orderSequence": [ "desc","asc" ] },
                { name: "hits" , data: "hits", "orderSequence": [ "desc","asc" ] },
                { name: "shots" , data: "shots", "orderSequence": [ "desc","asc" ] },
                { name: "shotPct" , data: "shotPct", "orderSequence": [ "desc","asc" ] },
                { name: "goalStreak" , data: "goalStreak", "orderSequence": [ "desc","asc" ] },
                { name: "pointStreak" , data: "pointStreak", "orderSequence": [ "desc","asc" ] },
            ],
			"columnDefs":[  
				{  
// 					"targets":[0],  
// 					"orderable":false,
				},  
				{
                	"targets": [ 3 ],
                	"visible": true
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
