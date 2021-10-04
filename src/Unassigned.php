<?php
$dataTablesRequired = 1; //require datatables import

require_once 'config.php';
include 'lang.php';
$CurrentHTML = 'Unassigned.php';
$CurrentTitle = $langUnassignedPlayers;
$CurrentPage = 'Unassigned';
include 'head.php';

include_once 'common.php';
?>

<style>

 #faTable { 
   display:none;  
 } 

</style>

	<div class = "container"">
		
    	<div class = "card">
    		<?php include 'SectionHeader.php';?>
    		<div class = "card-body p-2">
    			<div class="container">
                	
                	<div class="row py-2" id="searchFields">
    					<div class="col px-0 px-md-2 px-lg-3">
    						<!-- position -->
    						 <div class="row">
    							<div class="input-group mb-3 col-sm-6">
    								<div class="input-group-prepend">
    									<label class="input-group-text" for="positionInputField">Position</label>
    								</div>
    								<select class="custom-select" id="positionInputField">
    									<option value="">All Players</option>
    									<option value="Skaters">All Skaters</option>
    									<option value="Forwards">All Forwards</option>
    									<option value="C">Center</option>
    									<option value="RW">Right Wing</option>
    									<option value="LW">Left Wing</option>
    									<option value="D">Defense</option>
    									<option value="G">Goalie</option>
    								</select>
    							</div>
    						</div>
    					</div>
                	</div>
                	
                	<div class = "row"> 
                	<?php
                
                    $Fnm = getLeagueFile($folder, $playoff, 'Unassigned.html', 'Unassigned');
                		
                		$a = 0;
                		$i = 0;
                		if (file_exists($Fnm)) {
                		    $tableau = file($Fnm);
                		    while(list($cle,$val) = myEach($tableau)) {
                		        $val = utf8_encode($val);
                		        if(substr_count($val, '</PRE>')) {
                		            $a = 0;
                		        }
                		        if($a == 1) {
                		            $reste = trim($val);
                		            $unassignedOV[$i] = substr($reste, strrpos($reste, ' '));
                		            $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                		            $unassignedLD[$i] = substr($reste, strrpos($reste, ' '));
                		            $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                		            $unassignedEX[$i] = substr($reste, strrpos($reste, ' '));
                		            $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                		            $unassignedSC[$i] = substr($reste, strrpos($reste, ' '));
                		            $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                		            $unassignedDF[$i] = substr($reste, strrpos($reste, ' '));
                		            $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                		            $unassignedPC[$i] = substr($reste, strrpos($reste, ' '));
                		            $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                		            $unassignedPA[$i] = substr($reste, strrpos($reste, ' '));
                		            $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                		            $unassignedSK[$i] = substr($reste, strrpos($reste, ' '));
                		            $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                		            $unassignedDI[$i] = substr($reste, strrpos($reste, ' '));
                		            $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                		            $unassignedDU[$i] = substr($reste, strrpos($reste, ' '));
                		            $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                		            $unassignedEN[$i] = substr($reste, strrpos($reste, ' '));
                		            $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                		            $unassignedST[$i] = substr($reste, strrpos($reste, ' '));
                		            $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                		            $unassignedSP[$i] = substr($reste, strrpos($reste, ' '));
                		            $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                		            $unassignedIT[$i] = substr($reste, strrpos($reste, ' '));
                		            $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                		            $unassignedPO[$i] = trim(substr($reste, strrpos($reste, ' ')));
                		            $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                		            $unassignedAG[$i] = substr($reste, strrpos($reste, ' '));
                		            $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                		            $unassignedPL[$i] = $reste;
                		            $i++;
                		        }
                		        if(substr_count($val, '<PRE>Player')) {
                		            $a = 1;
                		        }
                		    }
                		    if(isset($unassignedPL)) {
                		        
                		        echo '<div class="col px-0 px-md-2 px-lg-3">';
                		        echo '<table id="faTable" class="table table-sm table-striped nowrap show " style="width:100%">';
                		          echo '<thead>
                                            <tr>
                                                <th>'.$rostersName.'</th>
                                                <th>Age</th>
                                    			<th>PO</th>
                                                <th>'.$rostersIT.'</th>
                                                <th>'.$rostersSP.'</th>
                                                <th>'.$rostersST.'</th>
                                                <th>'.$rostersEN.'</th>
                                                <th>'.$rostersDU.'</th>
                                                <th>'.$rostersDI.'</th>
                                                <th>'.$rostersSK.'</th>
                                                <th>'.$rostersPA.'</th>
                                                <th>'.$rostersPC.'</th>
                                                <th>'.$rostersDF.'</th>
                                                <th>'.$rostersOF.'</th>
                                                <th>'.$rostersEX.'</th>
                                                <th>'.$rostersLD.'</th>
                                                <th>'.$rostersOV.'</th>
                
                                			</tr>
                                        </thead>';
                		        echo '<tbody style="font-weight:normal">';
                		        
                		        for ($x = 0; $x < $i; $x++) {
                		            echo '<tr>';
                		            
                		            $scoringNameSearch = htmlspecialchars($unassignedPL[$x]);
                		            $scoringNameLink = 'http://www.google.com/search?q='.$scoringNameSearch.'%nhl.com&btnI';
                		            
                		            // 		            echo '<td class="text-left">'.$unassignedPL[$x].'</td>';
                		            echo '<td class="text-left"><a href="'.$scoringNameLink.'">'.$unassignedPL[$x].'</a></td>';
                		            echo '<td>'.$unassignedAG[$x].'</td>';
                		            echo '<td>'.$unassignedPO[$x].'</td>';
                		            echo '<td>'.$unassignedIT[$x].'</td>';
                		            echo '<td>'.$unassignedSP[$x].'</td>';
                		            echo '<td>'.$unassignedST[$x].'</td>';
                		            echo '<td>'.$unassignedEN[$x].'</td>';
                		            echo '<td>'.$unassignedDU[$x].'</td>';
                		            echo '<td>'.$unassignedDI[$x].'</td>';
                		            echo '<td>'.$unassignedSK[$x].'</td>';
                		            echo '<td>'.$unassignedPA[$x].'</td>';
                		            echo '<td>'.$unassignedPC[$x].'</td>';
                		            echo '<td>'.$unassignedDF[$x].'</td>';
                		            echo '<td>'.$unassignedSC[$x].'</td>';
                		            echo '<td>'.$unassignedEX[$x].'</td>';
                		            echo '<td>'.$unassignedLD[$x].'</td>';
                		            echo '<td>'.$unassignedOV[$x].'</td>';
                		            echo '</tr>';        
                		        } 
                		        echo '</tbody>';
                		        echo '</table>';
                		        echo '</div>';
                		        
                		    }else {
                		        echo $langUnassignedPlayersNotFound;
                		    }
                
                		}
                		else echo $allFileNotFound.' - '.$Fnm;
                		?>
                		
                	</div>
            	</div>
    		</div>
    	</div>
	

	
	</div>

	<script>

