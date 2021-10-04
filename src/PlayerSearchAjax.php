<?php

require_once 'config.php';
include 'lang.php';
include 'common.php';

include_once 'classes/RosterObj.php';
include_once 'classes/RosterAvgObj.php';
include_once 'classes/RostersHolder.php';
include_once 'classes/UnassignedHolder.php';
include_once 'classes/TeamHolder.php';
include_once 'classes/ProspectObj.php';
include_once 'classes/ProspectHolder.php';
include_once 'classes/PlayerSearchWrapper.php';
include_once 'classes/PlayerVitalObj.php';
include_once 'classes/PlayerVitalsHolder.php';

$playoffs='';
if(isPlayoffs(TRANSFER_DIR, LEAGUE_MODE)){
    $playoffs = 'PLF';
}

$gmFile = getLeagueFile(TRANSFER_DIR, $playoffs, 'GMs.html', 'GMs');
$rosterFile = getLeagueFile(TRANSFER_DIR, $playoffs, 'Rosters.html', 'Rosters');
$unassignedFile = getLeagueFile(TRANSFER_DIR, $playoffs, 'Unassigned.html', 'Unassigned');
$futuresFile = getLeagueFile(TRANSFER_DIR, $playoffs, 'Futures.html', 'Futures');
$vitalsFileName = getLeagueFile(TRANSFER_DIR, $playoffs, 'PlayerVitals.html', 'PlayerVitals');

if (!file_exists($rosterFile) || !file_exists($gmFile)) {
    http_response_code(400);
    exit();
}

$teams = new TeamHolder($gmFile);
$unassignedHolder = new UnassignedHolder($unassignedFile);
$prospectHolder = new ProspectHolder($futuresFile, '');

$allPlayers = array();

//add roster players for each team
foreach($teams->get_teams() as $team){
    $rosterHolder = new RostersHolder($rosterFile, $team, false);
    $playerVitals = new PlayerVitalsHolder($vitalsFileName, $team);
    
    foreach($rosterHolder->getProRosters() as $roster){
        $wrapper = new PlayerSearchWrapper();
        
        $vitals = $playerVitals->findVital($roster->getNumber(), $roster->getName());

        $wrapper->setType('Pro');
        $wrapper->setTeam($roster->getTeam());
        $wrapper->setNumber($roster->getNumber());
        $wrapper->setName($roster->getName());
        $wrapper->setPosition($roster->getPosition());
        $wrapper->setHand($roster->getHand());
        $wrapper->setCondition($roster->getCondition());
        $wrapper->setInjStatus($roster->getInjStatus());
        $wrapper->setIt($roster->getIt());
        $wrapper->setSp($roster->getSp());
        $wrapper->setSt($roster->getSt());
        $wrapper->setEn($roster->getEn());
        $wrapper->setDu($roster->getDu());
        $wrapper->setDi($roster->getDi());
        $wrapper->setSk($roster->getSk());
        $wrapper->setPa($roster->getPa());
        $wrapper->setPc($roster->getPc());
        $wrapper->setDf($roster->getDf());
        $wrapper->setSc($roster->getSc());
        $wrapper->setEx($roster->getEx());
        $wrapper->setLd($roster->getLd());
        $wrapper->setOv($roster->getOv());
        $wrapper->setCt($vitals->getContractLength());
        $wrapper->setSalary($vitals->getSalary());

        array_push($allPlayers, $wrapper);
    }
    
    foreach($rosterHolder->getFarmRosters() as $roster){
        $wrapper = new PlayerSearchWrapper();
        
        $vitals = $playerVitals->findVital($roster->getNumber(), $roster->getName());
        
        $wrapper->setType('Farm');
        $wrapper->setTeam($roster->getTeam());
        $wrapper->setNumber($roster->getNumber());
        $wrapper->setName($roster->getName());
        $wrapper->setPosition($roster->getPosition());
        $wrapper->setHand($roster->getHand());
        $wrapper->setCondition($roster->getCondition());
        $wrapper->setInjStatus($roster->getInjStatus());
        $wrapper->setIt($roster->getIt());
        $wrapper->setSp($roster->getSp());
        $wrapper->setSt($roster->getSt());
        $wrapper->setEn($roster->getEn());
        $wrapper->setDu($roster->getDu());
        $wrapper->setDi($roster->getDi());
        $wrapper->setSk($roster->getSk());
        $wrapper->setPa($roster->getPa());
        $wrapper->setPc($roster->getPc());
        $wrapper->setDf($roster->getDf());
        $wrapper->setSc($roster->getSc());
        $wrapper->setEx($roster->getEx());
        $wrapper->setLd($roster->getLd());
        $wrapper->setOv($roster->getOv());
        $wrapper->setCt($vitals->getContractLength());
        $wrapper->setSalary($vitals->getSalary());
        
        array_push($allPlayers, $wrapper);
    }

}

//add unassigned players
foreach($unassignedHolder->getUnassigned() as $roster){
    $wrapper = new PlayerSearchWrapper();
    
    $wrapper->setType('Unassigned');
    $wrapper->setTeam($roster->getTeam());
    $wrapper->setNumber($roster->getNumber());
    $wrapper->setName($roster->getName());
    $wrapper->setPosition($roster->getPosition());
    $wrapper->setHand($roster->getHand());
    $wrapper->setCondition($roster->getCondition());
    $wrapper->setInjStatus($roster->getInjStatus());
    $wrapper->setIt($roster->getIt());
    $wrapper->setSp($roster->getSp());
    $wrapper->setSt($roster->getSt());
    $wrapper->setEn($roster->getEn());
    $wrapper->setDu($roster->getDu());
    $wrapper->setDi($roster->getDi());
    $wrapper->setSk($roster->getSk());
    $wrapper->setPa($roster->getPa());
    $wrapper->setPc($roster->getPc());
    $wrapper->setDf($roster->getDf());
    $wrapper->setSc($roster->getSc());
    $wrapper->setEx($roster->getEx());
    $wrapper->setLd($roster->getLd());
    $wrapper->setOv($roster->getOv());
    
    array_push($allPlayers, $wrapper);
}

//add prospects
foreach($prospectHolder->getProspects() as $prospect){
    $wrapper = new PlayerSearchWrapper();
    
    $wrapper->setType('Prospect');
    $wrapper->setTeam($prospect->getTeam());
    $wrapper->setNumber('N/A');
    $wrapper->setName($prospect->getName());
    $wrapper->setPosition('N/A');
    $wrapper->setHand('N/A');
    $wrapper->setCondition('N/A');
    $wrapper->setInjStatus('N/A');
    $wrapper->setIt('N/A');
    $wrapper->setSp('N/A');
    $wrapper->setSt('N/A');
    $wrapper->setEn('N/A');
    $wrapper->setDu('N/A');
    $wrapper->setDi('N/A');
    $wrapper->setSk('N/A');
    $wrapper->setPa('N/A');
    $wrapper->setPc('N/A');
    $wrapper->setDf('N/A');
    $wrapper->setSc('N/A');
    $wrapper->setEx('N/A');
    $wrapper->setLd('N/A');
    $wrapper->setOv('N/A');
    
    array_push($allPlayers, $wrapper);
}


//return data
echo '{ "data": '.json_encode($allPlayers).'}';
http_response_code(200);



?>