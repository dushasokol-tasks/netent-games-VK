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
$buster12 = '';

$randomwildsActive = "false";
$stickyActive = "false";
$shuffleActive = "false";
$wildreelsActive = "false";

////////////////////////////////////
//correct action check
////////////////////////////////////
if ($_GET['action'] == "initbonus" and $lastActionDB != "startbonus" and $lastActionDB != "paytable") {
	exit;
}
if ($_GET['action'] == "initfreespin" and $lastActionDB != "bonusaction" and $lastActionDB != "paytable") exit;

if ($_GET['action'] == "bonusaction") {
	if ($answer == '') exit;
	elseif (!isset($rollsleft)) exit;
	elseif ($rollsleft < 0) exit;
}
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

if ($_GET['action'] == "endbonus") {
	$output .= "current.rs.i0=basic&";
	$output .= "previous.rs.i0=freespin&";
	$output .= "next.rs=basic&";
	$output .= "nextclientrs=basic&";
	$output .= "gamestate.stack=basic&";
	$output .= "clientaction=endbonus&";
	$output .= "nextaction=spin&";
	$output .= "gamestate.current=basic&";

	$output .= "bonus.rollsleft=" . $rollsleft . "&";
	$output .= "bonus.board.position=" . $boardposition . "&";
	$output .= "bonus.token=" . $token . "&";

	$output .= "feature.randomwilds.active=$randomwildsActive&";
	$output .= "feature.sticky.active=$stickyActive&";
	$output .= "feature.shuffle.active=$shuffleActive&";
	$output .= "feature.wildreels.active=$wildreelsActive&";

	$bonusStickyDisabled = "";
	$bonusWildreelsDisabled = "";
	$bonusShuffleDisabled = "";
	$bonusRandomwildsDisabled = "";

	$lastAction = "endbonus";
	$botAction = "spin";
}

if ($_GET['action'] == "bonusaction") {
	$table_locked = 1;
	$fs_type = "none";
	$fs_left = 0;
	$fs_initial = 0;

	if ($lastActionDB != "initbonus" or ($lastActionDB == "initbonus" and isset($restoreAction))) {
		$query = "SELECT * FROM ns.bonuses where payRate='" . $payRate . "' and gameId='" . $gameId . "' order by id asc;";
		$result = mysql_query($query);
		while ($reels = mysql_fetch_assoc($result)) {
			$reel[$reels['id']] = explode(";", $reels['symbols']);
		}
		$rollsleft--;
		$dice0 = round(rand(1, 6));
		$dice1 = round(rand(1, 6));

		//	$dice0=3;
		//	$dice1=4;

		if (isset($mystery) and $mystery == 1) {
			$dice0 = 0;
			$dice1 = 0;
			$rollsleft++;
		}
		$oldBoardposition = $boardposition;
		$boardposition = $boardposition + $dice0 + $dice1;
		if ($boardposition > 31) $boardposition = $boardposition - 32;


		foreach ($reel[7] as $e => $v) {
			$temp = explode("_", $v);
			if ($temp[0] == $oldBoardposition) {
				$oldNodeValue = $temp[1];
				$oldNodeType = $temp[2];
			}
			if ($temp[0] == $boardposition) {
				$nodeValue = $temp[1];
				$nodeType = $temp[2];
			}
		}

		if ($nodeType == 'mystery') {
			if (!isset($mystery)) {
				$answ .= "mystery=1;";
				$output .= "nextactiontype=revealmystery&";
			} else {
				$dice2 = round(rand(1, 6));
				if ($dice2 == 1 and $bonusStickyDisabled == "true") $dice2 = 6;
				if ($dice2 == 2 and $bonusWildreelsDisabled == "true") $dice2 = 6;
				if ($dice2 == 3 and $bonusShuffleDisabled == "true") $dice2 = 6;
				if ($dice2 == 4 and $bonusRandomwildsDisabled == "true") $dice2 = 6;

				if ($dice2 == 1) {
					$nodeType = "feature";
					$nodeValue = "stickywin";
					$boardposition = 4;
				}
				if ($dice2 == 2) {
					$nodeType = "feature";
					$nodeValue = "wildreels";
					$boardposition = 11;
				}
				if ($dice2 == 3) {
					$nodeType = "feature";
					$nodeValue = "shuffle";
					$boardposition = 20;
				}
				if ($dice2 == 4) {
					$nodeType = "feature";
					$nodeValue = "randomwilds";
					$boardposition = 27;
				}
				if ($dice2 == 5) {
					$nodeType = "reroll";
					$nodeValue = 2;
				}
				if ($dice2 == 6) //{$nodeType="coin";$nodeValue=round(rand(2,5));}
				{
					$nodeType = "coin";
					$length = (count($reel[8]) - 1);
					$pos = round(rand(0, $length));
					$nodeValue = $reel[8][$pos];
				}

				$symb_combs = "mystery: $nodeType $nodeValue;";
			}
		} else {
			if ($rollsleft == 0 and $nodeType == 'feature')
				$output .= "nextactiontype=freespin&";
			else $output .= "nextactiontype=roll&";
		}

		if ($nodeType == 'mystery' and !isset($mystery)) {
			$output .= "gamestate.bonusid=alan-bonus&";
			$output .= "gamestate.current=bonus&";
			$output .= "gamestate.history=basic%2Cbonus&";
			$output .= "gamestate.stack=basic%2Cbonus&";
			$output .= "nextclientrs=basic&";
			$output .= "bonus.win.type=mystery&";
			$output .= "bonus.win.value=unrevealed&";

			$output1 = "nextaction=bonusaction&";

			$botAction = "bonusaction";
		}

		if ($nodeType == 'feature') {
			if ($nodeValue == 'stickywin')
				if ($bonusStickyDisabled == "true") {
					$nodeType = 'reroll';
					$nodeValue = 1;
				} else {
					$stickyActive = "true";
					$output .= "feature.sticky.respin=false&";
					$output .= "gamestate.bonusid=alan-bonus&";
					$output .= "gamestate.current=freespin&";
					$output .= "gamestate.history=basic%2Cbonus&";
					$output .= "gamestate.stack=basic%2Cfreespin&";
					$output .= "nextclientrs=stickyfsa&";
					$output .= "bonus.win.type=feature&";
					$output .= "bonus.win.value=stickywin&";
					$fs_type = "sticky";
					$fs_initial = 10;
					$fs_left = 10;
					include('./integr/busters.php');
					if ($buster10 != '') {
						$fs_left *= 2;
						$fs_initial *= 2;
						$symb_combs = "bust10;";
					}
				}

			if ($nodeValue == 'wildreels')
				if ($bonusWildreelsDisabled == "true") {
					$nodeType = 'reroll';
					$nodeValue = 1;
				} else {
					$wildreelsActive = "true";

					$output .= "gamestate.bonusid=alan-bonus&";
					$output .= "gamestate.current=freespin&";
					$output .= "gamestate.history=basic%2Cbonus&";
					$output .= "gamestate.stack=basic%2Cfreespin&";
					$output .= "nextclientrs=wildfeatures&";
					$output .= "bonus.win.type=feature&";
					$output .= "bonus.win.value=wildreels&";

					$fs_type = "wildreels";
					$fs_initial = 7;
					$fs_left = 7;
					include('./integr/busters.php');
					if ($buster10 != '') {
						$fs_left *= 2;
						$fs_initial *= 2;
						$symb_combs = "bust10;";
					}
				}

			if ($nodeValue == 'shuffle')
				if ($bonusShuffleDisabled == "true") {
					$nodeType = 'reroll';
					$nodeValue = 1;
				} else {
					$shuffleActive = "true";

					$output .= "gamestate.bonusid=alan-bonus&";
					$output .= "gamestate.current=freespin&";
					$output .= "gamestate.history=basic%2Cbonus&";
					$output .= "gamestate.stack=basic%2Cfreespin&";
					$output .= "nextclientrs=shuffle&";

					$output .= "bonus.win.value=shuffle&";
					$output .= "bonus.win.type=feature&";

					$fs_type = "shuffle";
					$fs_initial = 6;
					$fs_left = 6;
					include('./integr/busters.php');
					if ($buster10 != '') {
						$fs_left *= 2;
						$fs_initial *= 2;
						$symb_combs = "bust10;";
					}
				}

			if ($nodeValue == 'randomwilds')
				if ($bonusRandomwildsDisabled == "true") {
					$nodeType = 'reroll';
					$nodeValue = 1;
				} else {
					$randomwildsActive = "true";

					$output .= "gamestate.bonusid=alan-bonus&";
					$output .= "gamestate.current=freespin&";
					$output .= "gamestate.history=basic%2Cbonus&";
					$output .= "gamestate.stack=basic%2Cfreespin&";
					$output .= "nextclientrs=wildfeatures&";

					$output .= "bonus.win.value=randomwilds&";
					$output .= "bonus.win.type=feature&";

					$fs_type = "randomwilds";
					$fs_initial = 5;
					$fs_left = 5;
					include('./integr/busters.php');
					if ($buster10 != '') {
						$fs_left *= 2;
						$fs_initial *= 2;
						$symb_combs = "bust10;";
					}
				}

			$coinWin = $bonuswin;
			$mysteryMul = 1;
			$totalWinsDB = $bonuswin;
			$total_winCents = $bonuswin;
			$fs_totalwin = $bonuswin;

			$symb_combs = "FS: $nodeType $nodeValue;";

			$output .= "current.rs.i0=freespin&";
			$output .= "next.rs=freespin&";
			$output1 = "nextaction=freespin&";

			$output .= "freespins.betlevel=1&";
			$output .= "freespins.win.coins=0&";
			$output .= "freespins.initial=" . $fs_left . "&";
			$output .= "freespins.denomination=1.000&";
			$output .= "freespins.win.cents=0&";
			$output .= "freespins.totalwin.coins=0&";
			$output .= "freespins.total=" . $fs_left . "&";
			$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C21%2C22%2C23%2C24%2C25%2C26%2C27%2C28%2C29%2C30%2C31%2C32%2C33%2C34%2C35&";
			$output .= "freespins.wavecount=1&";
			$output .= "freespins.multiplier=1&";
			$output .= "freespins.left=" . $fs_left . "&";

			$botAction = "initfreespin"; ///////////////???????????????????
		}

		if ($nodeType == 'coin') {
			$symb_combs = "coinMul=$nodeValue;";

			$mysteryMul = 10;
			if (isset($mystery)) $mysteryMul = 1;

			$coinWin = $nodeValue * $betDB;
			$bonuswin += $coinWin * 10;

			$credit /= 100;
			$total_win = $coinWin * 10;
			$real_win = $total_win * $denomDB * 0.01;
			$credit += $real_win;
			$creditDB = $credit * 100;
			$credit *= 100;

			$totalWinsDB = $bonuswin;

			$total_winCents = $total_win * $denomDB;
			$fs_totalwin = $bonuswin; //$coinWin*10;

			$output .= "previous.rs.i0=freespin&";
			$output .= "current.rs.i0=freespin&";
			$output .= "next.rs=freespin&";
			$output .= "nextclientrs=basic&";
			$output .= "last.rs=freespin&";
			$output1 = "nextaction=bonusaction&";

			$botAction = "bonusaction";

			if (isset($mystery)) $output .= "bonus.win.value=" . $nodeValue . "&";
			else
				$output .= "bonus.win.value=" . ($coinWin) . "&";

			$output .= "bonus.win.type=coin&";

			$output .= "gamestate.history=basic&";
			$output .= "gamestate.current=bonus&";
			$output .= "gamestate.stack=basic%2Cfreespin%2Cbonus&";
			$output .= "gamestate.bonusid=alan-bonus&";
		}
		if ($nodeType == 'reroll') {
			$coinWin = $bonuswin;
			$mysteryMul = 1;
			$totalWinsDB = $bonuswin;
			$total_winCents = $bonuswin;
			$fs_totalwin = $bonuswin;
			$symb_combs = "addRolls=$nodeValue;";


			$output .= "previous.rs.i0=freespin&";
			$output .= "current.rs.i0=freespin&";
			$output .= "next.rs=freespin&";
			$output .= "nextclientrs=basic&";
			$output .= "last.rs=freespin&";
			$output1 = "nextaction=bonusaction&";

			$output .= "bonus.win.value=$nodeValue&";
			$output .= "bonus.win.type=reroll&";

			$output .= "gamestate.history=basic&";
			$output .= "gamestate.current=bonus&";
			$output .= "gamestate.stack=basic%2Cfreespin%2Cbonus&";
			$output .= "gamestate.bonusid=alan-bonus&";

			$rollsleft += $nodeValue;

			$botAction = "bonusaction";
		}

		$output .= "clientaction=bonusaction&";

		if (!isset($mystery)) {
			$output .= "bonus.dice.i0.result=" . $dice0 . "&";
			$output .= "bonus.dice.i1.result=" . $dice1 . "&";
		}
	} else {
		$output .= "gamestate.current=bonus&";
		$output .= "gamestate.stack=basic%2Cbonus&";
		$output .= "gamestate.bonusid=alan-bonus&";

		$output .= "clientaction=bonusaction&";
		$output1 = "nextaction=bonusaction&";
		$output .= "nextactiontype=roll&";

		$botAction = "bonusaction";
	}

	if ($rollsleft <= 0 and $nodeType != 'feature' and $nodeType != 'mystery') {
		$output1 = "nextaction=endbonus&";
		$botAction = "endbonus";
	}

	$output .= $output1;

	$output .= "bonusgame.coinvalue=0.01&";

	$output .= "bonus.rollsleft=" . $rollsleft . "&";
	$output .= "bonus.board.position=" . $boardposition . "&";
	$output .= "bonus.token=" . $token . "&";

	$output .= "totalbonuswin.cents=" . $bonuswin . "&";
	$output .= "totalbonuswin.coins=" . $bonuswin . "&";
	$output .= "bonuswin.cents=" . ($coinWin * $mysteryMul) . "&";
	$output .= "bonuswin.coins=" . ($coinWin * $mysteryMul) . "&";


	$output .= "feature.randomwilds.active=$randomwildsActive&";
	$output .= "feature.sticky.active=$stickyActive&";
	$output .= "feature.shuffle.active=$shuffleActive&";
	$output .= "feature.wildreels.active=$wildreelsActive&";

	$answ .= "rollsleft=$rollsleft;bonuswin=$bonuswin;boardposition=$boardposition;token=$token;fs_type=$fs_type;fs_left=$fs_left;fs_initial=$fs_initial;";

	if ($bonusStickyDisabled == "true") {
		$answ .= "bonusStickyDisabled=$bonusStickyDisabled;";
		$bonusStickyDisabled = "aftertrue";
	}
	if ($bonusWildreelsDisabled == "true") {
		$answ .= "bonusWildreelsDisabled=$bonusWildreelsDisabled;";
		$bonusWildreelsDisabled = "aftertrue";
	}
	if ($bonusShuffleDisabled == "true") {
		$answ .= "bonusShuffleDisabled=$bonusShuffleDisabled;";
		$bonusShuffleDisabled = "aftertrue";
	}
	if ($bonusRandomwildsDisabled == "true") {
		$answ .= "bonusRandomwildsDisabled=$bonusRandomwildsDisabled;";
		$bonusRandomwildsDisabled = "aftertrue";
	}

	$lastAction = "bonusaction";

	$symb_combs = "rollsleft=" . $rollsleft . ";Ntype=" . $nodeType . ";Nval=" . $nodeValue . ";" . $symb_combs;
}


