<?
$table_locked = 0;
$gsStack = "basic";
$gsCur = "basic";
$gsHis = "basic";
$nesxAct = "spin";

$restore = "false";

if ($lastActionDB == "drop" or $lastActionDB == "drop1" or $lastActionDB == "freespin") {
	$gameover = "false";
	$restore = "true";

	if (isset($fs_left)) {
		$gsStack = "basic%2Cfreespin";
		$gsCur = "freespin";
		$gsHis = "basic%2Cfreespin";

		$output .= "current.rs.i0=freespin&";
		$output .= "next.rs=freespin&";
		$output .= "last.rs=freespin&";
		$output .= "previous.rs.i0=freespin&";

		$answ = "restoreAction=drop;colossalSym=$colossalSym;colossalSize=$colossalSize;colossalX=$colossalX;colossalY=$colossalY;colossalFinalX=$colossalFinalX;colossalFinalY=$colossalFinalY;symsShiftedDB=$symsShiftedDB;symsOrigDB=$symsOrigDB;symsLastDB=$symsLastDB;fs_left=$fs_left;fs_played=$fs_played;fs_totalwin=$fs_totalwin;fs_multiplier=$fs_multiplier;fs_initial=$fs_initial;startFS=$startFS;hasColossal=$hasColossal;";
	} else {
		$gsStack = "basic";
		$gsCur = "basic";
		$gsHis = "basic";

		$output .= "current.rs.i0=basic&";
		$output .= "next.rs=basic&";
		$output .= "last.rs=basic&";
		$output .= "previous.rs.i0=basic&";

		if (isset($colossalSym) and $hasColossal > 0) {
			$output .= "restoreColossal.colossalSize=$colossalSize&";
			$output .= "restoreColossal.colossalFinalX=$colossalFinalX&";
			$output .= "restoreColossal.colossalFinalY=$colossalFinalY&";
			$output .= "restoreColossal.colossalType=SYM" . $colossalSym . "&";
		}


		$answ = "restoreAction=drop;colossalSym=$colossalSym;colossalSize=$colossalSize;colossalX=$colossalX;colossalY=$colossalY;colossalFinalX=$colossalFinalX;colossalFinalY=$colossalFinalY;symsShiftedDB=$symsShiftedDB;symsOrigDB=$symsOrigDB;symsLastDB=$symsLastDB;hasColossal=$hasColossal;";
	}
	$nesxAct = "drop";

	$table_locked = 1;





	$output .= "freespins.betlevel=$betDB&";
	$output .= "freespins.initial=$fs_initial&";
	$output .= "freespins.totalwin.coins=$fs_totalwin&";
	$output .= "freespins.win.coins=$fs_totalwin&";
	$output .= "freespins.win.cents=$fs_totalwin&";
	$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19&";
	$output .= "freespins.wavecount=1&";
	$output .= "freespins.denomination=$denomDB&";
	$output .= "freespins.total=" . ($fs_played + $fs_left) . "&";
	$output .= "freespins.multiplier=1&";
	$output .= "freespins.left=$fs_left&";
	$output .= "freespins.totalwin.cents=$fs_totalwin&";
}


$output .= "restore=" . $restore . "&";

$output .= "rs.i0.id=basic&";
$output .= "rs.i1.id=freespin&";


$output .= "clientaction=init&";


$output .= "gamestate.stack=$gsStack&";
$output .= "nextaction=$nesxAct&";
$output .= "gamestate.current=$gsCur&";
$output .= "gamestate.history=$gsHis&";




//if($lastRsDB=='')
//{
//    $lastRsDB="rs.i0.r.i0.syms=SYM6%2CSYM4%2CSYM7&rs.i0.r.i1.syms=SYM5%2CSYM3%2CSYM8&rs.i0.r.i2.syms=SYM4%2CSYM7%2CSYM6&rs.i0.r.i3.syms=SYM7%2CSYM8%2CSYM5&rs.i0.r.i4.syms=SYM4%2CSYM7%2CSYM6&";

$output .= "rs.i1.r.i0.syms=SYM10%2CSYM10%2CSYM10&";
$output .= "rs.i1.r.i1.syms=SYM10%2CSYM10%2CSYM10&";
$output .= "rs.i1.r.i2.syms=SYM10%2CSYM10%2CSYM10&";
$output .= "rs.i1.r.i3.syms=SYM8%2CSYM3%2CSYM7&";
$output .= "rs.i1.r.i4.syms=SYM8%2CSYM9%2CSYM9&";
//}
//else
//$output.=$lastRsDB;



$output .= "autoplay=10%2C25%2C50%2C75%2C100%2C250%2C500%2C750%2C1000&";

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

