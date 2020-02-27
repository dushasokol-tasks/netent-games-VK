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
$gameover = "true";
$wilds = '';
$table_locked = 0;
$buster12 = '';
$buster10 = '';
$buster8 = '';

////////////////////////////////////
//correct action check
////////////////////////////////////

if ($_GET['action'] == "freespin" and ($lastActionDB == "spin" or $lastActionDB == "respin" or $lastActionDB == "lastrespin" or $lastActionDB == "endfreespin")) exit;
if ($_GET['action'] == "freespin" and $lastActionDB == "paytable" and $answer == '') exit;
if ($_GET['action'] == "freespin" and $lastActionDB == "init") exit;

if ($_GET['action'] == "freespin" and $lastActionDB != "freespin" and $lastActionDB != "initfreespin" and $lastActionDB != "paytable") exit;

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

if ($_GET['action'] == "spin" or $_GET['action'] == "respin" or $_GET['action'] == "freespin") {

	$lastAction = "spin";
	if ($lastActionDB == "paytable" and isset($restoreAction)) {
		$lastActionDB = $restoreAction;
		$wildsDB = $wildStcks;
	}

	if ($lastActionDB == "freespin" and $_GET['action'] == "freespin") $lastAction = "freespin";
	if ($lastActionDB == "initfreespin" and $_GET['action'] == "freespin") $lastAction = "freespin";

	if ($lastActionDB == "respin" and $_GET['action'] == "respin") $lastAction = "respin";

	////////////////////
	//symbol generation
	////////////////////
	$i = 0;

	if ($lastAction == "freespin") {
		$query = "SELECT * FROM ns.bonuses where payRate='" . $payRate . "' and gameId='" . $gameId . "' and (type=0 or type=1 or type=2 or type=3 or type=4 or type=5 or type=6 or type=7  or type=8) order by type asc;";
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
			$symbols[$i][3] = $reel[$i][2];
			$symbols[$i][4] = $reel[$i][3];
		} elseif ($pos == ($length - 1)) {
			$symbols[$i][1] = $reel[$i][$length];
			$symbols[$i][2] = $reel[$i][0];
			$symbols[$i][3] = $reel[$i][1];
			$symbols[$i][4] = $reel[$i][2];
		} elseif ($pos == ($length - 2)) {
			$symbols[$i][1] = $reel[$i][$length - 1];
			$symbols[$i][2] = $reel[$i][$length];
			$symbols[$i][3] = $reel[$i][0];
			$symbols[$i][4] = $reel[$i][1];
		} elseif ($pos == ($length - 3)) {
			$symbols[$i][1] = $reel[$i][$length - 2];
			$symbols[$i][2] = $reel[$i][$length - 1];
			$symbols[$i][3] = $reel[$i][$length];
			$symbols[$i][4] = $reel[$i][0];
		} else {
			$symbols[$i][1] = $reel[$i][$pos + 1];
			$symbols[$i][2] = $reel[$i][$pos + 2];
			$symbols[$i][3] = $reel[$i][$pos + 3];
			$symbols[$i][4] = $reel[$i][$pos + 4];
		}
	}

	for ($i = 0; $i < 5; $i++)
		unset($symbols[$i][4]);

	include('./integr/busters.php');

	//$symbols[2][2]=3;$symbols[2][1]=3;$symbols[2][0]=3;$symbols[2][3]=3;
	//$symbols[0][2]=0;$symbols[1][2]=0;$symbols[2][2]=0;
	$bonusSymbCount = 0;
	$nearWinReel = 0;
	$BF_count = 0;
	foreach ($symbols as $tReel => $t)
		foreach ($t as $tRow => $e) {
			if ($symbols[$tReel][$tRow] == 0) {
				$bonusSymbCount++;
				$nearWinReel = $tReel;
			}
			if ($symbols[$tReel][$tRow] == 3) {
				$BF_count++;
			}
			if ($symbols[$tReel][$tRow] == 0 and $lastAction == 'respin') {
				$symbols[$tReel][$tRow] = 3;
				$BF_count++;
			}
		}

	$oldRls = explode('_', $wildsDB);
	foreach ($oldRls as $oldRlNum => $oldRl) {
		if ($oldRl != '') {
			$oldSyms = explode(',', $oldRl);
			$old_BF[$oldSyms[0]][$oldSyms[1]] = 1;
			if ($symbols[$oldSyms[0]][$oldSyms[1]] != 3) $BF_count++;
		}
	}

	if ($bonusSymbCount > 2) {
		if ($lastAction == 'spin') {
			$lastAction = "initfreespin";
			if ($bonusSymbCount == 3) $fs_initial = 5;
			if ($bonusSymbCount == 4) $fs_initial = 6;
			if ($bonusSymbCount == 5) $fs_initial = 7;
		}
	}

	///////////////////////////////////////
	$staxxRate = $reel[5][0];
	$staxxRateRespin = $reel[5][1];
	$BFmaxToStaxx = $reel[5][2];

	$staxxRate1reel = $reel[6][0];
	$staxxRate2reel = $reel[6][1];
	$staxxRate3reel = $reel[6][2];
	$staxxRate4reel = $reel[6][3];

	$staxxRateRespin3reel = $reel[7][3];
	//////////////////////////////////////

	if ($lastAction == "spin") {
		if ($bonusSymbCount < 3 and $lastAction == "spin") {
			if ($lastActionDB == "spin" or $buster8 != '') {
				if (rand(0, 1000) < $staxxRate) {
					$lastAction = "respin";
					if (rand(0, 1000) < $staxxRate1reel) $makeStack = 0;
					elseif (rand(0, 1000) < $staxxRate2reel) $makeStack = 1;
					elseif (rand(0, 1000) < $staxxRate3reel) $makeStack = 2;
					elseif (rand(0, 1000) < $staxxRate4reel) $makeStack = 3;
					else $makeStack = 4;
				}
			}
		}
	} elseif ($lastAction == "respin" and $BFmaxToStaxx >= $BF_count) {
		if (rand(0, 1000) < $staxxRateRespin) {
			if (rand(0, 1000) < $staxxRateRespin3reel) $makeStack = 3;
			else $makeStack = 4;
		}
	}



	if ($lastAction != "startfreespin" and $lastAction != "bonusgame" and $lastAction != "coins")
		include($gamePath . 'lines.php');
	else $symb_combs .= " fake spin;";

	$overlaySym = 1;

	//////////
	//draw rs
	//////////

	$wild = 0;
	$nearwin = 0;
	$anim_num = 0;

	for ($i = 0; $i < 5; $i++) {
		for ($j = 0; $j < 4; $j++) {
			if ($symbolsOverlayed[$i][$j] == 0) {
				$output .= "rs.i0.r.i" . $i . ".attention.i0=" . $j . "&";
			}
		}
		$anim_num = 0;
		$output .= "rs.i0.r.i" . $i . ".hold=false&";
		$lastRs .= "rs.i0.r.i" . $i . ".syms=SYM" . $symbolsOverlayed[$i][0] . ",SYM" . $symbolsOverlayed[$i][1] . ",SYM" . $symbolsOverlayed[$i][2] . ",SYM" . $symbolsOverlayed[$i][3] . "&";
	}

	if ($bonusSymbCount >= 2 and $lastAction != "respin") {
		if ($nearWinReel == 1)		$output .= "rs.i0.nearwin=2,3,4&";
		elseif ($nearWinReel == 2)	$output .= "rs.i0.nearwin=3,4&";
		elseif ($nearWinReel == 3)	$output .= "rs.i0.nearwin=4&";
		elseif ($nearWinReel == 4)	$output .= "rs.i0.nearwin=4&";
	}

	$output .= $lastRs;


	/////////////////////////////
	//draw ws		
	///////////////////////////
	$anim_num = 0;
	$total_win = 0;

	if ($lastAction == "initfreespin") {
		$output .= "ws.i" . $anim_num . ".reelset=basic&";
		$output .= "ws.i" . $anim_num . ".sym=SYM0&";
		$output .= "ws.i" . $anim_num . ".betline=null&";
		$output .= "ws.i" . $anim_num . ".types.i0.wintype=freespins&";
		$output .= "ws.i" . $anim_num . ".types.i0.freespins=" . $fs_initial . "&";
		$output .= "ws.i" . $anim_num . ".types.i0.multipliers=1&";
		$output .= "ws.i" . $anim_num . ".direction=none&";
		for ($i = 0; $i < 5; $i++) {
			for ($j = 0; $j < 4; $j++) {
				if ($symbols[$i][$j] == 0) {
					$output .= "ws.i0.pos.i" . $anim_num . "=" . $i . "," . $j . "&";
					$anim_num++;
				}
			}
		}
		$anim_num = 1;
	}

	foreach ($win as $e => $v) {
		$tmp = explode("_", $v);
		$output .= "ws.i" . $anim_num . ".reelset=$reelset&";

		if ($lastAction != "addfreespin" and $lastAction != "freespin" and $lastAction != "endfreespin")
			if ($buster12 != '') {
				$tmp[0] *= 2;
				$symb_combs .= " bus12 " . $tmp[0] . ";";
			}

		$right_coins = $tmp[0] * $denomDB;

		$output .= "ws.i" . $anim_num . ".sym=SYM" . $symbOverlays[$e] . "&";

		$output .= "ws.i" . $anim_num . ".direction=left_to_right&";
		$output .= "ws.i" . $anim_num . ".betline=" . $e . "&";
		$output .= "ws.i" . $anim_num . ".types.i0.coins=" . $tmp[0] . "&";
		$output .= "ws.i" . $anim_num . ".types.i0.cents=" . $right_coins . "&";

		$output .= "ws.i" . $anim_num . ".types.i0.wintype=coins&";

		$total_win += $tmp[0];

		$ani = explode(";", $tmp[1]);
		$i = 0;

		foreach ($ani as $smb) {
			$output .= "ws.i" . $anim_num . ".pos.i" . $i . "=" . $smb . "&";
			$i++;
		}
		$anim_num++;
	}

	if ($lastAction == "freespin") {
		$fs_total = $fs_left + $fs_played;
		$fs_totalwin += $total_win;

		if ($fs_left > 0 and $lastAction == "freespin") {
			$output .= "previous.rs.i0=freespin_first&";
			$output .= "current.rs.i0=freespin_first&";
			$output .= "next.rs=freespin_first&";
			$output .= "last.rs=freespin_first&";
			$output .= "rs.i0.id=freespin_first&";
			$output .= "gamestate.current=freespin&";
			$output .= "gamestate.stack=basic%2Cfreespin&";
			$output .= "gamestate.history=basic%2Cfreespin&";
			$output .= "clientaction=freespin&";
			$output .= "nextaction=freespin&";

			$gameover = 'false';
			$table_locked = 1;
			$botAction = "freespin";
		} else {
			$output .= "previous.rs.i0=freespin_last&";
			$output .= "current.rs.i0=basic&";
			$output .= "next.rs=basic&";
			$output .= "last.rs=freespin_last&";
			$output .= "rs.i0.id=freespin_last&";
			$output .= "gamestate.current=basic&";
			$output .= "gamestate.stack=basic&";
			$output .= "gamestate.history=basic%2Cfreespin&";
			$output .= "clientaction=freespin&";
			$output .= "nextaction=spin&";

			$lastAction = 'endfreespin';
			$botAction = "spin";
			$wavecount = 0;
			$table_locked = 0;
		}

		$output .= "freespins.wavecount=$wavecount&";
		$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C21%2C22%2C23%2C24%2C25%2C26%2C27%2C28%2C29%2C30%2C31%2C32%2C33%2C34%2C35%2C36%2C37%2C38%2C39&";
		$output .= "freespins.multiplier=1&";
		$output .= "freespins.denomination=1.000&";
		$output .= "freespins.initial=10&";
		$output .= "freespins.betlevel=1&";

		$output .= "freespins.total=" . $fs_total . "&";
		$output .= "freespins.left=" . $fs_left . "&";
		$output .= "freespins.played=" . $fs_played . "&";
		$output .= "freespins.totalwin.coins=" . $fs_totalwin . "&";
		$output .= "freespins.totalwin.cents=" . $fs_totalwin . "&";
		$output .= "freespins.win.cents=" . $fs_totalwin . "&";
		$output .= "freespins.win.coins=" . $fs_totalwin . "&";

		$symb_combs .= "fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";";
	} elseif ($lastAction == "initfreespin") {
		if ($buster10 != '') {
			$fs_initial *= 2;
			$symb_combs .= " bus10;";
		}

		$output .= "rs.i0.id=basic&";
		$output .= "current.rs.i0=freespin_first&";
		$output .= "last.rs=basic&";
		$output .= "next.rs=freespin_first&";
		$output .= "nextaction=freespin&";
		$output .= "clientaction=spin&";

		$output .= "gamestate.current=freespin&";
		$output .= "gamestate.stack=basic%2Cfreespin&";
		$output .= "gamestate.history=basic&";

		$output .= "freespins.betlevel=1&";
		$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C21%2C22%2C23%2C24%2C25%2C26%2C27%2C28%2C29%2C30%2C31%2C32%2C33%2C34%2C35%2C36%2C37%2C38%2C39&";
		$output .= "freespins.denomination=1.000&";
		$output .= "freespins.initial=" . $fs_initial . "&";
		$output .= "freespins.left=" . $fs_initial . "&";
		$output .= "freespins.multiplier=1&";
		$output .= "freespins.total=" . $fs_initial . "&";
		$output .= "freespins.totalwin.cents=0&";
		$output .= "freespins.totalwin.coins=0&";
		$output .= "freespins.wavecount=1&";
		$output .= "freespins.win.cents=0&";
		$output .= "freespins.win.coins=0&";

		$fs_left = $fs_initial;
		$fs_played = 0;
		$fs_totalwin = 0;

		$reelset = "freespin_first";

		$wilds = "";
		$gameover = "false";
		$botAction = "freespin";
		$table_locked = 1;
	} elseif ($lastAction == "trigger") {
		$output .= "rs.i0.id=trigger&";
		$output .= "current.rs.i0=basic&";
		$output .= "next.rs=basic&";

		$output .= "clientaction=spin&";
		$output .= "nextaction=spin&";

		$output .= "gamestate.current=basic&";
		$output .= "gamestate.stack=basic&";
		$output .= "gamestate.history=basic&";

		$output .= "last.rs=trigger&";
		$output .= "previous.rs.i0=trigger&";

		$botAction = "spin";
		$table_locked = 0;
	} elseif ($lastAction == "respin") {
		$output .= "rs.i0.id=trigger&";
		$output .= "current.rs.i0=trigger&";
		$output .= "next.rs=trigger&";

		$output .= "clientaction=spin&";
		$output .= "nextaction=respin&";
		$output .= "gamestate.current=respin&";
		$output .= "gamestate.stack=basic%2Crespin&";
		$output .= "gamestate.history=basic&";
		$output .= "last.rs=trigger&";
		$output .= "previous.rs.i0=trigger&";

		$gameover = "false";
		$botAction = "respin";
		$table_locked = 1;
	} else {
		$output .= "rs.i0.id=basic&";
		$output .= "current.rs.i0=basic&";
		$output .= "next.rs=basic&";

		$output .= "clientaction=spin&";
		$output .= "nextaction=spin&";

		$output .= "gamestate.current=basic&";
		$output .= "gamestate.stack=basic&";
		$output .= "gamestate.history=basic&";

		$output .= "last.rs=basic&";
		$output .= "previous.rs.i0=basic&";

		$botAction = "spin";
		$table_locked = 0;
	}

	//echo "LADB=$lastActionDB&LA=$lastAction&mrs=$reelset&";


	foreach ($trans as $e => $v) {
		$tmp = explode("_", $v);
		$ani = explode(",", $tmp[1]);

		$output .= "translated_symbols.i" . $e . ".r=" . $ani[0] . "&";
		$output .= "translated_symbols.i" . $e . ".row=" . $ani[1] . "&";

		$output .= "translations.i" . $e . ".to.r=" . $ani[0] . "&";
		$output .= "translations.i" . $e . ".to.row=" . $ani[1] . "&";

		if ($lastAction != "endfreespin") {
			$output .= "rs.i0.r.i" . $ani[0] . ".overlay.i" . $e . ".with=SYM3&";
			$output .= "rs.i0.r.i" . $ani[0] . ".overlay.i" . $e . ".row=" . $ani[1] . "&";
		}

		$ani = explode(",", $tmp[0]);

		$output .= "translations.i" . $e . ".from.r=" . $ani[0] . "&";
		$output .= "translations.i" . $e . ".from.row=" . $ani[1] . "&";
	}

	if ($lastAction == "freespin") {
		if ($reelset == "freespin_first" and $total_win > 0) $reelset = "freespin_standard";
		elseif ($reelset == "freespin_standard") $reelset = "freespin_last";
	}


	$spincost = 0;
	if ($lastAction != 'respin' and $lastAction != 'freespin' and $lastAction != 'endfreespin') {
		$spin_to_history = 1;
		$spincost = $betDB * $linesDB * $denomDB * 0.01 / 2;
	}
	$credit /= 100;

	$real_win = $total_win * $denomDB * 0.01;

	if (isset($freeRoundsLeft)) $spincost = 0;
	if ($lastAction != 'respin' and $lastAction != 'freespin' and $lastAction != 'endfreespin') {
		$credit -= $spincost;
	}

	$credit += $real_win;

	$creditDB = $credit * 100;

	$credit *= 100;

	if ($lastAction == 'endfreespin') $totalWinsDB = $fs_totalwin;
	else $totalWinsDB = $total_win;
}


