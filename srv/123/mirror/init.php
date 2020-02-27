<?
$totalWinsDB = 0;
$total_win = 0;

$table_locked = 0;
$gsStack = "basic";
$gsCur = "basic";
$nesxAct = "spin";

$restore = "false";


if ($lastActionDB == "bonus_feature_pick") {
	$restore = "true";
	$gameover = "false";

	$gsStack = "basic%2Cbonus_feature_pick";
	$gsCur = "bonus_feature_pick";
	$nesxAct = "bonus_feature_pick";

	$answ = "restoreAction=bonus_feature_pick;";

	$output .= "rs.i0.nearwin=4&";

	$output .= "bws.i0.pos.i0=0%2C0&";
	$output .= "bws.i0.pos.i1=2%2C0&";
	$output .= "bws.i0.pos.i2=4%2C0&";

	$output .= "current.rs.i0=basic&";
	$output .= "next.rs=basic&";
	$output .= "gamestate.history=basic&";

	$table_locked = 1;

	$output .= "rs.i1.r.i0.syms=SYM0%2CSYM10%2CSYM9&";
	$output .= "rs.i1.r.i1.syms=SYM8%2CSYM13%2CSYM4&";
	$output .= "rs.i1.r.i2.syms=SYM0%2CSYM6%2CSYM8&";
	$output .= "rs.i1.r.i3.syms=SYM3%2CSYM3%2CSYM11&";
	$output .= "rs.i1.r.i4.syms=SYM0%2CSYM5%2CSYM8&";
} else {
	$output .= "rs.i1.r.i0.syms=SYM8%2CSYM0%2CSYM9&";
	$output .= "rs.i1.r.i1.syms=SYM8%2CSYM13%2CSYM4&";
	$output .= "rs.i1.r.i2.syms=SYM12%2CSYM6%2CSYM8&";
	$output .= "rs.i1.r.i3.syms=SYM3%2CSYM3%2CSYM11&";
	$output .= "rs.i1.r.i4.syms=SYM8%2CSYM5%2CSYM8&";
}

if ($lastActionDB == "bonusgame" or $lastActionDB == "bonusaction") {
	$bonusInfo = explode(";", $answer);
	foreach ($bonusInfo as $e => $v)
		if ($v != '') {
			$a = explode("=", $v);
			$$a[0] = $a[1];
		}

	$gameover = "false";
	$restore = "true";

	$totalWinsDB = $bonus_totalwin;
	$total_win = $bonus_totalwin * $denomDB;

	if ($type != "start") {
		///////////

		if ($pickaxes > 0) {
			$nesxAct = "bonusaction";
			$output .= "gamestate.history=basic%2Cbonus_feature_pick%2Cbonus&";
			$wildsDB = '';

			$j = 0;
			$k = 0;
			for ($i = 0; $i < 9; $i++) {
				$valInDB = "item" . $i;
				if (isset($$valInDB)) {
					$output .= "picked_items.i" . $j . ".itemId=" . substr($valInDB, 4) . "&";
					$output .= "picked_items.i" . $j . ".itemValue=" . ($$valInDB / 10 / $betDB) . "&";
					$j++;
				}
			}
		}

		///////////
		$output .= "clientaction=bonusaction&";

		$nesxAct = "bonusaction";
	} else {
		$nesxAct = "bonusaction";
		$output .= "gamestate.history=basic%2Cbonus_feature_pick&";
		$output .= "clientaction=bonus_feature_pick&";
		$wildsDB = '';
	}

	$output .= "bonusgame.coinvalue=0.01&";
	$output .= "rs.i0.id=basic&";
	$output .= "nextactiontype=pickbonus&";

	$output .= "gamestate.bonusid=dwarves_bonus&";

	$output .= "bonuswin.cents=" . $bonus_totalwin . "&";
	$output .= "bonuswin.coins=" . $bonus_totalwin . "&";
	$output .= "totalbonuswin.cents=" . $bonus_totalwin . "&";
	$output .= "totalbonuswin.coins=" . $bonus_totalwin . "&";


	$gsStack = "basic%2Cbonus";
	$gsCur = "bonus";

	$answ .= "restoreAction=bonusaction;" . $answer;

	$table_locked = 1;
}


//    if($lastActionDB=="freespin" or $lastActionDB=="startfreespin")
if (isset($fs_left) or $lastActionDB == "startfreespin") {
	if ($fs_left > 1 or $lastActionDB == "startfreespin") {
		if ($lastActionDB != "startfreespin") $fs_left--;
		$fs_multiplier = 1;
		$fs_initial = 10;

		$bonusInfo = explode(";", $answer);
		foreach ($bonusInfo as $e => $v)
			if ($v != '') {
				$a = explode("=", $v);
				$$a[0] = $a[1];
			}
		$fs_total = $fs_left + $fs_played;

		$gameover = "false";
		$restore = "true";
		$output .= "current.rs.i0=freespin&next.rs=freespin&";

		$gsStack = "basic%2Cfreespin";
		$gsCur = "freespin";
		$nesxAct = "freespin";
		$answ .= "restoreAction=freespin;" . $answer;

		$totalWinsDB = $fs_totalwin;

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

		$table_locked = 1;
	}
}


