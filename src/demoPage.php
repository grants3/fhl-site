<!DOCTYPE html>
<html>


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>TablePage 2.0 Demo</title>
    
<!--     <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"/> -->
<!--     <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
<!--     <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.13.0/umd/popper.min.js"></script> -->
<!--     <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script> -->
    
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

	<style>
	
	

body {
    font-family: 'Roboto', sans-serif;
    background: #fafafa;
}

#sidebar a,
#sidebar a:hover,
#sidebar a:focus {
    color: #fff !important;
    text-decoration: none;
    transition: all 0.3s;
}

.navbar {
    padding: 15px 10px;
    background: #fff;
    border: none;
    border-radius: 0;
    margin-bottom: 40px;
    box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
}

.navbar-btn {
    box-shadow: none;
    outline: none !important;
    border: none;
}

.line {
    width: 100%;
    height: 1px;
    border-bottom: 1px dashed #ddd;
    margin: 40px 0;
}

/* ---------------------------------------------------
    SIDEBAR STYLE
----------------------------------------------------- */

.wrapper {
    display: flex;
    width: 100%;
}

#sidebar {
    width: 250px;
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    z-index: 999;
    background: rgb(15, 40, 81);
    color: #fff;
    transition: all 0.3s;
}

#sidebar.active {
    margin-left: -250px;
}

#sidebar .sidebar-header {
    padding: 20px;
    background: rgb(27, 98, 162);
}

#sidebar ul.components {
    padding: 20px 0;
    border-bottom: 1px solid #47748b;
}

#sidebar ul p {
    color: #fff;
    padding: 10px;
}

#sidebar ul li a {
    padding: 10px;
    font-size: 1.1em;
    display: block;
}

#sidebar ul li a:hover {
    color: #7386D5;
    background: rgb(15, 40, 81);;
}

#sidebar ul li.active>a,
#sidebar a[aria-expanded="true"] {
    color: #fff;
    background: rgb(27, 98, 162);
}

#sidebar a[data-toggle="collapse"] {
    position: relative;
}

.dropdown-toggle::after {
    display: block;
    position: absolute;
    top: 50%;
    right: 20px;
    transform: translateY(-50%);
}

#sidebar ul ul a {
    font-size: 0.9em !important;
    padding-left: 30px !important;
    background: rgb(27, 98, 162);
}

#sidebar ul.CTAs {
    padding: 20px;
}

#sidebar ul.CTAs a {
    text-align: center;
    font-size: 0.9em !important;
    display: block;
    border-radius: 5px;
    margin-bottom: 5px;
}

a.article,
a.article:hover {
    background: rgb(27, 98, 162) !important;
    color: #fff !important;
}

/* ---------------------------------------------------
    CONTENT STYLE
----------------------------------------------------- */

#content {
    width: calc(100% - 250px);
    padding: 5px;
    min-height: 100vh;
    transition: all 0.3s;
    position: absolute;
    top: 0;
    right: 0;
}

#content.active {
    width: 100%;
}

/* ---------------------------------------------------
    MEDIAQUERIES
----------------------------------------------------- */

@media (max-width: 768px) {
    #sidebar {
        margin-left: -250px;
    }
    #sidebar.active {
        margin-left: 0;
    }
    #content {
        width: 100%;
    }
    #content.active {
/*        width: calc(100% - 250px); */
        width: calc(100%);
    }
    #sidebarCollapse span {
        display: none;
    }
    
    /* at mobile breakpoints stretch full screen */
    #content .article-content {
     width:100% !important;
    }

}
	
	</style>
</head>