$output .= "bet.betlevel=10&";
$output .= "bet.denomination=" . $denomDB . "&";

$output .= "confirmBetMessageEnabled=false&";
$output .= "iframeEnabled=false&";
$output .= "nearwinallowed=true&";
$output .= "staticsharedurl=https%3A%2F%2F" . $staticSharedURL . "%2Fgameclient_html%2Fdevicedetection%2Fcurrent&";
$output .= "gamesoundurl=https%3A%2F%2F" . $soundURL . "&";
$output .= "gameEventSetters.enabled=false&";
$output .= "autoplayLossLimitEnabled=false&";
$output .= "playforfun=false&";
$output .= "bet.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19&";
$output .= "betlevel.all=1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10&";



$output .= "bl.standard=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19&";
$output .= "bl.i17.reelset=ALL&";
$output .= "bl.i15.id=15&";
$output .= "bl.i10.line=1%2C2%2C1%2C2%2C1&";
$output .= "bl.i18.coins=1&";
$output .= "bl.i4.line=2%2C1%2C0%2C1%2C2&";
$output .= "bl.i13.coins=1&";
$output .= "bl.i13.reelset=ALL&";
$output .= "bl.i0.id=0&";
$output .= "bl.i15.line=0%2C1%2C1%2C1%2C0&";
$output .= "bl.i19.id=19&";
$output .= "bl.i9.id=9&";
$output .= "bl.i17.line=0%2C2%2C0%2C2%2C0&";
$output .= "bl.i1.reelset=ALL&";
$output .= "bl.i17.id=17&";
$output .= "bl.i19.reelset=ALL&";
$output .= "bl.i2.line=2%2C2%2C2%2C2%2C2&";
$output .= "bl.i6.reelset=ALL&";
$output .= "bl.i6.coins=1&";
$output .= "bl.i0.reelset=ALL&";
$output .= "bl.i10.id=10&";
$output .= "bl.i3.reelset=ALL&";
$output .= "bl.i12.coins=1&";
$output .= "bl.i8.id=8&";
$output .= "bl.i6.line=2%2C2%2C1%2C2%2C2&";
$output .= "bl.i12.line=2%2C1%2C2%2C1%2C2&";
$output .= "bl.i19.line=0%2C2%2C2%2C2%2C0&";
$output .= "bl.i12.reelset=ALL&";
$output .= "bl.i6.id=6&";
$output .= "bl.i19.coins=1&";
$output .= "bl.i18.reelset=ALL&";
$output .= "bl.i7.id=7&";
$output .= "bl.i1.coins=1&";
$output .= "bl.i3.line=0%2C1%2C2%2C1%2C0&";
$output .= "bl.i4.reelset=ALL&";
$output .= "bl.i4.coins=1&";
$output .= "bl.i11.id=11&";
$output .= "bl.i18.line=2%2C0%2C2%2C0%2C2&";
$output .= "bl.i9.reelset=ALL&";
$output .= "bl.i17.coins=1&";
$output .= "bl.i1.line=0%2C0%2C0%2C0%2C0&";
$output .= "bl.i8.line=1%2C0%2C0%2C0%2C1&";
$output .= "bl.i8.coins=1&";
$output .= "bl.i15.coins=1&";
$output .= "bl.i12.id=12&";
$output .= "bl.i4.id=4&";
$output .= "bl.i7.coins=1&";
$output .= "bl.i14.coins=1&";
$output .= "bl.i16.reelset=ALL&";
$output .= "bl.i11.reelset=ALL&";
$output .= "bl.i16.line=2%2C1%2C1%2C1%2C2&";
$output .= "bl.i11.coins=1&";
$output .= "bl.i15.reelset=ALL&";
$output .= "bl.i11.line=0%2C1%2C0%2C1%2C0&";
$output .= "bl.i5.id=5&";
$output .= "bl.i10.coins=1&";
$output .= "bl.i16.coins=1&";
$output .= "bl.i9.coins=1&";
$output .= "bl.i13.id=13&";
$output .= "bl.i10.reelset=ALL&";
$output .= "bl.i3.coins=1&";
$output .= "bl.i5.reelset=ALL&";
$output .= "bl.i14.line=1%2C1%2C2%2C1%2C1&";
$output .= "bl.i13.line=1%2C1%2C0%2C1%2C1&";
$output .= "bl.i0.coins=1&";
$output .= "bl.i18.id=18&";
$output .= "bl.i5.line=0%2C0%2C1%2C0%2C0&";
$output .= "bl.i7.line=1%2C2%2C2%2C2%2C1&";
$output .= "bl.i7.reelset=ALL&";
$output .= "bl.i9.line=1%2C0%2C1%2C0%2C1&";
$output .= "bl.i2.reelset=ALL&";
$output .= "bl.i2.id=2&";
$output .= "bl.i14.reelset=ALL&";
$output .= "bl.i3.id=3&";
$output .= "bl.i8.reelset=ALL&";
$output .= "bl.i16.id=16&";
$output .= "bl.i5.coins=1&";
$output .= "bl.i0.line=1%2C1%2C1%2C1%2C1&";
$output .= "bl.i1.id=1&";
$output .= "bl.i14.id=14&";
$output .= "bl.i2.coins=1&";