if ($_GET['action'] == "initbonus") {
	$table_locked = 1;
	if ($lastActionDB == "startbonus" or ($lastActionDB == "paytable" and isset($restoreAction) and ($restoreAction == "bonusaction" or $restoreAction == "initbonus" or
		(($restoreAction == "shuffle" or $restoreAction == "aftershuffle" or $restoreAction == "sticky" or $restoreAction == "respin" or $restoreAction == "lastrespin" or $restoreAction == "freespin") and $rollsleft > 0)))) {
		if ($lastActionDB == "startbonus") {
			$boardposition = 0;
			$bonuswin = 0;
		}

		$output = "bonus.rollsleft=$rollsleft&";
		$output .= "bonus.board.position=$boardposition&";

		$output .= "clientaction=initbonus&";
		$output .= "nextaction=bonusaction&";
		$output .= "nextactiontype=selecttoken&";

		$output .= "gamestate.history=basic&";
		$output .= "gamestate.current=bonus&";
		$output .= "gamestate.bonusid=alan-bonus&";
		$output .= "gamestate.stack=basic%2Cbonus&";


		$output .= "bonus.field.i0.type=mystery&bonus.field.i0.value=unrevealed&";
		$output .= "bonus.field.i1.type=coin&bonus.field.i1.value=1&";
		$output .= "bonus.field.i2.type=reroll&bonus.field.i2.value=1&";
		$output .= "bonus.field.i3.type=coin&bonus.field.i3.value=5&";
		$output .= "bonus.field.i4.type=feature&bonus.field.i4.value=stickywin&";
		$output .= "bonus.field.i5.type=feature&bonus.field.i5.value=stickywin&";
		$output .= "bonus.field.i6.type=reroll&bonus.field.i6.value=1&";
		$output .= "bonus.field.i7.type=coin&bonus.field.i7.value=1&";
		$output .= "bonus.field.i8.type=mystery&bonus.field.i8.value=unrevealed&";
		$output .= "bonus.field.i9.type=reroll&bonus.field.i9.value=1&";
		$output .= "bonus.field.i10.type=coin&bonus.field.i10.value=1&";
		$output .= "bonus.field.i11.type=feature&bonus.field.i11.value=wildreels&";
		$output .= "bonus.field.i12.type=feature&bonus.field.i12.value=wildreels&";
		$output .= "bonus.field.i13.type=coin&bonus.field.i13.value=1&";
		$output .= "bonus.field.i14.type=coin&bonus.field.i14.value=1&";
		$output .= "bonus.field.i15.type=coin&bonus.field.i15.value=2&";
		$output .= "bonus.field.i16.type=mystery&bonus.field.i16.value=unrevealed&";
		$output .= "bonus.field.i17.type=coin&bonus.field.i17.value=1&";
		$output .= "bonus.field.i18.type=reroll&bonus.field.i18.value=1&";
		$output .= "bonus.field.i19.type=coin&bonus.field.i19.value=1&";
		$output .= "bonus.field.i20.type=feature&bonus.field.i20.value=shuffle&";
		$output .= "bonus.field.i21.type=feature&bonus.field.i21.value=shuffle&";
		$output .= "bonus.field.i22.type=coin&bonus.field.i22.value=1&";
		$output .= "bonus.field.i23.type=coin&bonus.field.i23.value=1&";
		$output .= "bonus.field.i24.type=mystery&bonus.field.i24.value=unrevealed&";
		$output .= "bonus.field.i25.type=coin&bonus.field.i25.value=3&";
		$output .= "bonus.field.i26.type=coin&bonus.field.i26.value=1&";
		$output .= "bonus.field.i27.type=feature&bonus.field.i27.value=randomwilds&";
		$output .= "bonus.field.i28.type=feature&bonus.field.i28.value=randomwilds&";
		$output .= "bonus.field.i29.type=coin&bonus.field.i29.value=1&";
		$output .= "bonus.field.i30.type=coin&bonus.field.i30.value=1&";
		$output .= "bonus.field.i31.type=coin&bonus.field.i31.value=1&";


		$output .= "nextclientrs=basic&";
		$output .= "feature.wildreels.active=false&";
		$output .= "feature.randomwilds.active=false&";
		$output .= "feature.sticky.active=false&";
		$output .= "feature.shuffle.active=false&";

		$output .= "bonuswin.cents=0&bonuswin.coins=0&totalbonuswin.cents=0&totalbonuswin.coins=0&";
		$output .= "bonusgame.coinvalue=0.01&";

		$answ .= "rollsleft=$rollsleft;bonuswin=$bonuswin;boardposition=$boardposition;token=$token;";

		if (isset($restoreAction)) $answ .= "restoreAction=$restoreAction;";

		$lastAction = "initbonus";

		$botAction = "bonusaction";
	}
}



