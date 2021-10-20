 
  <!-- Top menu -->
<style>
    body.fhlElement {
    	margin-top: 56px;
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


		<div class="container">
			<a class="navbar-brand" href="<?php echo HOME?>">Navbar</a>

			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse navbar-nav-scroll" id="navbarNav">
				<ul class="navbar-nav ml-auto scrollable text-right">
					  <?php if(!empty(GMO_DIR)){?>
    					<li class="nav-item"><a class="nav-item nav-link" href="<?php echo BASE_URL.GMO_DIR;?>">GMO</a></li>
    				  <?php }?>
					  
					  <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL?>Scores.php">Scores</a></li>
					  <!--<li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL?>Standings.php">Standings</a></li>-->
					  <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL?>TeamRosters.php">Teams</a></li>
					  
					  <!-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navStandingsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Standings
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navStandingsDropdown">
                          <a class="nav-item dropdown-item" href="<?php //echo BASE_URL?>Standings.php">Pro&nbsp;Standings</a>
                          <div class="dropdown-divider"></div>
                          <a class="nav-item dropdown-item" href="<?php //echo BASE_URL?>FarmStandings.php?s=1">Farm&nbsp;Standings</a>
                        </div>
                      </li>-->
					  
					  <li class="dropdown">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Standings<span class="caret"></span></a>
						<ul class="dropdown-menu">
						  <li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>Standings.php">Pro&nbsp;Standings</a></li>
						  <li class="dropdown-divider"></li>
						  <li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>FarmStandings.php?s=1">Farm&nbsp;Standings</a></li>
						</ul>
					  </li>

					  <li class="dropdown">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Stats<span class="caret"></span></a>
						<ul class="dropdown-menu">
						  <li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>Stats.php">Statistics</a></li>
						  <li class="dropdown-divider"></li>
						  <li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>TeamStats.php">Team Stats</a></li>
						  <li class="dropdown-divider"></li>
						  <li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>Individual.php">Individual</a></li>
						  <li class="dropdown-divider"></li>
						  <li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>Leaders.php?s=1">Farm&nbsp;Leaders</a></li>
						  <li class="dropdown-divider"></li>
						  <li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>CareerLeaders.php">Career&nbsp;Leaders</a></li>
						  <li class="dropdown-divider"></li>
						  <li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>CareerStandings.php">Career&nbsp;Standings</a></li>
						</ul>
					  </li>
					  <li class="dropdown">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">League&nbsp;<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>Schedule.php">Schedule</a></li>
							<li class="dropdown-divider"></li>
							<li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>Transact.php">Transactions</a></li>
							<li class="dropdown-divider"></li>
							<li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>FreeAgents.php">Free&nbsp;Agents</a></li>
							<li class="dropdown-divider"></li>
							<li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>Unassigned.php">Unassigned</a></li>
							<li class="dropdown-divider"></li>
							<li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>Waivers.php">Waivers</a></li>
							<li class="dropdown-divider"></li>
							<li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>Coaches.php">Coaches</a></li>
							<li class="dropdown-divider"></li>
							<li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>Injury.php">Injuries</a></li>
			
						</ul>
					  </li>
					  <li class="dropdown">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Other&nbsp;<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>GMs.php">General&nbsp;Managers</a></li>
							<li class="dropdown-divider"></li>
							<li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>PlayerSearch.php">Player Search</a></li>
							<li class="dropdown-divider"></li>
							<li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>ComparePlayers.php">Player Compare</a></li>
							<li class="dropdown-divider"></li>
							<li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>SalaryCop.php">Salary&nbsp;Cop</a></li>
						
							
						</ul>
					  </li>
				</ul>
			</div>
			
		</div>
	</nav>
	
