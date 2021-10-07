<?php

function isAuthenticated(){
    
    if(isset($_SESSION['authenticated']) && $_SESSION['authenticated']){
        return true;
    }
    
    return false;
}

function jsonPrettify($json)
{
    $array = json_decode($json, true);
    $json = json_encode($array, JSON_PRETTY_PRINT);
    return $json;
}

function json_response($json=null, $httpStatus=200)
{
    header_remove();
    
    header("Content-Type: application/json");
    
    http_response_code($httpStatus);
    
    echo $json;
    
    exit();
}

function IsNullOrEmptyString($str){
    return (!isset($str) || trim($str) === '');
}

function myEach(&$arr) {
    $key = key($arr);
    $result = ($key === null) ? false : [$key, current($arr), 'key' => $key, 'value' => current($arr)];
    next($arr);
    return $result;
}

function getLeagueFile($rootFolder, $playoff, $fileName, $name) {
    
    $fileName = $name.'.html';
    
    //handle boolean and txt value. assumes any text value other than empty means playoffs is active (legacy support)
    if (!isset($playoff)){
        $playoff = '';
    }else{
        if($playoff && !empty($playoff)){
            $playoff = 'PLF';
        }else{
            $playoff = '';
        }
    }

    $matches = glob($rootFolder . '*' . $playoff . $fileName);
    $folderLeagueURL = '';
    $matchesDate = array_map('filemtime', $matches);
    arsort($matchesDate);
    foreach ($matchesDate as $j => $val) {
        if ((! substr_count($matches[$j], 'PLF') && $playoff == '') || (substr_count($matches[$j], 'PLF') && $playoff == 'PLF')) {
            $folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/') + 1, strpos($matches[$j], $name) - strrpos($matches[$j], '/') - 1);
            break 1;
        }
    }
    return $rootFolder.$folderLeagueURL . $fileName;
}

function getLeagueFile2($rootFolder, $playoff, $fileName, $name, $exclude) {
    
    if (! isset($playoff))
        $playoff = '';
        
        $matches = glob($rootFolder . '*' . $playoff . $fileName);
        $folderLeagueURL = '';
        $matchesDate = array_map('filemtime', $matches);
        arsort($matchesDate);
        foreach ($matchesDate as $j => $val) {

            if(isset($exclude) && $exclude != '' && substr_count($matches[$j], $exclude)){
               continue; 
            }
            
            if ((! substr_count($matches[$j], 'PLF') && $playoff == '') || (substr_count($matches[$j], 'PLF') && $playoff == 'PLF')) {
                $folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/') + 1, strpos($matches[$j], $name) - strrpos($matches[$j], '/') - 1);
                break 1;
            }
        }
        return $rootFolder.$folderLeagueURL . $fileName;
}

//check playoff mode. 0 = auto detect, 1 regular season, 2 playoffs.
function isPlayoffs($rootFolder, $playoffMode){

    if (!isset($playoffMode)){
        $playoffMode = 0;
    }
    
    if($playoffMode == 0){
        if(!empty(glob($rootFolder . '*PLFGMs.html'))){
            return true;
        }
    }else{
        if($playoffMode == 2){
            return true;
        }
    }
    
    return false;
}

function getFilteredArray($aFilterKey, $aFilterValue, $array) {
    $filtered_array = array();
    foreach ($array as $value) {
        
        if (isset($value->$aFilterKey)) {
            if($aFilterValue == $value->$aFilterKey){
                $filtered_array[] = $value;
            }
        }
        
    }
    
    return $filtered_array;
}

function getPreviousSeasons($folderCarrerStats):array{
    $seasons = array();
    
    if(isset($folderCarrerStats)) {

        $dirs = array_filter(glob(str_replace("#/","*",$folderCarrerStats)), 'is_dir');

        foreach($dirs as $dir) {
            $tmpYear = substr($dir, strlen($folderCarrerStats)-2);
            array_push($seasons, $tmpYear);
        }
        
    }
    
    rsort($seasons);
    
    return $seasons;
}

/*usage example: includeWithVariables('component/teamDropdown.php',array('teamList' => $teamList, 'teamDropdownPrefix' => 'roster', 'CurrentPage' => $CurrentPage)); */
function includeWithVariables($filePath, $variables = array(), $print = true)
{
    $output = NULL;
    if(file_exists($filePath)){
        // Extract the variables to a local namespace
        extract($variables);
        
        // Start output buffering
        ob_start();
        
        // Include the template file
        include $filePath;
        
        // End buffering and return its contents
        $output = ob_get_clean();
    }
    if ($print) {
        print $output;
    }
    return $output;
    
}

/*starts with*/
function str_starts_with ( $haystack, $needle ) {
    return strpos( $haystack , $needle ) === 0;
}

/*starts with with position*/
function strposX($haystack, $needle, $number)
{
    // decode utf8 because of this behaviour: https://bugs.php.net/bug.php?id=37391
    preg_match_all("/$needle/", utf8_decode($haystack), $matches, PREG_OFFSET_CAPTURE);
    return $matches[0][$number-1][1];
}

/*backwards compatibility functions if mb module is not loaded in php*
 * These functions are hardcoded to UTF encoding. the $encoding variable has no effect. 
 */
if (!function_exists('mb_substr')){
    function mb_substr($string, $offset, $length, $encoding = 'UTF-8')
    {
        $arr = preg_split("//u", $string);
        $slice = array_slice($arr, $offset + 1, $length);
        return implode("", $slice);
    }
}

if (!function_exists('mb_strlen')){
    function mb_strlen(string $str, string $encoding = 'UTF-8')
    {
        return preg_match_all('(.)su', $str);
    }
}


function URL_exists($url){

    //override ssl context for the call
    stream_context_set_default( [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
        ],
    ]);

    $headers = @get_headers($url->_value);
    if(strpos($headers[0],'200')===false)return false;
    
    stream_context_set_default( [
        'ssl' => [
            'verify_peer' => true,
            'verify_peer_name' => true,
        ],
    ]);
    
    return true;
    
  //  return $exists;
}


?>