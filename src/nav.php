 
  <!-- Top menu -->
<style>
    body.fhlElement {
    	margin-top: 49px;
    }

    #main-navbar .dropdown-menu{
        min-width: 1rem;
        float:right;
         overflow-y:auto;
         max-height: 99vh;
    }
    
    @media(max-width:768px) {
        #main-navbar .dropdown-menu{
            overflow-y:auto;
            max-height: 50vh;
        }
      
    }
    
    @media(max-height:300px) {
        #main-navbar .dropdown-menu{
            overflow-x:auto;
            max-height: 50vh;
        }
      
    }

</style>
<nav class="navbar navbar-dark fixed-top navbar-expand-lg navbar-no-bg scrollable" id="main-navbar"> 


		<div class="container px-0">
			<a class="navbar-brand" href="<?php echo (HOME ? HOME : '.');?>"><?php echo $homeTitle?></a>

			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse navbar-nav-scroll" id="navbarNav">
				<ul class="navbar-nav ml-auto scrollable text-right">
					  <?php if(!empty(GMO_DIR)){?>
    					<li class="nav-item"><a class="nav-item nav-link" href="<?php echo GMO_DIR;?>"><?php echo $allGMOE;?></a></li>
    				  <?php }?>
					  
					  <li class="nav-item"><a class="nav-link" href="Scores.php"><?php echo $allScores?></a></li>
					  <!--<li class="nav-item"><a class="nav-link" href="Standings.php">Standings</a></li>-->
					  <li class="nav-item"><a class="nav-link" href="TeamRosters.php"><?php echo $allTeam?></a></li>
					  
					  <li class="dropdown">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $standingTitle?><span class="caret"></span></a>
						<ul class="dropdown-menu">
						  <li class="nav-item"><a class="nav-link-inner" href="Standings.php"><?php echo formatHtmlText($homeStandingsPro)?></a></li>
						  <li class="dropdown-divider"></li>
						  <li class="nav-item"><a class="nav-link-inner" href="FarmStandings.php?s=1"><?php echo formatHtmlText($homeStandingsFarm)?></a></li>
						  <li class="dropdown-divider"></li>
						  <li class="nav-item"><a class="nav-link-inner" href="OverallStandings.php"><?php echo formatHtmlText($standingOVTitle)?></a></li>
						</ul>
					  </li>

					  <li class="dropdown">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $homeStats?><span class="caret"></span></a>
						<ul class="dropdown-menu">
						  <li class="nav-item"><a class="nav-link-inner" href="Stats.php"><?php echo formatHtmlText($allStats)?></a></li>
						  <li class="dropdown-divider"></li>
						  <li class="nav-item"><a class="nav-link-inner" href="TeamStats.php"><?php echo formatHtmlText($teamStatsTitle)?></a></li>
						  <li class="dropdown-divider"></li>
						  <li class="nav-item"><a class="nav-link-inner" href="Individual.php"><?php echo formatHtmlText($individualTitle)?></a></li>
						  <li class="dropdown-divider"></li>
						  <li class="nav-item"><a class="nav-link-inner" href="Leaders.php?s=1"><?php echo formatHtmlText($leaderTitleFarm)?></a></li>
						  <li class="dropdown-divider"></li>
						  <li class="nav-item"><a class="nav-link-inner" href="CareerLeaders.php"><?php echo formatHtmlText($langCareerLeadersTitle)?></a></li>
						  <li class="dropdown-divider"></li>
						  <li class="nav-item"><a class="nav-link-inner" href="CareerStandings.php"><?php echo formatHtmlText($careerStandingsTitle)?></a></li>
						</ul>
					  </li>
					  <li class="dropdown">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo formatHtmlText($allLeague) ?><span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li class="nav-item"><a class="nav-link-inner" href="Schedule.php"><?php echo formatHtmlText($schedTitle)?></a></li>
							<li class="dropdown-divider"></li>
							<?php if(TRANSACTIONS_ENABLED){?>
							<li class="nav-item"><a class="nav-link-inner" href="Transact.php"><?php echo formatHtmlText($alltransact)?></a></li>
							<li class="dropdown-divider"></li>
							<?php }?>
							<li class="nav-item"><a class="nav-link-inner" href="FreeAgents.php"><?php echo formatHtmlText($allFreeAgents)?></a></li>
							<li class="dropdown-divider"></li>
							<li class="nav-item"><a class="nav-link-inner" href="Unassigned.php"><?php echo formatHtmlText($langUnassignedPlayers)?></a></li>
							<li class="dropdown-divider"></li>
							<li class="nav-item"><a class="nav-link-inner" href="Waivers.php"><?php echo formatHtmlText($waiversTitle)?></a></li>
							<li class="dropdown-divider"></li>
							<li class="nav-item"><a class="nav-link-inner" href="Coaches.php"><?php echo formatHtmlText($CoachesTitle)?></a></li>
							<li class="dropdown-divider"></li>
							<li class="nav-item"><a class="nav-link-inner" href="Injury.php"><?php echo formatHtmlText($injuryTitle)?></a></li>
			
						</ul>
					  </li>
					  <li class="dropdown">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo$allOther?>&nbsp;<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li class="nav-item"><a class="nav-link-inner" href="GMs.php"><?php echo formatHtmlText($GMsTitle)?></a></li>
							<li class="dropdown-divider"></li>
							<li class="nav-item"><a class="nav-link-inner" href="PlayerSearch.php"><?php echo formatHtmlText($searchPlayerTitle)?></a></li>
							<li class="dropdown-divider"></li>
							<li class="nav-item"><a class="nav-link-inner" href="ComparePlayers.php"><?php echo formatHtmlText($compareTitle)?></a></li>
							<li class="dropdown-divider"></li>
							<li class="nav-item"><a class="nav-link-inner" href="SalaryCop.php"><?php echo formatHtmlText($salaryCopTitle)?></a></li>
						
							
						</ul>
					  </li>
				</ul>
			</div>
			
		</div>
	</nav>
	
