<?php
require_once 'config.php';
require_once 'lang.php';
require_once 'common.php';
require_once 'classes/TradeObj.php';

$playoff='';
if(isPlayoffs(TRANSFER_DIR, LEAGUE_MODE)){
    $playoff = 'PLF';
}

include_once 'classes/TeamHolder.php';
$gmFile = getLeagueFile(TRANSFER_DIR, $playoff, 'GMs.html', 'GMs');
$teamHolder = new TeamHolder($gmFile);
$teams = $teamHolder->get_teams();
sort($teams);


if(isset($_GET['seasonId']) || isset($_POST['seasonId'])) {
    $seasonId = ( isset($_GET['seasonId']) ) ? $_GET['seasonId'] : $_POST['seasonId'];
    $seasonId = filter_var($seasonId, FILTER_VALIDATE_INT);
}

if(isset($_GET['team']) || isset($_POST['team'])) {
    $team = ( isset($_GET['team']) ) ? $_GET['team'] : $_POST['team'];
    //$team = filter_var($seasonId, FILTER_SANITIZE_STRING);
}

if(empty($seasonId)){
    http_response_code(400);
    exit();
}

//READ TRADES CSV
$tradesArray = array();
$start_row = 2; //define start row
$i = 1; //define row count flag
$csvLocation = $folderLegacy."s".$seasonId."-trades.csv";

if(!file_exists($csvLocation)) {
    http_response_code(500);
    exit();
}

$file = fopen($csvLocation, "r");

if(empty($team)){
    while (($row = fgetcsv($file)) !== FALSE) {
        if($i >= $start_row) {            
            if($row[0] == "") continue;
            $trade = new TradeObj();
            $trade->setTeam1($row[0]);
            $trade->setTeam1Players($row[1]);
            $trade->setTeam1Prosepcts($row[2]);
            $trade->setTeam1Picks($row[3]);
            $trade->setTeam1Cash($row[4]);
            
            $trade->setTeam2($row[5]);
            $trade->setTeam2Players($row[6]);
            $trade->setTeam2Prosepcts($row[7]);
            $trade->setTeam2Picks($row[8]);
            $trade->setTeam2Cash($row[9]);
            
            $trade->setDate($row[10]);
            
            $tradesArray[$i-1] = $trade;
        }
        $i++;
    }
}else{
    while (($row = fgetcsv($file)) !== FALSE) {
        if($i >= $start_row) {
            if($row[0] == "") continue;
            if(trim($row[0]) == trim($team) || trim($row[5]) == trim($team)){
                $trade = new TradeObj();
                $trade->setTeam1($row[0]);
                $trade->setTeam1Players($row[1]);
                $trade->setTeam1Prosepcts($row[2]);
                $trade->setTeam1Picks($row[3]);
                $trade->setTeam1Cash($row[4]);
                
                $trade->setTeam2($row[5]);
                $trade->setTeam2Players($row[6]);
                $trade->setTeam2Prosepcts($row[7]);
                $trade->setTeam2Picks($row[8]);
                $trade->setTeam2Cash($row[9]);
                
                $trade->setDate($row[10]);
                
                $tradesArray[$i-1] = $trade;
            }
        }
        $i++;
    }
}


usort($tradesArray, function ($c1, $c2)
{
    
    //desc by date
    $returnValue = strtotime($c2->getDate()) - strtotime($c1->getDate());
    
    return $returnValue;
});

?>

<style>

.ul-inner>li:nth-child(odd) { background: var(--color-alternate-1); }
.ul-inner>li:nth-child(even) { background: var(--color-alternate-2); }
.ul-inner{
color:black;
}


</style>

<div id = "trades-inner" class="row no-gutters">
	<div class="col">

		<div class="row">
			<!-- team -->
			<div class="input-group mb-3 col-sm-6">
				<div class="input-group-prepend">
					<label class="input-group-text" for="teamInputField">Team</label>
				</div>
	
				<select class="custom-select" id="teamInputField">
					<option value="">All Teams</option>
      				<?php
      				foreach ($teams as $team) {
                            echo '<option value="' . $team . '">' . $team . '</option>';
                        }
                    ?>

    		   </select>
			</div>
			
			<!-- text search -->
			<div class="input-group mb-3 col-sm-6">
				<div class="input-group-prepend">
					<label class="input-group-text" for="searchField">Search</label>
				</div>
				 <input id = "searchField" type="text" class="form-control" placeholder="" aria-label="Search" aria-describedby="searchField">
			</div>

		</div>
	
<!-- 		<div class="tableau-top">Transactions</div> -->
		<ul class="list-group ul-main">
				
		  <?php foreach($tradesArray as $trade) { ?>
          <li class="list-group-item">
          	
          	<div class="tableau-top text-left pl-3">Date: <?php echo $trade->getDate()?></div>
          	<ul class="list-group ul-inner">

          		 <li class="list-group-item"><span><strong>To <?php echo $trade->getTeam1()?>:</strong></span> <?php echo $trade->concatTrade2()?></li>
          		 <li class="list-group-item"><span><strong>To <?php echo $trade->getTeam2()?>:</strong></span> <?php echo $trade->concatTrade1()?></li>
                           
          	</ul>
		  </li>
          <?php } ?>
        </ul>
	</div>

</div>

<script type="text/javascript">

$('#teamInputField').keyup(function(e){
    if(e.keyCode == 46) {
    	$('#teamInputField option[value=""]').prop('selected', true);

    	var team = $('#teamInputField').val();
    	var searchText = $('#searchField').val();

    	filter(team,searchText);
    }
});

$('#teamInputField').on('change', function() {

	var team = this.value;
	var searchText = $('#searchField').val();

	filter(team,searchText);

});

$(function(){

    $('input[type="text"]').keyup(function(){

        var searchText = $(this).val();
        var team = $('#teamInputField').val();

        filter(team,searchText);

    });

});

function filter(team, searchText){
	$('#trades-inner .list-group-item ul').each(function(){
		var filter = searchFilter(searchText,this);
		filter = filter && teamFilter(team, this);

    	//toggle outer ul
    	$(this).parent().toggle(filter);
	});
}

function searchFilter(searchText, ul){

	if(!searchText) return true;

	var show = false;
	
	$(ul).children('li').each(function(i) { 
        var currentLiText = $(this).text();
        var showCurrentLi = currentLiText.toLowerCase().indexOf(searchText.toLowerCase()) !== -1;

        if(showCurrentLi){
        	show = true;
        	return false;
        }
	});

	return show;
}

function teamFilter(team, ul){

	if(!team) return true;
	
	var show = false;
	
	$(ul).children('li').each(function(i) { 
        var currentLiText = $(this).text();
        var showCurrentLi = currentLiText.toLowerCase().indexOf(team.toLowerCase()) !== -1;

        if(showCurrentLi){
        	show = true;
        	return false;
        }
	});

	return show;
}

</script>


