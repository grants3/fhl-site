<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once __DIR__.'/../baseConfig.php';

include_once FS_ROOT.'common.php';
include_once FS_ROOT.'controller/PlayerScoringController2.php';
include_once FS_ROOT.'api/ApiRequest.php';

$apiPlayerStats = 'playerStats';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );
error_log(print_r($uri,1));
if(DEBUG_MODE){
    error_log(print_r($uri,1));
}

if(DEBUG_MODE){
    error_log(print_r($_GET,1));
}

$apiParam = null;
if(isset($_GET['api']) || isset($_POST['api'])) {
    $apiParam = ( isset($_GET['api']) ) ? $_GET['api'] : $_POST['api'];
}

if(isset($apiParam)){
    // Get the REQUEST_URI.
    $requestURI = $_SERVER['REQUEST_URI'];
    
    // Build an API Request and pass the REQUEST_URI var.
    $request = new ApiRequest($requestURI);
    error_log(print_r($request,1));
    
    if($apiPlayerStats == $apiParam){
        // pass the request method and user ID to the PlayerScoringController and process the HTTP request:
        $controller = new PlayerScoringController2($request);
        $controller->processRequest();
    }else{
        http_response_code( 404 );
    }
 
    
}else{
    http_response_code( 404 );
}




//error_log(print_r($request,1));




?>


