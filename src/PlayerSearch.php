<?php
$dataTablesRequired = 1; //require datatables import

require_once 'config.php';
include 'lang.php';
$CurrentHTML = 'PlayerSearch.php';
$CurrentTitle ='Player Search';
$CurrentPage = 'PlayerSearch';
include 'head.php';

include_once 'classes/TeamHolder.php';

$gmFile = getLeagueFile('GMs');
$teams = new TeamHolder($gmFile);

?>

<style>

.input-group>.input-group-prepend{
    flex: 0 0 25%;
}

#searchFields .input-group .input-group-text{
    width:100%
}

#advancedSearch .input-group>.input-group-prepend{
    flex: 0 0 30%;
}



</style>

<div class="container px-0" >
	
	<div class="card">
    		<?php include 'SectionHeader.php';?>
    		<div class="card-body p-1">
				<div class="row no-gutters py-2" id="searchFields">
					<div class="col px-0 px-md-2 px-lg-3">

						<!-- position -->
						<div class="row no-gutters">
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

							<!-- team -->
							<div class="input-group mb-3 col-sm-6">
								<div class="input-group-prepend">
									<label class="input-group-text" for="teamInputField"><?php echo $allTeam;?></label>
								</div>
								<select class="custom-select" id="teamInputField">
									<option value="" selected><?php echo $langCareerTeamLeadersAllTeam;?></option>
									<option value="Unassigned"><?php echo $langUnassignedPlayers?></option>
                      				<?php
                                        foreach ($teams->get_teams() as $team) {
                                            echo '<option value="' . $team . '">' . $team . '</option>';
                                        }
                                    ?>

                    		   </select>
							</div>
			
						</div>
						<div class="row no-gutters">
										
							<!-- type -->
							<div class="input-group mb-3 col-sm-6">
								<div class="input-group-prepend">
									<label class="input-group-text" for="typeInputField"><?php echo $seasonType;?></label>
								</div>
								<select class="custom-select" id="typeInputField">
									<option value="ALL">All Types</option>
									<option value="PROFRM" selected>Pro/Farm</option>
									<option value="PRO">Pro</option>
									<option value="FRM">Farm</option>
									<option value="PCT"><?php echo $allProspects;?></option>			
                    		   </select>
							</div>
						</div>
						
						<div class="accordion" id="searchAccordion">
                          <div class="card" id="advancedSearch">
                            <div class="card-header" id="advancedSearchHeader">
                              <h5 class="mb-0 text-center">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseSearch" aria-expanded="false" aria-controls="collapseSearch">
                                  <?php echo $playerSearchMoreFilters?>
                                </button>
                              </h5>
                            </div>
                            <div id="collapseSearch" class="collapse" aria-labelledby="advancedSearchHeader" data-parent="#searchAccordion">
                              <div class="card-body">
                              	<div class="row">
        							<div class="input-group col-6 col-lg-3 offset-lg-3">
        								<div class="input-group-prepend">
        									<span class="input-group-text" id="">IT</span>
        								</div>
        								<input id="itMin" type="text" class="form-control" value = 0> 
        								<input id="itMax" type="text" class="form-control" value = 99>
        							</div>
        							<div class="input-group col-6 col-lg-3">
        								<div class="input-group-prepend">
        									<span class="input-group-text" id="">SP</span>
        								</div> 
        								<input id="spMin" type="text" class="form-control" value = 0> 
        								<input id="spMax" type="text" class="form-control" value = 99>
        							</div>
        						</div>
        						<div class="row pt-1">
        							<div class="input-group col-6 col-lg-3 offset-lg-3">
        								<div class="input-group-prepend">
        									<span class="input-group-text" id="">ST</span>
        								</div>
        								<input id="stMin" type="text" class="form-control" value = 0> 
        								<input id="stMax" type="text" class="form-control" value = 99>
        							</div>
        							<div class="input-group col-6 col-lg-3">
        								<div class="input-group-prepend">
        									<span class="input-group-text" id="">EN</span>
        								</div> 
        								<input id="enMin" type="text" class="form-control" value = 0> 
        								<input id="enMax" type="text" class="form-control" value = 99>
        							</div>
        						</div>
        						<div class="row pt-1">
        							<div class="input-group col-6 col-lg-3 offset-lg-3">
        								<div class="input-group-prepend">
        									<span class="input-group-text" id="">DU</span>
        								</div>
        								<input id="duMin" type="text" class="form-control" value = 0> 
        								<input id="duMax" type="text" class="form-control" value = 99>
        							</div>
        							<div class="input-group col-6 col-lg-3">
        								<div class="input-group-prepend">
        									<span class="input-group-text" id="">DI</span>
        								</div> 
        								<input id="diMin" type="text" class="form-control" value = 0> 
        								<input id="diMax" type="text" class="form-control" value = 99>
        							</div>
        						</div>
        						<div class="row pt-1">
        							<div class="input-group col-6 col-lg-3 offset-lg-3">
        								<div class="input-group-prepend">
        									<span class="input-group-text" id="">SK</span>
        								</div>
        								<input id="skMin" type="text" class="form-control" value = 0> 
        								<input id="skMax" type="text" class="form-control" value = 99>
        							</div>
        							<div class="input-group col-6 col-lg-3">
        								<div class="input-group-prepend">
        									<span class="input-group-text" id="">PA</span>
        								</div> 
        								<input id="paMin" type="text" class="form-control" value = 0> 
        								<input id="paMax" type="text" class="form-control" value = 99>
        							</div>
        						</div>
        						<div class="row pt-1">
        							<div class="input-group col-6 col-lg-3 offset-lg-3" >
        								<div class="input-group-prepend">
        									<span class="input-group-text" id="">PC</span>
        								</div>
        								<input id="pcMin" type="text" class="form-control" value = 0> 
        								<input id="pcMax" type="text" class="form-control" value = 99>
        							</div>
        							<div class="input-group col-6 col-lg-3">
        								<div class="input-group-prepend">
        									<span class="input-group-text" id="">DF</span>
        								</div> 
        								<input id="dfMin" type="text" class="form-control" value = 0> 
        								<input id="dfMax" type="text" class="form-control" value = 99>
        							</div>
        						</div>
        						<div class="row pt-1">
        							<div class="input-group col-6 col-lg-3 offset-lg-3">
        								<div class="input-group-prepend">
        									<span class="input-group-text" id="">SC</span>
        								</div>
        								<input id="scMin" type="text" class="form-control" value = 0> 
        								<input id="scMax" type="text" class="form-control" value = 99>
        							</div>
        							<div class="input-group col-6 col-lg-3">
        								<div class="input-group-prepend">
        									<span class="input-group-text" id="">EN</span>
        								</div> 
        								<input id="enMin" type="text" class="form-control" value = 0> 
        								<input id="enMax" type="text" class="form-control" value = 99>
        							</div>
        						</div>
        						<div class="row pt-1">
        							<div class="input-group col-6 col-lg-3 offset-lg-3">
        								<div class="input-group-prepend">
        									<span class="input-group-text" id="">LD</span>
        								</div>
        								<input id="ldMin" type="text" class="form-control" value = 0> 
        								<input id="ldMax" type="text" class="form-control" value = 99>
        							</div>
        							<div class="input-group col-6 col-lg-3">
        								<div class="input-group-prepend">
        									<span class="input-group-text" id="">OV</span>
        								</div> 
        								<input id="ovMin" type="text" class="form-control" value = 0> 
        								<input id="ovMax" type="text" class="form-control" value = 99>
        							</div>
        						</div>
        						<div class="row pt-1">
        							<div class="input-group col-6 col-lg-3 offset-lg-3">
        								<div class="input-group-prepend">
        									<span class="input-group-text" id="">CT</span>
        								</div>
        								<input id="ctMin" type="text" class="form-control" value = 0> 
        								<input id="ctMax" type="text" class="form-control" value = 5>
        							</div>