$output .= "restore=" . $restore . "&";

$output .= "gamestate.stack=$gsStack&";
$output .= "nextaction=$nesxAct&";
$output .= "gamestate.current=$gsCur&";

$output .= "rs.i0.id=respin_normal&";
$output .= "rs.i1.id=basic&";
$output .= "rs.i2.id=respin_first_a&";
$output .= "rs.i3.id=respin_first_b&";
$output .= "rs.i4.id=freespin&";
$output .= "rs.i5.id=respin_end&";
$output .= "rs.i6.id=symbol_transform&";

$output .= "casinoID=netent&";
$output .= "bl.standard=0&";
$output .= "bl.i0.id=0&";
$output .= "bl.i0.coins=10&";
$output .= "bl.i0.reelset=basic%2Crespin_first_a%2Crespin_first_b%2Crespin_normal%2Crespin_end%2Cfreespin%2Csymbol_transform&";
$output .= "bl.i0.line=0%2F1%2F2%2C0%2F1%2F2%2C0%2F1%2F2%2C0%2F1%2F2%2C0%2F1%2F2&";
//$output.="betlevel.standard=1&";
$output .= "betlevel.all=1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10&";
$output .= "clientaction=init&";
$output .= "gameEventSetters.enabled=false&";
$output .= "staticsharedurl=https%3A%2F%2F" . $staticSharedURL . "%2Fgameclient_html%2Fdevicedetection%2Fcurrent&";
$output .= "confirmBetMessageEnabled=false&";
$output .= "gameover=true&";

/*
if(!isset($_Social))    $output.= "denomination.all=1%2C2%2C5%2C10%2C20%2C50%2C100&";
    else{
	    $output.= "denomination.all=1";
	    if($_Social['denomLevel']>0) $output.= "%2C2";
	    if($_Social['denomLevel']>1) $output.= "%2C5";
	    if($_Social['denomLevel']>2) $output.= "%2C10";
	    if($_Social['denomLevel']>3) $output.= "%2C20";
	    if($_Social['denomLevel']>4) $output.= "%2C50";
	    if($_Social['denomLevel']>5) $output.= "%2C100";
	    if($_Social['denomLevel']>6) $output.= "%2C200";
	    $output.="&";
	}
*/
if (!isset($_Social) or $_Social == '')    $output .= "denomination.all=1%2C2%2C5%2C10%2C20%2C50%2C100&";
else {
	$output .= "denomination.all=1";
	if ($_Social['denomLevel'] > 0) $output .= "%2C2";
	if ($_Social['denomLevel'] > 1) $output .= "%2C5";
	if ($_Social['denomLevel'] > 2) $output .= "%2C10";
	if ($_Social['denomLevel'] > 3) $output .= "%2C20";
	if ($_Social['denomLevel'] > 4) $output .= "%2C50";
	if ($_Social['denomLevel'] > 5) $output .= "%2C100";
	if ($_Social['denomLevel'] > 6) $output .= "%2C200";
	$output .= "&";
	if ($_Social['denomLevel'] == 0) $denomDB = "1";
	if ($_Social['denomLevel'] == 1) $denomDB = "2";
	if ($_Social['denomLevel'] == 2) $denomDB = "5";
	if ($_Social['denomLevel'] == 3) $denomDB = "10";
	if ($_Social['denomLevel'] == 4) $denomDB = "20";
	if ($_Social['denomLevel'] == 5) $denomDB = "50";
	if ($_Social['denomLevel'] == 6) $denomDB = "100";
	if ($_Social['denomLevel'] == 7) $denomDB = "200";
}
$output .= "denomination.standard=" . $denomDB . "&";
$output .= "betlevel.standard=10&";

//$output.="denomination.standard=1&";
$output .= "multiplier=1&";
$output .= "autoplay=10%2C25%2C50%2C75%2C100%2C250%2C500%2C750%2C1000&";
$output .= "gamesoundurl=https%3A%2F%2F" . $soundURL . "%2F&";
$output .= "nearwinallowed=true&";
$output .= "autoplayLossLimitEnabled=false&";
$output .= "playforfun=false&";

$output .= "wavecount=1&";




