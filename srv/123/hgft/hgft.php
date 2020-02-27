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

if ($_GET['action'] == "freespin" and ($lastActionDB == "spin" or $lastActionDB == "respin" or $lastActionDB == "random_wilds" or $lastActionDB == "symbol_overlay")) exit;
if ($_GET['action'] == "freespin" and $lastActionDB == "paytable" and $answer == '') exit;
if ($_GET['action'] == "freespin" and $lastActionDB == "init") exit;

if ($_GET['action'] == "freespin" and $lastActionDB != "freespin" and $lastActionDB != "startfreespin" and $lastActionDB != "paytable") exit;

if ($_GET['action'] == "bonusaction" and ($lastActionDB == "spin" or $lastActionDB == "respin" or $lastActionDB == "random_wilds" or $lastActionDB == "symbol_overlay")) exit;
if ($_GET['action'] == "bonusaction" and $lastActionDB == "paytable" and $answer == '') exit;
if ($_GET['action'] == "bonusaction" and $lastActionDB == "init") exit;

if ($_GET['action'] == "bonusaction" and $lastActionDB != "bonusaction" and $lastActionDB != "bonusgame" and $lastActionDB != "paytable") exit;

if ($_GET['action'] == "bonus_feature_pick")
	if ($lastActionDB == "paytable" and $answer == '') exit;
	elseif ($lastActionDB != "bonus_feature_pick" and $lastActionDB != "paytable") exit;


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


if ($_GET['action'] == "endbonus") {
	$lastAction = "endbonus";
	//////////////////////////////////////////////////PRAVIT
	$output = "playercurrencyiso=EUR&historybutton=false&next.rs=basic&isJackpotWin=false&jackpotcurrencyiso=EUR&rs.i0.r.i3.pos=213&jackpotcurrency=%26%23x20AC%3B&playercurrency=%26%23x20AC%3B&rs.i0.r.i0.attention.i0=0&rs.i0.r.i1.hold=false&gamestate.history=basic%2Cbonus_feature_pick%2Cbonus&wavecount=1&g4mode=false&nextaction=spin&rs.i0.nearwin=4&rs.i0.r.i2.attention.i0=0&rs.i0.r.i2.syms=SYM0%2CSYM5%2CSYM5&gamestate.current=basic&rs.i0.r.i2.hold=false&rs.i0.r.i0.hold=false&rs.i0.r.i4.attention.i0=2&rs.i0.r.i4.hold=false&current.rs.i0=basic&rs.i0.id=basic&rs.i0.r.i4.pos=75&playforfun=false&rs.i0.r.i3.syms=SYM5%2CSYM5%2CSYM5&rs.i0.r.i2.pos=166&multiplier=1&rs.i0.r.i0.syms=SYM0%2CSYM9%2CSYM9&rs.i0.r.i0.pos=116&rs.i0.r.i3.hold=false&rs.i0.r.i1.syms=SYM6%2CSYM6%2CSYM6&overlaySym=SYM9&clientaction=endbonus&gamestate.bonusid=deal_or_no_deal&gamestate.stack=basic&rs.i0.r.i1.pos=112&rs.i0.r.i4.syms=SYM6%2CSYM6%2CSYM0&";

	$botAction = "spin";
	$credit /= 100;
	$real_win = $bonus_totalwin * $denomDB * 0.01;
	$credit += $real_win;
	$creditDB = $credit * 100;
	$credit *= 100;
	$symb_combs .= "bonuswin=" . $bonus_totalwin . ";";
	$table_locked = 0;
}

