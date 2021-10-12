 <?php 
 
 if (!function_exists('isPic')){
     function isPic($url){
         $url = get_headers($url,1);
         if(is_array($url['Content-Type'])){ //In some responses Content-type is an array
             $video = strpos($url['Content-Type'][1],'image/png');
         }else{
             $video = strpos($url['Content-Type'],'image/png');
         }
         if($video !== false)
             return true;
             
             return false;
     }
 }
 
 if (!function_exists('getProfilePhoto')){
     function getProfilePhoto($csName){
         
         $csNametmp = strtolower($csName);
         $csNametmp = str_replace(' ', '-', $csNametmp);
         $csNametmpFirst = substr($csNametmp, 0, 1);
         
         $imgUrl = 'http://assets1.sportsnet.ca/wp-content/uploads/players/nhl/'.$csNametmpFirst.'/'.$csNametmp.'.png';

         return $imgUrl;
     }
 }
 
 
 
 ?>
	
	<?php 
	/*USAGE
	 *
	 * usage example: includeWithVariables('component/ScoringLeaderTemplate.php',array('scoringArray' => $scoringArray, 'type' => '$type', 'sort'=>'$sort'));
	 */
	
	
	if(!isset($scoringArray)) return;
	if(!isset($attribute)) return;
	if(!isset($sort)) return;
	if(!isset($positionType)) $positionType = null; //dont filter
	
	if(!$scoringArray){
	    
	    echo '<h5>The season has not started</h5>';
	    
	    return;
	}
	
	//$attribute = strtolower($attribute);
	$imageLink = getProfilePhoto($scoringArray[0]->getName());
	$unknownImageLink = getBaseUrl().'assets/img/unknown-player.png';
	$playerCareersLink = getBaseUrl().'CareerStatsPlayer.php?csName='.htmlspecialchars_decode($scoringArray[0]->getName());
	?>
	
	<div style="display: flex;">

      	<div class="top-player-details">
      		<div class="card border-0" style="width: 13rem; padding-top:25px">
      		  <div class="row no-gutters text-center mx-auto d-block">
              	<img id= "top-player-img-<?php echo $attribute.$positionType?>" data-img-url="<?php echo $imageLink;?>"
              		 onerror="if(this.src='<?php echo $unknownImageLink;?>'); this.src='<?php echo $unknownImageLink;?>';"
              		 class="card-img-top playerImageLogo border-light" src="<?php echo $unknownImageLink;?>" alt="<?php echo $scoringArray[0]->getName();?>">
              </div>
              <div class="card-body text-center pt-1">
              	<div id="top-player-info-<?php echo $attribute.$positionType?>" class="bvjVjv"> <!-- player details -->
        			<a href="<?php echo $playerCareersLink;?>">
        				<div class="statPlayerNumber hHORBn">
        					<span class="gPPmv">#</span><?php echo $scoringArray[0]->getNumber();?>
        				</div>
        				<div class="statPlayerName jPZtbn text-center">
        				<?php $nameExploded = explode(" ", $scoringArray[0]->getName());?>
        					<span style="float:left; clear:left"><?php echo $nameExploded[0];?></span><span style="float:left; clear:left"><?php echo $nameExploded[1];?></span>
        
        				</div>
        			</a>
        			<a id="top-player-team-info-<?php echo $attribute.$positionType?>" href="<?php echo $playerCareersLink;?>"
        				class="styles__TeamNameContainer-sc-16cx6ic-7 cWNqKo">
        				<span class="statPlayerTeamName izUOIu"><?php echo $scoringArray[0]->getTeam();?></span>
        				<span class="statPlayerPosition"><?php echo $scoringArray[0]->getPosition();?></span>
        			</a>
                    <div id= "top-player-value-<?php echo $attribute.$positionType?>" class="styles__StatDetails-sc-16cx6ic-9 glDXkE">
            			<p style="margin-bottom:5px" class="styles__StatCategoryName-sc-16cx6ic-10 KRrDV text-uppercase"><?php echo ucwords($attribute);?></p>
            			<p  style="font-size:4em; font-weight:800; line-height:45px" 
            				class="statCategoryValue m-0 "><?php echo $scoringArray[0]->__get($attribute) ?></p>
            		</div>
        		</div>
              </div>
            </div>
      	</div>
		<div class="ANxrZ">
      		<div id = "top-leader-list-<?php echo $attribute.$positionType;?>" class="top-leader-list cOAcdw">
				<ul class="styles__LeaderList-owf6ne-5 ANxrZ" id="scoring-leaders-list-<?php echo $attribute;?>">
        			<?php 
        			foreach ($scoringArray as $skater) {
        			
        			?>
        			<li class="styles__LeaderListItem-owf6ne-6 eTUABY" 
        			data-img-list-url="<?php echo getProfilePhoto($skater->getName());?>"
        			data-img-list-name="<?php echo $skater->getName();?>"
        			data-img-list-team="<?php echo $skater->getTeam();?>"
        			data-img-list-pos="<?php echo $skater->getPosition();?>"
        			data-img-list-number="<?php echo $skater->getNumber();?>"
        			data-img-list-value="<?php echo $skater->__get($attribute);?>">
        				<span><?php echo $skater->getName();?></span><span><?php echo $skater->__get($attribute);?></span>
        			</li>
        					
        			<?php }?>
        
        		</ul>
        		<a class="styles__LeadersNavLink-owf6ne-8 bvgUsd" href="<?php echo getBaseUrl().'PlayerScoring.php?sort='.$sort;?>">All Leaders</a>
	
			</div>
		</div>
	</div>
