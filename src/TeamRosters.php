<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once 'config.php';
include 'lang.php';
include_once 'common.php';
include_once 'fileUtils.php';
include_once 'classes/RosterObj.php';
include_once 'classes/RosterAvgObj.php';
include_once 'classes/RostersHolder.php';
include_once 'classes/PlayerVitalObj.php';
include_once 'classes/PlayerVitalsHolder.php';


$CurrentHTML = 'TeamRosters.php';
$CurrentTitle = $rostersTitle;
$CurrentPage = 'TeamRosters';

include 'head.php';
include 'TeamHeader.php';

?>


<div class="container px-0">
	<div class="row2">
	<div class="col2"> 
	<div class="card">
	<div class="card-header p-1">
		<?php include 'TeamCardHeader.php'?>
	</div>
<!--     	<div class="card-body px-2 px-lg-4 pt-3"> -->
		<div class="card-body p-1">
    
                    <?php

                    //$fileName = getLeagueFile($folder, $playoff, 'Rosters.html', 'Rosters');
                    $fileName = getCurrentLeagueFile('Rosters');

                    //$vitalsFileName = getLeagueFile($folder, $playoff, 'PlayerVitals.html', 'PlayerVitals');
                    $vitalsFileName = getCurrentLeagueFile('PlayerVitals');
                    $lastUpdated = '';
                    
                    if (file_exists($fileName) && file_exists($vitalsFileName)) {
                        //get rosters from file
                        $rosters = new RostersHolder($fileName, $currentTeam);
                        $playerVitals = new PlayerVitalsHolder($vitalsFileName, $currentTeam);
                        
        
                        $lastUpdated = $rosters->getLastUpdated();
        
                        if (isset($lastUpdated)) {
                            
                            //echo '<h5>'.$lastUpdated.'</h5>';
                            //echo '<h5 class = "text-center">'.$allLastUpdate.' '.$lastUpdated.'</h5>';
                            
                            echo'<div class="card text-center">';
                            echo'<div id="rosterTabs" class="card-header px-2 px-lg-4 pb-1 pt-2">';
                            echo'<ul class="nav nav-tabs nav-fill">
                                			<li class="nav-item">
                                                <a class="nav-link active" href="#Pro" data-toggle="tab">Pro Roster</a>
                                			</li>
                                			<li class="nav-item">
                                                <a class="nav-link" href="#Farm" data-toggle="tab">Farm Roster</a>
                                			</li>
                                </ul>';
                            echo '</div>';
                            
                            echo '<div class="card-body tab-content p-0 m-0">';
                            
                            $typeArray = array('Pro','Farm');
                            
                            foreach ($typeArray as $rosterType) {

                                $tableId = 'Roster' . $rosterType;
                                $active = ($rosterType == 'Pro' ? ' active' : '');

                                echo'<div class="tab-pane'.$active.'" id="'.$rosterType.'">';
             
                                //create table header
                                echo '<div class="table-responsive">';
                                echo '<table id="'.$tableId.'" class="table table-sm table-striped table-hover fixed-column text-center">';
                                
                                    echo '<thead>
                                        <tr>
                                            <th data-toggle="tooltip" data-placement="top" title="'.$rostersName.'" class="text-left">'.$rostersName.'</th>
                                			<th data-toggle="tooltip" data-placement="top" title="'.$rostersPosition.'">PO</th>
                                            <th data-toggle="tooltip" data-placement="top" title="'.$rostersHDF.'">'.$rostersHD.'</th>
                                            <th data-toggle="tooltip" data-placement="top" title="Condition">CD</th>
                                            <th data-toggle="tooltip" data-placement="top" title="'.$rostersIJF.'">'.$rostersIJ.'</th>
                                            <th data-toggle="tooltip" data-placement="top" title="'.$rostersITF.'">'.$rostersIT.'</th>
                                            <th data-toggle="tooltip" data-placement="top" title="'.$rostersSPF.'">'.$rostersSP.'</th>
                                            <th data-toggle="tooltip" data-placement="top" title="'.$rostersSTF.'">'.$rostersST.'</th>
                                            <th data-toggle="tooltip" data-placement="top" title="'.$rostersENF.'">'.$rostersEN.'</th>
                                            <th data-toggle="tooltip" data-placement="top" title="'.$rostersDUF.'">'.$rostersDU.'</th>
                                            <th data-toggle="tooltip" data-placement="top" title="'.$rostersDIF.'">'.$rostersDI.'</th>
                                            <th data-toggle="tooltip" data-placement="top" title="'.$rostersSKF.'">'.$rostersSK.'</th>
                                            <th data-toggle="tooltip" data-placement="top" title="'.$rostersPAF.'">'.$rostersPA.'</th>
                                            <th data-toggle="tooltip" data-placement="top" title="'.$rostersPCF.'">'.$rostersPC.'</th>
                                            <th data-toggle="tooltip" data-placement="top" title="'.$rostersDFF.'">'.$rostersDF.'</th>
                                            <th data-toggle="tooltip" data-placement="top" title="'.$rostersOFF.'">'.$rostersOF.'</th>
                                            <th data-toggle="tooltip" data-placement="top" title="'.$rostersEXF.'">'.$rostersEX.'</th>
                                            <th data-toggle="tooltip" data-placement="top" title="'.$rostersLDF.'">'.$rostersLD.'</th>
                                            <th data-toggle="tooltip" data-placement="top" title="'.$rostersOVF.'">'.$rostersOV.'</th>
                                            <th data-toggle="tooltip" data-placement="top" title="Age">Age</th>
                                            <th data-toggle="tooltip" data-placement="top" title="Salary" class="text-right">Salary</th>
                                            <th data-toggle="tooltip" data-placement="top" title="'.$linkedYearF.'">CT</th>
                                            <th data-toggle="tooltip" data-placement="top" title="'.$joueursHeightF.'">HT</th>
                                            <th data-toggle="tooltip" data-placement="top" title="'.$joueursWeight.'">WT</th>
                            			</tr>    
                                    </thead>';
                                    
                                    if ($rosterType == 'Pro') {
                                        $results = $rosters->getProRosters();
                                        $rosterAvgs = $rosters->getProAverages();
                                    }else{
                                        $results = $rosters->getFarmRosters();
                                        $rosterAvgs = $rosters->getFarmAverages();
                                    }
                                    
                                    echo '<tbody style="font-weight:normal">';
                                    //create result rows
                                    foreach ($results as $roster) {
                                        
                                        $vitals = $playerVitals->findVital($roster->getNumber(), $roster->getName());
                                        //var_dump($vitals);
                                        
                                        $scoringNameSearch = htmlspecialchars($roster->getName());
                                        //$scoringNameLink = 'http://www.google.com/search?q='.$scoringNameSearch.'%nhl.com&btnI';
                                        $scoringNameLink ='http://www.hockeydb.com/ihdb/stats/findplayer.php?full_name='.$scoringNameSearch;

                                        echo '<tr>';
                                            echo '<td class="text-left"><a href="'.$scoringNameLink.'">'.$roster->getName().'</a></td>';
                                            echo '<td>'.$roster->getPosition().'</td>';
                                            echo '<td>'.$roster->getHand().'</td>';
                                            echo '<td>'.$roster->getCondition().'</td>';
                                            echo '<td>'.$roster->getInjStatus().'</td>';
                                            echo '<td>'.$roster->getIt().'</td>';
                                            echo '<td>'.$roster->getSp().'</td>';
                                            echo '<td>'.$roster->getSt().'</td>';
                                            echo '<td>'.$roster->getEn().'</td>';
                                            echo '<td>'.$roster->getDu().'</td>';
                                            echo '<td>'.$roster->getDi().'</td>';
                                            echo '<td>'.$roster->getSk().'</td>';
                                            echo '<td>'.$roster->getPa().'</td>';
                                            echo '<td>'.$roster->getPc().'</td>';
                                            echo '<td>'.$roster->getDf().'</td>';
                                            echo '<td>'.$roster->getSc().'</td>';
                                            echo '<td>'.$roster->getEx().'</td>';
                                            echo '<td>'.$roster->getLd().'</td>';
                                            echo '<td style="font-weight:bold; font-size: 13px;">'.$roster->getOv().'</td>';
                                            echo '<td>'.$vitals->getAge().'</td>';
                                            echo '<td class="text-right">$'.number_format($vitals->getSalary()).'</td>';
                                            echo '<td class="text-center">'.$vitals->getContractLength().'</td>';
                                            echo '<td>'.$vitals->getHeight().'</td>';
                                            echo '<td>'.$vitals->getWeight().'</td>';
                                        echo '</tr>';             
                                    }
                                    echo '</tbody>';
                                    
                                    //display averages in table footer
                                    echo ' <tfoot>
                                        <tr>
                              		       	<td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>'.$rosterAvgs->getAvgIt().'</td>
                                            <td>'.$rosterAvgs->getAvgSp().'</td>
                                            <td>'.$rosterAvgs->getAvgSt().'</td>
                                            <td>'.$rosterAvgs->getAvgEn().'</td>
                                            <td>'.$rosterAvgs->getAvgDu().'</td>
                                            <td>'.$rosterAvgs->getAvgDi().'</td>
                                            <td>'.$rosterAvgs->getAvgSk().'</td>
                                            <td>'.$rosterAvgs->getAvgPa().'</td>
                                            <td>'.$rosterAvgs->getAvgPc().'</td>
                                            <td>'.$rosterAvgs->getAvgDf().'</td>
                                            <td>'.$rosterAvgs->getAvgSc().'</td>
                                            <td>'.$rosterAvgs->getAvgEx().'</td>
                                            <td>'.$rosterAvgs->getAvgLd().'</td>
                                            <td>'.$rosterAvgs->getAvgOv().'</td>
                                            <td>'.$playerVitals->getAvgAge().'</td>
                                            <td class="text-right">$'.$playerVitals->getAvgSalary().'</td>
                                            <td></td>
                                            <td>'.$playerVitals->getAvgHeight().'</td>
                                            <td>'.$playerVitals->getAvgWeight().'</td>
                                                
                            			</tr>
                                    </tfoot>'; 
 
                                echo '</table>'; //end table
                                echo '</div>'; //end resp table
                                echo '</div>'; //end tab pane
                            }
                            echo '</div>'; //end tab-content
                            
                            echo '<h6 class = "text-center">'.$allLastUpdate.' '.$lastUpdated.'</h6>';
                        }else{
                            //parsing error
                            echo '<h3>ERROR PARSING ROSTERS</h3>';
                        }
                        
        
                    } else{
                        if(!file_exists($fileName)){
                            echo '<h3>' . $allFileNotFound . ' - ' . $fileName . '</h3>';
                        }
                        
                        if(!file_exists($vitalsFileName)){
                            echo '<h3>' . $allFileNotFound . ' - ' . $vitalsFileName . '</h3>'; 
                        }
                    }
                    
                    ?>
                    
            		</div> 
                </div>   
    		</div>
    	</div>
    </div>
 
</div>
<script>

// window.onload = function () {
// 	makeTableSortable('RosterPro');
// 	makeTableSortable('RosterFarm');
// 	};

$(document).ready(function() 
    { 
        $("#RosterPro").tablesorter({ 
            sortInitialOrder: 'desc'
    	}); 
        $("#RosterFarm").tablesorter({ 
            sortInitialOrder: 'desc'
    	}); 
    } 
); 



</script>

<?php include 'footer.php'; ?>