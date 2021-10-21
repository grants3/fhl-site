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

/**
 * 
 * To get league file by exact filename. Will resolve base location based on config file.
 * 
 * @param $name
 * @param $seasonId
 * @return string
 */
function getLeagueFileAbsolute($name, $seasonId = null) {
    
    $searchFolder = TRANSFER_DIR;
    
    if(isset($seasonId) && $seasonId){
        $searchFolder =  str_lreplace("#",$seasonId,CAREER_STATS_DIR);
    }

    error_log($searchFolder.$name);
    $matches = glob($searchFolder.$name,GLOB_NOSORT);

    //filter duplicates
    return filterMatches($matches);
}

function getLeaguePrefix($baseDir, bool $playoffs = false){
    
    $search = '*GMs.html';
    $filter = 'PLF'; //want to filter out in regular season play
    if($playoffs){
        $search = '*PLFGMs.html';
        $filter = ''; //no filter.
    }
    
    $matches = glob($baseDir.$search,GLOB_NOSORT);
    
    //exclude playoff from reg seaon results.
    $result = filterMatches($matches, $filter);
    
    if($result){
        $result = str_replace('GMs.html','',$result);
    }
    
    return basename($result);
}

/**
 * @param $gameNumber
 * @param $seasonId
 * @param $round
 * @return string
 */
function getGameFile($gameNumber, $seasonId = null, $round = null) {
    
    $isPlayoffs = isset($round) && $round; //infer
    //assume playoffs if round set.
    if(isset($round) && $round){
        $gameSearch = '-R'.$round.'-'.$gameNumber.'.html';
    }else{
        $gameSearch = $gameNumber.'.html';
    }
    
    $searchFolder = TRANSFER_DIR;
    
    if(isset($seasonId) && $seasonId){
        $searchFolder =  str_lreplace("#",$seasonId,CAREER_STATS_DIR);
    }
    
    //resolve league prefix.
    $leaguePrefix = getLeaguePrefix($searchFolder, $isPlayoffs);
    
    return getLeagueFileAbsolute($leaguePrefix.$gameSearch, $seasonId);
}

/**
 * Get the current season league file depending on the current league mode
 *
 * @param string $baseName --base filename to search for
 * @param string $exclude --file prefix to exclude. (optional). (standings/farm)
 * @return string
 */
function getCurrentLeagueFile(string $baseName, string $exclude=null) {
    return getLeagueFile($baseName, null, $exclude);
}

function getCurrentPlayoffLeagueFile(string $baseName, string $exclude=null) {
    return _getLeagueFile($baseName, 'PLF', null, $exclude);
}

function getLeagueFile(string $baseName, $seasonId = null, string $exclude=null) {
    $seasonType = '';
    
    $converted_res = isPlayoffs2() ? 'true' : 'false';
    //if(isPlayoffs(TRANSFER_DIR, LEAGUE_MODE)){
    error_log('LEAGUE MODE ====='.LEAGUE_MODE);
    error_log('ISPLAYOFFS ====='.$converted_res);
    error_log('ISPLAYOFFS2 ====='.$GLOBALS["GLOB_LEAGUE_MODE2"]);
    
    if(isPlayoffs2()){
        $seasonType = 'PLF';
    }
    
    return _getLeagueFile($baseName, $seasonType, $seasonId, $exclude);
}

function _getLeagueFile(string $baseName, $seasonType = null, $seasonId = null, string $exclude=null) {
 
    $isPlayoffs = false;
    if(isset($seasonType)){
        if('PLF' == $seasonType){
            $isPlayoffs=true;
        }
    }
    
    $searchFolder = TRANSFER_DIR;
    
    if(isset($seasonId) && $seasonId){
        $searchFolder =  str_lreplace("#",$seasonId,CAREER_STATS_DIR);
    }
    
    //resolve league prefix.
    $leaguePrefix = getLeaguePrefix($searchFolder,$isPlayoffs);
    
    error_log($leaguePrefix);
    error_log($leaguePrefix.$baseName.'.html');
    
    //return getLeagueFileAbsolute($leaguePrefix.$filePrefix.$baseName.'.html', $seasonId);
    return getLeagueFileAbsolute($leaguePrefix.$baseName.'.html', $seasonId);
}

/**
 * @param string $baseName
 * @param string $seasonType
 * @param int $seasonId
 * @param string $exclude
 * @return string|mixed
 */
function _getLeagueFile2(string $baseName, string $seasonType, int $seasonId = null, string $exclude=null) {
    
    if(!isset($exclude)) $exclude = '';
    
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
        $searchFolder =  str_lreplace("#",$seasonId,CAREER_STATS_DIR);
        error_log($searchFolder);
    }
    
    if($seasonType){
        if('PLF' == $seasonType){
            $filePrefix = 'PLF';
        }else if('PRE' == $seasonType){
            $searchFolder = $searchFolder.'pre/';
        }
    }else{
        $exclude = 'PLF'.$exclude;
    }

    //search for all matches. result duplicates below
    $matches = glob($searchFolder.'*'.$filePrefix.$baseName.'.html');
    
    //filter duplicates
    return filterMatches($matches, $exclude);
}



function filterMatches($matches, $exclude = null){
    $result = '';
    
    if($matches){
        if(count($matches) > 1){
            
            //sort by last modified.
           // error_log(print_r($matches,TRUE));
            usort( $matches, function( $a, $b ) { return filemtime($a) - filemtime($b); } );
            
            //attemp to use exclusion to filter.
            if(isset($exclude) && $exclude){
                $matches = array_filter($matches, function($v) use($exclude) {
                    return false === strpos($v, $exclude);
                });
                    
                    //arrayfilter will break indexes
                    $result = array_values($matches)[0];
            }
            
            if(!$result){
                //just take latest if unable to resolve duplicate
                $result = $matches[0];
            }
        }else{
            $result = $matches[0];
        }
    }
    //error_log(print_r($result,TRUE));
    return $result;
}

function getPlayoffRound() : int{
    
    $round = 0;
    
    $matches = glob(TRANSFER_DIR.'*PLF-Round1-Schedule.html');
    $folderLeagueURL2 = '';
    $matchesDate = array_map('filemtime', $matches);
    arsort($matchesDate);
    foreach ($matchesDate as $j => $val) {
        if(substr_count($matches[$j], 'PLF')) {
            $folderLeagueURL2 = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'PLF-Round1-Schedule.html')-strrpos($matches[$j], '/')-1);
            break 1;
        }
    }
    if (file_exists(TRANSFER_DIR.$folderLeagueURL2.'PLF-Round1-Schedule.html')) {
        $round = 1;
    }
    if (file_exists(TRANSFER_DIR.$folderLeagueURL2.'PLF-Round2-Schedule.html')) {
        $round = 2;
    }
    if (file_exists(TRANSFER_DIR.$folderLeagueURL2.'PLF-Round3-Schedule.html')) {
        $round = 3;
    }
    if (file_exists(TRANSFER_DIR.$folderLeagueURL2.'PLF-Round4-Schedule.html')) {
        $round = 4;
    }
    
    return $round;
}
