<?
header('Access-Control-Allow-Origin: *');
////////////////////////////////////////////////////////////////////////////////
//selectors
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////
//correct action check
////////////////////////////////////

if ($_GET['action'] == "freespin" and $lastActionDB == "spin") exit;

if ($_GET['action'] == "freespin" and $lastActionDB == "paytable" and $answer == '') exit;
if ($_GET['action'] == "respin" and $lastActionDB == "paytable" and $answer == '') exit;
if ($_GET['action'] == "freespin" and $lastActionDB == "init") exit;
if ($_GET['action'] == "respin" and $lastActionDB == "init") exit;

if ($_GET['action'] == "freespin" and $lastActionDB != "freespin" and $lastActionDB != "respin" and $lastActionDB != "paytable") exit;


////////////////////////////////////


////////////////////////////////////
//correct action check
////////////////////////////////////
//    if($_GET['action']=="respin" and $lastActionDB=="spin") exit;
//    if($_GET['action']=="freespin" and $lastActionDB=="spin") exit;
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




if ($_GET['action'] == "spin" or $_GET['action'] == "respin" or $_GET['action'] == "freespin") {
	$lastAction = "spin";
	$buster7 = '';
	$buster8 = '';
	$buster10 = '';
	$buster12 = '';
	if ($lastActionDB == "freespin") $lastAction = "freespin";
	if ($lastActionDB == "respin") $lastAction = "freespin";

	if ($_GET['action'] == "respin" and $lastActionDB == "initfreespin") $lastAction = "respin";

	if ($lastActionDB == "paytable" and isset($restoreAction)) {
		$lastActionDB = $restoreAction;
		$wildsDB = $wildStcks;
		$lastAction = $restoreAction;
	}

	////////////////////
	//symbol generation
	////////////////////
	$i = 0;

	if ($lastAction == "freespin" and $lastActionDB != "initfreespin") {
		$query = "SELECT * FROM ns.bonuses where payRate='" . $payRate . "' and gameId='" . $gameId . "' and (type=0 or type=1 or type=2 or type=3 or type=4 or type=6) order by type asc;";
		$fs_left--;
		$fs_played++;
	} else	$query = "SELECT * FROM ns.reels where payRate=" . $payRate . " and gameId=" . $gameId . " order by id asc;";

	$result = mysql_query($query);

	//echo "<br><br>left ".$query."<br>";


	while ($reels = mysql_fetch_assoc($result)) {
		$reel[$i] = explode("_", $reels['symbols']);
		$i++;
	}

	if ($lastAction == "freespin" and $wildsDB == 'poor') $reel[0] = $reel[5];

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
	//$symbols[0][0]=4;$symbols[0][1]=4;$symbols[0][2]=4;
	//$symbols[1][0]=3;//$symbols[1][1]=1;$symbols[1][2]=5;
	//$symbols[2][0]=7;$symbols[2][1]=3;$symbols[2][2]=8;
	//$symbols[3][0]=12;$symbols[3][1]=1;$symbols[3][2]=11;
	//$symbols[4][0]=3;$symbols[4][1]=5;$symbols[4][2]=5;


	$bonusSymbCount = 0;
	foreach ($symbols as $tReel => $t)
		foreach ($t as $tRow => $e) {
			if ($symbols[$tReel][$tRow] == 0) {
				if (isset($freeRoundsLeft) and $freeRoundsLeft == 1) {
					$symbols[$tReel][$tRow] = round(rand(3, 11));
				} else {
					$bonusSymbCount++;
					$bonusReels[$tReel] = 1;
				}
			}
		}

	if ($bonusSymbCount > 2 and $lastActionDB != "initfreespin" and $lastActionDB != "respin") {
		$lastAction = "initfreespin";
	}	//////////////////////////////////////

	$overlaySym = "0";
	$symbolsOverlayed = $symbols;

	if ($lastActionDB != "initfreespin") include($gamePath . 'lines.php');
	else $symb_combs .= " fake spin;";

	if ($lastAction == "respin") {
		$reels_bns = explode("_", $wildsDB);
		$rls_ = count($reels_bns) - 1;

		if ($buster7 == '' and $buster8 == '') {
			$query = "SELECT * FROM ns.bonuses where payRate='" . $payRate . "' and gameId='" . $gameId . "' and type=5 order by type asc;";

			$result = mysql_query($query);

			$f = mysql_fetch_assoc($result);

			$fs_counts = explode('_', $f['symbols']);

			if ($rls_ == 3)	$fs_total = floor(rand($fs_counts[0], ($fs_counts[1] - 1)));
			if ($rls_ == 4)	$fs_total = floor(rand($fs_counts[1], ($fs_counts[2] - 1)));
			if ($rls_ == 5)	$fs_total = floor(rand($fs_counts[2], 115));

			if (rand(0, 1000) < $fs_counts[3]) $wilds = 'poor';
			else $wilds = 'std';
		} else {
			if ($buster7 != '') {
				$fs_total = 60;
				$wilds = 'std';
			} elseif ($buster8 != '') {
				$fs_total = 9;
				$wilds = 'poor';
			}
		}
		if ($buster10 != '') {
			$fs_total *= 2;
			if ($fs_total > 115) $fs_total = 115;
		}

		$fs_left = $fs_total;
		$fs_played = 0;
		$total_win = 0;
		$fs_totalwin = 0;

		$rX = -1;
		$sum = 0;

		$r = floor($fs_total / $rls_);

		for ($i = 0; $i < ($rls_); $i++) {
			$_1st = floor(rand(0, 2));
			if ($_1st == 0) {
				$_2nd = 2;
				$_3rd = 1;
			}
			if ($_1st == 1) {
				$_2nd = 0;
				$_3rd = 2;
			}
			if ($_1st == 2) {
				$_2nd = 1;
				$_3rd = 0;
			}

			$rX = $reels_bns[$i];

			if ($fs_total < 20) $symbolsFS[$reels_bns[$i]][$_1st] = (floor($r / 3));
			elseif ($fs_total < 35)   $symbolsFS[$reels_bns[$i]][$_1st] = (floor($r / 2));
			else    $symbolsFS[$reels_bns[$i]][$_1st] = (floor($r / 2)) + (floor(rand(-2, 2)));

			if ($symbolsFS[$reels_bns[$i]][$_1st] > 10) $symbolsFS[$reels_bns[$i]][$_1st] = 10;
			if ($symbolsFS[$reels_bns[$i]][$_1st] == 9) $symbolsFS[$reels_bns[$i]][$_1st] = 10;

			$l = $r - $symbolsFS[$reels_bns[$i]][$_1st];

			$symbolsFS[$reels_bns[$i]][$_2nd] = floor($l / 2);
			if ($symbolsFS[$reels_bns[$i]][$_2nd] == 0) $symbolsFS[$reels_bns[$i]][$_2nd] = 1;
			if ($symbolsFS[$reels_bns[$i]][$_2nd] > 10) $symbolsFS[$reels_bns[$i]][$_2nd] = 10;
			if ($symbolsFS[$reels_bns[$i]][$_2nd] == 9) $symbolsFS[$reels_bns[$i]][$_2nd] = 8;

			$symbolsFS[$reels_bns[$i]][$_3rd] = $l - $symbolsFS[$reels_bns[$i]][$_2nd];

			if ($symbolsFS[$reels_bns[$i]][$_3rd] > 10) $symbolsFS[$reels_bns[$i]][$_3rd] = 10;
			if ($symbolsFS[$reels_bns[$i]][$_3rd] == 9) $symbolsFS[$reels_bns[$i]][$_3rd] = 8;

			$sum += $symbolsFS[$reels_bns[$i]][$_1st] + $symbolsFS[$reels_bns[$i]][$_2nd] + $symbolsFS[$reels_bns[$i]][$_3rd];
		}

		$delta = $fs_total - $sum;
		$symbolsFS[$rX][0] += $delta;
		if ($symbolsFS[$rX][0] > 10) $symbolsFS[$rX][0] = 10;
		if ($symbolsFS[$rX][0] == 9) $symbolsFS[$rX][0] = 10;
	}

	//////////
	//draw rs
	//////////
	$wild = 0;
	$nearwin = 0;
	$nearwinstr = '';

	if ($lastAction == "freespin")	$output .= "overlaySym=SYM" . $overlaySym . "&";
	$anim_num = 0;

	for ($i = 0; $i < 5; $i++) {
		if ($overlaySym != 0) {
			for ($j = 0; $j < 3; $j++) {
				if ($symbols[$i][$j] == $overlaySym) {
					$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".row=" . $j . "&";
					$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".with=SYM" . $overlaySym . "&";
					$anim_num++;
				}
			}
			$anim_num = 0;
		}


		if ($lastAction == "respin" and $symbolsFS[$i] != '')	$lastRs .= "rs.i0.r.i" . $i . ".syms=" . $symbolsFS[$i][0] . "," . $symbolsFS[$i][1] . "," . $symbolsFS[$i][2] . "&";
		else	$lastRs .= "rs.i0.r.i" . $i . ".syms=SYM" . $symbolsOverlayed[$i][0] . ",SYM" . $symbolsOverlayed[$i][1] . ",SYM" . $symbolsOverlayed[$i][2] . "&";

		if ($lastAction == "initfreespin") {
			if ($bonusReels[$i] == 1) {
				$output .= "rs.i0.r.i" . $i . ".hold=false&";
				if ($nearwin < 2) $output .= "rs.i0.r.i" . $i . ".attention.i0=1&";
				else $output .= "rs.i0.r.i" . $i . ".attention.i0=0&";
				$wilds .= $i . "_";
			} else $output .= "rs.i0.r.i" . $i . ".hold=true&";
		} elseif ($lastAction == "respin" and $symbolsFS[$i] != '') $output .= "rs.i0.r.i" . $i . ".hold=true&";
		else  $output .= "rs.i0.r.i" . $i . ".hold=false&";


		if ($bonusSymbCount > 1 and $nearwin > 1) {
			if ($nearwinstr == '') $nearwinstr = $i;
			else $nearwinstr .= "," . $i;
		}
		if ($bonusReels[$i] == 1) $nearwin++;
	}
	$output .= $lastRs;

	if ($lastAction != "freespin" and $nearwinstr != '')	$output .= "rs.i0.nearwin=" . $nearwinstr . "&";

	/////////////////////////////
	//draw ws				///////////////////////odd types.i0.coins
	///////////////////////////
	$anim_num = 0;
	$total_win = 0;

	if ($lastAction == "initfreespin") {

		$k = 0;
		$output .= "ws.i0.reelset=basic&";
		$output .= "ws.i0.types.i0.multipliers=1&";
		$output .= "ws.i0.types.i0.freespins=0&";
		$output .= "ws.i0.types.i0.wintype=respin&";
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

		if ($lastAction != "freespin") $output .= "ws.i" . $anim_num . ".reelset=basic_0&";
		else $output .= "ws.i" . $anim_num . ".reelset=freespin2&";

		if ($lastAction != "addfreespin" and $lastAction != "freespin" and $lastAction != "endfreespin" and $lastAction != "respin")
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
			$output .= "gameover=false&";
			$output .= "nextaction=freespin&";
			//     $output.= "current.rs.i0=freespin1&";
			$output .= "current.rs.i0=freespin2&";
			$output .= "gamestate.current=freespin&";
			$output .= "next.rs=freespin1&";
			$table_locked = 1;
		} else {
			$output .= "gameover=true&";
			$output .= "nextaction=spin&";
			$output .= "current.rs.i0=basic_0&";
			$output .= "next.rs=basic_0&";
			$output .= "gamestate.current=basic&";
			$lastAction = "endfreespin";
			$table_locked = 0;
		}

		$output .= "freespins.total=" . $fs_total . "&";
		$output .= "freespins.left=" . $fs_left . "&";



		$output .= "freespins.multiplier=1&";
		$output .= "freespins.initial=0&";
		$output .= "freespins.totalwin.coins=0&";
		$output .= "gamestate.history=basic%2Crespin%2Cfreespin&";
		$output .= "freespins.denomination=1.000&";
		//    $output.="last.rs=freespin1&";
		$output .= "last.rs=freespin2&";
		$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19&";
		$output .= "freespins.win.cents=0&";
		$output .= "clientaction=freespin&";
		$output .= "freespins.wavecount=1&";
		$output .= "freespins.win.coins=0&";
		$output .= "freespins.betlevel=1&";
		//    $output.="current.rs.i0=freespin1&";
		$output .= "current.rs.i0=freespin2&";
		//    $output.="rs.i0.id=freespin1&";
		$output .= "rs.i0.id=freespin2&";
		//    $output.="previous.rs.i0=freespin1&";
		$output .= "previous.rs.i0=freespin2&";
		$output .= "gamestate.stack=basic%2Cfreespin&";
		$output .= "freespins.totalwin.cents=0&";
	} elseif ($lastAction == "respin") {

		$output = "next.rs=freespin1&";

		$output .= $lastRs;

		$output .= "freespins.left=" . $fs_total . "&";
		$output .= "freespins.total=" . $fs_total . "&";

		$output .= "freespins.multiplier=1&";
		$output .= "totalwin.cents=0&";
		$output .= "totalwin.coins=0&";
		$output .= "game.win.cents=0&";

		$output .= "freespins.initial=0&";
		$output .= "freespins.totalwin.coins=0&";
		$output .= "gamestate.history=basic%2Crespin&";
		$output .= "freespins.denomination=1.000&";
		$output .= "last.rs=respin&";

		$output .= "gamestate.current=freespin&";

		$output .= "rs.i0.r.i0.hold=false&";
		$output .= "rs.i0.r.i1.hold=false&";
		$output .= "rs.i0.r.i2.hold=false&";
		$output .= "rs.i0.r.i3.hold=false&";
		$output .= "rs.i0.r.i4.hold=false&";

		$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19&";

		$output .= "freespins.win.cents=0&";
		$output .= "game.win.amount=0&";
		$output .= "clientaction=respin&";
		$output .= "freespins.wavecount=1&";
		$output .= "freespins.win.coins=0&";
		$output .= "freespins.betlevel=1&";
		$output .= "nextaction=freespin&";



		$output .= "game.win.coins=50&";
		$output .= "current.rs.i0=freespin1&";
		$output .= "rs.i0.id=respin&";

		$output .= "gameover=false&";
		$output .= "previous.rs.i0=respin&";
		$output .= "gamestate.stack=basic%2Cfreespin&";
		$output .= "freespins.totalwin.cents=0&";

		$table_locked = 1;
	} elseif ($lastAction == "initfreespin") {
		$output .= "nextaction=respin&";
		$output .= "gamestate.stack=basic%2Crespin&";
		$output .= "gameover=false&";
		$output .= "current.rs.i0=respin&";
		$output .= "gamestate.history=basic&";
		$output .= "gamestate.current=respin&";
		$output .= "clientaction=spin&";
		$output .= "rs.i0.id=basic&";
		$table_locked = 1;

		$_Events['402'] = 1;
	} else {

		//basic mode
		$output .= "rs.i0.id=basic_0&";
		$output .= "current.rs.i0=basic_0&";
		$output .= "next.rs=basic_0&";
		$output .= "previous.rs.i0=basic_0&";
		$output .= "last.rs=basic_0&";
		$output .= "gamestate.current=basic&";
		$output .= "clientaction=spin&";
		$output .= "gamestate.stack=basic&";
		$output .= "gamestate.history=basic&";
		$output .= "nextaction=spin&";
		$table_locked = 0;
	}


	$spincost = 0;
	if ($lastAction != 'freespin' and $lastAction != 'respin' and $lastAction != 'endfreespin') {
		$spin_to_history = 1;
		$spincost = $betDB * $linesDB * $denomDB * 0.01;
	}

	$credit /= 100;

	$real_win = $total_win * $denomDB * 0.01;

	if (isset($freeRoundsLeft)) $spincost = 0;
	//if($lastAction!='respin' and $lastAction!='freespin' and $lastAction!='endfreespin')
	{
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

if ($lastAction == "respin" or $lastAction == "freespin") {
	$answ .= "fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";";
}

//echo "LADB=$lastActionDB&LA=$lastAction&";


////widget
if (isset($freeRoundsLeft) and $freeRoundsLeft > 0 and $lastAction != 'init' and $lastAction != 'paytable' and $lastAction != 'widgetspin') {
	if ($lastAction != 'respin' and $lastAction != 'freespin' and $lastAction != 'endfreespin') {
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
