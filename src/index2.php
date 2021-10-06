<?php 
require_once 'config.php';
include 'lang.php';
include 'common.php';
include 'fileUtils.php';

$CurrentHTML = 'index.php';
$CurrentTitle = 'Home';
$CurrentPage = 'Home';

include 'head.php';

?>

<?php
$playoffs = isPlayoffs($folder, $playoffMode);
?>
		
    	<div class = "row">
			<div class = "col-sm-12 col-md-8 col-lg-12">
    		<div class="container-fluid rounded mx-xs-1 mx-md-3 mx-lg-5">
    			<?php //include 'ScoreCarousel.php'; ?>
    			<?php include FS_ROOT.'component/ScoreCarousel.php'; ?>
    		</div>
    		</div>
		</div>
	

<?php include 'footer.php'; ?>