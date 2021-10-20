
<?php
require_once 'config.php';
include_once 'lang.php';
include_once 'common.php';
include_once 'fileUtils.php';

$seasonId = '';
if(isset($_GET['seasonId']) || isset($_POST['seasonId'])) {
    $seasonId = ( isset($_GET['seasonId']) ) ? $_GET['seasonId'] : $_POST['seasonId'];
}

if(trim($seasonId) == false){
   // $Fnm = getLeagueFile2($folder, '', 'Standings.html', 'Standings', 'Farm'); // exclude farm
    $Fnm =  getCurrentLeagueFile('Standings','Farm');
}else{
   //$seasonFolder = str_replace("#",$seasonId,CAREER_STATS_DIR);
    //$Fnm = getLeagueFile2($seasonFolder, '', 'Standings.html', 'Standings', 'Farm'); // exclude farm
    $Fnm = _getLeagueFile('Standings', null, $seasonId, 'Farm'); // exclude farm
    error_log($Fnm);
}


$tableCol = 15;
$c = 1;
$d = 0;
$e = 0;

$confProcessed = 0;
$divProcessed = 0;

$lastUpdated = '';
$shootoutMode = false;

if (file_exists($Fnm)) {
    $tableau = file($Fnm);
    
    //check playoff mode first if in shootoutmode
    //still need to be able to support the old style if seasons are mixed between both types so don't look based on mode..
//     if(SHOOTOUT_MODE){
//         foreach($tableau as $line)
//         {
//             if(strpos($line, 'W  L OT') !== false){
//                 $otMode = true;
//             }
            
//         }
//     }
    foreach($tableau as $line)
    {
        if(strpos($line, 'W  L OT') !== false){
            $shootoutMode = true;
            break;
        }
        
    }

    
    while (list ($cle, $val) = myEach($tableau)) {
        $val = utf8_encode($val);
        if (substr_count($val, '<P>(As of')) {
            $pos = strpos($val, ')');
            $pos = $pos - 10;
            //$val2 = substr($val, 10, $pos);
            $lastUpdated= substr($val, 10, $pos);

            echo '<div class="col-sm-12 col-lg-8 offset-lg-2 px-0">';
            
            echo '<div class="accordion" id="accordionExample">';

          
        }
        else if (substr_count($val, '<H3>By Conference</H3>')) {
  
            //start conference
            echo '<div class="card">';
            echo '<div class="card-header p-1" id="headingOne">
                 
                    <button class="btn btn-link btn-block p-0" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <div class= "section-header logo-gradient">
                        <div class="header-container">
                        
                        <div class="gloss"></div>
                        <span class="header">'.$teamCardConference.'</span>
                        
                        </div>
                    </button>
       
                  </div>';
            echo '<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">';
            echo '<div class="card-body p-1">';

        }
        else if (substr_count($val, '<H3>By Division</H3>')) {

            //end of last conference
            echo '</tbody>';
            echo '</table>';
            echo '</div>'; //end table-responsive;
            echo '</div>'; //end card body
            echo '</div>'; //end card collapse;
            echo '</div>'; //end card
            
            echo '<div class="card">';
            echo '<div class="card-header p-1" id="divHeader">
                
                    <button class="btn btn-link btn-block collapsed p-0" type="button" data-toggle="collapse" data-target="#divCollapse" aria-expanded="true" aria-controls="divCollapse">
                        <div class= "section-header logo-gradient">
                            <div class="header-container">
                                <div class="gloss"></div>
                                <span class="header">'.$teamCardDivision.'</span>
                    	    </div>
                    	</div>';
            echo '  </button>
                
                  </div>';
            echo '<div id="divCollapse" class="collapse" aria-labelledby="divHeader" data-parent="#accordionExample">';
            echo '<div class="card-body p-1">';


        }
        else if (substr_count($val, 'Conference</H3>') && ! substr_count($val, '<H3>By Conference</H3>')) {
            $pos = strpos($val, 'Conference</H3>');
            $pos2 = strpos($val, '<H3>');
            $val2 = substr($val, $pos2 + 4, $pos - $pos2 - 5);


            
            if($confProcessed > 0){
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
            }
            
            echo '<div class = "tableau-top">' . $val2 . ' ' . $standingConference . '</div>';
            echo '<div class="table-responsive">';
            echo '<table class="table table-sm table-striped text-center table-rounded-bottom">';
           
     
            $d = 1;
            $b = 0;
            $final = 0;

            $confProcessed++;
        }
        else if  (substr_count($val, 'Division</H3>') && ! substr_count($val, '<H3>By Division</H3>')) {
            $pos = strpos($val, 'Division</H3>');
            $pos2 = strpos($val, '<H3>');
            $val2 = substr($val, $pos2 + 4, $pos - $pos2 - 5);            

            if($divProcessed > 0){
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
            }
            
            echo '<div class = "tableau-top">' . $val2 . ' ' . $standingDivision . '</div>';
            echo '<div class="table-responsive">';
            echo '<table class="table table-sm table-striped text-center table-rounded-bottom"">';
            
            
            $d = 1;
            $b = 0;
            
            $divProcessed++;
        }
        if ($d == 1 && substr_count($val, '</H3>')) {
            $c = 1;
        }
        if (substr_count($val, 'STK') && (substr_count($val, 'OL') || substr_count($val, 'OTL') || substr_count($val, 'OT'))) {
            $e = 1;
        }

        if (substr_count($val, 'HREF=')) {
            if ($d == 1) {
                echo '<thead>';
                echo '<tr>';
                echo '<th></th>';
                echo '<th></th>';
                echo '<th class="text-left">' . $standingTeam . '</th>';
                echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingGPFull.'">'. $standingGP .'</th>';
                echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingWFull.'">' . $standingW . '</th>';
                echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingLFull.'">' . $standingL . '</th>';
                if(!$shootoutMode){
                    echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingEFull.'">' . $standingE . '</th>';
                }

                if ($e == 1){

                    echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingOTFull.'">' . $standingOT . '</th>';
                    echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingPTSFull.'">' . $standingPTS . '</th>';
                    echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingGFFull.'">' . $standingGF . '</th>';
                    echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingGAFull.'">' . $standingGA . '</th>';
                    echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingDiffFull.'">' . $standingDiff . '</th>';
                    echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingPCTFull.'">' . $standingPCT . '</th>';
                    echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingL10Full.'">' . $standingL10 . '</th>';
                    echo '<th data-toggle="tooltip" data-placement="top" title="'.$standingSTRKFull.'">' . $standingSTRK . '</th>';
                    
                }
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

            }
            $reste = trim($val);
            if (substr_count($reste, 'WIDTH')) {
                echo '<tr class="tableau-top"><td colspan="' . $tableCol . '" style="height:2px;"></td></tr>';
                $reste = substr($reste, strpos($reste, '<A '));
            }
            $serie = '';
            
            $serie = substr($reste, 0, strpos($reste, '<'));
            $reste = trim(substr($reste, strpos($reste, '>') + 1));
            $equipe = substr($reste, 0, strpos($reste, '</A>'));
            $reste = trim(substr($reste, strpos($reste, '</A>') + 4));
            
            $pj = substr($reste, 0, strpos($reste, ' '));
            $reste = trim(substr($reste, strpos($reste, ' ')));
            $standingsW = substr($reste, 0, strpos($reste, ' '));
            $reste = trim(substr($reste, strpos($reste, ' ')));
            $standingsL = substr($reste, 0, strpos($reste, ' '));
            $reste = trim(substr($reste, strpos($reste, ' ')));
            
            //not needed in shootout mode.
            if(!$shootoutMode){
                $standingsT = substr($reste, 0, strpos($reste, ' '));
                $reste = trim(substr($reste, strpos($reste, ' ')));
            }

            if ($e == 1) {
                $standingsOL = substr($reste, 0, strpos($reste, ' '));
                $reste = trim(substr($reste, strpos($reste, ' ')));
            }
            $standingsPts = substr($reste, 0, strpos($reste, ' '));
            $reste = trim(substr($reste, strpos($reste, ' ')));
            $standingsGF = substr($reste, 0, strpos($reste, ' '));
            $reste = trim(substr($reste, strpos($reste, ' ')));
            $standingsGA = substr($reste, 0, strpos($reste, ' '));
            $reste = trim(substr($reste, strpos($reste, ' ')));
            $standingsDiff = $standingsGF - $standingsGA;
            if ($standingsDiff > 0)
                $standingsDiff = '+' . $standingsDiff;
                
                $standingsPCT = substr($reste, 0, strpos($reste, ' '));
                $reste = trim(substr($reste, strpos($reste, ' ')));
                
                $lastCounter = ($shootoutMode) ? 10 : 9;
                for ($z = 0; $z < $lastCounter; $z ++) {
                    $reste = trim(substr($reste, strpos($reste, ' ')));
                }
                $standingsL10 = substr($reste, 0, strpos($reste, ' '));
                $reste = trim(substr($reste, strpos($reste, ' ')));
                $standingsSTK = $reste;
                

                if ($b && $d > 8 && $final)
                    $serie = '<a href="javascript:return;" class="info" style="color:#000000">' . $standingN . '<span>' . $standingNFull . '</span></a>';
                    if ($c == 1)
                        $c = 2;
                        else
                            $c = 1;
                         
                            echo '<tr>';
                            echo '<td>' . $d . '</td>';
                            echo '<td>' . $serie . '</td>';
                            //echo '<td>' . $equipe . '</td>';
                            echo '<td class="text-left"><a style="display:block; width:100%;" href="TeamRosters.php?team=' . $equipe . '">' . $equipe . '</a></td>';
                            
                            echo '<td>' . $pj . '</td>';
                            echo '<td>' . $standingsW . '</td>';
                            echo '<td>' . $standingsL . '</td>';
                            if(!$shootoutMode){
                                echo '<td>' . $standingsT . '</td>';
                            }
                            if ($e == 1){

                                echo '<td>' . $standingsOL . '</td>';
                                echo '<td>' . $standingsPts . '</td>';
                                echo '<td>' . $standingsGF . '</td>';
                                echo '<td>' . $standingsGA . '</td>';
                                echo '<td>' . $standingsDiff . '</td>';
                                echo '<td>' . $standingsPCT . '</td>';
                            }
                            echo '<td>' . $standingsL10 . '</td>';
                            echo '<td>' . $standingsSTK . '</td>';
                            echo '</tr>';
                            
                            $d ++;
                              
                
        }
    }
    
    echo '</tbody>';
    echo '</table>';
    echo '</div>'; //end last div table responsive
    echo '</div>'; //end card body
    echo '</div>'; //end card collapse;
    echo '</div>'; //end card
    echo '</div>'; //end accordian
    echo '</div>'; //end col
    
    echo '<h6 class = "text-center">' . $allLastUpdate . ' ' . $lastUpdated . '</h56>';
    
    
    
} else {
    //echo  $allFileNotFound . ' - ' . $Fnm ;
    echo '<h6>No season data found</h6>';
}



?>

<script>

$('.collapse').on('shown.bs.collapse', function(e) {
    var $card = $(this).closest('.card');
    $('html,body').animate({
        scrollTop: $card.offset().top - 55
    }, 500);
});
</script>