if ($_GET['action'] == "initfreespin") {
	$table_locked = 1;
	$output .= "bonus.rollsleft=$rollsleft&bonus.token=$token&bonus.board.position=$boardposition&";

	$output .= "gamestate.current=freespin&gamestate.history=basic%2Cbonus&gamestate.bonusid=alan-bonus&gamestate.stack=basic%2Cfreespin&";

	$output .= "current.rs.i0=freespin&";
	$output .= "nextaction=freespin&";
	$output .= "clientaction=initfreespin&";

	$output .= "next.rs=freespin&";

	$output .= "nextactiontype=roll&";

	$output .= "freespins.left=" . $fs_left . "&";
	$output .= "freespins.initial=" . $fs_initial . "&";
	$output .= "freespins.total=" . $fs_left . "&";
	$output .= "freespins.win.cents=0&";
	$output .= "freespins.win.coins=0&";
	$output .= "freespins.totalwin.cents=0&";
	$output .= "freespins.totalwin.coins=0&";
	$output .= "freespins.betlevel=1&";
	$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C21%2C22%2C23%2C24%2C25%2C26%2C27%2C28%2C29%2C30%2C31%2C32%2C33%2C34%2C35&";
	$output .= "freespins.denomination=1.000&";
	$output .= "freespins.wavecount=1&";
	$output .= "freespins.multiplier=1&";

	$output .= "bet.denomination=1&bet.betlevel=1&bet.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C21%2C22%2C23%2C24%2C25%2C26%2C27%2C28%2C29%2C30%2C31%2C32%2C33%2C34%2C35&";

	$coinWin = $bonuswin;
	$mysteryMul = 1;
	$totalWinsDB = $bonuswin;
	$total_winCents = $bonuswin;
	$fs_totalwin = $bonuswin;


	if ($fs_type == 'sticky') {
		$output .= "rs.i0.id=basic&";
		$output .= "rs.i1.id=respin&";
		$output .= "rs.i2.id=freespin&";

		$output .= "nextclientrs=stickyfsa&";
		$output .= "feature.sticky.respin=false&";
		$stickyActive = "true";
		$bonusStickyDisabled = "true";

		$output .= "rs.i0.r.i0.syms=SYM7%2CSYM9%2CSYM9&rs.i0.r.i1.syms=SYM8%2CSYM0%2CSYM7%2CSYM7&rs.i0.r.i2.syms=SYM3%2CSYM6%2CSYM6%2CSYM5%2CSYM5&rs.i0.r.i3.syms=SYM5%2CSYM5%2CSYM9%2CSYM0&rs.i0.r.i4.syms=SYM9%2CSYM0%2CSYM7&";
		$output .= "rs.i1.r.i0.syms=SYM7&rs.i1.r.i1.syms=SYM7&rs.i1.r.i2.syms=SYM7&rs.i1.r.i3.syms=SYM11&rs.i1.r.i4.syms=SYM7&rs.i1.r.i5.syms=SYM7&rs.i1.r.i6.syms=SYM11&rs.i1.r.i7.syms=SYM11&rs.i1.r.i8.syms=SYM7&rs.i1.r.i9.syms=SYM11&rs.i1.r.i10.syms=SYM7&rs.i1.r.i11.syms=SYM11&rs.i1.r.i12.syms=SYM11&rs.i1.r.i13.syms=SYM7&rs.i1.r.i14.syms=SYM7&rs.i1.r.i15.syms=SYM11&rs.i1.r.i16.syms=SYM11&rs.i1.r.i17.syms=SYM7&rs.i1.r.i18.syms=SYM11&";
		$output .= "rs.i2.r.i0.syms=SYM6%2CSYM6%2CSYM7&rs.i2.r.i1.syms=SYM4%2CSYM4%2CSYM7%2CSYM7&rs.i2.r.i2.syms=SYM7%2CSYM7%2CSYM6%2CSYM6%2CSYM5&rs.i2.r.i3.syms=SYM4%2CSYM4%2CSYM8%2CSYM8&rs.i2.r.i4.syms=SYM8%2CSYM8%2CSYM7&";

		if (isset($wildStcks)) $wilds = $wildStcks;
	}
	if ($fs_type == 'wildreels') {
		$output .= "rs.i0.id=basic&";
		$output .= "rs.i1.id=respin&";
		$output .= "rs.i2.id=freespin&";

		$output .= "nextclientrs=wildfeatures&";
		$wildreelsActive = "true";
		$bonusWildreelsDisabled = "true";

		$output .= "rs.i0.r.i0.syms=SYM10%2CSYM0%2CSYM6&";
		$output .= "rs.i0.r.i1.syms=SYM10%2CSYM10%2CSYM0%2CSYM8&";
		$output .= "rs.i0.r.i2.syms=SYM10%2CSYM6%2CSYM6%2CSYM7%2CSYM7&";
		$output .= "rs.i0.r.i3.syms=SYM9%2CSYM6%2CSYM6%2CSYM10&";
		$output .= "rs.i0.r.i4.syms=SYM10%2CSYM10%2CSYM0&";
	}

	if ($fs_type == 'shuffle') {
		$output .= "rs.i0.id=respin&";
		$output .= "rs.i1.id=freespin&";
		$output .= "rs.i2.id=basic&";

		$output .= "nextclientrs=shuffle&";
		$shuffleActive = "true";
		$bonusShuffleDisabled = "true";

		$output .= "rs.i0.r.i0.syms=SYM7%2CSYM7%2CSYM9&";
		$output .= "rs.i0.r.i1.syms=SYM3%2CSYM9%2CSYM9%2CSYM7&";
		$output .= "rs.i0.r.i2.syms=SYM9%2CSYM9%2CSYM0%2CSYM6%2CSYM6&";
		$output .= "rs.i0.r.i3.syms=SYM0%2CSYM7%2CSYM7%2CSYM9&";
		$output .= "rs.i0.r.i4.syms=SYM0%2CSYM5%2CSYM5&";

		$output .= "rs.i1.r.i0.syms=SYM7&";
		$output .= "rs.i1.r.i1.syms=SYM7&";
		$output .= "rs.i1.r.i2.syms=SYM7&";
		$output .= "rs.i1.r.i3.syms=SYM11&";
		$output .= "rs.i1.r.i4.syms=SYM7&";
		$output .= "rs.i1.r.i5.syms=SYM7&";
		$output .= "rs.i1.r.i6.syms=SYM11&";
		$output .= "rs.i1.r.i7.syms=SYM11&";
		$output .= "rs.i1.r.i8.syms=SYM7&";
		$output .= "rs.i1.r.i9.syms=SYM11&";
		$output .= "rs.i1.r.i10.syms=SYM7&";
		$output .= "rs.i1.r.i11.syms=SYM11&";
		$output .= "rs.i1.r.i12.syms=SYM11&";
		$output .= "rs.i1.r.i13.syms=SYM7&";
		$output .= "rs.i1.r.i14.syms=SYM7&";
		$output .= "rs.i1.r.i15.syms=SYM11&";
		$output .= "rs.i1.r.i16.syms=SYM11&";
		$output .= "rs.i1.r.i17.syms=SYM7&";
		$output .= "rs.i1.r.i18.syms=SYM11&";

		$output .= "rs.i2.r.i0.syms=SYM6%2CSYM6%2CSYM7&";
		$output .= "rs.i2.r.i1.syms=SYM4%2CSYM4%2CSYM7%2CSYM7&";
		$output .= "rs.i2.r.i2.syms=SYM7%2CSYM7%2CSYM6%2CSYM6%2CSYM5&";
		$output .= "rs.i2.r.i3.syms=SYM4%2CSYM4%2CSYM8%2CSYM8&";
		$output .= "rs.i2.r.i4.syms=SYM8%2CSYM8%2CSYM7&";
	}

	if ($fs_type == 'randomwilds') {
		$output .= "rs.i0.id=basic&";
		$output .= "rs.i1.id=respin&";
		$output .= "rs.i2.id=freespin&";


		$output .= "nextclientrs=wildfeatures&";
		$randomwildsActive = "true";
		$bonusRandomwildsDisabled = "true";

		$output .= "rs.i0.r.i0.syms=SYM7%2CSYM3%2CSYM3&";
		$output .= "rs.i0.r.i1.syms=SYM6%2CSYM0%2CSYM8%2CSYM8&";
		$output .= "rs.i0.r.i2.syms=SYM8%2CSYM9%2CSYM9%2CSYM0%2CSYM6&";
		$output .= "rs.i0.r.i3.syms=SYM8%2CSYM10%2CSYM10%2CSYM0&";
		$output .= "rs.i0.r.i4.syms=SYM5%2CSYM10%2CSYM10&";
	}

	$output .= "feature.randomwilds.active=$randomwildsActive&";
	$output .= "feature.sticky.active=$stickyActive&";
	$output .= "feature.shuffle.active=$shuffleActive&";
	$output .= "feature.wildreels.active=$wildreelsActive&";

	$gameover = "false";
	$answ .= "rollsleft=$rollsleft;bonuswin=$bonuswin;boardposition=$boardposition;token=$token;fs_type=$fs_type;fs_left=$fs_left;fs_initial=$fs_initial;";

	if ($bonusStickyDisabled == "true") {
		$answ .= "bonusStickyDisabled=$bonusStickyDisabled;";
		$bonusStickyDisabled = "aftertrue";
	}
	if ($bonusWildreelsDisabled == "true") {
		$answ .= "bonusWildreelsDisabled=$bonusWildreelsDisabled;";
		$bonusWildreelsDisabled = "aftertrue";
	}
	if ($bonusShuffleDisabled == "true") {
		$answ .= "bonusShuffleDisabled=$bonusShuffleDisabled;";
		$bonusShuffleDisabled = "aftertrue";
	}
	if ($bonusRandomwildsDisabled == "true") {
		$answ .= "bonusRandomwildsDisabled=$bonusRandomwildsDisabled;";
		$bonusRandomwildsDisabled = "aftertrue";
	}

	$lastAction = "initfreespin";

	$botAction = "freespin";
}





