<?php
require_once 'config.php';
include_once 'common.php';
include_once 'lang.php';
$CurrentHTML = 'CareerStandings.php';
$CurrentTitle = $careerStandingsTitle;
$CurrentPage = 'CareerStandings';
include 'head.php';
?>

<div class="container">
<div class="col-sm-12 col-lg-8 offset-lg-2">
<div class="card">
<?php include 'SectionHeader.php';?>
<div class="card-body px-1 px-md-2 pt-1">
<div class="table-responsive"> 
<!-- <table class="table table-sm table-striped"> -->

<?php
$NumberSeason=0;

// Recherche des saisons antérieurs
if(CAREER_STATS_DIR) {
	$NumberSeason = count(getPreviousSeasons(CAREER_STATS_DIR));
}


// Recherche de la saison en cours (latest regular)
$FnmCurrentSeason = getCurrentRegSeasonFile('Standings','Farm');

//hardcode to current regular season
//$FnmCurrentSeason = getLeagueFile2($folder, '', 'Standings.html', 'Standings','Farm');

for($workSeason=$NumberSeason+1;$workSeason>0;$workSeason--) {
	$s = $workSeason;
	$Fnm = '';
	if($NumberSeason < $workSeason) {
		$Fnm = $FnmCurrentSeason;
	}
	else {
	    $Fnm = _getLeagueFile('Standings','REG',$NumberSeason,'Farm');
	}
	if(file_exists($Fnm)) { 
		$d = 0;
		$overtime = 0;
		$f = 0;
		$tableau = file($Fnm);
		while(list($cle,$val) = myEach($tableau)) {
			$val = utf8_encode($val);
			// Détection du simulateur utilisé
			if(substr_count($val, 'STK') && (substr_count($val, 'OL') || substr_count($val, 'OTL'))) {
				$overtime = 1;
			}
			if(substr_count($val, 'Conference</H3>') && !substr_count($val, '<H3>By Conference</H3>')) {
				$d = 1;
				$b = 0;
			}
			if(substr_count($val, '<H3>By Division</H3>')) {
				break 1;
			}
			if(substr_count($val, 'HREF=')) {
				$reste = trim($val);
				if(substr_count($reste, 'WIDTH')) {
					$reste = substr($reste, strpos($reste, '<A '));
				}
				$standingsPlayoff[$s][$f] = substr($reste, 0, strpos($reste, '<'));
				$reste = trim(substr($reste, strpos($reste, '>')+1));
				$standingsTeams[$s][$f] = substr($reste, 0, strpos($reste, '</A>'));
				$reste = trim(substr($reste, strpos($reste, '</A>')+4));
				$standingsGP[$s][$f] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$standingsW[$s][$f] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$standingsL[$s][$f] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$standingsT[$s][$f] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				if($overtime == 1) {
					$standingsOL[$s][$f] = substr($reste, 0, strpos($reste, ' '));
					$reste = trim(substr($reste, strpos($reste, ' ')));
				}
				else $standingsOL[$s][$f] = 0;
				$standingsPts[$s][$f] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$standingsGF[$s][$f] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$standingsGA[$s][$f] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$standingsDiff[$s][$f] = $standingsGF[$s][$f] - $standingsGA[$s][$f];
				if($standingsDiff[$s][$f] > 0) $standingsDiff[$s][$f] = '+'.$standingsDiff[$s][$f];
				$standingsPCT[$s][$f] = substr($reste, 0, strpos($reste, ' '));
				if($standingsPCT[$s][$f] == 'N/A') $standingsPCT[$s][$f] = 0;
				$reste = trim(substr($reste, strpos($reste, ' ')));
				for($z=0;$z<9;$z++) {
					$reste = trim(substr($reste, strpos($reste, ' ')));
				}
				$reste = trim(substr($reste, strpos($reste, ' ')));
				if($standingsPlayoff[$s][$f] != ''){
					if($standingsPlayoff[$s][$f] == 'z') $standingsPlayoff[$s][$f] = '<a href="javascript:return;" class="info" style="color:#000000; display:block; width:100%">'.$standingZ.'<span>'.$standingZFull.'</span></a>';
					if($standingsPlayoff[$s][$f] == 'y') $standingsPlayoff[$s][$f] = '<a href="javascript:return;" class="info" style="color:#000000; display:block; width:100%">'.$standingY.'<span>'.$standingYFull.'</span></a>';
					if($standingsPlayoff[$s][$f] == 'x') $standingsPlayoff[$s][$f] = '<a href="javascript:return;" class="info" style="color:#000000; display:block; width:100%">'.$standingX.'<span>'.$standingXFull.'</span></a>';
				}
				$standingsPos[$s][$f] = $d;
				$d++;
				$f++;
			}
		}
	}
	else { 
		//echo '<tr><td>'.$allFileNotFound.' - '.$Fnm.'</td></tr>'; 
	}
}

