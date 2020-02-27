<?
header('Access-Control-Allow-Origin: *');
////////////////////////////////////////////////////////////////////////////////
//selectors
////////////////////////////////////////////////////////////////////////////////
$gameover = "true";
$wilds = '';
$table_locked = 0;
$buster12 = '';

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



////////////////////////////////////
//correct action check
////////////////////////////////////

if ($_GET['action'] == "respin" and $lastActionDB != "respin") exit;

if ($_GET['action'] == "freespin" and $lastActionDB == "spin") exit;
if ($_GET['action'] == "bonusaction" and $lastActionDB == "spin") exit; ///////////add???
if ($_GET['action'] == "bonusaction" and $lastActionDB == "endbonus") exit;
if ($_GET['action'] == "bonusaction" and $lastActionDB == "collectbonus") exit;

if ($_GET['action'] == "endbonus" and $lastActionDB != "endbonus") exit;

if ($_GET['action'] == "freespin" and $lastActionDB == "paytable" and $answer == '') exit;
if ($_GET['action'] == "freespin" and $lastActionDB == "init") exit;

if ($_GET['action'] == "freespin" and $lastActionDB != "freespin" and $lastActionDB != "startfreespin" and $lastActionDB != "paytable") exit;


////////////////////////////////////

if ($_GET['action'] == "endbonus") {
	$output .= "next.rs=basic_0&";
	$output .= "rs.i0.r.i3.pos=144&";
	$output .= "rs.i0.r.i1.overlay.i0.pos=47&";
	$output .= "rs.i0.r.i0.attention.i0=2&";
	$output .= "rs.i0.r.i1.hold=false&";
	$output .= "gamestate.history=basic%2Cbonus_feature_pick%2Cbonus&";
	$output .= "nextaction=spin&";
	$output .= "last.rs=basic_0&";
	$output .= "rs.i0.nearwin=4&";

	$output .= "rs.i0.r.i2.attention.i0=2&";
	$output .= "rs.i0.r.i1.overlay.i0.row=0&";
	$output .= "rs.i0.r.i2.syms=SYM9%2CSYM8%2CSYM0&";
	$output .= "gamestate.current=basic&";
	$output .= "rs.i0.r.i2.hold=false&";
	$output .= "rs.i0.r.i1.overlay.i0.with=SYM6&";
	$output .= "rs.i0.r.i0.hold=false&";
	$output .= "rs.i0.r.i4.attention.i0=0&";
	$output .= "rs.i0.r.i4.hold=false&";
	$output .= "current.rs.i0=basic_0&";
	$output .= "rs.i0.id=basic_0&";

	$output .= "rs.i0.r.i4.pos=25&";
	$output .= "rs.i0.r.i3.syms=SYM9%2CSYM10%2CSYM5&";
	$output .= "rs.i0.r.i2.pos=7&";

	$output .= "rs.i0.r.i0.syms=SYM4%2CSYM10%2CSYM0&";
	$output .= "rs.i0.r.i0.pos=400&";
	$output .= "rs.i0.r.i3.hold=false&";
	$output .= "rs.i0.r.i1.syms=SYM32%2CSYM11%2CSYM9&";

	$output .= "overlaySym=SYM6&";
	$output .= "clientaction=endbonus&";
	$output .= "previous.rs.i0=basic_0&";
	$output .= "gamestate.stack=basic&";
	$output .= "rs.i0.r.i1.pos=47&";
	$output .= "rs.i0.r.i4.syms=SYM0%2CSYM9%2CSYM10";


	$creditDB = $credit;
	$real_win = $bonus_totalwin * $denomDB * 0.01;

	$lastAction = "collectbonus";
}


