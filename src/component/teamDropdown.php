<?php

/*
 * Example call
 * includeWithVariables('component/teamDropdown.php',array('teamList' => $teamList, 'teamDropdownPrefix' => 'roster', 'CurrentPage' => $CurrentPage));
 * 
 */

if(!isset($teamList)) return;
if(!isset($teamDropdownPrefix)) return;
if(!isset($CurrentPage)) return;
if(!isset($links)){
    $links = '';
}

?>



<div class="row">
	<div class="col-sm-12 col-md-6 col-lg-4 offset-md-6 offset-lg-8" style="display: flex;">
		<div class="input-group">
<!-- 			<div class="input-group-prepend"> -->
<!-- 				<span class="input-group-text" id="teamMenuHeader">Team</span> -->
<!-- 			</div> -->

<!-- 			<select class="form-control" aria-label="Select Season" -->
<!-- 				id="seasonMenu" aria-describedby="seasonMenuHeader"> -->
				<?php 
                
// 				sort($teamList);
// 				for($i=0;$i<count($teamList);$i++) {
// 				    echo '<option value='.$teamList[$i].'>'.$teamList[$i].'</option>';
// 				}
			
// 				?>
<!-- 			</select> -->

            <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Select Team
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              
              	<?php 
                
				sort($teamList);
				for($i=0;$i<count($teamList);$i++) {
				    echo '<a class="dropdown-item" id="'.$teamDropdownPrefix.$teamList[$i].'" href="'.$CurrentPage.'.php?'.$links.'team='.$teamList[$i].'">'.$teamList[$i].'</a>';
				}
			
 				?>
              
              	
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="/">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
              </div>
            </div>
		</div>
	</div>
</div>