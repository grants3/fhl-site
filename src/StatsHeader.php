
<?php 
if(!isset($leadersActive)) $leadersActive = '';
if(!isset($skatersActive)) $skatersActive = '';
if(!isset($goaliesActive)) $goaliesActive = '';

?>

<div>
    <ul class="nav nav-tabs card-header-tabs" id="stats-main-nav" role="tablist">
    <li class="nav-item">
    <a class="nav-link <?php echo $leadersActive;?>" href="<?php echo BASE_URL.'Stats.php';?>" role="tab" aria-selected="true">Leaders</a>
    </li>
    <li class="nav-item">
    <a class="nav-link <?php echo $skatersActive;?>"  href="<?php echo BASE_URL.'StatsSkaters.php';?>" role="tab" aria-selected="false">Skaters</a>
    </li>
    <li class="nav-item">
    <a class="nav-link <?php echo $goaliesActive;?>" href="<?php echo BASE_URL.'StatsGoalies.php';?>" role="tab" aria-selected="false">Goalies</a>
    </li>
    </ul>
</div>