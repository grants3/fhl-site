<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config.php';
include_once 'lang.php';
include_once 'common.php';

if (session_status() == PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_start();
}

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
if(isset($_GET['theme']) || isset($_POST['theme'])) {
    $_SESSION["theme"] = $_GET['theme'];
}
else if(!isset($_SESSION['theme'])){
    $_SESSION["theme"] = 'DEFAULT';
}

//set nav type
if(isset($_GET['navbarMode']) || isset($_POST['navbarMode'])) {
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

if($SecurePage){
    if(!isAuthenticated()){
        header('Location: Login.php');
        exit();
    }
}

if(isset($_SESSION['teamId'])){
    $teamID = $_SESSION['teamId'];
}


//TRACK TEAM STATE
$currentTeam = '';
if(isset($_GET['team']) || isset($_POST['team'])) {
    $currentTeam = ( isset($_GET['team']) ) ? $_GET['team'] : $_POST['team'];
    $currentTeam = htmlspecialchars($currentTeam);
    
    $_SESSION["team"] = $currentTeam;
}
else {
    if(isset($_SESSION["team"])){
        $currentTeam = $_SESSION["team"];
    }
}


//TRACK PLAYOFF STATE
$playoff = '';
$currentPLF = 0;

if(isPlayoffs(TRANSFER_DIR, LEAGUE_MODE)){
    $playoff = 'PLF';
    $currentPLF = 1;
}

//$dropLinkPlf = '';
$plfLink = '';
$tmpFolderPlayoff = '';
// TEAM CARD - SEE IF PLAYOFFS GMS FILE EXISTS
$matches = glob(TRANSFER_DIR.'*GMs.html');
$matchesDate = array_map('filemtime', $matches);
arsort($matchesDate);
foreach ($matchesDate as $j => $val) {
	$tmpFolderPlayoff = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'GMs')-strrpos($matches[$j], '/')-1);
	break 1;
}
//if($CurrentPage == 'fiche') {
if($CurrentPage == 'Overview') {
	if(substr_count($tmpFolderPlayoff, 'PLF')) {
		$playoff = 'PLF';
		$currentPLF = 1;
		$plfLink = '?plf=1';
	}
}

if(isset($_GET['plf']) || isset($_POST['plf'])) {
	$currentPLF = ( isset($_GET['plf']) ) ? $_GET['plf'] : $_POST['plf'];
	$currentPLF = htmlspecialchars($currentPLF);
	if($currentPLF == 1) {
		$playoff = 'PLF';
		//$dropLinkPlf = 'plf=1&';
		$plfLink = '?plf=1';
	}
	if($currentPLF == 0) $playoff = '';
}
if(isset($_GET['rnd']) || isset($_POST['rnd'])) {
	$playoff = 'PLF';
	$currentPLF = 1;
	//$dropLinkPlf = 'plf=1&';
	$plfLink = '?plf=1';
}

//SORTING (FACTOR THIS OUT)
$sort = '';
if(isset($_GET['sort']) || isset($_POST['sort'])) {
	$sort = ( isset($_GET['sort']) ) ? $_GET['sort'] : $_POST['sort'];
	$sort = htmlspecialchars($sort);
}

$dropLinkOne = '';
if($CurrentPage == 'CareerLeaders' && (isset($_GET['one']) || isset($_POST['one']))) {
	$ctlOneTeams = ( isset($_GET['one']) ) ? $_GET['one'] : $_POST['one'];
	$ctlOneTeams = trim(htmlspecialchars($ctlOneTeams));
	if($ctlOneTeams == 1) $dropLinkOne = 'one=1&';
}

