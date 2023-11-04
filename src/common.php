<?php

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
if(!function_exists('str_starts_with')) {
    function str_starts_with ( $haystack, $needle ) {
        return strpos( $haystack , $needle ) === 0;
    }
}

/*starts with with position*/
function strposX($haystack, $needle, $number)
{
    // decode utf8 because of this behaviour: https://bugs.php.net/bug.php?id=37391
    $haystack = mb_convert_encoding($haystack, 'Windows-1252', 'UTF-8'); // utf8_decode (decapreted)
    preg_match_all("/$needle/", $haystack, $matches, PREG_OFFSET_CAPTURE);
    return $matches[0][$number-1][1];
}

function str_lreplace($search, $replace, $subject)
{
    $pos = strrpos($subject, $search);
    
    if($pos !== false)
    {
        $subject = substr_replace($subject, $replace, $pos, strlen($search));
    }
    
    return $subject;
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

function toMoney($val,$symbol='$',$r=2)
{
    
    
    $n = $val;
    $c = is_float($n) ? 1 : number_format($n,$r);
    $d = '.';
    $t = ',';
    $sign = ($n < 0) ? '-' : '';
    $i = $n=number_format(abs($n),$r);
    $j = (($j = $i.length) > 3) ? $j % 3 : 0;
    
    return  $symbol.$sign .($j ? substr($i,0, $j) + $t : '').preg_replace('/(\d{3})(?=\d)/',"$1" + $t,substr($i,$j)) ;
    
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

function formatHtmlText(string $text){
     $text = str_replace('-', '&#8209;', $text);   
     return str_replace(' ', '&nbsp', $text);
}

// Format Ordinal
function ordinalEnglish($number) {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number%100) <= 13))
        return $number. 'th';
        else
            return $number. $ends[$number % 10];
}
function ordinalFrench($number) {
    if($number == 1) return $number. 'er';
    else return $number. 'e';
}

// Encode to UTF-8 new way!
if(!function_exists('encodeToUtf8')){
	function encodeToUtf8($string) {
		return mb_convert_encoding($string, "UTF-8", mb_detect_encoding($string, "Windows-1252, ISO-8859-1, ISO-8859-15", true));
	}
}

?>
