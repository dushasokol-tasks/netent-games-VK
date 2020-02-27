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


if ($_GET['action'] == "freespin" and ($lastActionDB == "spin" or $lastActionDB == "daze" or $lastActionDB == "endfreespin")) exit;
if ($_GET['action'] == "freespin" and $lastActionDB == "paytable" and $answer == '') exit;
if ($_GET['action'] == "freespin" and $lastActionDB == "init") exit;

if ($_GET['action'] == "freespin" and $lastActionDB != "freespin" and $lastActionDB != "startfreespin" and $lastActionDB != "paytable") exit;

if (
	$_GET['action'] == 'initfreespin' and
	(($lastActionDB != "initfreespin" and $lastActionDB != "paytable") or
		($lastActionDB == "paytable" and ($answer == '' or (!isset($fs_left) or $fs_left <= 0))))
) exit();

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




if ($_GET['action'] == 'initfreespin') {
	$gameover = "false";

	$output .= "clientaction=spin&";
	$output .= "freespins.betlevel=1&";
	$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C21%2C22%2C23%2C24%2C25%2C26%2C27%2C28%2C29%2C30%2C31%2C32%2C33%2C34%2C35%2C36%2C37%2C38%2C39%2C40%2C41%2C42%2C43%2C44%2C45%2C46%2C47%2C48%2C49%2C50%2C51%2C52%2C53%2C54%2C55%2C56%2C57%2C58%2C59%2C60%2C61%2C62%2C63%2C64%2C65%2C66%2C67%2C68%2C69%2C70%2C71%2C72%2C73%2C74%2C75&";
	$output .= "freespins.denomination=1.000&";
	$output .= "freespins.initial=$fs_left&";
	$output .= "freespins.left=$fs_left&";
	$output .= "freespins.multiplier=1&";
	$output .= "freespins.total=$fs_left&";
	$output .= "freespins.totalwin.cents=0&";
	$output .= "freespins.totalwin.coins=0&";
	$output .= "freespins.wavecount=1&";
	$output .= "freespins.win.cents=0&";
	$output .= "freespins.win.coins=0&";
	$output .= "gamestate.current=freespin&";
	$output .= "gamestate.history=basic&";
	$output .= "gamestate.stack=basic%2Cfreespin&";
	$output .= "nextaction=freespin&";
	$output .= "rs.i0.id=basic&";
	//$output.= "rs.i0.id=freespin&";


	if (isset($lastRsDB) and $lastRsDB != '')    $output .= $lastRsDB;
	else {
		$output .= "rs.i0.r.i0.syms=SYM4%2CSYM0%2CSYM6&";
		$output .= "rs.i0.r.i1.syms=SYM8%2CSYM8%2CSYM8&";
		$output .= "rs.i0.r.i2.syms=SYM5%2CSYM5%2CSYM0%2CSYM8&";
		$output .= "rs.i0.r.i3.syms=SYM5%2CSYM5%2CSYM5%2CSYM0&";
		$output .= "rs.i0.r.i4.syms=SYM5%2CSYM6%2CSYM6%2CSYM6%2CSYM6&";
	}

	$lastAction = 'startfreespin';
	$botAction = "freespin";
}





