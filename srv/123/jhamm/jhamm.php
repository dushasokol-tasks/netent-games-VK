<?
header('Access-Control-Allow-Origin: *');
////////////////////////////////////////////////////////////////////////////////
//selectors
////////////////////////////////////////////////////////////////////////////////
$gameover = "true";
$wilds = '';

////////////////////////////////////
//correct action check
////////////////////////////////////

//    if($_GET['action']=="respin" and $lastActionDB!="respin") exit;

if ($_GET['action'] == "freespin" and $lastActionDB == "spin") exit;

if ($_GET['action'] == "freespin" and $lastActionDB == "paytable" and $answer == '') exit;
if ($_GET['action'] == "freespin" and $lastActionDB == "init") exit;

if ($_GET['action'] == "freespin" and $lastActionDB != "freespin" and $lastActionDB != "initfreespin" and $lastActionDB != "paytable") exit;


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




if ($_GET['action'] == "spin" or $_GET['action'] == "initfreespin" or $_GET['action'] == "freespin" or $_GET['action'] == "respin") {
	$lastAction = "spin";
	$buster7 = '';
	$buster8 = '';
	$buster10 = '';
	$buster12 = '';

	if ($lastActionDB == "paytable" and isset($restoreAction)) {
		$lastActionDB = $restoreAction;
		$wildsDB = $wildStcks;
	}

	if ($lastActionDB == "freespin") $lastAction = "freespin";
	if ($lastActionDB == "respinFS" and $fs_left > 0) $lastAction = "freespin";

	if ($_GET['action'] == "initfreespin" and $lastActionDB == "initfreespin") $lastAction = "freespin";



	////////////////////
	//symbol generation
	////////////////////
	$i = 0;

	if ($lastAction == "freespin" and $lastActionDB != "initfreespin") {
		$query = "SELECT * FROM ns.bonuses where payRate='" . $payRate . "' and gameId='" . $gameId . "' and (type=0 or type=1 or type=2 or type=3 or type=4) order by type asc;";
	} else			$query = "SELECT * FROM ns.reels where payRate=" . $payRate . " and gameId=" . $gameId . " order by id asc;";

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



	//$symbols[0][0]=4;$symbols[1][0]=4;$symbols[2][0]=4;$symbols[3][0]=4;$symbols[4][0]=4;
	//$symbols[0][0]=4;$symbols[1][0]=1;$symbols[2][0]=4;
	/*
if($_GET['sessid']=='10637772')
if($lastActionDB!="initfreespin" and $lastActionDB!="freespin" and !isset($restoreAction) and $lastAction!="freespin")
{
$symbols[0][0]=0;$symbols[4][0]=0;
$symbols[2][0]=0;
//$symbols[0][0]=3;$symbols[1][0]=3;$symbols[2][0]=3;
}
*/

	/*
$symbols[0][0]=3;$symbols[0][1]=3;$symbols[0][2]=3;
$symbols[1][0]=4;$symbols[1][1]=4;$symbols[1][2]=4;
$symbols[2][0]=5;$symbols[2][1]=5;$symbols[2][2]=5;
$symbols[3][0]=6;$symbols[3][1]=6;$symbols[3][2]=6;
$symbols[4][0]=7;$symbols[4][1]=7;$symbols[4][2]=7;
*/
	/*
$symbols[0][0]=3;$symbols[0][1]=3;$symbols[0][2]=3;
$symbols[1][0]=4;$symbols[1][1]=3;$symbols[1][2]=4;
$symbols[2][0]=5;$symbols[2][1]=3;$symbols[2][2]=5;
$symbols[3][0]=6;$symbols[3][1]=6;$symbols[3][2]=6;
$symbols[4][0]=7;$symbols[4][1]=7;$symbols[4][2]=7;
*/
	/*
if($lastActionDB!="initfreespin" and $lastActionDB!="freespin")
{
$symbols[0][0]=11;$symbols[0][1]=3;$symbols[0][2]=12;
$symbols[1][0]=10;$symbols[1][1]=3;$symbols[1][2]=5;
$symbols[2][0]=10;$symbols[2][1]=4;$symbols[2][2]=8;
$symbols[3][0]=9;$symbols[3][1]=5;$symbols[3][2]=10;
$symbols[4][0]=8;$symbols[4][1]=5;$symbols[4][2]=11;
}
*/
	$bonusSymbCount = 0;
	foreach ($symbols as $tReel => $t)
		foreach ($t as $tRow => $e) {
			if ($symbols[$tReel][$tRow] == 0) {
				$bonusSymbCount++;
				$bonusReels[$tReel] = 1;
			}
		}

	include('./integr/busters.php');

	$overlaySym = "0";
	$symbolsOverlayed = $symbols;

	if ($lastActionDB != "initfreespin") include($gamePath . 'lines.php');
	else $symb_combs .= " fake spin;";

	if ($lastAction != "respin" and $fsSymbsCount > 4) {
		if ($lastAction != "freespin") {
			$lastAction = "initfreespin";
		}
	}
	if ($fs_left > 0 and $lastAction != "respin" and $lastActionDB != "initfreespin") {
		$fs_left--;
		$fs_played++;
		if ($fsSymbsCount > 4) $lastAction = "addfreespin";
	} elseif ($fs_left > 0 and $lastAction == "respin") $lastAction = "respinFS";

	//////////
	//draw rs
	//////////
	$wild = 0;
	$map = 0;

	$anim_num = 0;
	$sym_num = 0;
	for ($i = 0; $i < 5; $i++) {
		for ($j = 0; $j < 3; $j++) {
			$lastRs .= "rs.i0.r.i" . $sym_num . ".syms=SYM" . $symbolsOverlayed[$i][$j] . "&";
			if ($holdSymbs[$i][$j] == "1") $output .= "rs.i0.r.i" . $sym_num . ".hold=true&";
			else $output .= "rs.i0.r.i" . $sym_num . ".hold=false&";

			$sym_num++;
		}
		$anim_num = 0;
	}

	$output .= $lastRs;


	/////////////////////////////
	//draw ws				///////////////////////odd types.i0.coins
	///////////////////////////
	$anim_num = 0;
	$total_win = 0;

	if ($lastAction == "initfreespin" or $lastAction == "addfreespin") {

		if ($lastAction == "initfreespin") {
			$dop2 .= " init bs=" . $fsSymbsCount;
			if ($fsSymbsCount > 4) $fs_left = 10;
			if ($fsSymbsCount > 5) $fs_left = 15;
			if ($fsSymbsCount > 6) $fs_left = 20;
			if ($fsSymbsCount > 7) $fs_left = 25;
			if ($fsSymbsCount > 8) $fs_left = 30;

			if ($buster10 != '') {
				$fs_left *= 2;
			}
			$symb_combs .= " FSsym:$fsSymbsCount; fs: bus=$buster10, $fs_left;";

			$fs_played = 0;
			$total_win = 0;
			$gameover = "true";
			$output .= "ws.i0.reelset=basic&";
		}

		if ($lastAction == "addfreespin") {
			$dop2 .= " init add bs=" . $fsSymbsCount;
			if ($fsSymbsCount > 4) $add_fs = 10;
			if ($fsSymbsCount > 5) $add_fs = 15;
			if ($fsSymbsCount > 6) $add_fs = 20;
			if ($fsSymbsCount > 7) $add_fs = 25;
			if ($fsSymbsCount > 8) $add_fs = 30;

			$fs_total = $fs_left + $fs_played;
			$fs_left += $add_fs;
			$output .= "ws.i0.reelset=freespin&";
		}

		$k = 0;

		$output .= "ws.i0.types.i0.multipliers=3&";
		$output .= "ws.i0.types.i0.freespins=" . $fs_left . "&";
		$output .= "ws.i0.types.i0.wintype=freespins&";
		$output .= "ws.i0.direction=none&";
		$output .= "ws.i0.sym=SYM0&";
		$output .= "ws.i0.betline=null&";

		for ($i = 0; $i < 5; $i++)
			for ($j = 0; $j < 3; $j++)
				if ($symbols[$i][$j] == "0") {
					$output .= "ws.i0.pos.i" . $k . "=" . $i . "%2C" . $j . "&";
					$k++;
				}



		$anim_num++;
	}

	foreach ($win as $e => $v) {
		$tmp = explode("_", $v);

		$output .= "ws.i" . $anim_num . ".reelset=basic&";

		if ($lastAction != "addfreespin" and $lastAction != "freespin" and $lastAction != "endfreespin" and $lastAction != "respinFS")
			if ($buster12 != '') {
				$tmp[0] *= 2;
				$symb_combs .= " bus=$buster12, " . $tmp[0] . ";";
			}

		$right_coins = $tmp[0] * $denomDB;

		$output .= "ws.i" . $anim_num . ".sym=SYM" . $overlaySym . "&";
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

		if ($fs_left > 0) {
			$output .= "nextaction=freespin&";
			$output .= "current.rs.i0=freespin&";
			$output .= "gamestate.current=freespin&";
			$table_locked = 1;
		} else {
			$gameover = "true";
			$output .= "nextaction=spin&";
			$output .= "current.rs.i0=basic_0&";
			$output .= "gamestate.current=basic&";
			$lastAction = "endfreespin";
			$table_locked = 0;
		}

		$output .= "freespins.total=" . $fs_total . "&";
		$output .= "freespins.left=" . $fs_left . "&";

		$output .= "freespins.multiplier=1&";
		$output .= "next.rs=freespin&";
		$output .= "freespins.initial=10&";
		$output .= "freespins.totalwin.coins=30&";
		$output .= "gamestate.history=basic%2Cfreespin&";
		$output .= "freespins.denomination=1.000&";
		$output .= "last.rs=freespin&";

		$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C21%2C22%2C23%2C24&";
		$output .= "freespins.win.cents=30&";
		$output .= "clientaction=freespin&";
		$output .= "freespins.wavecount=1&";
		$output .= "freespins.win.coins=30&";
		$output .= "freespins.betlevel=1&";
		$output .= "rs.i0.id=freespin&";

		$output .= "previous.rs.i0=freespin&";
		$output .= "gamestate.stack=basic%2Cfreespin&";
		$output .= "freespins.totalwin.cents=30";
	} elseif ($lastAction == "addfreespin") {
		$output .= "rs.i0.id=freespin&";
		$output .= "gamestate.current=freespin&";
		$output .= "gamestate.history=basic%2Cfreespin&";
		$output .= "gamestate.stack=basic%2Cfreespin&";
		$output .= "freespins.initial=1&";
		$output .= "freespins.multiplier=3&";
		$output .= "next.rs=freespin&";
		$output .= "freespins.total=" . $fs_total . "&";
		$output .= "freespins.left=" . $fs_left . "&";

		$output .= "freespins.totalwin.coins=25&";
		$output .= "freespins.denomination=1.000&";
		$output .= "last.rs=freespin&";
		$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C21%2C22%2C23%2C24&";
		$output .= "freespins.win.cents=25&";
		$output .= "clientaction=freespin&";
		$output .= "freespins.wavecount=1&";
		$output .= "freespins.win.coins=25&";
		$output .= "freespins.betlevel=1&";
		$output .= "nextaction=freespin&";
		$output .= "current.rs.i0=freespin&";
		$output .= "previous.rs.i0=freespin&";
		$output .= "freespins.totalwin.cents=25&";

		$gameover = "false";
		$table_locked = 1;
	} elseif ($lastAction == "respinFS") {
		$output .= "nextaction=freespin&";
		$output .= "current.rs.i0=freespin&";
		$output .= "gamestate.current=freespin&";

		$output .= "freespins.total=" . $fs_total . "&";
		$output .= "freespins.left=" . $fs_left . "&";

		$output .= "freespins.multiplier=1&";
		$output .= "next.rs=freespin&";
		$output .= "freespins.initial=10&";
		$output .= "freespins.totalwin.coins=30&";
		$output .= "gamestate.history=basic%2Cfreespin&";
		$output .= "freespins.denomination=1.000&";
		$output .= "last.rs=freespin&";

		$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C21%2C22%2C23%2C24&";
		$output .= "freespins.win.cents=30&";
		$output .= "clientaction=freespin&";
		$output .= "freespins.wavecount=1&";
		$output .= "freespins.win.coins=30&";
		$output .= "freespins.betlevel=1&";
		$output .= "rs.i0.id=freespin&";

		$output .= "previous.rs.i0=freespin&";
		$output .= "gamestate.stack=basic%2Cfreespin&";
		$output .= "freespins.totalwin.cents=30";
		$table_locked = 1;
	} elseif ($lastAction == "respin") {
		$output .= "nextaction=respin&";
		$output .= "gamestate.current=basic&";
		$output .= "rs.i0.id=basic&";
		$output .= "clientaction=spin&";
		$output .= "gamestate.stack=basic&";
		$gameover = "false";
		$table_locked = 1;
	} elseif ($lastAction == "initfreespin") {
		$fs_totalwin = 0;

		$output .= "rs.i0.id=basic&";

		$output .= "gamestate.history=basic&";
		$output .= "gamestate.current=freespin&";
		$output .= "game.win.cents=0&";
		$output .= "game.win.coins=0&";
		$output .= "game.win.amount=0.00&";

		$output .= "gamestate.stack=basic%2Cfreespin&";
		$output .= "clientaction=respin&";
		$output .= "nextaction=freespin&";

		$output .= "freespins.multiplier=3&";
		$output .= "freespins.inital=" . $fs_left . "&";
		$output .= "freespins.left=" . $fs_left . "&";
		$output .= "freespins.total=" . $fs_left . "&";
		$output .= "freespins.totalwin.coins=0&";
		$output .= "freespins.denomination=5.000&";
		$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C21%2C22%2C23%2C24&";
		$output .= "freespins.win.cents=0&";
		$output .= "freespins.win.coins=0&";
		$output .= "freespins.totalwin.cents=0&";
		$output .= "freespins.wavecount=1&";
		$output .= "freespins.betlevel=1&";
		$gameover = "false";
		$table_locked = 1;
	} else {
		$output .= "nextaction=spin&";
		$output .= "gamestate.current=basic&";
		$output .= "rs.i0.id=basic&";
		$output .= "clientaction=spin&";
		$output .= "gamestate.stack=basic&";
		$gameover = "true";
		$table_locked = 0;
	}



	if ($lastAction == "addfreespin") {
		$lastAction = "freespin";
	}

	if ($lastAction == "respinFS") {
		$dop2 .= "|rFS|";
		$lastAction = "freespin";
	}

	if ($lastAction != 'initfreespin') $spin_to_history = 1;

	$credit /= 100;

	$spincost = $betDB * $linesDB * $denomDB * 0.01;

	$real_win = $total_win * $denomDB * 0.01;

	if (isset($freeRoundsLeft)) $spincost = 0;
	if ($lastAction != 'freespin' and $lastAction != 'endfreespin' and $lastAction != 'respin' and $lastAction != 'respinFS') {
		$credit -= $spincost;
	}

	$credit += $real_win;

	$creditDB = $credit * 100;

	$credit *= 100;

	if ($lastAction == 'endfreespin') $totalWinsDB = $fs_totalwin;
	else $totalWinsDB = $total_win;
}


if ($lastAction == "initfreespin" or $lastAction == "addfreespin" or $lastAction == "freespin" or $lastAction == "respinFS") {
	$answ .= "fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";";
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
