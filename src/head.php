<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
mb_http_input('UTF-8');
mb_language('uni');
mb_regex_encoding('UTF-8');

require_once 'config.php';

//set possible local formats if they exist. 
// if(LEAGUE_LANG == 'FR'){
//     if (false !== setlocale(LC_NUMERIC, 'fr_CA', 'fr_CA.UTF-8', 'fr','fr.UTF-8')) {
//         setlocale(LC_MONETARY, 'fr_CA', 'fr_CA.UTF-8', 'fr','fr.UTF-8');
//     }
// }else{
//     if (false !== setlocale(LC_NUMERIC, 'en_CA', 'en_CA.UTF-8', 'en-US','en_US.UTF-8', 'en')) {
//         setlocale(LC_MONETARY, 'en_CA', 'en_CA.UTF-8', 'en_US','en_US.UTF-8', 'en');
//     }
// }


if (session_status() == PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_start();
}


//override lang
if(isset($_GET['lang'])) {
	if($_GET['lang'] == 'EN' || $_GET['lang'] == 'FR'){
	    $_SESSION['lang'] = $_GET['lang'];
	}
}

if(isset($_SESSION['lang'])){
    $leagueLang = $_SESSION['lang'];
}

include 'lang.php';
include_once 'common.php';
include_once 'fileUtils.php';
include_once 'classes/TeamHolder.php';



if(!isset($CurrentPage)){
    $CurrentPage = '';
}

if(!isset($SecurePage)){
    $SecurePage = false;
}

if(!isset($navbarEnabled)){
    $navbarEnabled = true;
}

//set theme
if(isset($_GET['theme'])) {
    $_SESSION["theme"] = $_GET['theme'];
}
// else if(!isset($_SESSION['theme'])){
//     $_SESSION["theme"] = SITE_THEME;
// }

//set nav type
$navbarMode = NAVBAR_MODE;
if(isset($_GET['navbarMode'])) {
    $_SESSION["navbarMode"] = $_GET['navbarMode'];
    $navbarMode = $_SESSION["navbarMode"];
}
else if(isset($_SESSION['navbarMode'])){
    $navbarMode = $_SESSION["navbarMode"];
}


//page info

if ($CurrentPage !== ''){
    setcookie('currentPage',$CurrentPage);
}

// if(isset($_SESSION['teamId'])){
//     $teamID = $_SESSION['teamId'];
// }

//backwards compatibility
//$folder = FS_ROOT;
//$folderGames = GAMES_DIR;
//TRACK PLAYOFF STATE
$playoff = '';
$currentPLF = 0;
if(PLAYOFF_MODE){
    $playoff = 'PLF';
    $currentPLF = 1;
}

// // CREATE TEAM LIST
//$gmFile = getLeagueFile($folder, $playoff, 'GMs.html', 'GMs');
$gmFile = getCurrentLeagueFile('GMs');
$teamHolder = new TeamHolder($gmFile);
//needs to retain order.
$teamList = $teamHolder->get_teams();


//TRACK TEAM STATE
if($teamList) $currentTeam = $teamList[0]; //default to first team on list.
if(isset($_GET['team']) || isset($_POST['team'])) {
    $currentTeam = ( isset($_GET['team']) ) ? $_GET['team'] : $_POST['team'];
    $currentTeam = htmlspecialchars($currentTeam);
    
    $_SESSION["team"] = $currentTeam;
}

if(isset($_SESSION["team"])){
    $currentTeam = $_SESSION["team"];
}




?>
<!DOCTYPE html>
<html lang="en">
<head>
  	<meta charset="UTF-8"/>
<!--   	<meta http-equiv="x-ua-compatible" content="ie=edge,chrome=1"> -->
	<meta http-equiv="x-ua-compatible" content="ie=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=0.85, maximum-scale=3.0, minimum-scale=0.85"/>
  	<title><?php echo LEAGUE_NAME;?></title>
	
	<?php //load css/js and other assets?>
	<?php include FS_ROOT.'assets.php';?>


	<!-- style overrides -->
	<?php include_once FS_ROOT.'style.php' ?>

	<script>

		$(document).ready(function() {  
         $(function () {
             $("body").tooltip({
                 selector: '[data-toggle="tooltip"]',
                 container: 'body',
                 trigger: 'hover focus',
                 delay:{hide:0}
             });

             
         })

         $(function () {
        	   $(document).on('shown.bs.tooltip', function (e) {
        	      setTimeout(function () {
        	        $(e.target).tooltip('hide');
        	      }, 500);
        	   });
        	});
        });

	</script>

</head>

<body class="fhlElement">

<?php 
if(isset($navbarMode) && $navbarMode != 0){
    if($navbarMode == 1){
        include FS_ROOT.'nav.php';
    }else if($navbarMode == 2 || $navbarMode == 3){
        include FS_ROOT.'navSimple.php';
    }else if($navbarMode == 4){
        include FS_ROOT.'navCustom.php';
    }else{
        echo '<h5>Unsupported Nav</h5>';
    }
}

?>

	
<div class="container-fluid2 site-content header-content top-container">

<?php include FS_ROOT.'demo.php'?>

