
<?php 
if(!isset($leadersActive)) $leadersActive = '';
if(!isset($skatersActive)) $skatersActive = '';
if(!isset($goaliesActive)) $goaliesActive = '';
if(!isset($statsUrlParams)) $statusUrl = '';

?>
<div class = "row no-gutters">
    <ul class="nav nav-tabs card-header-tabs" id="stats-main-nav" role="tablist">
    <li class="nav-item">
    <a class="nav-link <?php echo $leadersActive;?>" href="<?php echo 'Stats.php?'.$statsUrlParams;?>" role="tab" aria-selected="true">Leaders</a>
    </li>
    <li class="nav-item">
    <a class="nav-link <?php echo $skatersActive;?>"  href="<?php echo 'StatsSkaters.php?'.$statsUrlParams;?>" role="tab" aria-selected="false">Skaters</a>
    </li>
    <li class="nav-item">
    <a class="nav-link <?php echo $goaliesActive;?>" href="<?php echo 'StatsGoalies.php?'.$statsUrlParams;?>" role="tab" aria-selected="false">Goalies</a>
    </li>
    </ul>
</div>