if ($lastAction == "freespin") {
	$answ .= "fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";reelset=" . $reelset . ";";
}

if ($lastAction == "initfreespin") {
	$answ .= "fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";reelset=" . $reelset . ";";
	$symb_combs .= "fs=" . $fs_left . ";";
}


////widget
if (isset($freeRoundsLeft) and $freeRoundsLeft > 0 and $lastAction != 'init' and $lastAction != 'paytable' and $lastAction != 'widgetspin') {
	if ($lastAction == 'spin' or $lastAction == 'trigger' or $lastAction == 'initfreespin') {
		$freeRoundsLeft--;
		$output .= "freeRoundsLeft=$freeRoundsLeft&";
		$output .= "gameroundid=$freeRoundsLeft&";
	}
	$freeRoundsWin += $real_win * 100;

	if ($freeRoundsLeft == 0) {
		if ($lastAction != 'endfreespin' or $lastAction != 'spin' or $lastAction != 'trigger') {
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

$query .= ", locked='" . $table_locked . "'";

$query .= ", lastAction='" . $lastAction . "',wilds='" . $wilds . "', lastRs='" . $lastRs . "'";

$query = "UPDATE ns.states set " . $query . " where sessionId='" . $_GET['sessid'] . "';";

$result = mysql_query($query);
