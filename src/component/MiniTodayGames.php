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
?>

<style>
/*  .latest-game { border-radius:10px; border-style: solid; margin:5px; padding:5px; font-size: 17px;}   */
.latest-game {
    border-radius:5%; 
    border-style: solid; 
    margin:1%;
   
}
 .latest-image { max-width: 66%; height: auto; }

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

<!-- <div class = "row"> -->

<?php
//if(!isset($playoff)) $playoff = '';
$playoff = isPlayoffs($folder, $playoffMode);
if($playoff == 1) $playoff = 'PLF';

$Fnm = getLeagueFile($folder, $playoff, 'TodayGames.html', 'TodayGames');
//$Fnm = $folder.$folderLeagueURL.'TodayGames.html';
$i = 0;
$j = 0;
$round = 0;
$playoffLink = '';
$stop = 0;
if(isset($lastGames)) unset($lastGames);
if (file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = each($tableau)) {
		$val = utf8_encode($val);
		
		if(substr_count($val, 'mailto:alexdumont@lchv.biz')) {
			$stop = 1;
		}
		
		// Last Results
		if(substr_count($val, 'HREF')) {
			if($playoff == 'PLF' && substr_count($val, 'PLF-R')) {
				$round = trim(substr($val, strpos($val, 'PLF-R')+5, 1));
				$playoffLink = '&rnd='.$round;
			}
			if(substr_count($val, '</')) $reste = trim(substr($val, strpos($val, '>')+1, strpos($val, '</A>')-strpos($val, '>')-1));
			else $reste = trim(substr($val, strpos($val, '> ')+1));
			
			$lastGames[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			
			$count = strlen($reste);
			$z = 0;
			while( $z < $count ) {
				if( ctype_digit($reste[$z]) ) {
					$lastPos = $z;
					break 1;
				}
				$z++;
			}
			$lastEquipe1[$i] = trim(substr($reste, 0, $lastPos)); 
			$reste = trim(substr($reste, $lastPos));
			$lastScore1[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$count = strlen($reste);
			$z = 0;
			while( $z < $count ) {
				if( ctype_digit($reste[$z]) ) {
					$lastPos = $z;
					break 1;
				}
				$z++;
			}
			$lastEquipe2[$i] = trim(substr($reste, 0, $lastPos));
			$reste = trim(substr($reste, $lastPos));
			$lastScore2[$i] = $reste;
			$i++;
		}
	}
	
	if($stop == 0) {
		$c = 1;
		echo '<div class="row justify-content-center">'; 
		

		if(!isset($lastGames)) echo '<div class="col"><h3>'.$todayNoSimGame.'<h3></div>';
		else {
			for($i=0;$i<count($lastGames);$i++){
				
				$matches = glob($folderTeamLogos.strtolower($lastEquipe1[$i]).'.*');
				$todayImage1 = '';
				for($j=0;$j<count($matches);$j++) {
					$todayImage1 = $matches[$j];
					break 1;
				}
				$matches = glob($folderTeamLogos.strtolower($lastEquipe2[$i]).'.*');
				$todayImage2 = '';
				for($j=0;$j<count($matches);$j++) {
					$todayImage2 = $matches[$j];
					break 1;
				}

				echo '<div class="col-3 col-md-2 latest-game">';
					echo '<a href="games.php?num='.$lastGames[$i].$playoffLink.'">';
						echo '<div class="row latest-score">';
                            echo '<div class="latest-image"><img src="'.$todayImage1.'" alt="'.$lastEquipe1[$i].' "></div>';
                            echo '<div class="latest-score-text"><span>'.$lastScore1[$i].'</span></div>';
						echo '</div>';
						
						echo '<div class="row latest-score ">';
						    echo '<div class="latest-image"><img src="'.$todayImage2.'" alt="'.$lastEquipe2[$i].' "></div>';
						    echo '<div class="latest-score-text"><span>'.$lastScore2[$i].'</span></div>';
						echo '</div>';
					echo '</a>';
				echo '</div>'; 

			}
			echo '</div>'; 
			//echo '</div>';
		}
	
	}
	else echo 'BoxScore by Dominik Lavoie detected, use Original FHLsim files...';
}
else {
    //echo $allFileNotFound.' - '.$Fnm;
    echo 'No Results';
}
//echo '</div>';
?>

