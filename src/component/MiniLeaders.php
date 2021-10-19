<?php require_once __DIR__.'/../config.php';
include_once FS_ROOT.'fileUtils.php';
include_once FS_ROOT.'classes/TeamHolder.php';
include_once FS_ROOT.'classes/ScoringHolder.php';
include_once FS_ROOT.'classes/ScoringPlayerObj.php';
include_once FS_ROOT.'classes/ScoringGoalieObj.php';
include_once FS_ROOT.'classes/ScoringObj.php';
include_once FS_ROOT.'classes/TeamAbbrHolder.php';
include_once FS_ROOT.'classes/ScoringAccumulator.php';

if(!isset($playoff)){
    include_once FS_ROOT.'common.php';
    
    $playoff = '';
    
    if(isPlayoffs(TRANSFER_DIR, LEAGUE_MODE)){
        $playoff = 'PLF';
    }
}


$scoringFile = getLeagueFile($folder, $playoff, 'TeamScoring.html', 'TeamScoring');
$scoringHolder = new ScoringHolder($scoringFile);
$scoringAccumulator = new ScoringAccumulator($scoringHolder);

$pointsArray = $scoringAccumulator->getTopPoints(10);
$goalsArray = $scoringAccumulator->getTopGoals(10);
$assistsArray = $scoringAccumulator->getTopAssists(10);

$dFilter = array(
    "position" => "D"
);
$pointsArrayD = $scoringAccumulator->getTopPoints(10,$dFilter);
$goalsArrayD = $scoringAccumulator->getTopGoals(10,$dFilter);
$assistsArrayD = $scoringAccumulator->getTopAssists(10,$dFilter);

$goaliesGaaArray = $scoringAccumulator->getTopGoalies('gaa',10, 'ASC');
$goaliesSvPctArray = $scoringAccumulator->getTopGoalies('savePct',10,'DESC');
$goaliesShutoutArray = $scoringAccumulator->getTopGoalies('shutouts',10,'DESC');

?>

<style>

/*  main */

.top-player-details {
	display: flex;
	flex-direction: column;
	-webkit-box-align: center;
	align-items: center;
	padding-top: 10px;
}

/* image */
.playerImageLogo {
	border-radius: 50%;
	width: 8rem;
	height: 8rem;
	object-fit: cover;
	
	border-color:var(--color-primary-1);
    border-style:solid;
    border-width: 2px;
}

/ /* player details */
.bvjVjv {
	display: flex;
	-webkit-box-align: center;
	align-items: center;
	flex-direction: column;
}

.hHORBn {
	display: inline-block;
	vertical-align: top;
	padding-right: 5px;
	line-height: 30px;
	font-size: 20px;
}

.jPZtbn {
	border-left: 1px solid rgb(102, 102, 102);
	display: inline-block;
	font-size: 16px;
	line-height: 16px;
	padding-left: 5px;
	text-align: left;
}

.cWNqKo {
	display: block;
	font-size: 12px;
	line-height: 22px;
}

/* /*amount details*/
* /
.glDXkE {
	display: flex;
	flex-direction: column;
	font-weight: bold;
	margin-top: 15px;
	text-align: center;
}

.ANxrZ {
	list-style: none;
	margin: 0px;
	padding: 10px 5px 0px;
	width: 100%;
}

/*All leaders*/
.top-leader-list ul {
	display: block;
	list-style-type: disc;
	margin-block-start: 0.51em;
	margin-block-end: 1em;
	margin-inline-start: 0px;
	margin-inline-end: 0px;
	padding-inline-start: 10px;
}

.eTUABY {
	display: flex;
	-webkit-box-pack: justify;
	justify-content: space-between;
	margin-bottom: 10px;
	font-size: 12px;
}

.top-leader-list {
	text-align: right;
}

.card-header:first-child {
	
}
</style>

