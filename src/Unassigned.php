<?php
$LOAD_DT_SCRIPTS = 1; //require datatables import

require_once 'config.php';
include 'lang.php';
$CurrentHTML = 'Unassigned.php';
$CurrentTitle = $langUnassignedPlayers;
$CurrentPage = 'Unassigned';
include 'head.php';

include_once 'common.php';

$fileName = getCurrentLeagueFile('Unassigned');
$OrigHTML = $fileName;

$sort = 16;
$position = '';
?>

<style>

 #faTable { 
   display:none;  
 } 

</style>

	<div class = "container px-0">
		
    	<div class = "card">
    		<?php include 'SectionHeader.php';?>
    		<div class = "card-body p-1">
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
          								<option value=""><?php echo $positionAll?></option>
    									<option value="Skaters"><?php echo $positionSkaters?></option>
            							<option value="Forwards"><?php echo $positionForwards?></option>
            							<option value="C"><?php echo $positionC?></option>
            							<option value="RW"><?php echo $positionRW?></option>
            							<option value="LW"><?php echo $positionLW?></option>
            							<option value="D"><?php echo $positionD?></option>
            							<option value="G"><?php echo $positionGoalie?></option>
    								</select>
    							</div>
    						</div>
    					</div>
                	</div>
                	
                	<div class = "row"> 
                		<?php 
                		        
                		        echo '<div class="col px-0 px-md-2 px-lg-3">';
                		        echo '<table id="unassigned-table" class="table table-sm table-striped nowrap show " style="width:100%">';
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
                		        
                		      
                		        echo '</tbody>';
                		        echo '</table>';
                		        echo '</div>';
                		        
                	
                		?>
                		
                	</div>
            	</div>
    		</div>
    	</div>
	

	
	</div>
	
	
<script>

<?php //if($position){?>
	//needs to be set before datatable initializes
	//$("#positionInputField option[value=D]").attr('selected', 'selected');

<?php // }?>

$(function() {
	var table = $('#unassigned-table').DataTable({
		//dom: 'lftBip',
		dom:'<"row no-gutters"<"col-sm-12 col-md-4"l><"col-sm-12 col-md-8"f>><ti><"row no-gutters"<"col-sm-12 col-md-8"p><"col-sm-12 col-md-4"B>>',
		"processing":false,
		"serverSide":true,  
		"responsive": true,
		searchDelay: 500,
		scrollY:        true,
        scrollX:        true,
        scrollCollapse: false,
        fixedColumns:   {
            leftColumns: 1
        },
		"lengthMenu": [[25, 50, 100, 200, -1], [25, 50, 100, 200, "All"]],
        language: {
            <?php if(LEAGUE_LANG == 'FR') echo 'url: \''.BASE_URL.'assets/other/dt.lang.fr\','?>
        },   
		"order": [[ "<?php echo $sort?>", "desc" ]],
       
        "searchCols": [
            null,
            null,
             <?php if($position){?>
            { "search": "<?php echo $position;?>"},
                <?php }else{ echo 'null,';}?>
          ],
    
		
		"ajax": {
			url : '<?php echo 'api?api=unassigned&action=find&seasonType='.LEAGUE_MODE; ?>',
				type: "GET"  
			},
            "columns": [
                    { name: "name" ,"data": "name" },
                	{ name: "age" ,"data": "age", "orderSequence": [ "desc","asc" ] },
                    { name: "position" ,"data": "position" },
                    { name: "it" ,"data": "it", "orderSequence": [ "desc","asc" ] },
                    { name: "sp" ,"data": "sp", "orderSequence": [ "desc","asc" ] },
                    { name: "st" ,"data": "st", "orderSequence": [ "desc","asc" ] },
                    { name: "en" ,"data": "en", "orderSequence": [ "desc","asc" ] },
                    { name: "du" ,"data": "du", "orderSequence": [ "desc","asc" ] },
                    { name: "di" ,"data": "di" , "orderSequence": [ "desc","asc" ]},
                    { name: "sk" ,"data": "sk" , "orderSequence": [ "desc","asc" ]},
                    { name: "pa" ,"data": "pa" , "orderSequence": [ "desc","asc" ]},
                    { name: "pc" ,"data": "pc" , "orderSequence": [ "desc","asc" ]},
                    { name: "df" ,"data": "df" , "orderSequence": [ "desc","asc" ]},
                    { name: "sc" ,"data": "sc" , "orderSequence": [ "desc","asc" ]},
                    { name: "ex" ,"data": "ex" , "orderSequence": [ "desc","asc" ] },
                    { name: "ld" ,"data": "ld" , "orderSequence": [ "desc","asc" ] },
                    { name: "ov" ,"data": "ov" , "orderSequence": [ "desc","asc" ]},

                ],
			"columnDefs":[  
				{  
// 					"targets":[0],  
// 					"orderable":false,
				},  

			],
			"initComplete": function () {
		        	
		        },
		    "buttons": [
		        	'copy',
		            {
		                extend: 'excel',
		                title: 'Unassigned',
		                className: 'btn btn-primary',
		                exportOptions: {
		                    modifier: {
		                    	order : 'current', // 'current', 'applied','index', 'original'
		                        page : 'all', // 'all', 'current'
		                        search : 'applied' // 'none', 'applied', 'removed' 
		                    }
		                }
			                
		            },
		            {
		                extend: 'csv',
		                title: 'Unassigned',
		                exportOptions: {
		                    modifier: {
		                    	order : 'current', // 'current', 'applied','index', 'original'
		                        page : 'all', // 'all', 'current'
		                        search : 'applied' // 'none', 'applied', 'removed' 
		                    }
		                }
		            }
		        ]
		            
		         
		});

        $("#positionInputField").on('change', function() {  
            var pos = $(this).val();
            if(pos == 'Skaters'){
            	table.column('position:name').search('[C]|[RW]|[LW]|[D]', true, false).draw();
            }else if(pos == 'Forwards'){
            	table.column( 'position:name' ).search('[C]|[RW]|[LW]', true, false).draw();
            }else{
            	table.column('position:name').search(pos).draw() ; 
            }    
            
        } );

	});
	

</script>


<?php include 'footer.php'; ?>