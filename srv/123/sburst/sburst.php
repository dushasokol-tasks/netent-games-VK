<?
header('Access-Control-Allow-Origin: *');
////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////
//correct action check
////////////////////////////////////
//    if($_GET['action']=="freespin" and ($lastActionDB=="spin" or $lastActionDB=="respin" or $lastActionDB=="paytable" or $lastActionDB=="init")) exit;
////////////////////////////////////////////////////////////////////////////////
//    if($_GET['action']=="bonusaction" and $lastActionDB!="bonusgame" and $_GET['bot']!=1)	 exit;


if ($_GET['action'] == "respin" and $lastActionDB == "paytable" and $answer == '') exit;
if ($_GET['action'] == "respin" and $lastActionDB == "init") exit;




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


if ($_GET['action'] == "spin" or $_GET['action'] == "respin") {
	$gameover = "true";

	$lastAction = "spin";
	$buster12 = '';

	if ($lastActionDB == "paytable" and isset($restoreAction)) {
		$lastActionDB = $restoreAction;
		$wildsDB = $wildStcks;
	}
	////////////////////
	//symbol generation
	////////////////////
	$i = 0;

	$query = "SELECT * FROM ns.reels where payRate=" . $payRate . " and gameId=" . $gameId . " order by id asc;";

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

	//$symbols[0][0]=7;$symbols[0][1]=8;$symbols[0][2]=5;
	//$symbols[1][0]=7;$symbols[1][1]=8;$symbols[1][2]=9;
	//$symbols[2][0]=7;$symbols[2][1]=8;$symbols[2][2]=9;
	//$symbols[3][0]=7;$symbols[3][1]=8;$symbols[3][2]=9;
	//$symbols[4][0]=7;$symbols[4][1]=8;$symbols[4][2]=9;


	//if($lastAction!="freespin")
	//{
	//$symbols[3][0]=1;
	//$symbols[2][0]=1;
	//$symbols[1][0]=1;
	//$symbols[4][0]=3;

	//$symbols[1][2]=0;
	//$symbols[2][2]=0;
	//$symbols[3][2]=0;
	//}

	//if($lastAction=="spin")$symbols[1][0]=1;
	//if($lastActionDB=="stackSpin")$symbols[2][0]=1;

	//$symbols[1][2]=1;

	$wildsSymbCount = 0;
	foreach ($symbols as $tReel => $t)
		foreach ($t as $tRow => $e) {
			//	$symbols[$tReel][$tRow]=3;
			if ($symbols[$tReel][$tRow] == 1) {
				$wildsSymbCount++;
				$extrawild[$tReel][$tRow] = 1;
				$wildReels[$tReel] = 1;
			}
		}

	//    $wildsSymbCount++;
	//    $extrawild[1][1]=1;
	//    $wildReels[1]=1;

	//if($lastActionDB!="respin" and $lastActionDB!="init")
	{
		if ($wildsSymbCount > 0 or $wildsDB != '') $lastAction = "respin";
	}

	$overlaySym = 1;

	include($gamePath . 'lines.php');

	if ($lastAction == "spin") $output .= "overlaySym=SYM" . $overlaySym . "&";

	//////////
	//draw rs
	//////////
	$wild = 0;
	$nearwin = 0;
	$nearwinstr = '';
	$map = 0;

	$anim_num = 0;

	for ($i = 0; $i < 5; $i++) {
		if ($overlaySym != 0) {
			for ($j = 0; $j < 3; $j++) { {
					if ($symbols[$i][$j] == $overlaySym) {

						$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".row=" . $j . "&";
						$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".with=SYM" . $overlaySym . "&";
						$anim_num++;
					}
				}
			}
			$anim_num = 0;
		}

		$lastRs .= "rs.i0.r.i" . $i . ".syms=SYM" . $symbolsOverlayed[$i][0] . ",SYM" . $symbolsOverlayed[$i][1] . ",SYM" . $symbolsOverlayed[$i][2] . "&";

		if ($lastAction == "stackSpin" or $lastAction == "stackSpin1") {
			if ($extrawild[$i][0] == 1) {
				$output .= "rs.i0.r.i" . $i . ".hold=true&";
			}
		} else

			$output .= "rs.i0.r.i" . $i . ".hold=false&";
	}
	$output .= $lastRs;

	/////////////////////////////
	//draw ws			
	///////////////////////////
	$anim_num = 0;
	$total_win = 0;

	foreach ($win as $e => $v) {
		$tmp = explode("_", $v);

		if ($lastAction != "spin" and $lastAction != "stackSpin1")
			$output .= "ws.i" . $anim_num . ".reelset=wildOnReel_" . $old_rls . "&";
		else
			$output .= "ws.i" . $anim_num . ".reelset=basic&";

		if ($lastAction == "spin" or $lastAction == "respin")
			if ($buster12 != '') {
				$tmp[0] *= 2;
				$symb_combs .= " bus=$buster12, " . $tmp[0] . ";";
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


	if ($lastAction == "stackSpin1") {

		$gameover = "false";
		$lastAction = "stackSpin";
		$output .= "gamestate.history=basic&";
		$output .= "gamestate.current=basic&";
		$output .= "gamestate.stack=basic&";
		$output .= "clientaction=spin&";
		$output .= "nextaction=respin&";
		$output .= "previous.rs.i0=basic&";
		$output .= "last.rs=basic&";
		$output .= "next.rs=wildOnReel_" . $rls . "&";
		$output .= "current.rs.i0=wildOnReel_" . $rls . "&";
		$output .= "rs.i0.id=basic&";

		$botAction = "respin";
		$table_locked = 1;
	} elseif ($lastAction == "stackSpin") {
		$gameover = "false";
		$output .= "gamestate.history=basic&";
		$output .= "gamestate.current=basic&";
		$output .= "gamestate.stack=basic&";
		$output .= "clientaction=respin&";
		$output .= "nextaction=respin&";
		$output .= "previous.rs.i0=wildOnReel_" . $old_rls . "&";
		$output .= "last.rs=wildOnReel_" . $old_rls . "&";
		$output .= "next.rs=wildOnReel_" . $rls . "&";
		$output .= "current.rs.i0=wildOnReel_" . $rls . "&";
		$output .= "rs.i0.id=wildOnReel_" . $old_rls . "&";

		$output .= "rs.i0.r.i1.overlay.i1.pos=1&";
		$output .= "rs.i0.r.i2.overlay.i1.pos=1&";
		$output .= "rs.i0.r.i2.overlay.i0.pos=0&";
		$output .= "rs.i0.r.i1.overlay.i2.pos=2&";
		$output .= "rs.i0.r.i2.overlay.i2.pos=2&";
		$output .= "rs.i0.r.i1.overlay.i0.pos=0&";

		$botAction = "respin";
		$table_locked = 1;
	} elseif ($lastAction == "respin") {
		$output .= "gamestate.history=basic&";
		$output .= "gamestate.current=basic&";
		$output .= "gamestate.stack=basic&";
		$output .= "clientaction=respin&";
		$output .= "nextaction=spin&";
		$output .= "previous.rs.i0=wildOnReel_" . $rls . "&";
		$output .= "last.rs=wildOnReel_" . $rls . "&";
		$output .= "next.rs=basic&";
		$output .= "current.rs.i0=basic&";
		$output .= "rs.i0.id=wildOnReel_" . $rls . "&";

		$botAction = "spin";
		$table_locked = 0;
	} else {
		$output .= "historybutton=false&";
		$output .= "gamestate.current=basic&";
		$output .= "gamestate.stack=basic&";
		$output .= "clientaction=spin&";
		$output .= "nextaction=spin&";
		$output .= "previous.rs.i0=basic&";
		$output .= "last.rs=basic&";
		$output .= "next.rs=basic&";
		$output .= "current.rs.i0=basic&";
		$output .= "rs.i0.id=basic&";

		$botAction = "spin";
		$table_locked = 0;
	}

	$spincost = 0;
	if ($lastAction != 'freespin' and $lastAction != 'endfreespin') {
		$spin_to_history = 1;
		$spincost = $betDB * $linesDB * $denomDB * 0.01;
	}

	$credit /= 100;

	$real_win = $total_win * $denomDB * 0.01;

	if (isset($freeRoundsLeft)) $spincost = 0;
	if ($lastAction != 'random_wilds' and $lastAction != 'stackSpin' and $lastAction != 'freespin' and $lastAction != 'endfreespin') {
		$credit -= $spincost;
	}

	$credit += $real_win;

	$creditDB = $credit * 100;

	$credit *= 100;

	if ($lastAction == 'endfreespin') $totalWinsDB = $fs_totalwin;
	elseif ($lastAction != 'respin' and $lastAction != 'stackSpin' and $lastAction != "random_wilds") $totalWinsDB = $total_win;
}

if ($lastAction == "freespin") {
	$answ .= "fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";" . $answFS;
}

if ($lastAction == "stackSpin" or $lastAction == "random_wilds") {
	$totalWinsDB += $total_win;
	$answ .= "totalWinsDB=" . $totalWinsDB . ";";
}

if ($lastAction == "respin") {
	$totalWinsDB += $total_win;
}



/*
 if($lastAction=="initfreespin" or $lastAction=="bonusaction")
    {
//	$query.=", locked='1'";
    }
*/

if ($lastAction == "endfreespin") {
	//	$query.=", locked='0'";
	$symb_combs = $fgType . ";win=" . $fs_totalwin . ";" . $symb_combs;
}


////widget
if (isset($freeRoundsLeft) and $freeRoundsLeft > 0 and $lastAction != 'init' and $lastAction != 'paytable' and $lastAction != 'widgetspin') {
	if ($lastAction == 'spin' or $lastAction == 'stackSpin') {
		$freeRoundsLeft--;
		if ($lastAction != 'stackSpin' and $freeRoundsLeft != 0) {
			$output .= "freeRoundsLeft=$freeRoundsLeft&";
			$output .= "gameroundid=$freeRoundsLeft&";
		}
	}
	$freeRoundsWin += $real_win * 100;

	if ($freeRoundsLeft == 0) {
		if ($lastAction != 'stackSpin' or $lastAction != 'spin') {
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
