<?php
require_once 'config.php';
require_once 'lang.php';
include_once 'fileUtils.php';

$CurrentHTML = 'TeamTransactions.php';
$CurrentTitle = 'Transactions';
$CurrentPage = 'TeamTransactions';

include 'head.php';
include 'TeamHeader.php';

//get seasons which will be used to populate previous season dropdown if they exist
$previousSeasons = getPreviousSeasons(CAREER_STATS_DIR);
?>

<style>

#loaderImage {
    background: url("assets/img/loader.gif") no-repeat scroll center center #FFF;

    height: 100%;
    width: 100%;
}
</style>



<div class = "container px-0">
	<div class="card">
    	<div class="card-header p-1">
    	
    		 <?php include 'TeamCardHeader.php'; ?>
    	
    	</div>
    	<div class="card-body p-1">
    			<?php include 'component/SeasonSelect.php';?>
    			
    			<div class="row">
    				
    				<div class="col"> 
             			<div id="loaderImage"><img class="mx-auto d-block" src="assets/img/loader.gif"></div>
<!--                         <div id="loaderImage" class="loaderImage">test</div> -->
    			
    		
            			<div id = "contracts"></div>
            		</div>
    			</div>
    
    		</div>
        </div>
</div>

<script type="text/javascript">

//         $(window).load(function(){
//             $('#loaderImage').fadeOut(1000);
            
//         });


		var currentTeam = '<?php echo $currentTeam?>';

		$(document).ready(function() 
		    { 
				$('#loaderImage').show();
				//var seasonId = $("#contractsMenu option[value='" + seasonId + "']").value();
				var seasonId = $("#contractsMenu").find(':selected').val();
				load(seasonId);
		    } 
		); 


        $('#typeMenu').on('change', function() {

        	$("#contracts").hide();
        	$('#loaderImage').show();

        	var seasonType = this.value;
			var seasonId = $('#seasonMenu').find(":selected").val();

        	load(seasonId,seasonType);

        });
        
        $('#seasonMenu').on('change', function() {

        	$("#contracts").hide();
        	$('#loaderImage').show();

        	var seasonId = this.value;
        	var seasonType = $('#typeMenu').find(":selected").val();

        	load(seasonId,seasonType);

        });

        function load(seasonId, seasonType){
            
          	 $.ajax({
        	    url: 'TeamTransactionsTemplate.php',
        	    data: {seasonId: seasonId, seasonType: seasonType, team: currentTeam},
      		    cache: false,
      		    dataType: "html",
      		    success: function(data) {
      		        $("#contracts").html(data);
      		        $("#loaderImage").hide();
      		    	$("#contracts").show();
      		    },
              	 error: function(XMLHttpRequest, textStatus, errorThrown) {
           	 		$('#contracts').html('<p>Error loading data</p>');
           	 		$("#loaderImage").hide();
           	 	}
      			});
        }


         
 		</script>




<?php include 'footer.php'; ?>