if ($_GET['action'] == "bonusaction") {

	if ($lastActionDB == "paytable" and isset($restoreAction)) {
		$lastActionDB = $restoreAction;
		$wildsDB = $wildStcks;
	}
	if ($_GET['bonus_itemId'] == "undefined") $_GET['bonus_itemId'] = 12;

	//    if($_GET['bonus_action']=="pick_item_id")
	{
		if ($wildsDB == "") 	$wildsDB = $_GET['bonus_itemId'] . "_";
		else		$wildsDB .= $_GET['bonus_itemId'] . "_";
		$str = explode("_", $wildsDB);
		array_pop($str);
		$wilds = $wildsDB;
		if (count($str) == 3) {
			$k = 1;
			$items[0] = 1200;
			$items[1] = 600;
			$items[2] = 450;
			$items[3] = 360;
			$items[4] = 300;
			$items[5] = 240;
			$items[6] = 210;
			$items[7] = 180;
			$items[8] = 150;
			$items[9] = 120;
			$items[10] = 75;
			$items[11] = 45;
			$items[12] = 30;
			$items[13] = 24;
			$items[14] = 12;
		}

		////////////////
		//FOR BOT
		///////////////
		if ($_GET['bot'] == "1") {
			$items[0] = 1200;
			$items[1] = 600;
			$items[2] = 450;
			$items[3] = 360;
			$items[4] = 300;
			$items[5] = 240;
			$items[6] = 210;
			$items[7] = 180;
			$items[8] = 150;
			$items[9] = 120;
			$items[10] = 75;
			$items[11] = 45;
			$items[12] = 30;
			$items[13] = 24;
			$items[14] = 12;
			$k = 1;
		}
		///////////////////////////////////////////////////////

		$answ .= "type=main;";

		if ($k == 1) {
			$summ = 0;

			$j1 = round(rand(0, 14));
			$j2 = round(rand(0, 14));
			if ($j2 == $j1) {
				if ($j1 == 14) $j2 = 0;
				else $j2 = $j1 + 1;
			}
			$j3 = round(rand(0, 14));
			if ($j3 == $j1) {
				if ($j1 == 14) $j3 = 1;
				else if ($j2 == 14)  $j3 = 0;
				else $j3 = $j2 + 1;
			} else
	    if ($j3 == $j2) {
				if ($j2 == 14) $j3 = 0;
				else $j3 = $j2 + 1;
			}

			$summ = $items[$j1] + $items[$j2] + $items[$j3];

			$answ .= "type=final;prz0=" . ($summ / 3) . ";prz1=" . $items[$j1] . ";prz2=" . $items[$j2] . ";prz3=" . $items[$j3] . ";";
			$symb_combs .= "prz1=" . $items[$j1] . ";prz2=" . $items[$j2] . ";prz3=" . $items[$j3] . ";";

			unset($items[$j1]);
			unset($items[$j2]);
			unset($items[$j3]);
			$i = 0;
			foreach ($items as $e => $v) {
				$output .= "ignored_items.i" . $i . "=" . $v . "&";
				$i++;
				$symb_combs .= "$e => $v, ";
			}
		}

		foreach ($str as $e => $v) {
			$output .= "remaining_items.i" . $e . ".itemValue=" . ($summ / 3) . "&";
			$output .= "remaining_items.i" . $e . ".itemId=" . $v . "&";
		}

		$gameover = "false";

		$output .= "gamestate.history=basic%2Cbonus_feature_pick%2Cbonus&";
		$output .= "bonusgame.coinvalue=0.01&";

		$output .= "gamestate.current=bonus&";
		$output .= "clientaction=bonusaction&";

		$output .= "nextactiontype=pickbonus&";

		$output .= "gamestate.bonusid=deal_or_no_deal&";
		$output .= "gamestate.stack=basic%2Cbonus&";

		$bonus_totalwin = 0;

		if ($_GET['bonus_action'] == "pick_item_id") {
			$output .= "nextaction=bonusaction&";
			$output .= "lastbonusaction=pick_item_id&";
		} elseif ($_GET['bonus_action'] == "stop") {
			$output .= "lastbonusaction=stop&";
			$output .= "bonusgameover=true&";
			$output .= "nextaction=endbonus&";
			$bonus_totalwin = $prz0 * $betDB;
		} elseif ($_GET['bonus_action'] == "pick") {
			$output .= "nextaction=endbonus&";
			$output .= "bonusgameover=true&";
			$output .= "lastbonusaction=pick&";
			$j = round(rand(1, 3));
			$k = "prz" . $j;
			$bonus_totalwin = $$k * $betDB;
			$symb_combs .= "check $j => $$k x $betDB";
		}


		$output .= "bonuswin.cents=" . $bonus_totalwin . "&";
		$output .= "bonuswin.coins=" . $bonus_totalwin . "&";
		$output .= "totalbonuswin.cents=" . $bonus_totalwin . "&";
		$output .= "totalbonuswin.coins=" . $bonus_totalwin . "&";

		////////////////
		//FOR BOT
		///////////////
		if ($_GET['bot'] == "1") {
			$bonus_totalwin = $summ / 3;
			$botAction = "endbonus";
		}
		//////////////

		$answ .= "bonus_totalwin=" . $bonus_totalwin . ";";
		$lastAction = "bonusaction";
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
		$output .= "gamestate.bonusid=deal_or_no_deal&";
		$output .= "gamestate.stack=basic%2Cbonus&";
		$output .= "totalbonuswin.cents=0&";

		$lastAction = "bonusgame";
		$botAction = "bonusaction";
		$table_locked = 1;

		$answ .= "type=start;bonus_totalwin=0;";
	}

	if ($bonustype == "fSpins") {
		$fs_left = 10;
		if ($buster10 != '') $fs_left *= 2;
		$answ .= "fs_left=" . $fs_left . ";fs_played=0;fs_totalwin=0;";

		$output .= "freespins.multiplier=1&";
		$output .= "next.rs=freespin&";
		$output .= "freespins.additional=0&";
		$output .= "freespins.total=0&";
		$output .= "rs.i1.r.i0.hold=false&";
		$output .= "rs.i0.r.i3.pos=117&";
		$output .= "freespins.initial=0&";
		$output .= "freespins.totalwin.coins=0&";
		$output .= "rs.i0.r.i0.attention.i0=1&";
		$output .= "gamestate.history=basic%2Cbonus_feature_pick&";
		$output .= "freespins.denomination=5.000&";
		$output .= "rs.i1.r.i4.pos=0&";
		$output .= "last.rs=basic&";
		$output .= "rs.i1.id=freespin&";
		$output .= "rs.i1.r.i4.syms=SYM10%2CSYM8%2CSYM0&";
		$output .= "rs.i0.r.i2.attention.i0=2&";
		$output .= "rs.i0.r.i2.syms=SYM11%2CSYM9%2CSYM0&";
		$output .= "rs.i0.r.i2.hold=false&";
		$output .= "gamestate.current=freespin&";
		$output .= "rs.i1.r.i2.pos=0&";
		$output .= "rs.i1.r.i2.hold=false&";
		$output .= "rs.i0.r.i0.hold=false&";
		$output .= "rs.i0.r.i4.attention.i0=2&";
		$output .= "rs.i0.r.i4.hold=false&";
		$output .= "rs.i0.r.i4.pos=148&";
		$output .= "rs.i1.r.i2.syms=SYM11%2CSYM9%2CSYM6&";
		$output .= "rs.i0.r.i3.syms=SYM9%2CSYM5%2CSYM12&";
		$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19&";
		$output .= "rs.i0.r.i0.syms=SYM12%2CSYM0%2CSYM10&";
		$output .= "rs.i0.r.i0.pos=361&";
		$output .= "freespins.win.cents=0&";
		$output .= "clientaction=bonus_feature_pick&";
		$output .= "rs.i1.r.i3.hold=false&";
		$output .= "rs.i0.r.i4.syms=SYM8%2CSYM9%2CSYM0&";
		$output .= "rs.i1.r.i3.syms=SYM11%2CSYM6%2CSYM8&";
		$output .= "rs.i1.r.i0.pos=0&";
		$output .= "rs.i1.r.i1.syms=SYM4%2CSYM32%2CSYM32&";
		$output .= "freespins.wavecount=1&";
		$output .= "rs.i1.r.i3.pos=0&";
		$output .= "rs.i1.r.i0.syms=SYM6%2CSYM7%2CSYM10&";
		$output .= "rs.i0.r.i1.hold=false&";
		$output .= "freespins.win.coins=0&";
		$output .= "freespins.betlevel=1&";
		$output .= "nextaction=freespin&";
		$output .= "freespins.left=" . $fs_left . "&";
		$output .= "rs.i0.nearwin=4&";
		$output .= "rs.i1.r.i1.hold=false&";
		$output .= "rs.i1.r.i1.pos=0&";
		$output .= "current.rs.i0=freespin&";
		$output .= "freespins.played=0&";
		$output .= "rs.i0.id=basic_0&";
		$output .= "rs.i1.r.i4.hold=false&";
		$output .= "rs.i0.r.i2.pos=99&";
		$output .= "rs.i0.r.i3.hold=false&";
		$output .= "rs.i0.r.i1.syms=SYM8%2CSYM3%2CSYM3&";
		$output .= "overlaySym=SYM4&previous.rs.i0=basic";
		$output .= "gamestate.stack=basic%2Cfreespin&";
		$output .= "rs.i0.r.i1.pos=144&";
		$output .= "freespins.totalwin.cents=0&";

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
		$coinWin = $reel[$pos] * $betDB; //critical!!!!!!!!!!!!!

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

		$lastAction = "coins";
		$botAction = "spin";

		$credit /= 100;
		$real_win = $total_win * $denomDB * 0.01;
		$credit += $real_win;
		$creditDB = $credit * 100;
		$credit *= 100;
	}

	$output .= $lastRsDB;
	$lastRs = $lastRsDB;
	$table_locked = 0;
}


