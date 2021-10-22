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
 
  <?php if(IS_IE){?>
    .latest-score {  
     margin-left:2em;
     margin-right:0px;
     }
 <?php }?>
 
 .latest-score-day{

/*     border: 1px; */
    border-color:var(--color-primary-1);
    border-style:solid;
    border-width: 1px;
/*     border-bottom-right-radius:3%; */
/*     border-bottom-left-radius:3%; */
    border-bottom-right-radius:2%; 
    border-bottom-left-radius:2%; 
    
    padding:5px;
 }

</style>
<?php
//if(isPlayoffs($folder, $playoffMode)){
if(isPlayoffs2()){
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
    
    $fileName = getLeagueFileOld($folder, 'PLF', '-Round'.$round.'-Schedule.html', '-Round'.$round.'-Schedule');
    $playoffLink = '&rnd='.$round;
    
}else{
   // $fileName = getLeagueFile($folder, $playoff, 'Schedule.html', 'Schedule');
    $fileName = getLeagueFile('Schedule');
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
//$miniNextToProcess = !isPlayoffs($folder, $playoffMode) ? $miniNextGame + 1 : $miniNextGame;
$miniNextToProcess = !isPlayoffs2() ? $miniNextGame + 1 : $miniNextGame;

for ($i = $miniNextGame; $i <= $miniNextToProcess; $i ++) {

     $miniGames = $scheduleHolder->getScheduleByDay($i);

     if(!empty($miniGames)){

    $miniNexyAddMargin = ($i % 2 == 0) ? 'mb-2' : '';
    echo '<div class="'.$miniNexyAddMargin.'">';
    //echo '<h5>Day' . $i . '</h5>';

    echo '<h5 class="tableau-top m-0">Day ' . $i . '</h5>';
    //echo '</div>';

    echo '<div class = "row no-gutters d-flex justify-content-center latest-score-day">';
    foreach ($miniGames as $games) {

        if (! $games->getIsRequired()) {
            continue;
        }

        $todayImage1 = getTeamLogoUrl($games->team1);
        $todayImage2 = getTeamLogoUrl($games->team2);

        echo '<div class="col-2 latest-game ">';
        echo '<div class="row latest-score">';
        echo '<div class="latest-image"><img src="' . $todayImage1 . '" alt="' . $games->team1 . ' "></div>';
        echo '</div>';

        echo '<div class="row latest-score ">';
        echo '<div class="latest-image"><img src="' . $todayImage2 . '" alt="' . $games->team2 . ' "></div>';
        echo '</div>';
        echo '</div>';
    }


    echo '</div>';
    echo '</div>';
     }
}
?>

</div>
</div>
</div>
