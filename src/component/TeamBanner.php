<?php require_once __DIR__.'/../config.php';
include_once FS_ROOT.'fileUtils.php';
include_once FS_ROOT.'classes/TeamHolder.php';

if(!isset($teamList)){
    include_once FS_ROOT.'fileUtils.php';
    
    // // CREATE TEAM LIST
    $gmFile = getCurrentLeagueFile('GMs');
    $teamHolder = new TeamHolder($gmFile);
    //needs to retain order.
    $teamList = $teamHolder->get_teams();
}

?>

<div class="container-fluid team-header-content px-0">
    <div class="row no-gutters justify-content-center team-header-content ">
    	<div class="">
    		<div class="col text-center p-0">
                <?php
                sort($teamList); // sort
                for ($i = 0; $i < count($teamList); $i ++) {
                    ?>
        			
        			<a href="<?php echo BASE_URL?>TeamRosters.php?team=<?php echo urlencode($teamList[$i]) ?>">
        				<img class="test-img" src="<?php echo getTeamLogoUrl($teamList[$i])?>" width=55 alt="<?php echo $teamList[$i] ?>" title="<?php echo $teamList[$i] ?>" >
        			</a>
        
        		<?php } ?>
        	</div>
    	</div>
    </div>
</div>

