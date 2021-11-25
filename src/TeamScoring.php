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
        	<div class = "row no-gutters">
            	<div class="col-sm-12 col-md-10 offset-md-1">
    			<?php include 'component/SeasonSelect.php';?>
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