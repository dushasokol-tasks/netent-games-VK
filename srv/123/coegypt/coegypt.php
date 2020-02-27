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

	if (
		isset($lowbasket) and isset($mediumbasket) and isset($lowbasket)
		and isset($lbk) and isset($mbk) and isset($hbk)
		and isset($restoreAction)
	) {
	} else {
		$lbk = 0;
		$mbk = 0;
		$hbk = 0;
		$highbasket = $start_basket;
		$mediumbasket = $start_basket;
		$lowbasket = $start_basket;
		if (!isset($fs_played)) $fs_played = 0;
	}

	$output .= "bet.betlevel=1&";
	$output .= "bet.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19&";
	$output .= "bet.denomination=1&";
	$output .= "clientaction=initfreespin&";
	$output .= "current.rs.i0=freespin&";
	$output .= "freespin.counter=$fs_played&";
	$output .= "freespin.highbasket.coins=$highbasket&";
	$output .= "freespin.highbasket.keys=$hbk&";
	$output .= "freespin.lowbasket.coins=$lowbasket&";
	$output .= "freespin.lowbasket.keys=$lbk&";
	$output .= "freespin.mediumbasket.coins=$mediumbasket&";
	$output .= "freespin.mediumbasket.keys=$mbk&";
	$output .= "freespins.betlevel=1&";
	$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19&";
	$output .= "freespins.denomination=1.000&";
	$output .= "freespins.initial=10&";
	$output .= "freespins.left=10&";
	$output .= "freespins.multiplier=1&";
	$output .= "freespins.total=10&";
	$output .= "freespins.totalwin.cents=0&";
	$output .= "freespins.totalwin.coins=0&";
	$output .= "freespins.wavecount=1&";
	$output .= "freespins.win.cents=0&";
	$output .= "freespins.win.coins=0&";
	$output .= "gamestate.current=freespin&";
	$output .= "gamestate.history=basic&";
	$output .= "gamestate.stack=basic%2Cfreespin&";
	$output .= "next.rs=freespin&";
	$output .= "nextaction=freespin&";
	$output .= "rs.i0.id=freespin&";
	$output .= "rs.i0.r.i0.hold=false&";
	$output .= "rs.i0.r.i0.pos=0&";
	$output .= "rs.i0.r.i0.syms=SYM3%2CSYM8%2CSYM4&";
	$output .= "rs.i0.r.i1.hold=false&";
	$output .= "rs.i0.r.i1.pos=0&";
	$output .= "rs.i0.r.i1.syms=SYM10%2CSYM7%2CSYM11&";
	$output .= "rs.i0.r.i2.hold=false&";
	$output .= "rs.i0.r.i2.pos=0&";
	$output .= "rs.i0.r.i2.syms=SYM8%2CSYM5%2CSYM12&";
	$output .= "rs.i0.r.i3.hold=false&";
	$output .= "rs.i0.r.i3.pos=0&";
	$output .= "rs.i0.r.i3.syms=SYM6%2CSYM9%2CSYM7&";
	$output .= "rs.i0.r.i4.hold=false&";
	$output .= "rs.i0.r.i4.pos=0&";
	$output .= "rs.i0.r.i4.syms=SYM11%2CSYM4%2CSYM8&";
	$output .= "rs.i1.id=basic&";
	$output .= "rs.i1.r.i0.hold=false&";
	$output .= "rs.i1.r.i0.pos=40&";
	$output .= "rs.i1.r.i0.syms=SYM12%2CSYM10%2CSYM0&";
	$output .= "rs.i1.r.i1.hold=false&";
	$output .= "rs.i1.r.i1.pos=54&";
	$output .= "rs.i1.r.i1.syms=SYM7%2CSYM12%2CSYM7&";
	$output .= "rs.i1.r.i2.hold=false&";
	$output .= "rs.i1.r.i2.pos=32&";
	$output .= "rs.i1.r.i2.syms=SYM11%2CSYM0%2CSYM7&";
	$output .= "rs.i1.r.i3.hold=false&";
	$output .= "rs.i1.r.i3.pos=50&";
	$output .= "rs.i1.r.i3.syms=SYM8%2CSYM4%2CSYM9&";
	$output .= "rs.i1.r.i4.hold=false&";
	$output .= "rs.i1.r.i4.pos=38&";
	$output .= "rs.i1.r.i4.syms=SYM0%2CSYM11%2CSYM9&";

	$lastAction = "startfreespin";
	$botAction = "freespin";

	$table_locked = 1;
	$gameover = "false";
}