<!--         							<div class="input-group col-6 col-lg-4"> -->
<!--         								<div class="input-group-prepend"> -->
<!--         									<span class="input-group-text" id="">SAL</span> -->
<!--         								</div>  -->
<!--         								<input id="salaryMin" type="text" class="form-control" value = 400000>  -->
<!--         								<input id="salaryMax" type="text" class="form-control" value = 15000000> -->
<!--         							</div> -->
        						</div>
        						
        						<div class="row pt-1">
         							<div class="input-group col-sm-12 col-lg-6 offset-lg-3">
        								<div class="input-group-prepend">
        									<span class="input-group-text" id="">SALARY</span>
        								</div> 
        								<input id="salaryMin" type="text" class="form-control" value = 400000> 
        								<input id="salaryMax" type="text" class="form-control" value = 15000000>
        							</div>
        						</div>
        						
        						<button id="btnSearch" class="btn btn-sm btn-outline-primary my-2">Filter</button>
                              
                              
                              </div>
                            </div>
                          </div>
                        </div>    
                            
						

					</div>
				</div>

				<div>
					<table id="tblPlayerSearch" class="table table-sm table-sm-px table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                            	<th class="text-left"><?php echo $rostersName ?></th>
                           	    <th><?php echo $playerSearchTeam?></th>
                           	    <th>Type</th>
								<th>PO</th>
								<th><?php echo $rostersIT ?> </th>
								<th><?php echo $rostersSP ?> </th>
								<th><?php echo $rostersST ?> </th>
								<th><?php echo $rostersEN ?> </th>
								<th><?php echo $rostersDU ?> </th>
								<th><?php echo $rostersDI ?> </th>
								<th><?php echo $rostersSK ?> </th>
								<th><?php echo $rostersPA ?> </th>
								<th><?php echo $rostersPC ?> </th>
								<th><?php echo $rostersDF ?> </th>
								<th><?php echo $rostersOF ?> </th>
								<th><?php echo $rostersEX ?> </th>
								<th><?php echo $rostersLD ?> </th>
								<th><?php echo $rostersOV ?> </th>	 	
								<th>#</th>
								<th>CT</th>
								<th><?php echo $joueursSalary;?></th>
                            </tr>
                        </thead>             
                    </table>
				 </div>
			
		</div>
	</div>