$output .= "rs.i1.r.i4.hold=false&";
$output .= "rs.i4.r.i3.hold=false&";
$output .= "rs.i5.r.i2.hold=false&";
$output .= "rs.i6.r.i2.hold=false&";
$output .= "rs.i3.r.i2.hold=false&";
$output .= "rs.i4.r.i0.hold=false&";
$output .= "rs.i2.r.i4.hold=false&";
$output .= "rs.i6.r.i4.hold=false&";
$output .= "rs.i0.r.i4.hold=false&";
$output .= "rs.i2.r.i1.hold=false&";
$output .= "rs.i1.r.i2.hold=false&";
$output .= "rs.i1.r.i3.hold=false&";
$output .= "rs.i3.r.i1.hold=false&";
$output .= "rs.i2.r.i0.hold=false&";
$output .= "rs.i2.r.i3.hold=false&";
$output .= "rs.i1.r.i0.hold=false&";
$output .= "rs.i0.r.i1.hold=false&";
$output .= "rs.i0.r.i2.hold=false&";
$output .= "rs.i5.r.i1.hold=false&";
$output .= "rs.i5.r.i4.hold=false&";
$output .= "rs.i4.r.i4.hold=false&";
$output .= "rs.i6.r.i0.hold=false&";
$output .= "rs.i5.r.i3.hold=false&";
$output .= "rs.i4.r.i2.hold=false&";
$output .= "rs.i5.r.i0.hold=false&";
$output .= "rs.i3.r.i4.hold=false&";
$output .= "rs.i4.r.i1.hold=false&";
$output .= "rs.i3.r.i3.hold=false&";
$output .= "rs.i6.r.i3.hold=false&";
$output .= "rs.i3.r.i0.hold=false&";
$output .= "rs.i2.r.i2.hold=false&";
$output .= "rs.i1.r.i1.hold=false&";
$output .= "rs.i0.r.i3.hold=false&";
$output .= "rs.i6.r.i1.hold=false&";
$output .= "rs.i0.r.i0.hold=false&";


$output .= "rs.i0.r.i1.syms=SYM4%2CSYM11%2CSYM12&";
$output .= "rs.i5.r.i4.syms=SYM5%2CSYM8%2CSYM9&";
$output .= "rs.i0.r.i0.syms=SYM4%2CSYM8%2CSYM9&";
$output .= "rs.i0.r.i3.syms=SYM4%2CSYM11%2CSYM12&";
$output .= "rs.i6.r.i3.syms=SYM3%2CSYM3%2CSYM10&";
$output .= "rs.i4.r.i4.syms=SYM7%2CSYM11%2CSYM9&";
$output .= "rs.i2.r.i1.syms=SYM4%2CSYM11%2CSYM5&";
$output .= "rs.i4.r.i3.syms=SYM5%2CSYM8%2CSYM11&";
$output .= "rs.i6.r.i2.syms=SYM3%2CSYM3%2CSYM12&";
$output .= "rs.i5.r.i1.syms=SYM4%2CSYM11%2CSYM12&";
$output .= "rs.i4.r.i0.syms=SYM12%2CSYM7%2CSYM10&";
$output .= "rs.i0.r.i2.syms=SYM8%2CSYM9%2CSYM10&";
$output .= "rs.i5.r.i0.syms=SYM4%2CSYM8%2CSYM9&";
$output .= "rs.i2.r.i4.syms=SYM4%2CSYM8%2CSYM9&";
$output .= "rs.i3.r.i2.syms=SYM4%2CSYM8%2CSYM9&";
$output .= "rs.i6.r.i0.syms=SYM3%2CSYM3%2CSYM10&";
$output .= "rs.i2.r.i2.syms=SYM4%2CSYM8%2CSYM9&";
$output .= "rs.i5.r.i2.syms=SYM4%2CSYM8%2CSYM9&";
$output .= "rs.i3.r.i3.syms=SYM4%2CSYM11%2CSYM5&";
$output .= "rs.i4.r.i1.syms=SYM8%2CSYM10%2CSYM4&";
$output .= "rs.i3.r.i0.syms=SYM4%2CSYM8%2CSYM9&";
$output .= "rs.i6.r.i1.syms=SYM3%2CSYM3%2CSYM9&";
$output .= "rs.i0.r.i4.syms=SYM4%2CSYM8%2CSYM9&";
$output .= "rs.i2.r.i0.syms=SYM4%2CSYM8%2CSYM9&";
$output .= "rs.i2.r.i3.syms=SYM4%2CSYM11%2CSYM12&";
$output .= "rs.i3.r.i4.syms=SYM4%2CSYM8%2CSYM9&";
$output .= "rs.i3.r.i1.syms=SYM4%2CSYM11%2CSYM12&";
$output .= "rs.i4.r.i2.syms=SYM11%2CSYM13%2CSYM5&";
$output .= "rs.i5.r.i3.syms=SYM4%2CSYM11%2CSYM12&";
$output .= "rs.i6.r.i4.syms=SYM3%2CSYM3%2CSYM11&";
