<?php

require_once __DIR__.'/../config.php';
include_once FS_ROOT.'lang.php';
include_once FS_ROOT.'common.php';
include_once FS_ROOT.'style.php';
include_once FS_ROOT.'classes/ScheduleHolder.php';
include_once FS_ROOT.'classes/ScheduleObj.php';
?>

<style>

.latest-game {
    border-radius:5%; 
    border-style: solid; 
/*     margin:2px; */
    border-width: 1px;
    margin:5px;
    border-color:var(--color-primary-2);
}
 .latest-image { max-width: 50%; height: auto; }

.latest-score {  
  
     display: flex;
     justify-content: center;  
     align-items: center;
  
 }
 
 .latest-score-day{

/*     border: 1px; */
    border-color:var(--color-primary-1);
    border-style:solid;
    border-width: 3px;
/*     border-bottom-right-radius:3%; */
/*     border-bottom-left-radius:3%; */
 }

</style>
<?php
if(isPlayoffs($folder, $playoffMode)){
    $round = 0;
    if(file_exists($folder.'cehlPLF-Round4-Schedule.html')) {
        //$fileName = $folder.'cehlPLF-Round4-Schedule.html';
        $round = 4;
    }else if(file_exists($folder.'cehlPLF-Round3-Schedule.html')) {
        //$fileName = $folder.'cehlPLF-Round3-Schedule.html';
        $round = 3;
    }else if(file_exists($folder.'cehlPLF-Round2-Schedule.html')) {
        //$fileName = $folder.'cehlPLF-Round2-Schedule.html';
        $round = 2;
    }else if(file_exists($folder.'cehlPLF-Round1-Schedule.html')) {
        //$fileName = $folder.'cehlPLF-Round1-Schedule.html';
        $round = 1;
    }
    
    $fileName = getLeagueFile($folder, 'PLF', '-Round'.$round.'-Schedule.html', '-Round'.$round.'-Schedule');
    $playoffLink = '&rnd='.$round;
    
}else{
    $fileName = getLeagueFile($folder, $playoff, 'Schedule.html', 'Schedule');
}



$scheduleHolder = new ScheduleHolder($fileName, '');

?>

<div class="fhlElement container-fluid px-0">
<div class="row justify-content-center no-gutters">
<div class="col">

<?php

if($scheduleHolder->isScheduleComplete()){
    echo '<h5>No Games Scheduled</h5>';
}


//only display one day for playoffs, 2 for reg season
$miniNextGame = $scheduleHolder->getLastDayPlayed() + 1;
$miniNextToProcess = !isPlayoffs($folder, $playoffMode) ? $miniNextGame + 1 : $miniNextGame;

for ($i = $miniNextGame; $i <= $miniNextToProcess; $i ++) {

     $miniGames = $scheduleHolder->getScheduleByDay($i);

     if(!empty($miniGames)){

    echo '<div class="mb-1">';
    //echo '<h5>Day' . $i . '</h5>';
    echo '<h5 class="tableau-top m-0">Day' . $i . '</h5>';
    //echo '</div>';

    echo '<div class = "row no-gutters d-flex justify-content-center latest-score-day">';

    foreach ($miniGames as $games) {
        
        if(!$games->getIsRequired()){
            continue;
        }
        
            $matches = glob($folderTeamLogos . strtolower($games->team1) . '.*');
            $todayImage1 = '';
            for ($j = 0; $j < count($matches); $j ++) {
                $todayImage1 = $matches[$j];
                break 1;
            }
            $matches = glob($folderTeamLogos . strtolower($games->team2) . '.*');
            $todayImage2 = '';
            for ($j = 0; $j < count($matches); $j ++) {
                $todayImage2 = $matches[$j];
                break 1;
            }
    
            // echo '<div class="next-game">';
            // echo '<div class="next-image"><img src="'.$todayImage1.'" alt="'.$nextEquipe1[$i].'"></div>';
            // echo '<div class="next-image"><img src="'.$todayImage2.'" alt="'.$nextEquipe2[$i].'"></div>';
            // echo '</div>';
    
            echo '<div class="col-2 latest-game ">';
            echo '<div class="row latest-score">';
            echo '<div class="latest-image"><img src="' . $todayImage1 . '" alt="' . $games->team1 . ' "></div>';
            echo '</div>';
    
            echo '<div class="row latest-score ">';
            echo '<div class="latest-image"><img src="' . $todayImage2 . '" alt="' . $games->team2 . ' "></div>';
            echo '</div>';
            echo '</div>';
        }
    // }

    echo '</div>';
    echo '</div>';
     }
}
?>

</div>
</div>
</div>