</div>


	<script>
		
		let advancedEnabled = false;
		
        $(document).ready(function() {
        	var table = $('#tblPlayerSearch').DataTable( {
        		dom:'<"row no-gutters"<"col-sm-12 col-md-4"l><"col-sm-12 col-md-8"f>><ti><"row no-gutters"<"col-sm-12 col-md-8"p><"col-sm-12 col-md-4"B>>',
        		"processing":false,
        		"serverSide":true,  
        		"responsive": true,
        		searchDelay: 500,
        		scrollY:        true,
                scrollX:        true,
                scrollCollapse: false,
				"order": [[ "17", "DESC" ]],
                fixedColumns:   {
                    leftColumns: 1
                },
                
                lengthMenu: [[25, 50, 100, 200, -1], [25, 50, 100, 200, "All"]],
                language: {
                    <?php if($leagueLang == 'FR') echo 'url: \''.BASE_URL.'assets/other/dt.lang.fr\','?>
                    
                }, 
                "ajax": {
                	url : '<?php echo 'api?api=search&action=find'; ?>',
    				type: "GET",
    				data: function ( d ) {
    					d.position = $('#positionInputField').find(":selected").val();
                   		d.team = $('#teamInputField').find(":selected").val();
                   		d.type = $('#typeInputField').find(":selected").val();
                   		
                   		if (advancedEnabled) {

							d.advFilter = [
								{data:"it", "min":getMinValue('it'), "max":getMaxValue('it')},
								{data:"sp", "min":getMinValue('sp'), "max":getMaxValue('sp')},
								{data:"st", "min":getMinValue('st'), "max":getMaxValue('st')},
								{data:"en", "min":getMinValue('en'), "max":getMaxValue('en')},
								{data:"du", "min":getMinValue('du'), "max":getMaxValue('du')},
								{data:"di", "min":getMinValue('di'), "max":getMaxValue('di')},
								{data:"sk", "min":getMinValue('sk'), "max":getMaxValue('sk')},
								{data:"pa", "min":getMinValue('pa'), "max":getMaxValue('pa')},
								{data:"pc", "min":getMinValue('pc'), "max":getMaxValue('pc')},
								{data:"df", "min":getMinValue('df'), "max":getMaxValue('df')},
								{data:"sc", "min":getMinValue('sc'), "max":getMaxValue('sc')},
								{data:"en", "min":getMinValue('en'), "max":getMaxValue('en')},
								{data:"ld", "min":getMinValue('ld'), "max":getMaxValue('ld')},
								{data:"ov", "min":getMinValue('ov'), "max":getMaxValue('ov')},
								{data:"ct", "min":getMinValue('ct'), "max":getMaxValue('ct',5)},
								{data:"salary", "min":getMinValue('salary',400000), "max":getMaxValue('salary',15000000)},
							];
                        }
            		}
    			},
    			"columns": [
                        //{ "data": "name" },
                        { "name": "name", "data": "name",
                            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                                $(nTd).html("<a href='CareerStatsPlayer.php?csName="+ encodeURIComponent(oData.name)+"'>"+oData.name+"</a>");
                            }
                        },
                    	{ "name": "team", "data": "team" },
                    	{ "name": "type", "data": "type" },
                        //{ "name": "position", "data": "position" },
                        { "name": "position","data": "position",
                            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            	var pos = oData.position;
                            	
                            	<?php if($leagueLang == 'FR'){?>
                            		if('RW' === pos) pos = 'AD';
                            		if('LW' === pos) pos = 'AG';
                            	<?php }?>
                                $(nTd).html(pos);
                            }
                        },
                        { "name": "it", "data": "it", "orderSequence": [ "desc","asc" ] },
                        { "name": "sp", "data": "sp", "orderSequence": [ "desc","asc" ] },
                        { "name": "st", "data": "st", "orderSequence": [ "desc","asc" ] },
                        { "name": "en", "data": "en", "orderSequence": [ "desc","asc" ] },
                        { "name": "du", "data": "du", "orderSequence": [ "desc","asc" ] },
                        { "name": "di", "data": "di", "orderSequence": [ "desc","asc" ] },
                        { "name": "sk", "data": "sk", "orderSequence": [ "desc","asc" ] },
                        { "name": "pa", "data": "pa", "orderSequence": [ "desc","asc" ] },
                        { "name": "pc", "data": "pc", "orderSequence": [ "desc","asc" ] },
                        { "name": "df", "data": "df", "orderSequence": [ "desc","asc" ] },
                        { "name": "sc", "data": "sc", "orderSequence": [ "desc","asc" ] },
                        { "name": "ex", "data": "ex", "orderSequence": [ "desc","asc" ] },
                        { "name": "ld", "data": "ld", "orderSequence": [ "desc","asc" ]},
                        { "name": "ov", "data": "ov", "orderSequence": [ "desc","asc" ] },
                        { "data": "number", "orderSequence": [ "desc","asc" ] },
                        { "data": "ct", "orderSequence": [ "desc","asc" ] },
                        { "name": "salary", "data": "salary", "orderSequence": [ "desc","asc" ], render: function (data, type, row, meta) {
                        	var sal = row.salary != null ? row.salary : 0;
          					return meta.settings.fnFormatNumber(sal); }}
                	],
                "columnDefs": [
                    { className: "text-left", "targets": [ 0,1,2 ] }
                  ],
                buttons: [
                	'copyHtml5',
                    {
                        extend: 'excelHtml5',
                        title: 'PlayerSearchExport'
                    },
                    {
                        extend: 'csvHtml5',
                        title: 'PlayerSearchExport'
                    }
                ]
            } );

            $('#teamInputField, #typeInputField').change( function() {
                table.draw();
            } );

            $( "#btnSearch" ).click(function() {
            	 table.draw();
            	});
            	
            $("#collapseSearch").on("shown.bs.collapse", function(){
            	advancedEnabled = true;
            });

            $("#collapseSearch").on("hide.bs.collapse", function(){

            	resetSimAttrib('it');
            	resetSimAttrib('sp');
            	resetSimAttrib('st');
            	resetSimAttrib('en');
            	resetSimAttrib('du');
            	resetSimAttrib('di');
            	resetSimAttrib('sk');
            	resetSimAttrib('pa');
            	resetSimAttrib('pc');
            	resetSimAttrib('df');
            	resetSimAttrib('sc');
            	resetSimAttrib('en');
            	resetSimAttrib('ld');
            	resetSimAttrib('ov');
            	resetSimAttrib('ct', 0, 5);
            	resetSimAttrib('salary', 400000,15000000);
            	
            	advancedEnabled = false;
            	
            	table.draw();
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



            
        } );

        function resetSimAttrib(attrib, defaultMin, defaultMax){
        	defaultMin = defaultMin || 0;
        	defaultMax = defaultMax || 99;
        
        	$('#' + attrib + 'Min').val(defaultMin);
			$('#' + attrib + 'Max').val(defaultMax);
        }
        
        function getMinValue(attrib, defaultValue){
        	defaultValue = defaultValue || 0;
        	value = $('#' + attrib + 'Min').val();
        	return value ? value : defaultValue;
        }
        function getMaxValue(attrib, defaultValue){
        	defaultValue = defaultValue || 99;
        	value = $('#' + attrib + 'Max').val();
        	return value ? value : defaultValue;
        }
	</script>

<?php include 'footer.php'; ?>