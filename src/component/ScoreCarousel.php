<?php

require_once __DIR__.'/../config.php';
include_once FS_ROOT.'common.php';
include_once FS_ROOT.'fileUtils.php';
include_once FS_ROOT.'lang.php';
include_once FS_ROOT.'classes/ScheduleHolder.php';
include_once FS_ROOT.'classes/ScheduleObj.php';
include_once FS_ROOT.'classes/TeamAbbrHolder.php';
//load slick css/js assets
$LOAD_BASE_SCRIPTS=true;
$LOAD_SLICK_SCRIPTS=true;

include FS_ROOT.'assets.php';

?>

<style>

#scoringBanner{
display: none;
/* background:#444;  */
background:var(--color-primary-2);
padding-left:30px; 
padding-right:30px;
}

#scoringBanner .logo {
	float: left;
	vertical-align: middle;
	/*     width: 40px; */
	/*     height: 40px; */
	max-width: 25px;
	height:25px;
	width: 25px;
	overflow: hidden;
	/*     margin: 0 auto; */
	margin-left: -2px;
	display: block;
}

#scoringBanner .table {
	height: 92px;
}

#scoringBanner .table th {
	vertical-align: middle;
/* 	background-color: #dcdee0; */
/* 	border: 0; */
    background-color: var(--color-primary-1);
    color:white;
	height: 20px;
	line-height: 10px;
}

#scoringBanner .table td {
/* 	border: 1px solid #dcdee0; */
	vertical-align: middle;
	background-color: #fff; 
	/*    line-height: 45px; */
}

#scoringBanner .dark-text {
	color: #323232;
}

#scoringBanner .team-acronym {
	color: #323232;
	font-size: 15px;
/* 	font-weight: bold; */
    padding-top:.25rem;  
 	padding-left: 3px; 
	vertical-align: middle;
	float:left; 

}

#scoringBanner .team-score{
	color: #323232;
 font-size: 15px;
  padding-top:.5rem;  
}

#scoringBanner .dayPlayed {
	height: 92px;
	/*      line-height: 90px;  */
	width: 50px;
	color: black;
	background-color: #dcdee0;
	margin-right: 2px;
    margin-left:2px;
    margin-top:10px;
}

#scoringBanner .dayPlayed span { 
 	display: inline-flex; 
    align-items: center; 
    min-height: 92px; 
 } 

#scoringBanner .banner-game{
    width:95px;  
    height:92px;  
    margin-left:2px;
    margin-right:2px;
    margin-bottom:10px;
    margin-top:10px;
}

/* .slick-dots li.slick-active button:before {  */
/*     opacity: .75;  */
/*      color: var(--color-alternate-1);  */
/*  }  */

/*  .slick-dots li button:before {  */
/*      opacity: .25;  */
/*      color: var(--color-alternate-2);  */

/*  }  */
 
/*  .slick-dots { */
/*     bottom: -20px; */

/* } */

/* #scoringBanner { */
/*  padding-bottom:1px; */
    
/* } */

</style>

<div id="scoringBanner" class="container-fluid fhlElement">
	<div class="button-container"></div>
	<div class="score-scroll">
    

<?php

if (PLAYOFF_MODE) {
    $round = getPlayoffRound();

    $fileName = getCurrentPlayoffLeagueFile('-Round' . $round . '-Schedule');
    $playoffLink = '&rnd=' . $round;

    $scheduleHolder = new ScheduleHolder($fileName, '');

    $playedGamesRound = $round;
    $nextGamesRound = $round;

    if ($scheduleHolder->isScheduleComplete() && $round > 1 && $round < 4) {
        $nextGameScheduleHolder = $scheduleHolder;
        $nextRound = $round + 1;

        $fileName = getCurrentPlayoffLeagueFile('-Round' . $nextRound . '-Schedule.html', '-Round' . $nextRound . '-Schedule');
        
        $nextGamesRound = $nextRound;
    } else if (! $scheduleHolder->isSeasonStarted() && $round > 1) {
        $nextGameScheduleHolder = $scheduleHolder;
        $previousRound = $round - 1;

        $fileName = getCurrentPlayoffLeagueFile('-Round' . $previousRound . '-Schedule.html', '-Round' . $previousRound . '-Schedule');
        $scheduleHolder = new ScheduleHolder($fileName, '');

        $playedGamesRound = $previousRound;
        $playoffLink = '&rnd=' . $previousRound;
    } else {
        $nextGameScheduleHolder = $scheduleHolder;
    }

} else {
    $fileName = getCurrentLeagueFile('Schedule');
    $scheduleHolder = new ScheduleHolder($fileName, '');
    $nextGameScheduleHolder = $scheduleHolder;
    $playoffLink = '';
}

