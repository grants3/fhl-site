<?php

function getBaseUrl(){
    $protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    $url = str_replace("\\",'/',$protocol.'://'.$_SERVER['HTTP_HOST'].substr(getcwd(),strlen($_SERVER['DOCUMENT_ROOT'])));
    
    $url = rtrim($url, '/') . '/';
    
    //check relativepath
    //$url = $url.relativePath(getcwd(),__DIR__);
   //$url = str_replace(array('\\', '/'), '/', $url);
    
    $url = $url.str_replace(array('\\', '/'), '/', relativePath(getcwd(),__DIR__));
    
    return $url;
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


//define("BASE_URL",getBaseUrl());
define("BASE_URL",getBaseUrl());
define("FS_ROOT",__DIR__.'/');

#Debug Mode. 1 = ON, 0 = OFF
define("DEBUG_MODE",1);

if(DEBUG_MODE){
    error_log('-------config path info ---------');
    error_log('FS_ROOT='.FS_ROOT);
    error_log('BASE_URL='.BASE_URL);
    error_log('DOCUMENT_ROOT='.$_SERVER['DOCUMENT_ROOT']);
    error_log('FILE='.__FILE__);
    error_log('WORKING DIR='.getcwd());
    error_log('---------------------------------');
}


?>