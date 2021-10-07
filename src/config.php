<?php
//base configuration. do not touch
require_once 'baseConfig.php';

//Session attributes
define("SESSION_NAME",'FHL');

//Fallback support for css/js assets (fetch js/css libraries from CDN as its faster by default. false falls back to getting resources from your own webserver)
define("CDN_SUPPORT", true);

// Language | Français: 'FR' | English: 'EN'
define("LEAGUE_LANG","EN");
$leagueLang = LEAGUE_LANG;

// Enter where your HTML files are located in your website. Same folder = '';, Previous directory = '../';
// Ex: '../html/'; -> Your HTML files folder: http://yourLeague.com/html/ -> Add-on folder: http://yourLeague.com/TablePage/
define("TRANSFER_DIR",FS_ROOT."transfer/");
$folder = TRANSFER_DIR;

// If your games files aren't in the same directory as the other files, enter here the subfolder of $folder.
// If Everything is in the same folder enter '';
define("GAMES_DIR","");
$folderGames = GAMES_DIR;

# SALARY COP
// 0 : Calculate Salary Cap with only Pro Payroll
// 1 : Calculate Salary Cap with Pro + Farm Payroll
define("CAP_MODE",0);
$leagueSalaryIncFarm = CAP_MODE;

// Plafond salariale | Salary Cap | Ex: 56000000 for 56M$
define("SALARY_CAP",53000000);
$leagueSalaryCap = SALARY_CAP;

// Alerte Proche du Plafond Salariale | Warning Near Salary Cap | Ex: 55000000 for 55M$
define("SALARY_CAP_WARN",52000000);
$leagueSalaryClose = SALARY_CAP_WARN;

// Floor Salary Cap | Ex: 45000000 for 45M$ | 0 : Inactivated
define("SALARY_CAP_FLOOR",0);
$leagueSalaryCapFloor = SALARY_CAP_FLOOR;

//cap injury mode 0 = don't count injuries 1, enable LTIR. 0 = count injuries no LTIR.
define("CAP_INJ_MODE",0);
$leagueSalaryCapInjuryMode = CAP_INJ_MODE;

// Overtime Point | 0:Off | 1:On (One Point)
define("OVERTIME_POINT_MODE",1);
$leagueOvertimePoint = OVERTIME_POINT_MODE;

//Min Active Players | Min required active players on roster. (Not injured or suspended) 0:Off
define("MIN_ACTIVE_PLAYERS",20);

# CAREER STATS
// Needed Files in each season folders : GMs, PlayerVitals, TeamScoring, PLFTeamScoring, Standings, Schedule

// Enter where your backup HTML files are located in your website. Unabled : 0;
// This folder MUST have the same name and at the end, the number of the season. Ex: Season 1, Season 2, Season 3. Put # to replace the number!
// Full example: ../backup/Season #/
// The current season/playoff folder shouldn't be here,  it will duplicates stats.
define("CAREER_STATS_DIR",FS_ROOT."backup/season#/");
$folderCarrerStats = CAREER_STATS_DIR;


# BOXSCORE LOGO
// Supported Formats: JPEG, GIF, PNG, BMP, ICO (PNG Recommanded)
// Logo names: the same as the name in your FHLsim but ALL the characters in lowercase Ex: RED WINGS = red wings
// Enter where your team logos are located in your website. Same folder = '';, Previous directory = '../';
define("LOGO_DIR",'logos/');
$folderTeamLogos = LOGO_DIR;

#GMO Location. 
//Location of Online GM editor relative to the location of the config file. Leave blank if not used.
define("GMO_DIR",'gmo/');
$folderGmo = GMO_DIR;


// For more information about timezone available : http://php.net/manual/en/timezones.php, copy paste your timezone in the box bellow!
define("LEAGUE_TZ",'America/Toronto');
$leagueTimeZone = LEAGUE_TZ;


# FUTURES PAGE
// Choose between hockeyDB : 1 or EliteProspect : 2
define("FUTURES_LINK_MODE",1);
$leagueFuturesLink = FUTURES_LINK_MODE;


//choose draft pick years (how many years ahead to display)
define("FUTURES_DRAFT_YEARS",4);
$leagueFuturesDraftYears = FUTURES_DRAFT_YEARS;

# Playoff mode (Auto mode will check if playoff files exist in transfer directory, otherwise mode is selected manualy)
# Auto: 0 Regular Season : 1 or Playoffs : 2
define("LEAGUE_MODE",1);
$playoffMode = LEAGUE_MODE;

# Whether or not main navbar should be displayed and the type of nav to be displayed.
# Default navbar includes all site links, simple nav only contains home button and team links.
# Auto: 0 Navbar disabled : 1 Full Navbar enabled (default) : 2 Simple with team icons : 3 Simple nav with team dropdown.
define("NAVBAR_MODE",1);
$navbarMode = NAVBAR_MODE;

#text to display in footer(bottom) of each page.
define("FOOTER_TEXT", "FHL Online 2021");
$footerText=FOOTER_TEXT;

//default color scheme.
//blue,green,red
define("SITE_THEME_COLOR", "blue");
?>