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

if ($_GET['action'] == "freespin" and $lastActionDB == "paytable" and $answer == '') exit;
elseif ($_GET['action'] == "initfreespin" and $lastActionDB == "paytable" and $answer == '') exit;

elseif ($_GET['action'] == "freespin" and $lastActionDB == "init") exit;
elseif ($_GET['action'] == "initfreespin" and $lastActionDB == "init") exit;
elseif ($_GET['action'] == "freespin" and $lastActionDB == "startfreespin") {
} elseif ($_GET['action'] == "freespin" and $lastActionDB != "initfreespin" and $lastActionDB != "addfreespin" and $lastActionDB != "freespin" and $lastActionDB != "paytable") exit;

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



if ($_GET['action'] == "initfreespin" and isset($fs_left)) {

	$output .= "clientaction=initfreespin&";
	$output .= "nextaction=freespin&";

	$output .= "freespins.betlevel=1&";
	$output .= "freespins.win.coins=0&";
	$output .= "freespins.initial=$fs_left&";
	$output .= "freespins.denomination=1.000&";
	$output .= "freespins.win.cents=0&";
	$output .= "freespins.totalwin.coins=0&";
	$output .= "freespins.total=$fs_left&";
	$output .= "freespins.betlines=0,1,2,3,4,5,6,7,8&";
	$output .= "freespins.wavecount=1&";
	$output .= "freespins.multiplier=1&";
	$output .= "freespins.left=$fs_left&";
	$output .= "freespins.totalwin.cents=0&";

	$output .= "gamestate.history=basic&";
	$output .= "gamestate.current=freespin&";
	$output .= "gamestate.stack=basic,freespin&";

	$output .= "current.rs.i0=freespin&";
	$output .= "next.rs=freespin&";
	$output .= "rs.i0.id=freespin&";

	$output .= "rs.i1.id=basic&";

	$output .= "wavecount=1&";
	$output .= "bet.betlines=0,1,2,3,4,5,6,7,8&";
	$output .= "bet.betlevel=1&";
	$output .= "bet.denomination=1&";

	$output .= "rs.i0.r.i0.syms=SYM12,SYM12,SYM12&";
	$output .= "rs.i0.r.i1.syms=SYM9,SYM9,SYM9&";
	$output .= "rs.i0.r.i2.syms=SYM3,SYM3,SYM3&";
	$output .= "rs.i0.r.i3.syms=SYM3,SYM3,SYM3&";
	$output .= "rs.i0.r.i4.syms=SYM11,SYM11,SYM11&";

	$output .= "rs.i1.r.i0.syms=SYM6,SYM6,SYM11&";
	$output .= "rs.i1.r.i1.syms=SYM9,SYM9,SYM0&";
	$output .= "rs.i1.r.i2.syms=SYM10,SYM10,SYM0&";
	$output .= "rs.i1.r.i3.syms=SYM7,SYM7,SYM7&";
	$output .= "rs.i1.r.i4.syms=SYM0,SYM11,SYM11&";

	$output .= "rs.i0.r.i0.hold=false&";
	$output .= "rs.i0.r.i1.hold=false&";
	$output .= "rs.i0.r.i2.hold=false&";
	$output .= "rs.i0.r.i3.hold=false&";
	$output .= "rs.i0.r.i4.hold=false&";

	$output .= "rs.i1.r.i0.hold=false&";
	$output .= "rs.i1.r.i1.hold=false&";
	$output .= "rs.i1.r.i2.hold=false&";
	$output .= "rs.i1.r.i3.hold=false&";
	$output .= "rs.i1.r.i4.hold=false&";

	$lastAction = "startfreespin";
	$botAction = "freespin";

	$output .= $lastRsDB;
	$lastRs = $lastRsDB;

	$table_locked = 1;
	$gameover = "false";
}


