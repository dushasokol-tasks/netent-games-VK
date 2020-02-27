<?
$table_locked = 0;
$gsStack = "basic";
$gsCur = "basic";
$nesxAct = "spin";

$restore = "false";

if ($lastActionDB == "respin") {
	$gameover = "false";
	$restore = "true";
	$output .= "current.rs.i0=respin&next.rs=respin&wildstacks.respin=$wildsDB&";
	$gsStack = "basic%2Crespin";
	$gsCur = "respin";
	$nesxAct = "respin";
	$answ = "restoreAction=respin;wildStcks=" . $wildsDB . ";";
	$table_locked = 1;
}

if ($lastActionDB == "freespin" or $lastActionDB == "startfreespin") {

	$bonusInfo = explode(";", $answer);
	foreach ($bonusInfo as $e => $v)
		if ($v != '') {
			$a = explode("=", $v);
			$$a[0] = $a[1];
		}

	$gameover = "false";
	$restore = "true";
	$output .= "current.rs.i0=freespin&next.rs=freespin&";
	if ($wildsDB != '') {
		$output .= "wildstacks.freespin=$wildsDB&";
		$answ .= "wildStcks=" . $wildsDB . ";";
	}
	$gsStack = "basic%2Cfreespin";
	$gsCur = "freespin";
	$nesxAct = "freespin";
	$answ .= "restoreAction=freespin;" . $answer;


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
	$lastRsDB = "rs.i0.r.i0.syms=SYM6%2CSYM4%2CSYM7&rs.i0.r.i1.syms=SYM5%2CSYM3%2CSYM8&rs.i0.r.i2.syms=SYM4%2CSYM7%2CSYM6&rs.i0.r.i3.syms=SYM7%2CSYM8%2CSYM5&rs.i0.r.i4.syms=SYM4%2CSYM7%2CSYM6&";
}


$output .= $lastRsDB;


$output .= "iframeEnabled=false&clientaction=init&gameEventSetters.enabled=false&confirmBetMessageEnabled=false&nearwinallowed=true&hotlines=1&gamestate.history=basic&betlevel.all=1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10&autoplay=10%2C25%2C50%2C75%2C100%2C250%2C500%2C750%2C1000&bet.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C21%2C22%2C23%2C24%2C25%2C26%2C27%2C28%2C29&";
$output .= "staticsharedurl=https%3A%2F%2F" . $staticSharedURL . "%2Fgameclient_html%2Fdevicedetection%2Fcurrent&";
$output .= "gamesoundurl=https%3A%2F%2F" . $soundURL . "&";

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


$output .= "bet.betlevel=10&playforfun=false&bet.denomination=" . $denomDB . "&autoplayLossLimitEnabled=false&";

