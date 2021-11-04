
<!--  <header style="width: 100%; height: 200px; background-color: #EEE; display: block;">
 </header> -->
 
 <link href="https://fonts.googleapis.com/css?family=Merriweather" rel="stylesheet">
 <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<style>

.navbar {
        height: 50px;
      }

      .to-sidebar {
        position: fixed;
        top: 50px;
        background-color: #eee;
        left: 0;
        min-width: 300px;
        height: 100%;
        overflow-y: auto;
        z-index: auto;
      }
      
      .block {
    display: block;
    float: left;
    background-color: #87CEEB;
    width: 100%;
}

</style>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top" id="main-navbar">
    <div class="container-fluid">
    
    <div class="container-fluid d-block d-lg-none">
      <div class="row">
        <div class="col-1">
          <div class="navbar-toggler navbar-toggler-left" data-toggle="collapse" style="float:left; margin-left: -15px">
            <i class="mt-1 material-icons menu animated" >menu</i>
          </div>
        </div>

    
<!--      	<h5 class="mt-2 col-10 text-center">Home</h5> -->
<!--         <i class="material-icons mt-2 pr-2 text-right col-1">more_vert</i> -->

      </div>
    </div>
    
    
    
    <div class="collapse navbar-collapse justify-content-md-center animated">
<!--       <div class="text-center"> -->
<!--       	<a class="nav-link" href="#">Brand Name</a> -->
<!--       </div> -->
    	<li class="nav-item"><a class="nav-link navbar-brand" href="index.php">Home</a></li>
      <ul class="navbar-nav changing-nav"> 
        <!--  -->
<!--         <li class="nav-item active"> -->
<!--           <a class="nav-link" href="#">Home -->
<!--             <span class="sr-only">(current)</span> -->
<!--           </a> -->
<!--         </li> -->

					  <li class="nav-item"><a class="nav-link" href="Scores.php">Scores</a></li>
					  <li class="nav-item"><a class="nav-link" href="Standings.php">Standings</a></li>
					  <li class="nav-item"><a class="nav-link" href="TeamRosters.php">Teams</a></li>
					  <li class="dropdown">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Stats&nbsp;<span class="caret"></span></a>
						<ul class="dropdown-menu">
						  <li class="nav-item"><a class="nav-link-inner" href="PlayerScoring.php">Player Stats</a></li>
						  <li class="nav-item"><a class="nav-link-inner" href="TeamStats.php">Team Stats</a></li>
						  <li class="nav-item"><a class="nav-link-inner" href="Individual.php">Individual</a></li>
						  <li class="nav-item"><a class="nav-link-inner" href="Leaders.php">Leaders</a></li>
						  <li class="nav-item"><a class="nav-link-inner" href="Leaders.php?s=1">Farm&nbsp;Leaders</a></li>
						  <li class="nav-item"><a class="nav-link-inner" href="CareerLeaders.php">Career&nbsp;Leaders</a></li>
						  <li class="nav-item"><a class="nav-link-inner" href="CareerStandings.php">Career&nbsp;Standings</a></li>
						</ul>
					  </li>
					  <li class="dropdown">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">League&nbsp;<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li class="nav-item"><a class="nav-link-inner" href="Coaches.php">Coaches</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="Injury.php">Injuries</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="Schedule.php">Schedule</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="Transact.php">Transactions</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="Waivers.php">Waivers</a></li>
							<li class="dropdown-divider"></li>
							<li class="nav-item"><a class="nav-link-inner" href="FarmStandings.php?s=1">Farm&nbsp;Standings</a></li>
							<li class="dropdown-divider"></li>
							<li class="nav-item"><a class="nav-link-inner" href="FreeAgents.php">Free&nbsp;Agents</a></li>
							<li class="dropdown-divider"></li>
							<li class="nav-item"><a class="nav-link-inner" href="Unassigned.php">Unassigned</a></li>
							
						</ul>
					  </li>
					  <li class="dropdown">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Other&nbsp;<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li class="nav-item"><a class="nav-link-inner" href="GMs.php">General&nbsp;Managers</a></li>
							<li class="dropdown-divider"></li>
							<li class="nav-item"><a class="nav-link-inner" href="PlayerSearch.php">Player Search</a></li>
							<li class="dropdown-divider"></li>
							<li class="nav-item"><a class="nav-link-inner" href="ComparePlayers.php">Player Compare</a></li>
							<li class="dropdown-divider"></li>
							<li class="nav-item"><a class="nav-link-inner" href="SalaryCop.php">Salary&nbsp;Cop</a></li>
						</ul>
					  </li>
        
       

      </ul>
    </div>
    </div>
  </nav>
  
  <script>
  
$(document).ready(function() {
        $(".navbar-toggler").on('click', function() {
          if($(".navbar-collapse").hasClass('animated fadeInLeft')) {
            $(".navbar-collapse").removeClass('animated fadeInLeft').addClass('animated fadeOutLeft');
            $(".changing-nav").removeClass('navbar-nav').addClass('nav flex-column');
            $(".navbar-collapse").addClass('to-sidebar');
            $(".menu").html('menu');
            $(".menu").hide().removeClass('animated rotateIn').addClass('animated rotateOut');
            $(".menu").show().removeClass('animated rotateOut').addClass('animated rotateIn');
          } else {
            $(".navbar-collapse").show().removeClass('animated fadeOutLeft').addClass('animated fadeInLeft');
            $(".changing-nav").removeClass('navbar-nav').addClass('nav flex-column');
            $(".navbar-collapse").addClass('to-sidebar');
            $(".menu").html('arrow_back');
            $(".menu").hide().removeClass('animated rotateIn').addClass('animated rotateOut');
            $(".menu").show().removeClass('animated rotateOut').addClass('animated rotateIn');
          }
        });

      });
  </script>