$teamScoringFile = getCurrentLeagueFile('TeamScoring');

if(!file_exists($teamScoringFile)) {
    echo '<h5>'.$allFileNotFound.' - TeamScoring</h5>';
    exit;
}

$teamAbbrHolder = new TeamAbbrHolder($teamScoringFile);


// last games played scores
if ($scheduleHolder->isSeasonStarted()) {
    
    if (!PLAYOFF_MODE) {
        if ($scheduleHolder->getLastDayPlayed() > 1) {
            $startDay = $scheduleHolder->getLastDayPlayed() - 1;
        } else {
            $startDay = $scheduleHolder->getLastDayPlayed();
        }
        
        $endGame = $scheduleHolder->getLastDayPlayed();
    } else {
        // only display one game for playoffs
        $startDay = $scheduleHolder->getLastDayPlayed();
        $endGame = $scheduleHolder->getLastDayPlayed();
    }
    
    for ($x = $startDay; $x <= $endGame; $x ++) {
        echo '<div class="dayPlayed text-center">';
        //echo '<div style ="padding-top:50%">';
        if (!PLAYOFF_MODE) {
            echo '<span><strong>'.$schedDay.' ' . ($x) . '</strong></span>';
        } else {
            echo '<span><strong>'.$scheldRoundS.' ' . ($playedGamesRound) . '</strong></span>';
            echo '<span><strong>'.$schedDay.' ' . ($x) . '</strong></span>';
        }
        
        // echo '</div>';
        echo '</div>';
        
        foreach ($scheduleHolder->getScheduleByDay($x) as $games) {
            
            // series over playoffs
            if (! $games->getIsRequired()) {
                continue;
            }
            
            $todayImage1 = getTeamLogoUrl($games->team1);
            $todayImage2 = getTeamLogoUrl($games->team2);
            
            $team1Abbr = $teamAbbrHolder->getAbbr($games->team1);
            $team2Abbr = $teamAbbrHolder->getAbbr($games->team2);
            
            $gameInfo = $games->getGameTitle();

            if($games->getIsOt()){
                if(substr_count($gameInfo, '(SO)')){
                    $gameInfo = str_lreplace('(SO)',$gameInfo,'('.$schedSO.')');
                }else if(substr_count($games->getGameTitle(), '(OT)')){
                    $gameInfo = str_lreplace('(OT)',$gameInfo,'('.$schedOT.')');
                } 
            }
            
            echo '<div class="banner-game">';
            echo '<a href="'.BASE_URL.'games.php?num=' . $games->getGameNumber() . $playoffLink . '">';
            echo '<table class = "table table-sm table-striped mb-0"  >';
            //echo '<tbody>';
            echo '<col><col>'; //define two columns so we can still colspan the header.
            echo '<tr style = "text-transform: uppercase;">'; // header
            echo '<th colspan="2">Final'. $gameInfo.'</th>';
            echo '</tr>';
            
            echo '<tr class="d-flex">'; // score 1
            echo '<td class="col-9 ">
                <div><img class="logo" src="'. $todayImage1 . '" alt="' . $games->team1 . '"</img></div>
                <div class = "team-acronym">' . $team1Abbr . '</div>
             </td>';
            
            echo '<td class = "team-score col-3 text-center"><strong>' . $games->team1Score . '</strong></td>';
            echo '</tr>';
            
            echo '<tr class="d-flex">'; // score 2
            echo '<td class="col-9">
                <div><img class="logo" src="' . $todayImage2 . '" alt="' . $games->team2 . '"</img></div>
                <div class = "team-acronym">' . $team2Abbr . '</div>
             </td>';
            echo '<td class = "team-score col-3 dark-text text-center"><strong>' . $games->team2Score . '</strong></td>';
            echo '</tr>';
            
           // echo '</tbody>';
            echo '</table>'; // end score-main table
            echo '</a>';
            echo '</div>';
        }
    }
}

// next games
$nextGame = $nextGameScheduleHolder->getLastDayPlayed() + 1;
$nextGamesToProcess = !PLAYOFF_MODE ? $nextGame + 1 : $nextGame;