<div class="container-fluid" id="mini-scoring-container">
  <div class="row">
    <div class="col-12 px-0">
 <!--      <div class= "section-header logo-gradient" style="border-bottom-left-radius:0px;border-bottom-right-radius:0px;">
         <div class="header-container"> -->
    
<!--     		<div class="gloss"></div> -->
<!--     		<span class="header">Skaters</span> -->
    
<!--     	</div> -->
<!--       </div>	 -->
	  <h5 class="tableau-top">Skaters</h5>
      <div class="card">
        <div class="card-header pt-0">
      
         <div class="card-heading"></div>
          <ul class="nav nav-tabs card-header-tabs" id="top-scorers-list" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" href="#top-scoring-points" role="tab" aria-controls="top-scoring-points" aria-selected="true">Points</a>
            </li>
            <li class="nav-item">
              <a class="nav-link"  href="#top-scoring-goals" role="tab" aria-controls="top-scoring-goals" aria-selected="false">Goals</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#top-scoring-assists" role="tab" aria-controls="top-scoring-assists" aria-selected="false">Assists</a>
            </li>
          </ul>
        </div>
        <div class="card-body p-0">
		  
           <div class="tab-content mt-1">
            <div class="tab-pane active" id="top-scoring-points" role="tabpanel">
                <?php includeWithVariables(FS_ROOT.'component/ScoringLeaderTemplate.php',
                  array('scoringArray' => $pointsArray, 'attribute' => 'points', 'sort' => 6)); ?>
              
            </div><!-- end points -->
             
            <div class="tab-pane" id="top-scoring-goals" role="tabpanel" aria-labelledby="top-scoring-goals-tab">  
            	<?php includeWithVariables(FS_ROOT.'component/ScoringLeaderTemplate.php',
                  array('scoringArray' => $goalsArray, 'attribute' => 'goals', 'sort' => 4)); ?>
              
            </div> <!-- end goals -->
             
            <div class="tab-pane" id="top-scoring-assists" role="tabpanel" aria-labelledby="top-scoring-assists-tab">
              <?php includeWithVariables(FS_ROOT.'component/ScoringLeaderTemplate.php',
                  array('scoringArray' => $assistsArray, 'attribute' => 'assists', 'sort' => 5)); ?>
              
            </div> <!-- end assists -->
            
          </div><!-- end tab content -->
        </div> <!-- end card body -->
      </div><!-- end skaters card -->
    </div><!-- end skaters col -->
    

    <div class="col-12 px-0">
<!--      <div class= "section-header logo-gradient" style="border-bottom-left-radius:0px;border-bottom-right-radius:0px;">
          <div class="header-container"> -->
    
<!--     		<div class="gloss"></div> -->
<!--     		<span class="header">Defenseman</span> -->
    
<!--     	</div> -->
<!--       </div> -->
	  <h5 class="tableau-top">Defenseman</h5>
      <div class="card">
        <div class="card-header pt-0">
         <div class="card-heading"></div>
          <ul class="nav nav-tabs card-header-tabs" id="top-scorers-defense-list" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" href="#top-scoring-defense-points" role="tab" aria-controls="top-scoring-defense-points" aria-selected="true">Points</a>
            </li>
            <li class="nav-item">
              <a class="nav-link"  href="#top-scoring-defense-goals" role="tab" aria-controls="top-scoring-defense-goals" aria-selected="false">Goals</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#top-scoring-defense-assists" role="tab" aria-controls="top-scoring-defense-assists" aria-selected="false">Assists</a>
            </li>
          </ul>
        </div>
        <div class="card-body p-0">
		  
           <div class="tab-content mt-1">
            <div class="tab-pane active" id="top-scoring-defense-points" role="tabpanel">
                <?php includeWithVariables(FS_ROOT.'component/ScoringLeaderTemplate.php',
                  array('scoringArray' => $pointsArrayD, 'attribute' => 'points', 'sort' => 6, 'positionType' => 'D')); ?>
              
            </div><!-- end points -->
             
            <div class="tab-pane" id="top-scoring-defense-goals" role="tabpanel" aria-labelledby="top-scoring-defense-goals-tab">  
            	<?php includeWithVariables(FS_ROOT.'component/ScoringLeaderTemplate.php',
            	    array('scoringArray' => $goalsArrayD, 'attribute' => 'goals', 'sort' => 4, 'positionType' => 'D')); ?>
              
            </div> <!-- end goals -->
             
            <div class="tab-pane" id="top-scoring-defense-assists" role="tabpanel" aria-labelledby="top-scoring-defense-assists-tab">
              <?php includeWithVariables(FS_ROOT.'component/ScoringLeaderTemplate.php',
                  array('scoringArray' => $assistsArrayD, 'attribute' => 'assists', 'sort' => 5, 'positionType' => 'D')); ?>
              
            </div> <!-- end assists -->
            
          </div><!-- end tab content -->
        </div> <!-- end card body -->
      </div><!-- end defense card -->
    </div><!-- end defense col -->
    

    <div class="col-12 px-0">
 <!--     <div class= "section-header logo-gradient" style="border-bottom-left-radius:0px;border-bottom-right-radius:0px;">
          <div class="header-container"> -->
    
