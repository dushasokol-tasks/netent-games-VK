<?
header('Access-Control-Allow-Origin: *');
////////////////////////////////////////////////////////////////////////////////
//reels
//	5	wild stacks vari
//	6	random_wild	symbol_transform	symbol_overlay
//	7	symbol_overlay combinations vari
//	8	bonus type vari
//bonus
//	5	coinwin value
////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////
//correct action check
////////////////////////////////////

$buster10 = '';
$buster12 = '';

if ($_GET['action'] == "freespin" and ($lastActionDB == "spin" or $lastActionDB == "respin" or $lastActionDB == "paytable" or $lastActionDB == "init")) exit;

if ($_GET['action'] == "initfreespin" and $answer == '') exit;

if ($_GET['action'] == "initfreespin" and !isset($winningScatter)) exit;


if ($_GET['action'] == "init") {
	include($gamePath . 'init.php');
	include($gamePath . 'common.php');
	$lastAction = "init";
	$lastRs = $lastRsDB;
}

if ($_GET['action'] == "paytable") {
	if ($answer == '') $table_locked = 0;
	else {
		$table_locked = 1;
		$answ = $answer;
	}
	include($gamePath . 'payt.php');
	$lastAction = "paytable";
	$lastRs = $lastRsDB;
}


if ($_GET['action'] == "initfreespin") {
	$gameover = "false";
	$anim_num = 0;
	$table_locked = 1;

	if (!isset($winningScatter)) exit;

	$extrawildDBcount = 0;
	$temp = explode('_', $wildsDB);
	foreach ($temp as $e) if ($e != '') {
		$temp2 = explode(',', $e);
		$extrawildDB[$temp2[0]][$temp2[1]] = 1;
		$extrawildDBcount++;
		$wilds .= $temp2[0] . "," . $temp2[1] . "_";
	}

	if ($winningScatter == 13) {
		$fs_left = $extrawildDBcount * 3;
		$fs_multiplier = 1;
	}
	if ($winningScatter == 14) {
		$fs_left = 7;
		$fs_multiplier = $extrawildDBcount;
		$output .= "freespin.two.multiplier.total=" . $fs_multiplier . "&";
		$output .= "freespin.two.multiplier.won=" . $fs_multiplier . "&";
	}

	if ($winningScatter == 15) {
		$fs_left = 5;
		$fs_multiplier = 1;
	}

	include('./integr/busters.php');
	if ($buster10 != '')	$fs_left *= 2;

	$fs_played = 0;
	$fs_totalwin = 0;
	$fs_initial = $fs_left;

	$lastAction = "startfreespin";
	$botAction = "freespin";

	for ($i = 0; $i < 5; $i++) {
		for ($j = 0; $j < 3; $j++) {
			if ($extrawildDB[$i][0] == 1) $rs_syms1 = "SYM" . $winningScatter;
			else $rs_syms1 = "SYM5";
			if ($extrawildDB[$i][1] == 1) $rs_syms2 = "SYM" . $winningScatter;
			else $rs_syms2 = "SYM5";
			if ($extrawildDB[$i][2] == 1) $rs_syms3 = "SYM" . $winningScatter;
			else $rs_syms3 = "SYM5";

			if ($extrawildDB[$i][$j] == 1) {
				$output .= "rs.i1.r.i" . $i . ".overlay.i" . $anim_num . ".row=" . $j . "&";
				$output .= "rs.i1.r.i" . $i . ".overlay.i" . $anim_num . ".with=SYM" . $winningScatter . "&";
				$anim_num++;
			}
		}
		$anim_num = 0;
		$output .= "rs.i0.r.i" . $i . ".syms=" . $rs_syms1 . "%2C" . $rs_syms2 . "%2C" . $rs_syms3 . "&";
	}

	$output .= "winning.scatter=SYM" . $winningScatter . "&";

	$output .= "rs.i1.r.i0.syms=SYM16%2CSYM16%2CSYM16&";
	$output .= "rs.i1.r.i1.syms=SYM16%2CSYM16%2CSYM16&";
	$output .= "rs.i1.r.i2.syms=SYM16%2CSYM16%2CSYM16&";
	$output .= "rs.i1.r.i3.syms=SYM16%2CSYM16%2CSYM16&";
	$output .= "rs.i1.r.i4.syms=SYM16%2CSYM16%2CSYM16&";

	if ($winningScatter == 13) {
		$output .= "rs.i2.r.i0.syms=SYM5%2CSYM5%2CSYM5&";
		$output .= "rs.i2.r.i1.syms=SYM4%2CSYM4%2CSYM4&";
		$output .= "rs.i2.r.i2.syms=SYM5%2CSYM5%2CSYM5&";
		$output .= "rs.i2.r.i3.syms=SYM3%2CSYM3%2CSYM3&";
		$output .= "rs.i2.r.i4.syms=SYM5%2CSYM5%2CSYM5&";
	}

	if ($winningScatter == 14) {
		$output .= "rs.i2.r.i0.syms=SYM4%2CSYM4%2CSYM4&";
		$output .= "rs.i2.r.i1.syms=SYM5%2CSYM5%2CSYM5&";
		$output .= "rs.i2.r.i2.syms=SYM4%2CSYM4%2CSYM4&";
		$output .= "rs.i2.r.i3.syms=SYM3%2CSYM3%2CSYM3&";
		$output .= "rs.i2.r.i4.syms=SYM4%2CSYM4%2CSYM4&";
	}

	if ($winningScatter == 15) {
		$output .= "rs.i2.r.i0.syms=SYM3%2CSYM3%2CSYM3&";
		$output .= "rs.i2.r.i1.syms=SYM5%2CSYM5%2CSYM5&";
		$output .= "rs.i2.r.i2.syms=SYM3%2CSYM3%2CSYM3&";
		$output .= "rs.i2.r.i3.syms=SYM4%2CSYM4%2CSYM4&";
		$output .= "rs.i2.r.i4.syms=SYM3%2CSYM3%2CSYM3&";
	}



	$output .= "rs.i0.id=basic&";
	$output .= "rs.i1.id=respin&";
	$output .= "rs.i2.id=freespin&";
	$output .= "current.rs.i0=freespin&previous.rs.i0=respin&";
	$output .= "clientaction=initfreespin&nextaction=freespin&";
	$output .= "next.rs=freespin&last.rs=respin&";
	$output .= "freespins.win.cents=0&freespins.win.coins=0&freespins.totalwin.coins=0&freespins.totalwin.cents=0&";
	$output .= "freespins.left=" . $fs_left . "&freespins.total=" . $fs_left . "&freespins.initial=" . $fs_left . "&";
	$output .= "freespins.denomination=1.000&freespins.wavecount=1freespins.betlevel=1&freespins.multiplier=" . $fs_multiplier . "&";
	$output .= "gamestate.current=freespin&gamestate.history=basic%2Crespin&gamestate.stack=basic%2Cfreespin&";
	$output .= "bet.denomination=1&bet.betlevel=1&bet.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C21%2C22%2C23%2C24%2C25%2C26%2C27%2C28%2C29&freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C21%2C22%2C23%2C24%2C25%2C26%2C27%2C28%2C29&";
}