// only display one day for playoffs
for ($x = $nextGame; $x <= $nextGamesToProcess; $x ++) {

    if (empty($nextGameScheduleHolder->getScheduleByDay($x)))
        continue;

    // check to make sure at least one required gamed exists
    $requiredGameExists = false;
    foreach ($nextGameScheduleHolder->getScheduleByDay($x) as $games) {
        if ($games->getIsRequired()) {
            $requiredGameExists = true;
            break;
        }
    }

    // stop if no required game exists (i.e for playoffs)
    if (! $requiredGameExists)
        continue;

    echo '<div class="dayPlayed text-center">';
    if (!PLAYOFF_MODE) {
        echo '<span><strong>'.$schedDay.' ' . ($x) . '</strong></span>';
    } else {
        echo '<span><strong>'.$scheldRoundS.' ' . ($nextGamesRound) . '</strong></span>';
        echo '<span><strong>'.$schedDay.' ' . ($x) . '</strong></span>';
    }

    echo '</div>';

    foreach ($nextGameScheduleHolder->getScheduleByDay($x) as $games) {

        if (! $games->getIsRequired())
            continue;

            $matches = glob(LOGO_DIR . strtolower($games->team1) . '.*');
        $todayImage1 = '';
        for ($j = 0; $j < count($matches); $j ++) {
            $todayImage1 = $matches[$j];
            break 1;
        }
        $matches = glob(LOGO_DIR . strtolower($games->team2) . '.*');
        $todayImage2 = '';
        for ($j = 0; $j < count($matches); $j ++) {
            $todayImage2 = $matches[$j];
            break 1;
        }

        $team1Abbr = $teamAbbrHolder->getAbbr($games->team1);
        $team2Abbr = $teamAbbrHolder->getAbbr($games->team2);

        echo '<div class="banner-game">';

        echo '<table class = "table table-sm ">';
        //echo '<tbody>';
        echo '<col><col>'; //define two columns so we can still colspan the header.
        echo '<tr style = "text-transform: uppercase;">'; // header
        echo '<th colspan="2">Game ' . $games->getGameNumber() . '</th>';
        echo '</tr>';

        echo '<tr class="d-flex">'; // header
        echo '<td class="col-12">
                <div><img class="logo" src="' .BASE_URL.$todayImage1 . '" alt="' . $games->team1 . '"</img></div>
                <div class = "team-acronym">' . $team1Abbr . '</div>
             </td>';

        // echo '<td class = "col-3 p-1 dark-text text-center"><strong>'.$games->team1Score.'</strong></td>';
        echo '</tr>';

        echo '<tr class="d-flex">'; // header
        echo '<td class="col-12">
                <div><img class="logo" src="' .BASE_URL.$todayImage2 . '" alt="' . $games->team2 . '"</img></div>
                <div class = "team-acronym">' . $team2Abbr . '</div>
             </td>';
        // echo '<td class = "col-3 p-1 dark-text text-center"><strong>'.$games->team2Score.'</strong></td>';
        echo '</tr>';

        //echo '</tbody>';
        echo '</table>'; // end score-main table
                         // echo '</a>';
        echo '</div>';
    }
}

?>
    
    
  	
    </div>

</div>

<script>

$(function() {
	//$('#scoringBanner').show();
	$('.score-scroll').slick({
		  dots: true,
		  infinite: false,
		  speed: 300,
		  variableWidth: true,
		  slidesToShow: 9,
		  slidesToScroll: 9,
		  mobileFirst: true,
		 // prevArrow:"<img class='a-left control-c prev slick-prev' src='../images/shoe_story/arrow-left.png'>",
          //nextArrow:"<i class="a-left control-c prev slick-prev fas fa-angle-right">",
		  responsive: [
		  	{
		      breakpoint: 1024,
		      settings: {
		        slidesToShow: 12,
		        slidesToScroll:12,
		        infinite: false,
		        dots: true
		      }
		    },
		    {
		      breakpoint: 900,
		      settings: {
		        slidesToShow: 5,
		        slidesToScroll: 5,
		        infinite: false,
		        dots: true
		      }
		    },
		    {
		      breakpoint: 700,
		      settings: {
		        slidesToShow: 4,
		        slidesToScroll: 4,
		        touchThreshold:10
		      }
		    },
		    {
		      breakpoint: 550,
		      settings: {
		        slidesToShow: 4,
		        slidesToScroll: 4,
		        touchThreshold:10
		      }
		    },
		    {
		      breakpoint: 440,
		      settings: {
		        slidesToShow: 4,
		        slidesToScroll: 4,
		        touchThreshold:10
		      }
		    },
		    {
		      breakpoint: 350,
		      settings: {
		        slidesToShow: 3,
		        slidesToScroll: 3,
		        touchThreshold:10
		      }
		    }
		  ]
		});//.show();

	//$('#scoringBanner').show();
	$('#scoringBanner').fadeIn();
	

});
</script>





