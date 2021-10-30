<?php require_once __DIR__.'/../config.php';
include_once FS_ROOT.'fileUtils.php';
include_once FS_ROOT.'classes/TeamHolder.php';

include FS_ROOT.'assets.php';

if(!isset($teamList)){
    include_once FS_ROOT.'fileUtils.php';
    
    // // CREATE TEAM LIST
    $gmFile = getCurrentLeagueFile('GMs');
    $teamHolder = new TeamHolder($gmFile);
    //needs to retain order.
    $teamList = $teamHolder->get_teams();
}

?>

<style>
.team-banner-logo-container {
    max-height: 49px;
    min-height:30px;
    width: 49px;

    display: inline-block;
    position:relative;
    margin: 0 auto;
    padding: 0px;
    margin-top:1px;
    margin-bottom:1px;
    margin-left:1px;
    margin-right:1px;
    border: 0px;
    float:center;
}

/*CENTER NOT STRETCH*/
.team-banner-logo{
  display: flex;
  justify-content: center;
  align-items: center;
  max-height: 49px;
  min-height:30px;
}

</style>

<div class="container-fluid team-header-content">
    <div class="row py-1">
		<div class="col px-0 center-block text-center">
            <?php
            sort($teamList); // sort
            for ($i = 0; $i < count($teamList); $i ++) {
                ?>
    			<div class="team-banner-logo-container">
    				<div class="team-banner-logo">
            			<a href="<?php echo BASE_URL?>TeamRosters.php?team=<?php echo urlencode($teamList[$i]) ?>">
            				<img src="<?php echo getTeamLogoUrl($teamList[$i])?>" alt="<?php echo $teamList[$i] ?>" title="<?php echo $teamList[$i] ?>" >
            			</a>
        			</div>
    			</div>
    
    		<?php } ?>
    	</div>
    </div>
</div>