if ($_GET['action'] == "spin" or $_GET['action'] == "respin" or $_GET['action'] == "freespin") {
	$gameover = "true";
	$overlaySym = "";
	$table_locked = 1;

	$bonusInfo = explode(";", $answer);
	foreach ($bonusInfo as $e => $v)
		if ($v != '') {
			$a = explode("=", $v);
			$$a[0] = $a[1];
		}

	$lastAction = "spin";
	if ($lastActionDB == "freespin" and $_GET['action'] == "freespin") $lastAction = "freespin";
	if ($lastActionDB == "startfreespin" and $_GET['action'] == "freespin") $lastAction = "freespin";

	////////////////////
	//symbol generation
	////////////////////
	$i = 0;

	if ($lastAction == "freespin") {
		$query = "SELECT * FROM ns.bonuses where payRate='" . $payRate . "' and gameId='" . $gameId . "' and (type=0 or type=1 or type=2 or type=3 or type=4 or type=5) order by type asc;";
		$fs_left--;
		$fs_played++;
	} else	$query = "SELECT * FROM ns.reels where payRate=" . $payRate . " and gameId=" . $gameId . " order by id asc;";

	$result = mysql_query($query);

	while ($reels = mysql_fetch_assoc($result)) {
		$reel[$i] = explode("_", $reels['symbols']);
		$i++;
	}

	for ($i = 0; $i < 5; $i++) {
		$length = (count($reel[$i]) - 1);
		$pos = round(rand(0, $length));

		$symbols[$i][0] = $reel[$i][$pos];
		if ($pos == $length) {
			$symbols[$i][1] = $reel[$i][0];
			$symbols[$i][2] = $reel[$i][1];
		} elseif ($pos == ($length - 1)) {
			$symbols[$i][1] = $reel[$i][$length];
			$symbols[$i][2] = $reel[$i][0];
		} else {
			$symbols[$i][1] = $reel[$i][$pos + 1];
			$symbols[$i][2] = $reel[$i][$pos + 2];
		}
	}

	include('./integr/busters.php');

	//if($lastAction!="freespin" and $lastAction!="initfreespin" and $lastActionDB!="freespin"){$symbols[0][0]=0;$symbols[4][0]=0;$symbols[2][0]=0;}
	//if($lastAction!="freespin" and $lastAction!="initfreespin"){$symbols[0][1]=1;$symbols[1][1]=1;$symbols[2][1]=1;}

	/*
//if($lastAction=="freespin")
{

$symbols[0][0]=8;$symbols[0][1]=1;$symbols[0][2]=5;
$symbols[1][0]=8;$symbols[1][1]=1;$symbols[1][2]=8;
$symbols[2][0]=7;$symbols[2][1]=1;$symbols[2][2]=7;
$symbols[3][0]=6;$symbols[3][1]=1;$symbols[3][2]=6;
$symbols[4][0]=5;$symbols[4][1]=11;$symbols[4][2]=5;

}
*/



	//if($lastActionDB=="paytable")
	/*
if($lastActionDB=="init")
{
    $symbols[2][0]=14;$symbols[1][0]=14;$symbols[3][0]=14;
}
*/
	//if($lastActionDB=="respin1")$symbols[1][2]=13;

	//echo $lastActionDB."&!&";


	//if($lastAction=="freespin")
	//{
	//$symbols[0][0]=3;
	//$symbols[2][0]=3;
	//$symbols[1][0]=3;
	//$symbols[4][0]=3;

	//$symbols[0][2]=0;
	//$symbols[2][2]=0;
	//$symbols[4][2]=0;

	//}


	$extrawildDBcount = 0;
	$temp = explode('_', $wildsDB);
	foreach ($temp as $e) if ($e != '') {
		$temp2 = explode(',', $e);
		$extrawildDB[$temp2[0]][$temp2[1]] = 1;
		$extrawildDBcount++;
		$symb_combs .= $temp2[0] . "," . $temp2[1] . ";";
	}

	//		$symb_combs=$symb_combs."<".$extrawildDBcount.">;";

	/////////////////////		extrascatters on reel0 and reel4 in respins
	if ($lastActionDB == "respin1" or $lastActionDB == "respin") {
		if ($winningScatter == 13) $sideReelsScatterChance = explode(",", $reel[9][0]);
		if ($winningScatter == 14) $sideReelsScatterChance = explode(",", $reel[9][1]);
		if ($winningScatter == 15) $sideReelsScatterChance = explode(",", $reel[9][2]);
		if (rand(0, 1000) < $sideReelsScatterChance[0]) {
			$y = round(rand(0, 2));
			$newScatter[0][$y] = $winningScatter;
			$symbols[0][$y] = $winningScatter;
		}
		if (rand(0, 1000) < $sideReelsScatterChance[1]) {
			$y = round(rand(0, 2));
			$newScatter[4][$y] = $winningScatter;
			$symbols[4][$y] = $winningScatter;
		}
	}
	/////////////////////
	/////////////////////		extrascatters on all  in bonus
	if ($lastAction == "freespin") {
		if ($winningScatter == 13) $sideReelsScatterChance = explode(",", $reel[5][0]);
		if ($winningScatter == 14) $sideReelsScatterChance = explode(",", $reel[5][1]);
		if ($winningScatter == 15) $sideReelsScatterChance = explode(",", $reel[5][2]);

		//	$steps=round

		if (rand(0, 1000) < $sideReelsScatterChance[0]) {
			$y = round(rand(0, 2));
			$symbols[0][$y] = $winningScatter;
		}
		if (rand(0, 1000) < $sideReelsScatterChance[1]) {
			$y = round(rand(0, 2));
			$symbols[1][$y] = $winningScatter;
		}
		if (rand(0, 1000) < $sideReelsScatterChance[2]) {
			$y = round(rand(0, 2));
			$symbols[2][$y] = $winningScatter;
		}
		if (rand(0, 1000) < $sideReelsScatterChance[3]) {
			$y = round(rand(0, 2));
			$symbols[3][$y] = $winningScatter;
		}
		if (rand(0, 1000) < $sideReelsScatterChance[4]) {
			$y = round(rand(0, 2));
			$symbols[4][$y] = $winningScatter;
		}
	}
	/////////////////////

	$scatterSymbCount = 0;
	$scatter13 = 0;
	$scatter14 = 0;
	$scatter15 = 0;
	$allScatters = 0;
	foreach ($symbols as $tReel => $t)
		foreach ($t as $tRow => $e) {
			if ($symbols[$tReel][$tRow] == 13) {
				if ($extrawildDB[$tReel][$tRow] != 1) {
					$scatter13++;
					$wilds .= $tReel . "," . $tRow . "_";
					$extrawildDB[$tReel][$tRow] = 1;
				}
			} elseif ($symbols[$tReel][$tRow] == 14) {
				if ($extrawildDB[$tReel][$tRow] != 1) {
					$scatter14++;
					$wilds .= $tReel . "," . $tRow . "_";
					$extrawildDB[$tReel][$tRow] = 1;
				}
			} elseif ($symbols[$tReel][$tRow] == 15) {
				if ($extrawildDB[$tReel][$tRow] != 1) {
					$scatter15++;
					$wilds .= $tReel . "," . $tRow . "_";
					$extrawildDB[$tReel][$tRow] = 1;
					if ($lastAction == "freespin") {
						$symbols[$tReel][$tRow] = $winningScatter;
						$newWilds[$tReel][$tRow] = 1;
						$newStr .= $tReel . "_" . $tRow . ",";
					}
				}
			}
			if ($extrawildDB[$tReel][$tRow] == 1) {
				$allScatters++;
				$nearwin[$tReel] = 1;
			}
		}
	$scatterSymbCount = $scatter13 + $scatter14 + $scatter15;
	$allScatters += $scatterSymbCount;

	if ($lastActionDB == "respin1" or $lastActionDB == "respin") {
		if ($scatterSymbCount > 0) $lastAction = "respin";
		else $lastAction = "fChance";
		$wilds .= $wildsDB;
	}

	if ($_GET['action'] == "spin" and ($lastActionDB != "respin1" or $lastActionDB != "respin")) {
		if ($scatterSymbCount > 1) {
			$lastAction = "respin";
			if ($answer == '' or isset($freeRoundsLeft)) {
				$lastAction = "respin1";
				if ($scatter13 == 0 and $scatter14 == 0) $winningScatter = 15;
				elseif ($scatter14 == 0 and $scatter15 == 0) $winningScatter = 13;
				elseif ($scatter13 == 0 and $scatter15 == 0) $winningScatter = 14;
				elseif ($scatter13 == 0) {
					if (round(rand(0, 1) == 1)) $winningScatter = 14;
					else $winningScatter = 15;
				} elseif ($scatter14 == 0) {
					if (round(rand(0, 1) == 1)) $winningScatter = 13;
					else $winningScatter = 15;
				} elseif ($scatter15 == 0) {
					if (round(rand(0, 1) == 1)) $winningScatter = 13;
					else $winningScatter = 14;
				} else $winningScatter = round(rand(13, 15));
			}
			if (($answer == '' or isset($freeRoundsLeft)) and $scatterSymbCount > 2)		$lastAction = "respin";
			if ($lastActionDB == "endfreespin")		$lastAction = "respin1";
			if ($lastAction == "respin" and $lastActionDB != "respin1")	$lastAction = "respin1";
		} else $wilds = '';


		if ($lastAction != "respin" and $lastAction != "respin1") {
			if (rand(0, 1000) < $reel[5][0]) $lastAction = "HAMMER";
			elseif (rand(0, 1000) < $reel[5][1] and $lastAction != "HAMMER") $lastAction = "ARROW";
			elseif (rand(0, 1000) < $reel[5][2] and $lastAction != "ARROW") $lastAction = "SWORD";
		}
		//$lastAction="SWORD";
		if ($lastAction == "SWORD") {
			$length = (count($reel[8]) - 1);
			$pos = round(rand(0, $length));
			$pattern_sw = $reel[8][$pos];
			$pattern_sws = explode(",", $pattern_sw);
			$patternIndex = $pattern_sws[0];
			$winComb = $pattern_sws[1];
			// 	    $patternIndex=9;
			//	    $winComb=3;
		}

		if ($lastAction == "HAMMER") {
			$length = (count($reel[6]) - 1);
			$pos = round(rand(0, $length));
			$winComb = $reel[6][$pos];
		}

		if ($lastAction == "ARROW") {
			$length = (count($reel[7]) - 1);
			$pos = round(rand(0, $length));
			$steps = $reel[7][$pos];
		}

		if ($lastAction == "SWORD" or $lastAction == "ARROW" or $lastAction == "HAMMER") {
			include('patterns.php');
			$overlaySym = 1;
		}
	}

	echo "WSR=" . $winningScatter . "&";
	if ($winningScatter != "")		$output .= "winning.scatter=SYM" . $winningScatter . "&";


	if (($lastAction == "respin" and $lastActionDB == "respin1") or ($lastAction == "respin" and $lastActionDB == "respin") or $lastAction == "fChance") {
		foreach ($symbols as $tReel => $t)
			foreach ($t as $tRow => $e) {
				$symbols[$tReel][$tRow] = "16";

				if ($lastAction == "respin" and $extrawildDB[$tReel][$tRow] == 1)
					$symbols[$tReel][$tRow] = $winningScatter;
			}
		$symbolsOverlayed = $symbols;
	}

	//if($lastAction=="respin" and $lastActionDB!="respin1")    $symbolsOverlayed=$symbols;

	if ($lastAction == "fChance") {
		if ($extrawildDBcount > 2) $lastAction = "initfreespin";
		else {
			$x = round(rand(0, 4));
			$y = round(rand(0, 2));
			if ($extrawildDB[$x][$y] == 1) {
				if ($y == 0 or $y == 2) $y = 1;
				else $y = 0;
				if ($extrawildDB[$x][$y] == 1)
					if ($x == 0 or $x == 4) $x = 1;
					else $x = 0;
			}

			$blueScatterRate = $reel[5][3];
			$greenScatterRate = $reel[5][4];
			$redScatterRate = $reel[5][5];

			if ($winningScatter == 13) {
				if (rand(0, 1000) < $blueScatterRate) $fChanceSymbol = 13;
				else $fChanceSymbol = 17;
			}

			if ($winningScatter == 14) {
				if (rand(0, 1000) < $greenScatterRate) $fChanceSymbol = 14;
				else $fChanceSymbol = 17;
			}

			if ($winningScatter == 15) {
				if (rand(0, 1000) < $redScatterRate) $fChanceSymbol = 15;
				else $fChanceSymbol = 17;
			}

			$symbols[$x][$y] = $fChanceSymbol;
			$output .= "ws.i0.pos.i0=" . $x . "%2C" . $y . "&";
			$output .= "rs.i0.r.i" . $x . ".overlay.i0.finalchance.mode=true&";

			if ($fChanceSymbol != 17)	$wildsDB .= $x . "," . $y . "_";
			else {
				/////////////////////	multiplier set 50% (3;10), 30% (11;25) 15% (26;42) 4,5% (43;50) 0,5% (51;100)
				$multiplierSet = (rand(0, 1000));
				if ($multiplierSet < 500) $fChanceMul = round(rand(3, 10));
				elseif ($multiplierSet < 800) $fChanceMul = round(rand(11, 25));
				elseif ($multiplierSet < 950) $fChanceMul = round(rand(26, 42));
				elseif ($multiplierSet < 995) $fChanceMul = round(rand(43, 50));
				else $fChanceMul = round(rand(51, 100));

				$fChanceTotal_win = $fChanceMul * $betDB * $linesDB;
			}
		}
	}

	if ($lastAction != "initfreespin" and $lastAction != "fChance" and $lastAction != "respin") {
		include($gamePath . 'lines.php');
	} else $symb_combs .= " fake spin;";

	if ($overlaySym != "") $output .= "overlaySym=SYM" . $overlaySym . "&";

	//////////
	//draw rs
	//////////
	$wild = 0;
	$nearwinStr = '';

	$anim_num = 0;

	for ($i = 0; $i < 5; $i++) {
		if ($overlaySym != 0 or $lastAction == "fChance") {
			for ($j = 0; $j < 3; $j++) { {

					if ($lastAction == "SWORD" or $lastAction == "HAMMER" or $lastAction == "ARROW" or ($lastAction == "freespin" and $winningScatter == 15)) {
						if ($newWilds[$i][$j] == 1) {
							$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".info=new&";
							$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".with=SYM" . $overlaySym . "&";
							$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".row=" . $j . "&";
						}
						if ($symbols[$i][$j] == $overlaySym) {
							$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".with=SYM" . $overlaySym . "&";
							$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".row=" . $j . "&";
							$anim_num++;
						}
					} elseif ($lastAction == "fChance") {

						if ($symbols[$i][$j] == "17") {
							$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".with=SYM17&";
							$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".row=" . $j . "&";
							$anim_num++;
						}
						if ($symbols[$i][$j] == "13" or $symbols[$i][$j] == "14" or $symbols[$i][$j] == "15") {
							$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".with=SYM" . $winningScatter . "&";
							$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".row=" . $j . "&";
							$anim_num++;
						}
					} else {
						$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".with=SYM" . $overlaySym . "&";
						$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".row=" . $j . "&";
						$anim_num++;
					}
				}
			}
			$anim_num = 0;
		}

		$lastRs .= "rs.i0.r.i" . $i . ".syms=SYM" . $symbolsOverlayed[$i][0] . ",SYM" . $symbolsOverlayed[$i][1] . ",SYM" . $symbolsOverlayed[$i][2] . "&";

		$output .= "rs.i0.r.i" . $i . ".hold=false&";
		//    echo "a=".$nearwin[1]."&";

	}
	$output .= $lastRs;

	if ($lastAction == "spin" or ($lastAction == "respin" and $lastActionDB != "respin1") or $lastAction == "respin1") {
		if ($nearwin[1] == 1) $nearwinStr = '2%2C3';
		else
	if ($nearwin[2] == 1) $nearwinStr = '3';

		//    echo "a=".$nearwin[1]."&";
	}

	if ($nearwinStr != '')	$output .= "rs.i0.nearwin=" . $nearwinStr . "&";

	/////////////////////////////
	//draw ws			
	///////////////////////////
	$anim_num = 0;
	$total_win = 0;

	if ($lastAction == "fChance") {
		$total_win = $fChanceTotal_win;

		$output .= "ws.i0.reelset=respin&";
		$output .= "ws.i0.sym=SYM" . $fChanceSymbol . "&";
		$output .= "ws.i0.betline=null&";
		if ($fChanceSymbol == 17) {
			$output .= "ws.i0.types.i0.cents=" . ($total_win * $denomDB) . "&";
			$output .= "ws.i0.types.i0.coins=" . $total_win . "&";
			$output .= "ws.i0.types.i0.wintype=coins&ws.i0.direction=left_to_right&";
		} else {
			$output .= "ws.i0.types.i0.wintype=freespins&ws.i0.direction=left_to_right&";
			$lastAction = "initfreespin";
		}
		$anim_num = 1;
	}

	if ($lastAction == "freespin") {

		$add_fs = 0;
		$add_mul;
		$ani = 0;
		for ($i = 0; $i < 5; $i++) {
			for ($j = 0; $j < 3; $j++) {
				if ($symbols[$i][$j] == $winningScatter) {
					if ($winningScatter == 13) {
						$add_fs += 3;
						$output .= "ws.i0.pos.i" . $ani . "=" . $i . "%2C" . $j . "&";
						$ani++;
					}
					if ($winningScatter == 14)	$fs_multiplier += 1;
				}
			}
		}

		if ($add_fs != 0) {
			$output .= "ws.i0.reelset=freespin&";
			$output .= "ws.i0.types.i0.wintype=freespins&";
			$output .= "ws.i0.types.i0.multipliers=1&";
			$output .= "ws.i0.types.i0.freespins=" . $add_fs . "&";
			$output .= "ws.i0.direction=left_to_right&";
			$output .= "ws.i0.sym=SYM" . $winningScatter . "&";
			$output .= "ws.i0.betline=null&";
			$anim_num = 1;
		}
	}

	foreach ($win as $e => $v) {
		$tmp = explode("_", $v);

		if ($lastAction != "freespin") $output .= "ws.i" . $anim_num . ".reelset=basic&";
		else {
			$output .= "ws.i" . $anim_num . ".reelset=freespin&";

			$tmp[0] *= $fs_multiplier;
		}

		if ($lastAction != "addfreespin" and $lastAction != "freespin" and $lastAction != "endfreespin" and $lastAction != "respin" and $lastAction != "respin1")
			if ($buster12 != '') {
				$tmp[0] *= 2;
				$symb_combs .= " bus=$buster12, " . $tmp[0] . ";";
			}

		$right_coins = $tmp[0] * $denomDB;

		$output .= "ws.i" . $anim_num . ".sym=SYM" . $symbOverlays[$e] . "&";

		$output .= "ws.i" . $anim_num . ".direction=left_to_right&";
		$output .= "ws.i" . $anim_num . ".betline=" . $e . "&";
		$output .= "ws.i" . $anim_num . ".types.i0.coins=" . $tmp[0] . "&";
		$output .= "ws.i" . $anim_num . ".types.i0.wintype=coins&";

		$total_win += $tmp[0];

		$ani = explode(";", $tmp[1]);
		$i = 0;

		foreach ($ani as $smb) {
			$output .= "ws.i" . $anim_num . ".pos.i" . $i . "=" . $smb . "&";

			$output .= "ws.i" . $anim_num . ".types.i0.coins=" . $tmp[0] . "&";
			$output .= "ws.i" . $anim_num . ".types.i0.cents=" . $right_coins . "&";
			$i++;
		}

		$anim_num++;
	}

	if ($lastAction == "freespin") {

		$fs_total = $fs_left + $fs_played;
		$fs_totalwin += $total_win;
		$fs_left += $add_fs;

		if ($fs_left > 0) {
			$output .= "freespins.wavecount=1&";
			$output .= "freespins.betlevel=1&";
			$output .= "freespins.multiplier=" . $fs_multiplier . "&";

			$output .= "next.rs=freespin&";
			$output .= "last.rs=freespin&";
			$output .= "previous.rs.i0=freespin&";

			$output .= "clientaction=freespin&";
			$output .= "nextaction=freespin&";

			$output .= "gamestate.history=basic%2Crespin%2Cfreespin&";
			$output .= "gamestate.current=freespin&";
			$output .= "gamestate.stack=basic%2Cfreespin&";
			$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C21%2C22%2C23%2C24%2C25%2C26%2C27%2C28%2C29&";

			$output .= "current.rs.i0=freespin&";
			$output .= "rs.i0.id=freespin&";

			$output .= "historybutton=false&";

			$gameover = 'false';
			$table_locked = 1;
			$botAction = "freespin";
		} else {
			$output .= "freespins.wavecount=1&";
			$output .= "freespins.multiplier=" . $fs_multiplier . "&";
			$output .= "freespins.betlevel=1&";

			$output .= "next.rs=basic&";
			$output .= "last.rs=freespin&";
			$output .= "previous.rs.i0=freespin&";

			$output .= "clientaction=freespin&";
			$output .= "nextaction=spin&";

			$output .= "gamestate.history=basic%2Crespin%2Cfreespin&";
			$output .= "gamestate.current=basic&";
			$output .= "gamestate.stack=basic&";
			$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C21%2C22%2C23%2C24%2C25%2C26%2C27%2C28%2C29&";

			$output .= "current.rs.i0=basic&";
			$output .= "rs.i0.id=freespin&";

			$table_locked = 0;
			$botAction = "spin";
		}

		$multiplier = $fs_multiplier;

		$output .= "freespins.denomination=1.000&";

		$output .= "freespins.initial=" . $fs_initial . "&";
		$output .= "freespins.total=" . $fs_total . "&";
		$output .= "freespins.left=" . $fs_left . "&";
		$output .= "freespins.played=" . $fs_played . "&";
		$output .= "freespins.totalwin.coins=" . $fs_totalwin . "&";
		$output .= "freespins.totalwin.cents=" . $fs_totalwin . "&";
		$output .= "freespins.win.cents=" . $fs_totalwin . "&";
		$output .= "freespins.win.coins=" . $fs_totalwin . "&";
	} elseif ($lastAction == "initfreespin") {
		if ($winningScatter == 13) {
			$fs_strt = $extrawildDBcount * 3;
			$output .= "freespins.total=" . $fs_strt . "&";
			$output .= "freespins.initial=" . $fs_strt . "&";
			$output .= "freespins.left=" . $fs_strt . "&";
		}
		if ($winningScatter == 14) {
			$output .= "freespins.total=7&";
			$output .= "freespins.initial=7&";
			$output .= "freespins.left=7&";
		}
		if ($winningScatter == 15) {
			$output .= "freespins.total=5&";
			$output .= "freespins.initial=5&";
			$output .= "freespins.left=5&";
		}

		$output .= "freespins.multiplier=1&";
		$output .= "next.rs=freespin&";
		$output .= "freespins.totalwin.coins=0&";
		$output .= "gamestate.history=basic%2Crespin&";
		$output .= "freespins.denomination=1.000&";
		$output .= "last.rs=respin&";
		$output .= "gamestate.current=freespin&";
		$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C21%2C22%2C23%2C24%2C25%2C26%2C27%2C28%2C29&";
		$output .= "freespins.win.cents=0&";
		$output .= "clientaction=respin&";
		$output .= "freespins.wavecount=1&";
		$output .= "freespins.win.coins=0&";
		$output .= "freespins.betlevel=1&";
		$output .= "nextaction=freespin&";
		$output .= "current.rs.i0=freespin&";
		$output .= "rs.i0.id=respin&";
		$output .= "previous.rs.i0=respin&";
		$output .= "gamestate.stack=basic%2Cfreespin&";
		$output .= "freespins.totalwin.cents=0&";

		$wilds = $wildsDB;
		$table_locked = 1;
		$botAction = "initfreespin";
	} elseif ($lastAction == "fChance") {
		$output .= "next.rs=basic&";
		$output .= "gamestate.history=basic%2Crespin&";
		$output .= "last.rs=respin&";
		$output .= "gamestate.current=basic&";
		$output .= "clientaction=respin&";
		$output .= "nextaction=spin&";
		$output .= "current.rs.i0=basic&";
		$output .= "rs.i0.id=respin&";
		$output .= "previous.rs.i0=respin&";
		$output .= "gamestate.stack=basic&";

		$table_locked = 0;
		$wilds = '';
		$botAction = "spin";
	} elseif ($lastAction == "respin" or $lastAction == "respin1") {
		$gameover = "false";
		$table_locked = 1;

		$output .= "next.rs=respin&";
		$output .= "gamestate.current=respin&";
		$output .= "current.rs.i0=respin&";
		$output .= "nextaction=respin&";
		$output .= "gameover=false&";
		$output .= "gamestate.history=basic%2Crespin&";
		$output .= "gamestate.stack=basic%2Crespin&";

		if ($lastAction == "respin") {
			$output .= "rs.i0.id=respin&";
			$output .= "last.rs=respin&";
			$output .= "clientaction=respin&";
			$output .= "previous.rs.i0=respin&";
		} else {
			$output .= "rs.i0.id=basic&";
			$output .= "clientaction=spin&";
		}
		$botAction = "respin";
	} elseif ($lastAction == "ARROW") {
		$output .= "basefeature.mode=ARROW&";
		$output .= "gamestate.current=basic&";
		$output .= "clientaction=spin&";
		$output .= "nextaction=spin&";
		$output .= "pattern.index=$patternIndex&";
		$output .= "gamestate.stack=basic&";
		$output .= "next.rs=basic&";
		$output .= "gamestate.history=basic&";
		$output .= "current.rs.i0=basic&rs.i0.id=basic&";

		$table_locked = 0;
		$lastAction = "spin";
		$symb_combs = "ARROW" . $steps . ";" . $arrowsLog . ";" . $symb_combs;
		$botAction = "spin";
	} elseif ($lastAction == "HAMMER") {
		$output .= "basefeature.mode=HAMMER&";
		$output .= "gamestate.current=basic&";
		$output .= "clientaction=spin&";
		$output .= "nextaction=spin&";
		$output .= "pattern.index=$patternIndex&";
		$output .= "gamestate.stack=basic&";
		$output .= "next.rs=basic&";
		$output .= "gamestate.history=basic&";
		$output .= "current.rs.i0=basic&rs.i0.id=basic&";

		$table_locked = 0;
		$lastAction = "spin";
		$symb_combs = "HAMMER" . $winComb . ";" . $symb_combs;
		$botAction = "spin";
	} elseif ($lastAction == "SWORD") {
		$output .= "basefeature.mode=SWORD&";
		$output .= "gamestate.current=basic&";
		$output .= "clientaction=spin&";
		$output .= "nextaction=spin&";
		$output .= "pattern.index=$patternIndex&";
		$output .= "gamestate.stack=basic&";
		$output .= "next.rs=basic&";
		$output .= "gamestate.history=basic&";
		$output .= "current.rs.i0=basic&rs.i0.id=basic&";

		$table_locked = 0;
		$lastAction = "spin";
		$symb_combs = "SWORD" . $patternIndex . ",p" . $winComb . ";" . $symb_combs;
		$botAction = "spin";
	} else {
		$output .= "rs.i0.id=basic&";
		$output .= "current.rs.i0=basic&";
		$output .= "last.rs=basic&";
		$output .= "gamestate.current=basic&";
		$output .= "clientaction=spin&";
		$output .= "gamestate.stack=basic&";
		$output .= "gamestate.history=basic&";
		$output .= "nextaction=spin&";

		$table_locked = 0;
		$botAction = "spin";
	}

	//$lastAction="startfreespin";

	$spincost = 0;
	if ($lastAction != 'freespin' and $lastAction != 'endfreespin' and $lastAction != 'initfreespin' and $lastAction != 'respin' and $lastAction != 'fChance') {
		$spin_to_history = 1;
		$spincost = $betDB * $linesDB * $denomDB * 0.01;
	}

	$credit /= 100;

	$real_win = $total_win * $denomDB * 0.01;

	//if($lastAction!='random_wilds' and $lastAction!='stackSpin' and $lastAction!='freespin' and $lastAction!='endfreespin') {$credit-=$spincost;}

	if (isset($freeRoundsLeft)) $spincost = 0;
	$credit -= $spincost;

	$credit += $real_win;

	$creditDB = $credit * 100;

	$credit *= 100;

	if ($lastAction != 'respin') $totalWinsDB = $total_win;
}

