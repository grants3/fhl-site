<?php
include 'config.php';
include 'lang.php';
$CurrentHTML = '';
$CurrentTitle = $compareTitle;
$CurrentPage = 'ComparePlayers';


$couleur_contour = "#484848";
$tableauGrey2 = "#ECECEC";

include 'head.php';

$Fnm = getLeagueFile('Rosters');
$Fnm2 = getLeagueFile('PlayerVitals');
$a = 0;
$c = 1;
$d = 0;
$i = 0;
$k = 0;
$m = 0;
$z = 0;
if(file_exists($Fnm) && file_exists($Fnm2)) {
	if(file_exists($Fnm)) {
		$tableau = file($Fnm);
		foreach ($tableau as $cle => $val) {
		//while(list($cle,$val) = each($tableau)) {
			$val = utf8_encode($val);
			if(substr_count($val, 'A NAME=')) {
				$reste = substr($val, strpos($val, '='), strpos($val, '</')-strpos($val, '='));
				$lastTeam = trim(substr($reste, strpos($reste, '>')+1));
				if($d != 0) $m++;
				$d = 1;
				$i = 0;
				$k = 0;
				$z = 0;
			}
			if(substr_count($val, '</PRE>') && $d) {
				$a = 0;
			}
			if($a == 1 && $d && $z == 1) {
				$equipe[$m][$i] = $lastTeam;
				$reste = trim($val);
				$numero[$m][$i] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				/*
				$tmpPos = '';
				if(substr_count($reste, ' C ')) $tmpPos = ' C ';
				if(substr_count($reste, ' LW ')) $tmpPos = ' LW ';
				if(substr_count($reste, ' RW ')) $tmpPos = ' RW ';
				if(substr_count($reste, ' D ')) $tmpPos = ' D ';
				if(substr_count($reste, ' G ')) $tmpPos = ' G ';
				$name[$m][$i] = trim(substr($reste, 0,  strpos($reste, $tmpPos)));
				$reste = trim(substr($reste, strpos($reste, $tmpPos)));
				*/
				$name[$m][$i] = trim(mb_substr($reste, 0, 22, 'UTF-8'));
				$reste = trim(mb_substr($reste, 22, mb_strlen($reste)-22, 'UTF-8'));
				$aremplacer = array('L ', 'R ', 'LW ', 'RW ');
				$remplace = array($rostersLeft.' ', $rostersRight.' ', $rostersLW.' ', $rostersRW.' ');
				$reste = str_replace($aremplacer, $remplace, $reste);
				$position[$m][$i] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				if(substr_count($position[$m][$i], 'G')) $positions[$m][$i] = 5;
				if(substr_count($position[$m][$i], 'D')) $positions[$m][$i] = 4;
				if(substr_count($position[$m][$i], 'AG') || substr_count($position[$m][$i], 'LW')) $positions[$m][$i] = 2;
				if(substr_count($position[$m][$i], 'AD') || substr_count($position[$m][$i], 'RW')) $positions[$m][$i] = 3;
				if(substr_count($position[$m][$i], 'C')) $positions[$m][$i] = 1;
				$lance[$m][$i] = substr($reste, 0, strpos($reste, '  '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$condition[$m][$i] = substr($reste, 0, strpos($reste, ' '));
				$reste = substr($reste, strpos($reste, ' '));
				$count = strlen($reste);
				$j = 3;
				while( $j < $count ) {
					if( ctype_digit($reste[$j]) ) {
						$pos = $j;
						break 1;
					}
					$j++;
				}
				$blessure[$m][$i] = trim(substr($reste, 0, $pos));
				$reste = trim(substr($reste, $pos));
				$intensite[$m][$i] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$vitesse[$m][$i] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$force[$m][$i] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$endurance[$m][$i] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$durabilite[$m][$i] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$discipline[$m][$i] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$patinage[$m][$i] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$passe[$m][$i] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$controle[$m][$i] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$defense[$m][$i] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$offense[$m][$i] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$experience[$m][$i] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$leadership[$m][$i] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$total[$m][$i] = substr($reste, strpos($reste, ' '));
				$i++;
				
			}
			if($a == 1 && $d && $z == 2) {
				$equipe2[$m][$k] = $lastTeam;
				$reste = trim($val);
				$numero2[$m][$k] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				/*
				$tmpPos = '';
				if(substr_count($reste, ' C ')) $tmpPos = ' C ';
				if(substr_count($reste, ' LW ')) $tmpPos = ' LW ';
				if(substr_count($reste, ' RW ')) $tmpPos = ' RW ';
				if(substr_count($reste, ' D ')) $tmpPos = ' D ';
				if(substr_count($reste, ' G ')) $tmpPos = ' G ';
				$name2[$m][$k] = trim(substr($reste, 0, strpos($reste, $tmpPos)));
				$reste = trim(substr($reste, strpos($reste, $tmpPos)));
				*/
				$name2[$m][$k] = trim(mb_substr($reste, 0, 22, 'UTF-8'));
				$reste = trim(mb_substr($reste, 22, mb_strlen($reste)-22, 'UTF-8'));
				$aremplacer = array('L ', 'R ', 'LW ', 'RW ');
				$remplace = array($rostersLeft.' ', $rostersRight.' ', $rostersLW.' ', $rostersRW.' ');
				$reste = str_replace($aremplacer, $remplace, $reste);
				$position2[$m][$k] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				if(substr_count($position2[$m][$k], 'G')) $positions2[$m][$k] = 5;
				if(substr_count($position2[$m][$k], 'D')) $positions2[$m][$k] = 4;
				if(substr_count($position2[$m][$k], 'AG') || substr_count($position2[$m][$k], 'LW')) $positions2[$m][$k] = 2;
				if(substr_count($position2[$m][$k], 'AD') || substr_count($position2[$m][$k], 'RW')) $positions2[$m][$k] = 3;
				if(substr_count($position2[$m][$k], 'C')) $positions2[$m][$k] = 1;
				$lance2[$m][$k] = substr($reste, 0, strpos($reste, '  '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$condition2[$m][$k] = substr($reste, 0, strpos($reste, ' '));
				$reste = substr($reste, strpos($reste, ' '));
				$count = strlen($reste);
				$j = 3;
				while( $j < $count ) {
					if( ctype_digit($reste[$j]) ) {
						$pos = $j;
						break 1;
					}
					$j++;
				}
				$blessure2[$m][$k] = trim(substr($reste, 0, $pos));
				$reste = trim(substr($reste, $pos));
				$intensite2[$m][$k] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$vitesse2[$m][$k] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$force2[$m][$k] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$endurance2[$m][$k] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$durabilite2[$m][$k] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$discipline2[$m][$k] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$patinage2[$m][$k] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$passe2[$m][$k] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$controle2[$m][$k] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$defense2[$m][$k] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$offense2[$m][$k] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$experience2[$m][$k] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$leadership2[$m][$k] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$total2[$m][$k] = substr($reste, strpos($reste, ' '));
				$k++;
			}
			if(substr_count($val, '<PRE>') && $d) {
				$a = 1;
				$z++;
			}
		}
	}
	
	$a = 0;
	$d = 0;
	$i = 0;
	$m = 0;
	if(file_exists($Fnm2)) {
		$tableau = file($Fnm2);
		foreach ($tableau as $cle => $val) {
		//while(list($cle,$val) = each($tableau)) {
			$val = utf8_encode($val);
			if(substr_count($val, 'A NAME=')) {
				$reste = substr($val, strpos($val, '='), strpos($val, '</')-strpos($val, '='));
				$lastTeam = trim(substr($reste, strpos($reste, '>')+1));
				if($d != 0) $m++;
				$a = 0;
				$d = 1;
				$i = 0;
			}
			if($a == 3 && $d) {
				$a++;
			}
			if(substr_count($val, '------------------') && $d) {
				$a++;
			}
			if($a == 2 && $d) {
				$vital_numero[$m][$i] = substr($val, 0,  strpos($val, ' '));
				$reste = trim(substr($val, strpos($val, ' ')));
				if(substr_count($reste, '*', 0, 1)) {
					$recrue[$m][$i] = substr($reste, 0, 1);
					$reste = trim(substr($reste, 1));
				}
				else $recrue[$m][$i] = '';
				
				$vital_name[$m][$i] = trim(substr($reste, 0, strpos($reste, '  ')));
				$reste = trim(substr($reste, strpos($reste, '  ')));
				$vital_position[$m][$i] = substr($reste, 0, strpos($reste, '  '));
				$aremplacer = array('LW', 'RW');
				$remplace = array($joueursLW, $joueursRW);
				if(substr_count($vital_position[$m][$i], 'G')) $vital_position2[$m][$i] = 5;
				if(substr_count($vital_position[$m][$i], 'D')) $vital_position2[$m][$i] = 4;
				if(substr_count($vital_position[$m][$i], 'LW')) $vital_position2[$m][$i] = 2;
				if(substr_count($vital_position[$m][$i], 'RW')) $vital_position2[$m][$i] = 3;
				if(substr_count($vital_position[$m][$i], 'C')) $vital_position2[$m][$i] = 1;
				$vital_position[$m][$i] = str_replace($aremplacer, $remplace, $vital_position[$m][$i]);
				$reste = trim(substr($reste, strpos($reste, '  ')));
				
				$vital_age[$m][$i] = substr($reste, 0, strpos($reste, '  '));
				$reste = trim(substr($reste, strpos($reste, '  ')));
				$vital_grandeur[$m][$i] = substr($reste, 0, strpos($reste, '  '));
				$vital_grandeur[$m][$i] = str_replace('ft', '\'', $vital_grandeur[$m][$i]);
				$reste = trim(substr($reste, strpos($reste, '  ')));
				$vital_poids[$m][$i] = substr($reste, 0, strpos($reste, 'lbs')-1);
				$reste = trim(substr($reste, strpos($reste, 'lbs') + 3));
				$vital_salaire[$m][$i] = substr($reste, 0, strpos($reste, '  '));
				$vital_salaire2[$m][$i] = preg_replace('/\D/', '', $vital_salaire[$m][$i]);
				$reste = trim(substr($reste, strpos($reste, '  ')));
				$vital_contrat[$m][$i] = substr($reste, 0);
				$aremplacer = array('years', 'year');
				$remplace = array('', '');
				$vital_contrat[$m][$i] = str_replace($aremplacer, $remplace, $vital_contrat[$m][$i]);
				
				$vital_grandeur2[$m][$i] = floatval(substr($vital_grandeur[$m][$i], 0, strpos($vital_grandeur[$m][$i], '\''))) * 12 + trim(substr($vital_grandeur[$m][$i], strpos($vital_grandeur[$m][$i], '\'')+1));
				$i++;
			}
			if($a == 1 && $d) {
				$a++;
			}
			if(substr_count($val, '<PRE>') && $d) {
				$a = 1;
			}
		}
	}
	// Regrouper les PRO ensemblent et les Farm Ensemblent avec les deux pages Rosters / PlayerVitals
	for($m=0;$m<count($name);$m++) {
		for($i=0;$i<count($name[$m]);$i++) {
			for($j=0;$j<count($vital_name[$m]);$j++) {
				$vi_nom = trim($vital_name[$m][$j]);
				$ro_nom = trim($name[$m][$i]);
				$vi_num = trim($vital_numero[$m][$j]);
				$ro_num = trim($numero[$m][$i]);
				if($vi_nom == $ro_nom && $vi_num == $ro_num) {
					$contrat[$m][$i] = $vital_contrat[$m][$j];
					$age[$m][$i] = $vital_age[$m][$j];
					$salaire[$m][$i] = $vital_salaire[$m][$j];
					$salaires[$m][$i] = $vital_salaire2[$m][$j];
					$grandeur[$m][$i] = $vital_grandeur[$m][$j];
					$grandeurs[$m][$i] = $vital_grandeur2[$m][$j];
					$poids[$m][$i] = $vital_poids[$m][$j];
					break 1;
				}
			}
		}
	}
	
	for($m=0;$m<count($name);$m++) {
		if(isset($name2[$m])) {
			for($i=0;$i<count($name2[$m]);$i++) {
				for($j=0;$j<count($vital_name[$m]);$j++) {
					$vi_nom = trim($vital_name[$m][$j]);
					$ro_nom = trim($name2[$m][$i]);
					$vi_num = trim($vital_numero[$m][$j]);
					$ro_num = trim($numero2[$m][$i]);
					if($vi_nom == $ro_nom && $vi_num == $ro_num) {
						$contrat2[$m][$i] = $vital_contrat[$m][$j];
						$age2[$m][$i] = $vital_age[$m][$j];
						$salaire2[$m][$i] = $vital_salaire[$m][$j];
						$salaires2[$m][$i] = $vital_salaire2[$m][$j];
						$grandeur2[$m][$i] = $vital_grandeur[$m][$j];
						$grandeurs2[$m][$i] = $vital_grandeur2[$m][$j];
						$poids2[$m][$i] = $vital_poids[$m][$j];
						break 1;
					}
				}
			}
		}
	}
}
else echo $allFileNotFound.' - '.$Fnm.' - '.$Fnm2;
?>

<script type="text/javascript">
<!--

var number = <?php echo json_encode($numero)?>;
var playerName = <?php echo json_encode($name); ?>;
var position = <?php echo json_encode($position)?>;
var lance = <?php echo json_encode($lance)?>;
var condition = <?php echo json_encode($condition)?>;
var blessure = <?php echo json_encode($blessure)?>;
var intensite = <?php echo json_encode($intensite)?>;
var vitesse = <?php echo json_encode($vitesse)?>;
var force = <?php echo json_encode($force)?>;
var endurance = <?php echo json_encode($endurance)?>;
var durabilite = <?php echo json_encode($durabilite)?>;
var discipline = <?php echo json_encode($discipline)?>;
var patinage = <?php echo json_encode($patinage)?>;
var passe = <?php echo json_encode($passe)?>;
var controle = <?php echo json_encode($controle)?>;
var defense = <?php echo json_encode($defense)?>;
var offense = <?php echo json_encode($offense)?>;
var experience = <?php echo json_encode($experience)?>;
var leadership = <?php echo json_encode($leadership)?>;
var total = <?php echo json_encode($total)?>;
var age = <?php echo json_encode($age)?>;
var salaire = <?php echo json_encode($salaire)?>;
var salaires = <?php echo json_encode($salaires)?>;
var contrat = <?php echo json_encode($contrat)?>;
var grandeur = <?php echo json_encode($grandeur)?>;
var grandeurs = <?php echo json_encode($grandeurs)?>;
var poids = <?php echo json_encode($poids)?>;
var equipe = <?php echo json_encode($equipe)?>;

<?php if(!isset($numero2)) {
	$numero2 = $name2 = $position2 = $lance2 = $condition2 = $blessure2 = $intensite2 = $vitesse2 = $force2 = $endurance2 = $durabilite2 = $discipline2 = $patinage2 = $passe2 = $controle2 = $defense2 = $offense2 = $experience2 = $leadership2 = $total2 = $age2 = $salaire2 = $salaires2 = $contrat2 = $grandeur2 = $grandeurs2 = $poids2 = $equipe2 = "";
} ?>

var number2 = <?php echo json_encode($numero2)?>;
var playerName2 = <?php echo json_encode($name2); ?>;
var position2 = <?php echo json_encode($position2)?>;
var lance2 = <?php echo json_encode($lance2)?>;
var condition2 = <?php echo json_encode($condition2)?>;
var blessure2 = <?php echo json_encode($blessure2)?>;
var intensite2 = <?php echo json_encode($intensite2)?>;
var vitesse2 = <?php echo json_encode($vitesse2)?>;
var force2 = <?php echo json_encode($force2)?>;
var endurance2 = <?php echo json_encode($endurance2)?>;
var durabilite2 = <?php echo json_encode($durabilite2)?>;
var discipline2 = <?php echo json_encode($discipline2)?>;
var patinage2 = <?php echo json_encode($patinage2)?>;
var passe2 = <?php echo json_encode($passe2)?>;
var controle2 = <?php echo json_encode($controle2)?>;
var defense2 = <?php echo json_encode($defense2)?>;
var offense2 = <?php echo json_encode($offense2)?>;
var experience2 = <?php echo json_encode($experience2)?>;
var leadership2 = <?php echo json_encode($leadership2)?>;
var total2 = <?php echo json_encode($total2)?>;
var age2 = <?php echo json_encode($age2)?>;
var salaire2 = <?php echo json_encode($salaire2)?>;
var salaires2 = <?php echo json_encode($salaires2)?>;
var contrat2 = <?php echo json_encode($contrat2)?>;
var grandeur2 = <?php echo json_encode($grandeur2)?>;
var grandeurs2 = <?php echo json_encode($grandeurs2)?>;
var poids2 = <?php echo json_encode($poids2)?>;
var equipe2 = <?php echo json_encode($equipe2)?>;

function selectTeam(x,m) {
	//x : side
	//m : # équipe
	
	var teamBox = document.querySelectorAll("[id^='side"+x+"t']");
	if(teamBox.length > 0) {
		for(var i=0;i<teamBox.length;i++) {
			teamBox[i].style.fontWeight = "normal";
			teamBox[i].style.backgroundColor = "";
			//teamBox[i].style.className = "lien-noir compare-team-entry";
			teamBox[i].classList.remove("compare-selection");
		}
	}
	document.getElementById("side"+x+"t"+m).style.fontWeight = "bold";
	document.getElementById("side"+x+"t"+m).classList.add("compare-selection");
	
	document.getElementById("team"+x).textContent = "";
	var result = document.getElementById("team"+x);
	var tbl = document.createElement('table');
		tbl.style.width='100%';
		tbl.className = "table table-sm table-striped table-hover fixed-column";
	var tbdy = document.createElement('tbody');
	var tmpi = 0;
	if(typeof playerName[m] != 'undefined') {
		for(var i=0;i<playerName[m].length;i++){
			var tr = document.createElement('tr');
				tr.style.height='15px';
				var tempo_color = '2';
				if(i & 1) tempo_color = '1';
				tr.className = "hover"+tempo_color;
				tr.style.cursor = "copy";
				tr.setAttribute("onclick", "javascript:selectPlayer("+x+","+m+","+i+",'p');");
			var td = document.createElement('td');
				td.className = "td"+x+"id"+i + " col-6";
				td.appendChild(document.createTextNode(playerName[m][i]));
				var span = document.createElement("span");
					span.style.display = "none";
					var input = document.createElement("input");
						input.setAttribute("type", "checkbox");
						input.id = "checkbox"+x+"t"+m+"p"+i;
						span.appendChild(input);
					td.appendChild(span);
				tr.appendChild(td);
			var td = document.createElement('td');
				td.className = "td"+x+"id"+i+ " col-1";
				td.appendChild(document.createTextNode(position[m][i]));
				tr.appendChild(td);
			var td = document.createElement('td');
				td.className = "td"+x+"id"+i+ " col-1";
				td.appendChild(document.createTextNode(total[m][i]));
				td.style.textAlign='right';
				tr.appendChild(td);
			var td = document.createElement('td');
				td.className = "td"+x+"id"+i+ " col-1";
				td.appendChild(document.createTextNode(age[m][i]));
				td.style.textAlign='right';
				tr.appendChild(td);
			var td = document.createElement('td');
				td.className = "td"+x+"id"+i+ " col-3";
				td.appendChild(document.createTextNode(salaire[m][i]));
				td.style.textAlign='right';
				tr.appendChild(td);
				
				tbdy.appendChild(tr);
			if(i == 0) var tmpID2 = "checkbox"+x+"t"+m+"p"+i;
		}
		tmpi = i;
	}
	if(typeof playerName2[m] != 'undefined') {
		var tr = document.createElement('tr');
		var td = document.createElement('td');
			td.colSpan = 5;
			td.appendChild(document.createTextNode('<?php echo $compareFarm; ?>'));
			tr.appendChild(td);
			tbdy.appendChild(tr);
		for(var i=0;i<playerName2[m].length;i++){
			var tmpi2 = tmpi + i;
			var tr = document.createElement('tr');
				var tempo_color = '2';
				if(i & 1) tempo_color = '1';
				tr.className = "hover"+tempo_color;
				tr.style.cursor = "copy";
				tr.setAttribute("onclick", "javascript:selectPlayer("+x+","+m+","+i+",'f');");
			var td = document.createElement('td');
				td.className = "td"+x+"idf"+i;
				td.appendChild(document.createTextNode(playerName2[m][i]));
				var span = document.createElement("span");
					span.style.display = "none";
					var input = document.createElement("input");
						input.setAttribute("type", "checkbox");
						input.id = "checkbox"+x+"t"+m+"f"+i;
						span.appendChild(input);
					td.appendChild(span);
				tr.appendChild(td);
			var td = document.createElement('td');
				td.className = "td"+x+"idf"+i;
				td.appendChild(document.createTextNode(position2[m][i]));
				tr.appendChild(td);
			var td = document.createElement('td');
				td.className = "td"+x+"idf"+i;
				td.appendChild(document.createTextNode(total2[m][i]));
				td.style.textAlign='right';
				tr.appendChild(td);
			var td = document.createElement('td');
				td.className = "td"+x+"idf"+i;
				td.appendChild(document.createTextNode(age2[m][i]));
				td.style.textAlign='right';
				tr.appendChild(td);
			var td = document.createElement('td');
				td.className = "td"+x+"idf"+i;
				td.appendChild(document.createTextNode(salaire2[m][i]));
				td.style.textAlign='right';
				tr.appendChild(td);
				
				tbdy.appendChild(tr);
		}
	}
	tbl.appendChild(tbdy);
	result.appendChild(tbl);
	result.scrollTop = 0;
}

function selectPlayer(side,t,p,status) {
	if(status == "p") {
		var tmpCheckbox = document.getElementById("checkbox"+side+"t"+t+"p"+p);
		var tdID = "td"+side+"id"+p;
	}
	if(status == "f") {
		var tmpCheckbox = document.getElementById("checkbox"+side+"t"+t+"f"+p);
		var tdID = "td"+side+"idf"+p;
	}
	if(tmpCheckbox.checked == true) {
		tmpCheckbox.checked = false;
		var x = document.getElementsByClassName(tdID);
		for(var i = 0; i < x.length; i++) {
			x[i].style.backgroundColor = "";
			x[i].classList.remove("compare-selection");
			x[i].style.fontWeight = "normal";
		}
	}
	else {
		tmpCheckbox.checked = true;
		var x = document.getElementsByClassName(tdID);
		for(var i = 0; i < x.length; i++) {
			x[i].classList.add("compare-selection");
			x[i].style.fontWeight = "bold";
		}
	}
}

function searchResult() {
	var inputs1 = document.getElementById("team1").querySelectorAll("input[type='checkbox']:checked");
	var inputs2 = document.getElementById("team2").querySelectorAll("input[type='checkbox']:checked");
	
	if(inputs1.length < 1 || inputs2.length < 1) {
		document.getElementById("windowResult").style.display = "none";
		return;
	}
	
	document.getElementById("windowResult").textContent = "";
	var result = document.getElementById("windowResult");
	var tblRsp = document.createElement('div');
		tblRsp.className = "table-responsive";
	
	var tbl = document.createElement('table');
		tbl.style.width='100%';
		tbl.className = "table table-sm table-striped";
	var tbdy = document.createElement('tbody');

	// Entête - Header
	var tr = document.createElement('tr');
		tr.className = "tableau-top";
		tr.style.textAlign = "center";
	var td = document.createElement('td');
		td.style.width = "20px";
		var a = document.createElement('a');
			a.href = "javascript:return;";
			a.className = "info";
			a.appendChild(document.createTextNode('#'));
				var span = document.createElement('span');
					span.appendChild(document.createTextNode('<?php echo $rostersNumber; ?>'));
				a.appendChild(span);
			td.appendChild(a);
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.textAlign = "left";
		var a = document.createElement('a');
			a.href = "javascript:return;";
			a.className = "lien-blanc";
			a.appendChild(document.createTextNode('<?php echo $rostersName; ?>'));
			td.appendChild(a);
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.width = "20px";
		var a = document.createElement('a');
			a.href = "javascript:return;";
			a.className = "info";
			a.appendChild(document.createTextNode('PO'));
				var span = document.createElement('span');
					span.appendChild(document.createTextNode('<?php echo $rostersPosition; ?>'));
				a.appendChild(span);
			td.appendChild(a);
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.width = "20px";
		var a = document.createElement('a');
			a.href = "javascript:return;";
			a.className = "info";
			a.appendChild(document.createTextNode('<?php echo $rostersHD; ?>'));
				var span = document.createElement('span');
					span.appendChild(document.createTextNode('<?php echo $rostersHDF; ?>'));
				a.appendChild(span);
			td.appendChild(a);
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.width = "20px";
		var a = document.createElement('a');
			a.href = "javascript:return;";
			a.className = "info";
			a.appendChild(document.createTextNode('CD'));
				var span = document.createElement('span');
					span.appendChild(document.createTextNode('Condition'));
				a.appendChild(span);
			td.appendChild(a);
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.width = "20px";
		var a = document.createElement('a');
			a.href = "javascript:return;";
			a.className = "info";
			a.appendChild(document.createTextNode('<?php echo $rostersIJ; ?>'));
				var span = document.createElement('span');
					span.appendChild(document.createTextNode('<?php echo $rostersIJF; ?>'));
				a.appendChild(span);
			td.appendChild(a);
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.width = "20px";
		var a = document.createElement('a');
			a.href = "javascript:return;";
			a.className = "info";
			a.appendChild(document.createTextNode('<?php echo $rostersIT; ?>'));
				var span = document.createElement('span');
					span.appendChild(document.createTextNode('<?php echo $rostersITF; ?>'));
				a.appendChild(span);
			td.appendChild(a);
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.width = "20px";
		var a = document.createElement('a');
			a.href = "javascript:return;";
			a.className = "info";
			a.appendChild(document.createTextNode('<?php echo $rostersSP; ?>'));
				var span = document.createElement('span');
					span.appendChild(document.createTextNode('<?php echo $rostersSPF; ?>'));
				a.appendChild(span);
			td.appendChild(a);
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.width = "20px";
		var a = document.createElement('a');
			a.href = "javascript:return;";
			a.className = "info";
			a.appendChild(document.createTextNode('<?php echo $rostersST; ?>'));
				var span = document.createElement('span');
					span.appendChild(document.createTextNode('<?php echo $rostersSTF; ?>'));
				a.appendChild(span);
			td.appendChild(a);
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.width = "20px";
		var a = document.createElement('a');
			a.href = "javascript:return;";
			a.className = "info";
			a.appendChild(document.createTextNode('<?php echo $rostersEN; ?>'));
				var span = document.createElement('span');
					span.appendChild(document.createTextNode('<?php echo $rostersENF; ?>'));
				a.appendChild(span);
			td.appendChild(a);
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.width = "20px";
		var a = document.createElement('a');
			a.href = "javascript:return;";
			a.className = "info";
			a.appendChild(document.createTextNode('<?php echo $rostersDU; ?>'));
				var span = document.createElement('span');
					span.appendChild(document.createTextNode('<?php echo $rostersDUF; ?>'));
				a.appendChild(span);
			td.appendChild(a);
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.width = "20px";
		var a = document.createElement('a');
			a.href = "javascript:return;";
			a.className = "info";
			a.appendChild(document.createTextNode('<?php echo $rostersDI; ?>'));
				var span = document.createElement('span');
					span.appendChild(document.createTextNode('<?php echo $rostersDIF; ?>'));
				a.appendChild(span);
			td.appendChild(a);
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.width = "20px";
		var a = document.createElement('a');
			a.href = "javascript:return;";
			a.className = "info";
			a.appendChild(document.createTextNode('<?php echo $rostersSK; ?>'));
				var span = document.createElement('span');
					span.appendChild(document.createTextNode('<?php echo $rostersSKF; ?>'));
				a.appendChild(span);
			td.appendChild(a);
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.width = "20px";
		var a = document.createElement('a');
			a.href = "javascript:return;";
			a.className = "info";
			a.appendChild(document.createTextNode('<?php echo $rostersPA; ?>'));
				var span = document.createElement('span');
					span.appendChild(document.createTextNode('<?php echo $rostersPAF; ?>'));
				a.appendChild(span);
			td.appendChild(a);
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.width = "20px";
		var a = document.createElement('a');
			a.href = "javascript:return;";
			a.className = "info";
			a.appendChild(document.createTextNode('<?php echo $rostersPC; ?>'));
				var span = document.createElement('span');
					span.appendChild(document.createTextNode('<?php echo $rostersPCF; ?>'));
				a.appendChild(span);
			td.appendChild(a);
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.width = "20px";
		var a = document.createElement('a');
			a.href = "javascript:return;";
			a.className = "info";
			a.appendChild(document.createTextNode('<?php echo $rostersDF; ?>'));
				var span = document.createElement('span');
					span.appendChild(document.createTextNode('<?php echo $rostersDFF; ?>'));
				a.appendChild(span);
			td.appendChild(a);
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.width = "20px";
		var a = document.createElement('a');
			a.href = "javascript:return;";
			a.className = "info";
			a.appendChild(document.createTextNode('<?php echo $rostersOF; ?>'));
				var span = document.createElement('span');
					span.appendChild(document.createTextNode('<?php echo $rostersOFF; ?>'));
				a.appendChild(span);
			td.appendChild(a);
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.width = "20px";
		var a = document.createElement('a');
			a.href = "javascript:return;";
			a.className = "info";
			a.appendChild(document.createTextNode('<?php echo $rostersEX; ?>'));
				var span = document.createElement('span');
					span.appendChild(document.createTextNode('<?php echo $rostersEXF; ?>'));
				a.appendChild(span);
			td.appendChild(a);
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.width = "20px";
		var a = document.createElement('a');
			a.href = "javascript:return;";
			a.className = "info";
			a.appendChild(document.createTextNode('<?php echo $rostersLD; ?>'));
				var span = document.createElement('span');
					span.appendChild(document.createTextNode('<?php echo $rostersLDF; ?>'));
				a.appendChild(span);
			td.appendChild(a);
		
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.width = "20px";
		var a = document.createElement('a');
			a.href = "javascript:return;";
			a.className = "info";
			a.appendChild(document.createTextNode('<?php echo $rostersOV; ?>'));
				var span = document.createElement('span');
					span.appendChild(document.createTextNode('<?php echo $rostersOVF; ?>'));
				a.appendChild(span);
			td.appendChild(a);
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.width = "25px";
		var a = document.createElement('a');
			a.href = "javascript:return;";
			a.className = "lien-blanc";
			a.appendChild(document.createTextNode('AGE'));
			td.appendChild(a);
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.width = "50px";
		var a = document.createElement('a');
			a.href = "javascript:return;";
			a.className = "info";
			a.appendChild(document.createTextNode('<?php echo $linkedHeightm; ?>'));
				var span = document.createElement('span');
					span.appendChild(document.createTextNode('<?php echo $joueursHeightF; ?>'));
				a.appendChild(span);
			td.appendChild(a);
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.width = "50px";
		var a = document.createElement('a');
			a.href = "javascript:return;";
			a.className = "info";
			a.appendChild(document.createTextNode('<?php echo $linkedWeightm; ?>'));
				var span = document.createElement('span');
					span.appendChild(document.createTextNode('<?php echo $joueursWeight; ?>'));
				a.appendChild(span);
			td.appendChild(a);
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.width = "70px";
		td.style.textAlign = "right";
		var a = document.createElement('a');
			a.href = "javascript:return;";
			a.className = "lien-blanc";
			a.appendChild(document.createTextNode('<?php echo $joueursSalary; ?>'));
			td.appendChild(a);
		tr.appendChild(td);
	var td = document.createElement('td');
		td.style.width = "20px";
		var a = document.createElement('a');
			a.href = "javascript:return;";
			a.className = "info";
			a.appendChild(document.createTextNode('<?php echo $linkedYear; ?>'));
				var span = document.createElement('span');
					span.appendChild(document.createTextNode('<?php echo $linkedYearF; ?>'));
				a.appendChild(span);
			td.appendChild(a);
		tr.appendChild(td);
		tbdy.appendChild(tr);
	
	// Team 1
	var team1IT = 0;
	var team1SP = 0;
	var team1ST = 0;
	var team1EN = 0;
	var team1DU = 0;
	var team1DI = 0;
	var team1SK = 0;
	var team1PA = 0;
	var team1PC = 0;
	var team1DF = 0;
	var team1DFNA = 0;
	var team1SC = 0;
	var team1SCNA = 0;
	var team1EX = 0;
	var team1LD = 0;
	var team1OV = 0;
	var team1Age = 0;
	var team1HGT = 0;
	var team1WGT = 0;
	var team1SAL = 0;
	for(var i=0;i<inputs1.length;i++) {
		var tmpID = inputs1[i].id;
		if(tmpID.indexOf("p") > 0) {
			var tmpTM = tmpID.substr(tmpID.indexOf("t") + 1, tmpID.indexOf("p") - tmpID.indexOf("t") - 1);
			var tmpPlayer = tmpID.substr(tmpID.indexOf("p")+1);
			var tr = showPlayer(tmpID,i);
		}
		if(tmpID.indexOf("f") > 0) {
			var tmpTM = tmpID.substr(tmpID.indexOf("t") + 1, tmpID.indexOf("f") - tmpID.indexOf("t") - 1);
			var tmpPlayer = tmpID.substr(tmpID.indexOf("f")+1);
			var tr = showPlayerFarm(tmpID,i);
		}
		tbdy.appendChild(tr);
		if(tmpID.indexOf("p") > 0) {
			team1IT = team1IT + Number(intensite[tmpTM][tmpPlayer]);
			team1SP = team1SP + Number(vitesse[tmpTM][tmpPlayer]);
			team1ST = team1ST + Number(force[tmpTM][tmpPlayer]);
			team1EN = team1EN + Number(endurance[tmpTM][tmpPlayer]);
			team1DU = team1DU + Number(durabilite[tmpTM][tmpPlayer]);
			team1DI = team1DI + Number(discipline[tmpTM][tmpPlayer]);
			team1SK = team1SK + Number(patinage[tmpTM][tmpPlayer]);
			team1PA = team1PA + Number(passe[tmpTM][tmpPlayer]);
			team1PC = team1PC + Number(controle[tmpTM][tmpPlayer]);
			if(defense[tmpTM][tmpPlayer] != 'NA') team1DF = team1DF + Number(defense[tmpTM][tmpPlayer]);
			else team1DFNA++;
			if(offense[tmpTM][tmpPlayer] != 'NA') team1SC = team1SC + Number(offense[tmpTM][tmpPlayer]);
			else team1SCNA++;
			team1EX = team1EX + Number(experience[tmpTM][tmpPlayer]);
			team1LD = team1LD + Number(leadership[tmpTM][tmpPlayer]);
			team1OV = team1OV + Number(total[tmpTM][tmpPlayer]);
			team1Age = team1Age + Number(age[tmpTM][tmpPlayer]);
			team1HGT = team1HGT + Number(grandeurs[tmpTM][tmpPlayer]);
			team1WGT = team1WGT + Number(poids[tmpTM][tmpPlayer]);
			team1SAL = team1SAL + Number(salaires[tmpTM][tmpPlayer]);
		}
		if(tmpID.indexOf("f") > 0) {
			team1IT = team1IT + Number(intensite2[tmpTM][tmpPlayer]);
			team1SP = team1SP + Number(vitesse2[tmpTM][tmpPlayer]);
			team1ST = team1ST + Number(force2[tmpTM][tmpPlayer]);
			team1EN = team1EN + Number(endurance2[tmpTM][tmpPlayer]);
			team1DU = team1DU + Number(durabilite2[tmpTM][tmpPlayer]);
			team1DI = team1DI + Number(discipline2[tmpTM][tmpPlayer]);
			team1SK = team1SK + Number(patinage2[tmpTM][tmpPlayer]);
			team1PA = team1PA + Number(passe2[tmpTM][tmpPlayer]);
			team1PC = team1PC + Number(controle2[tmpTM][tmpPlayer]);
			if(defense2[tmpTM][tmpPlayer] != 'NA') team1DF = team1DF + Number(defense2[tmpTM][tmpPlayer]);
			else team1DFNA++;
			if(offense2[tmpTM][tmpPlayer] != 'NA') team1SC = team1SC + Number(offense2[tmpTM][tmpPlayer]);
			else team1SCNA++;
			team1EX = team1EX + Number(experience2[tmpTM][tmpPlayer]);
			team1LD = team1LD + Number(leadership2[tmpTM][tmpPlayer]);
			team1OV = team1OV + Number(total2[tmpTM][tmpPlayer]);
			team1Age = team1Age + Number(age2[tmpTM][tmpPlayer]);
			team1HGT = team1HGT + Number(grandeurs2[tmpTM][tmpPlayer]);
			team1WGT = team1WGT + Number(poids2[tmpTM][tmpPlayer]);
			team1SAL = team1SAL + Number(salaires2[tmpTM][tmpPlayer]);
		}
	}
	team1IT = Math.round(team1IT / inputs1.length);
	team1SP = Math.round(team1SP / inputs1.length);
	team1ST = Math.round(team1ST / inputs1.length);
	team1EN = Math.round(team1EN / inputs1.length);
	team1DU = Math.round(team1DU / inputs1.length);
	team1DI = Math.round(team1DI / inputs1.length);
	team1SK = Math.round(team1SK / inputs1.length);
	team1PA = Math.round(team1PA / inputs1.length);
	team1PC = Math.round(team1PC / inputs1.length);
	if(team1DF != 0) team1DF = Math.round(team1DF / (inputs1.length-team1DFNA));
	if(team1SC != 0) team1SC = Math.round(team1SC / (inputs1.length-team1SCNA));
	team1EX = Math.round(team1EX / inputs1.length);
	team1LD = Math.round(team1LD / inputs1.length);
	team1OV = Math.round(team1OV / inputs1.length);
	team1Age = Math.round(team1Age / inputs1.length);
	team1HGT = Math.round(team1HGT / inputs1.length);
	team1WGT = Math.round(team1WGT / inputs1.length);
	team1SAL = team1SAL.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	
	var feet = Math.floor(team1HGT/12);
	var inches = (team1HGT%12);
	team1HGT = feet+'\' '+inches;
	
	// Moyenne Team 1
	var tr = document.createElement('tr');
		tr.style.textAlign = "center";
		tr.style.backgroundColor = "<?php echo $tableauGrey2; ?>";
	var td = document.createElement('td');
		td.appendChild(document.createTextNode('<?php echo $compareAverage; ?>'));
		td.style.paddingTop = "5px";
		td.style.paddingBottom = "5px";
		td.style.fontWeight = "bold";
		td.colSpan = 6;
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team1IT));
		td.style.fontWeight = "bold";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team1SP));
		td.style.fontWeight = "bold";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team1ST));
		td.style.fontWeight = "bold";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team1EN));
		td.style.fontWeight = "bold";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team1DU));
		td.style.fontWeight = "bold";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team1DI));
		td.style.fontWeight = "bold";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team1SK));
		td.style.fontWeight = "bold";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team1PA));
		td.style.fontWeight = "bold";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team1PC));
		td.style.fontWeight = "bold";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team1DF));
		td.style.fontWeight = "bold";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team1SC));
		td.style.fontWeight = "bold";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team1EX));
		td.style.fontWeight = "bold";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team1LD));
		td.style.fontWeight = "bold";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team1OV));
		td.style.fontWeight = "bold";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team1Age));
		td.style.fontWeight = "bold";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team1HGT));
		td.style.fontWeight = "bold";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team1WGT));
		td.style.fontWeight = "bold";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team1SAL));
		td.style.fontWeight = "bold";
		td.style.textAlign = "right";
		td.colSpan = 2;
		tr.appendChild(td);
		tbdy.appendChild(tr);
	
	
	// Team 2
	var team2IT = 0;
	var team2SP = 0;
	var team2ST = 0;
	var team2EN = 0;
	var team2DU = 0;
	var team2DI = 0;
	var team2SK = 0;
	var team2PA = 0;
	var team2PC = 0;
	var team2DF = 0;
	var team2DFNA = 0;
	var team2SC = 0;
	var team2SCNA = 0;
	var team2EX = 0;
	var team2LD = 0;
	var team2OV = 0;
	var team2Age = 0;
	var team2HGT = 0;
	var team2WGT = 0;
	var team2SAL = 0;
	for(var i=0;i<inputs2.length;i++) {
		var tmpID = inputs2[i].id;
		if(tmpID.indexOf("p") > 0) {
			var tmpTM = tmpID.substr(tmpID.indexOf("t") + 1, tmpID.indexOf("p") - tmpID.indexOf("t") - 1);
			var tmpPlayer = tmpID.substr(tmpID.indexOf("p")+1);
			var tr = showPlayer(tmpID,i);
		}
		if(tmpID.indexOf("f") > 0) {
			var tmpTM = tmpID.substr(tmpID.indexOf("t") + 1, tmpID.indexOf("f") - tmpID.indexOf("t") - 1);
			var tmpPlayer = tmpID.substr(tmpID.indexOf("f")+1);
			var tr = showPlayerFarm(tmpID,i);
		}
		tbdy.appendChild(tr);
		if(tmpID.indexOf("p") > 0) {
			team2IT = team2IT + Number(intensite[tmpTM][tmpPlayer]);
			team2SP = team2SP + Number(vitesse[tmpTM][tmpPlayer]);
			team2ST = team2ST + Number(force[tmpTM][tmpPlayer]);
			team2EN = team2EN + Number(endurance[tmpTM][tmpPlayer]);
			team2DU = team2DU + Number(durabilite[tmpTM][tmpPlayer]);
			team2DI = team2DI + Number(discipline[tmpTM][tmpPlayer]);
			team2SK = team2SK + Number(patinage[tmpTM][tmpPlayer]);
			team2PA = team2PA + Number(passe[tmpTM][tmpPlayer]);
			team2PC = team2PC + Number(controle[tmpTM][tmpPlayer]);
			if(defense[tmpTM][tmpPlayer] != 'NA') team2DF = team2DF + Number(defense[tmpTM][tmpPlayer]);
			else team2DFNA++;
			if(offense[tmpTM][tmpPlayer] != 'NA') team2SC = team2SC + Number(offense[tmpTM][tmpPlayer]);
			else team2SCNA++;
			team2EX = team2EX + Number(experience[tmpTM][tmpPlayer]);
			team2LD = team2LD + Number(leadership[tmpTM][tmpPlayer]);
			team2OV = team2OV + Number(total[tmpTM][tmpPlayer]);
			team2Age = team2Age + Number(age[tmpTM][tmpPlayer]);
			team2HGT = team2HGT + Number(grandeurs[tmpTM][tmpPlayer]);
			team2WGT = team2WGT + Number(poids[tmpTM][tmpPlayer]);
			team2SAL = team2SAL + Number(salaires[tmpTM][tmpPlayer]);
		}
		if(tmpID.indexOf("f") > 0) {
			team2IT = team2IT + Number(intensite2[tmpTM][tmpPlayer]);
			team2SP = team2SP + Number(vitesse2[tmpTM][tmpPlayer]);
			team2ST = team2ST + Number(force2[tmpTM][tmpPlayer]);
			team2EN = team2EN + Number(endurance2[tmpTM][tmpPlayer]);
			team2DU = team2DU + Number(durabilite2[tmpTM][tmpPlayer]);
			team2DI = team2DI + Number(discipline2[tmpTM][tmpPlayer]);
			team2SK = team2SK + Number(patinage2[tmpTM][tmpPlayer]);
			team2PA = team2PA + Number(passe2[tmpTM][tmpPlayer]);
			team2PC = team2PC + Number(controle2[tmpTM][tmpPlayer]);
			if(defense2[tmpTM][tmpPlayer] != 'NA') team2DF = team2DF + Number(defense2[tmpTM][tmpPlayer]);
			else team2DFNA++;
			if(offense2[tmpTM][tmpPlayer] != 'NA') team2SC = team2SC + Number(offense2[tmpTM][tmpPlayer]);
			else team2SCNA++;
			team2EX = team2EX + Number(experience2[tmpTM][tmpPlayer]);
			team2LD = team2LD + Number(leadership2[tmpTM][tmpPlayer]);
			team2OV = team2OV + Number(total2[tmpTM][tmpPlayer]);
			team2Age = team2Age + Number(age2[tmpTM][tmpPlayer]);
			team2HGT = team2HGT + Number(grandeurs2[tmpTM][tmpPlayer]);
			team2WGT = team2WGT + Number(poids2[tmpTM][tmpPlayer]);
			team2SAL = team2SAL + Number(salaires2[tmpTM][tmpPlayer]);
		}
	}
	team2IT = Math.round(team2IT / inputs2.length);
	team2SP = Math.round(team2SP / inputs2.length);
	team2ST = Math.round(team2ST / inputs2.length);
	team2EN = Math.round(team2EN / inputs2.length);
	team2DU = Math.round(team2DU / inputs2.length);
	team2DI = Math.round(team2DI / inputs2.length);
	team2SK = Math.round(team2SK / inputs2.length);
	team2PA = Math.round(team2PA / inputs2.length);
	team2PC = Math.round(team2PC / inputs2.length);
	if(team2DF != 0) team2DF = Math.round(team2DF / (inputs2.length-team2DFNA));
	if(team2SC != 0) team2SC = Math.round(team2SC / (inputs2.length-team2SCNA));
	team2EX = Math.round(team2EX / inputs2.length);
	team2LD = Math.round(team2LD / inputs2.length);
	team2OV = Math.round(team2OV / inputs2.length);
	team2Age = Math.round(team2Age / inputs2.length);
	team2HGT = Math.round(team2HGT / inputs2.length);
	team2WGT = Math.round(team2WGT / inputs2.length);
	team2SAL = team2SAL.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	
	var feet = Math.floor(team2HGT/12);
	var inches = (team2HGT%12);
	team2HGT = feet+'\' '+inches;
	
	// Moyenne Team 2
	var tr = document.createElement('tr');
		tr.style.textAlign = "center";
		tr.style.backgroundColor = "<?php echo $tableauGrey2; ?>";
	var td = document.createElement('td');
		td.appendChild(document.createTextNode('<?php echo $compareAverage; ?>'));
		td.style.paddingTop = "5px";
		td.style.paddingBottom = "5px";
		td.style.fontWeight = "bold";
		td.colSpan = 6;
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team2IT));
		td.style.fontWeight = "bold";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team2SP));
		td.style.fontWeight = "bold";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team2ST));
		td.style.fontWeight = "bold";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team2EN));
		td.style.fontWeight = "bold";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team2DU));
		td.style.fontWeight = "bold";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team2DI));
		td.style.fontWeight = "bold";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team2SK));
		td.style.fontWeight = "bold";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team2PA));
		td.style.fontWeight = "bold";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team2PC));
		td.style.fontWeight = "bold";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team2DF));
		td.style.fontWeight = "bold";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team2SC));
		td.style.fontWeight = "bold";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team2EX));
		td.style.fontWeight = "bold";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team2LD));
		td.style.fontWeight = "bold";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team2OV));
		td.style.fontWeight = "bold";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team2Age));
		td.style.fontWeight = "bold";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team2HGT));
		td.style.fontWeight = "bold";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team2WGT));
		td.style.fontWeight = "bold";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(team2SAL));
		td.style.fontWeight = "bold";
		td.style.textAlign = "right";
		td.colSpan = 2;
		tr.appendChild(td);
		tbdy.appendChild(tr);
	
	tbl.appendChild(tbdy);
	tblRsp.appendChild(tbl);
	result.appendChild(tblRsp);
	
	
	document.getElementById("windowResult").style.display = "block";
}

