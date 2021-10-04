<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once __DIR__.'/../../config.php';

include_once FS_ROOT.'common.php';
include_once FS_ROOT.'controller/PlayerScoringController.php';
include_once FS_ROOT.'api/ApiRequest.php';



$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

if(DEBUG_MODE){
    error_log(print_r($uri,1));
}

if(DEBUG_MODE){
    error_log(print_r($_GET,1));
}

// $apiParam = '';
// if(isset($_GET['$apiParam']) || isset($_POST['$apiParam'])) {
//     $apiParam = ( isset($_GET['$apiParam']) ) ? $_GET['$apiParam'] : $_POST['$apiParam'];
// }

$requestMethod = $_SERVER["REQUEST_METHOD"];
$requestData = $_GET;

// Get the REQUEST_URI.
$requestURI = $_SERVER['REQUEST_URI'];

// Build an API Request and pass the REQUEST_URI var.
$request = new ApiRequest($requestURI);
error_log(print_r($request,1));


$seasonId='';
$playoff='';
$fileName='';
$team = null;

if(isset($_GET['seasonId']) || isset($_POST['seasonId'])) {
    $seasonId = ( isset($_GET['seasonId']) ) ? $_GET['seasonId'] : $_POST['seasonId'];
}

if(isset($_GET['seasonType']) || isset($_POST['seasonType'])) {
    $seasonType = ( isset($_GET['seasonType']) ) ? $_GET['seasonType'] : $_POST['seasonType'];
    
    $playoff = $seasonType;
}

if(trim($seasonId) == false){
    $fileName = getLeagueFile(TRANSFER_DIR, $playoff, 'TeamScoring.html', 'TeamScoring');
}else{
    $seasonFolder =  str_replace("#",$seasonId,CAREER_STATS_DIR);
    $fileName = getLeagueFile($seasonFolder, $playoff, 'TeamScoring.html', 'TeamScoring');
}

// pass the request method and user ID to the PersonController and process the HTTP request:
$controller = new PlayerScoringController($requestMethod, $requestData, $fileName, $team);
$controller->processRequest();

?>


