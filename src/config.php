<?php
//base configuration. do not touch
require_once 'baseConfig.php';

//Session attributes
$sessionName = 'FHL';

//Site name - will be used as title (text on top of browser/tab)
$leagueName = 'FHL League';

//Logo used on large nav (if applicable). should be 40x150 at the maximum. Will use FHL default if not set.
$leagueLogo = '';

//CDN support for faster css/js assets 
//(basically get required javascript and css libraries from the internet on much faster servers closer to your location than your own webserver)
//uses less bandwith and should be faster. true = use CDN , false = use from your own webserver.
$cdnSupport = true;

// Language | Français: 'FR' | English: 'EN'
$leagueLang = "EN";

//enter where you site home address (your main index.html/php) is located in comparison to the TablePage addon. 
//Will be used on nav home button/league logo. Same folder "";
//ex: if http://yourLeague.com/ is your home page and -> Add-on folder: http://yourLeague.com/TablePage/
//then set value to "../"  
$home = "";

// Enter where your FHLSim Generated HTML files are located in your website in comparison to this config file. Same folder = '';, Previous directory = '../';
// Ex: '../html/'; -> Your HTML files folder: http://yourLeague.com/html/ -> Add-on folder: http://yourLeague.com/TablePage/
$folder = "transfer/";

// If your games files aren't in the same directory as the other FHLSim Generated HTML league files, enter here the subfolder of $folder.
// If Everything is in the same folder enter ''; 
$folderGames = "";

# CAREER STATS
// Needed Files in each season folders : GMs, PlayerVitals, TeamScoring, PLFTeamScoring, Standings, Schedule. Optional: Transactions
// Enter where your backup HTML files are located in your website. Unabled : 0;
// This folder MUST have the same name and at the end, the number of the season. Ex: Season 1, Season 2, Season 3. Put # to replace the number!
// Full example: ../backup/Season #/
// The current season/playoff folder shouldn't be here,  it will duplicates stats.
//$folderCarrerStats = "backup/season#/";
$folderCareerStats = "backup/season#/";

# BOXSCORE LOGO
// Supported Formats: JPEG, GIF, PNG, BMP, ICO (PNG Recommanded)
// Logo names: the same as the name in your FHLsim but ALL the characters in lowercase Ex: RED WINGS = red wings
// Enter where your team logos are located in your website. Same folder = '';, Previous directory = '../';
$folderTeamLogos = "logos/"; 

#boxscore logo for farm teams. Follows same naming convention as above. enter here the subfolder of $folderTeamLogos.
// If not using farm logos and just want to use NHL logos enter ''; 
$folderTeamLogosFarm = "farm/";

#GMO Location. 
//Location of Online GM editor relative to the location of the config file. Leave blank if not used. If set, this will cause link to appear on nav
$folderGmo = "gmo/";

# Rosters PAGE (neither of these work yet)
// Choose between hockeyDB : 1 or EliteProspect : 2
$leagueRostersLink = 1;

# FUTURES PAGE
// Choose between hockeyDB : 1 or EliteProspect : 2
$leagueFuturesLink = 1;

# Player images (stats and player profiles)
// Choose between TSN : 1 or Sportsnet : 2
$leaguePlayerImages = 1;

//choose draft pick years (how many years ahead to display)
$leagueFuturesDraftYears = 4;

# SALARY COP
// 0 : Calculate Salary Cap with only Pro Payroll
// 1 : Calculate Salary Cap with Pro + Farm Payroll
$leagueSalaryIncFarm = 0;

// Plafond salariale | Salary Cap | Ex: 56000000 for 56M$
$leagueSalaryCap = 53000000;

// Alerte Proche du Plafond Salariale | Warning Near Salary Cap | Ex: 55000000 for 55M$
$leagueSalaryClose = 52000000;

// Floor Salary Cap | Ex: 45000000 for 45M$ | 0 : Inactivated
$leagueSalaryCapFloor = 0;

//cap injury mode 0 = don't count injuries, enable LTIR. | 1 = injuries count toward caphit no LTIR. (TODO should switch these around)
$leagueSalaryCapInjuryMode = 0;

// Overtime Point | 0:Off | 1:On (One Point)
$leagueOvertimePoint = 1;

//Min Active Players | Min required active players on roster. (Not injured or suspended) 0:Off
$minActivePlayers = 20;

# League mode (Auto mode will check if playoff files exist in transfer directory, otherwise mode is selected manualy)
# Regular Season: 0 | Playoffs : 1 | Auto Detect : 2
//$playoffMode = 1;
$leagueMode = 0;

# Whether or not main navbar should be displayed and the type of nav to be displayed.
# Default navbar includes all site links, simple nav only contains home button and team links.
# Auto: 0 Navbar disabled : 1 Full Navbar enabled (default) : 2 Simple nav with team icons : 3 Simple nav with team dropdown. : 4 Use your own custom nav.
$navbarMode = 1;

#text to display in footer(bottom) of each page.
$footerText="FHL TableSim 2.0";

//default color scheme.
//blue,green,red,teal,custom
$siteTheme="blue";

//-----------------------------------------
//DO NOT TOUCH ANYTHING BELOW HERE.
//-----------------------------------------
define("SESSION_NAME",$sessionName);
define("LEAGUE_NAME",$leagueName);
define("LEAGUE_LOGO",$leagueLogo);
define("CDN_SUPPORT", $cdnSupport);
define("LEAGUE_LANG",$leagueLang);
define("HOME",BASE_URL.$home);
define("TRANSFER_DIR",FS_ROOT.$folder);
define("GAMES_DIR",$folderGames);
define("LOGO_DIR",$folderTeamLogos);
define("LOGO_FARM_DIR",$folderTeamLogosFarm);
define("GMO_DIR",$folderGmo);
define("CAREER_STATS_DIR",FS_ROOT.$folderCareerStats);

define("CAP_MODE",$leagueSalaryIncFarm);
define("SALARY_CAP",$leagueSalaryCap);
define("SALARY_CAP_WARN",$leagueSalaryClose);
define("SALARY_CAP_FLOOR",$leagueSalaryCapFloor);
define("CAP_INJ_MODE",$leagueSalaryCapInjuryMode);
define("OVERTIME_POINT_MODE",$leagueOvertimePoint);
define("MIN_ACTIVE_PLAYERS",$minActivePlayers);
define("PLAYER_IMG_SOURCE",$leaguePlayerImages);

define("FUTURES_LINK_MODE",$leagueFuturesLink);
define("FUTURES_DRAFT_YEARS",$leagueFuturesDraftYears);
//define("LEAGUE_MODE",$playoffMode);
define("LEAGUE_MODE",inferLeagueMode($leagueMode));
define("PLAYOFF_MODE",LEAGUE_MODE == 1);
define("NAVBAR_MODE",$navbarMode);
define("FOOTER_TEXT", $footerText);
define("SITE_THEME", $siteTheme);

unset($sessionName);
unset($leagueLogo);
unset($cdnSupport);
//unset($leagueLang);
unset($home);
unset($folder);
unset($folderGames);
unset($folderCareerStats);
unset($folderTeamLogos);
unset($folderGmo);
//unset($leagueRostersLink);
//unset($leagueFuturesLink);
//unset($leagueFuturesDraftYears );
// unset($leagueSalaryIncFarm);
// unset($leagueSalaryCap);
// unset($leagueSalaryClose);
// unset($leagueSalaryCapFloor);
// unset($leagueSalaryCapInjuryMode);
unset($minActivePlayers);
// unset($leagueOvertimePoint);

// unset($playoffMode);
 unset($navbarMode);
 unset($footerText);
 unset($siteTheme);

?>