<!--     		<div class="gloss"></div> -->
<!--     		<span class="header">Goalies</span> -->
    
<!--     	</div> -->
<!--    	  </div> -->
   	  <h5 class="tableau-top">Goalies</h5>
      <div class="card">
        <div class="card-header pt-0">
         
          <ul class="nav nav-tabs card-header-tabs" id="top-goalies-list" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" href="#top-scoring-goalies-points" role="tab" aria-controls="top-scoring-goalies-points" aria-selected="true">GAA</a>
            </li>
            <li class="nav-item">
              <a class="nav-link"  href="#top-scoring-goalies-goals" role="tab" aria-controls="top-scoring-goalies-goals" aria-selected="false">SV%</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#top-scoring-goalies-assists" role="tab" aria-controls="top-scoring-goalies-assists" aria-selected="false">SHUTOUTS</a>
            </li>
          </ul>
        </div>
        <div class="card-body p-0">
		  
           <div class="tab-content mt-1">
            <div class="tab-pane active" id="top-scoring-goalies-points" role="tabpanel">
                <?php includeWithVariables(FS_ROOT.'component/ScoringLeaderTemplate.php',
                    array('scoringArray' => $goaliesGaaArray, 'attribute' => 'gaa', 'sort' => 5, 'positionType' => 'G', 'sortOrder' => 'asc')); ?>
              
            </div><!-- end points -->
             
            <div class="tab-pane" id="top-scoring-goalies-goals" role="tabpanel" aria-labelledby="top-scoring-goalies-goals-tab">  
            	<?php includeWithVariables(FS_ROOT.'component/ScoringLeaderTemplate.php',
            	    array('scoringArray' => $goaliesSvPctArray, 'attribute' => 'savePct', 'sort' => 12, 'positionType' => 'G')); ?>
              
            </div> <!-- end goals -->
             
            <div class="tab-pane" id="top-scoring-goalies-assists" role="tabpanel" aria-labelledby="top-scoring-goalies-assists-tab">
              <?php includeWithVariables(FS_ROOT.'component/ScoringLeaderTemplate.php',
                  array('scoringArray' => $goaliesShutoutArray, 'attribute' => 'shutouts', 'sort' => 9, 'positionType' => 'G')); ?>
              
            </div> <!-- end assists -->
            
          </div><!-- end tab content -->
        </div> <!-- end card body -->
      </div><!-- end goalies card -->
    </div><!-- end goalies col -->
    
    
  </div>
</div>

<script>

$('#top-scorers-list a').on('click', function (e) {
  e.preventDefault()
  $(this).tab('show')
})

$('#top-scorers-defense-list a').on('click', function (e) {
  e.preventDefault()
  $(this).tab('show')
})

$('#top-goalies-list a').on('click', function (e) {
  e.preventDefault()
  $(this).tab('show')
})

</script>

	