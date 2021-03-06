<?php

require_once __DIR__.'/../config.php';

include_once FS_ROOT.'lang.php';
include_once FS_ROOT.'common.php';
include_once FS_ROOT.'classes/WaiversHolder.php';
include_once FS_ROOT.'classes/WaiverObj.php';

include FS_ROOT.'assets.php';


$fileName = getCurrentLeagueFile('Waivers');

if (file_exists($fileName)) {
    
    //get waivers from file
    $waiverHolder = new WaiversHolder($fileName);
    $waivers = $waiverHolder->get_waivers();

} else
    echo '<h5>' . $allFileNotFound . ' - ' . $fileName . '</h5>';

?>

<div class="container fhlElement px-0">
	<div class="card px-0">
		<div class="card-body px-0">
			<?php  if (isset($waivers) && !empty($waivers)) {?>
			<div class="table-responsive">
				<table class="table table-sm table-striped">
    				<thead>
    					<tr>
    						<th><?php echo $waiversPlayer; ?></th>
    						<th><?php echo $waiversDate; ?></th>
    						<th><?php echo $waiversBy; ?></th>
    						<th><?php echo $waiversClaimed; ?></th>
    					</tr>
    				</thead>
    				<tbody>
    					<?php foreach ($waivers as $waiver) {
    					    $waiveTextWeight = '';
    					    if($waiver->claimedBy != 'NO CLAIMS'){
    					        $waiveTextWeight = ' font-weight-bold';
    					    }
    					    
    					    ?>
    						<tr class="<?php echo $waiveTextWeight;?>">
    							<td><?php echo $waiver->player; ?></td>
        						<td><?php echo $waiver->waiveDate; ?></td>
        						<td><?php echo $waiver->waivedBy; ?></td>
        						<td><?php echo $waiver->claimedBy; ?></td>
    						</tr>
    					<?php }?>
    				</tbody>
             	</table>
			</div>
			<?php }else{?>
			<h6 class="text-center mb-0"><?php echo $waiversNothing;?></h6>
			<?php }?>
		</div>
	</div>
</div>
