<?php
require_once 'config.php';
include 'lang.php';
include_once 'common.php';

$CurrentPage = 'Schedule3';
$CurrentHTML = 'Schedule3.php';
$CurrentTitle = 'Schedule';
$CurrentPage = 'Schedule3';

include 'head.php';
include_once 'classes/ScheduleHolder.php';
include_once 'classes/ScheduleObj.php';

$baseFolder = '';
$seasonId = '';
if(isset($_GET['seasonId']) || isset($_POST['seasonId'])) {
    $seasonId = ( isset($_GET['seasonId']) ) ? $_GET['seasonId'] : $_POST['seasonId'];
}

if(trim($seasonId) == false){
    $baseFolder = $folder;
}else{
    $baseFolder = str_replace("#",$seasonId,$folderCarrerStats);
}

$Fnm = '';
$linkSchedule = 'Schedule';
$rnd = 0;
$existRnd = 0;
$schedTitlePlayoff = '';
if($currentPLF){
    
    if(isset($_GET['plf']) || isset($_POST['plf']) || $currentPLF) {
        $matches = glob($baseFolder.'*PLF-Round1-Schedule.html');
        $folderLeagueURL2 = '';
        $matchesDate = array_map('filemtime', $matches);
        arsort($matchesDate);
        foreach ($matchesDate as $j => $val) {
            if(substr_count($matches[$j], 'PLF')) {
                $folderLeagueURL2 = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'PLF-Round1-Schedule.html')-strrpos($matches[$j], '/')-1);
                break 1;
            }
        }
        if (file_exists($baseFolder.$folderLeagueURL2.'PLF-Round1-Schedule.html')) {
            $fileName = $baseFolder.$folderLeagueURL2.'PLF-Round1-Schedule.html';
            $linkSchedule = '-Round1-Schedule';
            $rnd = 1;
            $existRnd = 1;
        }
        if (file_exists($baseFolder.$folderLeagueURL2.'PLF-Round2-Schedule.html')) {
            $fileName = $baseFolder.$folderLeagueURL2.'PLF-Round2-Schedule.html';
            $linkSchedule = '-Round2-Schedule';
            $rnd = 2;
            $existRnd = 2;
        }
        if (file_exists($baseFolder.$folderLeagueURL2.'PLF-Round3-Schedule.html')) {
            $fileName = $baseFolder.$folderLeagueURL2.'PLF-Round3-Schedule.html';
            $linkSchedule = '-Round3-Schedule';
            $rnd = 3;
            $existRnd = 3;
        }
        if (file_exists($baseFolder.$folderLeagueURL2.'PLF-Round4-Schedule.html')) {
            $fileName = $baseFolder.$folderLeagueURL2.'PLF-Round4-Schedule.html';
            $linkSchedule = '-Round4-Schedule';
            $rnd = 4;
            $existRnd = 4;
        }
        if(isset($_GET['rnd']) || isset($_POST['rnd'])) {
            $currentRND = ( isset($_GET['rnd']) ) ? $_GET['rnd'] : $_POST['rnd'];
            $fileName = $baseFolder.$folderLeagueURL2.'PLF-Round'.$currentRND.'-Schedule.html';
            $linkSchedule = '-Round'.$currentRND.'-Schedule';
            $rnd = $currentRND;
        }
    }
    
    if($rnd) $schedTitlePlayoff = $scheldRound.' '.$rnd;
}else{
    $fileName = getLeagueFile($baseFolder, $playoff, 'Schedule.html', 'Schedule');
}

$scheduleHolder = new ScheduleHolder($fileName, '');

$CurrentHTML = $linkSchedule;
$CurrentTitle = $schedTitle;

if($currentPLF){
    //$CurrentTitle = 'Playoff '.$CurrentTitle.' '.$schedTitlePlayoff;
    $CurrentTitle = $schedTitlePlayoff;
}

?>

