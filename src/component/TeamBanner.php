<?php require_once __DIR__.'/../config.php';
include_once FS_ROOT.'fileUtils.php';
include_once FS_ROOT.'classes/TeamHolder.php';

?>
<style>
.team-header-content {
	/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#cedce7+9,596a72+100 */
    background: rgb(206,220,231); /* Old browsers */
    background: -moz-linear-gradient(top, rgba(206,220,231,1) 9%, var(--color-primary-2) 100%); /* FF3.6-15 */
    background: -webkit-linear-gradient(top, rgba(206,220,231,1) 9%,var(--color-primary-2) 100%); /* Chrome10-25,Safari5.1-6 */
    background: linear-gradient(to bottom, rgba(206,220,231,1) 9%,var(--color-primary-2) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
	/* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cedce7',
		endColorstr='#596a72', GradientType=0); /* IE6-9 */
/* 	border-radius: 5px; */
/* 	margin-bottom: 10px; */
}
</style>

<?php 

if(!isset($teamList)){
    include_once FS_ROOT.'common.php';

    $playoff = '';
 
    if(isPlayoffs(TRANSFER_DIR, LEAGUE_MODE)){
        $playoff = 'PLF';
    }
    
    // // CREATE TEAM LIST
    $gmFile = getLeagueFile($folder, $playoff, 'GMs.html', 'GMs');
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
        				<img src="<?php echo getTeamLogoUrl($teamList[$i])?>" width=55 alt="<?php echo $teamList[$i] ?>">
        			</a>
        
        		<?php } ?>
        	</div>
    	</div>
    </div>
</div>

