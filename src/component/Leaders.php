<?php require_once __DIR__.'/../config.php';
include_once FS_ROOT.'fileUtils.php';
include_once FS_ROOT.'classes/TeamHolder.php';
include_once FS_ROOT.'classes/ScoringHolder.php';
include_once FS_ROOT.'classes/ScoringPlayerObj.php';
include_once FS_ROOT.'classes/ScoringGoalieObj.php';
include_once FS_ROOT.'classes/ScoringObj.php';
include_once FS_ROOT.'classes/TeamAbbrHolder.php';
include_once FS_ROOT.'classes/ScoringAccumulator.php';

include FS_ROOT.'head.php';

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

$scoringFile = getLeagueFile($folder, $playoff, 'TeamScoring.html', 'TeamScoring');
$scoringHolder = new ScoringHolder($scoringFile);
$scoringAccumulator = new ScoringAccumulator($scoringHolder);

$goalsArray = $scoringAccumulator->getTopGoals(10);
$assistsArray = $scoringAccumulator->getTopAssists(10);
$pointsArray = $scoringAccumulator->getTopPoints(10);

function getProfilePhoto($csName){
    
    $csNametmp = strtolower($csName);
    $csNametmp = str_replace(' ', '-', $csNametmp);
    $csNametmpFirst = substr($csNametmp, 0, 1);
    
    $imgUrl = 'https://assets1.sportsnet.ca/wp-content/uploads/players/nhl/'.$csNametmpFirst.'/'.$csNametmp.'.png';

    if(URL_exists($imgUrl)){
        //$imgUrl = getBaseUrl().'assets/img/unknown-player.png';
    }
   
    return $imgUrl;
}
?>

<style>


.gKmhpZ {
    grid-area: leaders / leaders / leaders / leaders;
    flex: 3 1 0%;
}

.ctbpu {
    background: rgb(255, 255, 255);
    box-shadow: rgb(0 0 0 / 5%) 0px 5px 5px 0px;
    margin-bottom: 20px;
    padding: 30px 10px;
    position: relative;
}

/* main */
.fdyHxu > * {
    flex: 1 1 0%;
}

* {
    box-sizing: border-box;
}


/* left side main */
.dpFoLl {
    display: flex;
    flex-direction: column;
    -webkit-box-align: center;
    align-items: center;
    padding-top: 25px;
}


/* image */

.hmnSFV {
    display: block;
    position: relative;
}

.kxFCqJ {
    border: 1px solid rgb(210, 210, 210);
    border-radius: 50%;
    height: 100px;
    width: 100px;
}

a {
    color: rgb(51, 51, 51);
    text-decoration: none;
}
/* team icon */
.team-display-container {
    display: flex;
    flex: 1;
    
    position: absolute;
    bottom: 0px;
    right: -20px;
}

/* player details */
.bvjVjv {
    display: flex;
    -webkit-box-align: center;
    align-items: center;
    flex-direction: column;
}
.hHORBn {
    display: inline-block;
    vertical-align: top;
    padding-right: 5px;
    line-height: 30px;
    font-size: 20px;
}

.jPZtbn {
    border-left: 1px solid rgb(102, 102, 102);
    display: inline-block;
    font-size: 16px;
    line-height: 16px;
    padding-left: 5px;
    text-align: left;
}

.cWNqKo {
    display: block;
    font-size: 12px;
    line-height: 22px;
}

/*amount details*/
.glDXkE {
    display: flex;
    flex-direction: column;
    font-weight: bold;
    margin-top: 15px;
    text-align: center;
}

/*ride side*/
.cOAcdw {
    text-align: right;
}

.ANxrZ {
    list-style: none;
    margin: 0px;
    padding: 25px 5px 0px;
    width: 100%;
}


ul {
    display: block;
    list-style-type: disc;
    margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    padding-inline-start: 40px;
}

.eTUABY.active {
    font-weight: bold;
}

.eTUABY {
    display: flex;
    -webkit-box-pack: justify;
    justify-content: space-between;
    margin-bottom: 10px;
    font-size: 12px;
}

