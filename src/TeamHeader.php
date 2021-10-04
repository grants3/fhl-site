<?php 
require_once 'config.php';

?>

<style>

/* .header-content { margin-top: 65px; margin-bottom: 10px; } */

.highlight-team {
	-webkit-filter: sepia(1);
	filter: sepia(1);
border-bottom:1px solid blue;
}

#header-nav .active {
    font-weight: 1000;
	font-size: large;
}

.team-header-content { 
    /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#cedce7+9,596a72+100 */
    background: var(--team-header-background-color-2); /* Old browsers */
    background: -moz-linear-gradient(top, var(--team-header-background-color-1) 9%, var(--team-header-background-color-2) 100%); /* FF3.6-15 */
    background: -webkit-linear-gradient(top, var(--team-header-background-color-1) 9%,var(--team-header-background-color-2) 100%); /* Chrome10-25,Safari5.1-6 */
    background: linear-gradient(to bottom, var(--team-header-background-color-1) 9%,var(--team-header-background-color-2) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cedce7', endColorstr='#596a72',GradientType=0 ); /* IE6-9 */

    border-radius: 5px;   
    margin-bottom:10px;
}

.team-nav {
   a { color: rgba(225, 239, 255, 1.0); ; border-bottom: 1px ; text-decoration: none; transition: all .3; }
   a:hover, a:focus { 
    color: #856dc0; border: 0; text-decoration: none;   -webkit-filter: grayscale(100%);
    -moz-filter: grayscale(100%);
    filter: grayscale(100%);
   }
}

.team-nav a { color: rgba(225, 239, 255, 1.0); border-bottom: 1px ; text-decoration: none; transition: all .3; }

.panel-profile-img { 
	max-width: 75px; 
	margin-top: -10px; 
	margin-bottom: -10px; 
	margin-left: -20px; 
/*  	border: 1px solid #fff;   */
/* 	background-color: #708090;  */
/* 	border-radius: 100%;   */
}

.nav-item{
    text-transform: uppercase;
}



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

.team .header-container{ 
     background: var(--header-gradient);
     height: 68px;  
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

<div class="container team-header-content">

<?php

//$CurrentTitle .= ' - '.$currentTeam;
    
//team logo links
if($navbarMode <= 2){
echo '<div class="row">';
    echo '<div id="logo-header" class="col text-center">';
    
    sort($gmequipe); //sort
    for($i=0;$i<count($gmequipe);$i++) {
        $matches = glob($folderTeamLogos.strtolower($gmequipe[$i]).'.*');
        $teamImage = '';
        for($j=0;$j<count($matches);$j++) {
            $teamImage = $matches[$j];
            break 1;
        }
        //echo '<a id="'.$gmequipe[$i].'" href="'.$CurrentPage.'.php?'.$dropLinkPlf.$dropLinkFarm.$dropLinkOne.'team='.$gmequipe[$i].'">';
        echo '<a id="'.$gmequipe[$i].'" href="'.$CurrentPage.'.php?'.$plfLink.$dropLinkFarm.$dropLinkOne.'team='.$gmequipe[$i].'">';
        
        echo '<img src="'.$teamImage.'" width=55>';
        
        echo '</a>';
    }
    echo '</div>';
    
echo '</div>';
}

//team nav
    //includeWithVariables('component/teamDropdown.php',array('teamList' => $gmequipe, 'teamDropdownPrefix' => 'roster', 'CurrentPage' => $CurrentPage));
    echo '<div class="row justify-content-center team-nav">';
    echo '<nav id ="header-nav" class="nav justify-content-center">';
    echo'<a class="nav-item nav-link" href="TeamScoring.php'.$plfLink.'">'.$allScoring.'</a>';
    echo'<a class="nav-item nav-link" href="TeamFinance.php'.$plfLink.'">'.$allFinances.'</a>';
    echo'<a class="nav-item nav-link" href="TeamRosters.php'.$plfLink.'">'.$allRosters.'</a>';
    echo'<a class="nav-item nav-link" href="TeamLines.php'.$plfLink.'">'.$allLines.'</a>';
    echo'<a class="nav-item nav-link" href="TeamFutures.php'.$plfLink.'">'.$allProspects.'</a>';
    echo'<a class="nav-item nav-link" href="TeamTransactions.php">Transactions</a>';
    echo'<a class="nav-item nav-link" href="TeamOverview.php'.$plfLink.'">'.$allTeamCard.'</a>';
    echo'<a class="nav-item nav-link" href="TeamSchedule.php'.$plfLink.'">'.$schedTitle.'</a>';
    echo '</nav>';
    echo '</div>';




?>


<script>

function getPageName() {

    var index = window.location.href.lastIndexOf("/") + 1,
        filenameWithExtension = window.location.href.substr(index),
        filename = filenameWithExtension.split('?')[0]; 

	return filename;
}

$(document).ready(function() {

	$('a', $('#header-nav')).each(function () {

		var href = $(this).attr('href');
		if(typeof href !== "undefined"){
			if(href.startsWith(getPageName())){
				$(this).addClass('active');
			}
		}

	});

});

</script>

</div>
