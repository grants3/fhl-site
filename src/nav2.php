 
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
<nav role="navigation" class="navbar navbar-expand-md navbar-dark fixed-top navbar-no-bg scrollable" id="main-navbar"> 
  <div class="container px-0">

    <!-- Title -->
    <div class="navbar-header pull-left">
      <a class="navbar-brand" href="<?php echo (HOME ? HOME : '.');?>"><?php echo $homeTitle?></a>
    </div>

    <!-- 'Sticky' (non-collapsing) right-side menu item(s) -->
    <div class="navbar-header pull-left">
      <ul class="nav pull-left">

    	  <?php if(!empty(GMO_DIR)){?>
    		<li class="nav-item2"><a class="nav-item2 nav-link2 pull-left" href="<?php echo GMO_DIR;?>">GMOE</a></li>
    	  <?php }?>
    	  
    	  <li class="nav-item2"><a class="nav-link2 pull-left" href="Scores.php"><?php echo $allScores?></a></li>
    	  <!--<li class="nav-item"><a class="nav-link" href="Standings.php">Standings</a></li>-->
    	  <li class="nav-item2"><a class="nav-link2 pull-left" href="TeamRosters.php"><?php echo $allTeam?></a></li>
    	  



      </ul>

      <!-- Required bootstrap placeholder for the collapsed menu -->
      		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
<!--       <button type="button" data-toggle="collapse" data-target=".navbar-collapse" class="navbar-toggle"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button> -->
    </div>

		<div class="collapse navbar-collapse navbar-nav-scroll navbar-right" id="navbarNav">
				<ul class="navbar-nav ml-auto scrollable text-right pull-right">

					      	  <li class="dropdown">
    		<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $standingTitle?><span class="caret"></span></a>
    		<ul class="dropdown-menu">
    		  <li class="nav-item"><a class="nav-link-inner" href="Standings.php">Pro&nbsp;<?php echo $standingTitle?></a></li>
    		  <li class="dropdown-divider"></li>
    		  <li class="nav-item"><a class="nav-link-inner" href="FarmStandings.php?s=1">Farm&nbsp;<?php echo $standingTitle?></a></li>
    		</ul>
    	  </li>

					  <li class="dropdown">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Stats<span class="caret"></span></a>
						<ul class="dropdown-menu">
						  <li class="nav-item2"><a class="nav-link-inner" href="Stats.php"><?php echo formatHtmlText($homeStats)?></a></li>
						  <li class="dropdown-divider"></li>
						  <li class="nav-item2"><a class="nav-link-inner" href="TeamStats.php"><?php echo formatHtmlText($teamStatsTitle)?></a></li>
						  <li class="dropdown-divider"></li>
						  <li class="nav-item2"><a class="nav-link-inner" href="Individual.php"><?php echo formatHtmlText($individualTitle)?></a></li>
						  <li class="dropdown-divider"></li>
						  <li class="nav-item2"><a class="nav-link-inner" href="Leaders.php?s=1"><?php echo formatHtmlText($leaderTitleFarm)?></a></li>
						  <li class="dropdown-divider"></li>
						  <li class="nav-item2"><a class="nav-link-inner" href="CareerLeaders.php"><?php echo formatHtmlText($langCareerLeadersTitle)?></a></li>
						  <li class="dropdown-divider"></li>
						  <li class="nav-item2"><a class="nav-link-inner" href="CareerStandings.php"><?php echo formatHtmlText($careerStandingsTitle)?></a></li>
						</ul>
					  </li>

				</ul>
			</div>

    <!-- Additional navbar items -->
<!--     <div class="collapse navbar-collapse navbar-right"> -->
      <!--                      pull-right keeps the drop-down in line -->
<!--       <ul class="nav navbar-nav pull-right"> -->
<!--         <li><a href="#">Item 1</a></li> -->
<!--         <li><a href="#">Item 2</a></li> -->
<!--       </ul> -->
<!--     </div> -->
  </div>
</nav>
	
