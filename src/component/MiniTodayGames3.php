<?php

require_once __DIR__.'/../config.php';
include_once FS_ROOT.'lang.php';
include_once FS_ROOT.'common.php';
include_once FS_ROOT.'style.php';
include_once FS_ROOT.'classes/ScheduleHolder.php';
include_once FS_ROOT.'classes/ScheduleObj.php';

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
    echo '<div class="row no-gutters justify-content-center">'; 

    echo '<div class="col">'; 
    
    echo '<div class="row no-gutters">';
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

        echo '<div class = "col-4" >';
        
            echo '<table class = "table table-sm table-bordered" style="width:50px">';
                echo '<tbody>';
                    echo '<tr class="d-flex2"  style = "text-transform: uppercase;">'; //header
                    echo '<th class = "col-10"></th>';
                    echo '<th class = "col-2 text-center">Score</th>';
                    echo '</tr>';
                    
                    echo '<tr class="d-flex2">'; //header
                    echo '<td class = "col-11 text-left dark-text">
                                            <div><img class="logo" src="'.$todayImage1.'" alt="'.$games->team1.'"</img></div>
                                            <div class = "team-acronym">'.$team1Abbr.'</div>
                                         </td>';
                    
                    echo '<td class = "col-1 dark-text text-center"><strong>'.$games->team1Score.'</strong></td>';
                    echo '</tr>';
                    
                    echo '<tr class="d-flex2">'; //header
                    echo '<td class = "col-11 text-left dark-text">
                                                <div><img class="logo" src="'.$todayImage2.'" alt="'.$games->team2.'"</img></div>
                				                <div class = "team-acronym">'.$team2Abbr.'</div>
                                             </td>';
                    echo '<td class = "col-1 dark-text text-center"><strong>'.$games->team2Score.'</strong></td>';
                    echo '</tr>';
                
                echo '</tbody>';
            echo '</table>'; //end score-main table
        
        echo '</div>';
        


    }

    echo '</div>';

    echo '</div>'; 
    echo '</div>'; 
    echo '</div>'; 
    
}else{
    echo '<h3>'.$todayNoSimGame.'</h3>';
}

	

?>