li {
    display: list-item;
    text-align: -webkit-match-parent;
}

</style>
<div class="component">
<section class="styles__Module-owf6ne-0 ctbpu">
	<header>
		<h1 class="styles__Title-owf6ne-1 hRjSuW">Skaters</h1>
		<div class="ModuleContainer__ModuleMenu-zdst3-0 nBSgv">
			<a href="#" class="NavLinkButton-sc-1hg1q10-0 kEEjoJ active">Points</a><a
				href="#" class="NavLinkButton-sc-1hg1q10-0 kEEjoJ">Goals</a><a
				href="#" class="NavLinkButton-sc-1hg1q10-0 kEEjoJ">Assists</a>
		</div>
	</header>
<div class="styles__LeaderContent-owf6ne-3 fdyHxu">
	<?php if($goalsArray){
	    $playerCareersLink = getBaseUrl().'CareerStatsPlayer.php?csName='.htmlspecialchars_decode($goalsArray[0]->getName())

	    ?>

	<div class="row">
		<a href="<?php echo $playerCareersLink;?>"
			class="styles__ImgContainer-sc-16cx6ic-1 hmnSFV"><div
				class="team-display-container EDM "
				style="position: absolute; bottom: 0px; right: -20px;">
				<div class="team-display ">
					<img class="team-logo"
						src="<?php echo getTeamLogoUrl($goalsArray[0]->getTeam())?>"
						alt="<?php echo $goalsArray[0]->getTeam()?>">
				</div>
			</div>
			<img src="<?php echo getProfilePhoto($goalsArray[0]->getName());?>" class="styles__Headshot-sc-16cx6ic-2 kxFCqJ player-avatar__img player-headshot"></a>
		<div class="styles__PlayerDetails-sc-16cx6ic-3 bvjVjv">
			<a href="<?php echo $playerCareersLink;?>"><div
					class="styles__NumberContainer-sc-16cx6ic-4 hHORBn">
					<span class="styles__Hash-sc-16cx6ic-5 gPPmv">#</span><?php echo $goalsArray[0]->getNumber();?>
				</div>
				<div class="styles__NameContainer-sc-16cx6ic-6 jPZtbn">
<!-- 					<span>Connor</span><span>McDavid</span> -->
					<span><?php echo $goalsArray[0]->getName();?></span>

				</div></a><a href="<?php echo $playerCareersLink;?>"
				class="styles__TeamNameContainer-sc-16cx6ic-7 cWNqKo"><span
				class="styles__TeamName-sc-16cx6ic-8 izUOIu"><?php echo $goalsArray[0]->getTeam();?></span><span><?php echo $goalsArray[0]->getPosition();?></span></a>
		</div>
		<div class="styles__StatDetails-sc-16cx6ic-9 glDXkE">
			<p class="styles__StatCategoryName-sc-16cx6ic-10 KRrDV">Goals</p>
			<p class="styles__StatCategoryValue-sc-16cx6ic-11 bSCsVG"><?php echo $goalsArray[0]->getGoals() ?></p>
		</div>
	</div>
	

	
	<div class="styles__LeaderListContainer-owf6ne-4 cOAcdw">
		<ul class="styles__LeaderList-owf6ne-5 ANxrZ leaders-list">
			<?php 
			foreach ($goalsArray as $skater) {
			
			?>
			<li class="styles__LeaderListItem-owf6ne-6 eTUABY active">
				<span><?php echo $skater->getName();?></span><span><?php echo $skater->getGoals();?></span>
			</li>
					
			<?php }?>

		</ul>
		<a class="styles__LeadersNavLink-owf6ne-8 bvgUsd" href="<?php echo getBaseUrl().'PlayerScoring.php?sort=4';?>">All Leaders</a>
	</div>

	<?php }else{
	   echo '<h5>Files not found</5>';
	}?>
	</div>
	</section>
	</div>
	
	<?php include FS_ROOT.'footer.php';?>