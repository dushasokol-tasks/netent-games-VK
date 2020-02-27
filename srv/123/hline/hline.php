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
$buster10 = '';

////////////////////////////////////
//correct action check
////////////////////////////////////
if ($_GET['action'] == "freespin" and ($lastActionDB == "spin")) exit;
if ($_GET['action'] == "freespin" and $lastActionDB == "paytable" and $answer == '') exit;
if ($_GET['action'] == "respin" and $lastActionDB == "paytable" and $answer == '') exit;
if ($_GET['action'] == "freespin" and $lastActionDB == "init") exit;
if ($_GET['action'] == "respin" and $lastActionDB == "init") exit;

if ($_GET['action'] == "freespin" and $lastActionDB != "freespin" and $lastActionDB != "startfreespin" and $lastActionDB != "paytable") exit;

////////////////////////////////////

//echo "2";

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
	$gameover = "true";
	$overlaySym = "";
	$table_locked = 1;

	if ($lastActionDB == "paytable" and isset($restoreAction)) {
		$lastActionDB = $restoreAction;
		$wildsDB = $wildStcks;
	}

	$hotlines = explode(",", $anBetVarDB);

	$lastAction = "spin";
	if ($lastActionDB == "freespin" and $_GET['action'] == "freespin") $lastAction = "freespin";
	if ($lastActionDB == "startfreespin" and $_GET['action'] == "freespin") $lastAction = "freespin";


	////////////////////
	//symbol generation
	////////////////////
	$i = 0;

	if ($lastAction == "freespin") {
		$query = "SELECT * FROM ns.bonuses where payRate='" . $payRate . "' and gameId='" . $gameId . "' and (type=0 or type=1 or type=2 or type=3 or type=4 or type=5 or type=6) order by type asc;";
		$fs_left--;
		$fs_played++;
	} else	$query = "SELECT * FROM ns.reels where payRate=" . $payRate . " and gameId=" . $gameId . " order by id asc;";

	$result = mysql_query($query);

	while ($reels = mysql_fetch_assoc($result)) {
		$reel[$i] = explode("_", $reels['symbols']);
		$i++;
	}


	if ($lastAction != "freespin") {
		if (count($hotlines) > 1) {
			$reel[1] = $reel[6];
		}
		if (count($hotlines) > 2) {
			$reel[0] = $reel[5];
		}
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

	//if($lastAction!="freespin" and $lastAction!="initfreespin" and $lastActionDB!="freespin"){$symbols[0][0]=0;$symbols[4][0]=0;$symbols[2][0]=0;}
	//if($lastAction!="freespin" and $lastAction!="initfreespin"){$symbols[0][1]=1;$symbols[1][1]=1;$symbols[2][1]=1;}

	/*
$symbols[0][0]=7;$symbols[0][1]=0;$symbols[0][2]=1;
$symbols[1][0]=0;$symbols[1][1]=1;$symbols[1][2]=6;
$symbols[2][0]=7;$symbols[2][1]=0;$symbols[2][2]=6;
$symbols[3][0]=3;$symbols[3][1]=5;$symbols[3][2]=3;
$symbols[4][0]=5;$symbols[4][1]=0;$symbols[4][2]=1;
*/

	/*
if($lastActionDB=="spin" or $lastActionDB=="paytable" or $lastActionDB=="spin1")
{

$symbols[0][0]=3;$symbols[0][1]=3;$symbols[0][2]=0;
$symbols[1][0]=5;$symbols[1][1]=5;$symbols[1][2]=1;
$symbols[2][0]=7;$symbols[2][1]=0;$symbols[2][2]=4;
$symbols[3][0]=4;$symbols[3][1]=4;$symbols[3][2]=5;
$symbols[4][0]=0;$symbols[4][1]=3;$symbols[4][2]=3;

}
*/

	//if($lastActionDB=="respin")$symbols[0][0]=0;$symbols[2][0]=0;$symbols[4][0]=0;

	//if($lastActionDB=="respin")$symbols[3][2]=1;


	/*
if($lastAction=="freespin")
{

$symbols[0][0]=7;$symbols[0][1]=5;$symbols[0][2]=5;
$symbols[1][0]=1;$symbols[1][1]=8;$symbols[1][2]=3;
$symbols[2][0]=5;$symbols[2][1]=8;$symbols[2][2]=4;
$symbols[3][0]=6;$symbols[3][1]=5;$symbols[3][2]=8;
$symbols[4][0]=7;$symbols[4][1]=7;$symbols[4][2]=7;

}
*/

	//if($lastActionDB=="freespin")$symbols[4][1]=1;



	//if($lastActionDB=="paytable")
	//{
	//    $symbols[2][0]=14;$symbols[1][0]=14;//$symbols[3][0]=14;
	//}

	//if($lastActionDB=="respin1")$symbols[1][2]=13;

	//echo $lastActionDB."&!&";

	/*
if($lastActionDB=="respin")
{
//$symbols[2][0]=1;
//$symbols[2][0]=3;
//$symbols[1][0]=3;
//$symbols[4][0]=3;

$symbols[0][2]=0;
$symbols[2][2]=0;
$symbols[4][2]=0;

}
*/

	include('./integr/busters.php');

	$bonusSymbCount = 0;
	foreach ($symbols as $tReel => $t)
		foreach ($t as $tRow => $e) {
			if ($symbols[$tReel][$tRow] == 0) {
				$bonusSymbCount++;
				$bonusReels[$tReel] = 1;
				$bonusPos[$tReel] = $tRow;
			}
		}

	include($gamePath . 'lines.php');

	if ($bonusSymbCount > 1 and $bonusReels[0] == 1 and $bonusReels[2] == 1)
		if ($lastAction == "spin") $output .= "rs.i0.nearwin=4&";

	if ($bonusSymbCount > 2) {
		$lastAction = "startfreespin";
	}


	//if($overlaySym!="") $output.= "overlaySym=SYM".$overlaySym."&";

	//////////
	//draw rs
	//////////
	$wild = 0;

	$anim_num = 0;

	for ($i = 0; $i < 5; $i++) {
		if ($overlaySym != 0) {
			for ($j = 0; $j < 3; $j++) { {
					if ($symbols[$i][$j] == $overlaySym and $symbolsOverlayed[$i][$j] != $overlaySym) {
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
	}

	$output .= $lastRs;

	/////////////////////////////
	//draw ws			
	///////////////////////////
	$anim_num = 0;
	$total_win = 0;
	$temp = 0;


	if ($lastAction == "startfreespin") {
		$output .= "ws.i0.types.i0.wintype=freespins&";
		$output .= "ws.i0.direction=none&";

		foreach ($bonusPos as $e => $v) {
			$output .= "ws.i0.pos.i" . $temp . "=" . $e . "%2C" . $v . "&";
			$temp++;
		}

		$output .= "ws.i0.sym=SYM0&";
		$output .= "ws.i0.betline=null&";
		$output .= "ws.i0.types.i0.freespins=7&";

		$anim_num++;
	}

	foreach ($win as $e => $v) {
		$tmp = explode("_", $v);


		if ($lastAction == "spin") $output .= "ws.i" . $anim_num . ".reelset=basic&";
		elseif ($lastAction == "respin") {
			$output .= "ws.i" . $anim_num . ".reelset=respin&";
		} elseif ($lastAction == "spin1") {
			$output .= "ws.i" . $anim_num . ".reelset=respin&";
		} else {
			if ($wilds == '')	$output .= "ws.i" . $anim_num . ".reelset=freespin_nowilds123&";
			else 	$output .= "ws.i" . $anim_num . ".reelset=freespin_last123&";

			$tmp[0] *= $fs_multiplier;
		}

		if ($lastAction != "freespin" and $lastAction != "endfreespin")
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

		$output .= "ws.i" . $anim_num . ".types.i0.cents=" . $right_coins . "&";


		$total_win += $tmp[0];

		$ani = explode(";", $tmp[1]);
		$i = 0;


		foreach ($ani as $smb) {
			$output .= "ws.i" . $anim_num . ".pos.i" . $i . "=" . $smb . "&";
			$i++;
		}

		$anim_num++;
	}

	$output .= "hotlines=" . $anBetVarDB . "&";


	if ($lastAction == "freespin") {

		$fs_total = $fs_left + $fs_played;
		$fs_totalwin += $total_win;

		if ($fs_left > 0) {
			$gameover = "false";
			$output .= "next.rs=freespin&";
			$output .= "nextaction=freespin&";
			if ($wilds == '')	$output .= "rs.i0.id=freespin_nowilds123&";
			else {
				$output .= "rs.i0.id=freespin_last123&";
				$output .= "wildstacks.freespin=$wldstcks&";
			}
			$output .= "gamestate.history=basic%2Cfreespin&";
			$output .= "gamestate.current=freespin&";
			$output .= "gamestate.stack=basic%2Cfreespin&";
		} else {
			$output .= "gamestate.history=basic%2Cfreespin&";
			$output .= "gamestate.current=basic&";
			$output .= "gamestate.stack=basic&";

			$output .= "rs.i0.id=freespin_last12&";
			if ($wilds != '') $output .= "wildstacks.freespin=$wldstcks&";
			$output .= "next.rs=freespin&";
			$output .= "nextaction=spin&";
			$lastAction = "endfreespin";
			$table_locked = 0;
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


		$output .= "freespins.betlevel=1&";
		$output .= "freespins.wavecount=1&";
		$output .= "freespins.multiplier=1&";

		$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C21%2C22%2C23%2C24%2C25%2C26%2C27%2C28%2C29&";


		$output .= "last.rs=freespin&";
		$output .= "current.rs.i0=freespin&";
		$output .= "previous.rs.i0=freespin&";
		$output .= "clientaction=freespin&";
	} elseif ($lastAction == "startfreespin") {
		$fs_left = 7;
		$fs_played = 0;
		$fs_totalwin = 0;
		$fs_multiplier = 1;
		$fs_initial = 7;

		if ($buster10 != '') {
			$fs_left *= 2;
			$fs_initial *= 2;
		}

		$output .= "freespins.multiplier=1&";
		$output .= "next.rs=freespin&";
		$output .= "freespins.total=" . $fs_left . "&";
		$output .= "freespins.initial=" . $fs_left . "&";
		$output .= "freespins.left=" . $fs_left . "&";
		$output .= "freespins.totalwin.coins=0&";
		$output .= "gamestate.history=basic&";
		$output .= "freespins.denomination=1.000&";
		$output .= "gamestate.current=freespin&";
		$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C21%2C22%2C23%2C24%2C25%2C26%2C27%2C28%2C29&";

		$output .= "freespins.win.cents=0&";
		$output .= "clientaction=spin&";
		$output .= "freespins.wavecount=1&";
		$output .= "freespins.win.coins=0&";
		$output .= "freespins.betlevel=1&";
		$output .= "nextaction=freespin&";

		$output .= "current.rs.i0=freespin&";
		$output .= "rs.i0.id=basic&";

		$output .= "gamestate.stack=basic%2Cfreespin&";
		$output .= "freespins.totalwin.cents=0&";

		$wilds = '';
		$table_locked = 1;
		$botAction = "freespin";
	} elseif ($lastAction == "respin") {
		$gameover = "false";
		$table_locked = 1;

		$output .= "wildstacks.respin=$wldstcks&";

		$output .= "gamestate.stack=basic&";
		$output .= "gamestate.history=basic%2Crespin&";
		$output .= "gamestate.current=basic&";

		$output .= "clientaction=respin&";
		$output .= "nextaction=respin&";

		$output .= "last.rs=respin&";
		$output .= "previous.rs.i0=respin&";

		$output .= "next.rs=basic&";
		$output .= "current.rs.i0=basic&";

		$output .= "rs.i0.id=respin&";
	} elseif ($lastAction == "spin1") {
		$output .= "gamestate.stack=basic&";
		$output .= "gamestate.history=basic%2Crespin&";
		$output .= "gamestate.current=basic&";

		$output .= "clientaction=respin&";
		$output .= "nextaction=spin&";

		$output .= "last.rs=respin&";
		$output .= "previous.rs.i0=respin&";

		$output .= "next.rs=basic&";
		$output .= "current.rs.i0=basic&";

		$output .= "rs.i0.id=respin&";

		$output .= "wildstacks.respin=$wldstcks&";

		$table_locked = 0;
		$botAction = "spin";
	} else {

		if ($wilds != '')	$output .= "wildstacks.respin=$wldstcks&";

		$output .= "gamestate.stack=basic&";
		$output .= "gamestate.history=basic%2Crespin&";
		$output .= "gamestate.current=basic&";

		$output .= "clientaction=respin&";
		$output .= "nextaction=spin&";

		$output .= "last.rs=respin&";
		$output .= "previous.rs.i0=respin&";

		$output .= "next.rs=basic&";
		$output .= "current.rs.i0=basic&";

		$output .= "rs.i0.id=respin&";

		$table_locked = 0;
		$botAction = "spin";
	}


	$spincost = 0;
	if ($lastAction != 'freespin' and $lastAction != 'endfreespin' and $lastAction != 'respin') {
		$spin_to_history = 1;
		$spincost = ($betDB * $linesDB * $denomDB * 0.01) * $hotlinesCount;
	}

	$credit /= 100;

	$real_win = $total_win * $denomDB * 0.01;

	if (isset($freeRoundsLeft)) $spincost = 0;
	$credit -= $spincost;

	$credit += $real_win;

	$creditDB = $credit * 100;

	$credit *= 100;

	if ($lastAction != 'respin' and $lastAction != 'spin1') $totalWinsDB = $total_win;
}

if ($lastAction == "freespin"  or $lastAction == "startfreespin") {
	if ($fs_left > 0) {
		$answ .= "fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";fs_multiplier=" . $fs_multiplier . ";fs_initial=" . $fs_initial . ";";
	}
}

if ($lastAction == "respin") {
	$symb_combs = "wilds=" . $wilds . ";" . $symb_combs;
	$totalWinsDB += $total_win;
	$answ .= "totalWinsDB=" . $totalWinsDB . ";";
}

if ($lastAction == "spin1") {
	$symb_combs = "wilds=" . $wildsDB . ";" . $symb_combs;
	$totalWinsDB += $total_win;
	$answ .= "totalWinsDB=0;";
}


if ($lastAction == "endfreespin") {
	$symb_combs = "win=" . $fs_totalwin . ";fspins=" . $fs_played . ";wilds=" . $wilds . ";" . $symb_combs;
	$wilds = '';
	$botAction = "spin";
}


////widget
if (isset($freeRoundsLeft) and $freeRoundsLeft > 0 and $lastAction != 'init' and $lastAction != 'paytable' and $lastAction != 'widgetspin') {
	if ($lastAction == 'spin' or $lastAction == 'spin1' or $lastAction == 'startfreespin') {
		$freeRoundsLeft--;
		$output .= "freeRoundsLeft=$freeRoundsLeft&";
		$output .= "gameroundid=$freeRoundsLeft&";
	}
	$freeRoundsWin += $real_win * 100;

	if ($freeRoundsLeft == 0) {
		if ($lastAction != 'endfreespin' or $lastAction != 'spin' or $lastAction != 'spin1') {
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
