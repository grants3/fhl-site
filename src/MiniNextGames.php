<?php
$currentTeam = '';
//session_start();
if(isset($_SESSION["team"])) $currentTeam = $_SESSION["team"];
ob_start();
if(isset($_COOKIE['team'])) $currentTeam = $_COOKIE['team'];
ob_end_flush();

require_once 'config.php';
include_once 'lang.php';
include_once 'common.php';
include_once 'classes/ScheduleHolder.php';
include_once 'classes/ScheduleObj.php';
?>

<style>
/*  .latest-game { border-radius:10px; border-style: solid; margin:5px; padding:5px; font-size: 17px;}   */
.latest-game {
    border-radius:5%; 
    border-style: solid; 
    margin:1%;
   
}
 .latest-image { max-width: 50%; height: auto; }

.latest-score {  
  
     display: flex;
     justify-content: center;  
     align-items: center;
     padding:2px;
 }
 
 .square {
  width: 25%;
  height: 0;
  padding-bottom: 25%; 
  }

.latest-score-text {  
/*     font-size: 150%; */
    font-size:18pt;
/*     padding-left:10%;  */
    margin-left:10%;
    
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
    echo '<h5>Day' . $i . '</h5>';
    echo '</div>';

    echo '<div class = "row">';

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
    
            echo '<div class="col-3 col-md-2 latest-game">';
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


 <?php
// $playoff = isPlayoffs($folder, $playoffMode);
// if($playoff == 1) $playoff = 'PLF';

// $Fnm = getLeagueFile($folder, $playoff, 'TodayGames.html', 'TodayGames');
// $i = 0;
// $j = 0;
// $round = 0;
// $playoffLink = '';
// $stop = 0;


// if(isset($nextGames)) unset($nextGames);
// if (file_exists($Fnm)) {
// 	$tableau = file($Fnm);
// 	while(list($cle,$val) = myEach($tableau)) {
// 		$val = utf8_encode($val);
				
// 		// Next Games
// 		if(substr_count($val, ' at ')) {
// 			$reste = trim(substr($val, 0, strpos($val, '<BR>')));
// 			$nextGames[$j] = substr($reste, 0, strpos($reste, ' '));
// 			$reste = trim(substr($reste, strpos($reste, ' ')));
// 			$nextEquipe1[$j] = trim(substr($reste, 0, strpos($reste, ' at ')));
// 			$reste = trim(substr($reste, strpos($reste, ' at ')+4));
// 			$nextEquipe2[$j] = $reste;
// 			$j++;
// 		}
// 	}
//     $c = 1;
//     echo '<div class="row justify-content-center">';

//     if (! isset($nextGames))
//         echo '<div class="col"><h3>' . $todayNoUpcomingGame . '<h3></div>';
//     else {

//         for ($i = 0; $i < count($nextGames); $i ++) {
//             $matches = glob($folderTeamLogos . strtolower($nextEquipe1[$i]) . '.*');
//             $todayImage1 = '';
//             for ($j = 0; $j < count($matches); $j ++) {
//                 $todayImage1 = $matches[$j];
//                 break 1;
//             }
//             $matches = glob($folderTeamLogos . strtolower($nextEquipe2[$i]) . '.*');
//             $todayImage2 = '';
//             for ($j = 0; $j < count($matches); $j ++) {
//                 $todayImage2 = $matches[$j];
//                 break 1;
//             }

//             echo '<div class="col-3 col-md-2 latest-game">';
//             echo '<div class="row latest-score">';
//             echo '<div class="latest-image"><img src="' . $todayImage1 . '" alt="' . $nextEquipe1[$i] . ' "></div>';
//             echo '</div>';

//             echo '<div class="row latest-score ">';
//             echo '<div class="latest-image"><img src="' . $todayImage2 . '" alt="' . $nextEquipe2[$i] . ' "></div>';
//             echo '</div>';
//             echo '</div>';
//         }
//     }
//     echo '</div>'; 

	
// }
// else {
//     // echo $allFileNotFound.' - '.$Fnm;
//     echo 'No Games Scheduled';
// }
// // echo '</div>';
// ?>
