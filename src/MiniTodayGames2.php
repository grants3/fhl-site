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


if(!function_exists('search')) {
    function search($Fnm,$currentTeam) {
        $b = 0;
        $d = 0;
        $tableau = file($Fnm);
        while(list($cle,$val) = myEach($tableau)) {
            $val = utf8_encode($val);
            if(substr_count($val, 'A NAME='.$currentTeam)) {
                $b = 1;
            }
            if($b == 1 && $d == 1) {
                $reste = trim($val);
                $reste = trim(substr($reste, strpos($reste, ' ')));
                $reste = trim(substr($reste, strpos($reste, ' ')));
                if(substr($reste, 0, 1) == '*') {
                    $reste = trim(substr($reste, 1));
                }
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                return $TSabbr = trim(substr($reste, strrpos($reste, ' ')));
            }
            if($b == 1 && substr_count($val, 'PCTG')) {
                $d = 1;
            }
        }
    }
}

?>

<style>


#scores .logo {
    float: left;
    vertical-align: middle;
/*     width: 40px; */
/*     height: 40px; */
    max-width: 45px;
    overflow:hidden;
/*     margin: 0 auto; */
    margin-left:-2px;
    display: block;
}

#scores .table th{
    vertical-align: middle;
    background-color: #dcdee0;
    border: 0;
    height: 10px;
    line-height: 10px;
}

#scores .table td{
   border: 1px solid #dcdee0;
   font-size: 15px;
   font-family: Arial,Helvetica,sans-serif;
   vertical-align: middle;
   
   line-height: 40px;
  
}

.dark-text{
   color: #323232;
}

.team-acronym {
    color: #323232;
    font-size: 15px;
    font-weight: bold;
    padding-left: 40px;
    vertical-align: middle;
}


.box-score{
    background-color: #7a7a7a;
    color: white;
}

  
}

</style>

<!-- <div class = "row"> -->

<?php
//if(!isset($playoff)) $playoff = '';
$playoff = isPlayoffs($folder, $playoffMode);
if($playoff == 1) $playoff = 'PLF';

//$Fnm = getLeagueFile($folder, $playoff, 'TodayGames.html', 'TodayGames');
//$Fnm = $folder.$folderLeagueURL.'TodayGames.html';
$fileName = getLeagueFile($folder, $playoff, 'Schedule.html', 'Schedule');
$scheduleHolder = new ScheduleHolder($fileName, '');

if($scheduleHolder->isSeasonStarted()){
    
    
    echo '<div id = "scores" class="container-fluid">';
    echo '<div class="row align-items-center justify-content-center">'; 

    echo '<div class="col">'; 
    
    echo '<div class="row">';
    $colNum = 0;
    foreach ($scheduleHolder->getLastScheduleDay() as $games) {
        $matches = glob($folderTeamLogos.strtolower($games->team1).'.*');
        $todayImage1 = '';
        for($j=0;$j<count($matches);$j++) {
            $todayImage1 = $matches[$j];
            break 1;
        }
        $matches = glob($folderTeamLogos.strtolower($games->team2).'.*');
        $todayImage2 = '';
        for($j=0;$j<count($matches);$j++) {
            $todayImage2 = $matches[$j];
            break 1;
        }
        
        $FnmAbbr = getLeagueFile($folder, $playoff, 'TeamScoring.html', 'TeamScoring');

        if(file_exists($FnmAbbr)) {
            $team1Abbr = search($FnmAbbr,$games->team1);
            $team2Abbr = search($FnmAbbr,$games->team2);
        }
        else echo $allFileNotFound.' - '.$FnmAbbr;

        if($colNum % 3 == 0){
            echo '<div class="row">';
        }
        
        echo '<div class = "col-sm-12 col-lg-4">';
        
            echo '<table class = "table table-sm table-bordered" >';
                echo '<tbody>';
                    echo '<tr class="d-flex2"  style = "text-transform: uppercase;">'; //header
                    echo '<th class = "col-10"></th>';
                    echo '<th class = "col text-center">Score</th>';
                    echo '</tr>';
                    
                    echo '<tr class="d-flex2">'; //header
                    echo '<td class = "col-10 text-left dark-text">
                                            <div><img class="logo" src="'.$todayImage1.'" alt="'.$games->team1.'"</img></div>
                                            <div class = "team-acronym">'.$team1Abbr.'</div>
                                         </td>';
                    
                    echo '<td class = "col dark-text"><strong>'.$games->team1Score.'</strong></td>';
                    echo '</tr>';
                    
                    echo '<tr class="d-flex2">'; //header
                    echo '<td class = "col-10 text-left dark-text">
                                                <div><img class="logo" src="'.$todayImage2.'" alt="'.$games->team2.'"</img></div>
                				                <div class = "team-acronym">'.$team2Abbr.'</div>
                                             </td>';
                    echo '<td class = "col dark-text"><strong>'.$games->team2Score.'</strong></td>';
                    echo '</tr>';
                
                echo '</tbody>';
            echo '</table>'; //end score-main table
        
        echo '</div>';
        

        
        
        $colNum++;
        
        if($colNum % 3 == 0){
            echo '</div>';
        }
        

    }
    
    if($colNum + 1 % 3 != 0){
        echo '</div>';
    }
 
    echo '</div>';

    echo '</div>'; 
    echo '</div>'; 
    
}else{
    echo '<h3>'.$todayNoSimGame.'</h3>';
}

	

?>

