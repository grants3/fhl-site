<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

mb_internal_encoding('UTF-8');
//mb_http_output('UTF-8');
//mb_http_input('UTF-8'); // Bug in PHP
mb_language('uni');
mb_regex_encoding('UTF-8');

require_once __DIR__.'/config.php';

// Detect if there is an error before this point and header already sent.
if (headers_sent($file, $line)) {
	echo "Headers sent in $file on line $line";
}

if (session_status() == PHP_SESSION_NONE) {
	session_name(SESSION_NAME);
	session_start();
}

include_once FS_ROOT.'lang.php';
include_once FS_ROOT.'common.php';
include_once FS_ROOT.'fileUtils.php';
include_once FS_ROOT.'classes/TeamHolder.php';

//page info
if(!isset($CurrentPage)){
    $CurrentPage = '';
}
if(!isset($_COOKIE['currentPage']) || $CurrentPage != $_COOKIE['currentPage']){
    setcookie('currentPage',$CurrentPage);
}

//set theme
if(isset($_GET['theme'])) {
    $_SESSION["theme"] = $_GET['theme'];
}

//set nav type
if(!isset($navbarEnabled)){
    $navbarEnabled = true;
}

if(!isset($navbarMode)) $navbarMode = NAVBAR_MODE;
if(isset($_GET['navbarMode'])) {
    $_SESSION["navbarMode"] = $_GET['navbarMode'];
    $navbarMode = $_GET['navbarMode'];
}
else if(isset($_SESSION['navbarMode'])){
    $navbarMode = $_SESSION["navbarMode"];
}

// // CREATE TEAM LIST
$gmFile = getCurrentLeagueFile('GMs');
$teamHolder = new TeamHolder($gmFile);
//needs to retain order.
$teamList = $teamHolder->get_teams();


//TRACK TEAM STATE
$currentTeam = '';
if(isset($_GET['team']) || isset($_POST['team'])) {
    $currentTeam = ( isset($_GET['team']) ) ? $_GET['team'] : $_POST['team'];
    $currentTeam = htmlspecialchars($currentTeam);
    
    $_SESSION["team"] = $currentTeam;
}

if(isset($_SESSION["team"])){
    $currentTeam = $_SESSION["team"];
}else{
    if($teamList) $currentTeam = $teamList[0]; //default to first team on list.
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  	<meta charset="UTF-8"/>
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

if($navbarEnabled){
    $navBarLocation = initNav($navbarMode,NAV_LOC);
    if($navBarLocation) include $navBarLocation;
    
}


?>

	<!-- REMOVE header-content -->
<div class="site-content top-container">


<?php 
if(DEMO_MODE){
    include FS_ROOT.'demo.php';
}?>

