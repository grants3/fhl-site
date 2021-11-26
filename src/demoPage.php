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
a[aria-expanded="true"] {
    color: #fff;
    background: rgb(27, 98, 162);
}

a[data-toggle="collapse"] {
    position: relative;
}

.dropdown-toggle::after {
    display: block;
    position: absolute;
    top: 50%;
    right: 20px;
    transform: translateY(-50%);
}

ul ul a {
    font-size: 0.9em !important;
    padding-left: 30px !important;
    background: rgb(27, 98, 162);
}

ul.CTAs {
    padding: 20px;
}

ul.CTAs a {
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
    
    /* at mobile breakpoint stretch full components screen */
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
                    <a href="#standingsSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Standings Pages</a>
                    <ul class="collapse list-unstyled" id="standingsSubmenu">
 
						  <li><a  href="Standings.php">Pro Standings</a></li>
						  <li><a href="FarmStandings.php?s=1">Farm Standings</a></li>
						  <li><a href="OverallStandings.php">Overall Standings</a></li>
          
                    </ul>
                </li>
  				
  				<li>
                    <a href="#statsSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Stats Pages</a>
                    <ul class="collapse list-unstyled" id="statsSubmenu">
                    
						 <li ><a href="Stats.php">Statistics</a></li>
						  <li ><a href="TeamStats.php">Team Stats</a></li>
						  <li ><a href="Individual.php">Individual Stats</a></li>
						  <li ><a href="Leaders.php?s=1">Farm Leaders</a></li>
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
        
           

            <nav class="navbar navbar-expand-lg navbar-light bg-light mb-0 ">
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
    					<p>Use the home page provided, or use your own! Add Components to your php based league web page by using the php include examples below<p>
    					<p>Unless you are using the build-in home page provided with TablePage 2.0, it is recommended to put table sim page 2.0 in a different folder from your main index.html/php to keep the files seperate and making fixes easy. To use the links below just append the table sim location to the link</p>
    					<p>if http://yourLeague.com/ is your home page and -> Add-on folder: http://yourLeague.com/TablePage/ then including an example component would be: include 'TablePage/component/ScoreCarousel.php'</p>
    					</div>
					</div>
			
					</div>			
				</article>

				<article class="mt-3">
				<?php echo 'include \'component/TeamBanner.php\';'?>
					<div class="article-content" style="width:100%"><h5>Team Banner</h5>
						<?php include 'component/TeamBanner.php'; ?>	
					</div>			
				</article>
				<article class="mt-3">
				<?php echo 'include \'component/ScoreCarousel.php\';'?>
					<div class="article-content" style="width:100%"><h5>Score Carousel</h5>
						<?php //include FS_ROOT.'component/ScoreCarousel.php'; ?>	
						<?php include 'component/ScoreCarousel.php'; ?>	
					</div>			
				</article>
				<article class="mt-3">
					<?php echo 'include \'component/MiniWaivers.php\';'?>
					<div class="article-content" style="width:60%"><h5>Waivers Mini</h5>
						<?php include 'component/MiniWaivers.php'; ?>	
					</div>					
				</article>
				<article class="mt-3">
				<?php echo 'include \'component/News.php\';'?>
					<div class="article-content" style="width:50%"><h5>News</h5>
						<?php include 'component/News.php'; ?>	
					</div>		
				</article>
				<article class="mt-3">
					<?php echo 'include \'component/MiniNextGames.php\';'?>
					<div class="article-content" style="width:50%"><h5>Next Games Mini</h5>
						<?php include 'component/MiniNextGames.php'; ?>	
					</div>						
				</article>
				<article class="mt-3">
				<?php echo 'include \'component/MiniLeaders.php\';'?>
					<div class="article-content" style="width:50%"><h5>Scoring Leaders Mini</h5>
						<?php include 'component/MiniLeaders.php'; ?>	
					</div>	
				</article>
				<article class="mt-3">
				<?php echo 'include \'component/MiniStandings.php\';'?>
					<div class="article-content" style="width:40%"><h5>Full Standings Mini</h5>
                        <?php include 'component/MiniStandings.php';?>
					</div>
				</article>
				<article class="mt-3">
				<?php echo 'include \'component/MiniStandingsTree.php\';'?>
					<div class="article-content" style="width:50%"><h5>Playoff Tree Mini</h5>
						<?php include 'component/MiniStandingsTree.php';?>
					</div>
				</article>
				
				<article class="mt-3">
					<div class="article-content" style="width:100%"><h5>Links</h5>
					<div class="card fhlElement">
						<div class="card-header">
							<h5>TablePage 2.0 Links</h5>
						</div>
    					<div class="card-body">
    					<p>Link to TablePage 2.0 Pages. Like components you can have table page 2.0 in another directory. or you can put it all in the same directory and use the links as shown.</p>
    					<p>if http://yourLeague.com/ is your home page and -> Add-on folder: http://yourLeague.com/TablePage/ then linking to a page would require a link as follows &lt;a href="TablePage/TeamRosters.php"&gt;Rosters&lt;/a&gt;</p>
    			
						<table class="table table-sm table-striped">
                          <thead>
                            <tr>
                              <th>Page</th>
                              <th>Type</th>
                              <th>Link</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>Team Roster</td>
                              <td>Team</td>
                              <td><a href="TeamRosters.php">TeamRosters.php</a></td>
                            </tr>
                  			 <tr>
                              <td>Team Scoring</td>
                              <td>Team</td>
                              <td><a href="TeamScoring.php">TeamScoring.php</a></td>
                            </tr>
                            <tr>
                              <td>Team Finance</td>
                              <td>Team</td>
                              <td><a href="TeamFinance.php">TeamFinance.php</a></td>
                            </tr>
                            <tr>
                              <td>Team Lines</td>
                              <td>Team</td>
                              <td><a href="TeamLines.php">TeamLines.php</a></td>
                            </tr>
                            <tr>
                              <td>Team Futures</td>
                              <td>Team</td>
                              <td><a href="TeamFutures.php">TeamFutures.php</a></td>
                            </tr>
                            <tr>
                              <td>Team Transactions</td>
                              <td>Team</td>
                              <td><a href="TeamTransactions.php">TeamTransactions.php</a></td>
                            </tr>
                            <tr>
                              <td>Team Overview</td>
                              <td>Team</td>
                              <td><a href="TeamOverview.php">TeamOverview.php</a></td>
                            </tr>
                            <tr>
                              <td>Team Schedule</td>
                              <td>Team</td>
                              <td><a href="TeamSchedule.php">TeamSchedule.php</a></td>
                            </tr>
                            
                            <tr>
                              <td>Pro Standings</td>
                              <td>Standings</td>
                              <td><a href="Standings.php">Standings.php</a></td>
                            </tr>
                            <tr>
                              <td>Farm Standings</td>
                              <td>Standings</td>
                              <td><a href="FarmStandings.php?s=1">FarmStandings.php?s=1</a></td>
                            </tr>
                             <tr>
                              <td>Overall Standings</td>
                              <td>Standings</td>
                              <td><a href="OverallStandings.php">OverallStandings.php</a></td>
                            </tr>
				
                            <tr>
                              <td>Statistics</td>
                              <td>Stats</td>
                              <td><a href="Stats.php">Stats.php</a></td>
                            </tr>
                            <tr>
                              <td>Team Stats</td>
                              <td>Stats</td>
                              <td><a href="TeamStats.php">TeamStats.php</a></td>
                            </tr>
                            <tr>
                              <td>Individual Stats</td>
                              <td>Stats</td>
                              
                              <td><a href="Individual.php">Individual.php</a></td>
                            </tr>
                            <tr>
                              <td>Pro Leaders (old)</td>
                              <td>Stats</td>
                            
                              <td><a href="Leaders.php?s=1">Leaders.php</a></td>
                            </tr>
                            <tr>
                              <td>Farm Leaders</td>
                              <td>Stats</td>
                            
                              <td><a href="Leaders.php?s=1">Leaders.php?s=1</a></td>
                            </tr>
                            <tr>
                              <td>Career Leaders</td>
                              <td>Stats</td>
                            
                              <td><a href="CareerLeaders.php">CareerLeaders.php</a></td>
                            </tr>
                            <tr>
                              <td>Career Standings</td>
                              <td>Stats</td>
                           
                              <td><a href="CareerStandings.php">CareerStandings.php</a></td>
                            </tr>

                            <tr>
                              <td>League Schedule</td>
                              <td>League</td>
                             
                              <td><a href="Schedule.php">Schedule.php</a></td>
                            </tr>
                            <tr>
                              <td>League Transactions</td>
                              <td>League</td>
                            
                              <td><a href="Transact.php">Transact.php</a></td>
                            </tr>
                            <tr>
                              <td>Free Agents</td>
                              <td>League</td>
                              
                              <td><a href="FreeAgents.php">FreeAgents.php</a></td>
                            </tr>
                            <tr>
                              <td>Unassigned</td>
                              <td>League</td>
                              
                              <td><a href="Unassigned.php">Unassigned.php</a></td>
                            </tr>
                            <tr>
                              <td>Waivers</td>
                              <td>League</td>
                            
                              <td><a href="Waivers.php">Waivers.php</a></td>
                            </tr>
                            <tr>
                              <td>Coaches</td>
                              <td>League</td>
                              <td><a href="Coaches.php">Coaches.php</a></td>
                            </tr>
                            <tr>
                              <td>Injuries and Suspensions</td>
                              <td>League</td>

                              <td><a href="Injury.php">Injury.php</a></td>
                            </tr>
                            <tr>
                              <td>GM Page</td>
                              <td>League</td>
                              <td><a href="GMs.php">GMs.php</a></td>
                            </tr>
                            <tr>
                              <td>PlayerSearch</td>
                              <td>League</td>
                              <td><a href="PlayerSearch.php">PlayerSearch.php</a></td>
                            </tr>
                            <tr>
                              <td>Compare Players</td>
                              <td>League</td>
                              <td><a href="ComparePlayers.php">ComparePlayers.php</a></td>
                            </tr>
                            <tr>
                              <td>Salary Cop</td>
                              <td>League</td>
                              <td><a href="SalaryCop.php">SalaryCop.php</a></td>
                            </tr>
                            
               
                          </tbody>
                        </table>
                       </div>
					</div>
					</div>
				</article>
				
			</main>	
 
       </div>
    </div>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    
    <script type="text/javascript">
        $(document).ready(function () {
//             $("#sidebar").mCustomScrollbar({
//                 theme: "minimal"
//             });
//             $('#sidebarCollapse').on('click', function () {
//                 $('#sidebar, #content').toggleClass('active');
//                 $('.collapse.in').toggleClass('in');
//                 $('a[aria-expanded=true]').attr('aria-expanded', 'false');
//             });
        });
    </script>
    

</body>

</html>