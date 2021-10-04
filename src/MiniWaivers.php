<?php

require_once 'config.php';
include_once 'lang.php';
include_once 'common.php';
include_once 'classes/WaiversHolder.php';
include_once 'classes/WaiverObj.php';

?>


<div class="container">
	<div class="row">
		<div class="col">
			<div class="table-responsive">
				

                <?php
                $playoff = isPlayoffs($folder, $playoffMode);
                
                if ($playoff == 1)
                    $playoff = 'PLF';
                
                $fileName = getLeagueFile($folder, $playoff, 'Waivers.html', 'Waivers');
                
                if (file_exists($fileName)) {
                    
                    //get waivers from file
                    $waivers = new WaiversHolder($fileName);
                    $results = $waivers->get_waivers();
                    
                    if (isset($results) && !empty($results)) {
                        echo '<table class="table table-sm table-striped">';
                        //create table header
                        echo '<thead><tr>
            			<th>'.$waiversPlayer.'</th>
            			<th>'.$waiversDate.'</th>
            			<th>'.$waiversBy.'</th>
            			<th>'.$waiversClaimed.'</th>
            			</tr></thead>';
                        echo '<tbody>';
                        
                        //create result rows
                        foreach ($results as $waiver) {

                            echo '<tr">';
                                echo '<td>'.$waiver->player.'</td>';
                                echo '<td>'.$waiver->waiveDate.'</td>';
                                echo '<td>'.$waiver->waivedBy.'</td>';
                                echo '<td>'.$waiver->claimedBy.'</td>';
                            echo '</tr>';
                        }
                        echo '</tbody>';
                        echo '</table>';
                    }else{
                        //no waivers
                        echo '<h5>' . $waiversNothing. '</h5>';
                    }
                    

                } else
                    echo '<h5>' . $allFileNotFound . ' - ' . $fileName . '</h5>';
                
                ?>
                
             
			</div>
		</div>
	</div>
</div>
