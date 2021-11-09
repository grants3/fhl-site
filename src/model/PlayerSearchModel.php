<?php
if(count(get_included_files()) ==1) die(header('HTTP/1.1 404 Not Found')); //must be included 

require_once __DIR__.'/../config.php';
include_once FS_ROOT.'common.php';
include_once FS_ROOT.'fileUtils.php';
include_once FS_ROOT.'model/Model.php';
include_once FS_ROOT.'classes/RosterObj.php';
include_once FS_ROOT.'classes/RosterAvgObj.php';
include_once FS_ROOT.'classes/RostersHolder.php';
include_once FS_ROOT.'classes/UnassignedHolder.php';
include_once FS_ROOT.'classes/TeamHolder.php';
include_once FS_ROOT.'classes/ProspectObj.php';
include_once FS_ROOT.'classes/ProspectHolder.php';
include_once FS_ROOT.'classes/PlayerSearchWrapper.php';
include_once FS_ROOT.'classes/PlayerVitalObj.php';
include_once FS_ROOT.'classes/PlayerVitalsHolder.php';
include_once FS_ROOT.'classes/SimFileNotFoundException.php';

class PlayerSearchModel {//implements Model{
    
    public function __construct(){
        
    }
    
    function findBySeason($seasonId = null, $seasonType = null, $type = 'ALL', $searchTeam = null) : array{

        $gmFile = _getLeagueFile('GMs',$seasonType,$seasonId);
        $rosterFile = _getLeagueFile('Rosters',$seasonType,$seasonId);
        $unassignedFile = _getLeagueFile('Unassigned',$seasonType,$seasonId);
        $futuresFile = _getLeagueFile('Futures',$seasonType,$seasonId);
        $vitalsFileName = _getLeagueFile('PlayerVitals',$seasonType,$seasonId);
        
        $unassignedHolder = null;
        $prospectHolder = null;
        
        if(!file_exists($gmFile)) {
            throw new SimFileNotFoundException('GMs not found. seasonType='.$seasonType.' seasonId='.$seasonId);
        }
        if(!file_exists($rosterFile)) {
            throw new SimFileNotFoundException('Rosters not found. seasonType='.$seasonType.' seasonId='.$seasonId);
        }
        if(!file_exists($vitalsFileName)) {
            throw new SimFileNotFoundException('PlayerVitals not found. seasonType='.$seasonType.' seasonId='.$seasonId);
        }
        
        if(file_exists($unassignedFile)) {
            $unassignedHolder = new UnassignedHolder($unassignedFile);
        }
        if(file_exists($futuresFile)) {
            $prospectHolder = new ProspectHolder($futuresFile, $searchTeam);
        }

        $teams = new TeamHolder($gmFile);
        
        $allPlayers = array();
        
        //add roster players for each team
        if(('ALL' == $type || 'PRO' == $type || 'FRM' == $type|| 'PROFRM' == $type)){
            foreach($teams->get_teams() as $team){
                
                if(isset($searchTeam) && $searchTeam && strcasecmp($team,$searchTeam) != 0) continue;
                
                $rosterHolder = new RostersHolder($rosterFile, $team, false);
                $playerVitals = new PlayerVitalsHolder($vitalsFileName, $team);
                
                if('ALL' == $type || 'PRO' == $type || 'PROFRM' == $type){
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
                }
             
                if('ALL' == $type || 'FRM' == $type || 'PROFRM' == $type){
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

                
            }
        }
        //add unassigned players
        if(isset($unassignedHolder) && ('ALL' == $type && (!isset($searchTeam) || strcasecmp('Unassigned',$searchTeam) == 0) )){
            foreach($unassignedHolder->getUnassigned() as $roster){
                $wrapper = new PlayerSearchWrapper();
                
                $wrapper->setType('Unassigned');
                $wrapper->setName($roster->getName());
                $wrapper->setPosition($roster->getPosition());
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
        }
        
        //add prospects
        if(isset($prospectHolder) && ('ALL' == $type || 'PCT' == $type )){
            foreach($prospectHolder->getProspects() as $prospect){
                $wrapper = new PlayerSearchWrapper();
                
                $wrapper->setType('Prospect');
                $wrapper->setTeam($prospect->getTeam());
                $wrapper->setNumber('');
                $wrapper->setName($prospect->getName());
                $wrapper->setPosition('N/A');
                $wrapper->setHand('N/A');
                $wrapper->setCondition('');
                $wrapper->setInjStatus('');
                $wrapper->setIt(0);
                $wrapper->setSp(0);
                $wrapper->setSt(0);
                $wrapper->setEn(0);
                $wrapper->setDu(0);
                $wrapper->setDi(0);
                $wrapper->setSk(0);
                $wrapper->setPa(0);
                $wrapper->setPc(0);
                $wrapper->setDf(0);
                $wrapper->setSc(0);
                $wrapper->setEx(0);
                $wrapper->setLd(0);
                $wrapper->setOv(0);
                
                array_push($allPlayers, $wrapper);
            }
        }

        
        return $allPlayers;
    }

   

}