// 	window.onload = function () {
// 		makeTableSortable('freeAgents');
// 	};


	var table = $('#faTable').DataTable({
		//dom: 'lftBip',
		dom:'<"row"<"col-sm-12 col-md-4"l><"col-sm-12 col-md-8"f>><ti><"row"<"col-sm-12 col-md-8"p><"col-sm-12 col-md-4"B>>',
		scrollY:        true,
        scrollX:        true,
        scrollCollapse: true,
        order: [[ 16, "desc" ]],
        fixedColumns:   {
            leftColumns: 1,
            rightColumns: 1
        },
        paging:         true,
        pagingType: "simple_numbers",
        lengthMenu: [[25, 50, 100, 200, -1], [25, 50, 100, 200, "All"]],
        language: {
            "lengthMenu": "Display _MENU_ records"
        },   
        search: {
            "regex": true
          },    
        initComplete: function () {
        	$("#faTable").show(); 
        },
        
        buttons: [
        	'copyHtml5',
            {
                extend: 'excelHtml5',
                title: 'UnassignedExport'
            },
            {
                extend: 'csvHtml5',
                title: 'UnassignedExport'
            }
        ]
        
	});


    $("#positionInputField").on('change', function() {  
        var pos = $(this).val();
        if(pos == 'Skaters'){
        	table.column(2).search('^(?=.*?(C|RW|LW|D)).*?', true, false).draw();
        }else if(pos == 'Forwards'){
        	table.column(2).search('^(?=.*?(C|RW|LW)).*?', true, false).draw();
        }else{
        	table.column(2).search(pos).draw() ; 
        }    
        
    } );



	</script>

<?php include 'footer.php'; ?>