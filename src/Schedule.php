<?php
require_once 'config.php';
include 'lang.php';
include_once 'common.php';

$CurrentPage = 'Schedule';
$CurrentHTML = 'Schedule.php';
$CurrentTitle = 'Schedule';

include 'head.php';
include_once 'classes/ScheduleHolder.php';
include_once 'classes/ScheduleObj.php';

//$baseFolder = '';
$seasonId = '';
$round = 0;
$currentRound = 0;
if(isset($_GET['seasonId']) || isset($_POST['seasonId'])) {
    $seasonId = ( isset($_GET['seasonId']) ) ? $_GET['seasonId'] : $_POST['seasonId'];
}

if(isset($_GET['rnd']) || isset($_POST['rnd'])) {
    $round = ( isset($_GET['rnd']) ) ? $_GET['rnd'] : $_POST['rnd'];
}

$baseFileName = 'Schedule';
$seasonType='';
if($seasonId || $round){
    $seasonTitle = '';
    $roundTitle = '';
    if($seasonId){
        $seasonTitle = ' Season '.$seasonId;
    }
    //assumes playoffs
    if($round){
        $baseFileName = '-Round'.$round.'-Schedule';
        $seasonType = 'PLF';
        $currentRound = getPlayoffRound($seasonId);
        if($round == 4){
            $roundTitle = ' Cup Finals';
        }else{
            $roundTitle = ' Round '.$round;
        }
        
    }
    
    $CurrentTitle = $schedTitle.' - '.$seasonTitle.$roundTitle;
    
    $fileName = _getLeagueFile($baseFileName, $seasonType, $seasonId);
    
}else{
    if(isPlayoffs2()){
        //current playoffs
        $round = getPlayoffRound();
        $baseFileName = '-Round'.$round.'-Schedule';
       // $currentRound = getPlayoffRound();
        $currentRound = $round;
        
        $CurrentTitle = $schedTitle.' - Round '.$round;
    }
    $fileName = getCurrentLeagueFile($baseFileName);
}



$scheduleHolder = new ScheduleHolder($fileName, '');


?>

<style>

    .day-header{
        background-color: var(--color-primary-1);
        color: white;
    }
    
</style>

<div class = "container px-2">


	<div class="card">
				
		<?php include 'SectionHeader.php';?>
		<div class="card-body">
			<div class="card">
			    <?php 
			    if($round) {
            	    echo '<div class = "row">';
            	    echo '<div class = "col">';
            	    
            	    echo '<nav id ="playoff-header-nav" class="nav justify-content-center">';
            	    if($currentRound >= 4)echo'<a class="nav-item nav-link '.(4 == $round ? 'active font-weight-bold' : '').'" href="'.$CurrentPage.'.php?rnd=4">Cup Finals</a>';
            	    if($currentRound >= 3)echo'<a class="nav-item nav-link '.(3 == $round ? 'active font-weight-bold' : '').'" href="'.$CurrentPage.'.php?rnd=3">'.$scheldRound.' 3</a>';
            	    if($currentRound >= 2)echo'<a class="nav-item nav-link '.(2 == $round ? 'active font-weight-bold' : '').'" href="'.$CurrentPage.'.php?rnd=2">'.$scheldRound.' 2</a>';
            	    if($currentRound >= 1)echo'<a class="nav-item nav-link '.(1 == $round ? 'active font-weight-bold' : '').'" href="'.$CurrentPage.'.php?rnd=1">'.$scheldRound.' 1</a>';
            	    echo '</nav>';
            	    
            	    echo '</div>';
            	    echo '</div>';
				}?>
			
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
                                            	<h5 class="mb-0 ml-2"> Day: '.$schedule->getGameDay().($schedule->getGameDay() == $scheduleHolder->getTradeDeadline() ? ' TRADE DEADLINE' : '').'</h5>
                                              </div>';
                    			        echo '<div class="card-body p-1">';
                    			        $lastDay = $schedule->getGameDay();
                    			        $dayCount++;
                    			       // $rowCount = 0; //want to rest count every day.
                    			    }
                    
                        			?>
                    			    
                    			    <div class = "col-sm-12 pb-1 pr-1 pl-1">
                                      	<ul class="list-group">
                                      		<?php 
                                      		$textStyle = '';
                                      		
                                      		if($schedule->getIsPlayed()){
                                      		    $linkRnd = '';
                                      		    $linkSeasonId = '';
                                      		    $textStyle = '';
                                      		    if($round) {
                                      		        $linkRnd = '&rnd='.$round;
                                      		    }
                                      		    if($seasonId) {
                                      		        $linkSeasonId = '&seasonId='.$seasonId;
                                      		    }

                                      		    ?>
                                      		
                                      		 <li class="list-group-item p-1 border-0">
                                      		 	<a class="lien-noir" style="display:block; width:100%;" href="games.php?num=<?php echo$schedule->getGameNumber().$linkSeasonId.$linkRnd?>">
                                             	<span><strong><?php echo $schedule->getTeam1().' at '.$schedule->getTeam2()?></strong>
                                             	  <?php echo $schedule->getTeam1Score().' - '.$schedule->getTeam2Score().' '.$schedule->getGameTitle()?></span>
                                             	</a>
                                             </li>
                                            <?php }else{
                                            
                                                
                                                //skip if not required
                                                if(!$schedule->getIsRequired()){
                                                    $textStyle = 'text-decoration: line-through;';
        
                                                }
                                                
                                                ?>
                                          	 <li class="list-group-item p-1 border-0 lien-noir"><span style="<?php echo $textStyle;?>"><?php echo $schedule->getTeam1().' at '.$schedule->getTeam2() ?></span></li>
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
                                            	<h5 class="mb-0 ml-2"> Day: '.$schedule->getGameDay().($schedule->getGameDay() == $scheduleHolder->getTradeDeadline() ? ' TRADE DEADLINE' : '').'</h5>
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
                                      		    $linkSeasonId = '';
                                      		    if($round) {
                                      		        $linkRnd = '&rnd='.$round;
                                      		    }
                                      		    if($seasonId) {
                                      		        $linkSeasonId = '&seasonId='.$seasonId;
                                      		    }
                                      		    ?>
                                      		
                                      		 <li class="list-group-item p-1 border-0">
                                      		 	<a class="lien-noir" style="display:block; width:100%;" href="games.php?num=<?php echo$schedule->getGameNumber().$linkSeasonId.$linkRnd?>">
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
