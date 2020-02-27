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

	if ($type == "final") {
		$str = explode("_", $wildsDB);
		array_pop($str);
		$wilds = $wildsDB;
		if (count($str) == 3) {
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

			$summ = 0;

			foreach ($items as $e => $v) {
				if ($v == $prz1 or $v == $prz2 or $v == $prz3)	unset($items[$e]);
			}

			$i = 0;
			foreach ($items as $e => $v) {
				$output .= "ignored_items.i" . $i . "=" . $v . "&";
				$i++;
			}


			foreach ($str as $e => $v) {
				$output .= "remaining_items.i" . $e . ".itemValue=" . ($prz0) . "&";
				$output .= "remaining_items.i" . $e . ".itemId=" . $v . "&";
			}

			$output .= "gamestate.history=basic%2Cbonus_feature_pick%2Cbonus&";
			$output .= "bonusgame.coinvalue=0.01&";

			$output .= "clientaction=bonusaction&";

			$output .= "nextactiontype=pickbonus&";

			$output .= "gamestate.bonusid=deal_or_no_deal&";

			$bonus_totalwin = 0;

			$nesxAct = "bonusaction";
		}
	} else {
		$nesxAct = "bonusaction";
		$output .= "gamestate.history=basic%2Cbonus_feature_pick&";
		$wildsDB = '';
	}

	$output .= "bonusgame.coinvalue=0.01&";
	$output .= "rs.i0.id=basic&";
	$output .= "nextactiontype=pickbonus&";
	$output .= "clientaction=bonus_feature_pick&";
	$output .= "gamestate.bonusid=deal_or_no_deal&";

	$output .= "bonuswin.cents=" . $bonus_totalwin . "&";
	$output .= "bonuswin.coins=" . $bonus_totalwin . "&";
	$output .= "totalbonuswin.cents=" . $bonus_totalwin . "&";
	$output .= "totalbonuswin.coins=" . $bonus_totalwin . "&";


	$gsStack = "basic%2Cbonus";
	$gsCur = "bonus";

	$answ .= "restoreAction=bonusaction;wildStcks=" . $wildsDB . ";" . $answer;

	$table_locked = 1;
}


if ($lastActionDB == "freespin" or $lastActionDB == "startfreespin") {
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

	$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C21%2C22%2C23%2C24%2C25%2C26%2C27%2C28%2C29&";

	$table_locked = 1;
}


$output .= "restore=" . $restore . "&";

$output .= "gamestate.stack=$gsStack&";
$output .= "nextaction=$nesxAct&";
$output .= "gamestate.current=$gsCur&";

if ($lastRsDB == '') {
	$lastRsDB = "rs.i0.r.i0.syms=SYM4%2CSYM4%2CSYM4&rs.i0.r.i1.syms=SYM4%2CSYM4%2CSYM4&rs.i0.r.i2.syms=SYM9%2CSYM9%2CSYM9&rs.i0.r.i3.syms=SYM4%2CSYM4%2CSYM4&rs.i0.r.i4.syms=SYM4%2CSYM4%2CSYM4&";
}

$output .= $lastRsDB;