if ($_GET['action'] == "spin" or $_GET['action'] == "respin" or $_GET['action'] == "freespin") {

	$lastAction = "spin";
	if ($lastActionDB == "paytable" and isset($restoreAction)) {
		$lastActionDB = $restoreAction;
		$wildsDB = $wildStcks;
	}

	if ($lastActionDB == "freespin" and $_GET['action'] == "freespin") $lastAction = "freespin";
	if ($lastActionDB == "startfreespin" and $_GET['action'] == "freespin") $lastAction = "freespin";

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

	if ($lastAction == "freespin") {
		$chests = 0;
		for ($i = 0; $i < 3; $i++) {
			for ($j = 0; $j < 5; $j++) {
				if ($symbols[$j][$i] == 0 and $chests == 3) $symbols[$j][$i] = 3;
				if ($symbols[$j][$i] == 0 and $chests < 3) $chests++;
			}
		}
	}
	/*
if($lastAction!="freespin" and $_GET['sessid']==10637772)
{
$symbols[0][1]=4;$symbols[2][1]=7;$symbols[4][1]=4;
$symbols[0][0]=0;$symbols[2][0]=0;$symbols[4][0]=0;
$symbols[0][2]=4;$symbols[2][2]=6;$symbols[4][2]=5;
}
*/
	$bonusSymbCount = 0;
	$wildsSymbCount = 0;
	foreach ($symbols as $tReel => $t)
		foreach ($t as $tRow => $e) {
			if ($symbols[$tReel][$tRow] == 0) {
				$bonusSymbCount++;
				$bonusReels[$tReel] = 1;
			}
			if ($symbols[$tReel][$tRow] == 1) {
				$wildsSymbCount++;
			}
		}



	///////////////////////////////////////
	$randomWildsRate = $reel[6][0];
	$symbTransformRate = $reel[6][1];
	$symbolOverlayRate = $reel[6][2];
	//////////////////////////////////////

	if ($_GET['action'] == "spin") {
		if ($bonusSymbCount == 0) {
			if ($lastActionDB == "spin") {
				if (rand(0, 1000) < $reel[5][1]) {
					$lastAction = "stackSpin";
					$wldStacks[1] = 1;
				}
				if (rand(0, 1000) < $reel[5][3]) {
					$lastAction = "stackSpin";
					$wldStacks[3] = 1;
				}
			}
		}

		if ($lastAction != "stackSpin") {
			if (rand(0, 1000) < $randomWildsRate and $lastActionDB != "random_wilds") {
				$lastAction = "random_wilds";
				$length = (count($reel[7]) - 1);
				$pos = round(rand(0, $length));
				$wldStacks = explode(",", $reel[7][$pos]);
			}

			if ($lastAction != "random_wilds") {
				if (rand(0, 1000) < $symbTransformRate and $lastActionDB != "symbol_transform") {
					if ($bonusSymbCount == 0 and $wildsSymbCount == 0) $lastAction = "symbol_transform";
				}
			}

			if ($lastAction != "random_wilds" and $lastAction != "symbol_transform") {
				if (rand(0, 1000) < $symbolOverlayRate) {
					$lastAction = "symbol_overlay";
				}
			}
		}
	}

	include('./integr/busters.php');

	if ($bonusSymbCount > 2 and $lastAction != "random_wilds" and $lastAction != "freespin") $lastAction = "bonus_feature_pick";
	if ($lastActionDB == "stackSpin" or $lastActionDB == "random_wilds") $lastAction = "respin";


	if ($lastAction == "symbol_overlay") {
		unset($extrawild);
		$overlaySym = "3";
		$wilds = '';

		$overlaySymbsCount = 0;
		$baseX = round(rand(1, 3));
		$k = 0;
		for ($i = ($baseX - 1); $i <= ($baseX + 1); $i++) {
			for ($j = 0; $j < 3; $j++) {
				if (rand(0, 1000) < $reel[8][$k]) {
					$mapSymb[$i][$j] = $overlaySym;
					$symbols[$i][$j] = $overlaySym;
					$overlaySymbsCount++;
				}
				$k++;
			}
		}
		$output .= "feature.id=symbol_overlay&";
		$output .= "feature.sym=SYM" . $overlaySym . "&";
		$symb_combs .= "r $baseX;syms $overlaySymbsCount;";
	}



	if ($lastAction == "symbol_transform") {
		$hasSym = 0;
		for ($i = 0; $i < 3; $i++) {
			for ($j = 0; $j < 5; $j++) {
				$transform[$j][$i] = -1;

				if ($symbols[$j][$i] == 3 or $symbols[$j][$i] == 4 or $symbols[$j][$i] == 5) {
					$x = $j;
					$y = $i;
					$hasSym = 1;
				}
			}
		}
		if ($hasSym == 0) {
			$x = 2;
			$y = 1;
			$symbols[$x][$y] = round(rand(4, 5));
		}

		$symbolsOverlayed = $symbols;

		$overlaySym = $symbols[$x][$y];

		$output .= "feature.sym=SYM" . $symbols[$x][$y] . "&";

		$output .= "feature.id=symbol_transform&";

		$steps = 1;

		for ($i = 0; $i < 5; $i++)
			for ($j = 0; $j < 3; $j++)
				for ($k = 6; $k < 10; $k++) {
					if ($symbols[$i][$j] == $k) {
						$ax[$k] = $i;
						$ay[$k] = $j;
					}
				}

		foreach ($ax as $e => $v) {
			$a1x[$steps] = $ax[$e];
			$a1y[$steps] = $ay[$e];
			$steps++;
		}

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



	if ($lastAction != "startfreespin" and $lastAction != "bonusgame" and $lastAction != "coins")
		include($gamePath . 'lines.php');
	else $symb_combs .= " fake spin;";

	$output .= "overlaySym=SYM" . $overlaySym . "&";

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

					if ($lastAction == "symbol_transform" or $lastAction == "symbol_overlay") {
						if ($symbols[$i][$j] == $overlaySym) {
							$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".with=SYM" . $overlaySym . "&";
							$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".row=" . $j . "&";
							$anim_num++;
						}
					} else {

						$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".row=" . $j . "&";
						$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".with=SYM" . $overlaySym . "&";
						$anim_num++;
					}
				}


				if ($lastAction == "symbol_overlay") {
					if ($symbolsOverlayed[$i][$j] == $mapSymb[$i][$j]) {
						$output .= "feature.symbol_overlay.map.i" . $map . ".row=" . $j . "&";
						$output .= "feature.symbol_overlay.map.i" . $map . ".r=" . $i . "&";
						$map++;
					}
				}
			}
			$anim_num = 0;
		}

		$lastRs .= "rs.i0.r.i" . $i . ".syms=SYM" . $symbolsOverlayed[$i][0] . ",SYM" . $symbolsOverlayed[$i][1] . ",SYM" . $symbolsOverlayed[$i][2] . "&";

		if ($lastAction == "stackSpin" or $lastAction == "random_wilds") {
			if ($extrawild[$i][0] == 1) {
				$output .= "rs.i0.r.i" . $i . ".hold=true&";
				if ($wild_stacks == '') $wild_stacks = strval($i);
				else $wild_stacks .= "%2C" . $i;
			}
		} else
			$output .= "rs.i0.r.i" . $i . ".hold=false&";
	}
	$output .= $lastRs;


	if ($lastAction != "freespin" and $bonusReels[0] == 1 and $bonusReels[2] == 1) {
		$output .= "rs.i0.nearwin=4&";
	}

	/////////////////////////////
	//draw ws			
	///////////////////////////
	$anim_num = 0;
	$total_win = 0;

	if ($lastAction == "bonus_feature_pick") {
		$symbolsOverlayed = $symbols;
		$output .= "ws.i0.reelset=basic&";
		$output .= "ws.i0.direction=none&";
		$output .= "ws.i0.betline=null&";
		$output .= "ws.i0.sym=SYM0&";
		$output .= "rs.i0.nearwin=4&";
		$anim_num = 0;
		for ($i = 0; $i < 5; $i++) {
			for ($j = 0; $j < 3; $j++) {
				if ($symbols[$i][$j] == 0) {
					$output .= "rs.i0.r.i" . $i . ".attention.i0=" . $j . "&";
					$output .= "ws.i0.pos.i" . $anim_num . "=" . $i . "," . $j . "&";
					$anim_num++;
				}
			}
		}
		$anim_num = 1;
	}

	if ($lastAction == "freespin") {

		$add_fs = 0;
		$ani = 0;
		for ($i = 0; $i < 5; $i++) {
			for ($j = 0; $j < 3; $j++) {
				if ($symbols[$i][$j] == 0) {
					$add_fs += 2;
					$output .= "ws.i0.pos.i" . $ani . "=" . $i . "%2C" . $j . "&";
					$ani++;
				}
			}
		}

		if ($add_fs != 0) {
			if ($add_fs == 6) $add_fs = 10;
			$output .= "freespins.multiplier=1&";
			$output .= "freespins.wavecount=1&"; //////////////////////////////////////////////////////////
			$output .= "freespins.additional=" . $add_fs . "&";
			$output .= "ws.i0.reelset=freespin_few_spins&";
			$output .= "ws.i0.direction=left_to_right&";
			$output .= "ws.i0.sym=SYM0&";
			$output .= "ws.i0.betline=null&";
			$anim_num = 1;

			$lastAction = "freespinadd";
		}
	}



	foreach ($win as $e => $v) {
		$tmp = explode("_", $v);

		if ($lastAction == "stackSpin" or $lastAction == "respin") $output .= "ws.i" . $anim_num . ".reelset=basic_respin&";
		elseif ($lastAction == "symbol_transform") $output .= "ws.i" . $anim_num . ".reelset=symbol_transform&";
		elseif ($lastAction != "freespin") $output .= "ws.i" . $anim_num . ".reelset=basic&";

		else $output .= "ws.i" . $anim_num . ".reelset=freespin&";

		if ($buster12 != '') $tmp[0] *= 2;
		$right_coins = $tmp[0] * $denomDB;

		if ($lastAction == "symbol_transform") $output .= "ws.i" . $anim_num . ".sym=SYM" . $overlaySym . "&";
		else
			$output .= "ws.i" . $anim_num . ".sym=SYM" . $symbOverlays[$e] . "&";

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



	if ($lastAction == "freespin" or $lastAction == "freespinadd") {
		$fs_total = $fs_left + $fs_played;
		$fs_totalwin += $total_win;
		$fs_left += $add_fs;

		if ($fs_left > 0) {
			$output .= "gamestate.current=freespin&"; ///cont
			$output .= "nextaction=freespin&";
			$output .= "gamestate.stack=basic%2Cfreespin&";
			$output .= "next.rs=freespin&";
			$output .= "nextaction=freespin&";
			$botAction = "freespin";

			if ($lastAction == "freespinadd") {

				$output .= "last.rs=freespin_few_spins&";
				$output .= "rs.i0.id=freespin_few_spins&";
				$lastAction = "freespin";
			} else {
				$output .= "last.rs=freespin&";
				$output .= "rs.i0.id=freespin&";
			}


			$output .= "current.rs.i0=freespin&";
			$output .= "previous.rs.i0=freespin&";
			$output .= "clientaction=freespin&";

			$gameover = 'false';
			$table_locked = 1;
		} else {
			$output .= "gamestate.current=basic&";	///ends
			$output .= "nextaction=spin&"; /////////////////////////?????????????????
			$output .= "gamestate.stack=basic&";
			$output .= "next.rs=basic&";
			$lastAction = "endfreespin";

			$botAction = "spin";
			$symb_combs .= "fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";";

			$output .= "rs.i0.id=basic&";
			$output .= "current.rs.i0=basic&";
			$output .= "next.rs=basic&";
			$output .= "previous.rs.i0=basic&";
			$output .= "last.rs=basic&";
			$output .= "clientaction=spin&";
			$output .= "gamestate.stack=basic&";
			$output .= "gamestate.history=basic&";

			$table_locked = 1;
		}

		$output .= "freespins.total=" . $fs_total . "&";
		$output .= "freespins.left=" . $fs_left . "&";
		$output .= "freespins.played=" . $fs_played . "&";
		$output .= "freespins.totalwin.coins=" . $fs_totalwin . "&";
		$output .= "freespins.totalwin.cents=" . $fs_totalwin . "&";
		$output .= "freespins.win.cents=" . $fs_totalwin . "&";
		$output .= "freespins.win.coins=" . $fs_totalwin . "&";
	} elseif ($lastAction == "respin" or $lastAction == "stackSpin") {

		$gameover = "false";
		$output .= "gamestate.current=basic&";
		$output .= "gamestate.stack=basic&";

		$output .= "current.rs.i0=basic_respin&";
		$output .= "rs.i0.id=basic_respin&";

		$output .= "clientaction=spin&";
		$output .= "next.rs=basic_respin&";

		if ($lastAction == "respin") {
			$output .= "nextaction=spin&";
			$botAction = "spin";
			$table_locked = 0;
		} else {
			$output .= "nextaction=respin&";
			$output .= "wild_stacks.basic=" . $wild_stacks . "&";
			$botAction = "respin";
			$table_locked = 1;
		}
	} elseif ($lastAction == "random_wilds") {
		$gameover = "false";
		$output .= "gamestate.current=basic&";
		$output .= "gamestate.stack=basic&";

		$output .= "current.rs.i0=basic_respin&";
		$output .= "rs.i0.id=random_wild&";

		$output .= "clientaction=spin&";
		$output .= "next.rs=basic_respin&";

		$output .= "nextaction=respin&";
		$output .= "wild_stacks.basic=" . $wild_stacks . "&";

		$output .= "random_wilds=" . $wild_stacks . "&";
		$output .= "feature.id=random_wilds&";
		$botAction = "respin";
		$table_locked = 1;
	} elseif ($lastAction == "symbol_transform") {
		$output .= "current.rs.i0=basic&";
		$output .= "next.rs=basic&";
		$output .= "previous.rs.i0=basic&";
		$output .= "gamestate.stack=basic&";
		$output .= "gamestate.history=basic&";
		$output .= "last.rs=basic&";
		$output .= "clientaction=spin&";
		$output .= "gamestate.current=basic&";
		$output .= "rs.i0.id=symbol_transform&";
		$output .= "nextaction=spin&";
		$botAction = "spin";
		$table_locked = 0;
	} elseif ($lastAction == "symbol_overlay") {
		$output .= "clientaction=spin&";
		$output .= "rs.i0.id=symbol_overlay&";
		$output .= "gamestate.history=basic&";
		$output .= "gamestate.current=basic&";
		$output .= "next.rs=basic&";
		$output .= "last.rs=basic&";
		$output .= "nextaction=spin&";
		$output .= "previous.rs.i0=basic&";
		$output .= "gamestate.stack=basic&";
		$output .= "current.rs.i0=basic&";
		$botAction = "spin";
		$table_locked = 0;
	} elseif ($lastAction == "bonus_feature_pick") {
		$gameover = "false";
		$output .= "gamestate.current=bonus_feature_pick&";
		$output .= "clientaction=spin&";
		$output .= "nextaction=bonus_feature_pick&";
		$output .= "gamestate.stack=basic%2Cbonus_feature_pick&";
		$output .= "gamestate.history=basic&";
		$botAction = "bonus_feature_pick";
		$table_locked = 1;
	} else {
		$output .= "rs.i0.id=basic&";
		$output .= "current.rs.i0=basic&";
		$output .= "last.rs=basic&";
		$output .= "gamestate.current=basic&";
		$output .= "clientaction=spin&";
		$output .= "gamestate.stack=basic&";
		$output .= "gamestate.history=basic&";
		$output .= "nextaction=spin&";
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

	if ($lastAction == 'freespin') {
		$wilds = $wildsDB;
		$dop2 .= "(" . $wildsDB . ")";
	}

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