// CREATE TEAM LIST
$matches = glob(TRANSFER_DIR.'*'.$playoff.'GMs.html');
$folderLeagueURL = '';
$matchesDate = array_map('filemtime', $matches);
arsort($matchesDate);
foreach ($matchesDate as $j => $val) {
	if((!substr_count($matches[$j], 'PLF') && $playoff == '') || (substr_count($matches[$j], 'PLF') && $playoff == 'PLF')) {
		$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'GMs')-strrpos($matches[$j], '/')-1);
		break 1;
	}
}
$FnmGMs = TRANSFER_DIR.$folderLeagueURL.'GMs.html';
$i = 0;
if(file_exists($FnmGMs)) {
	$tableau = file($FnmGMs);
	/* while(list($cle,$val) = each($tableau)) { */
	while(list($cle,$val) = myEach($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, 'HREF') && !substr_count($val, '<BR>')) {
			$gmequipe[$i] = trim(substr($val, 0, 10));
			if($currentTeam == '' && $i == 0) $currentTeam = $gmequipe[$i];
			$i++;
		}
	}
}
//else echo $allFileNotFound.' - '.$FnmGMs;


$farm = '';
$dropLinkFarm = '';
$currentFarm = 0;
if(isset($_GET['s']) || isset($_POST['s'])) {
	$currentFarm = ( isset($_GET['s']) ) ? $_GET['s'] : $_POST['s'];
	$currentFarm = htmlspecialchars($currentFarm);
	if($currentFarm == 1) {
		$farm = 'Farm';
		//if($CurrentPage == 'Standings') $CurrentTitle = $standingTitleFarm;
		//if($CurrentPage == 'OverallStandings') $CurrentTitle = $standingTitleFarm;
		if($CurrentPage == 'Leaders') $CurrentTitle = $leaderTitleFarm;
		$dropLinkFarm = 's=1&';
	}
}

// if(isset($skipNav) && !$skipNav){
 
// }else{
//     include 'nav.php';
// //     echo '<div class="header-content top-container"></div>';
// }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  	<meta charset="UTF-8"/>
  	<meta http-equiv="x-ua-compatible" content="ie=edge,chrome=1">
  	<meta name="viewport" content="width=device-width, initial-scale=0.85, maximum-scale=3.0, minimum-scale=0.85"/>
  	<title>Canadian Elite Hockey League</title>

	<?php if(CDN_SUPPORT) {?>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,600"/>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css"/>
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.6/css/all.css"/> -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.css"/>
	<?php }else{?>
	<link rel="stylesheet" href="<?php echo BASE_URL?>assets/css/ex/fonts.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL?>assets/css/ex/bootstrap.min.css"/>
    <link rel="stylesheet" href="<?php echo BASE_URL?>assets/css/ex/font-awesome-all.css"/>
	<link rel="stylesheet" href="<?php echo BASE_URL?>assets/css/ex/animate.css"/>
	<?php }?>
     
     <!-- JQuery and bootstrap init -->
    <?php if(CDN_SUPPORT) {?>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.13.0/umd/popper.min.js"></script>
<!--     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.1/js/jquery.tablesorter.min.js"></script>
	<?php }else{?>
	<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/popper.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/jquery.tablesorter.min.js"></script>
	<?php }?>
     

	 <!-- Other scripts -->
	<?php if(CDN_SUPPORT) {?>
<!-- 	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.13.0/umd/popper.min.js"></script> -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-backstretch/2.0.4/jquery.backstretch.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
	<?php }else{?>
<!-- 	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.13.0/umd/popper.min.js"></script> -->
	<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/jquery.backstretch.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/wow.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/jquery.waypoints.min.js"></script>
	<?php }?>


	<!-- Datatables support -->
	<?php if(isset($dataTablesRequired) && $dataTablesRequired) {?>
	<?php if(CDN_SUPPORT) {?>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"/>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedcolumns/3.2.6/css/fixedColumns.bootstrap4.min.css"/>
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css"/>
	
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js"></script>
	
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<?php }else{?>
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL?>assets/css/ex/datatables/dataTables.bootstrap4.min.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL?>assets/css/ex/datatables/fixedColumns.bootstrap4.min.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL?>assets/css/ex/datatables/buttons.dataTables.min.css"/>
	
	<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/datatables/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/datatables/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/datatables/dataTables.fixedColumns.min.js"></script>
	
	<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/datatables/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/datatables/buttons.html5.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/datatables/buttons.print.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/datatables/jszip.min.js"></script>
	<?php }?>
	<?php }?>
	
	<?php 
	//cache bust css.(should evade caching same filename when contents changes)
	$cssHash = hash_file('crc32',FS_ROOT.'assets/css/style-1.css');
	//$cssHash = '123';
	$cssHashUrl= '?m='.$cssHash;
	?>

	<!-- Custom scripts and styling and overrides (load last)-->
	<link rel="stylesheet" href="<?php echo BASE_URL?>assets/css/style-1.css<?php echo $cssHashUrl;?>"/>
	<link rel="stylesheet" href="<?php echo BASE_URL?>assets/css/media-queries-09302021.css"/>
	<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/scripts-1.js"></script>

	<!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-141959083-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'UA-141959083-1');
    </script>
	
	
	<!-- css legacy browser (IE 9+ support) polyfill for unsupported css vars -->
	<?php if(CDN_SUPPORT) {?>
<!-- 	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/css-vars-ponyfill@1"></script> -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/css-vars-ponyfill/2.4.3/css-vars-ponyfill.min.js"></script>
	<?php }else{?>
	<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/css-vars-ponyfill@1.js"></script>
	<?php }?>

	
	<script type="text/javascript">
	cssVars({
	  onlyLegacy: true,
      rootElement: document // default
    });
    
	</script>

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
	
	
	<!-- style overrides -->
	<?php include_once FS_ROOT.'style.php' ?>
