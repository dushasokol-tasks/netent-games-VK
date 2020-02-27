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
$buster7 = '';

////////////////////////////////////
//correct action check
////////////////////////////////////
if ($_GET['action'] == "freespin" and ($lastActionDB == "spin" or $lastActionDB == "respin" or $lastActionDB == "symbol_transform" or $lastActionDB == "symbol_overlay")) exit;
if ($_GET['action'] == "freespin" and $lastActionDB == "paytable" and $answer == '') exit;
if ($_GET['action'] == "freespin" and $lastActionDB == "init") exit;
if ($_GET['action'] == "freespin" and $lastActionDB != "freespin" and $lastActionDB != "startfreespin" and $lastActionDB != "paytable" and $lastActionDB != "lastrespin") exit;

if ($_GET['action'] == "bonusaction" and ($lastActionDB == "spin" or $lastActionDB == "respin" or $lastActionDB == "lastrespin" or $lastActionDB == "symbol_transform" or $lastActionDB == "symbol_overlay")) exit;
if ($_GET['action'] == "bonusaction" and $lastActionDB == "paytable" and $answer == '') exit;
if ($_GET['action'] == "bonusaction" and $lastActionDB == "init") exit;

if ($_GET['action'] == "bonusaction" and $lastActionDB != "bonusaction" and $lastActionDB != "bonusgame" and $lastActionDB != "paytable") exit;

if ($_GET['action'] == "bonus_feature_pick")
	if ($lastActionDB == "paytable" and $answer == '') exit;
	elseif ($lastActionDB != "bonus_feature_pick" and $lastActionDB != "paytable" and $lastActionDB != "fairy_pre_bonus") exit;


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


if ($_GET['action'] == "endbonus" and $lastActionDB == "endbonus") {
	$lastAction = "endbonus";
	$total_win = $bonus_totalwin;
	$total_winCents = $total_win * $denomDB;


	$credit /= 100;
	$real_win = $bonus_totalwin * $denomDB * 0.01;
	$credit += $real_win;
	$creditDB = $credit * 100;
	$credit *= 100;
	$symb_combs = "bonuswin=" . $bonus_totalwin . ";";

	$output = "rs.i0.nearwin=4&historybutton=false&current.rs.i0=basic&rs.i0.r.i4.hold=false&next.rs=basic&gamestate.history=basic%2Cbonus_feature_pick%2Cbonus&rs.i0.r.i1.syms=SYM10%2CSYM4%2CSYM13&rs.i0.r.i2.overlay.i0.pos=64&rs.i0.id=basic&gamestate.current=basic&rs.i0.r.i2.overlay.i0.row=2&rs.i0.r.i0.syms=SYM12%2CSYM8%2CSYM0&rs.i0.r.i3.syms=SYM32%2CSYM9%2CSYM11&rs.i0.r.i2.overlay.i0.with=SYM4&isJackpotWin=false&gamestate.stack=basic&rs.i0.r.i0.pos=111&rs.i0.r.i1.pos=50&rs.i0.r.i1.hold=false&clientaction=endbonus&rs.i0.r.i2.hold=false&rs.i0.r.i4.syms=SYM10%2CSYM12%2CSYM0&rs.i0.r.i2.pos=62&rs.i0.r.i3.overlay.i0.with=SYM4&rs.i0.r.i0.hold=false&mystery.sym=SYM4&rs.i0.r.i3.pos=22&rs.i0.r.i4.pos=30&rs.i0.r.i3.overlay.i0.row=0&rs.i0.r.i3.overlay.i0.pos=22&gamestate.bonusid=dwarves_bonus&nextaction=spin&nextactiontype=pickbonus&rs.i0.r.i2.syms=SYM12%2CSYM0%2CSYM32&rs.i0.r.i3.hold=false&";

	$botAction = "spin";
	$table_locked = 0;
}

if ($_GET['action'] == "bonusaction" and isset($pickaxes)) {
	if ($lastActionDB == "paytable" and isset($restoreAction)) {
		$lastActionDB = $restoreAction;
		$wildsDB = $wildStcks;
	}

	$query = "SELECT * FROM ns.bonuses where payRate=" . $payRate . " and gameId=" . $gameId . " and id=8;";

	$result = mysql_query($query);

	while ($reels = mysql_fetch_assoc($result)) {
		$reel[$reels['id']] = explode("_", $reels['symbols']);
	} {
		$input_id = $_GET['bonus_item_id'];
		$valInDB = "item" . $input_id;
		if (isset($$valInDB)) $pickaxes = 1;

		$length = (count($reel[8]) - 1);
		$pos = round(rand(0, $length));

		$total_win = $reel[8][$pos] * $betDB;
		$$valInDB = $total_win;

		$pickaxes--;

		$output .= "gamestate.bonusid=dwarves_bonus&";
		$output .= "gamestate.current=bonus&";
		$output .= "gamestate.stack=basic%2Cbonus&";
		$output .= "gamestate.history=basic%2Cbonus_feature_pick%2Cbonus&";

		$output .= "nextactiontype=pickbonus&";
		$output .= "clientaction=bonusaction&";

		if ($pickaxes == 0) {
			$output .= "nextaction=endbonus&";
			$output .= "bonusgameover=true&";

			$gameover = "false";
			$lastAction = "endbonus";
			$botAction = "endbonus";
		} else {
			$output .= "nextaction=bonusaction&";

			$lastAction = "bonusaction";
			$botAction = "bonusaction";
		}

		$j = 0;
		$k = 0;
		for ($i = 0; $i < 9; $i++) {
			$valInDB = "item" . $i;
			if (isset($$valInDB)) {
				$answ .= $valInDB . "=" . $$valInDB . ";";
				$output .= "picked_items.i" . $j . ".itemId=" . substr($valInDB, 4) . "&";
				$output .= "picked_items.i" . $j . ".itemValue=" . $$valInDB . "&";
				$j++;
			} elseif ($pickaxes == 0) {
				$pos = round(rand(0, $length));
				$output .= "ignored_items.i" . $k . "=" . ($reel[8][$pos] / 10) . "&";
				$k++;
			}
		}
		$bonus_totalwin += $total_win;

		$output .= "bonusgame.coinvalue=0.01&";
		$output .= "bonuswin.cents=" . $total_win . "&";
		$output .= "bonuswin.coins=" . $total_win . "&";
		$output .= "totalbonuswin.cents=" . $bonus_totalwin . "&";
		$output .= "totalbonuswin.coins=" . $bonus_totalwin . "&";

		$answ .= "pickaxes=$pickaxes;";
		$answ .= "bonus_totalwin=" . $bonus_totalwin . ";";

		$symb_combs .= "+ $total_win;";

		$table_locked = 1;
	}
}