if ($_GET['action'] == "spin" or $_GET['action'] == "respin" or $_GET['action'] == "freespin") {

	$lastAction = "spin";
	if ($lastActionDB == "freespin" and $_GET['action'] == "freespin") $lastAction = "freespin";
	if ($lastActionDB == "startfreespin" and $_GET['action'] == "freespin") $lastAction = "freespin";

	////////////////////
	//symbol generation
	////////////////////
	$i = 0;

	if ($lastAction == "freespin") {
		$query = "SELECT * FROM ns.bonuses where payRate='" . $payRate . "' and gameId='" . $gameId . "' and (type=0 or type=1 or type=2 or type=3 or type=4 or type=5 or type=6 or type=7 or type=8 or type=9) order by type asc;";
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

	if ($_GET['action'] != 'freespin' and $lastActionDB != 'endfreespin') {
		//$symbols[0][0]=0;$symbols[1][0]=8;$symbols[2][0]=0;$symbols[3][0]=5;$symbols[4][0]=0;
		//$symbols[0][0]=7;$symbols[1][0]=8;$symbols[2][0]=9;//$symbols[3][0]=0;$symbols[4][0]=0;
		//$symbols[0][1]=1;$symbols[1][1]=1;$symbols[2][1]=1;$symbols[3][1]=1;$symbols[4][1]=9;
		//$symbols[0][2]=7;$symbols[1][2]=8;$symbols[2][2]=9;//$symbols[3][2]=4;$symbols[4][2]=4;

	} else {
		//$symbols[0][0]=11;$symbols[1][0]=5;$symbols[2][0]=5;
	}

	include('./integr/busters.php');

	$bonusSymbCount = 0;
	foreach ($symbols as $tReel => $t)
		foreach ($t as $tRow => $e) {
			if ($symbols[$tReel][$tRow] == 0) {
				$bonusSymbCount++;
				$bonusReels[$tReel] = 1;
			}
		}
	if ($bonusSymbCount > 2) {
		if ($lastAction == 'spin') {
			$lastAction = "initfreespin";
			$fs_initial = 10;
		}
	}

	///////////////////////////////////////
	$coin1Rate = $reel[5][0];
	$coin2Rate = $reel[5][1];
	$coin3Rate = $reel[5][2];

	$sym21Var = $reel[7][0];
	$sym22Var = $reel[7][1];
	$sym23Var = $reel[7][2];
	//////////////////////////////////////

	//    if($bonusSymbCount<3)
	{
		if ($lastAction == "spin" or $lastAction == "initfreespin") {
			if (rand(0, 1000) < $coin1Rate) {
				$length = (count($reel[6]) - 1);
				$pos = round(rand(0, $length));
				$coins[0][round(rand(0, 2))] = $reel[6][$pos] * $betDB * 20;
			}
			if (rand(0, 1000) < $coin2Rate) {
				$length = (count($reel[6]) - 1);
				$pos = round(rand(0, $length));
				$coins[1][round(rand(0, 2))] = $reel[6][$pos] * $betDB * 20;
			}
			if (rand(0, 1000) < $coin3Rate) {
				$length = (count($reel[6]) - 1);
				$pos = round(rand(0, $length));
				$coins[2][round(rand(0, 2))] = $reel[6][$pos] * $betDB * 20;
			}
		} else {
			if (rand(0, 1000) < $coin1Rate) {
				$length = (count($reel[6]) - 1);
				$pos = round(rand(0, $length));
				$coins[0][round(rand(0, 2))] = $reel[6][$pos] * $betDB * 20;
			}
			if (rand(0, 1000) < $coin2Rate) {
				$length = (count($reel[8]) - 1);
				$pos = round(rand(0, $length));
				$coins[1][round(rand(0, 2))] = $reel[8][$pos] * $betDB * 20;
			}
			if (rand(0, 1000) < $coin3Rate) {
				$length = (count($reel[9]) - 1);
				$pos = round(rand(0, $length));
				$coins[2][round(rand(0, 2))] = $reel[9][$pos] * $betDB * 20;
			}
		}
	}


	if ($coins[2] != '' or $coins[1] != '' or $coins[0] != '') {
		if ($lastAction == "spin") {
			if (rand(0, 1000) < $sym21Var) {
				$symbols[4][round(rand(0, 2))] = 20;
			}
		} elseif ($lastAction == "freespin") {
			if (rand(0, 1000) < $sym21Var) {
				$symbols[4][round(rand(0, 2))] = 21;
			} elseif (rand(0, 1000) < $sym22Var) {
				$symbols[4][round(rand(0, 2))] = 22;
			} elseif (rand(0, 1000) < $sym23Var) {
				$symbols[4][round(rand(0, 2))] = 23;
			}
		}
	}

	if ($lastAction != "startfreespin" and $lastAction != "bonusgame" and $lastAction != "coins")
		include($gamePath . 'lines.php');
	else $symb_combs .= " fake spin;";

	$overlaySym = 1;

	if ($lastAction == "freespin") $reelset = "freespin";

	//////////
	//draw rs
	//////////

	$wild = 0;
	$nearwin = 0;
	$anim_num = 0;
	$coin_overlays = 1;
	$nearwinstr = '';

	for ($i = 0; $i < 5; $i++) {
		for ($j = 0; $j < 3; $j++) {
			if (is_numeric($coins[$i][$j])) {
				$output .= "coins_overlays." . $coin_overlays . ".position.reel=" . $i . "&";
				$output .= "coins_overlays." . $coin_overlays . ".position.row=" . $j . "&";
				$output .= "coins_overlays." . $coin_overlays . ".value=" . $coins[$i][$j] . "&";
				$coin_overlays++;

				if ($lastAction == "freespin") {
					if ($i == 2) {
						$highbasket	+= $coins[$i][$j];
						$output .= "freespin.current.highbasket.coins=" . $coins[$i][$j] . "&";
						$output .= "freespin.current.highbasket.reel=" . $i . "&";
						$output .= "freespin.current.highbasket.row=" . $j . "&";
					} elseif ($i == 1) {
						$mediumbasket	+= $coins[$i][$j];
						$output .= "freespin.current.mediumbasket.coins=" . $coins[$i][$j] . "&";
						$output .= "freespin.current.mediumbasket.reel=" . $i . "&";
						$output .= "freespin.current.mediumbasket.row=" . $j . "&";
					} elseif ($i == 0) {
						$lowbasket	+= $coins[$i][$j];
						$output .= "freespin.current.lowbasket.coins=" . $coins[$i][$j] . "&";
						$output .= "freespin.current.lowbasket.reel=" . $i . "&";
						$output .= "freespin.current.lowbasket.row=" . $j . "&";
					}
				}
			}

			if ($lastAction == "freespin") { {
					if ($symbolsOverlayed[$i][$j] == 21)	    $lbk++;
					if ($symbolsOverlayed[$i][$j] == 22)	    $mbk++;
					if ($symbolsOverlayed[$i][$j] == 23)	    $hbk++;
				}
			}

			if (($nearwin < 2 or $lastAction == "initfreespin") and $symbolsOverlayed[$i][$j] == 0) {
				$output .= "rs.i0.r.i" . $i . ".attention.i" . $anim_num . "=" . $j . "&";
				$anim_num++;
			}
		}

		if ($bonusSymbCount > 1 and $nearwin > 1) {
			if ($nearwinstr == '') $nearwinstr = $i;
			else $nearwinstr .= "," . $i;
		}
		if ($bonusReels[$i] == 1) $nearwin++;

		$anim_num = 0;
		$output .= "rs.i0.r.i" . $i . ".hold=false&";
		$lastRs .= "rs.i0.r.i" . $i . ".syms=SYM" . $symbolsOverlayed[$i][0] . ",SYM" . $symbolsOverlayed[$i][1] . ",SYM" . $symbolsOverlayed[$i][2] . "&";
	}

	if ($lastAction != "freespin" and $nearwinstr != '')	$output .= "rs.i0.nearwin=" . $nearwinstr . "&";

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
			for ($j = 0; $j < 3; $j++) {
				if ($symbols[$i][$j] == 0) {
					$output .= "ws.i0.pos.i" . $anim_num . "=" . $i . "," . $j . "&";
					$anim_num++;
				}
			}
		}
		$anim_num = 1;
	} elseif ($lastAction == "coins_overlays") {
		if ($buster12 != '') {
			$symb_combs .= " bus12 on CO " . $coin_win . ";";
			$coin_win *= 2;
		}
		$output .= "ws.i0.betline=null&";
		$output .= "ws.i0.direction=none&";
		$output .= "ws.i0.pos.i0=" . $coin_pos . "&";
		$output .= "ws.i0.reelset=basic&";
		$output .= "ws.i0.sym=SYM20&";
		$output .= "ws.i0.types.i0.cents=" . ($coin_win * $denomDB) . "&";
		$output .= "ws.i0.types.i0.coins=" . $coin_win . "&";
		$output .= "ws.i0.types.i0.wintype=coins&";

		$total_win = $coin_win;
		$symb_combs .= " cw=$coin_win;";

		$anim_num = 1;
	}


	foreach ($win as $e => $v) {
		$tmp = explode("_", $v);
		$output .= "ws.i" . $anim_num . ".reelset=$reelset&";

		if ($lastAction != "addfreespin" and $lastAction != "freespin" and $lastAction != "endfreespin")
			if ($buster12 != '') {
				$symb_combs .= " bus12, " . $tmp[0] . "x2;";
				$tmp[0] *= 2;
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
		$output .= "freespin.lowbasket.coins=" . $lowbasket . "&";
		$output .= "freespin.lowbasket.keys=" . $lbk . "&";
		$output .= "freespin.mediumbasket.coins=" . $mediumbasket . "&";
		$output .= "freespin.mediumbasket.keys=" . $mbk . "&";
		$output .= "freespin.highbasket.coins=" . $highbasket . "&";
		$output .= "freespin.highbasket.keys=" . $hbk . "&";

		if (($hbk == 3 or $mbk == 3 or $lbk == 3) and $lastAction == "freespin") {
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

			if ($hbk == 3) {
				$total_win += $highbasket;
				$symb_combs = "hBask=" . $highbasket . ";" . $symb_combs;
			} elseif ($mbk == 3) {
				$total_win += $mediumbasket;
				$symb_combs = "mBask=" . $mediumbasket . ";" . $symb_combs;
			} elseif ($lbk == 3) {
				$total_win += $lowbasket;
				$symb_combs = "lBask=" . $lowbasket . ";" . $symb_combs;
			}

			$lastAction = 'endfreespin';
			$botAction = "spin";
			$wavecount = 0;
			$table_locked = 0;
		} else {
			$output .= "previous.rs.i0=freespin&"; //
			$output .= "current.rs.i0=freespin&"; //
			$output .= "next.rs=freespin&"; //
			$output .= "last.rs=freespin&"; //
			$output .= "rs.i0.id=freespin&"; //
			$output .= "gamestate.current=freespin&"; //
			$output .= "gamestate.stack=basic%2Cfreespin&"; //
			$output .= "gamestate.history=basic%2Cfreespin&"; //
			$output .= "clientaction=freespin&";
			$output .= "nextaction=freespin&"; //

			$gameover = 'false';
			$table_locked = 1;
			$botAction = "freespin";
		}

		$fs_total = $fs_left + $fs_played;
		$fs_totalwin += $total_win;

		$output .= "freespins.totalwin.coins=" . $fs_totalwin . "&";
		$output .= "freespins.totalwin.cents=" . $fs_totalwin . "&";
		$output .= "freespins.win.cents=" . $fs_totalwin . "&";
		$output .= "freespins.win.coins=" . $fs_totalwin . "&";

		$output .= "freespin.counter=$fs_played&";
		$output .= "freespins.betlevel=1&";
		$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19&";
		$output .= "freespins.denomination=1.000&";
		$output .= "freespins.initial=10&";
		$output .= "freespins.left=10&";
		$output .= "freespins.multiplier=1&";
		$output .= "freespins.total=10&";
		$output .= "freespins.wavecount=1&";

		$symb_combs .= "fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";";
	} elseif ($lastAction == "initfreespin") {
		$output .= "rs.i0.id=basic&";
		$output .= "current.rs.i0=freespin&"; //
		$output .= "last.rs=basic&";
		$output .= "next.rs=freespin&"; //
		$output .= "nextaction=freespin&"; //
		$output .= "clientaction=spin&"; //

		$output .= "gamestate.current=freespin&"; //
		$output .= "gamestate.stack=basic%2Cfreespin&"; //
		$output .= "gamestate.history=basic&"; //

		$output .= "freespins.betlevel=1&";
		$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19&";
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

		$reelset = "freespin";

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
	//echo "LADB=$lastActionDB&LA=$lastAction&mrs=$reelset&<br>&";

	$spincost = 0;
	if ($lastAction != 'respin' and $lastAction != 'freespin' and $lastAction != 'endfreespin') {
		$spin_to_history = 1;
		$spincost = $betDB * $linesDB * $denomDB * 0.01;
	}

	$credit /= 100;

	$real_win = $total_win * $denomDB * 0.01;

	if (isset($freeRoundsLeft)) $spincost = 0;
	if ($lastAction != 'respin' and $lastAction != 'freespin' and $lastAction != 'endfreespin' and $lastAction != 'addfreespin') {
		$credit -= $spincost;
	}

	$credit += $real_win;

	$creditDB = $credit * 100;

	$credit *= 100;

	if ($lastAction == 'endfreespin') $totalWinsDB = $fs_totalwin;
	else $totalWinsDB = $total_win;
}

if ($lastAction == "endfreespin") {
	$symb_combs .= "fs=" . $fs_left . ";";
}

if ($lastAction == "initfreespin") {
	$answ .= "fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";reelset=" . $reelset . ";start_basket=" . $coin_win . ";";
	$answ .= "highbasket=" . $highbasket . ";mediumbasket=" . $mediumbasket . ";lowbasket=" . $lowbasket . ";";
	$symb_combs .= "fs=" . $fs_left . ";";
}

if ($lastAction == "freespin" or $lastAction == "startfreespin") {
	$answ .= "fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";reelset=" . $reelset . ";start_basket=" . $start_basket . ";";
	$answ .= "highbasket=" . $highbasket . ";mediumbasket=" . $mediumbasket . ";lowbasket=" . $lowbasket . ";";
	$answ .= "hbk=" . $hbk . ";mbk=" . $mbk . ";lbk=" . $lbk . ";";
	$symb_combs .= "fs=" . $fs_left . ";";
}

////widget
if (isset($freeRoundsLeft) and $freeRoundsLeft > 0 and $lastAction != 'init' and $lastAction != 'paytable' and $lastAction != 'widgetspin') {
	if ($lastAction == 'spin' or $lastAction == 'initfreespin' or $lastAction = 'coins_overlays') {
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