<body>

    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>TablePage 2.0 Demo</h3>
            </div>

            <ul class="list-unstyled components">
      
                <li class="active">
                    <a href="#teamSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Team Pages</a>
                    <ul class="collapse list-unstyled" id="teamSubmenu">
                    
                        <li>
                       	 <a class="nav-link" href="TeamRosters.php">Team Rosters</a>
                            <a class="nav-item nav-link" href="TeamScoring.php">Team Scoring</a>
                            <a class="nav-item nav-link" href="TeamFinance.php">Team Finances</a>
                             <a class="nav-item nav-link" href="TeamLines.php">Team Lines</a>
                           <a class="nav-item nav-link" href="TeamFutures.php">Team Futures</a>
                			<a class="nav-item nav-link" href="TeamTransactions.php">Team Transactions</a>
                            <a class="nav-item nav-link" href="TeamOverview.php">Team Overview</a>
                            <a class="nav-item nav-link" href="TeamSchedule.php">Team Schedule</a>
                        </li>
          
                    </ul>
                </li>
  				<li ><a class="nav-link" href="Scores.php">Scores</a></li>
  				<li>
                    <a href="#statsSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Stats Pages</a>
                    <ul class="collapse list-unstyled" id="statsSubmenu">
                    
						 <li ><a href="Stats.php">Statistics</a></li>
						  <li ><a href="TeamStats.php">Team Stats</a></li>
						  <li ><a href="Individual.php">Individual Stats</a></li>
						  <li ><a href="Leaders.php?s=1">Leaders</a></li>
						  <li ><a href="CareerLeaders.php">Career Leaders</a></li>
						 <li ><a href="CareerStandings.php">Career Standings</a></li>
          
                    </ul>
                </li>
                
                <li>
                    <a href="#leagueSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">League Pages</a>
                    <ul class="collapse list-unstyled" id="leagueSubmenu">
                    
							<li ><a  href="Schedule.php">Schedule</a></li>
							
							<li ><a  href="Transact.php">Transactions</a></li>
							
							<li ><a  href="FreeAgents.php">Free Agents</a></li>
							
							<li ><a  href="Unassigned.php">Unassigned</a></li>
							
							<li ><a  href="Waivers.php">Waivers</a></li>
							
							<li ><a  href="Coaches.php">Coaches</a></li>
							
							<li ><a  href="Injury.php">Injury</a></li>
							
							<li ><a  href="GMs.php">GMs</a></li>
							
							<li ><a  href="PlayerSearch.php">Player Search</a></li>
							
							<li ><a  href="ComparePlayers.php">Compare</a></li>
							
							<li ><a  href="SalaryCop.php">Salary&nbspCop</a></li>
          
                    </ul>
                </li>
      
            </ul>


            <ul class="list-unstyled CTAs">
                <li>
                    <a href="." class="article">Back to Site</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">
        
           

            <nav class="navbar navbar-expand-lg navbar-light bg-light ">
                <div class="container-fluid d-flex justify-content-end">

				    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-right"></i>
                        <span>Toggle Sidebar</span>
                    </button>
                </div>
            </nav>

           <main>
           		<article class="">
					<div class="article-content">
					<div class="card">
						<div class="card-header">
							<h5>TablePage 2.0 Components</h5>
						</div>
    					<div class="card-body">
    					<p>Add Components to your league web page by including the links below<p>
    					<p>Unless you are using the build-in home page provided with TablePage 2.0, it is recommended to put table sim page 2.0 in a different folder from your main index.html/php to keep the files seperate and making fixes easy. To use the links below just append the table sim location to the link</p>
    					<p>if http://yourLeague.com/ is your home page and -> Add-on folder: http://yourLeague.com/TablePage/ then including an example component would be: 'include 'TablePage/component/ScoreCarousel.php'</p>
    					</div>
					</div>
			
					</div>			
				</article>
				
				<article class="mt-3">
				<?php echo 'include \'component/ScoreCarousel.php\';'?>
					<div class="article-content" style="width:100%">Score Carousel
						<?php //include FS_ROOT.'component/ScoreCarousel.php'; ?>	
						<?php include 'component/ScoreCarousel.php'; ?>	
					</div>			
				</article>
				<article class="mt-3">
					<?php echo 'include \'component/MiniWaivers.php\';'?>
					<div class="article-content" style="width:60%">Waivers Mini
						<?php include 'component/MiniWaivers.php'; ?>	
					</div>					
				</article>
				<article class="mt-3">
				<?php echo 'include \'component/News.php\';'?>
					<div class="article-content" style="width:50%">News
						<?php include 'component/News.php'; ?>	
					</div>		
				</article>
				<article class="mt-3">
					<?php echo 'include \'component/MiniNextGames.php\';'?>
					<div class="article-content" style="width:50%">Next Games Mini 
						<?php include 'component/MiniNextGames.php'; ?>	
					</div>						
				</article>
				<article class="mt-3">
				<?php echo 'include \'component/MiniLeaders.php\';'?>
					<div class="article-content" style="width:50%">Scoring Leaders Mini
						<?php include 'component/MiniLeaders.php'; ?>	
					</div>	
				</article>
				<article class="mt-3">
				<?php echo 'include \'component/MiniStandings.php\';'?>
					<div class="article-content" style="width:40%">Full Standings Mini
                        <?php include 'component/MiniStandings.php';?>
					</div>
				</article>
				<article class="mt-3">
				<?php echo 'include \'component/MiniStandingsTree.php\';'?>
					<div class="article-content" style="width:50%">Playoff Tree Mini
						<?php include 'component/MiniStandingsTree.php';?>
					</div>
				</article>
				
			</main>	
 
       </div>
    </div>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    
    <script type="text/javascript">
        $(document).ready(function () {
            $("#sidebar").mCustomScrollbar({
                theme: "minimal"
            });
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar, #content').toggleClass('active');
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });
        });
    </script>
    

</body>

</html>