$output .= "rs.i11.r.i4.pos=50&rs.i3.r.i0.pos=0&rs.i6.r.i0.pos=0&rs.i9.r.i1.pos=0&rs.i1.r.i2.pos=0&rs.i16.r.i1.pos=0&rs.i7.r.i4.pos=0&rs.i10.r.i1.pos=0&rs.i4.r.i3.pos=0&rs.i13.r.i2.pos=0&rs.i16.r.i3.pos=0&rs.i13.r.i0.pos=0&rs.i9.r.i0.pos=0&rs.i11.r.i3.pos=29&rs.i14.r.i4.pos=0&rs.i0.r.i1.pos=0&rs.i13.r.i3.pos=0&rs.i16.r.i0.pos=0&rs.i4.r.i4.pos=0&rs.i1.r.i3.pos=0&rs.i10.r.i2.pos=0&rs.i15.r.i1.pos=0&rs.i6.r.i3.pos=0&rs.i1.r.i0.pos=0&rs.i11.r.i2.pos=120&rs.i2.r.i4.pos=0&rs.i8.r.i4.pos=0&rs.i6.r.i2.pos=0&rs.i13.r.i4.pos=0&rs.i11.r.i1.pos=109&rs.i12.r.i4.pos=0&rs.i7.r.i2.pos=0&rs.i7.r.i3.pos=0&rs.i6.r.i1.pos=0&rs.i15.r.i0.pos=0&rs.i5.r.i0.pos=0&rs.i0.r.i0.pos=0&rs.i2.r.i3.pos=0&rs.i1.r.i1.pos=0&rs.i3.r.i4.pos=0&rs.i12.r.i3.pos=0&rs.i10.r.i0.pos=0&rs.i16.r.i2.pos=0&rs.i14.r.i0.pos=0&rs.i15.r.i3.pos=0&rs.i0.r.i4.pos=0&rs.i5.r.i2.pos=0&rs.i8.r.i2.pos=0&rs.i5.r.i1.pos=0&rs.i12.r.i2.pos=0&rs.i2.r.i2.pos=0&rs.i15.r.i2.pos=0&rs.i14.r.i1.pos=0&rs.i6.r.i4.pos=0&rs.i3.r.i3.pos=0&rs.i8.r.i3.pos=0&rs.i11.r.i0.pos=7&rs.i12.r.i1.pos=0&rs.i4.r.i0.pos=0&rs.i9.r.i4.pos=0&rs.i7.r.i1.pos=0&rs.i2.r.i1.pos=0&rs.i5.r.i4.pos=0&rs.i8.r.i0.pos=0&rs.i10.r.i3.pos=0&rs.i16.r.i4.pos=0&rs.i4.r.i1.pos=0&rs.i9.r.i3.pos=0&rs.i14.r.i2.pos=0&rs.i0.r.i2.pos=0&rs.i12.r.i0.pos=0&rs.i3.r.i2.pos=0&rs.i1.r.i4.pos=0&rs.i2.r.i0.pos=0&rs.i9.r.i2.pos=0&rs.i4.r.i2.pos=0&rs.i8.r.i1.pos=0&rs.i5.r.i3.pos=0&rs.i7.r.i0.pos=0&rs.i0.r.i3.pos=0&rs.i14.r.i3.pos=0&rs.i3.r.i1.pos=0&rs.i15.r.i4.pos=0&rs.i13.r.i1.pos=0&rs.i10.r.i4.pos=0&";
$output .= "morphsymbols.i1.origin=SYM13&morphsymbols.i0.target.i4=SYM5&morphsymbols.i0.target.i2=SYM5&morphsymbols.i0.target.i0=SYM5&morphsymbols.i0.target.i3=SYM5&morphsymbols.i0.target.i1=SYM5&morphsymbols.i2.origin=SYM12&morphsymbols.i2.target.i2=SYM4&morphsymbols.i2.target.i3=SYM4&morphsymbols.i2.target.i0=SYM3&morphsymbols.i2.target.i1=SYM5&morphsymbols.i2.target.i4=SYM5&morphsymbols.i1.target.i1=SYM3&morphsymbols.i1.target.i4=SYM8&morphsymbols.i1.target.i3=SYM5&morphsymbols.i1.target.i0=SYM4&morphsymbols.i1.target.i2=SYM4&morphsymbols.i0.origin=SYM11&";
$output .= "rs.i0.id=basic12b&rs.i2.id=freespin12&rs.i3.id=freespin1&rs.i16.id=basic12&rs.i4.id=basic2&rs.i15.id=freespin_nowilds1&rs.i5.id=freespin_nowilds12&rs.i14.id=freespin_last123&rs.i6.id=freespin123&rs.i13.id=respin&rs.i7.id=freespin_last12&rs.i12.id=basic123&rs.i8.id=basic2b&rs.i11.id=basic&rs.i9.id=basic123b&rs.i10.id=freespin_nowilds123&rs.i1.id=freespin_last1&";
$output .= "rs.i11.r.i1.overlay.i2.with=SYM1&rs.i11.r.i1.overlay.i1.with=SYM1&rs.i11.r.i3.overlay.i0.with=SYM5&rs.i11.r.i1.overlay.i0.row=0&rs.i11.r.i1.overlay.i0.with=SYM1&rs.i11.r.i3.overlay.i0.row=2&";
$output .= "rs.i11.r.i1.overlay.i0.pos=109&rs.i11.r.i1.overlay.i1.pos=110&rs.i11.r.i3.overlay.i0.pos=31&rs.i11.r.i1.overlay.i2.row=2&rs.i11.r.i1.overlay.i2.pos=111&rs.i11.r.i1.overlay.i1.row=1&";

