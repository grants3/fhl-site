<?php

require_once __DIR__.'/config.php';
include_once FS_ROOT.'common.php';

function getTeamLogo(string $teamName) :string{
    $matches = glob(FS_ROOT.LOGO_DIR . strtolower($teamName) . '.*');
    $teamLogoFile = '';
    for ($j = 0; $j < count($matches); $j ++) {
        $teamLogoFile = $matches[$j];
        break 1;
    }
    
    return $teamLogoFile;
}

function getTeamLogoUrl(string $teamName) :string{    
    return BASE_URL.LOGO_DIR.basename(getTeamLogo($teamName));
}

function leagueFileExists(string $baseName, string $seasonType, int $seasonId, string $exclude=null) {
    return file_exists(_getLeagueFile($seasonType, $baseName, $seasonId, $exclude));
}



function getLeagueFile5(string $baseName, string $exclude=null) {
    if($playoff) $playoff = 'PLF';
    return _getLeagueFile($baseName, $playoff, $seasonId, $exclude);
}

function _getLeagueFile(string $baseName, string $seasonType, int $seasonId = 0, string $exclude=null) {
    
    $filePrefix = '';
    if(isset($seasonType)){
        if(!('PLF' == $seasonType || 'PRE' == $seasonType)){
            $seasonType = '';
        }
    }else{
        $seasonType = '';
    }

    $searchFolder = TRANSFER_DIR;
    
    if(isset($seasonId) && !$seasonId){
        $searchFolder =  str_replace("#",$seasonId,CAREER_STATS_DIR);
    }
    
    if('PRE' == $seasonType){
        $searchFolder = $searchFolder.'pre/';
    }else if('PLF'){
        $filePrefix = 'PLF';
    }
    
    return getLeagueFile3($searchFolder, $filePrefix.'TeamScoring.html', $exclude);
}

/*
 * rootFolder = path to look
 * playoff = playoff mode. could be boolean value or have the text 'PLF'
 * baseName = Base File name without extending. e.g Standings (assumes html)
 * exclude = exclude filenames that may have the same suffix (Standings)
 */
function getLeagueFile3($rootFolder, $baseName, bool $exclude=null) {
    
    $fileName = $baseName.'.html';

    $matches = glob($rootFolder . '*' . $playoff . $fileName);
    $folderLeagueURL = '';
    $matchesDate = array_map('filemtime', $matches);
    arsort($matchesDate);
    foreach ($matchesDate as $j => $val) {
        
        if(isset($exclude) && $exclude != '' && substr_count($matches[$j], $exclude)){
            continue;
        }
        
        $folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/') + 1, strpos($matches[$j], $baseName) - strrpos($matches[$j], '/') - 1);
        break 1;
    }
    
    return $rootFolder.$folderLeagueURL.$fileName;
}

// function getLeagueFile2($rootFolder, $playoff, $fileName, $name, $exclude) {
    
//     if (! isset($playoff))
//         $playoff = '';
        
//         $matches = glob($rootFolder . '*' . $playoff . $fileName);
//         $folderLeagueURL = '';
//         $matchesDate = array_map('filemtime', $matches);
//         arsort($matchesDate);
//         foreach ($matchesDate as $j => $val) {
            
//             if(isset($exclude) && $exclude != '' && substr_count($matches[$j], $exclude)){
//                 continue;
//             }
            
//             if ((! substr_count($matches[$j], 'PLF') && $playoff == '') || (substr_count($matches[$j], 'PLF') && $playoff == 'PLF')) {
//                 $folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/') + 1, strpos($matches[$j], $name) - strrpos($matches[$j], '/') - 1);
//                 break 1;
//             }
//         }
//         return $rootFolder.$folderLeagueURL . $fileName;
// }