<?php 

include_once 'classes/TeamInfo.php';
$teamInfoAway = new TeamInfo($folder, $playoff, $currentTeam);

?>

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