<style>

    .day-header{
        background-color: var(--color-primary-1);
        color: white;
    }
    
</style>

<div class = "container">


	<div class="card">
				
		<?php include 'SectionHeader.php';?>
		<div class="card-body">
			<div class="card">
				<div id="standingsTabs" class="card-header px-2 px-lg-4 pb-1 pt-2">
					<ul class="nav nav-tabs nav-fill">
						<li class="nav-item">
							<a class="nav-link active" href="#remaining" data-toggle="tab">Remaining</a>
						</li>

						<li class="nav-item">
							<a class="nav-link" href="#completed" data-toggle="tab">Completed</a>
						</li>
					</ul>
				</div>
				<div class="card-body">
				
					<div class="tab-content">
    						
    					<div role="tabpanel" class="tab-pane active" id="remaining">
            				<?php
                                $daysPerRow = 3;
                                
                                $rowCount = 0;
                                $lastDay = 0;
                    			$dayCount = 0;
                    			
                    			foreach ($scheduleHolder->getRemainingSchedule() as $schedule) {

                    			    //new day
                    			    if($lastDay != $schedule->getGameDay()){
                    			        
                    			        if($dayCount % $daysPerRow == 0){
                    			            
                    			            if( $dayCount > 0){
                    			                echo '</div>'; //end row
                    			            }
                    			            
                    			            echo '<div class="row ">';
                    			        }

                    			        
                    			        if($dayCount > 0){
                    			            echo '</div>';
                    			            echo '</div>'; //end card
                    			            echo '</div>'; //end col
                    			        }
                    	
                    			        echo '<div class="col-sm-12 col-md-6 col-lg-4 mt-3">';
                    			        echo '<div class="card ">';
                    			        echo '<div class="card-header day-header p-0">
                                            	<h5 class="mb-0"> Day: '.$schedule->getGameDay().($schedule->getGameDay() == $scheduleHolder->getTradeDeadline() ? ' TRADE DEADLINE' : '').'</h5>
                                              </div>';
                    			        echo '<div class="card-body p-1">';
                    			        $lastDay = $schedule->getGameDay();
                    			        $dayCount++;
                    			       // $rowCount = 0; //want to rest count every day.
                    			    }
                    
                        			?>
                    			    
                    			    <div class = "col-sm-12 pb-1 pr-1 pl-1">
                                      	<ul class="list-group">
                                      		<?php if($schedule->getIsPlayed()){
                                      		    $linkRnd = '';
                                      		    if($rnd != 0) {
                                      		        $linkRnd = '&rnd='.$rnd;
                                      		    }
                                      		    ?>
                                      		
                                      		 <li class="list-group-item p-1 border-0">
                                      		 	<a class="lien-noir" style="display:block; width:100%;" href="games.php?num=<?php echo$schedule->getGameNumber().$linkRnd?>">
                                             	<span><strong><?php echo $schedule->getTeam1().' at '.$schedule->getTeam2()?></strong>
                                             	  <?php echo $schedule->getTeam1Score().' - '.$schedule->getTeam2Score().' '.$schedule->getGameTitle()?></span>
                                             	</a>
                                             </li>
                                            <?php }else{?>
                                          	 <li class="list-group-item p-1 border-0 lien-noir"><span><?php echo $schedule->getTeam1().' at '.$schedule->getTeam2() ?></span></li>
                                             <?php 
                        			
                        			         }?>
                                      	</ul>
                                  	</div>
          	    
                    			<?php 
                    			
                    			
                    			//if($rowCount == 9) break;
                    			
                    			$rowCount++;
                    			
                    			}?>
  
                    			<?php if(!empty($scheduleHolder->getRemainingSchedule())){?>
                    			</div><!-- last body -->
                    			</div><!-- last card -->
                    			</div><!-- last col -->
                    			</div><!-- last row -->
                    			<?php }else{?>
                    			    <div>
                    			    	<h5>No Games Remaining</h5>
                    			    </div>
                    		
                    			<?php }?>
            			</div>
            			
            			
						<div role="tabpanel" class="tab-pane" id="completed">

            				<?php
                                $daysPerRow = 3;
                                
                                $rowCount = 0;
                                $lastDay = 0;
                    			$dayCount = 0;

                    			foreach (array_reverse($scheduleHolder->getCompletedSchedule()) as $schedule) {
                    			    //new day
                    			    if($lastDay != $schedule->getGameDay()){
                    			        
                    			        if($dayCount % $daysPerRow == 0){
                    			            
                    			            if( $dayCount > 0){
                    			                echo '</div>'; //end row
                    			            }
                    			            
                    			            echo '<div class="row ">';
                    			        }
                    			        
                    
                    			        
                    			        if($dayCount > 0){
                    			           // echo '</div>'; //end col
                    			            //echo '</div>'; //end row
                    			            echo '</div>';
                    			            echo '</div>'; //end card
                    			            echo '</div>'; //end col
                    			        }
                    	
                    			        echo '<div class="col-sm-12 col-md-6 col-lg-4 mt-3">';
                    			        echo '<div class="card ">';
                    			        echo '<div class="card-header day-header p-0">
                                            	<h5 class="mb-0"> Day: '.$schedule->getGameDay().($schedule->getGameDay() == $scheduleHolder->getTradeDeadline() ? ' TRADE DEADLINE' : '').'</h5>
                                              </div>';
                    			        echo '<div class="card-body p-1">';
                    			        $lastDay = $schedule->getGameDay();
                    			        $dayCount++;
                    			       // $rowCount = 0; //want to rest count every day.
                    			    }
                    
                        			?>
                    			    
                    			    <div class = "col-sm-12 pb-1 pr-1 pl-1">
                                      	<ul class="list-group">
                                      		<?php if($schedule->getIsPlayed()){
                                      		    $linkRnd = '';
                                      		    if($rnd != 0) {
                                      		        $linkRnd = '&rnd='.$rnd;
                                      		    }
                                      		    ?>
                                      		
                                      		 <li class="list-group-item p-1 border-0">
                                      		 	<a class="lien-noir" style="display:block; width:100%;" href="games.php?num=<?php echo$schedule->getGameNumber().$linkRnd?>">
                                             	<span><strong><?php echo $schedule->getTeam1().' at '.$schedule->getTeam2()?></strong>
                                             	  <?php echo $schedule->getTeam1Score().' - '.$schedule->getTeam2Score().' '.$schedule->getGameTitle()?></span>
                                             	</a>
                                             </li>
                                            <?php }else{?>
                                          	 <li class="list-group-item p-1 border-0 lien-noir"><span><?php echo $schedule->getTeam1().' at '.$schedule->getTeam2() ?></span></li>
                                             <?php 
                        			
                        			         }?>
                                      	</ul>
                                  	</div>
          	    
                    			<?php 
                    			
                    			
                    			//if($rowCount == 9) break;
                    			
                    			$rowCount++;
                    			
                    			}?>
                    			
 								<?php if(!empty($scheduleHolder->getCompletedSchedule())){?>
                    			</div><!-- last body -->
                    			</div><!-- last card -->
                    			</div><!-- last col -->
                    			</div><!-- last row -->
                    			<?php }else{?>
                    			    <div>
                    			    	<h5>No Games Completed</h5>
                    			    </div>
                    		
                    			<?php }?>
            			</div>
            			
        			</div>
        			
				</div>
			</div>
			
	
		</div>
	</div>
</div>

<script>

$(document).ready(function() {
//     var url = document.location.toString();
    
//     if (url.match('#')) {
//         $('.nav-tabs a[href=#'+url.split('#')[1]+']').tab('show') ;
//     } 
    var url = document.location.toString();
    if (url.match('#')) {
       $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
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
