<?php

#Debug Mode. 1 = ON, 0 = OFF
define('DEBUG_MODE', 1);


/* DO NOT TOUCH ANYTHING BELOW HERE!! */
define("BASE_URL",getBaseContext());
define("FS_ROOT",getFsRoot());
define("IS_IE",isIE());

if(DEBUG_MODE){
    error_log('-------config path info ---------');
    error_log('FS_ROOT='.FS_ROOT);
    error_log('BASE_URL='.BASE_URL);
    error_log('DOCUMENT_ROOT='.$_SERVER['DOCUMENT_ROOT']);
    error_log('---------------------------------');
}

function initLeagueMode($searchDir, $leagueMode) :string{
    
    //only run this logic once. cache result.
    //if(isset($GLOBALS["GLOB_LEAGUE_MODE"])) return $GLOBALS["GLOB_LEAGUE_MODE"];
    
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
    
    if(DEBUG_MODE){
        error_log('LEAGUE MODE = '.$result);
    }

    return $result;
}

function initLang($leagueLang) :string{

    //override lang
    if(isset($_GET['lang'])) {
        if($_GET['lang'] == 'EN' || $_GET['lang'] == 'FR'){
            setcookie('lang',$_GET['lang']);
            $leagueLang = $_GET['lang'];
        }
    }else if(isset($_COOKIE['lang'])){
        //set from cookie
        $leagueLang = $_COOKIE['lang'];
    }else{
        //otherwise use league default.
        setcookie('lang',$leagueLang);
    }
      
    if(DEBUG_MODE){
        error_log('LANG = '.$leagueLang);
    }

    return $leagueLang;
}

//must be called inside active session
function initNav($navbarMode, $navBarLoc = 'nav.php') :string{
    
    if($navbarMode == 1){
        $navBarLoc =  FS_ROOT.$navBarLoc;
    }else if($navbarMode == 2 || $navbarMode == 3){
        $navBarLoc = FS_ROOT.'navSimple.php';
    }else{
        $navBarLoc = '';
    }
    
    if(DEBUG_MODE){
        error_log('NAVMODE = '.$navbarMode);
        error_log('NAVLOC = '.$navBarLoc);
    }
    
    return $navBarLoc;
}

//retrieves base url relative to document root.
function getBaseUrl(){
    $protocol = getProtocol();
    $url = str_replace("\\",'/',$protocol.'://'.$_SERVER['HTTP_HOST'].substr(getcwd(),strlen($_SERVER['DOCUMENT_ROOT'])));
    
    $url = rtrim($url, '/') . '/';
    
    //append relativepath from doc root if appliable.
    $url = $url.str_replace(array('\\', '/'), '/', relativePath(getcwd(),__DIR__));
    
    return $url;
}

//retrieves base context relative to document root.
function getBaseContext(){
    
    $context = str_replace(array('\\', '/'), '/', substr(getcwd(),strlen($_SERVER['DOCUMENT_ROOT'])).'/'.relativePath(getcwd(),__DIR__));
    $context = rtrim($context, '/') . '/';
    
    return $context;
}

function getFsRoot(){
    
    $root = relativePath(getcwd(),__DIR__);
    if($root) $root = rtrim($root, '/') . '/';
    
    return $root;
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