if ($_GET['action'] == "bonus_feature_pick") {
	$query = "SELECT * FROM ns.reels where payRate=" . $payRate . " and gameId=" . $gameId . " order by id asc;";

	$result = mysql_query($query);

	while ($reels = mysql_fetch_assoc($result)) {
		$reel[$i] = explode("_", $reels['symbols']);
		$i++;
	}

	$length = (count($reel[9]) - 1);
	$pos = round(rand(0, $length));

	if ($reel[9][$pos] == 5) $bonustype = "coins";
	if ($reel[9][$pos] == 6) $bonustype = "fSpins";
	if ($reel[9][$pos] == 7) $bonustype = "bonusGame";

	include('./integr/busters.php');
	//	    if($buster10!='')$bonustype="fSpins";
	if ($buster7 != '') $bonustype = "bonusGame";


	// $bonustype="coins";
	// $bonustype="bonusGame";
	// $bonustype="fSpins";

	if ($bonustype == "bonusGame") {
		$output .= "gamestate.history=basic%2Cbonus_feature_pick&";
		$output .= "bonuswin.coins=0&";
		$output .= "nextaction=bonusaction&";
		$output .= "totalbonuswin.coins=0&";
		$output .= "bonusgame.coinvalue=0.01&";
		$output .= "gamestate.current=bonus&";
		$output .= "rs.i0.id=basic&";
		$output .= "nextactiontype=pickbonus&";
		$output .= "bonuswin.cents=0&";
		$output .= "clientaction=bonus_feature_pick&";
		$output .= "gamestate.bonusid=dwarves_bonus&";
		$output .= "gamestate.stack=basic%2Cbonus&";
		$output .= "totalbonuswin.cents=0&";

		$query = "SELECT * FROM ns.bonuses where payRate=" . $payRate . " and gameId=" . $gameId . " and id=9;";
		$result = mysql_query($query);
		$reels = mysql_fetch_assoc($result);
		$reel[9] = explode("_", $reels['symbols']);

		$length = (count($reel[9]) - 1);
		$pos = round(rand(0, $length));
		$pickaxes = $reel[9][$pos];

		$symb_combs .= "ps $pickaxes;";

		$lastAction = "bonusgame";
		$botAction = "bonusaction";
		$table_locked = 1;

		$answ .= "type=start;bonus_totalwin=0;pickaxes=$pickaxes;";
	}

	if ($bonustype == "fSpins") {
		$addedFS = 10;
		if ($buster10 != '') $addedFS *= 2;
		$answ .= "fs_left=$addedFS;fs_played=0;fs_totalwin=0;";

		$output .= "rs.i0.id=basic&";
		$output .= "rs.i1.id=freespin&";
		$output .= "current.rs.i0=freespin&";
		$output .= "next.rs=freespin&";

		$output .= "clientaction=bonus_feature_pick&";
		$output .= "nextaction=freespin&";

		$output .= "gamestate.current=freespin&";
		$output .= "gamestate.stack=basic%2Cfreespin&";
		$output .= "gamestate.history=basic%2Cbonus_feature_pick&";

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

		$output .= "rs.i0.r.i0.syms=SYM32%2CSYM8%2CSYM0&";
		$output .= "rs.i0.r.i1.syms=SYM4%2CSYM9%2CSYM11&";
		$output .= "rs.i0.r.i2.syms=SYM12%2CSYM0%2CSYM12&";
		$output .= "rs.i0.r.i3.syms=SYM3%2CSYM11%2CSYM9&";
		$output .= "rs.i0.r.i4.syms=SYM0%2CSYM11%2CSYM8&";

		$output .= "rs.i1.r.i0.syms=SYM3%2CSYM3%2CSYM8&";
		$output .= "rs.i1.r.i2.syms=SYM3%2CSYM3%2CSYM12&";
		$output .= "rs.i1.r.i1.syms=SYM3%2CSYM3%2CSYM9&";
		$output .= "rs.i1.r.i3.syms=SYM3%2CSYM3%2CSYM8&";
		$output .= "rs.i1.r.i4.syms=SYM3%2CSYM3%2CSYM12&";

		$output .= "freespins.initial=$addedFS&";
		$output .= "freespins.left=$addedFS&";
		$output .= "freespins.total=0&";

		$output .= "freespins.denomination=1.000&";
		$output .= "freespins.betlevel=1&";
		$output .= "freespins.betlines=0&";
		$output .= "freespins.wavecount=1&";
		$output .= "freespins.multiplier=1&";

		$output .= "freespins.win.coins=0&";
		$output .= "freespins.win.cents=0&";

		$output .= "freespins.totalwin.coins=0&";
		$output .= "freespins.totalwin.cents=0";

		$gameover = 'false';

		$lastAction = "startfreespin";
		$botAction = "freespin";
		$table_locked = 1;
	}

	if ($bonustype == "coins") {
		$result = mysql_query("SELECT * FROM ns.bonuses where payRate=" . $payRate . " and gameId=" . $gameId . " and type=5;");
		$reels = mysql_fetch_assoc($result);
		$reel = explode("_", $reels['symbols']);
		$length = (count($reel) - 1);
		$pos = round(rand(0, $length));
		$coinWin = $reel[$pos] * $betDB * 10;

		$total_win = $coinWin;

		$output .= "next.rs=basic&";
		$output .= "gamestate.history=basic%2Cbonus_feature_pick&";
		$output .= "nextaction=spin&";
		$output .= "last.rs=basic&";
		$output .= "gamestate.current=basic&";
		$output .= "current.rs.i0=basic&";
		$output .= "rs.i0.id=basic&";

		$output .= "feature.coin_win.amount=" . $coinWin . "&";

		$output .= "clientaction=bonus_feature_pick&";
		$output .= "previous.rs.i0=basic&";
		$output .= "gamestate.stack=basic&";

		$credit /= 100;
		$real_win = $total_win * $denomDB * 0.01;
		$total_winCents = $total_win * $denomDB;
		$credit += $real_win;
		$creditDB = $credit * 100;
		$credit *= 100;

		$lastAction = "coins";
		$botAction = "spin";
		$table_locked = 0;
	}

	$output .= $lastRsDB;
	$lastRs = $lastRsDB;
}