if ($_GET['action'] == "spin" or $_GET['action'] == "respin" or $_GET['action'] == "freespin") {

	$lastAction = "spin";
	if ($lastActionDB == "paytable" and isset($restoreAction)) {
		$lastActionDB = $restoreAction;
		$wildsDB = $wildStcks;
	}

	if ($lastActionDB == "freespin" and $_GET['action'] == "freespin") $lastAction = "freespin";
	if ($lastActionDB == "startfreespin" and $_GET['action'] == "freespin") $lastAction = "freespin";

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

	//for ($i=0;$i<5;$i++)
	unset($symbols[0][4]);
	unset($symbols[0][3]);
	unset($symbols[1][4]);
	unset($symbols[1][3]);
	unset($symbols[2][4]);
	unset($symbols[3][4]);


	include('./integr/busters.php');

	//$symbols[2][2]=3;$symbols[2][1]=3;$symbols[2][0]=3;$symbols[2][3]=3;
	if ($lastAction != 'freespin') {
		$symbols[0][2] = 0;
		$symbols[1][2] = 0;
		$symbols[4][2] = 0;
		$symbols[3][2] = 0;
	}

	//$symbols[0][0]=7;$symbols[0][1]=7;$symbols[0][2]=7;
	//$symbols[1][0]=8;$symbols[1][1]=8;$symbols[1][2]=8;

	$bonusSymbCount = 0;
	$nearWinReel = 0;
	foreach ($symbols as $tReel => $t)
		foreach ($t as $tRow => $e) {
			if ($symbols[$tReel][$tRow] == 0) {
				$bonusSymbCount++;
				$nearWinReel = $tReel;
				$bonusReel[$tReel] = 1;
			}
		}
	if ($bonusSymbCount > 2) {
		if ($lastAction == 'spin') {
			$lastAction = "initfreespin";
			if ($bonusSymbCount == 3) $fs_initial = 8;
			if ($bonusSymbCount == 4) $fs_initial = 12;
			if ($bonusSymbCount == 5) $fs_initial = 16;
		}
	}

	///////////////////////////////////////

	$dazeRate = $reel[5][0];		//common probability of wld stack
	$dazeRate0reel = $reel[5][1];		// probabilities by reel
	$dazeRate1reel = $reel[5][2];
	$dazeRate2reel = $reel[5][3];
	$dazeRate3reel = $reel[5][4];
	$dazeRate4reel = $reel[5][5];
	$dazeStacksThreshold = $reel[5][6];

	$linkedNumRate = $reel[5][0];		//is 2 pairs of linkedreels
	$linkedPartRate = $reel[5][1];	// left or right reel link

	//////////////////////////////////////
	//    $dazeRate=0;

	if ($lastAction == "spin") {
		if ($bonusSymbCount < 3 and $lastAction == "spin") {
			//	if($lastActionDB=="spin" or $buster8!='')
			{

				if (rand(0, 1000) < $dazeRate) {
					//		$lastAction="daze";
					if (count($makeStack) < $dazeStacksThreshold) if (rand(0, 1000) < $dazeRate0reel and $bonusReel[0] != 1) $makeStack[0] = 1;
					if (count($makeStack) < $dazeStacksThreshold) if (rand(0, 1000) < $dazeRate1reel and $bonusReel[1] != 1) $makeStack[1] = 1;
					if (count($makeStack) < $dazeStacksThreshold) if (rand(0, 1000) < $dazeRate2reel and $bonusReel[2] != 1) $makeStack[2] = 1;
					if (count($makeStack) < $dazeStacksThreshold) if (rand(0, 1000) < $dazeRate3reel and $bonusReel[3] != 1) $makeStack[3] = 1;
					if (count($makeStack) < $dazeStacksThreshold) if (rand(0, 1000) < $dazeRate4reel and $bonusReel[4] != 1) $makeStack[4] = 1;
					if (isset($makeStack)) {
						$lastAction = "daze";
						$symb_combs .= "Daze: " . $makeStack[0] . "|" . $makeStack[1] . "|" . $makeStack[2] . "|" . $makeStack[3] . "|" . $makeStack[4] . ";";
					}
					//echo "<br>".count($makeStack)."!!!".$dazeStacksThreshold."***";
				}
			}
		}
	}
	if ($lastAction == "freespin") {
		//$linkedNumRate=000;
		//echo "a=<br>$linkedNumRate $linkedPartRate<br>&";
		if (rand(0, 1000) < $linkedNumRate) //its 2 pairs linked wheels
		{
			for ($j = 0; $j < 4; $j++) {
				if (isset($symbols[1][$j])) $symbols[1][$j] = $symbols[0][$j];
				if (isset($symbols[3][$j])) $symbols[3][$j] = $symbols[2][$j];
			}
			$symb_combs .= "Link: both;";
			$output .= "linkedreels=0:1,2:3&";
		} else {
			if (rand(0, 1000) < $linkedPartRate) //left wheel link prob, else right
			{
				for ($j = 0; $j < 3; $j++)
					$symbols[1][$j] = $symbols[0][$j];
				$output .= "linkedreels=0:1&";
				$symb_combs .= "Link: left;";
			} else {
				for ($j = 0; $j < 4; $j++)
					$symbols[3][$j] = $symbols[2][$j];
				$output .= "linkedreels=2:3&";
				$symb_combs .= "Link: right;";
			}
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
		for ($j = 0; $j < 5; $j++) {
			if (isset($symbolsOverlayed[$i][$j]) and $symbolsOverlayed[$i][$j] == 0) {
				$output .= "rs.i0.r.i" . $i . ".attention.i0=" . $j . "&";
			}
			if ($symbols[$i][$j] == $overlaySym) {
				$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".with=SYM" . $overlaySym . "&";
				$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".row=" . $j . "&";
				$anim_num++;
			}
		}
		$anim_num = 0;
		$output .= "rs.i0.r.i" . $i . ".hold=false&";
		$lastRs .= "rs.i0.r.i" . $i . ".syms=SYM" . $symbolsOverlayed[$i][0] . ",SYM" . $symbolsOverlayed[$i][1] . ",SYM" . $symbolsOverlayed[$i][2];

		if (isset($symbolsOverlayed[$i][3]))
			$lastRs .= ",SYM" . $symbolsOverlayed[$i][3];
		if (isset($symbolsOverlayed[$i][4]))
			$lastRs .= ",SYM" . $symbolsOverlayed[$i][4];

		$lastRs .= "&";
	}

	if ($bonusSymbCount >= 2) {
		if ($bonusSymbCount < 3) {
			if ($nearWinReel == 1)		$output .= "rs.i0.nearwin=2,3,4&";
			elseif ($nearWinReel == 2)		$output .= "rs.i0.nearwin=3,4&";
			else		$output .= "rs.i0.nearwin=4&";
		} else {
			$anim_num = 0;
			for ($i = 0; $i < 5; $i++) {
				if ($bonusReel[$i] == 1) {
					$anim_num++;
					if ($anim_num == 2) {
						if ($i == 1)	$output .= "rs.i0.nearwin=2,3,4&";
						elseif ($i == 2)	$output .= "rs.i0.nearwin=3,4&";
						else		$output .= "rs.i0.nearwin=4&";
						break;
					}
				}
			}
		}
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
			$output .= "current.rs.i0=basic&";
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
		//	    $output.= "gamestate.current=basic&";
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
		$botAction = "initfreespin";
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




	$spincost = 0;
	if ($lastAction != 'respin' and $lastAction != 'freespin' and $lastAction != 'endfreespin') {
		$spin_to_history = 1;
		$spincost = $betDB * $denomDB * 0.25;
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


if ($lastAction == "freespin" or $lastAction == "startfreespin") {
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