if(isset($standingsTeams)) {
    
	// Classement total
	$tmpPos = 0;
	$tmpPlf = 0;
	$tmpTms = 0;
	$tmpGPs = 0;
	$tmpWin = 0;
	$tmpLos = 0;
	$tmpTie = 0;
	$tmpOTL = 0;
	$tmpPts = 0;
	$tmpGFs = 0;
	$tmpGAs = 0;
	$tmpDif = 0;
	$tmpPct = 0;
	for($s=$NumberSeason+1;$s>0;$s--) {
	    
	    if(!array_key_exists($s, $standingsTeams)) continue;
		for($f=0;$f<count($standingsTeams[$s]);$f++) {
			if($standingsTeams[$s][$f] == $currentTeam) {
				$tmpPos += $standingsPos[$s][$f];
				$tmpGPs += $standingsGP[$s][$f];
				$tmpWin += $standingsW[$s][$f];
				$tmpLos += $standingsL[$s][$f];
				$tmpTie += $standingsT[$s][$f];
				if($overtime == 1) {
					$tmpOTL += $standingsOL[$s][$f];
				}
				$tmpPts += $standingsPts[$s][$f];
				$tmpGFs += $standingsGF[$s][$f];
				$tmpGAs += $standingsGA[$s][$f];
				$tmpDif += $standingsDiff[$s][$f];
				//$tmpPct += str_replace(",","0.",$standingsPCT[$s][$f]);
				break 1;
			}
		}
	}
	
	// Recherche des classements par équipe
	for($s=$NumberSeason+1;$s>0;$s--) {
	    if(!array_key_exists($s, $standingsTeams)) continue;
		for($f=0;$f<count($standingsTeams[$s]);$f++) {
			$found = 0;
			if(isset($tmpAllTms)) {
				for($t=0;$t<count($tmpAllTms);$t++) {
					if($standingsTeams[$s][$f] == $tmpAllTms[$t]) {
						$found = 1;
						$tmpAllPos[$t] += $standingsPos[$s][$f];
						$tmpAllGPs[$t] += $standingsGP[$s][$f];
						$tmpAllWin[$t] += $standingsW[$s][$f];
						$tmpAllLos[$t] += $standingsL[$s][$f];
						$tmpAllTie[$t] += $standingsT[$s][$f];
						if($overtime == 1) $tmpAllOTL[$t] += $standingsOL[$s][$f];
						$tmpAllPts[$t] += $standingsPts[$s][$f];
						$tmpAllGFs[$t] += $standingsGF[$s][$f];
						$tmpAllGAs[$t] += $standingsGA[$s][$f];
						$tmpAllDif[$t] += $standingsDiff[$s][$f];
						//$tmpAllPct[$t] += str_replace(",","0.",$standingsPCT[$s][$f]);
						break 1;
					}
				}
			}
			else $t = 0;
			if($found == 0) {
				if(!isset($tmpAllTms[$t])) {
					$tmpAllPos[$t] = 0;
					$tmpAllTms[$t] = $standingsTeams[$s][$f];
					$tmpAllGPs[$t] = 0;
					$tmpAllWin[$t] = 0;
					$tmpAllLos[$t] = 0;
					$tmpAllTie[$t] = 0;
					$tmpAllOTL[$t] = 0;
					$tmpAllPts[$t] = 0;
					$tmpAllGFs[$t] = 0;
					$tmpAllGAs[$t] = 0;
					$tmpAllDif[$t] = 0;
					$tmpAllPct[$t] = 0;	
				}
				$tmpAllPos[$t] += $standingsPos[$s][$f];
				$tmpAllGPs[$t] += $standingsGP[$s][$f];
				$tmpAllWin[$t] += $standingsW[$s][$f];
				$tmpAllLos[$t] += $standingsL[$s][$f];
				$tmpAllTie[$t] += $standingsT[$s][$f];
				if($overtime == 1) $tmpAllOTL[$t] += $standingsOL[$s][$f];
				$tmpAllPts[$t] += $standingsPts[$s][$f];
				$tmpAllGFs[$t] += $standingsGF[$s][$f];
				$tmpAllGAs[$t] += $standingsGA[$s][$f];
				$tmpAllDif[$t] += $standingsDiff[$s][$f];
				//$tmpAllPct[$t] += str_replace(",","0.",$standingsPCT[$s][$f]);
			}
		}
	}
	if(isset($tmpAllTms)) {
		echo '<div id="windowResult"></div>';
		for($i=0;$i<count($tmpAllTms);$i++) {
			$tmpAllTmsCount[$i] = $i;
			$tmpOvertimeCount = $tmpAllTie[$i];
			if($overtime == 1) $tmpOvertimeCount += $tmpAllOTL[$i];
			$tmpAllPct[$i] = number_format(round(($tmpOvertimeCount + (2 * $tmpAllWin[$i])) / (2 * $tmpAllGPs[$i]), 3), 3);
			//(OTL or/and OT + (2 x WINS)) / (2 x GP)
		}
	}
}
?>
<script type="text/javascript">
<!--
var allPos = <?php echo json_encode($tmpAllPos)?>;
var allTms = <?php echo json_encode($tmpAllTms)?>;
var allGPS = <?php echo json_encode($tmpAllGPs)?>;
var allWin = <?php echo json_encode($tmpAllWin)?>;
var allLos = <?php echo json_encode($tmpAllLos)?>;
var allTie = <?php echo json_encode($tmpAllTie)?>;
var allOTL = <?php echo json_encode($tmpAllOTL)?>;
var allPts = <?php echo json_encode($tmpAllPts)?>;
var allGFs = <?php echo json_encode($tmpAllGFs)?>;
var allGAs = <?php echo json_encode($tmpAllGAs)?>;
var allDif = <?php echo json_encode($tmpAllDif)?>;
var allPct = <?php echo json_encode($tmpAllPct)?>;
var allTmsCount = <?php echo json_encode($tmpAllTmsCount)?>;
var type = '';
var reverse = 0;

