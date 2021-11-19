<?php
//set headers to NOT cache a page
//header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
//header("Pragma: no-cache"); //HTTP 1.0
//header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

require_once 'config.php';
include 'lang.php';
include_once 'fileUtils.php';

$CurrentHTML = 'TeamScoring.php';
$CurrentTitle = $scoringTitle;
$CurrentPage = 'TeamScoring';

include 'head.php';
include 'TeamHeader.php';

//get seasons which will be used to populate previous season dropdown if they exist
$previousSeasons = getPreviousSeasons(CAREER_STATS_DIR);
?>

<style>

.selection-content { 
    padding-bottom: 7px; 
    padding-top: 7px; 
    margin-bottom: 10px; 
    border-radius:5px; 
    text-align:center;
 
}


</style>


<div class="container px-0">

	<div class="card">

		<div class="card-header p-1">
		
		 <?php include 'TeamCardHeader.php' ?>
			
		</div>
		<!--end card header -->
		<div class="card-body p-1">
			<div class="row selection-content2 justify-content-center no-gutters">
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
<!-- 									<option selected value=REG>Regular</option> -->
<!-- 									<option value=PLF>Playoffs</option> -->

                                        <?php 

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
			
			<div id="scoringInner">
     
     		<?php //include 'TeamScoringTemplate.php';?>
     
    		</div>

		</div>

		
	</div>
</div>


<script type="text/javascript">


var currentTeam = '<?php echo $currentTeam?>';
var playoffMode = <?php echo PLAYOFF_MODE?>;

$(window).on('pageshow', function(){

	if (window.performance && window.performance.navigation.type == window.performance.navigation.TYPE_BACK_FORWARD) {
	    var seasonSelection = $('#seasonMenu').find(":selected").val();
	    var typeSelection = $('#typeMenu').find(":selected").val();
		handleSelection(seasonSelection, typeSelection);
	}else{
// 		var seasonSelection = $('#seasonMenu').find(":selected").val();
// 		var typeSelection = playoffMode ? 'PLF' : '';
		
// 		handleSelection(seasonSelection, typeSelection);
	}
});

//init
$(function() {
    var seasonSelection = $('#seasonMenu').find(":selected").val();
		var typeSelection = playoffMode ? 'PLF' : '';
		
		handleSelection(seasonSelection, typeSelection);
});


$("#seasonMenu").on('change', function() {  
    var seasonSelection = $(this).val();
    var typeSelection = $('#typeMenu').find(":selected").val();

	handleSelection(seasonSelection, typeSelection);

	if(seasonSelection == 'Current'){
		if(!playoffMode){
			$("#typeMenu option[value=PLF").attr("disabled", true);
		}else{
			$("#typeMenu option[value=PLF").removeAttr('disabled');	
		}
	}else{
		$("#typeMenu option[value=PLF").removeAttr('disabled');	
	}
    
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

	$.ajax({
	    type: "GET",
	    url: 'TeamScoringTemplate.php',
	    data: {seasonId: season, seasonType: type, team:currentTeam},
	    success: function(data){
	    	$('#scoringInner').html(data);

	    	window.location.hash = hash;
	    }
	});
}


function generateHash(season, type) {
	return season + '-' + type;
}


</script>

<?php include 'footer.php'; ?>