if ($_GET['action'] == "bonusaction") {

	$dice = floor(rand(1, 6));
	if ($bonus_mult == "2") $curDlbPos = "true";
	else  $curDlbPos = "false";

	/////////////
	//check dice
	/////////////

	if ($cur_pos == 68) $dice = floor(rand(1, 5));
	if ($cur_pos == 70) $dice = floor(rand(1, 3));
	if ($cur_pos == 72) $dice = floor(rand(1, 2));

	$next_pos = $cur_pos;
	$lastAction = 'bonusaction';
	$curDlbPos = "false";

	$result = mysql_query("SELECT symbols FROM ns.bonuses where payRate='" . $payRate . "' and type='7' and gameId='" . $gameId . "';");
	$row = mysql_fetch_assoc($result);
	$mapNodes = explode(";", $row['symbols']);

	$temp_pos = $cur_pos;

	$node = explode("_", $mapNodes[$cur_pos]);
	if ($node[2] == 'arrow') $is_arrow = 1;

	do {
		$node = explode("_", $mapNodes[$temp_pos]);

		$next_pos = $temp_pos;

		if ($is_arrow == 1) {
			$temp_pos = $node[3];
			$is_arrow = 0;
		} else $temp_pos = $node[0];

		$dice--;
	} while ($dice >= 0);

	$output .= "bonus_game_results.diceroll=" . $dice . "&";

	if ($node[2] == 'arrow') {
		$output .= "bonus_game_results.arrow_position.win=2&";
		$output .= "bonus_game_results.arrow_position.id=" . $node[3] . "&";
		$output .= "bonus_game_results.arrow_position.double=" . $curDlbPos . "&";
		$output .= "bonus_game_results.arrow_position.type=coinwin&";
		$output .= "bonus_game_results.current_position.type=arrow&";
		$output .= "nextaction=bonusaction&";
		$output .= "bonus_game_results.gameover=false&";
	} elseif ($node[2] == 'collect') {
		$output .= "bonus_game_results.current_position.type=collect&";
		$output .= "bonus_game_results.near_collect=" . $next_pos . "&";
		$output .= "nextaction=endbonus&";
		$output .= "bonus_game_results.gameover=false&";
		$lastAction = 'endbonus';
	} elseif ($node[2] == 'double') {
		$curDlbPos = "true";
		$output .= "bonus_game_results.current_position.type=double&";
		$output .= "bonus_game_results.current_position.id=" . $node[3] . "&";
		$output .= "bonus_game_results.gameover=false&";
		$output .= "nextaction=bonusaction&";
		$bonus_mult = "2";

		$lastAction = 'bonusaction';
	} elseif ($node[2] == 'jackpot') {
		$output .= "bonus_game_results.near_collect=" . $next_pos . "&";

		$output .= "nextaction=endbonus&";
		$output .= "bonus_game_results.current_position.type=jackpot&";
		$output .= "bonus_game_results.gameover=true&";
		$output .= "bonus_game_results.current_position.id=74&";
		$output .= "bonus_game_results.near_collect=73&";
		$lastAction = 'endbonus';
	} else {
		$output .= "bonus_game_results.current_position.type=coinwin&";
		$output .= "nextaction=bonusaction&";
		$output .= "bonus_game_results.gameover=false&";
	}

	$current_positionWin = $node[1] * $bonus_mult;
	$bonus_totalwin += $current_positionWin * $betDB * $linesDB;

	$answ = "cur_pos=" . $next_pos . ";bonus_mult=" . $bonus_mult . ";bonus_totalwin=" . $bonus_totalwin . ";";

	$output .= "bonus_game_results.current_position.win=" . $current_positionWin . "&";
	$output .= "bonus_game_results.current_position.id=" . $next_pos . "&";
	$output .= "bonus_game_results.multiplier=" . $bonus_mult . "&";
	$output .= "bonus_game_results.current_position.double=" . $curDlbPos . "&";


	$output .= "bonus_game_results.totalwin=" . $bonus_totalwin . "&";
	$output .= "bonusgame.coinvalue=" . ($denomDB * 0.01) . "&";

	$output .= "bonuswin.coins=" . $current_positionWin . "&";
	$output .= "bonuswin.cents=" . ($current_positionWin * $denomDB) . "&";
	$output .= "totalbonuswin.coins=" . $bonus_totalwin . "&";
	$output .= "totalbonuswin.cents=" . ($bonus_totalwin * $denomDB) . "&";

	$output .= "previous.rs.i0=basic&";
	$output .= "next.rs=basic_0&";
	$output .= "last.rs=basic&";
	$output .= "current.rs.i0=basic_0&";

	$output .= "nextactiontype=pickbonus&";
	$output .= "clientaction=bonusaction&";

	$output .= "gamestate.history=basic%2Cbonus_feature_pick%2Cbonus&";
	$output .= "gamestate.current=bonus&";
	$output .= "gamestate.bonusid=grimmbonusgame&";
	$output .= "gamestate.stack=basic%2Cbonus&";

	$gameover = 'false';

	$creditDB = $credit;
}

//////////////////
//MAINGAME HANDLER
/////////////////

