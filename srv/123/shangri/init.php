<?
$totalWinsDB = 0;
$total_win = 0;

$table_locked = 0;
$gsStack = "basic";
$gsCur = "basic";
$nesxAct = "spin";

$restore = "false";

$wavecount = 0;

if ($lastActionDB == "respin" and $wildsDB != '') {
	$bonusInfo = explode(";", $answer);
	foreach ($bonusInfo as $e => $v)
		if ($v != '') {
			$a = explode("=", $v);
			$$a[0] = $a[1];
		}

	$restore = "true";
	$gameover = "false";

	$gsStack = "basic";
	$gsCur = "basic";
	$nesxAct = "respin";

	$answ .= "restoreAction=respin;wildStcks=" . $wildsDB . ";" . $answer;

	//	$answ="restoreAction=respin;";

	$output .= "current.rs.i0=basic&";
	$output .= "next.rs=basic&";
	$output .= "gamestate.history=basic&";
	$output .= "respin.positions=" . $wildsDB . "&";

	$table_locked = 1;
}

if ($lastActionDB == "freespin" or $lastActionDB == "startfreespin" or $lastActionDB == "initfreespin") {
	//	$fs_multiplier=1;
	//	$fs_initial=8;

	$bonusInfo = explode(";", $answer);
	foreach ($bonusInfo as $e => $v)
		if ($v != '') {
			$a = explode("=", $v);
			$$a[0] = $a[1];
		}

	if (!isset($fs_left)) $fs_temp = $fs_initial;
	else $fs_temp = $fs_left;
	$fs_total = $fs_left + $fs_played;

	if ($wildsDB != '') {
		$output .= "freespins.substitution.added=" . $wildsDB . "&";
		$output .= "freespins.substitution.next=" . $wildsDB . "&";
		$output .= "freespins.substitution.sticky=" . $wildsDB . "&";
	}

	$gameover = "false";
	$restore = "true";
	$output .= "current.rs.i0=freespin&next.rs=freespin&";

	$gsStack = "basic%2Cfreespin";
	$gsCur = "freespin";
	$nesxAct = "freespin";
	$answ .= "restoreAction=freespin;wildStcks=" . $wildsDB . ";" . $answer;

	$totalWinsDB = $fs_totalwin;

	$multiplier = $fs_multiplier;

	$output .= "freespins.denomination=1.000&";

	$output .= "freespins.initial=" . $fs_initial . "&";
	$output .= "freespins.total=" . $fs_total . "&";
	$output .= "freespins.left=" . $fs_temp . "&";
	$output .= "freespins.played=" . $fs_played . "&";
	$output .= "freespins.totalwin.coins=" . $fs_totalwin . "&";
	$output .= "freespins.totalwin.cents=" . $fs_totalwin . "&";
	$output .= "freespins.win.cents=" . $fs_totalwin . "&";
	$output .= "freespins.win.coins=" . $fs_totalwin . "&";

	$output .= "freespins.betlevel=1&";
	$output .= "freespins.wavecount=1&";
	$output .= "freespins.multiplier=1&";

	$output .= "freespins.betlines=0&";
	$output .= "freespins.retriggered=false&";
	$output .= "gameEventSetters.enabled=false&";

	$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C21%2C22%2C23%2C24%2C25%2C26%2C27%2C28%2C29&";

	$table_locked = 1;
}

$output .= "restore=" . $restore . "&";

$output .= "gamestate.stack=$gsStack&";
$output .= "nextaction=$nesxAct&";
$output .= "gamestate.current=$gsCur&";

$output .= "playforfun=false&";

$output .= "clientaction=init&";