$output .= "bl.i3.coins=1&rs.i3.r.i1.pos=0&rs.i5.r.i0.syms=SYM8%2CSYM8%2CSYM8&bl.i5.id=5&rs.i3.id=symbol_overlay&rs.i6.r.i0.pos=16&bl.i6.id=6&rs.i6.r.i1.syms=SYM7%2CSYM7%2CSYM3&rs.i4.r.i4.pos=0&rs.i6.r.i4.pos=2&rs.i0.r.i2.hold=false&rs.i0.r.i4.pos=0&rs.i7.id=basic_respin&bl.i4.coins=1&bl.i5.coins=1&rs.i5.r.i0.pos=0&bl.i3.reelset=ALL&rs.i5.r.i3.pos=0&rs.i1.r.i3.syms=SYM9%2CSYM9%2CSYM8&rs.i4.r.i1.syms=SYM4%2CSYM4%2CSYM4&rs.i7.r.i2.pos=0&bl.i9.line=1%2C0%2C1%2C0%2C1&rs.i6.r.i2.pos=17&bl.i5.reelset=ALL&rs.i1.r.i4.hold=false&bl.i8.coins=1&rs.i6.id=basic&rs.i6.r.i1.pos=14&bl.i6.coins=1&rs.i0.r.i3.hold=false&rs.i2.r.i2.pos=0&bl.i4.line=2%2C1%2C0%2C1%2C2&bl.i5.line=0%2C0%2C1%2C0%2C0&bl.i1.line=0%2C0%2C0%2C0%2C0&bl.i6.line=2%2C2%2C1%2C2%2C2&bl.i4.id=4&rs.i3.r.i0.hold=false&rs.i7.r.i3.syms=SYM9%2CSYM9%2CSYM9&rs.i2.r.i3.pos=0&rs.i5.id=random_wild&rs.i4.r.i0.syms=SYM4%2CSYM4%2CSYM4&bl.i4.reelset=ALL&rs.i5.r.i3.syms=SYM8%2CSYM8%2CSYM8&bl.i1.reelset=ALL&rs.i1.id=symbol_transform&rs.i2.r.i2.hold=false&rs.i6.r.i0.hold=false&rs.i1.r.i2.hold=false&rs.i2.r.i0.hold=false&rs.i5.r.i3.hold=false&rs.i5.r.i1.hold=false&rs.i3.r.i2.syms=SYM7%2CSYM7%2CSYM7&bl.i0.coins=1&rs.i3.r.i2.pos=0&rs.i3.r.i0.syms=SYM7%2CSYM7%2CSYM7&rs.i3.r.i4.pos=0&rs.i2.r.i4.hold=false&rs.i3.r.i1.hold=false&bl.standard=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9&rs.i1.r.i0.pos=0&rs.i6.r.i1.hold=false&rs.i4.r.i1.pos=0&rs.i1.r.i1.syms=SYM9%2CSYM9%2CSYM8&rs.i5.r.i1.syms=SYM8%2CSYM8%2CSYM8&bl.i6.reelset=ALL&rs.i7.r.i0.pos=0&autoplayLossLimitEnabled=false&rs.i2.r.i4.syms=SYM2%2CSYM2%2CSYM2&nearwinallowed=true&rs.i3.r.i4.hold=false&bl.i9.coins=1&rs.i1.r.i1.pos=0&rs.i5.r.i4.hold=false&rs.i7.r.i4.pos=0&rs.i2.r.i0.pos=0&bl.i0.line=1%2C1%2C1%2C1%2C1&bl.i1.id=1&rs.i5.r.i2.pos=0&rs.i4.r.i3.hold=false&rs.i0.r.i1.pos=0&rs.i4.r.i3.pos=0&rs.i4.r.i0.hold=false&rs.i7.r.i4.hold=false&rs.i1.r.i0.hold=false&rs.i0.r.i3.pos=0&gameEventSetters.enabled=false&rs.i3.r.i3.syms=SYM7%2CSYM7%2CSYM7&rs.i1.r.i4.pos=0&rs.i2.r.i1.syms=SYM4%2CSYM4%2CSYM4&rs.i5.r.i4.syms=SYM8%2CSYM8%2CSYM8&rs.i1.r.i4.syms=SYM9%2CSYM9%2CSYM8&rs.i7.r.i4.syms=SYM9%2CSYM9%2CSYM9&rs.i7.r.i1.syms=SYM9%2CSYM9%2CSYM9&rs.i7.r.i1.hold=false&confirmBetMessageEnabled=false&rs.i7.r.i2.syms=SYM6%2CSYM6%2CSYM6&rs.i2.id=freespin&rs.i1.r.i2.pos=0&rs.i0.r.i4.hold=false&bl.i3.line=0%2C1%2C2%2C1%2C0&rs.i2.r.i1.hold=false&rs.i4.r.i2.pos=0&rs.i1.r.i2.syms=SYM9%2CSYM9%2CSYM8&";

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

