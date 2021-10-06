<?php

require_once __DIR__.'/../config.php';
include_once FS_ROOT.'common.php';
include_once FS_ROOT.'lang.php';
include_once FS_ROOT.'classes/ScheduleHolder.php';
include_once FS_ROOT.'classes/ScheduleObj.php';
include_once FS_ROOT.'classes/TeamAbbrHolder.php';

?>

<link rel="stylesheet" type="text/css"
	href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
	
<link rel="stylesheet" type="text/css"
	href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

<script type="text/javascript"
	src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<style>

#scoringBanner{
display: none;
background:#444; 
padding-left:30px; 
padding-right:30px;
}

#scoringBanner .logo {
	float: left;
	vertical-align: middle;
	/*     width: 40px; */
	/*     height: 40px; */
	max-width: 25px;
	overflow: hidden;
	/*     margin: 0 auto; */
	margin-left: -2px;
	display: block;
}

#scoringBanner .table {
	height: 90px;
}

#scoringBanner .table th {
	vertical-align: middle;
	background-color: #dcdee0;
	border: 0;
	height: 20px;
	line-height: 10px;
}

#scoringBanner .table td {
	border: 1px solid #dcdee0;
	font-size: 15px;
	font-family: Arial, Helvetica, sans-serif;
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
	font-weight: bold;
	padding-left: 10px;
	vertical-align: middle;
}

.slick-prev, .slick-next {
	background-color: inherit;
}

.slick-slide {
	width: 95px;
}

.dayPlayed {
	height: 90px;
	/*      line-height: 90px;  */
	width: 50px;
	color: black;
	background-color: #dcdee0;
	margin-right: 2px;
    margin-left:2px;
    margin-top:10px;
}

.dayPlayed span {
	display: inline-flex;
    align-items: center;
    min-height: 90px;
}

.banner-game{
    width:90px;  
    height:90px;  
    margin-left:2px;
    margin-right:2px;
    margin-bottom:10px;
    margin-top:10px;
}


</style>

<div id="scoringBanner" class="container-fluid fhlElement px-0">
	<div class="button-container"></div>
	<div class="score-scroll">
    

<?php
$playoff = isPlayoffs($folder, $playoffMode);
if ($playoff == 1) {
    $playoff = 'PLF';
    $round = 0;

    //if (file_exists($folder . 'cehlPLF-Round4-Schedule.html')) {
    if (file_exists($folder . 'cehlPLF-Round4-Schedule.html')) {
        // $fileName = $folder.'cehlPLF-Round4-Schedule.html';
        $round = 4;
    } else if (file_exists($folder . 'cehlPLF-Round3-Schedule.html')) {
        // $fileName = $folder.'cehlPLF-Round3-Schedule.html';
        $round = 3;
    } else if (file_exists($folder . 'cehlPLF-Round2-Schedule.html')) {
        // $fileName = $folder.'cehlPLF-Round2-Schedule.html';
        $round = 2;
    } else if (file_exists($folder . 'cehlPLF-Round1-Schedule.html')) {
        // $fileName = $folder.'cehlPLF-Round1-Schedule.html';
        $round = 1;
    }

    $fileName = getLeagueFile($folder, $playoff, '-Round' . $round . '-Schedule.html', '-Round' . $round . '-Schedule');
    $playoffLink = '&rnd=' . $round;

    $scheduleHolder = new ScheduleHolder($fileName, '');

    $playedGamesRound = $round;
    $nextGamesRound = $round;

    if ($scheduleHolder->isScheduleComplete() && $round > 1 && $round < 4) {
        $nextGameScheduleHolder = $scheduleHolder;
        $nextRound = $round + 1;
        $fileName = getLeagueFile($folder, $playoff, '-Round' . $nextRound . '-Schedule.html', '-Round' . $nextRound . '-Schedule');

        $nextGamesRound = $nextRound;
    } else if (! $scheduleHolder->isSeasonStarted() && $round > 1) {
        $nextGameScheduleHolder = $scheduleHolder;
        $previousRound = $round - 1;
        $fileName = getLeagueFile($folder, $playoff, '-Round' . $previousRound . '-Schedule.html', '-Round' . $previousRound . '-Schedule');
        $scheduleHolder = new ScheduleHolder($fileName, '');

        $playedGamesRound = $previousRound;
        $playoffLink = '&rnd=' . $previousRound;
    } else {
        $nextGameScheduleHolder = $scheduleHolder;
    }

} else {
    $fileName = getLeagueFile($folder, $playoff, 'Schedule.html', 'Schedule');
    $scheduleHolder = new ScheduleHolder($fileName, '');
    $nextGameScheduleHolder = $scheduleHolder;
    $playoffLink = '';
}

$teamScoringFile = getLeagueFile($folder, $playoff, 'TeamScoring.html', 'TeamScoring');
$teamAbbrHolder = new TeamAbbrHolder($teamScoringFile);


