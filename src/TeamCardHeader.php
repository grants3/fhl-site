<?php 

include_once 'classes/TeamInfo.php';
$teamInfoAway = new TeamInfo($folder, $playoff, $currentTeam);

?>

<style>


.teamheader {
/* 	background: linear-gradient(rgb(0, 39, 79) 0%, rgb(0, 39, 79) 60%, */
/* 		rgb(27, 98, 162) 100%); */
    background: var(--header-gradient);
/* 	height: 68px; */

    overflow: hidden;
    width: 100%;
    float: left;

	moz-border-radius-bottomright: 5px;
	-webkit-border-bottom-right-radius: 5px;
	-border-bottom-right-radius: 5px;
	-moz-border-radius-bottomleft: 5px;
	-webkit-border-bottom-left-radius: 5px;
	border-bottom-left-radius: 5px;
}

.teamheader .logo-gradient {
	background: var(--header-gradient);
}

.teamheader .gloss {
	height: 34px;
	background: linear-gradient(to bottom, rgba(255, 255, 255, 0.6) 0%,
		rgba(255, 255, 255, 0.5) 35%, rgba(255, 255, 255, 0.1) 100%);
		
}

.teamheader .team-logo {
	float: left;
	vertical-align: middle;
	text-align: center;
	width: 68px;
	height: 68px;
	-moz-border-radius-bottomleft: 5px;
	-webkit-border-bottom-left-radius: 5px;
	border-bottom-left-radius: 5px;
}

.teamheader .team-logo-right {
	float: right;
	-moz-border-radius-bottomright: 5px;
	-webkit-border-bottom-right-radius: 5px;
	border-bottom-right-radius: 5px;
}

.teamheader .header {
    vertical-align: middle;
    line-height: 20px;
    padding: 5px 10px;

    color: #fff;
    text-transform: uppercase;
    margin-top: -32px;
    text-align: center;
   
}

</style>

<div class= "teamheader logo-gradient">
	<?php 
	 $teamCardLogoSrc = glob($folderTeamLogos.strtolower($currentTeam).'.*');
	?>
 	<div class="team-logo gloss logo-gradient">
        <?php 
            if(isset($teamCardLogoSrc[0])) {
                echo'<img src="'.$teamCardLogoSrc[0].'" alt="'.$currentTeam.'">';
            }
        ?>
     </div>
     <div class="team-logo gloss logo-gradient team-logo-right">
        <?php 
            if(isset($teamCardLogoSrc[0])) {
                echo'<img src="'.$teamCardLogoSrc[0].'" alt="'.$currentTeam.'">';
            }
        ?>
     </div>

     <div class="header-container">

		<div class="gloss"></div>
		<div class="header">
			<h3 class="mb-0" ><?php echo $CurrentTitle ?></h3>
			<?php echo $currentTeam.' '.$teamInfoAway->getWins().'-'.$teamInfoAway->getLosses().'-'.$teamInfoAway->getTies() ?>
			<?php echo '('.$teamInfoAway->getPlaceString().' '.$teamInfoAway->getConferenceSafeString().')' ?>
			
		</div>
	</div>
</div>