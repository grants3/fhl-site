<?php
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once __DIR__.'/../baseConfig.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

$apiParam = null;
if(isset($_GET['api']) || isset($_POST['api'])) {
    $apiParam = ( isset($_GET['api']) ) ? $_GET['api'] : $_POST['api'];
}

$apiAction = '';
if(isset($_GET['action']) || isset($_POST['action'])) {
    $apiAction = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
}

try {

    if('stats' == $apiParam){
        include_once FS_ROOT.'api/controller/StatsController.php';
        $controller = new StatsController();
        $controller->{$apiAction}();

    }else if('roster' == $apiParam){
        include_once FS_ROOT.'api/controller/RostersController.php';
        $controller = new RostersController();
        $controller->{$apiAction}();
        
    }else if('unassigned' == $apiParam){
        include_once FS_ROOT.'api/controller/UnassignedController.php';
        $controller = new UnassignedController();
        $controller->{$apiAction}();
        
    }else if('prospect' == $apiParam){
        include_once FS_ROOT.'api/controller/ProspectsController.php';
        $controller = new ProspectsController();
        $controller->{$apiAction}();
        
    }else{
        sendOutput(json_encode(array('error' => 'Invalid API Request')),
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


?>


