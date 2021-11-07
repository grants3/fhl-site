
<?php 

if(!isset($seasonId)) $seasonId = '';
if(!isset($seasonType)) $seasonType = 'REG';
?>

<div class="row no-gutters justify-content-left ">
	<div class="col col-md-8 col-lg-6">
		<div class="row no-gutters">
			<div class="col py-1 pr-1">
				<div class="input-group">
					<div class="input-group-prepend">
						<label class="input-group-text" for="seasonMenu">Season</label>
					</div>

					<?php 	
					$currentSeason = $seasonId ? $seasonId : 'Current';
					?>
					<select class="col custom-select" id="seasonMenu">
						<option <?php echo ($currentSeason == 'Current' ? 'selected' : '');?> <?php echo ($currentSeason == 'Current' && $seasonType == 'PLF' && !PLAYOFF_MODE ? 'disabled' : '');?> value="Current">Current</option>
						<?php 
						//get seasons which will be used to populate previous season dropdown if they exist
						$previousSeasons = getPreviousSeasons(CAREER_STATS_DIR);
					

						if (!empty($previousSeasons)) {
						    foreach ($previousSeasons as $prevSeason) {
						        echo '<option '.($currentSeason == $prevSeason ? 'selected' : '').' value='.$prevSeason.'>'.$prevSeason.'</option>';
						    }
						}
					
						?>
					</select>
				</div>
			</div>


			<div class="col py-1">
				<div class="input-group">
					<div class="input-group-prepend">
						<label class="input-group-text" for="typeMenu">Type</label>
					</div>
					<select class="custom-select" id="typeMenu">
                            <?php 
                            $currentType = $seasonType ? $seasonType : 'REG';
                            if(PLAYOFF_MODE && !$seasonType && !$seasonId){
                                echo '<option value=REG>Regular</option>';
                                echo '<option selected value=PLF>Playoffs</option>';
                            }else if(!PLAYOFF_MODE && !$seasonType && !$seasonId){
                                echo '<option selected value=REG>Regular</option>';
                                echo '<option disabled value=PLF>Playoffs</option>';
                            }else{
                                echo '<option '.($currentType == 'REG' ? 'selected' : '').' value=REG>Regular</option>';
                                echo '<option '.($currentType == 'PLF' ? 'selected' : '').' value=PLF>Playoffs</option>';
                            }

                            ?>
					</select>
				</div>
			</div>

		</div>
	</div>
</div>