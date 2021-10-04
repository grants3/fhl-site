<?php
require_once 'config.php';
include 'lang.php';
$CurrentHTML = 'Transactions.php';
$CurrentTitle = 'Transactions';
$CurrentPage = 'Transactions';
include 'head.php';
?>

<div class = "container">
	
	<div class = "card">
		<?php include 'SectionHeader.php';?>
		
		<div class = "card-body">
    		<div class="input-group mb-3 col-sm-6 px-0 px-md-3">
    		
    	
				<div class="input-group-prepend">
					<label class="input-group-text" for="yaerSearchField">Year</label>
				</div>
	
                <select name="tradesMenu" class="form-control" id="tradesMenu" aria-describedby="yaerSearchField">
    				<option value="30">Current</option>
    				<option value="29">Season 29</option>
    				<option value="28">Season 28</option>
					<option value="27">Season 27</option>
        			<option data-legacy value="26">Season 26</option>
                    <option data-legacy value="25">Season 25</option>
                    <option data-legacy value="24">Season 24</option>
                    <option data-legacy value="23">Season 23</option>
                    <option data-legacy value="22">Season 22</option>
                    <option data-legacy value="21">Season 21</option>
                    <option data-legacy value="20">Season 20</option>
                    <option data-legacy value="19">Season 19</option>
                    <option data-legacy value="18">Season 18</option>
                    <option data-legacy value="17">Season 17</option>
                    <option data-legacy value="16">Season 16</option>
                    <option data-legacy value="15">Season 15</option>
                    <option data-legacy value="14">Season 14</option>
                    <option data-legacy value="13">Season 13</option>
                    <option data-legacy value="12">Season 12</option>
                    <option data-legacy value="11">Season 11</option>
                    <option data-legacy value="10">Season 10</option>
                    <option data-legacy value="9">Season 9</option>
                    <option data-legacy value="8">Season 8</option>
                    <option data-legacy value="7">Season 7</option>
                    <option data-legacy value="6">Season 6</option>
                    <option data-legacy value="5">Season 5</option>
                    <option data-legacy value="4">Season 4</option>
                    <option data-legacy value="3">Season 3</option>
                    <option data-legacy value="2">Season 2</option>
                    <option data-legacy value="1">Season 1</option>

                </select>
	
    		</div>
    		
    		<div class="col px-0 px-md-3"> 
    				<div class="loaderImage"><img class="mx-auto d-block" src="assets/img/loader.gif"></div>
    				<div ALIGN=LEFT id = 'trades'></div>
    		</div>
		</div>
	</div>

</div>

<script type="text/javascript">


	$(document).ready(function() 
	    { 
			$('.loaderImage').show();
			//var seasonId = $("#contractsMenu option[value='" + seasonId + "']").value();
			var seasonId = $("#tradesMenu").find(':selected').val();
			load(seasonId);
	    } 
	); 


    $('#tradesMenu').on('change', function() {

    	$("#trades").hide();
    	$('.loaderImage').show();

    	var seasonId = this.value;

    	window.location.hash = seasonId;

    	//var attr = $(this).attr('data-legacy');
    	var attr = $("#tradesMenu").find(':selected').attr('data-legacy');
    	var isLegacy = false;

    	// For some browsers, `attr` is undefined; for others,
    	// `attr` is false.  Check for both.
    	if (typeof attr !== typeof undefined && attr !== false) {
    		isLegacy = true;
    	}

    	if(isLegacy){
        	var url = '<?php echo $folderLegacy ?>' + 'season' + seasonId + 'trades.html';
    		loadLegacy(url);
    	}else{
    		load(seasonId);
    	}



    });

    function load(seasonId){
      	 $.ajax({
    	    url: './TransactionsTemplate.php',
    	    data: {seasonId: seasonId},
  		    cache: false,
  		    dataType: "html",
  		    success: function(data) {
  		        $("#trades").html(data);
  		        $(".loaderImage").hide();
  		    	$("#trades").show();
  		    },
          	 error: function(XMLHttpRequest, textStatus, errorThrown) {
       	 		$('#trades').html('<p>Error loading data</p>');
       	 		$(".loaderImage").hide();
       	 	}
  			});
    }

    function loadLegacy(url){
   	 $.ajax({
	    url: url,
	    cache: false,
	    dataType: "html",
	    success: function(data) {
	        $("#trades").html(data);
	        $(".loaderImage").hide();
	    	$("#trades").show();
	    },
     	 error: function(XMLHttpRequest, textStatus, errorThrown) {
  	 		$('#trades').html('<p>Error loading data</p>');
  	 		$(".loaderImage").hide();
  	 	}
		});
    }

</script>

<?php include 'footer.php'; ?>