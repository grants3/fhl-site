<?php

if(file_exists(__DIR__.'/config.php')) {
    
    //BASE SETTINGS
    require_once __DIR__.'/config.php';
    require_once __DIR__.'/fileUtils.php';
    
    echo '<br><h1 style="margin:0">Table Sim Debug</h3>';
    
    echo '<br><h3 style="margin-bottom:0; margin-block-start:0.3em">Info</h3>';
    echo 'PHP Version: '.phpversion();
    echo '<br>TableSim Version: '.APP_VERSION.'<br>';
    $str = file_get_contents('config.php');
    $bom = pack("CCC", 0xef, 0xbb, 0xbf);
    if (0 === strncmp($str, $bom, 3)) {
        echo "Warning: config.php with BOM<br>Use notepad++ to edit this file!";
    }
    else {
        echo "Configuration files: OK";
    }
    

    
    
    //LEAGUE SETTINGS
    echo '<br><h3 style="margin-bottom:0">League Settings</h3>';
    if(LEAGUE_MODE == 'REG'){
        echo 'League Mode: - REGULAR SEASON MODE';
    }else if(LEAGUE_MODE == 'PLF'){
        echo 'League Mode: - PLAYOFF MODE';
    }else{
        echo 'League Mode: INVALID LEAGUE MODE:'.LEAGUE_MODE;
    }
    
    if(LEAGUE_LANG == 'EN') echo '<br>Lang: English';
    if(LEAGUE_LANG == 'FR') echo '<br>Langue: Français';
    if(LEAGUE_LANG != 'EN' && LEAGUE_LANG != 'FR') echo '<br><span style="color:red; font-weight:bold;">Lang Error!</span>';
    
    echo '<br>Theme selected: '.SITE_THEME;
    
    
    //FILE SETTINGS
    echo '<br><h3 style="margin-bottom:0">File Settings</h3>';
    
    echo 'HTML folder: '.TRANSFER_DIR;
    if(GAMES_DIR) echo '<br>Games HTML folder: '.GAMES_DIR;
    else echo '<br>Games folder same as HTML Folder';
    
    if(CAREER_STATS_DIR) echo '<br>Career Stats: '.CAREER_STATS_DIR;
    if(!CAREER_STATS_DIR) echo '<br>Career Stats: Off';
    
    if(LOGO_DIR) echo '<br>Team Logos folder: '.LOGO_DIR;
    if(LOGO_FARM_DIR) echo '<br>Team Logos Farm folder: '.LOGO_DIR.LOGO_FARM_DIR;
    
//     $matches = glob(TRANSFER_DIR.'*GMs.html');
//     $folderLeagueURL = '';
//     $matchesDate = array_map('filemtime', $matches);
//     arsort($matchesDate);
//     foreach ($matchesDate as $j => $val) {
//         $folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'GMs')-strrpos($matches[$j], '/')-1);
//         break 1;
//     }
    $leaguePrefix = getLeaguePrefix(TRANSFER_DIR);
    if($leaguePrefix != '') echo '<br>File Name Extra: '.$leaguePrefix;
    else echo '<br><span style="color:red; font-weight:bold;">No Extra Name on your HTML files!</span>';
    
    echo '<br><h3 style="margin-bottom:0">Cap Settings</h3>';
    
    if(CAP_MODE == 1) echo 'Salary Cop: Pro+Farm Payroll';
    if(CAP_MODE == 0) echo 'Salary Cop: Pro Payroll Only';
    
    if(SALARY_CAP != 0) echo '<br>Salary Cap: '.SALARY_CAP;
    if(SALARY_CAP == 0) echo '<br>No Salary Cop';
    
    if(SALARY_CAP_WARN != 0) echo '<br>Salary Cap Close: '.SALARY_CAP_WARN;
    if(SALARY_CAP_WARN == 0) echo '<br>No Salary Cap Close';
    
    if(SALARY_CAP_FLOOR != 0) echo '<br>Salary Cap Floor: '.SALARY_CAP_FLOOR;
    if(SALARY_CAP_FLOOR == 0) echo '<br>No Salary Cap Floor';
    

    echo '<br><h3 style="margin-bottom:0">Other Settings</h3>';
    
   
    if(isset($_SERVER['DOCUMENT_ROOT'])) {
        echo '<br>PHP DOCUMENT_ROOT: '.$_SERVER["DOCUMENT_ROOT"];
        
        function rsearch($sfolder, $pattern) {
            $iti = new RecursiveDirectoryIterator($sfolder);
            foreach(new RecursiveIteratorIterator($iti) as $file){
                if(strpos($file , $pattern) !== false){
                    return $file;
                }
            }
            return false;
        }
        if(!defined('__DIR__')) { define('__DIR__', dirname(__FILE__)); }
        $scanFolder = $scanFolderWork = substr(__DIR__.DIRECTORY_SEPARATOR, strlen($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR));
        $scanFolderFull = __DIR__.DIRECTORY_SEPARATOR;
        for($x=0;$x<substr_count($scanFolder,DIRECTORY_SEPARATOR);$x++) {
            $filepath = rsearch($scanFolderFull, "admin".DIRECTORY_SEPARATOR."fhlteam.php");
            if(isset($filepath) && $filepath != '') break 1;
            $scanFolderFull = dirname($scanFolderFull).DIRECTORY_SEPARATOR;
        }
        
        $filepath = rsearch($_SERVER['DOCUMENT_ROOT'], 'admin'.DIRECTORY_SEPARATOR.'fhlteam.php');
        if(isset($filepath) && $filepath != '') {
            $filepath = substr($filepath, strlen($_SERVER['DOCUMENT_ROOT']), strpos($filepath, 'admin'.DIRECTORY_SEPARATOR.'fhlteam.php')-strlen($_SERVER['DOCUMENT_ROOT']));
            echo '<br>GM Editor: Found!';
        }
        else echo '<br>GM Editor: Not Found!';
    }
    else echo '<br>GM Editor: Unable to determine, $_SERVER[\'DOCUMENT_ROOT\'] not found!';
    
//     if($leagueChatBox != 0) echo '<br>ChatBox Enabled';
//     if($leagueChatBox == 0) echo '<br>ChatBox Disabled';
    
//     echo '<br>Chat TimeZone: '.$leagueTimeZone;
    
//     if($leagueBackButton != 0) echo '<br>Back Button Enabled';
//     if($leagueBackButton == 0) echo '<br>Back Button Disabled';
    
//     if($leagueHomeButton != 0) echo '<br>Home Button Enabled';
//     if($leagueHomeButton == 0) echo '<br>Home Button Disabled';
    
    if(FUTURES_LINK_MODE == 1) echo '<br>Futures Links: hockeyDB selected';
    if(FUTURES_LINK_MODE == 2) echo '<br>Futures Links: EliteProspect selected';
    
    echo '<br><h3 style="margin-bottom:0">File Check</h3>';
    
    if($leaguePrefix){
        $gmFile = getCurrentLeagueFile('GMs');
        $coachFile = getCurrentLeagueFile('Coaches');
        $farmLeadersFile = getCurrentLeagueFile('FarmLeaders');
        $farmStandingsFile = getCurrentLeagueFile('FarmStandings');
        $financeFile = getCurrentLeagueFile('Finance');
        $faFile = getCurrentLeagueFile('FreeAgents');
        $futuresFile = getCurrentLeagueFile('Futures');
        $individualFile = getCurrentLeagueFile('Individual');
        $injuryFile = getCurrentLeagueFile('Injury');
        $leadersFile = getCurrentLeagueFile('Leaders','Farm');
        $linesFile = getCurrentLeagueFile('Lines');
        $playerVitalsFile = getCurrentLeagueFile('PlayerVitals');
        $rostersFile = getCurrentLeagueFile('Rosters');
        $standingsFile = getCurrentLeagueFile('Standings','Farm');
        $teamScoringFile = getCurrentLeagueFile('TeamScoring');
        $teamStatsFile = getCurrentLeagueFile('TeamStats');
        $transactFile = getCurrentLeagueFile('Transact');
        $unassignedFile = getCurrentLeagueFile('Unassigned');
        $waiversFile = getCurrentLeagueFile('Waivers');
        
        
        echo 'GMs.html: '.($gmFile ? basename($gmFile) : 'Not found!');
        echo '<br>Coaches.html: '.($coachFile ? basename($coachFile) : 'Not found!');
        echo '<br>FarmLeaders.html: '.($farmLeadersFile ? basename($farmLeadersFile) : 'Not found!');
        echo '<br>FarmStandings.html: '.($farmStandingsFile ? basename($farmStandingsFile) : 'Not found!');
        echo '<br>Finance.html: '.($financeFile ? basename($financeFile) : 'Not found!');
        echo '<br>FreeAgents.html: '.($faFile ? basename($faFile) : 'Not found!');
        echo '<br>Futures.html: '.($futuresFile ? basename($futuresFile) : 'Not found!');
        echo '<br>Individual.html: '.($individualFile ? basename($individualFile) : 'Not found!');
        echo '<br>Injury.html: '.($injuryFile ? basename($injuryFile) : 'Not found!');
        echo '<br>Leaders.html: '.($leadersFile ? basename($leadersFile) : 'Not found!');
        echo '<br>Lines.html: '.($linesFile ? basename($linesFile) : 'Not found!');
        echo '<br>PlayerVitals.html: '.($playerVitalsFile ? basename($playerVitalsFile) : 'Not found!');
        echo '<br>Rosters.html: '.($rostersFile ? basename($rostersFile) : 'Not found!');
        echo '<br>Standings.html: '.($standingsFile ? basename($standingsFile) : 'Not found!');
        echo '<br>TeamScoring.html: '.($teamScoringFile ? basename($teamScoringFile) : 'Not found!');
        echo '<br>TeamStats.html: '.($teamStatsFile ? basename($teamStatsFile) : 'Not found!');
        echo '<br>Transact.html: '.($transactFile ? basename($transactFile) : 'Not found!');
        echo '<br>Unassigned.html: '.($unassignedFile ? basename($unassignedFile) : 'Not found!');
        echo '<br>Waivers.html: '.($waiversFile ? basename($waiversFile) : 'Not found!');
        
        if(!PLAYOFF_MODE){
            $scheduleFile = getCurrentLeagueFile('Schedule');
            echo '<br>Schedule.html: '.($scheduleFile ? basename($scheduleFile) : 'Not found!');
        }else{
            $scheduleFile = getCurrentPlayoffLeagueFile('-Round1-Schedule');
            echo '<br>Round1-Schedule.html: '.($scheduleFile ? basename($scheduleFile) : 'Not found!');
            $scheduleFile = getCurrentPlayoffLeagueFile('-Round2-Schedule');
            echo '<br>Round2-Schedule.html: '.($scheduleFile ? basename($scheduleFile) : 'Not found!');
            $scheduleFile = getCurrentPlayoffLeagueFile('-Round3-Schedule');
            echo '<br>Round3-Schedule.html: '.($scheduleFile ? basename($scheduleFile) : 'Not found!');
            $scheduleFile = getCurrentPlayoffLeagueFile('-Round3-Schedule');
            echo '<br>Round4-Schedule.html: '.($scheduleFile ? basename($scheduleFile) : 'Not found!');
        }
        
    }else{
        echo '<br>Unable to determine league prefix, no files found';
    }
}
else {
    echo '<span style="color:red; font-weight:bold;">No config.php found!</span>';
    echo '<br>GM File: ';
}