<script>



$(function() {
	//init
	var playerImgLink = $("#top-player-img-<?php echo $attribute.$positionType?>").data('img-url');
    
    if (playerImgLink != null){
        $("#top-player-img-<?php echo $attribute.$positionType?>").attr("src", playerImgLink).fadeTo(400,1);
	}
	
	$("#top-leader-list-<?php echo $attribute.$positionType;?> li:first").css({ 'font-weight': 'bold' });

	//on change
	$("#top-leader-list-<?php echo $attribute.$positionType;?>").on("click", ".eTUABY", function(event){
    	 //alert(event.target.data-img-url);
   
	    $("#top-leader-list-<?php echo $attribute.$positionType;?> li").each(function(idx, li) {
            var product = $(li);
			
			product.css({ 'font-weight': 'normal' });
        });
        
        $(this).css({ 'font-weight': 'bold' });
        
        var playerName = $(this).attr("data-img-list-name");
        var playerImgLink = $(this).attr("data-img-list-url");
        var playerTeam = $(this).attr("data-img-list-team");
        var playerPosition = $(this).attr("data-img-list-pos");
        var playerNumber = $(this).attr("data-img-list-number");
        var playerStatValue = $(this).attr("data-img-list-value");

    	if (playerImgLink != null){
            $("#top-player-img-<?php echo $attribute.$positionType?>").attr("src", playerImgLink);
    	}
    	
    	if (playerName != null){
    		var playerNameArray = playerName.split(/(\s+)/);
            $("#top-player-info-<?php echo $attribute.$positionType?> .statPlayerName span:first-child").text(playerNameArray[0]);
            $("#top-player-info-<?php echo $attribute.$positionType?> .statPlayerName span:last-child").text(playerNameArray[2]);
    	}
    	
    	if (playerNumber != null){
            $("#top-player-info-<?php echo $attribute.$positionType?> .statPlayerNumber").text('#'+playerNumber);
    	}
    	
    	if (playerTeam != null){
            $("#top-player-team-info-<?php echo $attribute.$positionType?> .statPlayerTeamName").text(playerTeam);
    	}
    	
    	if (playerPosition != null){
            $("#top-player-team-info-<?php echo $attribute.$positionType?> .statPlayerPosition").text(playerPosition);
    	}
    	
    	if (playerStatValue != null){
            $("#top-player-value-<?php echo $attribute.$positionType?> .statCategoryValue").text(playerStatValue);
    	}

	});
});




</script>


