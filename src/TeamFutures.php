<?php
require_once 'config.php';
include_once 'lang.php';
include_once 'fileUtils.php';

$CurrentHTML = 'TeamFutures.php';
$CurrentTitle = $prospectsTitle;
$CurrentPage = 'TeamFutures';

$Fnm = getCurrentLeagueFile('Futures');
$OrigHTML = $Fnm;

include 'head.php';
include 'TeamHeader.php';
?>

<!--<h3 class = "text-center"><?php echo $prospectsTitle.' - '.$currentTeam ?></h3>-->



<?php


$a = 0;
$b = 0;
$c = 1;
$d = 1;
$yearCount = 0;
$lastUpdated = '';

$propects = array();
$picks = array();
if(file_exists($Fnm)) {
    $tableau = file($Fnm);
    while(list($cle,$val) = myEach($tableau)) {
        $val = encodeToUtf8($val);
        if(substr_count($val, '<P>(As of')){
            $pos = strpos($val, ')');
            $pos = $pos - 10;
            $val = substr($val, 10, $pos);
            $lastUpdated = $val;
            
        }
        if(substr_count($val, 'A NAME=') && $b) {
            $d = 0;
        }
        if(substr_count($val, 'A NAME='.$currentTeam) && $d) {
            $pos = strpos($val, '</A>');
            $pos = $pos - 23;
            $equipe = trim(substr($val, 23, $pos));
            $b = 1;
        }
        if($a >= 2 && $a <= 7 && substr_count($val, '<B>') && $b && $d) {
            if($c == 1) $c = 2;
            else $c = 1;
            
            $yearCount++;
            if($yearCount <= FUTURES_DRAFT_YEARS){
                $year = trim(substr($val, strpos($val, ':')+1, strpos($val, '</B>')-1-strpos($val, ':')-1));
                $draft = trim(substr($val, strpos($val, '</B>')+4, strpos($val, '<BR>')-strpos($val, '</B>')-4));
                
                array_push($picks, array($year, $draft));
                
                $pos = strpos($val, '<BR>');
                $pos = $pos - 19;

            }
            
            $a++;
        }
        if($a == 1 && $b && $d) {
            $pos = strpos($val, '<');
            $tmpProspect = substr($val, 0, $pos).',';
            $tmpCount = substr_count($tmpProspect, ',');
            for($i=0;$i<$tmpCount;$i++) {
                if($c == 1) $c = 2;
                else $c = 1;
                $tmp = trim(substr($tmpProspect, 0, strpos($tmpProspect, ',')));
                $tmpProspect = substr($tmpProspect, strpos($tmpProspect, ',')+1);
                
                array_push($propects, $tmp);

            }

            $a = 2;
            $c = 1;
        }
        if(substr_count($val, '<H4>Prospects</H4>') && $b && $d) {
            $a = 1;
        }
        
    }

}
?>

<div class = "container px-0">

	<div class="card">

    	<div class="card-header p-1">
    	
    		 <?php include 'TeamCardHeader.php'; ?>
    	
    	</div>
    	<div class="card-body">
    		<div class="row">
    			<div class = "col-sm-12 col-md-6">
    			
    				<h5 class="tableau-top titre" style = "padding-top:5px; padding-bottom:5px"><?php echo $prospectsTitle;?></h5>
    				<table class="table table-sm table-striped table-rounded-bottom">
    					<thead>
    						<tr class="tableau-top">
    							<th colspan=2 class="text-left"><?php echo $rostersName;?></th>
    						</tr>
    					</thead>
    					<tbody>
						
							<?php 
							$i = 0;
							foreach ($propects as $prospect) {
							    
							    // Choose between hockeyDB : 1 or EliteProspect : 2 | $leagueFuturesLink
							    if(FUTURES_LINK_MODE == 1) $tmpLink = strtolower(str_replace(' ', '+', $prospect));
							    if(FUTURES_LINK_MODE == 2) $tmpLink = strtolower(str_replace(' ', '+', $prospect));
							    if(FUTURES_LINK_MODE == 1) $hockeyFutureLink = 'http://www.hockeydb.com/ihdb/stats/findplayer.php?full_name='.$tmpLink;
							    if(FUTURES_LINK_MODE == 2) $hockeyFutureLink = 'http://www.eliteprospects.com/search/player?q='.$tmpLink;
							    
							    if($i == 0){
							        echo '<tr>';
							        //echo '<td class="text-center">'.$prospect.'</td>';
							        echo '<td class="text-left"> <a style="display:block; width:100%;" href="'.$hockeyFutureLink.'" >'.$prospect.'</a></td>';
						
							        $i++;
							    }else{
							        //echo '<td class="text-center">'.$prospect.'</td>';
							        echo '<td class="text-left"> <a style="display:block; width:100%;" href="'.$hockeyFutureLink.'" >'.$prospect.'</a></td>';
							        
							        
							        echo '</tr>';
							        
							        $i = 0;
							    }
		
							}
							
							//in case tr was not closed because of uneven columns
							if($i > 0){
							    echo '<td></td></tr>';
							}
							
							?>

    					</tbody>			
    				</table>
    			
    			
    			</div>
    			
    			<div class = "col-sm-12 col-md-6">
    			
    				<h5 class="tableau-top titre" style = "padding-top:5px; padding-bottom:5px"><?php echo $prospectsDraft;?></h5>
    				<table class="table table-sm table-striped table-rounded-bottom" style="white-space:normal;">
    					<thead>
    						<tr class="tableau-top">
    							<th class="text-center"><?php echo $prospectYear;?></th>
    							<th class="text-left"><?php echo $prospectPicks;?></th>
    						</tr>
    					</thead>
    					<tbody>
						
							<?php 
							foreach ($picks as $pickyear) {
							    echo '<tr>';
							    echo '<td class="text-center">'.$pickyear[0].'</td>';
							    echo '<td class="text-left">'.$pickyear[1].'</td>';
							    echo '</tr>';
							}
							?>

    					</tbody>			
    				</table>
    			
    			
    			</div>
    		
    		</div>
    	</div>
    	
    	<?php 
        	if(isset($lastUpdated)){
        	    
        	    echo '<h5 class = "text-center">'.$allLastUpdate.' '.$lastUpdated.'</h5>';
        	}
    	    
    	?>

	</div>
</div>





<?php include 'footer.php'; ?>
