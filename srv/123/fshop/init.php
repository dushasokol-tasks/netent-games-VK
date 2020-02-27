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
	//        $nesxAct="initfreespin";
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

	$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C21%2C22%2C23%2C24&";

	$table_locked = 1;
}


$output .= "restore=" . $restore . "&";

$output .= "gamestate.stack=$gsStack&";
$output .= "nextaction=$nesxAct&";
$output .= "gamestate.current=$gsCur&";

if ($lastRsDB == '') {

	$lastRsDB = "rs.i0.r.i0.syms=SYM11%2CSYM12%2CSYM1&rs.i0.r.i1.syms=SYM9%2CSYM5%2CSYM7&rs.i0.r.i2.syms=SYM11%2CSYM12%2CSYM1&rs.i0.r.i3.syms=SYM12%2CSYM5%2CSYM9&rs.i0.r.i4.syms=SYM9%2CSYM3%2CSYM10&";
}

$output .= $lastRsDB;


$output .= "autoplay=10%2C25%2C50%2C75%2C100%2C250%2C500%2C750%2C1000&";
$output .= "autoplayLossLimitEnabled=false&";
$output .= "betlevel.all=1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10&";

$output .= "bl.i0.coins=1&";
$output .= "bl.i0.id=11&";
$output .= "bl.i0.line=0%2C1%2C0%2C1%2C0&";
$output .= "bl.i0.reelset=ALL&";
$output .= "bl.i1.coins=1&";
$output .= "bl.i1.id=12&";
$output .= "bl.i1.line=2%2C1%2C2%2C1%2C2&";
$output .= "bl.i1.reelset=ALL&";
$output .= "bl.i10.coins=1&";
$output .= "bl.i10.id=6&";
$output .= "bl.i10.line=2%2C2%2C1%2C2%2C2&";
$output .= "bl.i10.reelset=ALL&";
$output .= "bl.i11.coins=1&";
$output .= "bl.i11.id=7&";
$output .= "bl.i11.line=1%2C2%2C2%2C2%2C1&";
$output .= "bl.i11.reelset=ALL&";
$output .= "bl.i12.coins=1&";
$output .= "bl.i12.id=8&";
$output .= "bl.i12.line=1%2C0%2C0%2C0%2C1&";
$output .= "bl.i12.reelset=ALL&";
$output .= "bl.i13.coins=1&";
$output .= "bl.i13.id=9&";
$output .= "bl.i13.line=1%2C0%2C1%2C0%2C1&";
$output .= "bl.i13.reelset=ALL&";
$output .= "bl.i14.coins=1&";
$output .= "bl.i14.id=10&";
$output .= "bl.i14.line=1%2C2%2C1%2C2%2C1&";
$output .= "bl.i14.reelset=ALL&";
$output .= "bl.i2.coins=1&";
$output .= "bl.i2.id=13&";
$output .= "bl.i2.line=1%2C1%2C0%2C1%2C1&";
$output .= "bl.i2.reelset=ALL&";
$output .= "bl.i3.coins=1&";
$output .= "bl.i3.id=14&";
$output .= "bl.i3.line=1%2C1%2C2%2C1%2C1&";
$output .= "bl.i3.reelset=ALL&";
$output .= "bl.i4.coins=1&";
$output .= "bl.i4.id=0&";
$output .= "bl.i4.line=1%2C1%2C1%2C1%2C1&";
$output .= "bl.i4.reelset=ALL&";
$output .= "bl.i5.coins=1&";
$output .= "bl.i5.id=1&";
$output .= "bl.i5.line=0%2C0%2C0%2C0%2C0&";
$output .= "bl.i5.reelset=ALL&";
$output .= "bl.i6.coins=1&";
$output .= "bl.i6.id=2&";
$output .= "bl.i6.line=2%2C2%2C2%2C2%2C2&";
$output .= "bl.i6.reelset=ALL&";
$output .= "bl.i7.coins=1&";
$output .= "bl.i7.id=3&";
$output .= "bl.i7.line=0%2C1%2C2%2C1%2C0&";
$output .= "bl.i7.reelset=ALL&";
$output .= "bl.i8.coins=1&";
$output .= "bl.i8.id=4&";
$output .= "bl.i8.line=2%2C1%2C0%2C1%2C2&";
$output .= "bl.i8.reelset=ALL&";
$output .= "bl.i9.coins=1&";
$output .= "bl.i9.id=5&";
$output .= "bl.i9.line=0%2C0%2C1%2C0%2C0&";
$output .= "bl.i9.reelset=ALL&";
$output .= "bl.standard=11%2C12%2C13%2C14%2C0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10&";
$output .= "clientaction=init&";
$output .= "confirmBetMessageEnabled=false&";

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

/*
$output.= "betlevel.standard=".$betDB."&";
$output.= "denomination.standard=".$denomDB."&";
*/
//$output.= "betlevel.standard=1&";
//$output.= "denomination.standard=1&";
$output .= "gameEventSetters.enabled=false&";
$output .= "gamesoundurl=https%3A%2F%2F" . $soundURL . "&";
$output .= "iframeEnabled=false&";
$output .= "nearwinallowed=true&";
$output .= "playforfun=false&";
$output .= "restore=false&";
$output .= "rs.i0.id=basic&";
$output .= "rs.i0.r.i0.hold=false&";
$output .= "rs.i0.r.i0.pos=0&";
$output .= "rs.i0.r.i1.hold=false&";
$output .= "rs.i0.r.i1.pos=6&";
$output .= "rs.i0.r.i2.hold=false&";
$output .= "rs.i0.r.i2.pos=0&";
$output .= "rs.i0.r.i3.hold=false&";
$output .= "rs.i0.r.i3.pos=0&";
$output .= "rs.i0.r.i4.hold=false&";
$output .= "rs.i0.r.i4.pos=0&";
$output .= "s0=0&";
$output .= "s1=0&";
$output .= "staticsharedurl=https%3A%2F%2F" . $staticSharedURL . "%2Fgameclient_html%2Fdevicedetection%2Fcurrent&";