if ($_GET['action'] == "spin" or $_GET['action'] == "respin" or $_GET['action'] == "freespin") {

	$lastAction = "spin";
	if ($lastActionDB == "paytable" and isset($restoreAction)) {
		$lastActionDB = $restoreAction;
	}

	if ($lastActionDB == "freespin" and $_GET['action'] == "freespin" and isset($fs_left)) $lastAction = "freespin";
	if ($lastActionDB == "startfreespin" and $_GET['action'] == "freespin") $lastAction = "freespin";
	if ($lastActionDB == "lastrespin" and $_GET['action'] == "freespin" and $fs_left > 0) $lastAction = "freespin";
	if ($lastActionDB == "mirrorFS" and $_GET['action'] == "respin" and $fs_left > 0) $lastAction = "freespin";

	if ($lastActionDB == "mirror" and $_GET['action'] == "respin") $lastAction = "respin";
	if ($lastActionDB == "mirror2" and $_GET['action'] == "respin") $lastAction = "respin";
	if ($lastActionDB == "mirrorFS" and $_GET['action'] == "respin") $lastAction = "respin";
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
		} elseif ($pos == ($length - 1)) {
			$symbols[$i][1] = $reel[$i][$length];
			$symbols[$i][2] = $reel[$i][0];
		} else {
			$symbols[$i][1] = $reel[$i][$pos + 1];
			$symbols[$i][2] = $reel[$i][$pos + 2];
		}
	}

	/*
if(!isset($fs_left))
{

$symbols[0][0]=0;$symbols[0][1]=8;$symbols[0][2]=6;
$symbols[1][0]=9;$symbols[1][1]=4;$symbols[1][2]=7;
$symbols[2][0]=0;$symbols[2][1]=12;$symbols[2][2]=7;
$symbols[3][0]=10;$symbols[3][1]=12;$symbols[3][2]=4;
$symbols[4][0]=10;$symbols[4][1]=0;$symbols[4][2]=11;

}
else
{
//$symbols[0][0]=4;$symbols[0][1]=4;$symbols[0][2]=6;
}
*/
	include('./integr/busters.php');

	$has3symb = 0;
	$has4symb = 0;
	$has5symb = 0;
	$has6symb = 0;
	$has7symb = 0;

	$bonusSymbCount = 0;
	$wildsSymbCount = 0;
	foreach ($symbols as $tReel => $t)
		foreach ($t as $tRow => $e) {
			if ($symbols[$tReel][$tRow] == 0) {
				$bonusSymbCount++;
				$bonusReels[$tReel] = 1;
			}
			if ($symbols[$tReel][$tRow] == 3) $has3symb = 1;
			if ($symbols[$tReel][$tRow] == 4) $has4symb = 1;
			if ($symbols[$tReel][$tRow] == 5) $has5symb = 1;
			if ($symbols[$tReel][$tRow] == 6) $has6symb = 1;
			if ($symbols[$tReel][$tRow] == 7) $has7symb = 1;
		}

	///////////////////////////////////////
	$fairyPreBonusRate = $reel[5][0];
	$string4Var = $reel[5][1];
	$string5Var = $reel[5][2];
	$mirror1Rate = $reel[6][0];
	$mirror2Rate = $reel[6][1];
	$symbTransformRate = $reel[6][2];
	$symbolOverlayRate = $reel[6][3];
	//////////////////////////////////////
	if ($_GET['action'] == "spin") {
		if ($bonusSymbCount < 3 and $lastAction == "spin") {
			if ($lastActionDB == "spin") {
				if (rand(0, 1000) < $mirror1Rate) {
					$lastAction = "mirror";
				}
			}
			if ($lastActionDB == "spin" and $lastAction != "mirror" and $bonusSymbCount == 0) {
				if (($has3symb + $has4symb + $has5symb + $has6symb + $has7symb) > 2)
					if (rand(0, 1000) < $symbTransformRate) {
						$lastAction = "symbol_transform";
					}
			}

			if ($lastAction != "mirror" and $lastAction != "symbol_transform" and $bonusSymbCount == 0) {
				if (rand(0, 1000) < $symbolOverlayRate) {
					$lastAction = "symbol_overlay";
				}
			}

			if ($lastAction != "mirror" and $lastAction != "symbol_transform" and $lastAction != "symbol_overlay") {
				if (rand(0, 1000) < $mirror2Rate) {
					$lastAction = "mirror2";
				}
			}
		}
	} elseif ($lastAction == "freespin") {
		if (rand(0, 1000) < $mirror1Rate) {
			$lastAction = "mirrorFS";
		}
	}

	if ($lastAction == "symbol_overlay") {
		$length = (count($reel[8]) - 1);
		$pos = round(rand(0, $length));
		$overlaySym = $reel[8][$pos];
		//		$overlaySym=round(rand(4,7));//reelDB???
		$wilds = '';

		$overlaySymbsCount = 0;
		$baseX = round(rand(1, 3));
		$k = 0;
		for ($i = ($baseX - 1); $i <= ($baseX + 1); $i++) {
			for ($j = 0; $j < 3; $j++) {
				if ($overlaySymbsCount < 5) $overlayVariar = 1000;
				elseif ($overlaySymbsCount == 5) $overlayVariar = $reel[7][0];
				elseif ($overlaySymbsCount == 6) $overlayVariar = $reel[7][1];

				if ($overlaySymbsCount < 7)
					if (rand(0, 1000) < $overlayVariar) {
						$mapSymb[$i][$j] = $overlaySym;
						$symbols[$i][$j] = $overlaySym;
						$overlaySymbsCount++;
					}
				$k++;
			}
		}
		for ($j = 0; $j < $overlaySymbsCount; $j++) {
			$mapsMixed[$j] = $j;
		}
		shuffle($mapsMixed);
	}

	if ($lastAction == "symbol_transform") {
		$preSymbols = $symbols;
		$hasSym = 0;
		for ($i = 0; $i < 3; $i++) {
			for ($j = 0; $j < 5; $j++) {
				$transform[$j][$i] = -1;

				if ($symbols[$j][$i] == 4 or $symbols[$j][$i] == 5 or $symbols[$j][$i] == 6 or $symbols[$j][$i] == 7) {
					$x = $j;
					$y = $i;
					$hasSym = 1;
				}
			}
		}
		if ($hasSym == 0) ////////////////////noneed!!!
		{
			$x = 2;
			$y = 1;
			$symbols[$x][$y] = round(rand(4, 7));
		}

		$symbolsOverlayed = $symbols;

		$overlaySym = $symbols[$x][$y];

		$steps = 1;

		for ($i = 0; $i < 5; $i++)
			for ($j = 0; $j < 3; $j++)
				for ($k = 8; $k < 14; $k++) {
					if ($symbols[$i][$j] == $k) {
						$ax[$k] = $i;
						$ay[$k] = $j;
						$acou[$k]++;
					}
				}

		foreach ($acou as $e => $v) {
			if ($v > 3) {
				if ($v == 4) {
					if (rand(0, 1000) > $string4Var)
						unset($ax[$e]);
				} elseif ($v == 5) {
					if (rand(0, 1000) > $string5Var)
						unset($ax[$e]);
				} else unset($ax[$e]);
			}
		}

		foreach ($ax as $e => $v) {
			$a1x[$steps] = $ax[$e];
			$a1y[$steps] = $ay[$e];
			$steps++;
		}
		if ($steps > 2) $steps = round(rand(3, $steps));

		for ($i = 0; $i < $steps; $i++) {
			$ok = 0;
			$c = 0;
			do {
				if ($i > 0) {
					$x = $a1x[$i];
					$y = $a1y[$i];
				}
				if ($transform[$x][$y] == -1) {
					$transform[$x][$y] = $i;
					for ($k = 0; $k < 3; $k++) {
						for ($j = 0; $j < 5; $j++) {
							if ($symbols[$j][$k] == $symbols[$x][$y]) {
								$transform[$j][$k] = $i;
							}
						}
					}
					$ok = 1;
				}
			} while ($ok == 0);

			if ($i > 0) $output .= "feature.symbol_transform.steps.i" . ($i - 1) . ".id=" . ($i - 1) . "&";
		}
		for ($j = 0; $j < $steps; $j++) {
			$i = 0;
			foreach ($transform as $v => $e)
				foreach ($e as $v1 => $e1)
					if ($transform[$v][$v1] != -1) {
						if ($e1 == 0 and $j == 0) {
							$output .= "feature.symbol_transform.targets.i" . $i . ".x=" . $v . "&"; //short ani
							$output .= "feature.symbol_transform.targets.i" . $i . ".y=" . $v1 . "&";
							$i++;
						} elseif ($e1 == $j) {
							$output .= "feature.symbol_transform.steps.i" . ($j - 1) . ".pos.i" . $i . ".x=" . $v . "&";
							$output .= "feature.symbol_transform.steps.i" . ($j - 1) . ".pos.i" . $i . ".y=" . $v1 . "&";
							$i++;
						}
						if ($j == 0) if ($transform[$v][$v1] != -1) $symbols[$v][$v1] = $overlaySym;
					}
		}
	}

	if ($bonusSymbCount > 2 and $lastAction != "freespin") $lastAction = "bonus_feature_pick";

	if ($lastAction != "startfreespin" and $lastAction != "bonusgame" and $lastAction != "coins")
		include($gamePath . 'lines.php');
	else $symb_combs .= " fake spin;";

	if ($lastAction == "symbol_transform") {
		$delta = $total_win - ($betDB * 2500);
		//	echo "tw = $total_win; bet= $betDB; delta=".$delta."<br>";
		if ($total_win > 0 and $delta > 0) {

			$symbols = $preSymbols;
			$lastAction = 'spin';
			$total_win = 0;
			$total_winCents = 0;
			unset($win);
			$output = '';
			$symb_combs = "reject ST; ";
			include($gamePath . 'lines.php');
		}
	}


	if ($lastAction == "spin" and $bonusReels[0] == 1 and $bonusReels[2] == 1 and $total_win == 0) {
		$output .= "rs.i0.nearwin=4&";
		if ($bonusSymbCount == 2) {
			if (rand(0, 1000) < $fairyPreBonusRate) {
				$lastAction = "fairy_pre_bonus";
				$extraChest = round(rand(0, 2));
				$symbols[4][$extraChest] = 0;
			}
		}
	}

	if (isset($overlaySym)) {
		$output .= "mystery.sym=SYM" . $overlaySym . "&";
		if ($lastAction == "respin" or $lastAction == "lastrespin" or $lastAction == "mirror" or $lastAction == "mirror2" or $lastAction == "mirrorFS")
			$output .= "mirror_respin.target_sym=SYM" . $overlaySym . "&";
	}
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
			for ($j = 0; $j < 3; $j++) {
				if ($lastAction == "mirror") {
					if ($symbolsOverlayed[$i][$j] == 2) {
						$output .= "mirror_respin.overlay.i" . $anim_num . ".row=" . $j . "&";
						$output .= "mirror_respin.overlay.i" . $anim_num . ".r=" . $i . "&";
						$wilds .= "$i,$j" . "_";
						$anim_num++;
					}
					if ($symbolsOverlayed[$i][$j] == $overlaySym) {
						$output .= "rs.i0.r.i" . $i . ".overlay.i0.with=SYM" . $overlaySym . "&";
						$output .= "rs.i0.r.i" . $i . ".overlay.i0.row=" . $j . "&";
						$output .= "mirror_respin.overlay.i" . $anim_num . ".row=" . $j . "&";
						$output .= "mirror_respin.overlay.i" . $anim_num . ".r=" . $i . "&";
						$wilds .= "$i,$j" . "_";
						$anim_num++;
					}
				}

				if ($lastAction == "mirrorFS") {
					if ($symbolsOverlayed[$i][$j] == 2) {
						$output .= "mirror_respin.overlay.i" . $anim_num . ".row=" . $j . "&";
						$output .= "mirror_respin.overlay.i" . $anim_num . ".r=" . $i . "&";
						$wilds .= "$i,$j" . "_";
						$anim_num++;
					}
					if ($symbolsOverlayed[$i][$j] == $overlaySym) {
						$output .= "rs.i0.r.i" . $i . ".overlay.i0.with=SYM" . $overlaySym . "&";
						$output .= "rs.i0.r.i" . $i . ".overlay.i0.row=" . $j . "&";
						$output .= "mirror_respin.overlay.i" . $anim_num . ".row=" . $j . "&";
						$output .= "mirror_respin.overlay.i" . $anim_num . ".r=" . $i . "&";
						$wilds .= "$i,$j" . "_";
						$anim_num++;
					}
				}

				if ($lastAction == "mirror2" and $symbols[$i][$j] == 2) {
					$output .= "mirror_respin.overlay.i0.row=" . $j . "&";
					$output .= "mirror_respin.overlay.i0.r=" . $i . "&";
					$output .= "rs.i0.r.i" . $i . ".overlay.i0.with=SYM2&";
					$output .= "rs.i0.r.i" . $i . ".overlay.i0.row=" . $j . "&";
					$output .= "rs.i0.r.i2.overlay.i1.with=SYM" . $symbols[2][0] . "&";
					$output .= "rs.i0.r.i2.overlay.i1.row=0&";
					$output .= "rs.i0.r.i2.overlay.i2.with=SYM" . $symbols[2][2] . "&";
					$output .= "rs.i0.r.i2.overlay.i2.row=2&";
					$output .= "random_feature=random_mirror&";
					$wilds .= "$i,$j" . "_";
				}
				if ($lastAction == "respin" or $lastAction == "lastrespin") {
					if ($symbolsOverlayed[$i][$j] == $overlaySym) {
						$output .= "rs.i0.r.i" . $i . ".overlay.i0.with=SYM" . $overlaySym . "&";
						$output .= "rs.i0.r.i" . $i . ".overlay.i0.row=" . $j . "&";
						$output .= "mirror_respin.overlay.i" . $anim_num . ".row=" . $j . "&";
						$output .= "mirror_respin.overlay.i" . $anim_num . ".r=" . $i . "&";
						$anim_num++;
					}
				}

				if ($lastAction == "symbol_transform") {
					if ($symbols[$i][$j] == $overlaySym) {
						$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".with=SYM" . $overlaySym . "&";
						$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".row=" . $j . "&";
						$anim_num++;
					}
				}

				if ($lastAction == "symbol_overlay") {
					if ($symbols[$i][$j] == $overlaySym) {
						$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".with=SYM" . $overlaySym . "&";
						$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".row=" . $j . "&";
						$anim_num++;
					}
					if ($symbolsOverlayed[$i][$j] == $mapSymb[$i][$j]) {
						$mapRes[$mapsMixed[$map]] = "blob.overlay.i" . $mapsMixed[$map] . ".row=" . $j . "&blob.overlay.i" . $mapsMixed[$map] . ".r=" . $i . "&";
						$map++;
					}
				}
			}
			if ($lastAction == "symbol_transform")		$anim_num = 0;
		}

		$output .= "rs.i0.r.i" . $i . ".hold=false&";
		$lastRs .= "rs.i0.r.i" . $i . ".syms=SYM" . $symbolsOverlayed[$i][0] . ",SYM" . $symbolsOverlayed[$i][1] . ",SYM" . $symbolsOverlayed[$i][2] . "&";
	}

	if ($lastAction == "fairy_pre_bonus") {
		$output .= "rs.i0.r.i4.overlay.i0.with=SYM0&";
		$output .= "rs.i0.r.i4.overlay.i0.row=" . $extraChest . "&";
	}

	$output .= $lastRs;

	shuffle($mapRes);
	for ($i = 0; $i < $map; $i++) {
		$output .= $mapRes[$mapsMixed[$i]];
	}


	/////////////////////////////
	//draw ws			
	///////////////////////////
	$anim_num = 0;
	$total_win = 0;

	if ($lastAction == "bonus_feature_pick" or $lastAction == "fairy_pre_bonus") {
		$output .= "ws.i0.reelset=basic&";
		$output .= "ws.i0.direction=none&";
		$output .= "ws.i0.betline=null&";
		$output .= "ws.i0.sym=SYM0&";
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

		if ($lastAction == "lastrespin") {
			if (isset($fs_left)) $output .= "ws.i" . $anim_num . ".reelset=respin_first_b&";
			else
				$output .= "ws.i" . $anim_num . ".reelset=respin_end&";
		} elseif ($lastAction == "symbol_transform") $output .= "ws.i" . $anim_num . ".reelset=symbol_transform&";
		elseif ($lastAction != "freespin") $output .= "ws.i" . $anim_num . ".reelset=basic&";

		else $output .= "ws.i" . $anim_num . ".reelset=freespin&";

		if ($buster12 != '')
			if (
				$lastAction == "symbol_transform" or $lastAction == "symbol_overlay" or $lastAction == "spin" or
				$lastAction == "mirror" or $lastAction == "mirror2" or $lastAction == "bonus_feature_pick" or $lastAction == "fairy_pre_bonus"
			)
				$tmp[0] *= 2;

		$right_coins = $tmp[0] * $denomDB;

		$output .= "ws.i" . $anim_num . ".sym=SYM" . $symbOverlays[$e] . "&";

		$output .= "ws.i" . $anim_num . ".direction=left_to_right&";
		$output .= "ws.i" . $anim_num . ".betline=0&";
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


	if ($lastAction == "freespin" or $lastAction == "mirrorFS") {
		$fs_total = $fs_left + $fs_played;
		$fs_totalwin += $total_win;
		$table_locked = 1;

		if ($fs_left == 0 and $lastAction == "freespin") {
			$output .= "gamestate.current=basic&";
			$output .= "nextaction=spin&";
			$output .= "gamestate.stack=basic&";
			$output .= "next.rs=basic&";
			$lastAction = "endfreespin";



			$output .= "rs.i0.id=basic&";
			$output .= "current.rs.i0=basic&";
			$output .= "next.rs=basic&";
			$output .= "previous.rs.i0=basic&";
			$output .= "last.rs=basic&";
			$output .= "clientaction=spin&";
			$output .= "gamestate.stack=basic&";
			$output .= "gamestate.history=basic&";

			$botAction = "spin";
			$table_locked = 0;
		} else {
			$output .= "rs.i0.id=freespin&";

			if ($lastAction == "mirrorFS") {
				$output .= "current.rs.i0=respin_normal&";
				$output .= "next.rs=respin_normal&";
				$output .= "nextaction=respin&";

				$botAction = "respin";
			} else {
				$output .= "current.rs.i0=freespin&";
				$output .= "next.rs=freespin&";
				$output .= "nextaction=freespin&";

				$botAction = "freespin";
			}

			$output .= "last.rs=freespin&";
			$output .= "previous.rs.i0=freespin&";
			$output .= "clientaction=freespin&";

			$output .= "gamestate.current=freespin&";
			$output .= "gamestate.stack=basic%2Cfreespin&";
			$output .= "gamestate.history=basic%2Cbonus_feature_pick%2Cfreespin&";

			$table_locked = 1;
			$gameover = 'false';
		}

		$output .= "freespins.total=" . $fs_total . "&";
		$output .= "freespins.left=" . $fs_left . "&";
		$output .= "freespins.played=" . $fs_played . "&";
		$output .= "freespins.totalwin.coins=" . $fs_totalwin . "&";
		$output .= "freespins.totalwin.cents=" . $fs_totalwin . "&";
		$output .= "freespins.win.cents=" . $fs_totalwin . "&";
		$output .= "freespins.win.coins=" . $fs_totalwin . "&";

		$symb_combs .= "fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";";
	} elseif ($lastAction == "symbol_transform") {
		$output .= "rs.i0.id=symbol_transform&";
		$output .= "current.rs.i0=basic&";
		$output .= "next.rs=basic&";
		$output .= "random_feature=symbol_transform&";
		$output .= "symbol_transform.sym=SYM" . $overlaySym . "&";

		$output .= "clientaction=spin&";
		$output .= "nextaction=spin&";

		$output .= "gamestate.current=basic&";
		$output .= "gamestate.stack=basic&";
		$output .= "gamestate.history=basic&";

		$botAction = "spin";
		$table_locked = 0;
	} elseif ($lastAction == "symbol_overlay") {
		$output .= "rs.i0.id=symbol_transform&";
		$output .= "current.rs.i0=basic&";
		$output .= "next.rs=basic&";
		$output .= "random_feature=blob&";
		$output .= "blob.sym=SYM" . $overlaySym . "&";

		$output .= "clientaction=spin&";
		$output .= "nextaction=spin&";

		$output .= "gamestate.current=basic&";
		$output .= "gamestate.stack=basic&";
		$output .= "gamestate.history=basic&";

		$botAction = "spin";
		$table_locked = 0;
	} elseif ($lastAction == "bonus_feature_pick" or $lastAction == "fairy_pre_bonus") {
		$gameover = "false";
		$output .= "gamestate.current=bonus_feature_pick&";
		$output .= "clientaction=spin&";
		$output .= "nextaction=bonus_feature_pick&";
		$output .= "gamestate.stack=basic%2Cbonus_feature_pick&";
		$output .= "gamestate.history=basic&";

		$_Events['1301'] = 1;
		$botAction = "bonus_feature_pick";
		$table_locked = 1;
	} elseif ($lastAction == "lastrespin") {
		if (isset($fs_left)) {
			$table_locked = 1;
			$fs_totalwin += $total_win;
			if ($fs_left < 1) {
				$output .= "gamestate.current=basic&";
				$output .= "nextaction=spin&";
				$output .= "gamestate.stack=basic&";
				$output .= "next.rs=basic&";

				$symb_combs .= "fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";";

				$output .= "rs.i0.id=basic&";
				$output .= "current.rs.i0=basic&";
				$output .= "next.rs=basic&";
				$output .= "previous.rs.i0=basic&";
				$output .= "last.rs=basic&";
				$output .= "clientaction=spin&";
				$output .= "gamestate.stack=basic&";
				$output .= "gamestate.history=basic&";


				$lastAction = "endfreespin";
				$table_locked = 0;
				$botAction = "spin";
			}
			$output .= "current.rs.i0=freespin&";
			if ($fs_left > 0) {
				$output .= "next.rs=freespin&";
				$output .= "nextaction=freespin&";
				$output .= "gamestate.current=freespin&";
				$output .= "rs.i0.id=respin_first_b&";
			}
			$output .= "freespins.total=" . $fs_total . "&";
			$output .= "freespins.left=" . $fs_left . "&";
			$output .= "freespins.played=" . $fs_played . "&";
			$output .= "freespins.totalwin.coins=" . $fs_totalwin . "&";
			$output .= "freespins.totalwin.cents=" . $fs_totalwin . "&";
			$output .= "freespins.win.cents=" . $fs_totalwin . "&";
			$output .= "freespins.win.coins=" . $fs_totalwin . "&";

			$table_locked = 1;
			$botAction = "freespin";
		} else {
			$output .= "gamestate.current=basic&";
			$output .= "rs.i0.id=respin_end&";
			$output .= "current.rs.i0=basic&";
			$output .= "next.rs=basic&";
			$output .= "nextaction=spin&";

			$table_locked = 0;
			$botAction = "spin";
		}

		$output .= "previous.rs.i0=respin_normal&";
		$output .= "last.rs=respin_normal&";
		$output .= "clientaction=respin&";

		$output .= "gamestate.stack=basic&";
		$output .= "gamestate.history=basic&";
	} elseif ($lastAction == "respin") {
		if ($lastActionDB == "mirror" or $lastActionDB == "mirror2")	$output .= "rs.i0.id=respin_first_a&";
		else 	$output .= "rs.i0.id=respin_normal&";

		if (isset($fs_left)) {
			$output .= "freespins.total=" . $fs_total . "&";
			$output .= "freespins.left=" . $fs_left . "&";
			$output .= "freespins.played=" . $fs_played . "&";
			$output .= "freespins.totalwin.coins=" . $fs_totalwin . "&";
			$output .= "freespins.totalwin.cents=" . $fs_totalwin . "&";
			$output .= "freespins.win.cents=" . $fs_totalwin . "&";
			$output .= "freespins.win.coins=" . $fs_totalwin . "&";
			$output .= "gamestate.current=freespin&";
		} else $output .= "gamestate.current=basic&";

		$output .= "current.rs.i0=respin_normal&";
		$output .= "previous.rs.i0=respin_normal&";

		$output .= "next.rs=respin_normal&";
		$output .= "last.rs=respin_normal&";

		$output .= "clientaction=respin&";
		$output .= "nextaction=respin&";


		$output .= "gamestate.stack=basic&";
		$output .= "gamestate.history=basic&";

		$botAction = "respin";
		$gameover = "false";
		$table_locked = 1;
	} elseif ($lastAction == "mirror" or $lastAction == "mirror2") {
		$gameover = "false";
		$output .= "rs.i0.id=basic&";
		$output .= "current.rs.i0=respin_normal&";
		$output .= "next.rs=respin_normal&";

		$output .= "clientaction=spin&";
		$output .= "nextaction=respin&";

		$output .= "gamestate.current=basic&";
		$output .= "gamestate.stack=basic&";
		$output .= "gamestate.history=basic&";

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
	//echo "LADB=$lastActionDB&LA=$lastAction&";

	$spincost = 0;
	if ($lastAction != 'mirror' and $lastAction != 'mirror2' and $lastAction != 'mirrorFS' and $lastAction != 'respin' and $lastAction != 'freespin' and $lastAction != 'endfreespin') {
		$spin_to_history = 1;
		$spincost = $betDB * $denomDB * 0.1;
	}
	if ($lastAction == 'lastrespin' and isset($fs_left)) {
		$spin_to_history = 0;
		$spincost = 0;
	}

	$credit /= 100;

	$real_win = $total_win * $denomDB * 0.01;

	if (isset($freeRoundsLeft)) $spincost = 0;
	if ($lastAction != 'mirror' and $lastAction != 'mirror2' and $lastAction != 'mirrorFS' and $lastAction != 'respin' and $lastAction != 'freespin' and $lastAction != 'endfreespin') {
		$credit -= $spincost;
	}

	$credit += $real_win;

	$creditDB = $credit * 100;

	$credit *= 100;

	if ($lastAction == 'freespin') {
		$wilds = $wildsDB;
		$dop2 .= "(" . $wildsDB . ")";
	}

	if ($lastAction == 'mirrorFS' or $lastAction == 'freespin' or $lastAction == 'endfreespin') $totalWinsDB = $fs_totalwin;
	elseif ($lastAction == 'respin' and isset($fs_left)) $totalWinsDB = $fs_totalwin;
	elseif ($lastAction == 'lastrespin' and isset($fs_left)) $totalWinsDB = $fs_totalwin;
	elseif ($lastAction != 'respin' and $lastAction != 'mirror' and $lastAction != 'mirror2') $totalWinsDB = $total_win;
}

if ($lastAction == "mirror" or $lastAction == "mirror2") {
	$answ .= "overlaySym=$overlaySym;wavecount=" . ($wavecount + 1) . ";";
	$symb_combs .= "overlaySym=$overlaySym;";
}


if ($lastAction == "freespin") {
	$answ .= "fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";" . $answFS;
}
if ($lastAction == "mirrorFS") {
	$answ .= "overlaySym=$overlaySym;wavecount=" . ($wavecount + 1) . ";";
	$answ .= "fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";" . $answFS;
	$symb_combs .= "overlaySym=$overlaySym;";
}

if ($lastAction == "respin") {
	$answ .= "overlaySym=$overlaySym;wavecount=" . ($wavecount + 1) . ";";
	if (isset($fs_left))
		$answ .= "fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";" . $answFS;
}
if ($lastAction == "lastrespin") {
	$answ .= "overlaySym=$overlaySym;";
	if (isset($fs_left))
		$answ .= "fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";" . $answFS;
}

////widget
if (isset($freeRoundsLeft) and $freeRoundsLeft > 0 and $lastAction != 'init' and $lastAction != 'paytable' and $lastAction != 'widgetspin') {
	if (
		$lastAction != 'respin' and $lastAction != 'coins' and
		$lastAction != 'startfreespin' and $lastAction != 'freespin' and $lastAction != 'endfreespin' and
		$lastAction != 'bonusgame'  and $lastAction != 'bonusaction' and $lastAction != 'endbonus' and $lastAction != 'collectbonus' and
		$lastAction != 'random_wilds_spin'
	) {
		$freeRoundsLeft--;
		$output .= "freeRoundsLeft=$freeRoundsLeft&";
		$output .= "gameroundid=$freeRoundsLeft&";
	}
	if ($lastAction != 'bonusgame' and $lastAction != 'bonusaction' and $lastAction != 'endbonus') $freeRoundsWin += $real_win * 100;

	if ($freeRoundsLeft == 0) {
		if ($lastAction != 'endfreespin' or $lastAction != 'spin' or $lastAction == 'endbonus' or $lastAction != 'coins') {
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
