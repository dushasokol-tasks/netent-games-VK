<?
$totalWinsDB = 0;
$total_win = 0;

$table_locked = 0;
$gsStack = "basic";
$gsCur = "basic";
$nesxAct = "spin";

$restore = "false";


if ($lastActionDB == "freespin" or $lastActionDB == "initfreespin") {

	$bonusInfo = explode(";", $answer);
	foreach ($bonusInfo as $e => $v)
		if ($v != '') {
			$a = explode("=", $v);
			$$a[0] = $a[1];
		}

	$gameover = "false";
	$restore = "true";
	$output .= "current.rs.i0=freespin&next.rs=freespin&";

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
	$lastRsDB = "rs.i0.r.i0.syms=SYM3%2CSYM12%2CSYM6&rs.i0.r.i1.syms=SYM6%2CSYM6%2CSYM4&rs.i0.r.i2.syms=SYM8%2CSYM5%2CSYM5&rs.i0.r.i3.syms=SYM12%2CSYM12%2CSYM5&rs.i0.r.i4.syms=SYM12%2CSYM12%2CSYM4&";
}

$output .= $lastRsDB;





$output .= "bl.i13.coins=1&rs.i1.r.i0.hold=false&bl.i3.coins=1&rs.i0.r.i3.pos=0&gameEventSetters.enabled=false&bl.i12.reelset=ALL&bl.i5.id=5&bl.i11.id=11&bl.i12.coins=1&bl.i24.line=0%2C0%2C1%2C0%2C0&bl.i6.id=6&bl.i24.reelset=ALL&rs.i1.r.i4.pos=0&bl.i24.coins=1&rs.i1.r.i4.syms=SYM12%2CSYM12%2CSYM3&bl.i19.coins=1&bl.i22.line=2%2C1%2C1%2C1%2C0&rs.i0.r.i2.hold=false&confirmBetMessageEnabled=false&bl.i15.line=1%2C2%2C1%2C2%2C1&rs.i1.r.i2.pos=0&bl.i3.line=0%2C1%2C2%2C1%2C0&rs.i0.r.i4.hold=false&rs.i0.r.i4.pos=0&bl.i17.line=0%2C2%2C0%2C2%2C0&bl.i13.id=13&rs.i1.r.i2.syms=SYM8%2CSYM5%2CSYM10&";

if (!isset($_Social) or $_Social == '')    $output .= "denomination.all=1%2C2%2C5%2C10%2C20%2C50%2C100%2C200&";
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
/*
$output.= "betlevel.standard=".$betDB."&";
$output.= "denomination.standard=".$denomDB."&";
*/
$output .= "bl.i19.reelset=ALL&";
$output .= "bl.i4.coins=1&bl.i5.coins=1&rs.i0.r.i0.pos=0&bl.i22.id=22&bl.i23.coins=1&bl.i22.coins=1&clientaction=init&rs.i1.r.i3.hold=false&bl.i3.reelset=ALL&bl.i14.coins=1&bl.i16.id=16&rs.i1.r.i3.syms=SYM12%2CSYM12%2CSYM5&bl.i1.coins=1&bl.i8.reelset=ALL&bl.i14.id=14&bl.i9.line=0%2C1%2C1%2C1%2C0&bl.i23.reelset=ALL&rs.i1.r.i3.pos=0&bl.i17.reelset=ALL&rs.i1.r.i0.syms=SYM10%2CSYM11%2CSYM12&rs.i0.r.i1.hold=false&";
$output .= "gamesoundurl=https%3A%2F%2F" . $soundURL . "&";
$output .= "bl.i12.id=12&bl.i10.coins=1&bl.i7.line=1%2C0%2C1%2C2%2C1&bl.i14.line=1%2C1%2C2%2C1%2C1&bl.i5.reelset=ALL&bl.i18.line=2%2C0%2C2%2C0%2C2&rs.i1.r.i4.hold=false&rs.i0.r.i2.pos=0&bl.i8.coins=1&bl.i23.id=23&bl.i6.coins=1&bl.i14.reelset=ALL&betlevel.all=1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10&rs.i0.r.i3.hold=false&bl.i2.coins=1&bl.i7.reelset=ALL&bl.i10.id=10&bl.i4.line=2%2C1%2C0%2C1%2C2&bl.i5.line=0%2C0%2C1%2C2%2C2&bl.i1.line=0%2C0%2C0%2C0%2C0&bl.i6.line=2%2C2%2C1%2C0%2C0&bl.i4.id=4&bl.i20.id=20&bl.i11.line=1%2C0%2C0%2C0%2C1&bl.i8.line=1%2C2%2C1%2C0%2C1&bl.i8.id=8&bl.i7.coins=1&bl.i17.coins=1&bl.i4.reelset=ALL&rs.i1.id=basic&bl.i1.reelset=ALL&bl.i22.reelset=ALL&bl.i2.reelset=ALL&bl.i19.id=19&bl.i24.id=24&rs.i1.r.i2.hold=false&rs.i0.r.i0.hold=false&bl.i10.line=2%2C1%2C1%2C1%2C2&bl.i20.line=2%2C1%2C2%2C1%2C2&bl.i18.id=18&bl.i9.reelset=ALL&bl.i0.coins=1&bl.i0.id=0&autoplay=10%2C25%2C50%2C75%2C100%2C250%2C500%2C750%2C1000&bl.i17.id=17&bl.i11.coins=1&bl.i15.id=15&bl.i15.reelset=ALL&bl.i16.coins=1&bl.i11.reelset=ALL&bl.i3.id=3&bl.i2.id=2&bl.standard=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C21%2C22%2C23%2C24&bl.i21.line=0%2C1%2C1%2C1%2C2&rs.i1.r.i0.pos=0&bl.i12.line=1%2C2%2C2%2C2%2C1&bl.i19.line=0%2C1%2C0%2C1%2C0&rs.i1.r.i1.syms=SYM8%2CSYM5%2CSYM5&bl.i6.reelset=ALL&bl.i21.coins=1&bl.i2.line=2%2C2%2C2%2C2%2C2&";
$output .= "bl.i10.reelset=ALL&autoplayLossLimitEnabled=false&bl.i18.reelset=ALL&bl.i21.reelset=ALL&bl.i7.id=7&bl.i20.coins=1&nearwinallowed=true&bl.i16.reelset=ALL&bl.i9.id=9&bl.i9.coins=1&bl.i23.line=2%2C2%2C1%2C2%2C2&bl.i0.reelset=ALL&rs.i1.r.i1.hold=false&rs.i1.r.i1.pos=10&bl.i16.line=1%2C0%2C1%2C0%2C1&rs.i0.id=freespin&iframeEnabled=false&playforfun=false&bl.i18.coins=1&bl.i15.coins=1&bl.i0.line=1%2C1%2C1%2C1%2C1&";
$output .= "staticsharedurl=https%3A%2F%2F" . $staticSharedURL . "%2Fgameclient_html%2Fdevicedetection%2Fcurrent&";
$output .= "bl.i13.reelset=ALL&bl.i20.reelset=ALL&bl.i1.id=1&bl.i13.line=1%2C1%2C0%2C1%2C1&bl.i21.id=21&rs.i0.r.i1.pos=0&";