$output .= "autoplay=10%2C25%2C50%2C75%2C100%2C250%2C500%2C750%2C1000&";
$output .= "autoplayLossLimitEnabled=false&";
$output .= "betlevel.all=1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10&";
$output .= "betlevel.standard=1&";
$output .= "bl.i0.coins=15&";
$output .= "bl.i0.id=0&";
$output .= "bl.i0.line=0%2F1%2F2%2F3%2F4%2C0%2F1%2F2%2F3%2F4%2C0%2F1%2F2%2F3%2F4%2C0%2F1%2F2%2F3%2F4%2C0%2F1%2F2%2F3%2F4%2C0%2F1%2F2%2F3%2F4&";
$output .= "bl.i0.reelset=ALL&";
$output .= "bl.standard=0&";
$output .= "clientaction=init&";
$output .= "confirmBetMessageEnabled=false&";
$output .= "denomination.all=1%2C2%2C5%2C10%2C20%2C50%2C100%2C200&";
$output .= "denomination.standard=1&";
$output .= "gameEventSetters.enabled=false&";
$output .= "gamesoundurl=https%3A%2F%2F" . $soundURL . "%2F&";
//$output.= "gamestate.current=basic&";
$output .= "nearwinallowed=true&";
//$output.= "nextaction=spin&";
$output .= "rs.i0.id=freespin&";
$output .= "rs.i0.r.i0.hold=false&";
$output .= "rs.i0.r.i0.pos=0&";
$output .= "rs.i0.r.i0.syms=SYM3%2CSYM3%2CSYM7%2CSYM7%2CSYM7&";
$output .= "rs.i0.r.i1.hold=false&";
$output .= "rs.i0.r.i1.pos=0&";
$output .= "rs.i0.r.i1.syms=SYM5%2CSYM5%2CSYM8%2CSYM8%2CSYM8&";
$output .= "rs.i0.r.i2.hold=false&";
$output .= "rs.i0.r.i2.pos=0&";
$output .= "rs.i0.r.i2.syms=SYM7%2CSYM7%2CSYM7%2CSYM6%2CSYM6&";
$output .= "rs.i0.r.i3.hold=false&";
$output .= "rs.i0.r.i3.pos=0&";
$output .= "rs.i0.r.i3.syms=SYM7%2CSYM7%2CSYM7%2CSYM9%2CSYM9&";
$output .= "rs.i0.r.i4.hold=false&";
$output .= "rs.i0.r.i4.pos=0&";
$output .= "rs.i0.r.i4.syms=SYM5%2CSYM5%2CSYM5%2CSYM5%2CSYM3&";
$output .= "rs.i0.r.i5.hold=false&";
$output .= "rs.i0.r.i5.pos=0&";
$output .= "rs.i0.r.i5.syms=SYM3%2CSYM3%2CSYM3%2CSYM3%2CSYM3&";
$output .= "rs.i1.id=respin1&";
$output .= "rs.i1.r.i0.hold=false&";
$output .= "rs.i1.r.i0.pos=11&";
$output .= "rs.i1.r.i0.syms=SYM13&";
$output .= "rs.i1.r.i1.hold=false&";
$output .= "rs.i1.r.i1.pos=2&";
$output .= "rs.i1.r.i1.syms=SYM13&";
$output .= "rs.i1.r.i10.hold=false&";
$output .= "rs.i1.r.i10.pos=0&";
$output .= "rs.i1.r.i10.syms=SYM12&";
$output .= "rs.i1.r.i11.hold=false&";
$output .= "rs.i1.r.i11.pos=8&";
$output .= "rs.i1.r.i11.syms=SYM13&";
$output .= "rs.i1.r.i12.hold=false&";
$output .= "rs.i1.r.i12.pos=7&";
$output .= "rs.i1.r.i12.syms=SYM12&";
$output .= "rs.i1.r.i13.hold=false&";
$output .= "rs.i1.r.i13.pos=11&";
$output .= "rs.i1.r.i13.syms=SYM13&";
$output .= "rs.i1.r.i14.hold=false&";
$output .= "rs.i1.r.i14.pos=10&";
$output .= "rs.i1.r.i14.syms=SYM13&";
$output .= "rs.i1.r.i15.hold=false&";
$output .= "rs.i1.r.i15.pos=9&";
$output .= "rs.i1.r.i15.syms=SYM13&";
$output .= "rs.i1.r.i16.hold=false&";
$output .= "rs.i1.r.i16.pos=6&";
$output .= "rs.i1.r.i16.syms=SYM13&";
$output .= "rs.i1.r.i17.hold=false&";
$output .= "rs.i1.r.i17.pos=9&";
$output .= "rs.i1.r.i17.syms=SYM13&";
$output .= "rs.i1.r.i18.hold=false&";
$output .= "rs.i1.r.i18.pos=7&";
$output .= "rs.i1.r.i18.syms=SYM12&";
$output .= "rs.i1.r.i19.hold=false&";
$output .= "rs.i1.r.i19.pos=1&";
$output .= "rs.i1.r.i19.syms=SYM13&";
$output .= "rs.i1.r.i2.hold=false&";
$output .= "rs.i1.r.i2.pos=2&";
$output .= "rs.i1.r.i2.syms=SYM13&";
$output .= "rs.i1.r.i20.hold=false&";
$output .= "rs.i1.r.i20.pos=3&";
$output .= "rs.i1.r.i20.syms=SYM13&";
$output .= "rs.i1.r.i21.hold=false&";
$output .= "rs.i1.r.i21.pos=1&";
$output .= "rs.i1.r.i21.syms=SYM13&";
$output .= "rs.i1.r.i22.hold=false&";
$output .= "rs.i1.r.i22.pos=4&";
$output .= "rs.i1.r.i22.syms=SYM13&";
$output .= "rs.i1.r.i23.hold=false&";
$output .= "rs.i1.r.i23.pos=8&";
$output .= "rs.i1.r.i23.syms=SYM13&";
$output .= "rs.i1.r.i24.hold=false&";
$output .= "rs.i1.r.i24.pos=9&";
$output .= "rs.i1.r.i24.syms=SYM13&";
$output .= "rs.i1.r.i25.hold=false&";
$output .= "rs.i1.r.i25.pos=2&";
$output .= "rs.i1.r.i25.syms=SYM13&";
$output .= "rs.i1.r.i26.hold=false&";
$output .= "rs.i1.r.i26.pos=4&";
$output .= "rs.i1.r.i26.syms=SYM13&";
$output .= "rs.i1.r.i27.hold=false&";
$output .= "rs.i1.r.i27.pos=10&";
$output .= "rs.i1.r.i27.syms=SYM13&";
$output .= "rs.i1.r.i28.hold=false&";
$output .= "rs.i1.r.i28.pos=5&";
$output .= "rs.i1.r.i28.syms=SYM13&";
$output .= "rs.i1.r.i29.hold=false&";
$output .= "rs.i1.r.i29.pos=11&";
$output .= "rs.i1.r.i29.syms=SYM13&";
$output .= "rs.i1.r.i3.hold=false&";
$output .= "rs.i1.r.i3.pos=0&";
$output .= "rs.i1.r.i3.syms=SYM12&";
$output .= "rs.i1.r.i4.hold=false&";
$output .= "rs.i1.r.i4.pos=12&";
$output .= "rs.i1.r.i4.syms=SYM13&";
$output .= "rs.i1.r.i5.hold=false&";
$output .= "rs.i1.r.i5.pos=4&";
$output .= "rs.i1.r.i5.syms=SYM13&";
$output .= "rs.i1.r.i6.hold=false&";
$output .= "rs.i1.r.i6.pos=0&";
$output .= "rs.i1.r.i6.syms=SYM12&";
$output .= "rs.i1.r.i7.hold=false&";
$output .= "rs.i1.r.i7.pos=10&";
$output .= "rs.i1.r.i7.syms=SYM13&";
$output .= "rs.i1.r.i8.hold=false&";
$output .= "rs.i1.r.i8.pos=3&";
$output .= "rs.i1.r.i8.syms=SYM13&";
$output .= "rs.i1.r.i9.hold=false&";
$output .= "rs.i1.r.i9.pos=8&";
$output .= "rs.i1.r.i9.syms=SYM13&";
$output .= "rs.i2.id=respin2&";
$output .= "rs.i2.r.i0.hold=false&";
$output .= "rs.i2.r.i0.pos=9&";
$output .= "rs.i2.r.i0.syms=SYM13&";
$output .= "rs.i2.r.i1.hold=false&";
$output .= "rs.i2.r.i1.pos=7&";
$output .= "rs.i2.r.i1.syms=SYM13&";
$output .= "rs.i2.r.i10.hold=false&";
$output .= "rs.i2.r.i10.pos=10&";
$output .= "rs.i2.r.i10.syms=SYM13&";
$output .= "rs.i2.r.i11.hold=false&";
$output .= "rs.i2.r.i11.pos=4&";
$output .= "rs.i2.r.i11.syms=SYM13&";
$output .= "rs.i2.r.i12.hold=false&";
$output .= "rs.i2.r.i12.pos=7&";
$output .= "rs.i2.r.i12.syms=SYM13&";
$output .= "rs.i2.r.i13.hold=false&";
$output .= "rs.i2.r.i13.pos=1&";
$output .= "rs.i2.r.i13.syms=SYM13&";
$output .= "rs.i2.r.i14.hold=false&";
$output .= "rs.i2.r.i14.pos=4&";
$output .= "rs.i2.r.i14.syms=SYM13&";
$output .= "rs.i2.r.i15.hold=false&";
$output .= "rs.i2.r.i15.pos=8&";
$output .= "rs.i2.r.i15.syms=SYM13&";
$output .= "rs.i2.r.i16.hold=false&";
$output .= "rs.i2.r.i16.pos=8&";
$output .= "rs.i2.r.i16.syms=SYM13&";
$output .= "rs.i2.r.i17.hold=false&";
$output .= "rs.i2.r.i17.pos=3&";
$output .= "rs.i2.r.i17.syms=SYM13&";
$output .= "rs.i2.r.i18.hold=false&";
$output .= "rs.i2.r.i18.pos=8&";
$output .= "rs.i2.r.i18.syms=SYM13&";
$output .= "rs.i2.r.i19.hold=false&";
$output .= "rs.i2.r.i19.pos=6&";
$output .= "rs.i2.r.i19.syms=SYM13&";
$output .= "rs.i2.r.i2.hold=false&";
$output .= "rs.i2.r.i2.pos=9&";
$output .= "rs.i2.r.i2.syms=SYM13&";
$output .= "rs.i2.r.i20.hold=false&";
$output .= "rs.i2.r.i20.pos=6&";
$output .= "rs.i2.r.i20.syms=SYM13&";
$output .= "rs.i2.r.i21.hold=false&";
$output .= "rs.i2.r.i21.pos=7&";
$output .= "rs.i2.r.i21.syms=SYM13&";
$output .= "rs.i2.r.i22.hold=false&";
$output .= "rs.i2.r.i22.pos=9&";
$output .= "rs.i2.r.i22.syms=SYM13&";
$output .= "rs.i2.r.i23.hold=false&";
$output .= "rs.i2.r.i23.pos=0&";
$output .= "rs.i2.r.i23.syms=SYM12&";
$output .= "rs.i2.r.i24.hold=false&";
$output .= "rs.i2.r.i24.pos=9&";
$output .= "rs.i2.r.i24.syms=SYM13&";
$output .= "rs.i2.r.i25.hold=false&";
$output .= "rs.i2.r.i25.pos=5&";
$output .= "rs.i2.r.i25.syms=SYM13&";
$output .= "rs.i2.r.i26.hold=false&";
$output .= "rs.i2.r.i26.pos=5&";
$output .= "rs.i2.r.i26.syms=SYM13&";
$output .= "rs.i2.r.i27.hold=false&";
$output .= "rs.i2.r.i27.pos=11&";
$output .= "rs.i2.r.i27.syms=SYM13&";
$output .= "rs.i2.r.i28.hold=false&";
$output .= "rs.i2.r.i28.pos=2&";
$output .= "rs.i2.r.i28.syms=SYM13&";
$output .= "rs.i2.r.i29.hold=false&";
$output .= "rs.i2.r.i29.pos=2&";
$output .= "rs.i2.r.i29.syms=SYM13&";
$output .= "rs.i2.r.i3.hold=false&";
$output .= "rs.i2.r.i3.pos=5&";
$output .= "rs.i2.r.i3.syms=SYM13&";
$output .= "rs.i2.r.i4.hold=false&";
$output .= "rs.i2.r.i4.pos=4&";
$output .= "rs.i2.r.i4.syms=SYM13&";
$output .= "rs.i2.r.i5.hold=false&";
$output .= "rs.i2.r.i5.pos=10&";
$output .= "rs.i2.r.i5.syms=SYM13&";
$output .= "rs.i2.r.i6.hold=false&";
$output .= "rs.i2.r.i6.pos=4&";
$output .= "rs.i2.r.i6.syms=SYM13&";
$output .= "rs.i2.r.i7.hold=false&";
$output .= "rs.i2.r.i7.pos=10&";
$output .= "rs.i2.r.i7.syms=SYM13&";
$output .= "rs.i2.r.i8.hold=false&";
$output .= "rs.i2.r.i8.pos=8&";
$output .= "rs.i2.r.i8.syms=SYM13&";
$output .= "rs.i2.r.i9.hold=false&";
$output .= "rs.i2.r.i9.pos=5&";
$output .= "rs.i2.r.i9.syms=SYM13&";
$output .= "rs.i3.id=respin3&";
$output .= "rs.i3.r.i0.hold=false&";
$output .= "rs.i3.r.i0.pos=2&";
$output .= "rs.i3.r.i0.syms=SYM13&";
$output .= "rs.i3.r.i1.hold=false&";
$output .= "rs.i3.r.i1.pos=1&";
$output .= "rs.i3.r.i1.syms=SYM13&";
$output .= "rs.i3.r.i10.hold=false&";
$output .= "rs.i3.r.i10.pos=17&";
$output .= "rs.i3.r.i10.syms=SYM13&";
$output .= "rs.i3.r.i11.hold=false&";
$output .= "rs.i3.r.i11.pos=2&";
$output .= "rs.i3.r.i11.syms=SYM13&";
$output .= "rs.i3.r.i12.hold=false&";
$output .= "rs.i3.r.i12.pos=8&";
$output .= "rs.i3.r.i12.syms=SYM13&";
$output .= "rs.i3.r.i13.hold=false&";
$output .= "rs.i3.r.i13.pos=10&";
$output .= "rs.i3.r.i13.syms=SYM13&";
$output .= "rs.i3.r.i14.hold=false&";
$output .= "rs.i3.r.i14.pos=10&";
$output .= "rs.i3.r.i14.syms=SYM13&";
$output .= "rs.i3.r.i15.hold=false&";
$output .= "rs.i3.r.i15.pos=17&";
$output .= "rs.i3.r.i15.syms=SYM13&";
$output .= "rs.i3.r.i16.hold=false&";
$output .= "rs.i3.r.i16.pos=5&";
$output .= "rs.i3.r.i16.syms=SYM13&";
$output .= "rs.i3.r.i17.hold=false&";
$output .= "rs.i3.r.i17.pos=3&";
$output .= "rs.i3.r.i17.syms=SYM13&";
$output .= "rs.i3.r.i18.hold=false&";
$output .= "rs.i3.r.i18.pos=8&";
$output .= "rs.i3.r.i18.syms=SYM13&";
$output .= "rs.i3.r.i19.hold=false&";
$output .= "rs.i3.r.i19.pos=14&";
$output .= "rs.i3.r.i19.syms=SYM13&";
$output .= "rs.i3.r.i2.hold=false&";
$output .= "rs.i3.r.i2.pos=14&";
$output .= "rs.i3.r.i2.syms=SYM13&";
$output .= "rs.i3.r.i20.hold=false&";
$output .= "rs.i3.r.i20.pos=9&";
$output .= "rs.i3.r.i20.syms=SYM13&";
$output .= "rs.i3.r.i21.hold=false&";
$output .= "rs.i3.r.i21.pos=11&";
$output .= "rs.i3.r.i21.syms=SYM13&";
$output .= "rs.i3.r.i22.hold=false&";
$output .= "rs.i3.r.i22.pos=16&";
$output .= "rs.i3.r.i22.syms=SYM13&";
$output .= "rs.i3.r.i23.hold=false&";
$output .= "rs.i3.r.i23.pos=11&";
$output .= "rs.i3.r.i23.syms=SYM13&";
$output .= "rs.i3.r.i24.hold=false&";
$output .= "rs.i3.r.i24.pos=14&";
$output .= "rs.i3.r.i24.syms=SYM13&";
$output .= "rs.i3.r.i25.hold=false&";
$output .= "rs.i3.r.i25.pos=0&";
$output .= "rs.i3.r.i25.syms=SYM12&";
$output .= "rs.i3.r.i26.hold=false&";
$output .= "rs.i3.r.i26.pos=16&";
$output .= "rs.i3.r.i26.syms=SYM13&";
$output .= "rs.i3.r.i27.hold=false&";
$output .= "rs.i3.r.i27.pos=9&";
$output .= "rs.i3.r.i27.syms=SYM13&";
$output .= "rs.i3.r.i28.hold=false&";
$output .= "rs.i3.r.i28.pos=5&";
$output .= "rs.i3.r.i28.syms=SYM13&";
$output .= "rs.i3.r.i29.hold=false&";
$output .= "rs.i3.r.i29.pos=4&";
$output .= "rs.i3.r.i29.syms=SYM13&";
$output .= "rs.i3.r.i3.hold=false&";
$output .= "rs.i3.r.i3.pos=3&";
$output .= "rs.i3.r.i3.syms=SYM13&";
$output .= "rs.i3.r.i4.hold=false&";
$output .= "rs.i3.r.i4.pos=5&";
$output .= "rs.i3.r.i4.syms=SYM13&";
$output .= "rs.i3.r.i5.hold=false&";
$output .= "rs.i3.r.i5.pos=17&";
$output .= "rs.i3.r.i5.syms=SYM13&";
$output .= "rs.i3.r.i6.hold=false&";
$output .= "rs.i3.r.i6.pos=12&";
$output .= "rs.i3.r.i6.syms=SYM13&";
$output .= "rs.i3.r.i7.hold=false&";
$output .= "rs.i3.r.i7.pos=7&";
$output .= "rs.i3.r.i7.syms=SYM13&";
$output .= "rs.i3.r.i8.hold=false&";
$output .= "rs.i3.r.i8.pos=15&";
$output .= "rs.i3.r.i8.syms=SYM13&";
$output .= "rs.i3.r.i9.hold=false&";
$output .= "rs.i3.r.i9.pos=2&";
$output .= "rs.i3.r.i9.syms=SYM13&";
$output .= "rs.i4.id=respin4&";
$output .= "rs.i4.r.i0.hold=false&";
$output .= "rs.i4.r.i0.pos=14&";
$output .= "rs.i4.r.i0.syms=SYM13&";
$output .= "rs.i4.r.i1.hold=false&";
$output .= "rs.i4.r.i1.pos=20&";
$output .= "rs.i4.r.i1.syms=SYM13&";
$output .= "rs.i4.r.i10.hold=false&";
$output .= "rs.i4.r.i10.pos=5&";
$output .= "rs.i4.r.i10.syms=SYM13&";
$output .= "rs.i4.r.i11.hold=false&";
$output .= "rs.i4.r.i11.pos=6&";
$output .= "rs.i4.r.i11.syms=SYM13&";
$output .= "rs.i4.r.i12.hold=false&";
$output .= "rs.i4.r.i12.pos=5&";
$output .= "rs.i4.r.i12.syms=SYM13&";
$output .= "rs.i4.r.i13.hold=false&";
$output .= "rs.i4.r.i13.pos=3&";
$output .= "rs.i4.r.i13.syms=SYM13&";
$output .= "rs.i4.r.i14.hold=false&";
$output .= "rs.i4.r.i14.pos=5&";
$output .= "rs.i4.r.i14.syms=SYM13&";
$output .= "rs.i4.r.i15.hold=false&";
$output .= "rs.i4.r.i15.pos=5&";
$output .= "rs.i4.r.i15.syms=SYM13&";
$output .= "rs.i4.r.i16.hold=false&";
$output .= "rs.i4.r.i16.pos=16&";
$output .= "rs.i4.r.i16.syms=SYM13&";
$output .= "rs.i4.r.i17.hold=false&";
$output .= "rs.i4.r.i17.pos=16&";
$output .= "rs.i4.r.i17.syms=SYM13&";
$output .= "rs.i4.r.i18.hold=false&";
$output .= "rs.i4.r.i18.pos=14&";
$output .= "rs.i4.r.i18.syms=SYM13&";
$output .= "rs.i4.r.i19.hold=false&";
$output .= "rs.i4.r.i19.pos=3&";
$output .= "rs.i4.r.i19.syms=SYM13&";
$output .= "rs.i4.r.i2.hold=false&";
$output .= "rs.i4.r.i2.pos=12&";
$output .= "rs.i4.r.i2.syms=SYM13&";
$output .= "rs.i4.r.i20.hold=false&";
$output .= "rs.i4.r.i20.pos=0&";
$output .= "rs.i4.r.i20.syms=SYM12&";
$output .= "rs.i4.r.i21.hold=false&";
$output .= "rs.i4.r.i21.pos=13&";
$output .= "rs.i4.r.i21.syms=SYM13&";
$output .= "rs.i4.r.i22.hold=false&";
$output .= "rs.i4.r.i22.pos=21&";
$output .= "rs.i4.r.i22.syms=SYM13&";
$output .= "rs.i4.r.i23.hold=false&";
$output .= "rs.i4.r.i23.pos=11&";
$output .= "rs.i4.r.i23.syms=SYM13&";
$output .= "rs.i4.r.i24.hold=false&";
$output .= "rs.i4.r.i24.pos=17&";
$output .= "rs.i4.r.i24.syms=SYM13&";
$output .= "rs.i4.r.i25.hold=false&";
$output .= "rs.i4.r.i25.pos=13&";
$output .= "rs.i4.r.i25.syms=SYM13&";
$output .= "rs.i4.r.i26.hold=false&";
$output .= "rs.i4.r.i26.pos=7&";
$output .= "rs.i4.r.i26.syms=SYM13&";
$output .= "rs.i4.r.i27.hold=false&";
$output .= "rs.i4.r.i27.pos=15&";
$output .= "rs.i4.r.i27.syms=SYM13&";
$output .= "rs.i4.r.i28.hold=false&";
$output .= "rs.i4.r.i28.pos=15&";
$output .= "rs.i4.r.i28.syms=SYM13&";
$output .= "rs.i4.r.i29.hold=false&";
$output .= "rs.i4.r.i29.pos=4&";
$output .= "rs.i4.r.i29.syms=SYM13&";
$output .= "rs.i4.r.i3.hold=false&";
$output .= "rs.i4.r.i3.pos=7&";
$output .= "rs.i4.r.i3.syms=SYM13&";
$output .= "rs.i4.r.i4.hold=false&";
$output .= "rs.i4.r.i4.pos=9&";
$output .= "rs.i4.r.i4.syms=SYM13&";
$output .= "rs.i4.r.i5.hold=false&";
$output .= "rs.i4.r.i5.pos=2&";
$output .= "rs.i4.r.i5.syms=SYM13&";
$output .= "rs.i4.r.i6.hold=false&";
$output .= "rs.i4.r.i6.pos=20&";
$output .= "rs.i4.r.i6.syms=SYM13&";
$output .= "rs.i4.r.i7.hold=false&";
$output .= "rs.i4.r.i7.pos=18&";
$output .= "rs.i4.r.i7.syms=SYM13&";
$output .= "rs.i4.r.i8.hold=false&";
$output .= "rs.i4.r.i8.pos=6&";
$output .= "rs.i4.r.i8.syms=SYM13&";
$output .= "rs.i4.r.i9.hold=false&";
$output .= "rs.i4.r.i9.pos=13&";
$output .= "rs.i4.r.i9.syms=SYM13&";
$output .= "rs.i5.id=basic&";
$output .= "rs.i5.r.i0.hold=false&";
$output .= "rs.i5.r.i0.pos=16&";
$output .= "rs.i5.r.i0.syms=SYM4%2CSYM4%2CSYM7%2CSYM7%2CSYM7&";
$output .= "rs.i5.r.i1.hold=false&";
$output .= "rs.i5.r.i1.pos=0&";
$output .= "rs.i5.r.i1.syms=SYM6%2CSYM6%2CSYM6%2CSYM6%2CSYM6&";
$output .= "rs.i5.r.i2.hold=false&";
$output .= "rs.i5.r.i2.pos=13&";
$output .= "rs.i5.r.i2.syms=SYM5%2CSYM5%2CSYM6%2CSYM6%2CSYM6&";
$output .= "rs.i5.r.i3.hold=false&";
$output .= "rs.i5.r.i3.pos=32&";
$output .= "rs.i5.r.i3.syms=SYM9%2CSYM9%2CSYM9%2CSYM3%2CSYM3&";
$output .= "rs.i5.r.i4.hold=false&";
$output .= "rs.i5.r.i4.pos=315&";
$output .= "rs.i5.r.i4.syms=SYM11%2CSYM11%2CSYM11%2CSYM0%2CSYM0&";
$output .= "rs.i5.r.i5.hold=false&";
$output .= "rs.i5.r.i5.pos=17&";
$output .= "rs.i5.r.i5.syms=SYM8%2CSYM8%2CSYM8%2CSYM6%2CSYM6&";
$output .= "staticsharedurl=https%3A%2F%2F" . $staticSharedURL . "%2Fgameclient_html%2Fdevicedetection%2Fcurrent&";