if ($_GET['action'] == "spin" or $_GET['action'] == "freespin" or $_GET['action'] == "shuffle" or $_GET['action'] == "respin") {
	$gameover = "true";
	$overlaySym = "";
	$table_locked = 1;
	$stickyFlag = 0;
	$shuffleFlag = 0;

	if ($lastActionDB == "paytable" and isset($restoreAction)) {
		$lastActionDB = $restoreAction;
		$wildsDB = $wildStcks;
	}

	$hotlines = explode(",", $anBetVarDB);

	$lastAction = "spin";

	if (isset($fs_left) and $fs_left > 0) {
		if ($lastActionDB == "initfreespin" and $_GET['action'] == "freespin") $lastAction = "freespin";
		if ($lastActionDB == "freespin" and $_GET['action'] == "freespin") $lastAction = "freespin";
		if (isset($fs_type) and $fs_type == 'sticky') if ($lastActionDB == "lastrespin" and $_GET['action'] == "freespin") $lastAction = "freespin";
		if (isset($fs_type) and $fs_type == 'wildreels') $lastAction = "wildreels";
		if (isset($fs_type) and $fs_type == 'randomwilds') $lastAction = "randomwilds";
		if (isset($fs_type) and $fs_type == 'shuffle') $lastAction = "shuffle";
	}

	if ($lastActionDB == "shuffle" and $_GET['action'] == "shuffle") {
		$lastAction = "aftershuffle";
	}

	if ($lastActionDB == "sticky" and $_GET['action'] == "respin") {
		$lastAction = "respin";
	}
	if ($lastActionDB == "respin" and $_GET['action'] == "respin") {
		$lastAction = "respin";
	}

	////////////////////
	//symbol generation
	////////////////////

	if (isset($fs_left) and $fs_left > 0) {
		$query = "SELECT * FROM ns.bonuses where payRate='" . $payRate . "' and gameId='" . $gameId . "' order by id asc;";
		if ($lastAction == "freespin" or $lastAction == "wildreels" or $lastAction == "shuffle" or $lastAction == "randomwilds") {
			$fs_left--;
			$fs_played++;
		}
	} else	$query = "SELECT * FROM ns.reels where payRate=" . $payRate . " and gameId=" . $gameId . " order by id asc;";

	$result = mysql_query($query);

	while ($reels = mysql_fetch_assoc($result)) {
		$reel[$reels['id']] = explode("_", $reels['symbols']);
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

	unset($symbols[0][3]);
	unset($symbols[0][4]);
	unset($symbols[1][4]);
	unset($symbols[3][4]);
	unset($symbols[4][3]);
	unset($symbols[4][4]);

	//if($mainTerminalId=='VK532248891')$symbols[0][1]=0;$symbols[1][1]=0;$symbols[2][1]=0;


	if ($lastAction == 'respin') {
		foreach ($symbols as $tReel => $t)
			foreach ($t as $tRow => $e)
				if ($symbols[$tReel][$tRow] == 0) $symbols[$tReel][$tRow] = round(rand(5, 10));
	}

	//if($lastAction=='init')
	//$symbols[0][1]=0;$symbols[1][1]=0;$symbols[2][1]=0;

	$bonusSymbCount = 0;
	foreach ($symbols as $tReel => $t)
		foreach ($t as $tRow => $e) {
			if ($symbols[$tReel][$tRow] == 0) {
				$bonusSymbCount++;
				$bonusReels[$tReel] = $tRow;
			} elseif (!isset($bonusReels[$tReel])) $bonusReels[$tReel] = -1;
		}

	if ($bonusSymbCount > 2) {
		$lastAction = "startbonus";
		$rollsleft += $bonusSymbCount + 3;
	}


	////////////feature selector

	$wildReelsRate = $reel[5][0];
	$randomWildsRate = $reel[5][1];
	$shuffleRate = $reel[5][2];
	$stickyRate = $reel[5][3];





	if ($bonusSymbCount == 0 and !isset($fs_type)) {
		if (rand(0, 1000) < $wildReelsRate and $lastAction == "spin") {
			$lastAction = "wildreels";
		}
		if (rand(0, 1000) < $randomWildsRate and $lastAction == "spin") {
			$lastAction = "randomwilds";
		}
		if (rand(0, 1000) < $shuffleRate and $lastAction == "spin") {
			$shuffleFlag = 1;
		}
		if (rand(0, 1000) < $stickyRate and $lastAction == "spin" and $shuffleFlag != 1) {
			$stickyFlag = 1;
		}
	}


	if ($lastAction != "respin") {
		if ($lastAction != "aftershuffle") {
		} else {
			unset($symbols);

			if (isset($symsLastDB) and $symsLastDB != '') {
				$oldRls = explode('_', $symsLastDB);
				foreach ($oldRls as $oldRlNum => $oldRl) {
					if ($oldRl != '') {
						$oldSyms = explode(',', $oldRl);
						foreach ($oldSyms as $oldSymsNum => $oldSym) {
							if ($oldSym != '') $old_symbols[$oldRlNum][$oldSymsNum] = $oldSym;
						}
					}
				}
			}

			unset($old_symbols[0][3]);
			unset($old_symbols[0][4]);
			unset($old_symbols[1][4]);
			unset($old_symbols[3][4]);
			unset($old_symbols[4][3]);
			unset($old_symbols[4][4]);

			for ($i = 0; $i < 5; $i++)
				for ($j = 0; $j < 5; $j++) {
					if (isset($old_symbols[$i][$j])) {
						$aviableSymbols[$old_symbols[$i][$j]]++;
						$fullTape[] = $old_symbols[$i][$j];
					}
				}

			foreach ($aviableSymbols as $oldRlNum => $oldRl)
				if ($oldRl > 3) {
					$sSym[] = $oldRlNum;
				}

			unset($old_symbols);

			if (isset($sSym)) {
				$shufSym = $sSym[round(rand(0, (count($sSym) - 1)))];
			}

			shuffle($fullTape);

			foreach ($fullTape as $e => $v) {
				if ($v == $shufSym) $partSuffleSyms[] = $v;
				else $partOtherSyms[] = $v;
			}

			$k = count($partSuffleSyms);
			if ($k > 5) $k = 5;
			for ($i = 0; $i < $k; $i++) {
				if ($i == 0) $y[0] = round(rand(0, 2));
				if ($i == 1) $y[1] = round(rand(0, 1)) + $y[0];
				if ($i == 2) $y[2] = round(rand(0, 1)) + $y[1];
				if ($i == 3) $y[3] = round(rand(0, 1)) + $y[0];
				if ($i == 4) $y[4] = round(rand(0, 2));

				$old_symbols[$i][$y[$i]] = $shufSym;
				array_pop($partSuffleSyms);
			}

			for ($i = 0; $i < 5; $i++) {
				for ($j = 0; $j < 5; $j++) {
					if (($i == 0 or $i == 4) and ($j == 3 or $j == 4)) continue;
					if (($i == 1 or $i == 3) and $j == 4) continue;
					if (!isset($old_symbols[$i][$j])) {
						if (!empty($partOtherSyms)) $old_symbols[$i][$j] = array_pop($partOtherSyms);
						else $old_symbols[$i][$j] = array_pop($partSuffleSyms);
					}
				}
			}

			$symbols = $old_symbols;
		}
	}

	include($gamePath . 'lines.php');

	if ($lastAction == "sticky" or $lastAction == "respin") {
		unset($win);
	}

	//////////
	//draw rs
	//////////

	$wild = 0;
	$wildStr = '';
	$nearwin = 0;

	$anim_num = 0;
	$allSymbs = 0;

	for ($i = 0; $i < 5; $i++) {
		$k = 0;
		$l = ''; {
			if ($i == 0 or $i == 4) $k = 0;
			elseif ($i == 1 or $i == 3) $k = 1;
			else $k = 2;
			$k += 3;
			if ($lastAction != 'respin' and $lastAction != 'lastrespin')	$lastRs .= "rs.i0.r.i" . $i . ".syms=";


			for ($j = 0; $j < $k; $j++) {
				if ($lastAction != 'respin' and $lastAction != 'lastrespin') {
					if ($symbols[$i][$j] == $overlaySym and $symbolsOverlayed[$i][$j] != $overlaySym) {
						$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".with=SYM" . $overlaySym . "&";
						$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".row=" . $j . "&";
						$anim_num++;
					}
				}

				if ($lastAction != 'respin' and $lastAction != 'lastrespin') {
					if (($i == 0 or $i == 4) and $j == 2)	$lastRs .= "SYM" . $symbolsOverlayed[$i][$j] . "&";
					elseif (($i == 1 or $i == 3) and $j == 3) $lastRs .= "SYM" . $symbolsOverlayed[$i][$j] . "&";
					elseif ($i == 2 and $j == 4) $lastRs .= "SYM" . $symbolsOverlayed[$i][$j] . "&";
					else $lastRs .= "SYM" . $symbolsOverlayed[$i][$j] . ",";
				} else {
					if (($i == 0 or $i == 4) and $j == 2) {
						$lastRs .= "rs.i0.r.i" . $allSymbs . ".syms=SYM" . $symbolsOverlayed[$i][$j] . "&";
						$allSymbs++;
					} elseif (($i == 1 or $i == 3) and $j == 3) {
						$lastRs .= "rs.i0.r.i" . $allSymbs . ".syms=SYM" . $symbolsOverlayed[$i][$j] . "&";
						$allSymbs++;
					} elseif ($i == 2 and $j == 4) {
						$lastRs .= "rs.i0.r.i" . $allSymbs . ".syms=SYM" . $symbolsOverlayed[$i][$j] . "&";
						$allSymbs++;
					} else {
						$lastRs .= "rs.i0.r.i" . $allSymbs . ".syms=SYM" . $symbolsOverlayed[$i][$j] . "&";
						$allSymbs++;
					}
				}
			}
			$anim_num = 0;
		}

		if ($lastAction != 'respin' and $lastAction != 'lastrespin')	$output .= "rs.i0.r.i" . $i . ".hold=false&";


		if ($bonusSymbCount > 1) {
			if ($bonusReels[$i] != -1) {
				$output .= "rs.i0.r.i" . $i . ".attention.i0=" . $bonusReels[$i] . "&";
				$nearwin++;
			}
		}
		if ($bonusSymbCount > 1 and $nearwin > 2) {
			if ($lastAction == 'startbonus') {
				$output .= "rs.i0.nearwin=$i&";
				$nearwin = -5;
			}
		}
	}

	if ($lastAction != 'startbonus' and $bonusSymbCount > 1 and $bonusReels[4] == -1)	$output .= "rs.i0.nearwin=4&";

	if ($lastAction == 'respin' or $lastAction == 'lastrespin') {
		$allSymbs = 0;
		$oldRls = explode(',', $wilds);
		foreach ($oldRls as $oldRlNum => $oldRl) {
			if ($oldRl != '') {
				$oldSyms = explode(':', $oldRl);
				if ($oldSyms[0] == 0) $allSymbs = 0;
				if ($oldSyms[0] == 1) $allSymbs = 3;
				if ($oldSyms[0] == 2) $allSymbs = 7;
				if ($oldSyms[0] == 3) $allSymbs = 12;
				if ($oldSyms[0] == 4) $allSymbs = 16;
				$allSymbs += $oldSyms[1];

				$output .= "rs.i0.r.i" . $allSymbs . ".overlay.i0.with=SYM1&";

				if ($fs_type == 'sticky' and $lastAction == 'lastrespin')	$output .= "rs.i0.r.i" . $allSymbs . ".overlay.i0.row=0&";
				else 		$output .= "rs.i0.r.i" . $allSymbs . ".overlay.i0.row=1&";
			}
		}
		$allSymbs = 0;
		$oldRls = explode(',', $stickyPositionsDB);
		foreach ($oldRls as $oldRlNum => $oldRl) {
			if ($oldRl != '') {
				$oldSyms = explode(':', $oldRl);
				if ($oldSyms[0] == 0) $allSymbs = 0;
				if ($oldSyms[0] == 1) $allSymbs = 3;
				if ($oldSyms[0] == 2) $allSymbs = 7;
				if ($oldSyms[0] == 3) $allSymbs = 12;
				if ($oldSyms[0] == 4) $allSymbs = 16;
				$allSymbs += $oldSyms[1];

				$output .= "rs.i0.r.i" . $allSymbs . ".overlay.i0.with=SYM" . $symbolsOverlayed[$oldSyms[0]][$oldSyms[1]] . "&";
				$output .= "rs.i0.r.i" . $allSymbs . ".overlay.i0.row=0&";
			}
		}
	}

	$output .= $lastRs;


	if (isset($fs_left) and $fs_left >= 0) {
		if ($fs_type == 'wildreels') $lastAction = "freespin";
		if ($fs_type == 'randomwilds') $lastAction = "freespin";
	}

	/////////////////////////////
	//draw ws			
	///////////////////////////
	$anim_num = 0;
	$total_win = 0;
	$temp = 0;

	if ($lastAction == 'startbonus') {
		$output .= "ws.i0.types.i0.bonusid=alan-bonus&";
		$output .= "ws.i0.types.i0.wintype=bonusgame&";
		$output .= "ws.i0.reelset=basic&";
		$output .= "ws.i0.betline=null&";
		$output .= "ws.i0.direction=none&";
		$output .= "ws.i0.sym=SYM0&";

		foreach ($bonusReels as $e => $v)
			if ($v != -1) {
				$output .= "ws.i0.pos.i" . $temp . "=" . $e . "%2C" . $v . "&";
				$temp++;
			}
		$anim_num = 1;
	}

	foreach ($win as $e => $v) {
		$tmp = explode("_", $v);

		if ($lastAction == 'respin' or $lastAction == 'lastrespin') {
			$output .= "ws.i" . $anim_num . ".reelset=freespin&";
		} elseif (isset($fs_left)) $output .= "ws.i" . $anim_num . ".reelset=respin&";
		else
			$output .= "ws.i" . $anim_num . ".reelset=basic&";

		if (!isset($fs_left))
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


	if (isset($fs_type)) {
		$fs_totalwin += $total_win;
		$bonuswin += $total_win;
	}

	if ($lastAction == "freespin") {
		$fs_total = $fs_played + $fs_left;

		$output .= "rs.i0.id=freespin&";
		$output .= "previous.rs.i0=freespin&";

		$output .= "bonus.rollsleft=$rollsleft&";
		$output .= "bonus.token=$token&";
		$output .= "bonus.board.position=$boardposition&";
		$output .= "nextactiontype=roll&";

		$output .= "bonusgame.coinvalue=0.01&";
		$output .= "bonuswin.coins=0&";
		$output .= "bonuswin.cents=0&";

		if ($fs_type == 'sticky') ///?????????????
		{
			if ($wilds != '')
				$output .= "feature.sticky.wildpositions=" . $wilds . "&";
			$output .= "feature.sticky.positions=" . $stickyPositions . "&";

			$output .= "clientaction=freespin&";

			if ($nextAction == 'freespin') {
				$output .= "current.rs.i0=freespin&";
				$output .= "nextclientrs=stickyfsb&";
				$output .= "next.rs=freespin&";
				$output .= "feature.sticky.respin=false&";

				if ($fs_left > 0) {
					$output .= "nextaction=freespin&";
					$botAction = "freespin";
				} else {
					if ($rollsleft <= 0) {
						$botAction = "endbonus";
						$output .= "nextaction=endbonus&";
					} else {
						$botAction = "bonusaction";
						$output .= "nextaction=spin&";
					}
				}
			} else {
				$output .= "current.rs.i0=respin&";
				$output .= "nextclientrs=respina&";
				$output .= "nextaction=respin&";
				$output .= "next.rs=respin&";
				$output .= "feature.sticky.respin=true&";

				$botAction = "respin";
			}

			$output .= "last.rs=freespin&";

			$output .= "gamestate.current=freespin&";

			$stickyActive = "true";
			$gameover = "false";
		}

		if ($fs_type == 'wildreels') {
			if ($fs_left > 0) {
				$output .= "nextaction=freespin&";
				$botAction = "freespin";
			} else {
				if ($rollsleft <= 0) {
					$botAction = "endbonus";
					$output .= "nextaction=endbonus&";
				} else {
					$botAction = "bonusaction";
					$output .= "nextaction=spin&";
				}
			}
			if ($fs_left > 0) {
				$output .= "nextclientrs=wildfeatures&";

				$output .= "current.rs.i0=freespin&";
				$output .= "next.rs=freespin&";
				$output .= "clientaction=freespin&";
				//	$output.="nextaction=freespin&";
				$output .= "last.rs=freespin&";

				$output .= "gamestate.current=freespin&";

				$wildreelsActive = "true";
				$gameover = "false";
			} elseif ($fs_left == 0) {
				$output .= "nextclientrs=wildfeatures&";

				$output .= "current.rs.i0=freespin&";
				$output .= "next.rs=freespin&";
				$output .= "clientaction=freespin&";

				$output .= "last.rs=freespin&";
				$output .= "previous.rs.i0=freespin&";

				$output .= "gamestate.current=bonus&";

				$wildreelsActive = "true";
				$gameover = "false";
			}
		}

		if ($fs_type == 'randomwilds') {
			if ($fs_left > 0) {
				$output .= "nextaction=freespin&";
				$botAction = "freespin";
			} else {
				if ($rollsleft <= 0) {
					$botAction = "endbonus";
					$output .= "nextaction=endbonus&";
				} else {
					$botAction = "bonusaction";
					$output .= "nextaction=spin&";
				}
			}

			if ($fs_left > 0) {
				$output = $output . "feature.randomwilds.positions=" . $wilds . "&";
				$output .= "nextclientrs=wildfeatures&";

				$output .= "current.rs.i0=freespin&";
				$output .= "next.rs=freespin&";
				$output .= "clientaction=freespin&";
				$output .= "last.rs=freespin&";

				$output .= "gamestate.current=freespin&";

				$randomwildsActive = "true";
				$gameover = "false";
			} elseif ($fs_left == 0) {
				$output = $output . "feature.randomwilds.positions=" . $wilds . "&";
				$output .= "nextclientrs=wildfeatures&";

				$output .= "current.rs.i0=freespin&";
				$output .= "next.rs=freespin&";
				$output .= "clientaction=freespin&";

				$output .= "last.rs=freespin&";
				$output .= "previous.rs.i0=freespin&";

				$output .= "gamestate.current=bonus&";

				$randomwildsActive = "true";
				$gameover = "false";
			}
		}
		$output .= "gamestate.bonusid=alan-bonus&";
		$output .= "gamestate.stack=basic%2Cfreespin&";

		$output .= "gamestate.history=basic%2Cbonus%2Cfreespin&";

		$output .= "freespins.initial=$fs_initial&";
		$output .= "freespins.total=$fs_total&";
		$output .= "freespins.left=" . $fs_left . "&";

		$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C21%2C22%2C23%2C24%2C25%2C26%2C27%2C28%2C29%2C30%2C31%2C32%2C33%2C34%2C35&";
		$output .= "freespins.betlevel=1&";
		$output .= "freespins.denomination=1.000&";
		$output .= "freespins.wavecount=1&";
		$output .= "freespins.multiplier=1&";

		$output .= "freespins.win.cents=$fs_totalwin&";
		$output .= "freespins.win.coins=$fs_totalwin&";
		$output .= "freespins.totalwin.cents=$fs_totalwin&";
		$output .= "freespins.totalwin.coins=$fs_totalwin&";

		$output .= "totalbonuswin.cents=$bonuswin&";
		$output .= "totalbonuswin.coins=$bonuswin&";
	} elseif ($lastAction == "startbonus") {
		$output .= "rs.i0.id=basic&";
		$output .= "nextclientrs=basic&";
		$output .= "clientaction=spin&";
		$output .= "nextaction=bonusaction&";
		$output .= "nextactiontype=selecttoken&";

		$output .= "gamestate.stack=basic%2Cbonus&";
		$output .= "gamestate.history=basic&";
		//    $output.="gamestate.current=bonus&";
		$output .= "gamestate.current=basic&";
		$output .= "gamestate.bonusid=alan-bonus&";

		$output .= "bonus.rollsleft=" . $rollsleft . "&";
		$output .= "bonus.board.position=0&";

		$answ .= "rollsleft=$rollsleft;";

		$botAction = "initbonus";
	} elseif ($lastAction == "aftershuffle") {

		if (isset($fs_left) and $fs_left > 0) {
			$fs_total = $fs_played + $fs_left;

			$output .= "rs.i0.id=freespin&";
			$output .= "current.rs.i0=freespin&";
			$output .= "next.rs=freespin&";
			$output .= "clientaction=shuffle&";
			$output .= "nextaction=freespin&";
			$output .= "last.rs=freespin&";
			$output .= "previous.rs.i0=freespin&";
			$output .= "nextclientrs=shuffle&";

			$output .= "gamestate.history=basic%2Cbonus%2Cfreespin&";
			$output .= "gamestate.current=freespin&";
			$output .= "gamestate.stack=basic%2Cfreespin&";
			$output .= "gamestate.bonusid=alan-bonus&";

			$output .= "bonus.rollsleft=$rollsleft&";
			$output .= "bonus.token=$token&";
			$output .= "bonus.board.position=$boardposition&";
			$output .= "nextactiontype=roll&";

			$output .= "freespins.initial=$fs_initial&";
			$output .= "freespins.total=$fs_total&";
			$output .= "freespins.left=$fs_left&";

			$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C21%2C22%2C23%2C24%2C25%2C26%2C27%2C28%2C29%2C30%2C31%2C32%2C33%2C34%2C35&";
			$output .= "freespins.betlevel=1&";
			$output .= "freespins.denomination=1.000&";
			$output .= "freespins.wavecount=1&";
			$output .= "freespins.multiplier=1&";

			$output .= "freespins.win.cents=$fs_totalwin&";
			$output .= "freespins.win.coins=$fs_totalwin&";
			$output .= "freespins.totalwin.cents=$fs_totalwin&";
			$output .= "freespins.totalwin.coins=$fs_totalwin&";

			$gameover = "false";

			$botAction = "freespin";
		} elseif (isset($fs_left) and $fs_left == 0) {
			$output .= "rs.i0.id=freespin&";
			$output .= "current.rs.i0=freespin&";
			$output .= "next.rs=freespin&";
			$output .= "clientaction=shuffle&";

			if ($rollsleft <= 0) {
				$output .= "nextaction=endbonus&";
				$botAction = "endbonus";
			} else {
				$output .= "nextaction=spin&";
				$botAction = "bonusaction";
			}

			$output .= "last.rs=freespin&";
			$output .= "previous.rs.i0=shuffle&";
			$output .= "nextclientrs=shuffle&";

			$output .= "gamestate.history=basic%2Cbonus%2Cfreespin&";
			$output .= "gamestate.current=bonus&";
			$output .= "gamestate.stack=basic%2Cfreespin%2Cbonus&";
			$output .= "gamestate.bonusid=alan-bonus&";

			$output .= "bonus.rollsleft=$rollsleft&";
			$output .= "bonus.token=$token&";
			$output .= "bonus.board.position=$boardposition&";
			$output .= "nextactiontype=roll&";
			$output .= "bonus.feature.disabled=stickywin&";

			$gameover = "false";
		} else {
			$output .= "rs.i0.id=basic&";
			$output .= "current.rs.i0=basic&";

			$output .= "gamestate.history=basic&";
			$output .= "gamestate.current=basic&";
			$output .= "gamestate.stack=basic&";

			$output .= "clientaction=shuffle&";
			$output .= "nextaction=spin&";
			$output .= "next.rs=basic&";

			$botAction = "spin";

			$table_locked = 0;
		}

		$shuffleActive = "true";
	} elseif ($lastAction == "shuffle") {
		$fs_total = $fs_played + $fs_left;

		$output .= "nextclientrs=shuffle&";

		$output .= "rs.i0.id=basic&";
		$output .= "clientaction=spin&";
		$output .= "nextaction=shuffle&";
		$output .= "gamestate.history=basic&gamestate.current=basic&gamestate.stack=basic&";

		$shuffleActive = "true";
		$gameover = "false";

		$botAction = "shuffle";
	} elseif ($lastAction == "randomwilds") {
		$output = $output . "feature.randomwilds.positions=" . $wilds . "&";

		$output .= "rs.i0.id=basic&";
		$output .= "nextclientrs=basic&";
		$output .= "clientaction=spin&";
		$output .= "nextaction=spin&";
		$output .= "gamestate.history=basic&gamestate.current=basic&gamestate.stack=basic&";

		$randomwildsActive = "true";
		$table_locked = 0;

		$botAction = "spin";
	} elseif ($lastAction == "sticky") {
		/*
	if($wilds!='')
	$output.="feature.sticky.wildpositions=".$wilds."&";

	$output.="feature.sticky.positions=".$stickyPositions."&";
*/
		if ($wilds != '') {
			$output .= "feature.sticky.wildpositions=" . $wilds . "&";
			$stickyPositionsOut = $stickyPositions . "," . $wilds;
		} else
			$stickyPositionsOut = $stickyPositions;

		$output .= "feature.sticky.positions=" . $stickyPositionsOut . "&";

		$output .= "nextclientrs=respinb&";

		$output .= "rs.i0.id=basic&";
		$output .= "current.rs.i0=respin&";
		$output .= "next.rs=respin&";
		$output .= "clientaction=spin&";

		$output .= "nextaction=respin&";

		$output .= "gamestate.history=basic&";
		$output .= "gamestate.current=basic&";
		$output .= "gamestate.stack=basic&";

		$stickyActive = "true";
		$gameover = "false";

		$botAction = "respin";
	} elseif ($lastAction == "respin") {
		if ($wilds != '') {
			$output .= "feature.sticky.wildpositions=" . $wilds . "&";
			$stickyPositionsOut = $stickyPositions . "," . $wilds;
		} else
			$stickyPositionsOut = $stickyPositions;

		$output .= "feature.sticky.positions=" . $stickyPositionsOut . "&";

		$output .= "nextclientrs=respina&";
		$output .= "feature.sticky.respin=true&";

		$output .= "rs.i0.id=respin&";
		$output .= "current.rs.i0=respin&";
		$output .= "next.rs=respin&";
		$output .= "clientaction=respin&";
		$output .= "nextaction=respin&";

		$output .= "last.rs=respin&";
		$output .= "previous.rs.i0=respin&";


		$output .= "gamestate.history=basic&";
		$output .= "gamestate.current=basic&";
		$output .= "gamestate.stack=basic&";

		if (isset($fs_left)) {
			$output .= "freespins.initial=$fs_initial&";
			$output .= "freespins.total=$fs_total&";
			$output .= "freespins.left=$fs_left&";

			$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C21%2C22%2C23%2C24%2C25%2C26%2C27%2C28%2C29%2C30%2C31%2C32%2C33%2C34%2C35&";
			$output .= "freespins.betlevel=1&";
			$output .= "freespins.denomination=1.000&";
			$output .= "freespins.wavecount=1&";
			$output .= "freespins.multiplier=1&";

			$output .= "freespins.win.cents=$fs_totalwin&";
			$output .= "freespins.win.coins=$fs_totalwin&";
			$output .= "freespins.totalwin.cents=$fs_totalwin&";
			$output .= "freespins.totalwin.coins=$fs_totalwin&";
		}

		$stickyActive = "true";
		$gameover = "false";

		$botAction = "respin";
	} elseif ($lastAction == "lastrespin") {
		//	$output.="feature.sticky.positions=".$stickyPositions."&";

		if (isset($fs_left) and $fs_left > 0) {
			if ($wilds != '')
				$output .= "feature.sticky.wildpositions=" . $wilds . "&";

			$output .= "nextclientrs=stickyfsa&";
			$output .= "feature.sticky.respin=false&";

			$output .= "rs.i0.id=respin&";
			$output .= "current.rs.i0=freespin&";
			$output .= "next.rs=freespin&";
			$output .= "clientaction=respin&";
			$output .= "nextaction=freespin&";

			$output .= "last.rs=respin&";
			$output .= "previous.rs.i0=respin&";

			$output .= "gamestate.history=basic%2Cbonus%2Cfreespin&";
			$output .= "gamestate.current=freespin&";
			$output .= "gamestate.stack=basic%2Cfreespin&";
			$output .= "gamestate.bonusid=alan-bonus&";

			$output .= "bonus.rollsleft=$rollsleft&";
			$output .= "bonus.token=$token&";
			$output .= "bonus.board.position=$boardposition&";
			$output .= "nextactiontype=roll&";

			$output .= "freespins.initial=$fs_initial&";
			$output .= "freespins.total=$fs_total&";
			$output .= "freespins.left=$fs_left&";

			$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C21%2C22%2C23%2C24%2C25%2C26%2C27%2C28%2C29%2C30%2C31%2C32%2C33%2C34%2C35&";
			$output .= "freespins.betlevel=1&";
			$output .= "freespins.denomination=1.000&";
			$output .= "freespins.wavecount=1&";
			$output .= "freespins.multiplier=1&";

			$output .= "freespins.win.cents=$fs_totalwin&";
			$output .= "freespins.win.coins=$fs_totalwin&";
			$output .= "freespins.totalwin.cents=$fs_totalwin&";
			$output .= "freespins.totalwin.coins=$fs_totalwin&";

			$botAction = "freespin";

			$gameover = "false";
		} elseif (isset($fs_left) and $fs_left == 0) {
			$output .= "nextclientrs=basic&";
			$output .= "feature.sticky.respin=false&";
			$output .= "rs.i0.id=respin&";
			$output .= "current.rs.i0=respin&";
			$output .= "next.rs=respin&";
			$output .= "clientaction=respin&";
			//	$output.="nextaction=bonusaction&";

			if ($rollsleft <= 0) {
				$output .= "nextaction=endbonus&";
				$botAction = "endbonus";
			} else {
				$output .= "nextaction=spin&";
				$botAction = "bonusaction";
			}

			$output .= "last.rs=respin&";
			$output .= "previous.rs.i0=respin&";

			$output .= "gamestate.history=basic%2Cbonus%2Cfreespin&";
			$output .= "gamestate.current=bonus&";
			$output .= "gamestate.stack=basic%2Cfreespin%2Cbonus&";
			$output .= "gamestate.bonusid=alan-bonus&";

			$output .= "bonus.rollsleft=$rollsleft&";
			$output .= "bonus.token=$token&";
			$output .= "bonus.board.position=$boardposition&";
			$output .= "nextactiontype=roll&";
			$output .= "bonus.feature.disabled=stickywin&";

			$gameover = "false";
		} else {
			if ($wilds != '')
				$output .= "feature.sticky.wildpositions=" . $wilds . "&";

			$output .= "nextclientrs=basic&"; //
			$output .= "feature.sticky.respin=false&";

			$output .= "rs.i0.id=respin&"; //
			$output .= "current.rs.i0=basic&"; //
			$output .= "next.rs=basic&"; //
			$output .= "clientaction=respin&"; //
			$output .= "nextaction=spin&";

			$output .= "last.rs=respin&";
			$output .= "previous.rs.i0=respin&"; //

			$output .= "gamestate.history=basic&";
			$output .= "gamestate.current=basic&";
			$output .= "gamestate.stack=basic&";

			$botAction = "spin";

			$table_locked = 0;
		}

		$stickyActive = "true";
	} elseif ($lastAction == "wildreels") { {
			$output .= "rs.i0.id=basic&";
			$output .= "current.rs.i0=basic&";
			$output .= "next.rs=basic&";
			$output .= "nextclientrs=basic&";
			$output .= "clientaction=spin&";
			$output .= "nextaction=spin&";
			$output .= "gamestate.history=basic&gamestate.current=basic&gamestate.stack=basic&";
		}

		$table_locked = 0;
		$wildreelsActive = "true";
		$botAction = "spin";
	} else {
		$output .= "rs.i0.id=basic&";
		$output .= "current.rs.i0=basic&";

		$output .= "next.rs=basic&";

		$output .= "gamestate.current=basic&";
		$output .= "gamestate.stack=basic&";
		$output .= "gamestate.history=basic&";
		$output .= "clientaction=spin&";
		$output .= "nextaction=spin&";

		$table_locked = 0;
		$botAction = "spin";
	}

	$output .= "feature.randomwilds.active=$randomwildsActive&";
	$output .= "feature.sticky.active=$stickyActive&";
	$output .= "feature.shuffle.active=$shuffleActive&";
	$output .= "feature.wildreels.active=$wildreelsActive&";


	$spincost = 0;
	if ($lastAction != 'initfreespin' and $lastAction != 'freespin' and $lastAction != 'endfreespin' and $lastAction != 'shuffle' and $lastAction != 'respin' and $lastAction != 'lastrespin') {
		$spin_to_history = 1;
		$spincost = $betDB * $denomDB * 0.1;
	}

	if (($lastAction == 'aftershuffle' or $lastAction == 'sticky') and isset($fs_type)) {
		$spin_to_history = 0;
		$spincost = 0;
	}


	$credit /= 100;

	$real_win = $total_win * $denomDB * 0.01;

	if (isset($freeRoundsLeft)) $spincost = 0;
	$credit -= $spincost;

	$credit += $real_win;

	$creditDB = $credit * 100;

	$credit *= 100;

	$totalWinsDB = $total_win;

	$answ .= "symsLastDB=" . $symsLast2DB . ";";
	$answ .= "respinNum=$respinNum;";
	$answ .= "stickyPositionsDB=$stickyPositions;";
}

if ($lastAction == "sticky" or $lastAction == "respin")    $answ .= "remapsDB=$remaps;";

if (isset($fs_left)) {
	if ($lastAction == "sticky") {
		if ($fs_left >= 0) {
			$answ .= "fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";fs_multiplier=" . $fs_multiplier . ";fs_initial=" . $fs_initial . ";";
			$answ .= "rollsleft=$rollsleft;bonuswin=$bonuswin;boardposition=$boardposition;token=$token;fs_type=$fs_type;";
			$answ .= "remapsDB=$remaps;";
			$symb_combs .= "win=" . $fs_totalwin . ";ftype=" . $fs_type . ";fspins=" . $fs_played . ";remain=" . $fs_left . ";" . $symb_combs;
		}
	}

	if ($lastAction == "freespin") {
		if ($fs_left >= 0) {
			$answ .= "fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";fs_multiplier=" . $fs_multiplier . ";fs_initial=" . $fs_initial . ";";
			$answ .= "rollsleft=$rollsleft;bonuswin=$bonuswin;boardposition=$boardposition;token=$token;fs_type=$fs_type;";
		}
		$symb_combs .= "win=" . $fs_totalwin . ";ftype=" . $fs_type . ";fspins=" . $fs_played . ";remain=" . $fs_left . ";" . $symb_combs;
	}


	if ($lastAction == "respin") {
		if ($fs_left >= 0) {
			$answ .= "fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";fs_multiplier=" . $fs_multiplier . ";fs_initial=" . $fs_initial . ";";
			$answ .= "rollsleft=$rollsleft;bonuswin=$bonuswin;boardposition=$boardposition;token=$token;fs_type=$fs_type;";
			$answ .= "remapsDB=$remaps;";
		}
		$symb_combs .= "wilds=" . $wilds . ";" . $symb_combs;
	}
	if ($lastAction == "lastrespin") {
		if ($fs_left > 0) {
			$answ .= "fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";fs_multiplier=" . $fs_multiplier . ";fs_initial=" . $fs_initial . ";";
			$answ .= "rollsleft=$rollsleft;bonuswin=$bonuswin;boardposition=$boardposition;token=$token;fs_type=$fs_type;";
		} elseif ($fs_left == 0) $answ .= "rollsleft=$rollsleft;bonuswin=$bonuswin;boardposition=$boardposition;token=$token;";
		$symb_combs .= "wilds=" . $wilds . ";ftype=" . $fs_type . ";" . $symb_combs;
	}

	if ($lastAction == "wildreels" or $lastAction == "randomwilds") {
		if ($fs_left > 0) {
			$answ .= "fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";fs_multiplier=" . $fs_multiplier . ";fs_initial=" . $fs_initial . ";";
			$answ .= "rollsleft=$rollsleft;bonuswin=$bonuswin;boardposition=$boardposition;token=$token;fs_type=$fs_type;";
		} elseif ($fs_left == 0) $answ .= "rollsleft=$rollsleft;bonuswin=$bonuswin;boardposition=$boardposition;token=$token;";
		$symb_combs .= "wilds=" . $wilds . ";ftype=" . $fs_type . ";" . $symb_combs;
	}

	if ($lastAction == "aftershuffle") {
		if ($fs_left > 0) {
			$answ .= "fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";fs_multiplier=" . $fs_multiplier . ";fs_initial=" . $fs_initial . ";";
			$answ .= "rollsleft=$rollsleft;bonuswin=$bonuswin;boardposition=$boardposition;token=$token;fs_type=$fs_type;";
		} elseif ($fs_left == 0) $answ .= "rollsleft=$rollsleft;bonuswin=$bonuswin;boardposition=$boardposition;token=$token;";
		$symb_combs .= "wilds=" . $wilds . ";ftype=" . $fs_type . ";" . $symb_combs;
	}

	if ($lastAction == "shuffle") {
		if ($fs_left >= 0) {
			$answ .= "fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";fs_multiplier=" . $fs_multiplier . ";fs_initial=" . $fs_initial . ";";
			$answ .= "rollsleft=$rollsleft;bonuswin=$bonuswin;boardposition=$boardposition;token=$token;fs_type=$fs_type;";
		}
		$symb_combs .= "wilds=" . $wilds . ";ftype=" . $fs_type . ";" . $symb_combs;
	}
	if ($bonusStickyDisabled == "true") {
		$answ .= "bonusStickyDisabled=$bonusStickyDisabled;";
		$bonusStickyDisabled = "aftertrue";
	}
	if ($bonusWildreelsDisabled == "true") {
		$answ .= "bonusWildreelsDisabled=$bonusWildreelsDisabled;";
		$bonusWildreelsDisabled = "aftertrue";
	}
	if ($bonusShuffleDisabled == "true") {
		$answ .= "bonusShuffleDisabled=$bonusShuffleDisabled;";
		$bonusShuffleDisabled = "aftertrue";
	}
	if ($bonusRandomwildsDisabled == "true") {
		$answ .= "bonusRandomwildsDisabled=$bonusRandomwildsDisabled;";
		$bonusRandomwildsDisabled = "aftertrue";
	}
}

$disabledFeatures = '';

if ($bonusStickyDisabled == "true" or $bonusStickyDisabled == "aftertrue")		if ($disabledFeatures == '') $disabledFeatures = "stickywin";
else $disabledFeatures .= ",stickywin";
if ($bonusWildreelsDisabled == "true" or $bonusWildreelsDisabled == "aftertrue")		if ($disabledFeatures == '') $disabledFeatures = "wildreels";
else $disabledFeatures .= ",wildreels";
if ($bonusShuffleDisabled == "true" or $bonusShuffleDisabled == "aftertrue")		if ($disabledFeatures == '') $disabledFeatures = "shuffle";
else $disabledFeatures .= ",shuffle";
if ($bonusRandomwildsDisabled == "true" or $bonusRandomwildsDisabled == "aftertrue")	if ($disabledFeatures == '') $disabledFeatures = "randomwilds";
else $disabledFeatures .= ",randomwilds";

if ($disabledFeatures != '' and $lastAction == 'bonusaction') $output .= "bonus.feature.disabled=$disabledFeatures&";

if ($botAction == 'endbonus' or $botAction == 'bonusaction') $symb_combs .= "rollsleft=$rollsleft;" . $symb_combs;

if (isset($fs_type) and $fs_type != 'none' and $fs_type != 'none') $symb_combs .= "ftype=" . $fs_type . ";win=" . $fs_totalwin . ";fspins=" . $fs_played . ";remain=" . $fs_left . ";" . $symb_combs;



////widget
if (isset($freeRoundsLeft) and $freeRoundsLeft > 0 and $lastAction != 'init' and $lastAction != 'paytable' and $lastAction != 'widgetspin') {
	if (
		$lastAction == "spin" or $lastAction == "startbonus" or
		($lastAction == "aftershuffle" and $ftype != "shuffle") or
		($lastAction == "lastrespin" and $ftype != "sticky") or
		($lastAction == "randomwilds" and $ftype != "randomwilds") or
		($lastAction == "wildreels" and $ftype != "wildreels")
	) {
		$freeRoundsLeft--;
		$output .= "freeRoundsLeft=$freeRoundsLeft&";
		$output .= "gameroundid=$freeRoundsLeft&";
	}
	$freeRoundsWin += $real_win * 100;

	if ($freeRoundsLeft == 0) {
		if ($lastAction != 'endfreespin' or $lastAction != 'spin' or $lastAction == 'endbonus') {
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