if ($_GET['action'] == "spin" or $_GET['action'] == "respin" or $_GET['action'] == "freespin") {

	$lastAction = "spin";
	if ($lastActionDB == "freespin" and $_GET['action'] == "freespin") $lastAction = "freespin";
	if ($lastActionDB == "startfreespin" and $_GET['action'] == "freespin") $lastAction = "freespin";
	if ($lastActionDB == "addfreespin" and $_GET['action'] == "freespin") $lastAction = "freespin";

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
		} elseif ($pos == ($length - 1)) {
			$symbols[$i][1] = $reel[$i][$length];
			$symbols[$i][2] = $reel[$i][0];
		} else {
			$symbols[$i][1] = $reel[$i][$pos + 1];
			$symbols[$i][2] = $reel[$i][$pos + 2];
		}
	}


	//$symbols[0][1]=0;$symbols[1][1]=0;$symbols[2][1]=0;$symbols[3][1]=0;

	include('./integr/busters.php');

	$bonusSymbCount = 0;
	$nearWinReel = 0;
	foreach ($symbols as $tReel => $t)
		foreach ($t as $tRow => $e) {
			if ($symbols[$tReel][$tRow] == 0) {
				$bonusSymbCount++;
				$nearWinReel = $tReel;
			}
		}

	if ($bonusSymbCount > 2) {
		if ($lastAction == 'spin') {
			$lastAction = "initfreespin";
			if ($bonusSymbCount == 3) {
				$fs_initial = 10;
				$fs_add = 10;
			}
			if ($bonusSymbCount == 4) {
				$fs_initial = 20;
				$fs_add = 20;
			}
			if ($bonusSymbCount == 5) {
				$fs_initial = 30;
				$fs_add = 30;
			}
		} elseif ($lastAction == 'freespin' or $lastAction == 'addfreespin') {
			$lastAction = "addfreespin";
			if ($bonusSymbCount == 3) $fs_add = 10;
			if ($bonusSymbCount == 4) $fs_add = 20;
			if ($bonusSymbCount == 5) $fs_add = 30;
			$fs_left += $fs_add;
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
		for ($j = 0; $j < 3; $j++) { {
				if ($symbols[$i][$j] == $overlaySym) {
					$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".with=SYM" . $overlaySym . "&";
					$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".row=" . $j . "&";
					$anim_num++;
				}
			}
			if ($symbolsOverlayed[$i][$j] == 0) {
				$output .= "rs.i0.r.i" . $i . ".attention.i0=" . $j . "&";
			}
		}
		$anim_num = 0;
		$output .= "rs.i0.r.i" . $i . ".hold=false&";
		$lastRs .= "rs.i0.r.i" . $i . ".syms=SYM" . $symbolsOverlayed[$i][0] . ",SYM" . $symbolsOverlayed[$i][1] . ",SYM" . $symbolsOverlayed[$i][2] . "&";
	}
	if ($bonusSymbCount >= 2) {
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

	if ($lastAction == "initfreespin" or $lastAction == "addfreespin") {
		$output .= "ws.i" . $anim_num . ".reelset=basic&";
		$output .= "ws.i" . $anim_num . ".sym=SYM0&";
		$output .= "ws.i" . $anim_num . ".betline=null&";
		$output .= "ws.i" . $anim_num . ".types.i0.wintype=freespins&";
		$output .= "ws.i" . $anim_num . ".types.i0.freespins=$fs_add&";
		$output .= "ws.i" . $anim_num . ".types.i0.multipliers=1&";
		for ($i = 0; $i < 5; $i++) {
			for ($j = 0; $j < 3; $j++) {
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
		if ($lastAction != "freespin") $output .= "ws.i" . $anim_num . ".reelset=$reelset&";
		else $output .= "ws.i" . $anim_num . ".reelset=freespin&";

		if ($lastAction != "addfreespin" and $lastAction != "freespin" and $lastAction != "endfreespin")
			if ($buster12 != '') {
				$tmp[0] *= 2;
				$symb_combs .= " bus=$buster12, " . $tmp[0] . ";";
			}

		$right_coins = $tmp[0] * $denomDB;

		$output .= "ws.i" . $anim_num . ".sym=SYM" . $symbOverlays[$e] . "&";

		$output .= "ws.i" . $anim_num . ".direction=left_to_right&";
		$output .= "ws.i" . $anim_num . ".betline=null&";
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
			$output .= "previous.rs.i0=freespin";
			$output .= "current.rs.i0=freespin";
			$output .= "next.rs=freespin";
			$output .= "last.rs=freespin";
			$output .= "rs.i0.id=freespin&"; //
			$output .= "gamestate.current=freespin&"; //
			$output .= "gamestate.stack=basic%2Cfreespin&";
			$output .= "gamestate.history=basic%2Cfreespin&"; //
			$output .= "clientaction=freespin&"; //
			$output .= "nextaction=freespin&"; //

			$gameover = 'false';
			$table_locked = 1;
			$botAction = "freespin";
		} else {
			$output .= "previous.rs.i0=freespin&";
			$output .= "current.rs.i0=basic&";
			$output .= "next.rs=basic&";
			$output .= "last.rs=freespin&";
			$output .= "rs.i0.id=freespin&";
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
		$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8&";
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
		}

		$output .= "rs.i0.id=basic&";
		$output .= "current.rs.i0=freespin&";
		$output .= "next.rs=freespin&";
		$output .= "nextaction=freespin&";
		$output .= "clientaction=spin&";

		$output .= "gamestate.current=freespin&";
		$output .= "gamestate.stack=basic%2Cfreespin&";
		$output .= "gamestate.history=basic&";

		$output .= "freespins.left=" . $fs_initial . "&";
		$output .= "freespins.wavecount=1&";
		$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8&";
		$output .= "freespins.multiplier=1&";
		$output .= "freespins.denomination=1.000&";
		$output .= "freespins.win.cents=0&";
		$output .= "freespins.totalwin.cents=0&";
		$output .= "freespins.betlevel=1&";
		$output .= "freespins.win.coins=0&";
		$output .= "freespins.totalwin.coins=0&";
		$output .= "freespins.total=0&";

		$fs_left = $fs_initial;
		$fs_played = 0;
		$fs_totalwin = 0;

		$gameover = "false";
		$botAction = "initfreespin";
		$table_locked = 1;
	} elseif ($lastAction == "addfreespin") {
		$output .= "rs.i0.id=freespin&";
		$output .= "current.rs.i0=freespin&";
		$output .= "previous.rs.i0=freespin&";
		$output .= "next.rs=freespin&";
		$output .= "last.rs=freespin&";
		$output .= "clientaction=freespin&";
		$output .= "nextaction=freespin&";

		$output .= "freespins.betlevel=1&";
		$output .= "freespins.win.coins=0&";
		$output .= "freespins.initial=$fs_add&";
		$output .= "freespins.denomination=1.000&";

		$output .= "freespins.total=" . $fs_total . "&";
		$output .= "freespins.left=" . $fs_left . "&";
		$output .= "freespins.played=" . $fs_played . "&";
		$output .= "freespins.totalwin.coins=" . $fs_totalwin . "&";
		$output .= "freespins.totalwin.cents=" . $fs_totalwin . "&";
		$output .= "freespins.win.cents=" . $fs_totalwin . "&";
		$output .= "freespins.win.coins=" . $fs_totalwin . "&";

		$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8&";

		$output .= "freespins.wavecount=1&";
		$output .= "freespins.multiplier=1&";

		$output .= "gamestate.history=basic,freespin&";
		$output .= "gamestate.current=freespin&";
		$output .= "gamestate.stack=basic,freespin&";

		$symb_combs .= "fs_add=" . $fs_add . ";fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";";

		$gameover = "false";
		$botAction = "freespin";
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

		$botAction = "spin";
		$table_locked = 0;
	}
	//echo "LADB=$lastActionDB&LA=$lastAction&";


	$spincost = 0;
	if ($lastAction != 'addfreespin' and $lastAction != 'freespin' and $lastAction != 'endfreespin') {
		$spin_to_history = 1;
		$spincost = $betDB * $linesDB * $denomDB * 0.01;
	}

	$credit /= 100;

	$real_win = $total_win * $denomDB * 0.01;

	if (isset($freeRoundsLeft)) $spincost = 0;
	if ($lastAction != 'freespin' and $lastAction != 'endfreespin' and $lastAction != 'addfreespin') {
		$credit -= $spincost;
	}

	$credit += $real_win;

	$creditDB = $credit * 100;

	$credit *= 100;

	if ($lastAction == 'freespin') {
		$wilds = $wildsDB;
		$dop2 .= "(" . $wildsDB . ")";
	}

	if ($lastAction == 'endfreespin') $totalWinsDB = $fs_totalwin;
	else $totalWinsDB = $total_win;
}

if ($lastAction == "freespin" or $lastAction == "startfreespin" or $lastAction == "addfreespin") {
	$answ .= "fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";" . $answFS;
}

if ($lastAction == "initfreespin") {
	$answ .= "fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";";
	$symb_combs .= "fs=" . $fs_left . ";";
}

////widget
if (isset($freeRoundsLeft) and $freeRoundsLeft > 0 and $lastAction != 'init' and $lastAction != 'paytable' and $lastAction != 'widgetspin') {
	if ($lastAction == 'spin' or $lastAction == 'initfreespin') {
		$freeRoundsLeft--;
		$output .= "freeRoundsLeft=$freeRoundsLeft&";
		$output .= "gameroundid=$freeRoundsLeft&";
	}
	$freeRoundsWin += $real_win * 100;

	if ($freeRoundsLeft == 0) {
		if ($lastAction != 'endfreespin' or $lastAction != 'spin') {
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