// last games played scores
if ($scheduleHolder->isSeasonStarted()) {
    
    if (! $playoff) {
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
        if (! $playoff) {
            echo '<span><strong>Day ' . ($x) . '</strong></span>';
        } else {
            echo '<span><strong>Rnd ' . ($playedGamesRound) . '</strong></span>';
            echo '<span><strong>Day ' . ($x) . '</strong></span>';
        }
        
        // echo '</div>';
        echo '</div>';
        
        foreach ($scheduleHolder->getScheduleByDay($x) as $games) {
            
            // series over playoffs
            if (! $games->getIsRequired()) {
                continue;
            }
            
            $matches = glob(FS_ROOT.LOGO_DIR . strtolower($games->team1) . '.*');
            $todayImage1 = '';
            for ($j = 0; $j < count($matches); $j ++) {
                $todayImage1 = $matches[$j];
                $todayImage1 = basename($todayImage1);
                break 1;
            }
            $matches = glob(FS_ROOT.LOGO_DIR . strtolower($games->team2) . '.*');
            $todayImage2 = '';
            for ($j = 0; $j < count($matches); $j ++) {
                $todayImage2 = $matches[$j];
                $todayImage2 = basename($todayImage2);
                break 1;
            }
            
            $team1Abbr = $teamAbbrHolder->getAbbr($games->team1);
            $team2Abbr = $teamAbbrHolder->getAbbr($games->team2);
            
            echo '<div class="banner-game">';
            echo '<a href="'.BASE_URL.'games.php?num=' . $games->getGameNumber() . $playoffLink . '">';
            echo '<table class = "table table-sm mb-0"  >';
            echo '<tbody>';
            echo '<tr class="d-flex" style = "text-transform: uppercase;">'; // header
            echo '<th class="col-9 p-1">Final'. (($games->getIsOt()) ? '(OT)' : '').'</th>';
            echo '<th class="col-3 p-1"></th>';
            echo '</tr>';
            
            echo '<tr class="d-flex">'; // header
            echo '<td class="col-9 p-1">
                <div><img class="logo" src="'. BASE_URL.LOGO_DIR. $todayImage1 . '" alt="' . $games->team1 . '"</img></div>
                <div class = "team-acronym">' . $team1Abbr . '</div>
             </td>';
            
            echo '<td class = "col-3 p-1 dark-text text-center"><strong>' . $games->team1Score . '</strong></td>';
            echo '</tr>';
            
            echo '<tr class="d-flex">'; // header
            echo '<td class="col-9 p-1">
                <div><img class="logo" src="' . BASE_URL.LOGO_DIR.$todayImage2 . '" alt="' . $games->team2 . '"</img></div>
                <div class = "team-acronym">' . $team2Abbr . '</div>
             </td>';
            echo '<td class = "col-3 p-1 dark-text text-center"><strong>' . $games->team2Score . '</strong></td>';
            echo '</tr>';
            
            echo '</tbody>';
            echo '</table>'; // end score-main table
            echo '</a>';
            echo '</div>';
        }
    }
}

// next games
$nextGame = $nextGameScheduleHolder->getLastDayPlayed() + 1;
$nextGamesToProcess = ! $playoff ? $nextGame + 1 : $nextGame;

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
    if (! $playoff) {
        echo '<span><strong>Day ' . ($x) . '</strong></span>';
    } else {
        echo '<span><strong>Rnd ' . ($nextGamesRound) . '</strong></span>';
        echo '<span><strong>Day ' . ($x) . '</strong></span>';
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
        // echo '<a href="games.php?num='.$games->getGameNumber().$playoffLink.'">';
        echo '<table class = "table table-sm ">';
        echo '<tbody>';
        echo '<tr class="d-flex" style = "text-transform: uppercase;">'; // header
                                                                         // echo '<th class="col-9 p-1">Final</th>';
        echo '<th class="col-9 p-1">Game ' . $games->getGameNumber() . '</th>';
        echo '<th class="col-3 p-1"></th>';
        echo '</tr>';

        echo '<tr class="d-flex">'; // header
        echo '<td class="col-12 p-1">
                <div><img class="logo" src="' .BASE_URL.$todayImage1 . '" alt="' . $games->team1 . '"</img></div>
                <div class = "team-acronym">' . $team1Abbr . '</div>
             </td>';

        // echo '<td class = "col-3 p-1 dark-text text-center"><strong>'.$games->team1Score.'</strong></td>';
        echo '</tr>';

        echo '<tr class="d-flex">'; // header
        echo '<td class="col-12 p-1">
                <div><img class="logo" src="' .BASE_URL.$todayImage2 . '" alt="' . $games->team2 . '"</img></div>
                <div class = "team-acronym">' . $team2Abbr . '</div>
             </td>';
        // echo '<td class = "col-3 p-1 dark-text text-center"><strong>'.$games->team2Score.'</strong></td>';
        echo '</tr>';

        echo '</tbody>';
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





