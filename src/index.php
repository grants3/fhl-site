<?php 
$TABLE_PAGE_LOCATION = '/'; //ex:/TablePage/ 

require_once __DIR__.$TABLE_PAGE_LOCATION.'config.php';
include_once FS_ROOT.'/lang.php';
include_once FS_ROOT.'/common.php';
include_once FS_ROOT.'/fileUtils.php';

$CurrentHTML = 'index.php';
$CurrentTitle = 'Home';
$CurrentPage = 'Home';

$LOAD_SLICK_SCRIPTS=true;

include FS_ROOT.'head.php';

?>

	<div class="">
		<?php include FS_ROOT.'component/TeamBanner.php'; ?>
	</div>
	
	<div class="">
		<?php include FS_ROOT.'component/ScoreCarousel.php'; ?>
	</div>
	

	<div id="main-page-content" class="mx-md-3 mx-lg-10">
		<div class="row no-gutters">
		
		     <!-- fixed left side menu -->
			<div class="col-sm-12 col-md-5 col-lg-4 pr-md-3 pr-lg-4">
    				
    				<div class="card">
    					<div class="card-header p-2">
    						<h4 class="m-0"><?php
    						if (PLAYOFF_MODE) {
    						    echo $StandingsTreeTitle;
                            } else {
                                echo $standingOVTitle;
                            }
                    
                            ?></h4>
               
    					</div>
    					<div class="card-body p-2">
    						<?php
    						if (PLAYOFF_MODE) {
    						    include FS_ROOT.'component/MiniStandingsTree.php';
                            } else {
                                include FS_ROOT.'component/MiniStandings.php';
                            }
                    
                            ?>
    					</div>
    				</div>
    
				    <div class="card mt-3">
    					<div class="card-header p-2">
    						<h4 class="m-0"><?php echo $mainNews;?></h4>
    					</div>
    					<div class="card-body p-2">
    						<?php include FS_ROOT.'component/News.php'; ?>
    					</div>
    				</div>
    				
    				    					        			
    			    <div class="card">
    					<div class="card-header p-2">
    						<h4 class="m-0"><?php echo $waiversTitle;?></h4>
    					</div>
    					<div class="card-body p-2">
    						<?php //include 'MiniWaivers.php'; ?>
    						<?php include FS_ROOT.'component/MiniWaivers.php'; ?>
    						
    					</div>
    				</div>
    				
    				
			</div> <!-- col end -->
		
			<!-- card columns (left side of page, non fixed) -->
			<div class="col-sm-12 col-md-7 col-lg-8">
    			<div class="card-columns">

    	
    
    				<div class="card">
    					<div class="card-header p-2">
    						<h4 class="m-0"><?php echo $todayNextGames;?></h4>
    					</div>
    					<div class="card-body p-2">
    						<?php include FS_ROOT.'component/MiniNextGames.php'; ?>
    					</div>
    				</div>
    
    				<div class="card">
    					<div class="card-header p-2">
    						<h4 class="m-0"><?php echo $leaderTitle;?></h4>
    					</div>
    					<div class="card-body p-2">
    						<?php //include FS_ROOT.'MiniTop5.php'; ?>
    						<?php include FS_ROOT.'component/MiniLeaders.php'; ?>
    					</div>
    				</div>
    				
    
    			</div> <!-- card-columns end -->
			</div> <!-- col end -->
			
			
		</div> <!-- row end -->
	</div> <!-- main content end -->


<?php include FS_ROOT.'footer.php'; ?>