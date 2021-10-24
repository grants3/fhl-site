<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once __DIR__.'/../baseConfig.php';

include_once FS_ROOT.'common.php';
include_once FS_ROOT.'api/controller/StatsController.php';
include_once FS_ROOT.'api/controller/RostersController.php';
include_once FS_ROOT.'api/controller/UnassignedController.php';
include_once FS_ROOT.'api/controller/ProspectsController.php';

include_once FS_ROOT.'api/ApiRequest.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );


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

$apiAction = '';
if(isset($_GET['action']) || isset($_POST['action'])) {
    $apiAction = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
}

try {

    // Get the REQUEST_URI.
    //$requestURI = $_SERVER['REQUEST_URI'];
    
    // Build an API Request and pass the REQUEST_URI var.
    //$request = new ApiRequest($requestURI);

    if('stats' == $apiParam){
        
        $controller = new StatsController();
        $controller->{$apiAction}();

    }else if('roster' == $apiParam){
        
        $controller = new RostersController();
        $controller->{$apiAction}();
        
    }else if('unassigned' == $apiParam){
        
        $controller = new UnassignedController();
        $controller->{$apiAction}();
        
    }else if('prospect' == $apiParam){
        
        $controller = new ProspectsController();
        $controller->{$apiAction}();
        
    }else{
        sendOutput(json_encode(array('error' => 'Invalid API')),
            array('Content-Type: application/json', 'HTTP/1.1 404 Not Found')
            );
    }
}
catch(Exception $e) {
    sendOutput(json_encode(array('error' => 'An Error Occured: '.$e)),
        array('Content-Type: application/json', 'HTTP/1.1 500 Internal Server Error')
        );
    if(DEBUG_MODE){
        error_log($e);
    }

}




// 
// require __DIR__ . "/inc/bootstrap.php";

// $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// $uri = explode( '/', $uri );

// if ((isset($uri[2]) && $uri[2] != 'user') || !isset($uri[3])) {
//     header("HTTP/1.1 404 Not Found");
//     exit();
// }

// require PROJECT_ROOT_PATH . "/Controller/Api/UserController.php";

// $objFeedController = new UserController();
// $strMethodName = $uri[3] . 'Action';
// $objFeedController->{$strMethodName}();
// 
function sendOutput($data, $httpHeaders=array())
{
    header_remove('Set-Cookie');
    
    if (is_array($httpHeaders) && count($httpHeaders)) {
        foreach ($httpHeaders as $httpHeader) {
            header($httpHeader);
        }
    }
    
    echo $data;
    exit;
}



//error_log(print_r($request,1));




?>


