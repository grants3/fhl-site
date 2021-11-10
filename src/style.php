<?php 
require_once 'config.php';

//override colour
//dont need to check if it is valid. will fallback to default colour scheme.
if(isset($_SESSION["theme"])){
    $siteColorTheme = $_SESSION["theme"];
}else{
    $siteColorTheme = SITE_THEME;
}

?>

<style type="text/css">

<?php if(LEAGUE_LOGO){ ?>

:root {
	--nav-logo-url:url(<?php echo LEAGUE_LOGO;?>) left center no-repeat;
}

<?php } ?>

/* site color overrides. blue is default*/

<?php 
if($siteColorTheme === 'green') {

?>

:root {
   --color-primary-1: #18A558; 
   --color-primary-2: #0a4520; 
   --color-primary-3: #A3EBB1; 
   --color-alternate-1:#edfff5; 
   --color-alternate-2:#caedce; 
   --color-alternate-3:#E9FFF3;

   --table-sort-asc:#0a4323; 
   --table-sort-desc:#77AF9C; 
}

<?php }
else if($siteColorTheme == 'red') {

?>

:root {
   --color-primary-1: #ad2430; 
   --color-primary-2: #6C1E1E; 
   --color-primary-3: #A75B5B; 
   --color-alternate-1:#FFF5F6; 
   --color-alternate-2:#EBDCDD;
   --color-alternate-3:#F7EFF0;

   --table-sort-asc:#763838; 
   --table-sort-desc:#5A1E1E; 
}

<?php 
} else if($siteColorTheme == 'dark') {
    
    ?>

:root {
   --color-primary-1: #26203B; 
   --color-primary-2: #221F2C; 
   --color-primary-3: #19181B; 
   --color-alternate-1:#ebebed; 
   --color-alternate-2:#cdcadb;
   --color-alternate-3:#EBE5FC;

   --table-sort-asc:#443E59; 
   --table-sort-desc:#332F3C; 
}

<?php 
}else if($siteColorTheme == 'teal') {
    
    ?>

:root {
   --color-primary-1: #006d77; 
   --color-primary-2: #1a535c; 
   --color-primary-3: #83c5be; 
   --color-alternate-1:#ffddd2; 
   --color-alternate-2:#edf6f9;
   --color-alternate-3:#fff0eb;

   --table-sort-asc:#798777; 
   --table-sort-desc:#BDD2B6; 
}

<?php 
}else if($siteColorTheme == 'custom') {
    
    include FS_ROOT.'styleCustom.php'; 

} ?>


</style>