</head>

<body class="fhlElement">

<?php 
if(isset($navbarMode) && $navbarMode != 0){
    if($navbarMode == 1){
        include FS_ROOT.'nav.php';
    }else if($navbarMode == 2 || $navbarMode == 3){
        include FS_ROOT.'navSimple.php';
    }else{
        error_log("unsupported nav mode: ".$navbarMode);
    }
}

?>

	
<div class="container-responsive site-content header-content top-container">

<style>

.floating-menu-main{
    background-color: rgba(255,255,255,0.5);
    margin-top:100px;
    padding: 0px;
    margin-left: 5px;
    width: 100px;
    z-index: 100;
    position: fixed;
}
.floating-menu-main .btn-sm{
 background-color:transparent
}

    .floating-menu {

    background-color:white;

  }
  .floating-menu a, 
  .floating-menu h3 {
    font-size: 0.9em;
    display: block;
    margin: 1em 0.5em;
    color: black;
  }
  

  
</style>

<?php if(isset($CurrentHTML) && $CurrentHTML == 'index.php' || str_starts_with($CurrentHTML,'Team') ){?>
<div class="floating-menu-main">
<button class="btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    <span class="font-weight-bold">Demo Options</span>
</button>
<nav class="floating-menu collapse" id="collapseExample">
    <h3 class="text-left font-weight-bold">Theme</h3>
    <a href="<?php echo BASE_URL.$CurrentHTML?>?theme=blue">Blue</a>
    <a href="<?php echo BASE_URL.$CurrentHTML?>?theme=green">Green</a>
    <a href="<?php echo BASE_URL.$CurrentHTML?>?theme=red">Red</a>
    <h3 class="text-left font-weight-bold">Nav Mode</h3>
    <a href="<?php echo BASE_URL.$CurrentHTML?>?navbarMode=1">Full</a>
    <a href="<?php echo BASE_URL.$CurrentHTML?>?navbarMode=0">None</a>
    <a href="<?php echo BASE_URL.$CurrentHTML?>?navbarMode=2">Simple</a>
    <a href="<?php echo BASE_URL.$CurrentHTML?>?navbarMode=3">Simple Min</a>
</nav>
</div>
<?php }?>