if ($_GET['action'] == "spin" or $_GET['action'] == "respin" or $_GET['action'] == "random_wilds_spin" or $_GET['action'] == "bonus_feature_pick" or $_GET['action'] == "freespin") {
	$lastAction = "undef";
	$buster7 = '';
	//////////////////
	//symbol generation
	////////////////////
	$i = 0;
	$result = mysql_query("SELECT * FROM ns.reels where payRate=" . $payRate . " and gameId=" . $gameId . " order by id asc;");

	while ($reels = mysql_fetch_assoc($result)) {
		$reel[$i] = explode("_", $reels['symbols']);
		$i++;
	}
	///////////////////////////////////////		pravka
	$freeWildsRate = $reel[9][0];
	$symbTransRate = $reel[9][1];
	$clusterTransRate = $reel[9][2];
	//////////////////////////////////////

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

	/////////////////////////////////////////
	/*
if($_GET['action']=="spin" and $lastActionDB!='collectbonus')
{
	$symbols[0][1]=0;$symbols[2][1]=0;$symbols[4][1]=0;
//	$symbols[0][0]=4;$symbols[2][0]=4;$symbols[4][0]=4;
}
*/
	///////////////////////////////////////

	$lastAction = "spin";

	//wilds preparing
	$temp = explode('_', $wildsDB);
	foreach ($temp as $e) if ($e != '') {
		$temp2 = explode(',', $e);
		$extraWildsDB[$temp2[0]][$temp2[1]] = 1;
		$freeReelForWild[$temp2[0]] = 1;
	}

	$bonusSymbCount = 0;
	foreach ($symbols as $tReel => $t)
		foreach ($t as $tRow => $e) {
			if ($symbols[$tReel][$tRow] == 0) {
				$bonusSymbCount++;
				$bonusReels[$tReel] = 1;
			}
		}

	// make wilds
	if ($bonusSymbCount < 2) {
		foreach ($reel[5] as $v => $e)
			if (rand(0, 1000) < ($e)) {
				$p = round(rand(0, 2));
				$extrawild[$v][$p] = 1;
			}
	}

	//$extrawild[1][1]=1;//$extrawild[1][1]=1;//$extrawild[2][1]=1;$extrawild[3][1]=1;$extrawild[4][1]=1;
	//$extrawild[0][0]=1;
	//$extrawild[3][1]=1;

	$wildCount = 0;

	foreach ($extrawild as $tReel => $t)
		foreach ($t as $tRow => $e) {
			if ($extraWildsDB[$tReel][$tRow] != 1) {
				$wildCount++;
				$wilds .= $tReel . "," . $tRow . "_";
			}
		}

	foreach ($extraWildsDB as $e => $v) foreach ($v as $e1 => $v1) $extrawild[$e][$e1] = 1;

	/////////////////////
	//make action
	//////////////////////
	// make random wilds

	if (rand(0, 1000) < $freeWildsRate and $_GET['action'] == "spin" and $lastActionDB != "symbol_transform") {
		$lastAction = "random_wilds_spin";
	}

	if ($lastAction != "random_wilds_spin") {
		if (rand(0, 1000) < $clusterTransRate and $_GET['action'] == "spin") {
			$lastAction = "cluster_spin";
		}
	}

	if ($lastAction != "random_wilds_spin" and $lastAction != "cluster_spin") {
		if ($wildCount > 1) $lastAction = "respin";

		if ($wildCount > 0 and $lastActionDB == 'respin') $lastAction = "respin";

		if (rand(0, 1000) < $symbTransRate and $_GET['action'] == "spin" and $lastActionDB != "symbol_transform") {
			if ($bonusSymbCount == 0) $lastAction = "symbol_transform";
		}
	}

	//if($_GET['action']=='spin')
	//	$lastAction="random_wilds_spin";
	//	$lastAction="cluster_spin";
	//	$lastAction="symbol_transform";

	include('./integr/busters.php');


	if ($bonusSymbCount > 2 and $lastAction != "random_wilds_spin" and $lastAction != "random_wilds_spin" and $lastAction != "cluster_spin") $lastAction = "bonus_feature_pick";

	if ($lastAction == 'respin' and $lastActionDB != 'random_wilds_spin') $wilds .= $wildsDB;
	else $wilds = '';

	if ($_GET['action'] == "freespin") {
		$result = mysql_query("SELECT answer FROM ns.states where sessionId='" . $_GET['sessid'] . "';");
		$row = mysql_fetch_assoc($result);
		$bonusInfo = explode(";", $row['answer']);
		foreach ($bonusInfo as $e => $v)
			if ($v != '') {
				$a = explode("=", $v);
				$$a[0] = $a[1];
			}
		$output .= "freespins.multiplier=1&";
		$output .= "next.rs=freespin_0&";
		$output .= "freespins.additional=0&";
		$output .= "gamestate.history=basic%2Cbonus_feature_pick%2Cfreespin&";
		$output .= "freespins.denomination=5.000&";
		$output .= "freespins.initial=0&";
		$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19&";
		$output .= "clientaction=freespin&";
		$output .= "freespins.betlevel=1&";
		$output .= "freespins.overlaySym=SYM5&";

		$fs_left--;
		$fs_played++;

		$lastAction = "freespin";
	}

	if ($_GET['action'] == "bonus_feature_pick") {
		if ($buster7 == '') {
			$length = (count($reel[8]) - 1);
			$pos = round(rand(0, $length));

			if ($reel[8][$pos] == 5) $bonustype = "coins";
			if ($reel[8][$pos] == 6) $bonustype = "fSpins";
			if ($reel[8][$pos] == 7) $bonustype = "bonusGame";
		} else $bonustype = "bonusGame";

		//$bonustype="bonusGame";

		//	$bonustype="coins";	/////////////////////////////////////////////////////////////////////////////////

		//$bonustype="fSpins";

		if ($bonustype == "bonusGame") {
			$answ .= "cur_pos=0;bonus_mult=1;bonus_totalwin=0;";

			$result = mysql_query("SELECT symbols FROM ns.bonuses where payRate='" . $payRate . "' and type='7' and gameId='" . $gameId . "';");
			$row = mysql_fetch_assoc($result);
			$mapNodes = explode(";", $row['symbols']);
			foreach ($mapNodes as $v => $e) {
				$nodeData = explode("_", $e);
				if ($nodeData[0] != '') {
					$output .= "map.i" . $v . ".next=" . $nodeData[0] . "&";
					$output .= "map.i" . $v . ".coins=" . $nodeData[1] . "&";
					$output .= "map.i" . $v . ".type=" . $nodeData[2] . "&";
					if ($nodeData[3] != '') $output .= "map.i" . $v . ".arrow=" . $nodeData[3] . "&";
				}
			}

			$output .= "previous.rs.i0=basic&";
			$output .= "nextaction=bonusaction&";

			$output .= "bonus_game_results.gameover=false&";
			$output .= "bonus_game_results.current_position.type=coinwin&";
			$output .= "bonus_game_results.diceroll=0&";
			$output .= "bonus_game_results.current_position.win=0&";
			$output .= "bonus_game_results.current_position.double=false&";
			$output .= "bonus_game_results.multiplier=1&";
			$output .= "bonus_game_results.current_position.id=0&";
			$output .= "bonus_game_results.totalwin=0&";

			$output .= "bonuswin.cents=0&";
			$output .= "bonuswin.cents=0&";

			$output .= "gamestate.stack=basic%2Cbonus&";

			$output .= "totalbonuswin.cents=0&";
			$output .= "totalbonuswin.coins=0&";

			$output .= "gamestate.history=basic%2Cbonus_feature_pick&";
			$output .= "gamestate.current=bonus&";

			$output .= "bonuswin.coins=0&";

			$output .= "bonusgame.coinvalue=0.05&";

			$output .= "clientaction=bonus_feature_pick&";

			$output .= "nextactiontype=pickbonus&";

			$output .= "gamestate.bonusid=grimmbonusgame&";

			$output .= "next.rs=basic_0&";
			$output .= "last.rs=basic&";
			$output .= "current.rs.i0=basic_0&";
			$output .= "rs.i0.id=basic_0&";

			$lastAction = "bonusgame";
		}

		if ($bonustype == "fSpins") {
			$fs_left = 10;

			if ($buster10 != '') $fs_left *= 2;
			$fs_totalwin = 0;
			$fs_played = 0;
			$fs_multiplier = 1;
			$fs_initial = $fs_left;

			//	    $answ="fs_left=".$fs_left.";fs_played=0;fs_totalwin=0;";

			$output .= "freespins.multiplier=1&";
			$output .= "next.rs=freespin_0&";
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
			$output .= "last.rs=basic_0&";
			$output .= "rs.i1.id=freespin_0&";
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
			$output .= "current.rs.i0=freespin_0&";
			$output .= "freespins.played=0&";
			$output .= "rs.i0.id=basic_0&";
			$output .= "rs.i1.r.i4.hold=false&";
			$output .= "rs.i0.r.i2.pos=99&";
			$output .= "rs.i0.r.i3.hold=false&";
			$output .= "rs.i0.r.i1.syms=SYM8%2CSYM3%2CSYM3&";
			$output .= "overlaySym=SYM4&previous.rs.i0=basic_0&";
			$output .= "gamestate.stack=basic%2Cfreespin&";
			$output .= "rs.i0.r.i1.pos=144&";
			$output .= "freespins.totalwin.cents=0";

			$gameover = 'false';

			$lastAction = "startfreespin";
			$_Events['102'] = 1;
		}

		if ($bonustype == "coins") {
			$result = mysql_query("SELECT * FROM ns.bonuses where payRate=" . $payRate . " and gameId=" . $gameId . " and type=5;");
			$reels = mysql_fetch_assoc($result);
			$reel = explode("_", $reels['symbols']);
			$length = (count($reel) - 1);
			$pos = round(rand(0, $length));
			$coinWin = $reel[$pos] * $betDB; //critical!!!!!!!!!!!!!

			//	    if($buster12!='')$coinWin*=2;			////////////////////

			$total_win = $coinWin;

			$output .= "next.rs=basic_0&";
			$output .= "gamestate.history=basic%2Cbonus_feature_pick&";
			$output .= "nextaction=spin&";
			$output .= "last.rs=basic_0&";
			$output .= "gamestate.current=basic&";
			$output .= "current.rs.i0=basic_0&";
			$output .= "rs.i0.id=basic_0&";

			$output .= "feature.coin_win.amount=" . $coinWin . "&";

			$output .= "clientaction=bonus_feature_pick&";
			$output .= "previous.rs.i0=basic_0&";
			$output .= "gamestate.stack=basic&";

			$lastAction = "coins";
		}

		$output .= $lastRsDB;
		$lastRs = $lastRsDB;
	}


	if ($lastAction == "bonus_feature_pick") {
		$output .= "bws.i0.betline=null&";
		$output .= "rs.i0.nearwin=4&";
		$output .= "bws.i0.types.i0.wintype=feature&";
		$output .= "bws.i0.sym=SYM0&";
		$output .= "bws.i0.reelset=basic_0&";
		$anim_num = 0;
		for ($i = 0; $i < 5; $i++) {
			for ($j = 0; $j < 3; $j++) {
				if ($symbols[$i][$j] == 0) {
					$output .= "rs.i0.r.i" . $i . ".attention.i0=" . $j . "&";
					$output .= "bws.i0.pos.i" . $anim_num . "=" . $i . "," . $j . "&";
					$anim_num++;
				}
			}
		}
	}

	$overlaySym = "1";

	if ($lastAction != "undef" and $lastAction != "coins") {
		if ($lastAction == "symbol_transform") $symbolsOverlayed = $symbols;
		else {
			//make wilds
			if ($lastAction == "random_wilds_spin" or $lastActionDB == "random_wilds_spin") {
				unset($extrawild);
				$wilds = '';
				if ($lastAction == "random_wilds_spin") {
					for ($p = 0; $p < 2; $p++) ////////////////////////////////////////////////////////////////////min2 ???
					{
						$i = round(rand(0, 2));
						$j = round(rand(0, 4));
						$extrawild[$j][$i] = 1;
					}
					for ($i = 0; $i < 5; $i++) {
						for ($j = 0; $j < 3; $j++) {
							if (rand(0, 1000) < ($reel[6][$i])) {
								$extrawild[$i][$j] = 1;
							}
						}
					}
					$wildCount = 0;
					foreach ($extrawild as $tReel => $t)
						foreach ($t as $tRow => $e) {
							if ($extraWildsDB[$tReel][$tRow] != 1) {
								$wildCount++;
								$wilds .= $tReel . "," . $tRow . "_";
							}
						}
				}
			} elseif ($lastAction == "cluster_spin") {
				unset($extrawild);
				$wilds = '';
				$i = round(rand(5, 7));
				$overlaySym = $i;
				$posX = round(rand(0, 4));
				$posY = round(rand(0, 2));

				if ($posX == 2) $posX = 4;
				if ($posX == 1 and $posY == 1) $posY = 2;
				if ($posX == 3 and $posY == 1) $posY = 0;

				$offsetX = $posX - 2;
				$offsetY = $posY - 1;

				for ($i = $offsetX; $i < ($offsetX + 5); $i++) {
					if ($i >= 0)
						for ($j = $offsetY; $j < ($offsetY + 3); $j++) {
							if ($j >= 0) {
								$symbols[$i][$j] = $overlaySym;
								$mapSymb[$i][$j] = $overlaySym;
							}
						}
				}
				$output .= "feature.id=symbol_overlay&";
				$output .= "feature.sym=SYM" . $overlaySym . "&";
				$answ .= "<$posX;$posY>";
			}
		}

		if ($lastAction == "freespin") {
			unset($extrawild);
			unset($symbols);
			$wilds = '';

			//symbol generation
			$i = 0;
			$result = mysql_query("SELECT * FROM ns.bonuses where payRate=" . $payRate . " and gameId=" . $gameId . " and (type=0 or type=1 or type=2 or type=3 or type=4) order by type asc;");
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
			//	$symbols[0][1]=0;
			//	$symbols[2][1]=0;
			//	$symbols[4][1]=0;
			//	$symbols[3][1]=0;
			$chests = 0;

			for ($i = 0; $i < 3; $i++) {
				for ($j = 0; $j < 5; $j++) {
					if ($symbols[$j][$i] == 0 and $chests == 3) $symbols[$j][$i] = 3;
					if ($symbols[$j][$i] == 0 and $chests < 3) $chests++;
				}
			}
		}

		if ($wildsDB != "" and $lastAction != "respin") {
			unset($extrawild);
			$extrawild = $extraWildsDB;
			$wilds = '';
		}

		if ($lastAction == "symbol_transform") {
			unset($extrawild);
			for ($i = 0; $i < 3; $i++) {
				for ($j = 0; $j < 5; $j++) {
					$transform[$j][$i] = -1;
				}
			}
			$x = round(rand(0, 4));
			$y = round(rand(0, 2));

			$overlaySym = $symbols[$x][$y];

			$output .= "feature.sym=SYM" . $symbols[$x][$y] . "&";

			$output .= "feature.id=symbol_transform&";

			$steps = round(rand($reel[7][0], $reel[7][1]));


			for ($i = 0; $i < $steps; $i++) {
				$ok = 0;
				do {
					if ($i > 0) {
						$x = round(rand(0, 4));
						$y = round(rand(0, 2));
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

		if ($lastAction != "startfreespin" and $lastAction != "bonusgame" and $lastAction != "coins") include($gamePath . 'lines.php');

		//////////
		//draw rs
		//////////

		$wild = 0;
		$map = 0;
		$output .= "overlaySym=SYM" . $overlaySym . "&";

		if ($lastAction != "symbol_transform") $symbolsOverlayed = $symbols;

		for ($i = 0; $i < 5; $i++) {
			$wildsOnreel = 0;
			for ($j = 0; $j < 3; $j++) {
				if ($lastAction == "symbol_transform") {
					if ($symbols[$i][$j] == $overlaySym) {
						$output .= "rs.i0.r.i" . $i . ".overlay.i" . $wildsOnreel . ".with=SYM" . $overlaySym . "&";
						$output .= "rs.i0.r.i" . $i . ".overlay.i" . $wildsOnreel . ".row=" . $j . "&";
						$wildsOnreel++;
					}
				} else {
					if ($extrawild[$i][$j] == 1) {
						if ($lastAction != "random_wilds_spin" and $lastActionDB != "random_wilds_spin") {
							$output .= "extrawilds.i" . $wild . ".row=" . $j . "&";
							$output .= "extrawilds.i" . $wild . ".r=" . $i . "&";
						}
						$output .= "rs.i0.r.i" . $i . ".overlay.i" . $wildsOnreel . ".with=SYM" . $overlaySym . "&";
						$output .= "rs.i0.r.i" . $i . ".overlay.i" . $wildsOnreel . ".row=" . $j . "&";
						$symbolsOverlayed[$i][$j] = 32;
						$wild++;
						$wildsOnreel++;
					}

					if ($lastAction == "cluster_spin") {
						if ($symbolsOverlayed[$i][$j] == $mapSymb[$i][$j]) {
							$output .= "feature.symbol_overlay.map.i" . $map . ".id=" . $map . "&";
							$output .= "feature.symbol_overlay.map.i" . $map . ".row=" . $j . "&";
							$output .= "feature.symbol_overlay.map.i" . $map . ".r=" . $i . "&";
							$map++;
						}
					}
				}
			}
			$lastRs .= "rs.i0.r.i" . $i . ".syms=SYM" . $symbolsOverlayed[$i][0] . ",SYM" . $symbolsOverlayed[$i][1] . ",SYM" . $symbolsOverlayed[$i][2] . "&";
			$output .= "rs.i0.r.i" . $i . ".hold=false&";
		}


		if ($lastAction != "freespin" and $bonusReels[0] == 1 and $bonusReels[2] == 1) {
			$output .= "rs.i0.nearwin=4&";
		}

		$output .= $lastRs;


		/////////////////////////////
		//draw ws				///////////////////////odd types.i0.coins
		///////////////////////////
		$anim_num = 0;
		$total_win = 0;
		foreach ($win as $e => $v) {
			$tmp = explode("_", $v);

			if ($lastAction == "random_wilds_spin") $output .= "ws.i" . $anim_num . ".reelset=random_wild_0&";
			elseif ($lastAction == "symbol_transform") $output .= "ws.i" . $anim_num . ".reelset=symbol_transform_0&";
			elseif ($lastAction == "cluster_spin") $output .= "ws.i" . $anim_num . ".reelset=symbol_overlay_0&";
			else $output .= "ws.i" . $anim_num . ".reelset=basic_0&";

			if ($buster12 != '') $tmp[0] *= 2;			////////////////////
			$right_coins = $tmp[0] * $denomDB;		//////////////////////////////???????????????????????


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
			$add_fs = 0;
			$ani = 0;
			for ($i = 0; $i < 5; $i++) {
				for ($j = 0; $j < 3; $j++) {
					if ($symbols[$i][$j] == 0) {
						$add_fs += 2;
						$output .= "bws.i0.pos.i" . $ani . "=" . $i . "%2C" . $j . "&";
						$ani++;
					}
				}
			}

			if ($add_fs != 0) {
				if ($add_fs == 6) $add_fs = 10;
				$output .= "bws.i0.types.i0.wintype=feature&";
				$output .= "freespins.multiplier=1&";
				$output .= "freespins.wavecount=4&"; //////////////////////////////////////////////////////////
				$output .= "freespins.additional=" . $add_fs . "&";
				$output .= "bws.i0.direction=left_to_right&";
				$output .= "bws.i0.sym=SYM0&";
				$output .= "bws.i0.reelset=freespin_0&";
				$output .= "bws.i0.betline=null&";
			}

			$fs_total = $fs_left + $fs_played;
			$fs_totalwin += $total_win;
			$fs_left += $add_fs;

			if ($fs_left > 0) {
				$output .= "gamestate.current=freespin&"; ///cont
				$output .= "nextaction=freespin&";
				$output .= "gamestate.stack=basic%2Cfreespin&";
				$gameover = 'false';
			} else {
				$output .= "gamestate.current=basic&";	///ends
				$output .= "nextaction=spin&"; /////////////////////////?????????????????
				$output .= "gamestate.stack=basic&";
				$lastAction = "endfreespin";
			}

			$output .= "freespins.total=" . $fs_total . "&";
			$output .= "freespins.left=" . $fs_left . "&";
			$output .= "freespins.played=" . $fs_played . "&";
			$output .= "freespins.totalwin.coins=" . $fs_totalwin . "&";
			$output .= "freespins.totalwin.cents=" . $fs_totalwin . "&";
			$output .= "freespins.win.cents=" . $fs_totalwin . "&";
			$output .= "freespins.win.coins=" . $fs_totalwin . "&";

			$answ .= "fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";";
			$result = mysql_query("UPDATE ns.states set answer='" . $answ . "'  where sessionId='" . $_GET['sessid'] . "';");	////////////////may optimize no nado li???

		}

		if ($lastAction == "cluster_spin") {
			$output .= "clientaction=spin&";
			$output .= "rs.i0.id=symbol_overlay_0&";
			$output .= "gamestate.history=basic&";
			$output .= "gamestate.current=basic&";
			$output .= "next.rs=basic_0&";
			$output .= "last.rs=basic_0&";
			$output .= "nextaction=spin&";
			$output .= "previous.rs.i0=basic_0&";
			$output .= "gamestate.stack=basic&";
			$output .= "current.rs.i0=basic_0&";
			$table_locked = 0;

			$_Events['105'] = 1;
		} elseif ($lastAction == "random_wilds_spin") {
			$output .= "feature.id=random_wilds&";
			$output .= "clientaction=spin&";
			$output .= "rs.i0.id=random_wild_0&";
			$output .= "gamestate.history=basic&";
			$output .= "gamestate.current=basic&";
			$output .= "next.rs=random_wild_respin_0&";
			$output .= "last.rs=random_wild_0&";
			$output .= "previous.rs.i0=random_wild_0&";
			$output .= "gamestate.stack=basic&";
			$output .= "current.rs.i0=random_wild_respin_0&";
			$output .= "nextaction=" . $lastAction . "&";
			$gameover = 'false';
			$table_locked = 1;

			$_Events['104'] = 1;
		} elseif ($lastAction == "symbol_transform") {
			$output .= "current.rs.i0=basic_0&";
			$output .= "next.rs=basic_0&";
			$output .= "previous.rs.i0=basic_0&";
			$output .= "gamestate.stack=basic&";
			$output .= "gamestate.history=basic&";
			$output .= "last.rs=basic_0&";
			$output .= "clientaction=spin&";
			$output .= "gamestate.current=basic&";
			$output .= "rs.i0.id=symbol_transform_0&";
			$output .= "nextaction=spin&";
			$table_locked = 0;

			$_Events['103'] = 1;
		} elseif ($lastAction == "bonus_feature_pick") {
			$output .= "nextaction=bonus_feature_pick&";
			$output .= "rs.i0.id=basic_0&";
			$output .= "current.rs.i0=basic_0&";
			$output .= "next.rs=basic_0&";
			$output .= "previous.rs.i0=basic_0&";
			$output .= "last.rs=basic_0&";
			$output .= "gamestate.current=basic&";
			$output .= "clientaction=spin&";
			$output .= "gamestate.stack=basic&";
			$output .= "gamestate.history=basic&";
			$table_locked = 1;
		} elseif ($lastAction == "bonusgame") {
			$output .= "nextaction=bonusaction&";
			$table_locked = 1;
		} elseif ($lastAction == "freespin") {
			$output .= "last.rs=freespin_0&";
			$output .= "current.rs.i0=freespin_0&";
			$output .= "rs.i0.id=freespin_0&";
			$output .= "previous.rs.i0=freespin_0&";
			$table_locked = 1;
		} elseif ($lastAction == "endfreespin") {
			$output .= "nextaction=spin&";
			$output .= "rs.i0.id=basic_0&";
			$output .= "current.rs.i0=basic_0&";
			$output .= "next.rs=basic_0&";
			$output .= "previous.rs.i0=basic_0&";
			$output .= "last.rs=basic_0&";
			$output .= "gamestate.current=basic&";
			$output .= "clientaction=spin&";
			$output .= "gamestate.stack=basic&";
			$output .= "gamestate.history=basic&";
			$table_locked = 0;
		} elseif ($lastAction == "startfreespin") {
			$output .= "last.rs=freespin_0&";
			$output .= "current.rs.i0=freespin_0&";
			$output .= "rs.i0.id=freespin_0&";
			$output .= "previous.rs.i0=freespin_0&";
			$output .= "nextaction=freespin&";
			$table_locked = 1;
		} else {
			$output .= "nextaction=" . $lastAction . "&";
			$output .= "rs.i0.id=basic_0&";
			$output .= "current.rs.i0=basic_0&";
			$output .= "next.rs=basic_0&";
			$output .= "previous.rs.i0=basic_0&";
			$output .= "last.rs=basic_0&";
			$output .= "gamestate.current=basic&";
			$output .= "clientaction=spin&";
			$output .= "gamestate.stack=basic&";
			$output .= "gamestate.history=basic&";
			$table_locked = 0;
		}
	}

	$spin_to_history = 1;

	$credit /= 100;

	$spincost = 0;

	$real_win = $total_win * $denomDB * 0.01;

	if ($lastAction != 'respin' and $lastAction != 'coins' and $lastAction != 'freespin' and $lastAction != 'startfreespin' and $lastAction != 'endfreespin' and $lastAction != 'bonusgame' and $lastAction != 'random_wilds_spin')     $spincost = $betDB * $linesDB * $denomDB * 0.01;

	if (isset($freeRoundsLeft)) $spincost = 0;

	$credit -= $spincost;

	$credit += $real_win;

	$creditDB = $credit * 100;

	$credit *= 100;
}


$query = "lastAction='" . $lastAction . "',wilds='" . $wilds . "', lastRs='" . $lastRs . "'";

if ($lastAction == 'respin' or $lastActionDB == 'respin' or $lastAction == 'random_wilds_spin') {
	if ($totalWinsDB == 0) $totalWinsDB = $total_win;
	else $totalWinsDB = $totalWinsDB + $total_win;
	if ($lastAction != 'spin') $answ .= "totalWinsDB=" . $totalWinsDB . ";";
}


if ($lastAction == "endbonus") {
	$credit += ($bonus_totalwin * $denomDB);
	$creditDB = $credit;
	$real_win = $bonus_totalwin * $denomDB * 0.01;

	$symb_combs = "bonusWin=" . ($bonus_totalwin * $denomDB) . ";" . $symb_combs;
}


if ($lastAction == "freespin"  or $lastAction == "startfreespin") {
	if ($fs_left > 0) {
		$answ .= "fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";fs_multiplier=" . $fs_multiplier . ";fs_initial=" . $fs_initial . ";";
	}
}

if ($lastAction == "respin") {
	$symb_combs = "wilds=" . $wilds . ";" . $symb_combs;
	$table_locked = 1;
}

if ($lastAction == "endfreespin") {
	$symb_combs = "win=" . $fs_totalwin . ";fspins=" . $fs_played . ";wilds=" . $wilds . ";" . $symb_combs;
	$wilds = '';
	$botAction = "spin";
}

if ($lastAction == "bonusaction") {
	$symb_combs = "cur_pos=" . $cur_pos . ";next_pos=" . $next_pos . ";win=" . $bonus_totalwin . ";mul=" . $bonus_mult . ";" . $symb_combs;
}

if ($lastAction == "collectbonus") $real_win = 0;

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

$query .= ", answer='" . $answ . "'";
$query .= ", locked='" . $table_locked . "'";

$query = "UPDATE ns.states set " . $query . " where sessionId='" . $_GET['sessid'] . "';";

//    echo "<br><br>".$query."<br><br>";

$result = mysql_query($query);