$output .= "rs.i0.r.i0.syms=SYM10%2CSYM10%2CSYM10%2CSYM7%2CSYM1%2CSYM1%2CSYM7%2CSYM5&";
$output .= "rs.i0.r.i1.syms=SYM9%2CSYM5%2CSYM10%2CSYM4%2CSYM8%2CSYM7%2CSYM3%2CSYM10&";
$output .= "rs.i0.r.i2.syms=SYM5%2CSYM4%2CSYM5%2CSYM1%2CSYM3%2CSYM7%2CSYM7%2CSYM6&";
$output .= "rs.i0.r.i3.syms=SYM9%2CSYM6%2CSYM7%2CSYM1%2CSYM5%2CSYM9%2CSYM3%2CSYM5&";
$output .= "rs.i0.r.i4.syms=SYM8%2CSYM7%2CSYM6%2CSYM9%2CSYM10%2CSYM1%2CSYM6%2CSYM9&";
$output .= "rs.i0.r.i5.syms=SYM16%2CSYM16%2CSYM16&";
$output .= "rs.i0.r.i6.syms=SYM12%2CSYM16%2CSYM16&";
$output .= "rs.i0.r.i7.syms=SYM12%2CSYM16%2CSYM16&";
$output .= "rs.i0.r.i8.syms=SYM16%2CSYM16%2CSYM16&";
$output .= "rs.i0.r.i9.syms=SYM16%2CSYM16%2CSYM16&";


$output .= "rs.i1.r.i5.syms=SYM12%2CSYM12%2CSYM12&";
$output .= "rs.i1.r.i6.syms=SYM12%2CSYM12%2CSYM12&";
$output .= "rs.i1.r.i7.syms=SYM12%2CSYM12%2CSYM12&";
$output .= "rs.i1.r.i8.syms=SYM16%2CSYM16%2CSYM16&";
$output .= "rs.i1.r.i9.syms=SYM16%2CSYM16%2CSYM16&";

$output .= "rs.i0.r.i0.lastsyms=null%2Cnull%2CSYM10&";
$output .= "rs.i0.r.i1.lastsyms=null%2Cnull%2CSYM10&";
$output .= "rs.i0.r.i2.lastsyms=null%2CSYM5%2Cnull&";
$output .= "rs.i0.r.i3.lastsyms=SYM6%2CSYM5%2CSYM7&";
$output .= "rs.i0.r.i4.lastsyms=SYM9%2CSYM10%2CSYM6&";

$output .= "rs.i1.r.i0.lastsyms=null&";
$output .= "rs.i1.r.i1.lastsyms=null&";
$output .= "rs.i1.r.i2.lastsyms=null&";
$output .= "rs.i1.r.i3.lastsyms=null&";
$output .= "rs.i1.r.i4.lastsyms=null&";

$output .= "rs.i0.r.i5.pos=177&";
$output .= "rs.i0.r.i6.pos=177&";
$output .= "rs.i0.r.i7.pos=177&";
$output .= "rs.i0.r.i8.pos=177&";
$output .= "rs.i0.r.i9.pos=177&";

$output .= "rs.i1.r.i5.pos=189&";
$output .= "rs.i1.r.i6.pos=189&";
$output .= "rs.i1.r.i7.pos=189&";
$output .= "rs.i1.r.i8.pos=189&";
$output .= "rs.i1.r.i9.pos=189&";

$output .= "rs.i0.r.i5.hold=false&";
$output .= "rs.i0.r.i6.hold=true&";
$output .= "rs.i0.r.i7.hold=true&";
$output .= "rs.i0.r.i8.hold=true&";
$output .= "rs.i0.r.i9.hold=true&";

$output .= "rs.i1.r.i5.hold=false&";
$output .= "rs.i1.r.i6.hold=true&";
$output .= "rs.i1.r.i7.hold=true&";
$output .= "rs.i1.r.i8.hold=true&";
$output .= "rs.i1.r.i9.hold=true&";