function showPlayer(tmpID,i) {
	var tmpTM = tmpID.substr(tmpID.indexOf("t") + 1, tmpID.indexOf("p") - tmpID.indexOf("t") - 1);
	var tmpPlayer = tmpID.substr(tmpID.indexOf("p")+1);
	
	var tr = document.createElement('tr');
		var tempo_color = '2';
		if(i & 1) tempo_color = '1';
		tr.className = "hover"+tempo_color;
		tr.style.textAlign = "center";
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(number[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
			var a = document.createElement('a');
			a.className = "lien-noir";
			a.style.display = "block";
			a.style.width = "100%";
			a.href = "CareerStatsPlayer.php?csName="+encodeURIComponent(playerName[tmpTM][tmpPlayer]);
			a.target = "_blank";
			a.appendChild(document.createTextNode(playerName[tmpTM][tmpPlayer]));
			td.appendChild(a);
		td.style.textAlign = "left";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(position[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(lance[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(condition[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(blessure[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		var rgb = overallColors(intensite[tmpTM][tmpPlayer]);
		td.style.backgroundColor = 'rgb('+rgb[0]+','+rgb[1]+','+rgb[2]+')';
		td.appendChild(document.createTextNode(intensite[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		var rgb = overallColors(vitesse[tmpTM][tmpPlayer]);
		td.style.backgroundColor = 'rgb('+rgb[0]+','+rgb[1]+','+rgb[2]+')';
		td.appendChild(document.createTextNode(vitesse[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		var rgb = overallColors(force[tmpTM][tmpPlayer]);
		td.style.backgroundColor = 'rgb('+rgb[0]+','+rgb[1]+','+rgb[2]+')';
		td.appendChild(document.createTextNode(force[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		var rgb = overallColors(endurance[tmpTM][tmpPlayer]);
		td.style.backgroundColor = 'rgb('+rgb[0]+','+rgb[1]+','+rgb[2]+')';
		td.appendChild(document.createTextNode(endurance[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		var rgb = overallColors(durabilite[tmpTM][tmpPlayer]);
		td.style.backgroundColor = 'rgb('+rgb[0]+','+rgb[1]+','+rgb[2]+')';
		td.appendChild(document.createTextNode(durabilite[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		var rgb = overallColors(discipline[tmpTM][tmpPlayer]);
		td.style.backgroundColor = 'rgb('+rgb[0]+','+rgb[1]+','+rgb[2]+')';
		td.appendChild(document.createTextNode(discipline[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		var rgb = overallColors(patinage[tmpTM][tmpPlayer]);
		td.style.backgroundColor = 'rgb('+rgb[0]+','+rgb[1]+','+rgb[2]+')';
		td.appendChild(document.createTextNode(patinage[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		var rgb = overallColors(passe[tmpTM][tmpPlayer]);
		td.style.backgroundColor = 'rgb('+rgb[0]+','+rgb[1]+','+rgb[2]+')';
		td.appendChild(document.createTextNode(passe[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		var rgb = overallColors(controle[tmpTM][tmpPlayer]);
		td.style.backgroundColor = 'rgb('+rgb[0]+','+rgb[1]+','+rgb[2]+')';
		td.appendChild(document.createTextNode(controle[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		var rgb = overallColors(defense[tmpTM][tmpPlayer]);
		td.style.backgroundColor = 'rgb('+rgb[0]+','+rgb[1]+','+rgb[2]+')';
		td.appendChild(document.createTextNode(defense[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		var rgb = overallColors(offense[tmpTM][tmpPlayer]);
		td.style.backgroundColor = 'rgb('+rgb[0]+','+rgb[1]+','+rgb[2]+')';
		td.appendChild(document.createTextNode(offense[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		var rgb = overallColors(experience[tmpTM][tmpPlayer]);
		td.style.backgroundColor = 'rgb('+rgb[0]+','+rgb[1]+','+rgb[2]+')';
		td.appendChild(document.createTextNode(experience[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		var rgb = overallColors(leadership[tmpTM][tmpPlayer]);
		td.style.backgroundColor = 'rgb('+rgb[0]+','+rgb[1]+','+rgb[2]+')';
		td.appendChild(document.createTextNode(leadership[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		var rgb = overallColors(total[tmpTM][tmpPlayer]);
		td.style.backgroundColor = 'rgb('+rgb[0]+','+rgb[1]+','+rgb[2]+')';
		td.appendChild(document.createTextNode(total[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(age[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(grandeur[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(poids[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(salaire[tmpTM][tmpPlayer]));
		td.style.textAlign = "right";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(contrat[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	return tr;
}

function showPlayerFarm(tmpID,i) {
	var tmpTM = tmpID.substr(tmpID.indexOf("t") + 1, tmpID.indexOf("f") - tmpID.indexOf("t") - 1);
	var tmpPlayer = tmpID.substr(tmpID.indexOf("f")+1);
	
	var tr = document.createElement('tr');
		var tempo_color = '2';
		if(i & 1) tempo_color = '1';
		tr.className = "hover"+tempo_color;
		tr.style.textAlign = "center";
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(number2[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
			var a = document.createElement('a');
			a.className = "lien-noir";
			a.style.display = "block";
			a.style.width = "100%";
			a.href = "CareerStatsPlayer.php?csName="+encodeURIComponent(playerName2[tmpTM][tmpPlayer]);
			a.target = "_blank";
			a.appendChild(document.createTextNode(playerName2[tmpTM][tmpPlayer]));
			td.appendChild(a);
		td.style.textAlign = "left";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(position2[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(lance2[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(condition2[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(blessure2[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		var rgb = overallColors(intensite2[tmpTM][tmpPlayer]);
		td.style.backgroundColor = 'rgb('+rgb[0]+','+rgb[1]+','+rgb[2]+')';
		td.appendChild(document.createTextNode(intensite2[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		var rgb = overallColors(vitesse2[tmpTM][tmpPlayer]);
		td.style.backgroundColor = 'rgb('+rgb[0]+','+rgb[1]+','+rgb[2]+')';
		td.appendChild(document.createTextNode(vitesse2[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		var rgb = overallColors(force2[tmpTM][tmpPlayer]);
		td.style.backgroundColor = 'rgb('+rgb[0]+','+rgb[1]+','+rgb[2]+')';
		td.appendChild(document.createTextNode(force2[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		var rgb = overallColors(endurance2[tmpTM][tmpPlayer]);
		td.style.backgroundColor = 'rgb('+rgb[0]+','+rgb[1]+','+rgb[2]+')';
		td.appendChild(document.createTextNode(endurance2[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		var rgb = overallColors(durabilite2[tmpTM][tmpPlayer]);
		td.style.backgroundColor = 'rgb('+rgb[0]+','+rgb[1]+','+rgb[2]+')';
		td.appendChild(document.createTextNode(durabilite2[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		var rgb = overallColors(discipline2[tmpTM][tmpPlayer]);
		td.style.backgroundColor = 'rgb('+rgb[0]+','+rgb[1]+','+rgb[2]+')';
		td.appendChild(document.createTextNode(discipline2[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		var rgb = overallColors(patinage2[tmpTM][tmpPlayer]);
		td.style.backgroundColor = 'rgb('+rgb[0]+','+rgb[1]+','+rgb[2]+')';
		td.appendChild(document.createTextNode(patinage2[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		var rgb = overallColors(passe2[tmpTM][tmpPlayer]);
		td.style.backgroundColor = 'rgb('+rgb[0]+','+rgb[1]+','+rgb[2]+')';
		td.appendChild(document.createTextNode(passe2[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		var rgb = overallColors(controle2[tmpTM][tmpPlayer]);
		td.style.backgroundColor = 'rgb('+rgb[0]+','+rgb[1]+','+rgb[2]+')';
		td.appendChild(document.createTextNode(controle2[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		var rgb = overallColors(defense2[tmpTM][tmpPlayer]);
		td.style.backgroundColor = 'rgb('+rgb[0]+','+rgb[1]+','+rgb[2]+')';
		td.appendChild(document.createTextNode(defense2[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		var rgb = overallColors(offense2[tmpTM][tmpPlayer]);
		td.style.backgroundColor = 'rgb('+rgb[0]+','+rgb[1]+','+rgb[2]+')';
		td.appendChild(document.createTextNode(offense2[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		var rgb = overallColors(experience2[tmpTM][tmpPlayer]);
		td.style.backgroundColor = 'rgb('+rgb[0]+','+rgb[1]+','+rgb[2]+')';
		td.appendChild(document.createTextNode(experience2[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		var rgb = overallColors(leadership2[tmpTM][tmpPlayer]);
		td.style.backgroundColor = 'rgb('+rgb[0]+','+rgb[1]+','+rgb[2]+')';
		td.appendChild(document.createTextNode(leadership2[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		var rgb = overallColors(total2[tmpTM][tmpPlayer]);
		td.style.backgroundColor = 'rgb('+rgb[0]+','+rgb[1]+','+rgb[2]+')';
		td.appendChild(document.createTextNode(total2[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(age2[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(grandeur2[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(poids2[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(salaire2[tmpTM][tmpPlayer]));
		td.style.textAlign = "right";
		tr.appendChild(td);
	var td = document.createElement('td');
		td.appendChild(document.createTextNode(contrat2[tmpTM][tmpPlayer]));
		tr.appendChild(td);
	return tr;
}

function overallColors(OV) {
	if(OV != "NA") {
		var r = g = b = 0;
		if (OV > 100) {
			OV = 100;
		}
		else if (OV < 0) {
			OV = 0;
		}
		if (OV <= 50) {
			r = 255;
			g = Math.floor(OV / 50 * 255);
			b = 0;
		}
		if (OV > 50) {
			r = Math.floor(((100 - OV) / 50) * 255);
			g = 255;
			b = 0;
		}
		return [r, g, b];
	}
	else return ['100', '100', '100'];
}




document.addEventListener("DOMContentLoaded", function() { 
	document.getElementById("windowSearch").style.display = "block";	
});

//-->
</script>

<style>

/*fix compare table header colour*/
.table>tbody a.info,
.table>tbody a.lien-blanc {
    color: white;
    /* font-weight: 550; */
}

.compare-team-entry{
    height:25px;
    line-height: 25px;
    vertical-align: middle;
}


/*alternate override for selection*/
.fhlElement a.compare-selection,
.fhlElement .table-striped>tbody>tr>td.compare-selection{
     background-color:var(--color-primary-2);
    color:#fff;
}


</style>

<div class="container px-2">

<div class="card">
	<?php include 'SectionHeader.php';?>
	<div class="card-body px-2 px-md-3">


<div style="display:none; border:solid 1px<?php echo $couleur_contour; ?>" id="windowSearch">
	
	<div class = "row no-gutters">
    	<div class= "col-3" style=" height:300px;overflow: auto; background-color: var(--color-alternate-1);">
    		<?php
    		for($i=0;$i<count($teamList);$i++) {
    			echo '<a id="side1t'.$i.'" style="display:block; width:100%;" class="lien-noir compare-team-entry" href="javascript:selectTeam(\'1\',\''.$i.'\');">'.$teamList[$i].'</a>';
    		}
    		?>
    	</div>
    	<div class= "col-9" id="team1" style=" height:300px; overflow: auto; background-color: var(--color-alternate-3);">
    		<?php echo $compareSelectTeam; ?>
    	</div>
	</div>
	
	<div class = "row no-gutters mt-2 border-top ">
    	<div class= "col-3" style=" height:300px; overflow: auto; background-color: var(--color-alternate-3);">
    		<?php
    		for($i=0;$i<count($teamList);$i++) {
    			echo '<a id="side2t'.$i.'" style="display:block; width:100%;" class="lien-noir compare-team-entry" href="javascript:selectTeam(\'2\',\''.$i.'\');">'.$teamList[$i].'</a>';
    		}
    		?>
    	</div>
    	<div class = "col-9" id="team2" style="height:300px; overflow: auto; background-color: var(--color-alternate-1);">
    		<?php echo $compareSelectTeam; ?>
    	</div>
	</div>
	
	<div class="row mt-2 border-top">
		<div class="col" style="clear:both"><input class="btn btn-primary" onclick="javascript:searchResult();" style="width:100%;" type="button" value="<?php echo $compareCompare; ?>"></div>
	</div>
</div>

<div class="row no-gutters mt-2">
	<div class="col">
		<div id="windowResult" style="display:none; border:solid 1px<?php echo $couleur_contour; ?>"></div>
	</div>
</div>

<!-- </div> -->
		</div> <!-- card body -->
	</div> <!-- card -->
</div> <!-- container -->
<?php include 'footer.php'; ?>