$output .= "betlevel.standard=10&";
$output .= "denomination.standard=" . $denomDB . "&";


$output .= "rs.i4.r.i2.hold=false&rs.i3.r.i2.hold=false&rs.i0.r.i0.pos=0&clientaction=init&rs.i7.r.i1.pos=0&rs.i1.r.i3.hold=false&rs.i2.r.i1.pos=0&rs.i2.r.i3.syms=SYM4%2CSYM4%2CSYM4&rs.i7.r.i0.syms=SYM9%2CSYM9%2CSYM9&bl.i8.reelset=ALL&bl.i1.coins=1&rs.i6.r.i3.syms=SYM5%2CSYM5%2CSYM9&rs.i6.r.i4.syms=SYM7%2CSYM0%2CSYM4&rs.i1.r.i0.syms=SYM9%2CSYM9%2CSYM8&rs.i1.r.i3.pos=0&rs.i0.r.i1.hold=false&rs.i6.r.i3.pos=6&rs.i5.r.i4.pos=0&bl.i7.line=1%2C2%2C2%2C2%2C1&rs.i7.r.i2.hold=false&rs.i4.r.i1.hold=false&rs.i4.r.i4.hold=false&rs.i3.r.i1.syms=SYM7%2CSYM7%2CSYM7&rs.i0.r.i2.pos=0&rs.i5.r.i2.hold=false&betlevel.all=1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10&bl.i7.reelset=ALL&bl.i2.coins=1&rs.i4.r.i2.syms=SYM7%2CSYM7%2CSYM7&rs.i6.r.i2.syms=SYM7%2CSYM0%2CSYM4&rs.i2.r.i2.syms=SYM9%2CSYM9%2CSYM9&rs.i2.r.i4.pos=0&bl.i8.line=1%2C0%2C0%2C0%2C1&bl.i8.id=8&bl.i7.coins=1&rs.i6.r.i0.syms=SYM4%2CSYM0%2CSYM6&rs.i6.r.i2.hold=false&rs.i2.r.i0.syms=SYM2%2CSYM2%2CSYM2&credit=500000&bl.i2.reelset=ALL&rs.i7.r.i3.hold=false&rs.i5.r.i0.hold=false&rs.i0.r.i0.hold=false&rs.i3.r.i3.pos=0&rs.i3.r.i4.syms=SYM7%2CSYM7%2CSYM7&bl.i9.reelset=ALL&bl.i0.id=0&autoplay=10%2C25%2C50%2C75%2C100%2C250%2C500%2C750%2C1000&bl.i2.id=2&bl.i3.id=3&rs.i4.r.i0.pos=0&rs.i6.r.i3.hold=false&rs.i7.r.i3.pos=0&bl.i2.line=2%2C2%2C2%2C2%2C2&rs.i6.r.i4.hold=false&rs.i5.r.i2.syms=SYM3%2CSYM3%2CSYM3&bl.i7.id=7&rs.i4.id=freespin_few_spins&rs.i5.r.i1.pos=0&rs.i3.r.i0.pos=0&bl.i9.id=9&bl.i0.reelset=ALL&rs.i1.r.i1.hold=false&rs.i4.r.i3.syms=SYM4%2CSYM4%2CSYM4&rs.i0.id=freespin_respin&rs.i2.r.i3.hold=false&iframeEnabled=false&playforfun=false&rs.i4.r.i4.syms=SYM4%2CSYM4%2CSYM4&rs.i7.r.i0.hold=false&";
$output .= "staticsharedurl=https%3A%2F%2F" . $staticSharedURL . "%2Fgameclient_html%2Fdevicedetection%2Fcurrent&rs.i3.r.i3.hold=false&";