//$botAction="spin";

if ($lastAction == "freespin"  or $lastAction == "startfreespin") {
	if ($fs_left > 0) {
		$answ .= "winningScatter=" . $winningScatter . ";fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";fs_multiplier=" . $fs_multiplier . ";fs_initial=" . $fs_initial . ";";
		$symb_combs = "WS=" . $winningScatter . "mlt=" . $fs_multiplier . ";" . $symb_combs;
	} else {
		$answ = '';
		$wilds = '';
		$totalWinsDB = $fs_totalwin;
		$lastAction = "endfreespin";
	}

	if ($lastAction == "startfreespin") $symb_combs = "winScat=" . $winningScatter . ";" . $symb_combs;

	//	$botAction="freespin";

}

if ($lastAction == "respin1") {
	$answ .= "winningScatter=" . $winningScatter . ";";
	$totalWinsDB += $total_win;
	//	$botAction="respin";
}

if ($lastAction == "respin" or $lastAction == "initfreespin") {
	$answ .= "winningScatter=" . $winningScatter . ";";
	//	$botAction="respin";
}

if ($lastAction == "endfreespin") {
	$symb_combs = "WS=" . $winningScatter . ";win=" . $fs_totalwin . ";mul=" . $fs_multiplier . ";fspins=" . $fs_played . ";" . $symb_combs;
}


