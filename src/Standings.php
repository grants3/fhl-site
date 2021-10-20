<?php
require_once 'config.php';
include 'lang.php';
include_once 'common.php';

$CurrentHTML = 'Standings.php';
$CurrentTitle = $standingTitle;
$CurrentPage = 'Standings';

include 'head.php';

$playoffActive = '';
$seasonActive = '';
if(isPlayoffs2()){
    //$playoffActive = 'active';
   // $seasonActive = '';
}else{
   // $playoffActive = '';
   // $seasonActive = 'active';
}

//get seasons which will be used to populate previous season dropdown if they exist
$previousSeasons = getPreviousSeasons(CAREER_STATS_DIR);

?>

<div class="container px-0">

	<div class="card">
	
		<?php include 'SectionHeader.php';?>
		
		<div class="card-body px-2 px-md-3">

			<div class="col-sm-12 col-md-6 col-lg-4" style="display: flex;">

				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="seasonMenuHeader">Season</span>
					</div>

					<select class="form-control" aria-label="Select Season"
						id="seasonMenu" aria-describedby="seasonMenuHeader">
						<option value="Current">Current</option>
						<?php 
                        //set dropdown dynamically from prev season dirs
						if (!empty($previousSeasons)) {
						    foreach ($previousSeasons as $prevSeason) {
						        echo '<option value='.$prevSeason.'>'.$prevSeason.'</option>';
						    }
						}
					
						?>
					</select>
				</div>
			</div>


			<div class="card">
				<div id="standingsTabs" class="card-header px-2 px-lg-4 pb-1 pt-2">
					<ul class="nav nav-tabs nav-fill">
						<li class="nav-item"><a
							class="nav-link <?php echo $seasonActive?>" href="#Season"
							data-toggle="tab">Regular Season</a></li>

						<li class="nav-item"><a
							class="nav-link <?php echo $playoffActive?>" href="#Playoffs"
							data-toggle="tab">Playoffs</a></li>
					</ul>
				</div>
				<div class="card-body tab-content m-0 p-0 pt-2">
					<div class="tab-pane  <?php echo $seasonActive?>" id="Season">
						<div id="SeasonInner">
        						<?php include 'StandingsTemplate.php'; ?>
        					</div>
					</div>

					<div class="tab-pane <?php echo $playoffActive?>" id="Playoffs">
						<div id="PlayoffsInner">
        						<?php include 'StandingsTreeTemplate.php'; ?>
        					</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>


<script>

	

	//$('#Season').load('./StandingsTemplate.php');
	//$('#Playoffs').load('./StandingsTreeTemplate.php');

    $("#seasonMenu").on('change', function() {  
        var selection = $(this).val();

    	if(selection == 'Current'){
    		selection = '';
    	}

    	//window.location.hash = selection;
    	
    	$.ajax({
    	    type: "GET",
    	    cache:false,
    	    dataType: "html",
    	    url: '<?php echo BASE_URL?>StandingsTemplate.php',
    	    data: {seasonId: selection},
    	    success: function(data){
    	    	$('#SeasonInner').html(data.trim());
    	    }
    	});

    	$.ajax({
    	    type: "GET",
    	    cache:false,
    	    dataType: "html",
    	    url: '<?php echo BASE_URL?>StandingsTreeTemplate.php',
    	    data: {seasonId: selection},
    	    success: function(data){
    	    	$('#PlayoffsInner').html(data.trim());
    	    }
    	});
    	
    	var activeTab = $('[href="' + location.hash + '"]');
  
        if (activeTab.length) {
            activeTab.tab('show');
        } else {
            $('.nav-tabs a:first').tab('show');
        }
        
    } );


$(document).ready(function() {

	var isPlayoffs = <?php echo isPlayoffs2() ? 'true' : 'false';?>;

	//handle active tab.
    var url = document.location.toString();
    if (url.match('#')) {
       $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
    }else{
    	//just default to first table active.
    	if(isPlayoffs){
    		$('.nav-tabs a[href="#Playoffs"]').tab('show');
    	}else{
    		$('.nav-tabs a:first').tab('show');
    	}
       
    }

	  // add a hash to the URL when the user clicks on a tab
    $('a[data-toggle="tab"]').on('click', function(e) {
        history.pushState(null, null, $(this).attr('href'));
    });

    // navigate to a tab when the history changes
    window.addEventListener("popstate", function(e) {
        var activeTab = $('[href="' + location.hash + '"]');
  
        if (activeTab.length) {
            activeTab.tab('show');
        } else {
            $('.nav-tabs a:first').tab('show');
        }
    });
});

</script>


<?php include 'footer.php'; ?>
