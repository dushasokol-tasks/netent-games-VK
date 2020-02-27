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
$buster10 = '';
$buster12 = '';

////////////////////////////////////
//correct action check
////////////////////////////////////

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



if ($_GET['action'] == "initfreespin" and $wavecount == 6) {
	if (!isset($fs_left)) $fs_left = 8;
	include('./integr/busters.php');
	if ($buster10 != '') {
		$fs_left *= 2;
		$symb_combs .= " bust10;";
	}
	if (!isset($fs_played)) $fs_played = 0;
	if (!isset($fs_totalwin)) $fs_totalwin = 0;

	$output .= "rs.i0.r.i0.syms=SYM9%2CSYM7%2CSYM7%2CSYM10%2CSYM10&";
	$output .= "rs.i0.r.i1.syms=SYM1%2CSYM10%2CSYM10%2CSYM6%2CSYM6&";
	$output .= "rs.i0.r.i2.syms=SYM9%2CSYM9%2CSYM13%2CSYM13%2CSYM7&";
	$output .= "rs.i0.r.i3.syms=SYM13%2CSYM13%2CSYM12%2CSYM12%2CSYM5&";
	$output .= "rs.i0.r.i4.syms=SYM9%2CSYM5%2CSYM5%2CSYM12%2CSYM12&";

	$output .= "rs.i1.r.i0.syms=SYM13%2CSYM11%2CSYM11%2CSYM3%2CSYM3&";
	$output .= "rs.i1.r.i1.syms=SYM5%2CSYM1%2CSYM6%2CSYM6%2CSYM10&";
	$output .= "rs.i1.r.i2.syms=SYM11%2CSYM11%2CSYM8%2CSYM8%2CSYM12&";
	$output .= "rs.i1.r.i3.syms=SYM10%2CSYM10%2CSYM13%2CSYM13%2CSYM12&";
	$output .= "rs.i1.r.i4.syms=SYM11%2CSYM11%2CSYM9%2CSYM9%2CSYM5&";

	$output .= "rs.i2.r.i0.syms=SYM8%2CSYM9%2CSYM9%2CSYM12%2CSYM12&";
	$output .= "rs.i2.r.i1.syms=SYM13%2CSYM1%2CSYM12%2CSYM12%2CSYM9&";
	$output .= "rs.i2.r.i2.syms=SYM5%2CSYM5%2CSYM12%2CSYM12%2CSYM1&";
	$output .= "rs.i2.r.i3.syms=SYM9%2CSYM6%2CSYM6%2CSYM13%2CSYM13&";
	$output .= "rs.i2.r.i4.syms=SYM11%2CSYM11%2CSYM13%2CSYM13%2CSYM7&";

	$output .= "rs.i3.r.i0.syms=SYM4%2CSYM4%2CSYM5%2CSYM5%2CSYM9&";
	$output .= "rs.i3.r.i1.syms=SYM11%2CSYM11%2CSYM4%2CSYM4%2CSYM12&";
	$output .= "rs.i3.r.i2.syms=SYM3%2CSYM9%2CSYM9%2CSYM10%2CSYM10&";
	$output .= "rs.i3.r.i3.syms=SYM11%2CSYM8%2CSYM8%2CSYM12%2CSYM12&";
	$output .= "rs.i3.r.i4.syms=SYM5%2CSYM5%2CSYM12%2CSYM12%2CSYM3&";

	$output .= "rs.i4.r.i0.syms=SYM9%2CSYM12%2CSYM12%2CSYM13%2CSYM13&";
	$output .= "rs.i4.r.i1.syms=SYM6%2CSYM10%2CSYM10%2CSYM1%2CSYM7&";
	$output .= "rs.i4.r.i2.syms=SYM1%2CSYM11%2CSYM11%2CSYM12%2CSYM12&";
	$output .= "rs.i4.r.i3.syms=SYM3%2CSYM3%2CSYM11%2CSYM11%2CSYM10&";
	$output .= "rs.i4.r.i4.syms=SYM12%2CSYM12%2CSYM11%2CSYM11%2CSYM13&";

	$output .= "rs.i5.r.i0.syms=SYM9%2CSYM9%2CSYM13%2CSYM13%2CSYM7&";
	$output .= "rs.i5.r.i1.syms=SYM9%2CSYM9%2CSYM10%2CSYM10%2CSYM5&";
	$output .= "rs.i5.r.i2.syms=SYM1%2CSYM10%2CSYM10%2CSYM9%2CSYM9&";
	$output .= "rs.i5.r.i3.syms=SYM13%2CSYM13%2CSYM12%2CSYM12%2CSYM3&";
	$output .= "rs.i5.r.i4.syms=SYM13%2CSYM10%2CSYM10%2CSYM11%2CSYM11&";

	$output .= "rs.i6.r.i0.syms=SYM5%2CSYM5%2CSYM11%2CSYM11%2CSYM8&";
	$output .= "rs.i6.r.i1.syms=SYM10%2CSYM5%2CSYM5%2CSYM1%2CSYM6&";
	$output .= "rs.i6.r.i2.syms=SYM12%2CSYM12%2CSYM1%2CSYM3%2CSYM3&";
	$output .= "rs.i6.r.i3.syms=SYM13%2CSYM12%2CSYM12%2CSYM5%2CSYM5&";
	$output .= "rs.i6.r.i4.syms=SYM11%2CSYM13%2CSYM13%2CSYM7%2CSYM7&";

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

	$output .= "rs.i2.r.i0.hold=false&";
	$output .= "rs.i2.r.i1.hold=false&";
	$output .= "rs.i2.r.i2.hold=false&";
	$output .= "rs.i2.r.i3.hold=false&";
	$output .= "rs.i2.r.i4.hold=false&";

	$output .= "rs.i3.r.i0.hold=false&";
	$output .= "rs.i3.r.i1.hold=false&";
	$output .= "rs.i3.r.i2.hold=false&";
	$output .= "rs.i3.r.i3.hold=false&";
	$output .= "rs.i3.r.i4.hold=false&";

	$output .= "rs.i4.r.i0.hold=false&";
	$output .= "rs.i4.r.i1.hold=false&";
	$output .= "rs.i4.r.i2.hold=false&";
	$output .= "rs.i4.r.i3.hold=false&";
	$output .= "rs.i4.r.i4.hold=false&";

	$output .= "rs.i5.r.i0.hold=false&";
	$output .= "rs.i5.r.i1.hold=false&";
	$output .= "rs.i5.r.i2.hold=false&";
	$output .= "rs.i5.r.i3.hold=false&";
	$output .= "rs.i5.r.i4.hold=false&";

	$output .= "rs.i6.r.i0.hold=false&";
	$output .= "rs.i6.r.i1.hold=false&";
	$output .= "rs.i6.r.i2.hold=false&";
	$output .= "rs.i6.r.i3.hold=false&";
	$output .= "rs.i6.r.i4.hold=false&";

	$output .= "freespins.win.coins=0&";
	$output .= "freespins.initial=0&";
	$output .= "freespins.win.cents=0&";
	$output .= "freespins.betlines=0&";
	$output .= "freespins.totalwin.cents=0&";
	$output .= "freespins.betlevel=1&";
	$output .= "freespins.denomination=1.000&";
	$output .= "freespins.totalwin.coins=0&";
	$output .= "freespins.total=0&";
	$output .= "freespins.wavecount=$wavecount&";
	$output .= "freespins.multiplier=1&";
	$output .= "freespins.left=$fs_left&";

	$output .= "wavecount=$wavecount&";

	$output .= "gamestate.history=basic&";
	$output .= "gamestate.current=freespin&";
	$output .= "gamestate.stack=basic%2Cfreespin&";

	$output .= "bet.betlines=0&";
	$output .= "bet.betlevel=1&";
	$output .= "bet.denomination=1&";

	$output .= "rs.i0.id=basic5&";
	$output .= "rs.i1.id=basic4&";
	$output .= "rs.i2.id=basic3&";
	$output .= "rs.i3.id=freespin&";
	$output .= "rs.i4.id=basic2&";
	$output .= "rs.i5.id=basic1&";
	$output .= "rs.i6.id=basic&";

	$output .= "clientaction=initfreespin&";
	$output .= "nextaction=freespin&";

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

	if ($lastActionDB == "respin" and $_GET['action'] == "respin") $lastAction = "respin";

	if ($lastActionDB == "paytable" and isset($restoreAction)) {
		if ($restoreAction == 'respin') $lastAction = "respin";
	}

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

	include('./integr/busters.php');

	if ($lastAction != "startfreespin" and $lastAction != "bonusgame" and $lastAction != "coins")
		include($gamePath . 'lines.php');
	else $symb_combs .= " fake spin;";

	//////////
	//draw rs
	//////////

	$wild = 0;
	$nearwin = 0;
	$nearwinstr = '';
	$map = 0;
	$anim_num = 0;

	for ($i = 0; $i < 5; $i++) {
		$output .= "rs.i0.r.i" . $i . ".hold=false&";
		$lastRs .= "rs.i0.r.i" . $i . ".syms=SYM" . $symbolsOverlayed[$i][0] . ",SYM" . $symbolsOverlayed[$i][1] . ",SYM" . $symbolsOverlayed[$i][2] . ",SYM" . $symbolsOverlayed[$i][3] . ",SYM" . $symbolsOverlayed[$i][4] . "&";
	}

	$output .= $lastRs;


	/////////////////////////////
	//draw ws			
	///////////////////////////
	$anim_num = 0;
	$total_win = 0;

	foreach ($win as $e => $v) {
		$tmp = explode("_", $v);
		if ($lastAction != "freespin") $output .= "ws.i" . $anim_num . ".reelset=$reelset&";
		else $output .= "ws.i" . $anim_num . ".reelset=freespin&";


		if ($lastAction != "freespin" and $lastAction != "endfreespin")
			if ($buster12 != '') {
				$tmp[0] *= 2;
				$symb_combs .= " bust12;";
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

	if ($lastAction == "initfreespin") {
		$output .= "ws.i" . $anim_num . ".reelset=basic5&";
		$output .= "ws.i" . $anim_num . ".sym=FS&";
		$output .= "ws.i" . $anim_num . ".betline=0&";
		$output .= "ws.i" . $anim_num . ".direction=left_to_right&";
		$output .= "ws.i" . $anim_num . ".types.i0.wintype=freespins&";
		$output .= "ws.i" . $anim_num . ".types.i0.freespins=8&";
		$output .= "ws.i" . $anim_num . ".types.i0.multipliers=1&";
	}


	if ($lastAction == "freespin") {
		$fs_total = $fs_left + $fs_played;
		$fs_totalwin += $total_win;


		if ($fs_left > 0 and $lastAction == "freespin") {
			$output .= "rs.i0.id=freespin&";
			$output .= "gamestate.current=freespin&";
			$output .= "gamestate.stack=basic%2Cfreespin&";
			$output .= "gamestate.history=basic%2Cfreespin&";
			$output .= "clientaction=freespin&";
			$output .= "nextaction=freespin&";

			$gameover = 'false';
			$table_locked = 1;
			$botAction = "freespin";
		} else {
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
		$output .= "freespins.betlines=0&";
		$output .= "freespins.multiplier=1&";
		$output .= "freespins.denomination=1.000&";
		$output .= "freespins.initial=0&";
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
		$output .= "rs.i0.id=basic5&";
		$output .= "nextaction=freespin&";
		$output .= "clientaction=respin&";

		$output .= "gamestate.current=freespin&";
		$output .= "gamestate.stack=basic%2Cfreespin&";
		$output .= "gamestate.history=basic&";

		$output .= "freespins.left=8&";
		$output .= "freespins.wavecount=6&";
		$output .= "freespins.betlines=0&";
		$output .= "freespins.multiplier=1&";
		$output .= "freespins.denomination=1.000&";
		$output .= "freespins.win.cents=0&";
		$output .= "freespins.initial=0&";
		$output .= "freespins.totalwin.cents=0&";
		$output .= "freespins.betlevel=1&";
		$output .= "freespins.win.coins=0&";
		$output .= "freespins.totalwin.coins=0&";
		$output .= "freespins.total=0&";

		$gameover = "false";
		$botAction = "initfreespin";
		$table_locked = 1;
	} elseif ($lastAction == "lastrespin") {
		$output .= "rs.i0.id=$reelset&";
		$output .= "gamestate.current=basic&";
		$output .= "gamestate.history=basic&";
		$output .= "gamestate.stack=basic&";
		$output .= "nextaction=spin&";
		$output .= "clientaction=respin&";

		$botAction = "spin";
		$table_locked = 0;
	} elseif ($lastAction == "respin") {
		$output .= "rs.i0.id=$reelset&";
		$output .= "gamestate.current=basic&";
		$output .= "gamestate.history=basic&";
		$output .= "gamestate.stack=basic&";
		$output .= "nextaction=respin&";
		$output .= "clientaction=spin&";

		$gameover = "false";
		$botAction = "respin";
		$table_locked = 1;
	} else {
		$output .= "rs.i0.id=basic&";
		$output .= "current.rs.i0=basic&";

		$output .= "clientaction=spin&";
		$output .= "nextaction=spin&";

		$output .= "gamestate.current=basic&";
		$output .= "gamestate.stack=basic&";
		$output .= "gamestate.history=basic&";

		$botAction = "spin";
		$table_locked = 0;
	}

	$spincost = 0;
	if ($lastAction != 'respin' and $lastAction != 'freespin' and $lastAction != 'endfreespin') {
		$spin_to_history = 1;
		$spincost = $betDB * $denomDB * 0.5;
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

	if ($lastAction == 'freespin') {
		$wilds = $wildsDB;
		$dop2 .= "(" . $wildsDB . ")";
	}

	if ($lastAction == 'endfreespin') $totalWinsDB = $fs_totalwin;
	else $totalWinsDB = $total_win;
}

$answ .= "wavecount=" . ($wavecount) . ";";

if ($lastAction == "freespin" or $lastAction == "startfreespin") {
	$answ .= "fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";" . $answFS;
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
