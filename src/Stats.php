<?php
require_once __DIR__.'/config.php';
include_once FS_ROOT.'lang.php';
include_once FS_ROOT.'common.php';

include_once FS_ROOT.'fileUtils.php';
include_once FS_ROOT.'classes/TeamHolder.php';
include_once FS_ROOT.'classes/ScoringHolder.php';
include_once FS_ROOT.'classes/ScoringPlayerObj.php';
include_once FS_ROOT.'classes/ScoringGoalieObj.php';
include_once FS_ROOT.'classes/ScoringObj.php';
include_once FS_ROOT.'classes/TeamAbbrHolder.php';
include_once FS_ROOT.'classes/ScoringAccumulator.php';

$CurrentHTML = 'Stats.php';
$CurrentTitle = 'Statistics';
$CurrentPage = 'Statistics';

include 'head.php';

//tab activation
$leadersActive = 'active';

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

$rFilter = array(
    "rookieStatus" => "1"
);
$pointsArrayR = $scoringAccumulator->getTopPoints(10,$rFilter);
$goalsArrayR = $scoringAccumulator->getTopGoals(10,$rFilter);
$assistsArrayR = $scoringAccumulator->getTopAssists(10,$rFilter);



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

.leader-container{

/*     border: 1px; */
    border-color:var(--color-primary-1);
    border-style:solid;
    border-width: 1px;
    border-bottom-right-radius:1%; 
    border-bottom-left-radius:1%; 
 }


</style>

<div class="container px-0">

	<div class="card">
		<?php include 'SectionHeader.php';?>
		 <div class="card-header pt-0">
          <?php include 'StatsHeader.php';?>
        </div>
    	<div class="card-body p-2">
			<div class="row no-gutters">
				<div class="col-sm-12 col-md-6 col-lg-6 p-1">
					<h5 class="tableau-top">Skaters</h5>
					<div class="leader-container">
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
                                      array('scoringArray' => $pointsArray, 'attribute' => 'points', 'sort' => 7)); ?>
                                  
                                </div><!-- end points -->
                                 
                                <div class="tab-pane" id="top-scoring-goals" role="tabpanel" aria-labelledby="top-scoring-goals-tab">  
                                	<?php includeWithVariables(FS_ROOT.'component/ScoringLeaderTemplate.php',
                                      array('scoringArray' => $goalsArray, 'attribute' => 'goals', 'sort' => 5)); ?>
                                  
                                </div> <!-- end goals -->
                                 
                                <div class="tab-pane" id="top-scoring-assists" role="tabpanel" aria-labelledby="top-scoring-assists-tab">
                                  <?php includeWithVariables(FS_ROOT.'component/ScoringLeaderTemplate.php',
                                      array('scoringArray' => $assistsArray, 'attribute' => 'assists', 'sort' => 6)); ?>
                                  
                                </div> <!-- end assists -->
                                
                              </div><!-- end tab content -->
                            </div> <!-- end card body -->
                          </div><!-- end skaters card -->
					</div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-6 p-1">
					<h5 class="tableau-top">Defenseman</h5>
					<div class="leader-container">

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
                                          array('scoringArray' => $pointsArrayD, 'attribute' => 'points', 'sort' => 7, 'positionType' => 'D')); ?>
                                      
                                    </div><!-- end points -->
                                     
                                    <div class="tab-pane" id="top-scoring-defense-goals" role="tabpanel" aria-labelledby="top-scoring-defense-goals-tab">  
                                    	<?php includeWithVariables(FS_ROOT.'component/ScoringLeaderTemplate.php',
                                    	    array('scoringArray' => $goalsArrayD, 'attribute' => 'goals', 'sort' => 5, 'positionType' => 'D')); ?>
                                      
                                    </div> <!-- end goals -->
                                     
                                    <div class="tab-pane" id="top-scoring-defense-assists" role="tabpanel" aria-labelledby="top-scoring-defense-assists-tab">
                                      <?php includeWithVariables(FS_ROOT.'component/ScoringLeaderTemplate.php',
                                          array('scoringArray' => $assistsArrayD, 'attribute' => 'assists', 'sort' => 6, 'positionType' => 'D')); ?>
                                      
                                    </div> <!-- end assists -->
                                    
                                  </div><!-- end tab content -->
                                </div> <!-- end card body -->
                              </div><!-- end defense card -->

					</div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-6 p-1">
					<h5 class="tableau-top">Goalies</h5>
					<div class="leader-container">

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
                                  <a class="nav-link" href="#top-scoring-goalies-assists" role="tab" aria-controls="top-scoring-goalies-assists" aria-selected="false">Shutouts</a>
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

					</div>
				</div><!-- end goalies col -->
				
				<div class="col-sm-12 col-md-6 col-lg-6 p-1">
					<h5 class="tableau-top">Rookies</h5>
					<div class="leader-container">

                    	<div class="card">
                            <div class="card-header pt-0">
                             
                              <ul class="nav nav-tabs card-header-tabs" id="top-rookies-list" role="tablist">
                                <li class="nav-item">
                                  <a class="nav-link active" href="#top-scoring-rookies-points" role="tab" aria-controls="top-scoring-rookies-points" aria-selected="true">Points</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link"  href="#top-scoring-rookies-goals" role="tab" aria-controls="top-scoring-rookies-goals" aria-selected="false">Goals</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" href="#top-scoring-rookies-assists" role="tab" aria-controls="top-scoring-rookies-assists" aria-selected="false">Assists</a>
                                </li>
                              </ul>
                            </div>
                            <div class="card-body p-0">
                    		  
                               <div class="tab-content mt-1">
                                <div class="tab-pane active" id="top-scoring-rookies-points" role="tabpanel">
                                    <?php includeWithVariables(FS_ROOT.'component/ScoringLeaderTemplate.php',
                                        array('scoringArray' => $pointsArrayR, 'attribute' => 'points', 'sort' => 7, 'rookie' => '1', 'sortOrder' => 'asc', 'positionType' => 'R')); ?>
                                  
                                </div><!-- end points -->
                                 
                                <div class="tab-pane" id="top-scoring-rookies-goals" role="tabpanel" aria-labelledby="top-scoring-rookies-goals-tab">  
                                	<?php includeWithVariables(FS_ROOT.'component/ScoringLeaderTemplate.php',
                                	    array('scoringArray' => $goalsArrayR, 'attribute' => 'goals', 'sort' => 5, 'rookie' => '1', 'positionType' => 'R')); ?>
                                  
                                </div> <!-- end goals -->
                                 
                                <div class="tab-pane" id="top-scoring-rookies-assists" role="tabpanel" aria-labelledby="top-scoring-rookies-assists-tab">
                                  <?php includeWithVariables(FS_ROOT.'component/ScoringLeaderTemplate.php',
                                      array('scoringArray' => $assistsArrayR, 'attribute' => 'assists', 'sort' => 6, 'rookie' => '1', 'positionType' => 'R')); ?>
                                  
                                </div> <!-- end assists -->
                                
                              </div><!-- end tab content -->
                            </div> <!-- end card body -->
                          </div><!-- end goalies card -->

					</div>
				</div><!-- end goalies col -->
			</div>

			<div>
				
			</div><!--row-->
			
		</div><!--card-body-->
	</div><!--card-->
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

$('#top-rookies-list a').on('click', function (e) {
  e.preventDefault()
  $(this).tab('show')
})


</script>


<?php include 'footer.php'; ?>
