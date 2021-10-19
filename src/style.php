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

/* site color overrides. blue is default*/

<?php 
if($siteColorTheme == 'green') {

?>

:root {
   --color-primary-1: #18A558; 
   --color-primary-2: #116530; 
   --color-primary-3: #A3EBB1; 
   --color-alternate-1:#D7FFF1; 
   --color-alternate-2:#8CD790; 

   --table-link-color:#116530; 
   --table-sort-asc:#0a4323; 
   --table-sort-desc:#77AF9C; 
}

<?php }
?>
<?php 
if($siteColorTheme == 'red') {

?>

:root {
   --color-primary-1: #7d1e26; 
   --color-primary-2: #6C1E1E; 
   --color-primary-3: #A75B5B; 
   --color-alternate-1:#ebbec2; 
   --color-alternate-2:#FFF5F6; 

   --table-link-color:#6C1E1E; 
   --table-sort-asc:#763838; 
   --table-sort-desc:#5A1E1E; 
}

<?php } ?>




</style>