////widget
if (isset($freeRoundsLeft) and $freeRoundsLeft > 0 and $lastAction != 'init' and $lastAction != 'paytable' and $lastAction != 'widgetspin') {
	if (
		$lastAction != 'respin' and $lastAction != 'initfreespin' and
		$lastAction != 'startfreespin' and $lastAction != 'freespin' and $lastAction != 'endfreespin'
	) {
		$freeRoundsLeft--;
		$output .= "freeRoundsLeft=$freeRoundsLeft&";
		$output .= "gameroundid=$freeRoundsLeft&";
	}
	$freeRoundsWin += $real_win * 100;

	if ($freeRoundsLeft == 0) {
		if (
			$lastAction != 'endfreespin' or $lastAction != 'spin' or $lastAction != 'fChance'
			or $lastAction != 'SWORD' or $lastAction != 'ARROW' or $lastAction != 'HAMMER'
		) {
			$answ .= "freeRoundsWin=" . $freeRoundsWin . ";";
			$answ .= "freeRoundsLeft=" . $freeRoundsLeft . ";";
		}
	} else {
		$answ .= "freeRoundsWin=" . $freeRoundsWin . ";";
		$answ .= "freeRoundsLeft=" . $freeRoundsLeft . ";";
	}
}
/////




$query = "answer='" . $answ . "'";

$query .= ", lastAction='" . $lastAction . "',wilds='" . $wilds . "', lastRs='" . $lastRs . "'";

$query .= ", locked='" . $table_locked . "'";

$query = "UPDATE ns.states set " . $query . " where sessionId='" . $_GET['sessid'] . "';";

$result = mysql_query($query);
