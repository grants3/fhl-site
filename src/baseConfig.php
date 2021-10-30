<?php
/* DO NOT TOUCH ANYTHING IN HERE!! */

define("BASE_URL",getBaseUrl());
define("FS_ROOT",__DIR__.'/');
define("IS_IE",isIE());

#Debug Mode. 1 = ON, 0 = OFF
define("DEBUG_MODE",0);

if(DEBUG_MODE){
    error_log('-------config path info ---------');
    error_log('FS_ROOT='.FS_ROOT);
    error_log('BASE_URL='.BASE_URL);
    error_log('DOCUMENT_ROOT='.$_SERVER['DOCUMENT_ROOT']);
    error_log('---------------------------------');
}

function inferLeagueMode($searchDir, $leagueMode) :string{
    
    //only run this logic once. cache result.
    if(isset($GLOBALS["GLOB_LEAGUE_MODE"])) return $GLOBALS["GLOB_LEAGUE_MODE"];
    
    //regular season
    $result = 'REG';
    
    if($leagueMode == 1){
        $result = 'PLF';
    }else if ($leagueMode == 2){ //auto
        $matches = glob($searchDir.'*PLFGMs.html',GLOB_NOSORT);

        if($matches){
            $result = 'PLF';
        }
    }
    
    $GLOBALS["GLOB_LEAGUE_MODE"] = $result;

    return $result;
}

function getBaseUrl(){
    $protocol = getProtocol();
    $url = str_replace("\\",'/',$protocol.'://'.$_SERVER['HTTP_HOST'].substr(getcwd(),strlen($_SERVER['DOCUMENT_ROOT'])));
    
    $url = rtrim($url, '/') . '/';
    
    //check relativepath
    $url = $url.str_replace(array('\\', '/'), '/', relativePath(getcwd(),__DIR__));
    
    return $url;
}

function getProtocol(){
    return isset($_SERVER["HTTPS"]) ? 'https' : 'http';
}

/**
 * Return relative path between two sources
 * @param $from
 * @param $to
 * @param string $separator
 * @return string
 */
function relativePath($from, $to, $separator = DIRECTORY_SEPARATOR)
{

    $from   = str_replace(array('/', '\\'), $separator, $from);
    $to     = str_replace(array('/', '\\'), $separator, $to);
    
    $arFrom = explode($separator, rtrim($from, $separator));
    $arTo = explode($separator, rtrim($to, $separator));
    while(count($arFrom) && count($arTo) && ($arFrom[0] == $arTo[0]))
    {
        array_shift($arFrom);
        array_shift($arTo);
    }
    
    return str_pad("", count($arFrom) * 3, '..'.$separator).implode($separator, $arTo);
}

function isIE(){   
    $ua = htmlentities($_SERVER['HTTP_USER_AGENT'], ENT_QUOTES, 'UTF-8');
    if (preg_match('~MSIE|Internet Explorer~i', $ua) || (strpos($ua, 'Trident/7.0') !== false && strpos($ua, 'rv:11.0') !== false)) {
       return true;
    }

    return false;
}



?>