function result(x) {
	if(type == x) {
		if(reverse == 1) reverse = 0;
		else reverse = 1;
	}
	else {
		type = x;
		reverse = 0;
	}
	document.getElementById("windowResult").textContent = "";
	var result = document.getElementById("windowResult");
	var tbl = document.createElement('table');
		tbl.className = "table table-sm table-striped table-rounded";
	var thead = document.createElement('thead');
	var tbdy = document.createElement('tbody');
	// Entête
	var tr = document.createElement('tr');
		var td = document.createElement('th');
			td.appendChild(document.createTextNode(''));
			tr.appendChild(td);
			var td = document.createElement('th');
				var a = document.createElement('a');
					a.href = "javascript:return;";
					a.className = "lien-blanc";
					a.appendChild(document.createTextNode('<?php echo $standingTeam; ?>'));
				td.appendChild(a);
			tr.appendChild(td);
			var td = document.createElement('th');
				td.style.textAlign = "right";
				if(type == 'GPS') td.style.fontWeight = "bold";
					var a = document.createElement('a');
						a.href = "javascript:result('GPS');";
						a.className = "info";
						a.style.width = "100%";
						a.style.display = "block";
						a.appendChild(document.createTextNode('<?php echo $standingGP; ?>'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('<?php echo $standingGPFull; ?>'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
			var td = document.createElement('th');
				td.style.textAlign = "right";
				if(type == 'WIN') td.style.fontWeight = "bold";
					var a = document.createElement('a');
						a.href = "javascript:result('WIN');";
						a.className = "info";
						a.style.width = "100%";
						a.style.display = "block";
						a.appendChild(document.createTextNode('<?php echo $standingW; ?>'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('<?php echo $standingWFull; ?>'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
			var td = document.createElement('th');
				td.style.textAlign = "right";
				if(type == 'LOS') td.style.fontWeight = "bold";
					var a = document.createElement('a');
						a.href = "javascript:result('LOS');";
						a.className = "info";
						a.style.width = "100%";
						a.style.display = "block";
						a.appendChild(document.createTextNode('<?php echo $standingL; ?>'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('<?php echo $standingLFull; ?>'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
			var td = document.createElement('th');
				td.style.textAlign = "right";
				if(type == 'TIE') td.style.fontWeight = "bold";
					var a = document.createElement('a');
						a.href = "javascript:result('TIE');";
						a.className = "info";
						a.style.width = "100%";
						a.style.display = "block";
						a.appendChild(document.createTextNode('<?php echo $standingE; ?>'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('<?php echo $standingEFull; ?>'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
			
			if(<?php echo $overtime; ?> == 1) {
				var td = document.createElement('th');
					td.style.textAlign = "right";
					if(type == 'OTL') td.style.fontWeight = "bold";
						var a = document.createElement('a');
							a.href = "javascript:result('OTL');";
							a.className = "info";
							a.style.width = "100%";
							a.style.display = "block";
							a.appendChild(document.createTextNode('<?php echo $standingOT; ?>'));
						var span = document.createElement('span');
							span.appendChild(document.createTextNode('<?php echo $standingOTFull; ?>'));
						a.appendChild(span);
					td.appendChild(a);
				tr.appendChild(td);
			}
			var td = document.createElement('th');
				td.style.textAlign = "right";
				if(type == 'PTS') td.style.fontWeight = "bold";
					var a = document.createElement('a');
						a.href = "javascript:result('PTS');";
						a.className = "info";
						a.style.width = "100%";
						a.style.display = "block";
						a.appendChild(document.createTextNode('<?php echo $standingPTS; ?>'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('<?php echo $standingPTSFull; ?>'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
			var td = document.createElement('th');
				td.style.textAlign = "right";
				if(type == 'GFS') td.style.fontWeight = "bold";
					var a = document.createElement('a');
						a.href = "javascript:result('GFS');";
						a.className = "info";
						a.style.width = "100%";
						a.style.display = "block";
						a.appendChild(document.createTextNode('<?php echo $standingGF; ?>'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('<?php echo $standingGFFull; ?>'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
			var td = document.createElement('th');
				td.style.textAlign = "right";
				if(type == 'GAS') td.style.fontWeight = "bold";
					var a = document.createElement('a');
						a.href = "javascript:result('GAS');";
						a.className = "info";
						a.style.width = "100%";
						a.style.display = "block";
						a.appendChild(document.createTextNode('<?php echo $standingGA; ?>'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('<?php echo $standingGAFull; ?>'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
			var td = document.createElement('th');
				td.style.textAlign = "right";
				if(type == 'DIF') td.style.fontWeight = "bold";
					var a = document.createElement('a');
						a.href = "javascript:result('DIF');";
						a.className = "info";
						a.style.width = "100%";
						a.style.display = "block";
						a.appendChild(document.createTextNode('<?php echo $standingDiff; ?>'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('<?php echo $standingDiffFull; ?>'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
			var td = document.createElement('th');
				td.style.textAlign = "right";
				if(type == 'PCT') td.style.fontWeight = "bold";
					var a = document.createElement('a');
						a.href = "javascript:result('PCT');";
						a.className = "info";
						a.style.width = "100%";
						a.style.display = "block";
						a.appendChild(document.createTextNode('<?php echo $standingPCT; ?>'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('<?php echo $standingPCTFull; ?>'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
		thead.appendChild(tr);
	var zipped = [];
	var tmpTransF = [];
	if(type == 'GPS') tmpTransF = allGPS;
	if(type == 'WIN') tmpTransF = allWin;
	if(type == 'LOS') tmpTransF = allLos;
	if(type == 'TIE') tmpTransF = allTie;
	if(type == 'OTL') tmpTransF = allOTL;
	if(type == 'PTS') tmpTransF = allPts;
	if(type == 'GFS') tmpTransF = allGFs;
	if(type == 'GAS') tmpTransF = allGAs;
	if(type == 'DIF') tmpTransF = allDif;
	if(type == 'PCT') tmpTransF = allPct;
	for(i=0; i<allTms.length; ++i) {
		zipped.push({
			attr: tmpTransF[i],
			id: allTmsCount[i]
		});
	}
	zipped.sort(function(left, right) {
		var leftArray1elem = left.attr,
			rightArray1elem = right.attr;
		return leftArray1elem === rightArray1elem ? 0 : (leftArray1elem < rightArray1elem ? -1 : 1);
	});
	if(reverse == 0) zipped.reverse(); 
	var c = 1;
	var d = 0;
	for(var i=0;i<allTms.length;i++) {
		if(c == 2) c = 1;
		else c = 2;
		var tr = showPlayer(zipped[i]['id'],c,d,type);
		tbdy.appendChild(tr);
		d++;
		if(d == 100) break;
	}
	tbl.appendChild(thead);
	tbl.appendChild(tbdy);
	result.appendChild(tbl);
}

function showPlayer(i,c,d,currentSearch) {
	d = d + 1;
	var tr = document.createElement('tr');
		tr.className = "hover"+c;
		var td = document.createElement('td');
			if(allTms[i] == '<?php echo $currentTeam; ?>') td.style.fontWeight = "bold";
			td.appendChild(document.createTextNode(d));
		tr.appendChild(td);
		var td = document.createElement('td');
			if(allTms[i] == '<?php echo $currentTeam; ?>') td.style.fontWeight = "bold";
			var a = document.createElement('a');
				a.className = "lien-noir";
				a.style.display = "block";
				//a.style.width = "100%";
				a.href = "TeamRosters.php?team="+encodeURIComponent(allTms[i]);
				//a.target = "_blank";
				a.appendChild(document.createTextNode(allTms[i]));
			td.appendChild(a);
			td.style.textAlign = "left";
		tr.appendChild(td);
		var td = document.createElement('td');
			td.style.textAlign = "right";
			if(currentSearch == 'GPS' || allTms[i] == '<?php echo $currentTeam; ?>') td.style.fontWeight = "bold";
			td.appendChild(document.createTextNode(allGPS[i]));
		tr.appendChild(td);
		var td = document.createElement('td');
			td.style.textAlign = "right";
			if(currentSearch == 'WIN' || allTms[i] == '<?php echo $currentTeam; ?>') td.style.fontWeight = "bold";
			td.appendChild(document.createTextNode(allWin[i]));
		tr.appendChild(td);
		var td = document.createElement('td');
			td.style.textAlign = "right";
			if(currentSearch == 'LOS' || allTms[i] == '<?php echo $currentTeam; ?>') td.style.fontWeight = "bold";
			td.appendChild(document.createTextNode(allLos[i]));
		tr.appendChild(td);
		var td = document.createElement('td');
			td.style.textAlign = "right";
			if(currentSearch == 'TIE' || allTms[i] == '<?php echo $currentTeam; ?>') td.style.fontWeight = "bold";
			td.appendChild(document.createTextNode(allTie[i]));
		tr.appendChild(td);
		if(<?php echo $overtime; ?> == 1) {
			var td = document.createElement('td');
				td.style.textAlign = "right";
				if(currentSearch == 'OTL' || allTms[i] == '<?php echo $currentTeam; ?>') td.style.fontWeight = "bold";
				td.appendChild(document.createTextNode(allOTL[i]));
			tr.appendChild(td);
		}
		var td = document.createElement('td');
			td.style.textAlign = "right";
			if(currentSearch == 'PTS' || allTms[i] == '<?php echo $currentTeam; ?>') td.style.fontWeight = "bold";
			td.appendChild(document.createTextNode(allPts[i]));
		tr.appendChild(td);
		var td = document.createElement('td');
			td.style.textAlign = "right";
			if(currentSearch == 'GFS' || allTms[i] == '<?php echo $currentTeam; ?>') td.style.fontWeight = "bold";
			td.appendChild(document.createTextNode(allGFs[i]));
		tr.appendChild(td);
		var td = document.createElement('td');
			td.style.textAlign = "right";
			if(currentSearch == 'GAS' || allTms[i] == '<?php echo $currentTeam; ?>') td.style.fontWeight = "bold";
			td.appendChild(document.createTextNode(allGAs[i]));
		tr.appendChild(td);
		var td = document.createElement('td');
			td.style.textAlign = "right";
			if(currentSearch == 'DIF' || allTms[i] == '<?php echo $currentTeam; ?>') td.style.fontWeight = "bold";
			td.appendChild(document.createTextNode(allDif[i]));
		tr.appendChild(td);
		var td = document.createElement('td');
			td.style.textAlign = "right";
			if(currentSearch == 'PCT' || allTms[i] == '<?php echo $currentTeam; ?>') td.style.fontWeight = "bold";
			td.appendChild(document.createTextNode(allPct[i]));
		tr.appendChild(td);
	return tr;
}

document.addEventListener('DOMContentLoaded', result('PTS'), false);

//-->
</script>

</div></div></div></div></div>

<?php include 'footer.php'; ?>