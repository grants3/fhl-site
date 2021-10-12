<?php require_once __DIR__.'/../config.php';
include_once FS_ROOT.'fileUtils.php';
include_once FS_ROOT.'classes/TeamHolder.php';
include_once FS_ROOT.'classes/ScoringHolder.php';
include_once FS_ROOT.'classes/ScoringPlayerObj.php';
include_once FS_ROOT.'classes/ScoringGoalieObj.php';
include_once FS_ROOT.'classes/ScoringObj.php';
include_once FS_ROOT.'classes/TeamAbbrHolder.php';
include_once FS_ROOT.'classes/ScoringAccumulator.php';

//include FS_ROOT.'head.php';
?>

	<?php if(CDN_SUPPORT) {?>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,600"/>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css"/>
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.6/css/all.css"/> -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.css"/>
	<?php }else{?>
	<link rel="stylesheet" href="<?php echo BASE_URL?>assets/css/ex/fonts.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL?>assets/css/ex/bootstrap.min.css"/>
    <link rel="stylesheet" href="<?php echo BASE_URL?>assets/css/ex/font-awesome-all.css"/>
	<link rel="stylesheet" href="<?php echo BASE_URL?>assets/css/ex/animate.css"/>
	<?php }?>
     
     <!-- JQuery and bootstrap init -->
    <?php if(CDN_SUPPORT) {?>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.13.0/umd/popper.min.js"></script>
<!--     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.1/js/jquery.tablesorter.min.js"></script>
	<?php }else{?>
	<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/popper.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/jquery.tablesorter.min.js"></script>
	<?php }?>
     

	 <!-- Other scripts -->
	<?php if(CDN_SUPPORT) {?>
<!-- 	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.13.0/umd/popper.min.js"></script> -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-backstretch/2.0.4/jquery.backstretch.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
	<?php }else{?>
<!-- 	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.13.0/umd/popper.min.js"></script> -->
	<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/jquery.backstretch.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/wow.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/ex/jquery.waypoints.min.js"></script>
	<?php }?>


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


 /* main */ 

.ctbpu {
    background: rgb(255, 255, 255);
    box-shadow: rgb(0 0 0 / 5%) 0px 5px 5px 0px;
    margin-bottom: 20px;
    padding: 30px 10px;
    position: relative;
}

.hRjSuW {
    font-size: 24px;
}
.nBSgv {
    background: rgb(255, 255, 255);
    border-bottom: 1px solid rgb(210, 210, 210);
    display: flex;
}

.kEEjoJ.active {
    background-color: rgb(255, 255, 255);
    border-bottom: 4px solid rgb(1, 131, 218);
    border-top: 4px solid rgba(0, 0, 0, 0);
    color: rgb(37, 37, 37);
    cursor: default;
    font-weight: bold;
}

.kEEjoJ {
    -webkit-box-align: center;
    align-items: center;
    color: rgb(51, 51, 51);
    cursor: pointer;
    display: flex;
    font-size: 16px;
    margin-right: 20px;
    padding: 14px 0px;
    text-transform: uppercase;
}

.fdyHxu {
    display: flex;
} 

.fdyHxu > * {
    flex: 1 1 0%;
}

* {
    box-sizing: border-box;
}


/* /*  main */ */
.dpFoLl {
    display: flex;
    flex-direction: column;
    -webkit-box-align: center;
    align-items: center;
    padding-top: 25px;
}


/* /* image */ */

.hmnSFV { 
     display: block; 
     position: relative; 
} 

.kxFCqJ { */
     border: 1px solid rgb(210, 210, 210); 
     border-radius: 50%; 
     height: 100px; 
     width: 100px; 
     object-fit: cover; /*magic*/
} 

/* a { */
/*     color: rgb(51, 51, 51); */
/*     text-decoration: none; */
/* } */
/* /* team icon */ */
.team-display-container { 
     display: flex; 
     flex: 1; 
     position: absolute; 
     bottom: 0px; 
     right: -20px; 
} 
 
.team-display-container .team-display {
    display: flex;
    align-items: center;
    flex: 1 1 0%;
    color: #000000;
}
 
.team-display-container .team-display .team-logo {
    width: 48px;
    height: 32px;
}

/* /* player details */ */
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

/* /*amount details*/ */
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

/* .eTUABY.active { */
/*     font-weight: bold; */
/* } */

 .eTUABY { 
     display: flex; 
     -webkit-box-pack: justify; 
     justify-content: space-between; 
     margin-bottom: 10px; 
     font-size: 12px; 
   
/*All leaders*/     
.cOAcdw {
    text-align: right;
}
  

 li { 
     display: list-item; 
     text-align: -webkit-match-parent; 
     text-align: match-parent
 } 

</style>
<div class="container">
<section class="styles__Module-owf6ne-0 ctbpu">
	<header class="border">
		<h1 class="styles__Title-owf6ne-1 hRjSuW">Skaters</h1>
		<div class="ModuleContainer__ModuleMenu-zdst3-0 nBSgv">
			<a href="#" class="NavLinkButton-sc-1hg1q10-0 kEEjoJ active">Points</a><a
				href="#" class="NavLinkButton-sc-1hg1q10-0 kEEjoJ">Goals</a><a
				href="#" class="NavLinkButton-sc-1hg1q10-0 kEEjoJ">Assists</a>
		</div>
	</header>
	<div class="styles__LeaderContent-owf6ne-3 border">
    	<?php if($goalsArray){
    	    $playerCareersLink = getBaseUrl().'CareerStatsPlayer.php?csName='.htmlspecialchars_decode($goalsArray[0]->getName())
    
    	    ?>
    
    	<div class="styles__LeaderContent-owf6ne-3 fdyHxu">
			<div class="styles__Player-sc-16cx6ic-0 dpFoLl">
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
        				<?php $nameExploded = explode(" ", $goalsArray[0]->getName());?>
<!--          					<span>Connor</span><span>McDavid</span>  -->
        					<span><?php echo $nameExploded[0];?></span><span><?php echo $nameExploded[1];?></span>
        
        				</div></a><a href="<?php echo $playerCareersLink;?>"
        				class="styles__TeamNameContainer-sc-16cx6ic-7 cWNqKo"><span
        				class="styles__TeamName-sc-16cx6ic-8 izUOIu"><?php echo $goalsArray[0]->getTeam();?></span><span><?php echo $goalsArray[0]->getPosition();?></span></a>
        		</div>
        		
        		<div class="styles__StatDetails-sc-16cx6ic-9 glDXkE">
        			<p class="styles__StatCategoryName-sc-16cx6ic-10 KRrDV">Goals</p>
        			<p class="styles__StatCategoryValue-sc-16cx6ic-11 bSCsVG"><?php echo $goalsArray[0]->getGoals() ?></p>
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
            </div>
         </div>

    	<?php }else{
    	   echo '<h5>Files not found</5>';
    	}?>
	</div>
</section>
</div>
	