$output .= "bl.i26.line=1%2C0%2C2%2C0%2C1&bl.i14.coins=0&bl.i4.id=4&bl.i7.coins=0&bl.i12.id=12&bl.i8.coins=0&bl.i23.id=23&bl.i15.coins=0&bl.i8.line=1%2C0%2C0%2C0%2C1&bl.i16.reelset=ALL&bl.i28.reelset=ALL&bl.i21.coins=0&bl.i1.line=0%2C0%2C0%2C0%2C0&bl.i21.line=0%2C0%2C2%2C0%2C0&bl.i16.line=2%2C1%2C1%2C1%2C2&bl.i11.reelset=ALL&bl.i9.reelset=ALL&bl.i17.coins=0&bl.i11.id=11&bl.i18.line=2%2C0%2C2%2C0%2C2&bl.i3.line=0%2C1%2C2%2C1%2C0&bl.i4.reelset=ALL&bl.i4.coins=0&bl.i22.reelset=ALL&bl.i11.coins=0&bl.i23.coins=0&bl.i10.reelset=ALL&bl.i13.id=13&bl.i22.coins=0&bl.i24.id=24&bl.i16.coins=0&bl.i9.coins=0&bl.i10.coins=0&bl.i3.coins=0&bl.i5.id=5&bl.i11.line=0%2C1%2C0%2C1%2C0&bl.i15.reelset=ALL&bl.standard=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C21%2C22%2C23%2C24%2C25%2C26%2C27%2C28%2C29&bl.i25.coins=0&bl.i1.coins=0&bl.i18.reelset=ALL&bl.i7.id=7&bl.i19.coins=0&bl.i20.id=20&bl.i19.line=0%2C2%2C2%2C2%2C0&bl.i12.reelset=ALL&bl.i6.id=6&bl.i27.coins=0&bl.i12.line=2%2C1%2C2%2C1%2C2&bl.i29.reelset=ALL&bl.i22.id=22&bl.i6.line=2%2C2%2C1%2C2%2C2&bl.i8.id=8&bl.i28.line=1%2C2%2C2%2C2%2C0&bl.i12.coins=0&bl.i3.reelset=ALL&bl.i26.reelset=ALL&bl.i24.line=2%2C0%2C1%2C0%2C2&bl.i10.id=10&bl.i20.coins=0&bl.i23.reelset=ALL&bl.i0.reelset=ALL&bl.i21.id=21&bl.i6.coins=0&bl.i6.reelset=ALL&bl.i20.line=2%2C0%2C0%2C0%2C2&bl.i20.reelset=ALL&bl.i29.id=29&bl.i2.line=2%2C2%2C2%2C2%2C2&bl.i17.id=17&bl.i1.reelset=ALL&bl.i28.id=28&bl.i19.reelset=ALL&bl.i9.id=9&bl.i17.line=0%2C2%2C0%2C2%2C0&bl.i19.id=19&bl.i15.line=0%2C1%2C1%2C1%2C0&bl.i0.id=0&bl.i13.reelset=ALL&bl.i25.reelset=ALL&bl.i9.line=1%2C0%2C1%2C0%2C1&bl.i29.coins=0&bl.i7.reelset=ALL&bl.i27.line=0%2C1%2C1%2C1%2C2&bl.i7.line=1%2C2%2C2%2C2%2C1&bl.i28.coins=0&bl.i5.line=0%2C0%2C1%2C0%2C0&bl.i18.id=18&bl.i25.line=1%2C2%2C0%2C2%2C1&bl.i23.line=0%2C2%2C1%2C2%2C0&bl.i26.id=26&bl.i27.reelset=ALL&bl.i29.line=2%2C0%2C0%2C0%2C1&bl.i26.coins=0&bl.i0.coins=30&bl.i2.reelset=ALL&bl.i13.line=1%2C1%2C0%2C1%2C1&bl.i24.reelset=ALL&bl.i14.line=1%2C1%2C2%2C1%2C1&bl.i5.reelset=ALL&bl.i24.coins=0&bl.i14.id=14&bl.i2.coins=0&bl.i21.reelset=ALL&bl.i25.id=25&bl.i1.id=1&bl.i0.line=1%2C1%2C1%2C1%2C1&bl.i5.coins=0&bl.i16.id=16&bl.i22.line=2%2C2%2C0%2C2%2C2&bl.i3.id=3&bl.i8.reelset=ALL&bl.i14.reelset=ALL&bl.i13.coins=0&bl.i27.id=27&bl.i18.coins=0&bl.i10.line=1%2C2%2C1%2C2%2C1&bl.i17.reelset=ALL&bl.i4.line=2%2C1%2C0%2C1%2C2&bl.i15.id=15&bl.i2.id=2&";
$output .= "rs.i2.r.i2.hold=false&rs.i12.r.i2.hold=false&rs.i10.r.i0.hold=false&rs.i0.r.i0.hold=false&rs.i7.r.i1.hold=false&rs.i3.r.i4.hold=false&rs.i16.r.i1.hold=false&rs.i14.r.i4.hold=false&rs.i6.r.i1.hold=false&rs.i11.r.i2.hold=false&rs.i11.r.i0.hold=false&rs.i4.r.i4.hold=false&rs.i5.r.i4.hold=false&rs.i5.r.i1.hold=false&rs.i15.r.i4.hold=false&rs.i14.r.i2.hold=false&rs.i6.r.i4.hold=false&rs.i9.r.i0.hold=false&rs.i13.r.i4.hold=false&rs.i12.r.i4.hold=false&rs.i13.r.i2.hold=false&rs.i0.r.i3.hold=false&rs.i3.r.i0.hold=false&rs.i1.r.i4.hold=false&rs.i10.r.i3.hold=false&rs.i4.r.i1.hold=false&rs.i4.r.i2.hold=false&rs.i5.r.i3.hold=false&rs.i12.r.i0.hold=false&rs.i16.r.i3.hold=false&rs.i8.r.i1.hold=false&rs.i15.r.i1.hold=false&rs.i7.r.i3.hold=false&rs.i14.r.i3.hold=false&rs.i0.r.i2.hold=false&rs.i1.r.i0.hold=false&rs.i12.r.i3.hold=false&rs.i13.r.i1.hold=false&rs.i9.r.i3.hold=false&rs.i11.r.i1.hold=false&rs.i1.r.i1.hold=false&rs.i9.r.i4.hold=false&rs.i3.r.i3.hold=false&rs.i16.r.i0.hold=false&rs.i7.r.i2.hold=false&rs.i5.r.i0.hold=false&rs.i4.r.i3.hold=false&rs.i6.r.i0.hold=false&rs.i10.r.i1.hold=false&rs.i8.r.i4.hold=false&rs.i9.r.i2.hold=false&rs.i16.r.i2.hold=false&rs.i6.r.i2.hold=false&rs.i7.r.i0.hold=false&rs.i10.r.i4.hold=false&rs.i0.r.i1.hold=false&rs.i15.r.i0.hold=false&rs.i2.r.i3.hold=false&rs.i3.r.i1.hold=false&rs.i14.r.i0.hold=false&rs.i1.r.i3.hold=false&rs.i8.r.i2.hold=false&rs.i7.r.i4.hold=false&rs.i2.r.i1.hold=false&rs.i11.r.i4.hold=false&rs.i6.r.i3.hold=false&rs.i8.r.i0.hold=false&rs.i13.r.i0.hold=false&rs.i15.r.i2.hold=false&rs.i15.r.i3.hold=false&rs.i16.r.i4.hold=false&rs.i10.r.i2.hold=false&rs.i5.r.i2.hold=false&rs.i3.r.i2.hold=false&rs.i12.r.i1.hold=false&rs.i4.r.i0.hold=false&rs.i2.r.i4.hold=false&rs.i11.r.i3.hold=false&rs.i2.r.i0.hold=false&rs.i1.r.i2.hold=false&rs.i14.r.i1.hold=false&rs.i8.r.i3.hold=false&rs.i9.r.i1.hold=false&rs.i13.r.i3.hold=false&rs.i0.r.i4.hold=false&";
$output .= "rs.i9.r.i4.syms=SYM6%2CSYM4%2CSYM7&rs.i2.r.i3.syms=SYM7%2CSYM5%2CSYM8&rs.i11.r.i1.syms=SYM13%2CSYM1%2CSYM12&rs.i13.r.i3.syms=SYM4%2CSYM8%2CSYM6&rs.i15.r.i0.syms=SYM5%2CSYM5%2CSYM5&rs.i3.r.i3.syms=SYM8%2CSYM11%2CSYM6&rs.i16.r.i0.syms=SYM3%2CSYM3%2CSYM11&rs.i6.r.i0.syms=SYM8%2CSYM8%2CSYM7&rs.i10.r.i1.syms=SYM12%2CSYM13%2CSYM1&rs.i16.r.i2.syms=SYM3%2CSYM3%2CSYM11&rs.i5.r.i0.syms=SYM7%2CSYM7%2CSYM7&rs.i14.r.i0.syms=SYM11%2CSYM8%2CSYM8&rs.i7.r.i0.syms=SYM11%2CSYM11%2CSYM11&rs.i6.r.i2.syms=SYM6%2CSYM6%2CSYM7&rs.i9.r.i2.syms=SYM6%2CSYM4%2CSYM7&rs.i8.r.i4.syms=SYM7%2CSYM7%2CSYM4&rs.i2.r.i1.syms=SYM7%2CSYM5%2CSYM8&rs.i1.r.i3.syms=SYM7%2CSYM6%2CSYM8&rs.i8.r.i2.syms=SYM7%2CSYM4%2CSYM11&rs.i10.r.i4.syms=SYM6%2CSYM6%2CSYM11&rs.i7.r.i4.syms=SYM7%2CSYM7%2CSYM8&rs.i1.r.i1.syms=SYM8%2CSYM4%2CSYM6&rs.i7.r.i2.syms=SYM7%2CSYM7%2CSYM8&rs.i13.r.i0.syms=SYM7%2CSYM7%2CSYM7&rs.i8.r.i0.syms=SYM7%2CSYM7%2CSYM4&rs.i9.r.i1.syms=SYM5%2CSYM11%2CSYM3&rs.i3.r.i1.syms=SYM8%2CSYM8%2CSYM6&rs.i2.r.i0.syms=SYM5%2CSYM3%2CSYM7&rs.i16.r.i4.syms=SYM8%2CSYM3%2CSYM5&rs.i5.r.i2.syms=SYM5%2CSYM5%2CSYM8&rs.i15.r.i2.syms=SYM11%2CSYM3%2CSYM3&rs.i3.r.i2.syms=SYM11%2CSYM11%2CSYM5&rs.i15.r.i3.syms=SYM5%2CSYM5%2CSYM5&rs.i11.r.i3.syms=SYM8%2CSYM8%2CSYM11&rs.i12.r.i1.syms=SYM11%2CSYM6%2CSYM7&rs.i4.r.i0.syms=SYM3%2CSYM8%2CSYM8&rs.i5.r.i1.syms=SYM4%2CSYM4%2CSYM4&rs.i4.r.i3.syms=SYM4%2CSYM6%2CSYM7&rs.i14.r.i1.syms=SYM7%2CSYM7%2CSYM8&rs.i6.r.i3.syms=SYM8%2CSYM6%2CSYM6&rs.i7.r.i1.syms=SYM7%2CSYM7%2CSYM8&rs.i8.r.i3.syms=SYM5%2CSYM5%2CSYM3&rs.i3.r.i4.syms=SYM11%2CSYM8%2CSYM8&rs.i13.r.i4.syms=SYM8%2CSYM7%2CSYM5&rs.i1.r.i2.syms=SYM7%2CSYM6%2CSYM8&rs.i6.r.i1.syms=SYM6%2CSYM6%2CSYM4&rs.i2.r.i2.syms=SYM8%2CSYM6%2CSYM4&rs.i14.r.i4.syms=SYM11%2CSYM4%2CSYM4&rs.i9.r.i3.syms=SYM5%2CSYM11%2CSYM3&rs.i10.r.i0.syms=SYM11%2CSYM7%2CSYM7&rs.i2.r.i4.syms=SYM8%2CSYM5%2CSYM7&rs.i16.r.i1.syms=SYM7%2CSYM6%2CSYM4&rs.i11.r.i0.syms=SYM5%2CSYM8%2CSYM8&rs.i12.r.i4.syms=SYM3%2CSYM11%2CSYM7&rs.i13.r.i2.syms=SYM7%2CSYM8%2CSYM8&rs.i4.r.i4.syms=SYM3%2CSYM8%2CSYM8&rs.i10.r.i2.syms=SYM6%2CSYM11%2CSYM11&rs.i9.r.i0.syms=SYM6%2CSYM4%2CSYM7&rs.i12.r.i0.syms=SYM3%2CSYM11%2CSYM7&rs.i11.r.i2.syms=SYM3%2CSYM3%2CSYM3&rs.i5.r.i4.syms=SYM11%2CSYM11%2CSYM11&rs.i12.r.i2.syms=SYM3%2CSYM11%2CSYM7&rs.i11.r.i4.syms=SYM6%2CSYM6%2CSYM7&rs.i6.r.i4.syms=SYM8%2CSYM6%2CSYM7&rs.i5.r.i3.syms=SYM6%2CSYM6%2CSYM6&rs.i4.r.i2.syms=SYM6%2CSYM3%2CSYM11&rs.i10.r.i3.syms=SYM8%2CSYM8%2CSYM8&rs.i14.r.i2.syms=SYM11%2CSYM11%2CSYM8&rs.i4.r.i1.syms=SYM4%2CSYM6%2CSYM6&rs.i3.r.i0.syms=SYM7%2CSYM12%2CSYM13&rs.i1.r.i4.syms=SYM7%2CSYM8%2CSYM6&rs.i16.r.i3.syms=SYM7%2CSYM6%2CSYM4&rs.i15.r.i1.syms=SYM12%2CSYM13%2CSYM1&rs.i15.r.i4.syms=SYM8%2CSYM8%2CSYM12&rs.i14.r.i3.syms=SYM6%2CSYM6%2CSYM8&rs.i8.r.i1.syms=SYM3%2CSYM5%2CSYM8&rs.i7.r.i3.syms=SYM8%2CSYM8%2CSYM7&rs.i12.r.i3.syms=SYM11%2CSYM6%2CSYM7&rs.i13.r.i1.syms=SYM8%2CSYM6%2CSYM11&rs.i1.r.i0.syms=SYM6%2CSYM7%2CSYM8&";
