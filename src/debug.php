<?php

if(file_exists(__DIR__.'/config.php')) {
    
    require_once __DIR__.'/config.php';
    
    echo 'Current Version: '.$version.'<br>';
    $str = file_get_contents('config.php');
    $bom = pack("CCC", 0xef, 0xbb, 0xbf);
    if (0 === strncmp($str, $bom, 3)) {
        echo "Warning: config.php with BOM<br>Use notepad++ to edit this file!";
    }
    else {
        echo "Configuration files: OK";
    }
    
    if($leagueLang == 'EN') echo '<br>Lang: English';
    if($leagueLang == 'FR') echo '<br>Langue: Français';
    if($leagueLang != 'EN' && $leagueLang != 'FR') echo '<br><span style="color:red; font-weight:bold;">Lang Error!</span>';
    
    echo '<br>HTML folder: '.$folder;
    if($folderGames != '') echo '<br>Games HTML folder: '.$folderGames;
    else echo '<br>Games HTML folder same as below';
    
    $matches = glob($folder.'*GMs.html');
    $folderLeagueURL = '';
    $matchesDate = array_map('filemtime', $matches);
    arsort($matchesDate);
    foreach ($matchesDate as $j => $val) {
        $folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'GMs')-strrpos($matches[$j], '/')-1);
        break 1;
    }
    if($folderLeagueURL != '') echo '<br>File Name Extra: '.$folderLeagueURL;
    else echo '<br><span style="color:red; font-weight:bold;">No Extra Name on your HTML files!</span>';
    
    if($leagueSalaryIncFarm == 1) echo '<br>Salary Cop: Pro+Farm Payroll';
    if($leagueSalaryIncFarm == 0) echo '<br>Salary Cop: Pro Payroll Only';
    
    if($leagueSalaryCap != 0) echo '<br>Salary Cap: '.$leagueSalaryCap;
    if($leagueSalaryCap == 0) echo '<br>No Salary Cop';
    
    if($leagueSalaryClose != 0) echo '<br>Salary Cap Close: '.$leagueSalaryClose;
    if($leagueSalaryClose == 0) echo '<br>No Salary Cap Close';
    
    if($leagueSalaryCapFloor != 0) echo '<br>Salary Cap Floor: '.$leagueSalaryCapFloor;
    if($leagueSalaryCapFloor == 0) echo '<br>No Salary Cap Floor';
    
    if($folderCarrerStats) echo '<br>Career Stats: '.$folderCarrerStats;
    if($folderCarrerStats == '0') echo '<br>Career Stats: Off';
    
    if($folderTeamLogos) echo '<br>Team Logos folder: '.$folderTeamLogos;
    
    echo '<br>Theme selected: '.$selectedColor;
    
    echo '<br>PHP Version: '.phpversion();
    if(isset($_SERVER['DOCUMENT_ROOT'])) {
        echo '<br>'.$_SERVER["DOCUMENT_ROOT"];
        
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
            echo '<br>GM Editor Found!';
        }
        else echo '<br>GM Editor not Found!';
    }
    else echo '<br>$_SERVER[\'DOCUMENT_ROOT\'] not found!';
    
    if($leagueChatBox != 0) echo '<br>ChatBox Enabled';
    if($leagueChatBox == 0) echo '<br>ChatBox Disabled';
    
    echo '<br>Chat TimeZone: '.$leagueTimeZone;
    
    if($leagueBackButton != 0) echo '<br>Back Button Enabled';
    if($leagueBackButton == 0) echo '<br>Back Button Disabled';
    
    if($leagueHomeButton != 0) echo '<br>Home Button Enabled';
    if($leagueHomeButton == 0) echo '<br>Home Button Disabled';
    
    if($leagueFuturesLink == 1) echo '<br>hockeyDB links selected';
    if($leagueFuturesLink == 2) echo '<br>EliteProspect links selected';
}
else {
    echo '<span style="color:red; font-weight:bold;">No config.php found!</span>';
}

