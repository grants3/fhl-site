<style>
/* navbar padding */
/* body.fhlElement{ */
/*     margin-top: 50px;  */
/* } */

    #main-navbar.navbar {
        height: 50px;
      }

#main-navbar.navbar {
	padding: .1rem .2rem
}

#main-navbar.navbar-dark {
	font-size: 15px; color: #fff; text-transform: uppercase;
	color: #4C96D7; color: rgba(182,219,251, 0.8);
}

#main-navbar .navbar-brand{
/* 	width: 200px; */
/* 	background: none; */
/* 	border: 0; */
/* 	text-indent: 0; */
	
	font-size: 15px; color: #fff; text-transform: uppercase;
	color: #4C96D7; color: rgba(182,219,251, 0.8);
	
	padding-top: .1125rem;
    padding-bottom: .1125rem;
}

#main-navbar .btn-secondary{
    background: #444;
}

#main-navbar .btn {
    padding: .1rem .2rem;
    margin-bottom: .1rem
}

/***** adjust for nav size *****/
#main-navbar{
    min-height: 45px;
}

#main-navbar .btn-outline-primary:hover {
    color: #fff;
    background-color: #444;
    border-color: var(--color-primary-2);
}
#main-navbar .btn-outline-primary {
    color: #fff;
    background-color: #444;
    border-color: var(--color-primary-2);
}


<?php if($navbarMode == 3 || $navbarMode == 4){
//need to override color for smaller nav bar as unable to read text.?>
:root {
  --team-header-background-color-1:var(--color-primary-1); 
}
<?php }?>

 /* need to modify size of icon */
#main-navbar .navbar-brand {
    padding-top: .02rem;
    padding-bottom: .02rem;
    background-size: 40%;
}


</style>
 
  <!-- Top menu -->
<!-- 	<nav class="navbar navbar-dark fixed-top navbar-expand-lg navbar-no-bg" id="main-navbar"> -->
	<nav class="navbar navbar-expand-lg navbar-dark sticky-top navbar-no-bg" id="main-navbar">
		<div class="container">
			<a class="navbar-brand" href="<?php echo BASE_URL?>">HOME</a>

			<!-- only display for team pages -->
			<?php if($navbarMode == 3 && str_starts_with($CurrentPage, 'Team')){?>

			<div>
    			<select class="btn-outline-primary my-1 py-1 pr-4" onchange="location = this.value;">
    
                 <?php 
                 
                     $navLink = $CurrentPage == 'Home' ? '' : $CurrentPage.'.php';
                 
     				for($i=0;$i<count($teamList);$i++)
     				{
     				    $navTeamSelected = $currentTeam === $teamList[$i] ? 'selected' : '';
     				    
     				    echo '<option '.$navTeamSelected.' id="nav-team-'.$teamList[$i].'" value="'.$navLink.'?'.'team='.$teamList[$i].'">'.$teamList[$i].'</a>';
     				}
                 ?>
                </select>

            </div>

			<?php }?>
			
		</div>
	</nav>
	