<?php

require_once 'config.php';
include_once 'lang.php';
include_once 'common.php';
include_once FS_ROOT.'style.php';
include_once 'classes/ScheduleHolder.php';
include_once 'classes/ScheduleObj.php';
?>

<style>

.latest-game {
    border-radius:5%; 
    border-style: solid; 
    margin:2px;
    border-color:var(--color-primary-1);
}
 .latest-image { max-width: 50%; height: auto; }

.latest-score {  
  
     display: flex;
     justify-content: center;  
     align-items: center;
  
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

<div class="container-responsive fhlElement">
<div class="row justify-content-center">
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

    echo '<div>';
    //echo '<h5>Day' . $i . '</h5>';
    echo '<h5 class="tableau-top titre" style = "padding-top:5px; padding-bottom:5px">Day' . $i . '</h5></h5>';
    echo '</div>';

    echo '<div class = "row no-gutters d-flex justify-content-center">';

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
     }
}
?>

</div>
</div>
</div>
