<?php 
require_once __DIR__.'/config.php';
include_once FS_ROOT.'fileUtils.php';

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
/* 	font-size: large; */
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

.team-nav .nav-item{
    text-transform: uppercase;
}

.team-nav-logo-container {
    max-height: 49px;
    width: 49px;
    min-height:30px;

    display: inline-block;
    position:relative;
    margin: 0 auto;
    padding: 0px;
    margin-top:1px;
    margin-bottom:1px;
    margin-left:1px;
    margin-right:1px;
    border: 0px;
    float:center;
}


/*CENTER NOT STRETCH*/
.team-nav-logo{
    <?php if(!IS_IE){?>
  display: flex;
  <?php }?> ?>
  justify-content: center;
  align-items: center;
  max-height: 49px;
  min-height:30px;
}


</style>

<!-- <div class="container-fluid team-header-content px-0"> -->
<div class="container-fluid team-header-content">

<?php

//$CurrentTitle .= ' - '.$currentTeam;
    
//team logo links

if(NAVBAR_MODE != 3){ ?>
   
	<div class="row py-1">
    	
    		<div class="col px-0 center-block text-center">
    			
                <?php
                sort($teamList); // sort
                for ($i = 0; $i < count($teamList); $i ++) {
                    ?>
        			<div class="team-nav-logo-container">
        				<div class="team-nav-logo">
                			<a href="<?php echo $CurrentPage;?>.php?team=<?php echo urlencode($teamList[$i]) ?>">
                				<img src="<?php echo getTeamLogoUrl($teamList[$i])?>" alt="<?php echo $teamList[$i] ?>" title="<?php echo $teamList[$i] ?>">
                			</a>
            			</div>
        			</div>
        
        		<?php } ?>
        		
        	</div>
    
    </div>
<?php }?>


    
    <div class="row team-nav">
    	<div class="col p-0">
            <nav id ="header-nav" class="nav justify-content-center">
                <a class="nav-item nav-link" href="TeamScoring.php"><?php echo $allScoring ?></a>
                <a class="nav-item nav-link" href="TeamFinance.php"><?php echo $allFinances ?></a>
                <a class="nav-item nav-link" href="TeamRosters.php"><?php echo $allRosters ?></a>
                <a class="nav-item nav-link" href="TeamLines.php"><?php echo $allLines ?></a>
               
                <?php if(FUTURES_ENABLED){?>
				 <a class="nav-item nav-link" href="TeamFutures.php"><?php echo $allProspects ?></a>
				<?php }?>
    			<?php if(TRANSACTIONS_ENABLED){?>
				<a class="nav-item nav-link" href="TeamTransactions.php">Transactions</a>
				<?php }?>
                <a class="nav-item nav-link" href="TeamOverview.php"><?php echo $allTeamCard ?></a>
                <a class="nav-item nav-link" href="TeamSchedule.php"><?php echo $schedTitle ?></a>
            </nav>
        </div>
    </div>
</div>



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


