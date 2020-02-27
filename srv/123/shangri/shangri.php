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
$answ = "";
$gameover = "true";
$wilds = '';
$table_locked = 0;
$buster10 = '';
$buster12 = '';

$wavecount = 1;

function creeper($prestackGroup, $symbols, $baseX, $baseY, $symb, $curGroup)
{
	if ($prestackGroup[$baseX][$baseY] == 'x') $prestackGroup[$baseX][$baseY] = $curGroup;
	else return $prestackGroup;
	if ($symbols[($baseX)][($baseY + 1)] == $symb and isset($symbols[($baseX)][($baseY + 1)]))
		$prestackGroup = creeper($prestackGroup, $symbols, $baseX, ($baseY + 1), $symb, $curGroup);
	if ($symbols[($baseX + 1)][($baseY)] == $symb and isset($symbols[($baseX + 1)][($baseY)]))
		$prestackGroup = creeper($prestackGroup, $symbols, ($baseX + 1), ($baseY), $symb, $curGroup);
	if ($symbols[($baseX)][($baseY - 1)] == $symb and isset($symbols[($baseX)][($baseY - 1)]))
		$prestackGroup = creeper($prestackGroup, $symbols, $baseX, ($baseY - 1), $symb, $curGroup);
	if ($symbols[($baseX - 1)][($baseY)] == $symb and isset($symbols[($baseX - 1)][($baseY)]))
		$prestackGroup = creeper($prestackGroup, $symbols, ($baseX - 1), ($baseY), $symb, $curGroup);
	return $prestackGroup;
}


////////////////////////////////////
//correct action check
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



if ($_GET['action'] == "initfreespin" and (!isset($fs_left) or isset($restoreAction))) {

	if (!isset($fs_left)) {
		$fs_left = $fs_initial;
	}

	if (isset($wildStcks))    $wilds = $wildStcks;

	$fs_played = $fs_initial - $fs_left;
	if (!isset($fs_totalwin))	$fs_totalwin = 0;

	$output .= "bet.betlevel=1&";
	$output .= "bet.betlines=0&";
	$output .= "bet.denomination=1&";
	$output .= "clientaction=initfreespin&";
	$output .= "current.rs.i0=freespin&";
	$output .= "freespins.betlevel=1&";
	$output .= "freespins.betlines=0&";
	$output .= "freespins.denomination=1.000&";
	$output .= "freespins.initial=" . $fs_initial . "&";
	$output .= "freespins.left=" . $fs_left . "&";
	$output .= "freespins.multiplier=1&";
	$output .= "freespins.retriggered=false&";
	$output .= "freespins.total=" . $fs_initial . "&";
	$output .= "freespins.totalwin.cents=0&";
	$output .= "freespins.totalwin.coins=0&";
	$output .= "freespins.wavecount=1&";
	$output .= "freespins.win.cents=0&";
	$output .= "freespins.win.coins=0&";
	$output .= "gamestate.current=freespin&";
	$output .= "gamestate.history=basic&";
	$output .= "gamestate.stack=basic%2Cfreespin&";
	$output .= "next.rs=freespin&";
	$output .= "nextaction=freespin&";
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
	$output .= "rs.i1.r.i0.pos=0&";
	$output .= "rs.i1.r.i0.syms=SYM12&";
	$output .= "rs.i1.r.i1.hold=false&";
	$output .= "rs.i1.r.i1.pos=12&";
	$output .= "rs.i1.r.i1.syms=SYM13&";
	$output .= "rs.i1.r.i10.hold=false&";
	$output .= "rs.i1.r.i10.pos=7&";
	$output .= "rs.i1.r.i10.syms=SYM12&";
	$output .= "rs.i1.r.i11.hold=false&";
	$output .= "rs.i1.r.i11.pos=2&";
	$output .= "rs.i1.r.i11.syms=SYM13&";
	$output .= "rs.i1.r.i12.hold=false&";
	$output .= "rs.i1.r.i12.pos=6&";
	$output .= "rs.i1.r.i12.syms=SYM13&";
	$output .= "rs.i1.r.i13.hold=false&";
	$output .= "rs.i1.r.i13.pos=1&";
	$output .= "rs.i1.r.i13.syms=SYM13&";
	$output .= "rs.i1.r.i14.hold=false&";
	$output .= "rs.i1.r.i14.pos=0&";
	$output .= "rs.i1.r.i14.syms=SYM12&";
	$output .= "rs.i1.r.i15.hold=false&";
	$output .= "rs.i1.r.i15.pos=4&";
	$output .= "rs.i1.r.i15.syms=SYM13&";
	$output .= "rs.i1.r.i16.hold=false&";
	$output .= "rs.i1.r.i16.pos=10&";
	$output .= "rs.i1.r.i16.syms=SYM13&";
	$output .= "rs.i1.r.i17.hold=false&";
	$output .= "rs.i1.r.i17.pos=6&";
	$output .= "rs.i1.r.i17.syms=SYM13&";
	$output .= "rs.i1.r.i18.hold=false&";
	$output .= "rs.i1.r.i18.pos=7&";
	$output .= "rs.i1.r.i18.syms=SYM12&";
	$output .= "rs.i1.r.i19.hold=false&";
	$output .= "rs.i1.r.i19.pos=9&";
	$output .= "rs.i1.r.i19.syms=SYM13&";
	$output .= "rs.i1.r.i2.hold=false&";
	$output .= "rs.i1.r.i2.pos=8&";
	$output .= "rs.i1.r.i2.syms=SYM13&";
	$output .= "rs.i1.r.i20.hold=false&";
	$output .= "rs.i1.r.i20.pos=6&";
	$output .= "rs.i1.r.i20.syms=SYM13&";
	$output .= "rs.i1.r.i21.hold=false&";
	$output .= "rs.i1.r.i21.pos=11&";
	$output .= "rs.i1.r.i21.syms=SYM13&";
	$output .= "rs.i1.r.i22.hold=false&";
	$output .= "rs.i1.r.i22.pos=8&";
	$output .= "rs.i1.r.i22.syms=SYM13&";
	$output .= "rs.i1.r.i23.hold=false&";
	$output .= "rs.i1.r.i23.pos=4&";
	$output .= "rs.i1.r.i23.syms=SYM13&";
	$output .= "rs.i1.r.i24.hold=false&";
	$output .= "rs.i1.r.i24.pos=4&";
	$output .= "rs.i1.r.i24.syms=SYM13&";
	$output .= "rs.i1.r.i25.hold=false&";
	$output .= "rs.i1.r.i25.pos=9&";
	$output .= "rs.i1.r.i25.syms=SYM13&";
	$output .= "rs.i1.r.i26.hold=false&";
	$output .= "rs.i1.r.i26.pos=1&";
	$output .= "rs.i1.r.i26.syms=SYM13&";
	$output .= "rs.i1.r.i27.hold=false&";
	$output .= "rs.i1.r.i27.pos=7&";
	$output .= "rs.i1.r.i27.syms=SYM12&";
	$output .= "rs.i1.r.i28.hold=false&";
	$output .= "rs.i1.r.i28.pos=1&";
	$output .= "rs.i1.r.i28.syms=SYM13&";
	$output .= "rs.i1.r.i29.hold=false&";
	$output .= "rs.i1.r.i29.pos=3&";
	$output .= "rs.i1.r.i29.syms=SYM13&";
	$output .= "rs.i1.r.i3.hold=false&";
	$output .= "rs.i1.r.i3.pos=0&";
	$output .= "rs.i1.r.i3.syms=SYM12&";
	$output .= "rs.i1.r.i4.hold=false&";
	$output .= "rs.i1.r.i4.pos=7&";
	$output .= "rs.i1.r.i4.syms=SYM12&";
	$output .= "rs.i1.r.i5.hold=false&";
	$output .= "rs.i1.r.i5.pos=8&";
	$output .= "rs.i1.r.i5.syms=SYM13&";
	$output .= "rs.i1.r.i6.hold=false&";
	$output .= "rs.i1.r.i6.pos=8&";
	$output .= "rs.i1.r.i6.syms=SYM13&";
	$output .= "rs.i1.r.i7.hold=false&";
	$output .= "rs.i1.r.i7.pos=4&";
	$output .= "rs.i1.r.i7.syms=SYM13&";
	$output .= "rs.i1.r.i8.hold=false&";
	$output .= "rs.i1.r.i8.pos=11&";
	$output .= "rs.i1.r.i8.syms=SYM13&";
	$output .= "rs.i1.r.i9.hold=false&";
	$output .= "rs.i1.r.i9.pos=3&";
	$output .= "rs.i1.r.i9.syms=SYM13&";
	$output .= "rs.i2.id=respin2&";
	$output .= "rs.i2.r.i0.hold=false&";
	$output .= "rs.i2.r.i0.pos=10&";
	$output .= "rs.i2.r.i0.syms=SYM13&";
	$output .= "rs.i2.r.i1.hold=false&";
	$output .= "rs.i2.r.i1.pos=3&";
	$output .= "rs.i2.r.i1.syms=SYM13&";
	$output .= "rs.i2.r.i10.hold=false&";
	$output .= "rs.i2.r.i10.pos=11&";
	$output .= "rs.i2.r.i10.syms=SYM13&";
	$output .= "rs.i2.r.i11.hold=false&";
	$output .= "rs.i2.r.i11.pos=6&";
	$output .= "rs.i2.r.i11.syms=SYM13&";
	$output .= "rs.i2.r.i12.hold=false&";
	$output .= "rs.i2.r.i12.pos=8&";
	$output .= "rs.i2.r.i12.syms=SYM13&";
	$output .= "rs.i2.r.i13.hold=false&";
	$output .= "rs.i2.r.i13.pos=4&";
	$output .= "rs.i2.r.i13.syms=SYM13&";
	$output .= "rs.i2.r.i14.hold=false&";
	$output .= "rs.i2.r.i14.pos=9&";
	$output .= "rs.i2.r.i14.syms=SYM13&";
	$output .= "rs.i2.r.i15.hold=false&";
	$output .= "rs.i2.r.i15.pos=7&";
	$output .= "rs.i2.r.i15.syms=SYM13&";
	$output .= "rs.i2.r.i16.hold=false&";
	$output .= "rs.i2.r.i16.pos=11&";
	$output .= "rs.i2.r.i16.syms=SYM13&";
	$output .= "rs.i2.r.i17.hold=false&";
	$output .= "rs.i2.r.i17.pos=3&";
	$output .= "rs.i2.r.i17.syms=SYM13&";
	$output .= "rs.i2.r.i18.hold=false&";
	$output .= "rs.i2.r.i18.pos=9&";
	$output .= "rs.i2.r.i18.syms=SYM13&";
	$output .= "rs.i2.r.i19.hold=false&";
	$output .= "rs.i2.r.i19.pos=10&";
	$output .= "rs.i2.r.i19.syms=SYM13&";
	$output .= "rs.i2.r.i2.hold=false&";
	$output .= "rs.i2.r.i2.pos=11&";
	$output .= "rs.i2.r.i2.syms=SYM13&";
	$output .= "rs.i2.r.i20.hold=false&";
	$output .= "rs.i2.r.i20.pos=3&";
	$output .= "rs.i2.r.i20.syms=SYM13&";
	$output .= "rs.i2.r.i21.hold=false&";
	$output .= "rs.i2.r.i21.pos=4&";
	$output .= "rs.i2.r.i21.syms=SYM13&";
	$output .= "rs.i2.r.i22.hold=false&";
	$output .= "rs.i2.r.i22.pos=7&";
	$output .= "rs.i2.r.i22.syms=SYM13&";
	$output .= "rs.i2.r.i23.hold=false&";
	$output .= "rs.i2.r.i23.pos=0&";
	$output .= "rs.i2.r.i23.syms=SYM12&";
	$output .= "rs.i2.r.i24.hold=false&";
	$output .= "rs.i2.r.i24.pos=9&";
	$output .= "rs.i2.r.i24.syms=SYM13&";
	$output .= "rs.i2.r.i25.hold=false&";
	$output .= "rs.i2.r.i25.pos=6&";
	$output .= "rs.i2.r.i25.syms=SYM13&";
	$output .= "rs.i2.r.i26.hold=false&";
	$output .= "rs.i2.r.i26.pos=6&";
	$output .= "rs.i2.r.i26.syms=SYM13&";
	$output .= "rs.i2.r.i27.hold=false&";
	$output .= "rs.i2.r.i27.pos=6&";
	$output .= "rs.i2.r.i27.syms=SYM13&";
	$output .= "rs.i2.r.i28.hold=false&";
	$output .= "rs.i2.r.i28.pos=6&";
	$output .= "rs.i2.r.i28.syms=SYM13&";
	$output .= "rs.i2.r.i29.hold=false&";
	$output .= "rs.i2.r.i29.pos=10&";
	$output .= "rs.i2.r.i29.syms=SYM13&";
	$output .= "rs.i2.r.i3.hold=false&";
	$output .= "rs.i2.r.i3.pos=8&";
	$output .= "rs.i2.r.i3.syms=SYM13&";
	$output .= "rs.i2.r.i4.hold=false&";
	$output .= "rs.i2.r.i4.pos=8&";
	$output .= "rs.i2.r.i4.syms=SYM13&";
	$output .= "rs.i2.r.i5.hold=false&";
	$output .= "rs.i2.r.i5.pos=2&";
	$output .= "rs.i2.r.i5.syms=SYM13&";
	$output .= "rs.i2.r.i6.hold=false&";
	$output .= "rs.i2.r.i6.pos=8&";
	$output .= "rs.i2.r.i6.syms=SYM13&";
	$output .= "rs.i2.r.i7.hold=false&";
	$output .= "rs.i2.r.i7.pos=8&";
	$output .= "rs.i2.r.i7.syms=SYM13&";
	$output .= "rs.i2.r.i8.hold=false&";
	$output .= "rs.i2.r.i8.pos=10&";
	$output .= "rs.i2.r.i8.syms=SYM13&";
	$output .= "rs.i2.r.i9.hold=false&";
	$output .= "rs.i2.r.i9.pos=11&";
	$output .= "rs.i2.r.i9.syms=SYM13&";
	$output .= "rs.i3.id=respin3&";
	$output .= "rs.i3.r.i0.hold=false&";
	$output .= "rs.i3.r.i0.pos=0&";
	$output .= "rs.i3.r.i0.syms=SYM12&";
	$output .= "rs.i3.r.i1.hold=false&";
	$output .= "rs.i3.r.i1.pos=12&";
	$output .= "rs.i3.r.i1.syms=SYM13&";
	$output .= "rs.i3.r.i10.hold=false&";
	$output .= "rs.i3.r.i10.pos=0&";
	$output .= "rs.i3.r.i10.syms=SYM12&";
	$output .= "rs.i3.r.i11.hold=false&";
	$output .= "rs.i3.r.i11.pos=17&";
	$output .= "rs.i3.r.i11.syms=SYM13&";
	$output .= "rs.i3.r.i12.hold=false&";
	$output .= "rs.i3.r.i12.pos=1&";
	$output .= "rs.i3.r.i12.syms=SYM13&";
	$output .= "rs.i3.r.i13.hold=false&";
	$output .= "rs.i3.r.i13.pos=7&";
	$output .= "rs.i3.r.i13.syms=SYM13&";
	$output .= "rs.i3.r.i14.hold=false&";
	$output .= "rs.i3.r.i14.pos=14&";
	$output .= "rs.i3.r.i14.syms=SYM13&";
	$output .= "rs.i3.r.i15.hold=false&";
	$output .= "rs.i3.r.i15.pos=7&";
	$output .= "rs.i3.r.i15.syms=SYM13&";
	$output .= "rs.i3.r.i16.hold=false&";
	$output .= "rs.i3.r.i16.pos=8&";
	$output .= "rs.i3.r.i16.syms=SYM13&";
	$output .= "rs.i3.r.i17.hold=false&";
	$output .= "rs.i3.r.i17.pos=15&";
	$output .= "rs.i3.r.i17.syms=SYM13&";
	$output .= "rs.i3.r.i18.hold=false&";
	$output .= "rs.i3.r.i18.pos=6&";
	$output .= "rs.i3.r.i18.syms=SYM13&";
	$output .= "rs.i3.r.i19.hold=false&";
	$output .= "rs.i3.r.i19.pos=8&";
	$output .= "rs.i3.r.i19.syms=SYM13&";
	$output .= "rs.i3.r.i2.hold=false&";
	$output .= "rs.i3.r.i2.pos=17&";
	$output .= "rs.i3.r.i2.syms=SYM13&";
	$output .= "rs.i3.r.i20.hold=false&";
	$output .= "rs.i3.r.i20.pos=17&";
	$output .= "rs.i3.r.i20.syms=SYM13&";
	$output .= "rs.i3.r.i21.hold=false&";
	$output .= "rs.i3.r.i21.pos=2&";
	$output .= "rs.i3.r.i21.syms=SYM13&";
	$output .= "rs.i3.r.i22.hold=false&";
	$output .= "rs.i3.r.i22.pos=12&";
	$output .= "rs.i3.r.i22.syms=SYM13&";
	$output .= "rs.i3.r.i23.hold=false&";
	$output .= "rs.i3.r.i23.pos=17&";
	$output .= "rs.i3.r.i23.syms=SYM13&";
	$output .= "rs.i3.r.i24.hold=false&";
	$output .= "rs.i3.r.i24.pos=7&";
	$output .= "rs.i3.r.i24.syms=SYM13&";
	$output .= "rs.i3.r.i25.hold=false&";
	$output .= "rs.i3.r.i25.pos=6&";
	$output .= "rs.i3.r.i25.syms=SYM13&";
	$output .= "rs.i3.r.i26.hold=false&";
	$output .= "rs.i3.r.i26.pos=17&";
	$output .= "rs.i3.r.i26.syms=SYM13&";
	$output .= "rs.i3.r.i27.hold=false&";
	$output .= "rs.i3.r.i27.pos=13&";
	$output .= "rs.i3.r.i27.syms=SYM13&";
	$output .= "rs.i3.r.i28.hold=false&";
	$output .= "rs.i3.r.i28.pos=1&";
	$output .= "rs.i3.r.i28.syms=SYM13&";
	$output .= "rs.i3.r.i29.hold=false&";
	$output .= "rs.i3.r.i29.pos=3&";
	$output .= "rs.i3.r.i29.syms=SYM13&";
	$output .= "rs.i3.r.i3.hold=false&";
	$output .= "rs.i3.r.i3.pos=7&";
	$output .= "rs.i3.r.i3.syms=SYM13&";
	$output .= "rs.i3.r.i4.hold=false&";
	$output .= "rs.i3.r.i4.pos=16&";
	$output .= "rs.i3.r.i4.syms=SYM13&";
	$output .= "rs.i3.r.i5.hold=false&";
	$output .= "rs.i3.r.i5.pos=5&";
	$output .= "rs.i3.r.i5.syms=SYM13&";
	$output .= "rs.i3.r.i6.hold=false&";
	$output .= "rs.i3.r.i6.pos=13&";
	$output .= "rs.i3.r.i6.syms=SYM13&";
	$output .= "rs.i3.r.i7.hold=false&";
	$output .= "rs.i3.r.i7.pos=7&";
	$output .= "rs.i3.r.i7.syms=SYM13&";
	$output .= "rs.i3.r.i8.hold=false&";
	$output .= "rs.i3.r.i8.pos=16&";
	$output .= "rs.i3.r.i8.syms=SYM13&";
	$output .= "rs.i3.r.i9.hold=false&";
	$output .= "rs.i3.r.i9.pos=13&";
	$output .= "rs.i3.r.i9.syms=SYM13&";
	$output .= "rs.i4.id=respin4&";
	$output .= "rs.i4.r.i0.hold=false&";
	$output .= "rs.i4.r.i0.pos=2&";
	$output .= "rs.i4.r.i0.syms=SYM13&";
	$output .= "rs.i4.r.i1.hold=false&";
	$output .= "rs.i4.r.i1.pos=18&";
	$output .= "rs.i4.r.i1.syms=SYM13&";
	$output .= "rs.i4.r.i10.hold=false&";
	$output .= "rs.i4.r.i10.pos=8&";
	$output .= "rs.i4.r.i10.syms=SYM13&";
	$output .= "rs.i4.r.i11.hold=false&";
	$output .= "rs.i4.r.i11.pos=20&";
	$output .= "rs.i4.r.i11.syms=SYM13&";
	$output .= "rs.i4.r.i12.hold=false&";
	$output .= "rs.i4.r.i12.pos=20&";
	$output .= "rs.i4.r.i12.syms=SYM13&";
	$output .= "rs.i4.r.i13.hold=false&";
	$output .= "rs.i4.r.i13.pos=1&";
	$output .= "rs.i4.r.i13.syms=SYM13&";
	$output .= "rs.i4.r.i14.hold=false&";
	$output .= "rs.i4.r.i14.pos=4&";
	$output .= "rs.i4.r.i14.syms=SYM13&";
	$output .= "rs.i4.r.i15.hold=false&";
	$output .= "rs.i4.r.i15.pos=17&";
	$output .= "rs.i4.r.i15.syms=SYM13&";
	$output .= "rs.i4.r.i16.hold=false&";
	$output .= "rs.i4.r.i16.pos=1&";
	$output .= "rs.i4.r.i16.syms=SYM13&";
	$output .= "rs.i4.r.i17.hold=false&";
	$output .= "rs.i4.r.i17.pos=1&";
	$output .= "rs.i4.r.i17.syms=SYM13&";
	$output .= "rs.i4.r.i18.hold=false&";
	$output .= "rs.i4.r.i18.pos=5&";
	$output .= "rs.i4.r.i18.syms=SYM13&";
	$output .= "rs.i4.r.i19.hold=false&";
	$output .= "rs.i4.r.i19.pos=5&";
	$output .= "rs.i4.r.i19.syms=SYM13&";
	$output .= "rs.i4.r.i2.hold=false&";
	$output .= "rs.i4.r.i2.pos=10&";
	$output .= "rs.i4.r.i2.syms=SYM13&";
	$output .= "rs.i4.r.i20.hold=false&";
	$output .= "rs.i4.r.i20.pos=18&";
	$output .= "rs.i4.r.i20.syms=SYM13&";
	$output .= "rs.i4.r.i21.hold=false&";
	$output .= "rs.i4.r.i21.pos=10&";
	$output .= "rs.i4.r.i21.syms=SYM13&";
	$output .= "rs.i4.r.i22.hold=false&";
	$output .= "rs.i4.r.i22.pos=5&";
	$output .= "rs.i4.r.i22.syms=SYM13&";
	$output .= "rs.i4.r.i23.hold=false&";
	$output .= "rs.i4.r.i23.pos=10&";
	$output .= "rs.i4.r.i23.syms=SYM13&";
	$output .= "rs.i4.r.i24.hold=false&";
	$output .= "rs.i4.r.i24.pos=14&";
	$output .= "rs.i4.r.i24.syms=SYM13&";
	$output .= "rs.i4.r.i25.hold=false&";
	$output .= "rs.i4.r.i25.pos=1&";
	$output .= "rs.i4.r.i25.syms=SYM13&";
	$output .= "rs.i4.r.i26.hold=false&";
	$output .= "rs.i4.r.i26.pos=5&";
	$output .= "rs.i4.r.i26.syms=SYM13&";
	$output .= "rs.i4.r.i27.hold=false&";
	$output .= "rs.i4.r.i27.pos=11&";
	$output .= "rs.i4.r.i27.syms=SYM13&";
	$output .= "rs.i4.r.i28.hold=false&";
	$output .= "rs.i4.r.i28.pos=8&";
	$output .= "rs.i4.r.i28.syms=SYM13&";
	$output .= "rs.i4.r.i29.hold=false&";
	$output .= "rs.i4.r.i29.pos=20&";
	$output .= "rs.i4.r.i29.syms=SYM13&";
	$output .= "rs.i4.r.i3.hold=false&";
	$output .= "rs.i4.r.i3.pos=12&";
	$output .= "rs.i4.r.i3.syms=SYM13&";
	$output .= "rs.i4.r.i4.hold=false&";
	$output .= "rs.i4.r.i4.pos=20&";
	$output .= "rs.i4.r.i4.syms=SYM13&";
	$output .= "rs.i4.r.i5.hold=false&";
	$output .= "rs.i4.r.i5.pos=16&";
	$output .= "rs.i4.r.i5.syms=SYM13&";
	$output .= "rs.i4.r.i6.hold=false&";
	$output .= "rs.i4.r.i6.pos=19&";
	$output .= "rs.i4.r.i6.syms=SYM13&";
	$output .= "rs.i4.r.i7.hold=false&";
	$output .= "rs.i4.r.i7.pos=5&";
	$output .= "rs.i4.r.i7.syms=SYM13&";
	$output .= "rs.i4.r.i8.hold=false&";
	$output .= "rs.i4.r.i8.pos=7&";
	$output .= "rs.i4.r.i8.syms=SYM13&";
	$output .= "rs.i4.r.i9.hold=false&";
	$output .= "rs.i4.r.i9.pos=12&";
	$output .= "rs.i4.r.i9.syms=SYM13&";
	$output .= "rs.i5.id=basic&";
	$output .= "rs.i5.nearwin=2%2C3%2C4%2C5&";
	$output .= "rs.i5.nearwinextra.freespin=2%2C3%2C4%2C5&";
	$output .= "rs.i5.r.i0.attention.i0=4&";
	$output .= "rs.i5.r.i0.hold=false&";
	$output .= "rs.i5.r.i0.pos=442&";
	$output .= "rs.i5.r.i0.syms=SYM5%2CSYM7%2CSYM7%2CSYM7%2CSYM0&";
	$output .= "rs.i5.r.i1.attention.i0=1&";
	$output .= "rs.i5.r.i1.attention.i1=2&";
	$output .= "rs.i5.r.i1.hold=false&";
	$output .= "rs.i5.r.i1.pos=185&";
	$output .= "rs.i5.r.i1.syms=SYM3%2CSYM0%2CSYM0%2CSYM7%2CSYM7&";
	$output .= "rs.i5.r.i2.attention.i0=1&";
	$output .= "rs.i5.r.i2.attention.i1=2&";
	$output .= "rs.i5.r.i2.hold=false&";
	$output .= "rs.i5.r.i2.pos=516&";
	$output .= "rs.i5.r.i2.syms=SYM8%2CSYM0%2CSYM0%2CSYM5%2CSYM5&";
	$output .= "rs.i5.r.i3.hold=false&";
	$output .= "rs.i5.r.i3.pos=534&";
	$output .= "rs.i5.r.i3.syms=SYM3%2CSYM3%2CSYM7%2CSYM7%2CSYM7&";
	$output .= "rs.i5.r.i4.hold=false&";
	$output .= "rs.i5.r.i4.pos=361&";
	$output .= "rs.i5.r.i4.syms=SYM9%2CSYM9%2CSYM9%2CSYM9%2CSYM6&";
	$output .= "rs.i5.r.i5.hold=false&";
	$output .= "rs.i5.r.i5.pos=519&";
	$output .= "rs.i5.r.i5.syms=SYM4%2CSYM4%2CSYM9%2CSYM9%2CSYM9&";


	$lastAction = "startfreespin";
	$botAction = "freespin";

	$output .= $lastRsDB;
	$lastRs = $lastRsDB;

	$table_locked = 1;
	$gameover = "false";
}


if ($_GET['action'] == "spin" or $_GET['action'] == "respin" or $_GET['action'] == "freespin") {

	$lastAction = "spin";
	$clientAction = $lastAction;
	$rs_Id = "basic";
	$reelset = "basic";
	$s_s_symbol = 3;

	if ($lastActionDB == "freespin" and $_GET['action'] == "freespin") $lastAction = "freespin";
	if ($lastActionDB == "startfreespin" and $_GET['action'] == "freespin") $lastAction = "freespin";

	if ($lastActionDB == "respin" and $_GET['action'] == "respin") $lastAction = "respin";

	if ($lastActionDB == "paytable" and isset($restoreAction)) ////????
	{
		if ($restoreAction == 'respin') {
			$lastAction = "respin";
			$wildsDB = $wildStcks;
		}
	}

	//echo $lastAction." = LA<br>";

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

	$randomSubsRate = $reel[6][0];
	$respinRate = $reel[6][1];

	for ($i = 0; $i < 6; $i++) {
		$length = (count($reel[$i]) - 1);
		$pos = round(rand(0, $length));


		if ($_GET['action'] != 'freespin') {
			/*
if($i==0)$pos=446;
if($i==1)$pos=210;
if($i==2)$pos=361;
if($i==3)$pos=329;
//if($i==3)$pos=333;
if($i==4)$pos=319;
if($i==5)$pos=442;
*/
		}
		/*
if($_GET['action']=='respin')
{
if($i==0)$pos=215;
if($i==1)$pos=496;
if($i==2)$pos=399;
if($i==3)$pos=526;
if($i==4)$pos=538;
if($i==5)$pos=294;
}
*/

		if ($_GET['action'] == 'freespin') {
			/*
if($i==0)$pos=548;
if($i==1)$pos=141;
if($i==2)$pos=447;
if($i==3)$pos=359;
if($i==4)$pos=129;
if($i==5)$pos=356;
*/
		}


		//echo "if($"."i==".$i.")$"."pos=$pos;<br>";


		$symbols[$i][0] = $reel[$i][$pos];

		if ($pos == $length) {
			$symbols[$i][1] = $reel[$i][0];
			$symbols[$i][2] = $reel[$i][1];
			$symbols[$i][3] = $reel[$i][2];
			$symbols[$i][4] = $reel[$i][3];
			$symbols[$i][5] = $reel[$i][4];
		} elseif ($pos == ($length - 1)) {
			$symbols[$i][1] = $reel[$i][$length];
			$symbols[$i][2] = $reel[$i][0];
			$symbols[$i][3] = $reel[$i][1];
			$symbols[$i][4] = $reel[$i][2];
			$symbols[$i][5] = $reel[$i][3];
		} elseif ($pos == ($length - 2)) {
			$symbols[$i][1] = $reel[$i][$length - 1];
			$symbols[$i][2] = $reel[$i][$length];
			$symbols[$i][3] = $reel[$i][0];
			$symbols[$i][4] = $reel[$i][1];
			$symbols[$i][5] = $reel[$i][2];
		} elseif ($pos == ($length - 3)) {
			$symbols[$i][1] = $reel[$i][$length - 2];
			$symbols[$i][2] = $reel[$i][$length - 1];
			$symbols[$i][3] = $reel[$i][$length];
			$symbols[$i][4] = $reel[$i][0];
			$symbols[$i][5] = $reel[$i][1];
		} elseif ($pos == ($length - 4)) {
			$symbols[$i][1] = $reel[$i][$length - 3];
			$symbols[$i][2] = $reel[$i][$length - 2];
			$symbols[$i][3] = $reel[$i][$length - 1];
			$symbols[$i][4] = $reel[$i][$length];
			$symbols[$i][5] = $reel[$i][0];
		} else {
			$symbols[$i][1] = $reel[$i][$pos + 1];
			$symbols[$i][2] = $reel[$i][$pos + 2];
			$symbols[$i][3] = $reel[$i][$pos + 3];
			$symbols[$i][4] = $reel[$i][$pos + 4];
			$symbols[$i][5] = $reel[$i][$pos + 5];
		}

		$output1 .= "rs.i0.r.i" . $i . ".pos=" . ($pos) . "&";
		$reel_Pos[$i] = $pos;
	}
	include('./integr/busters.php');
	$output .= $output1;

	$orig_symbols = $symbols;

	$oldRls = explode(',', $wildsDB);
	foreach ($oldRls as $oldRlNum => $oldRl) {
		if ($oldRl != '') {
			$oldSyms = explode(':', $oldRl);
			//	    if($lastAction=='freespin' or $lastAction=='respin')$symbols[$oldSyms[0]][$oldSyms[1]]=$respinSym;
			$oldSymbols[$oldSyms[0]][$oldSyms[1]] = $respinSym;
			$respinSymCount++;
		}
	}
	/*
$symbols[0][0]=4;$symbols[1][0]=5;$symbols[2][0]=4;$symbols[3][0]=8;$symbols[4][0]=8;$symbols[5][0]=4;
$symbols[0][1]=4;$symbols[1][1]=4;$symbols[2][1]=4;$symbols[3][1]=8;$symbols[4][1]=4;$symbols[5][1]=4;
$symbols[0][2]=5;$symbols[1][2]=4;$symbols[2][2]=4;$symbols[3][2]=6;$symbols[4][2]=4;$symbols[5][2]=4;
$symbols[0][3]=5;$symbols[1][3]=4;$symbols[2][3]=4;$symbols[3][3]=7;$symbols[4][3]=4;$symbols[5][3]=4;
$symbols[0][4]=4;$symbols[1][4]=4;$symbols[2][4]=4;$symbols[3][4]=7;$symbols[4][4]=4;$symbols[5][4]=4;
*/
	/*
$symbols[0][0]=7;$symbols[1][0]=5;$symbols[2][0]=7;$symbols[3][0]=8;$symbols[4][0]=8;$symbols[5][0]=7;
$symbols[0][1]=7;$symbols[1][1]=7;$symbols[2][1]=7;$symbols[3][1]=8;$symbols[4][1]=7;$symbols[5][1]=7;
$symbols[0][2]=5;$symbols[1][2]=7;$symbols[2][2]=7;$symbols[3][2]=6;$symbols[4][2]=7;$symbols[5][2]=7;
$symbols[0][3]=5;$symbols[1][3]=7;$symbols[2][3]=7;$symbols[3][3]=4;$symbols[4][3]=7;$symbols[5][3]=7;
$symbols[0][4]=7;$symbols[1][4]=7;$symbols[2][4]=7;$symbols[3][4]=4;$symbols[4][4]=7;$symbols[5][4]=7;
*

/*
$symbols[0][0]=9;$symbols[1][0]=9;$symbols[2][0]=7;$symbols[3][0]=4;$symbols[4][0]=3;$symbols[5][0]=0;
$symbols[0][1]=5;$symbols[1][1]=6;$symbols[2][1]=7;$symbols[3][1]=4;$symbols[4][1]=3;$symbols[5][1]=0;
$symbols[0][2]=5;$symbols[1][2]=6;$symbols[2][2]=8;$symbols[3][2]=4;$symbols[4][2]=5;$symbols[5][2]=5;
$symbols[0][3]=5;$symbols[1][3]=6;$symbols[2][3]=8;$symbols[3][3]=3;$symbols[4][3]=5;$symbols[5][3]=5;
$symbols[0][4]=5;$symbols[1][4]=6;$symbols[2][4]=8;$symbols[3][4]=3;$symbols[4][4]=5;$symbols[5][4]=5;
*/

	$bonusSymbCount = 0;
	$nearWinReel = 0;
	$nudgeReel = '-1';
	$substSymbCount = 0;

	foreach ($symbols as $tReel => $t) {
		foreach ($t as $tRow => $e) {
			if ($tRow < 5) {
				if ($symbols[$tReel][$tRow] == 0) {
					//		    $bonusSymbCount++;
					$bonusReels[$tReel] = 1;

					//		    echo "reel $tReel $tRow <br>";

					if (!isset($fs_wsStr[$tReel]))
						$fs_wsStr[$tReel] = $tReel . "," . $tRow;

					if ($lastAction == 'respin') $symbols[$tReel][$tRow] = $respinSym;
				}
				if ($symbols[$tReel][$tRow] == 11) {
					$substSymbCount++;

					//		    if($lastAction=='respin')$symbols[$tReel][$tRow]=round(rand(6,9));
				}
			}
		}

		if ($bonusReels[$tReel] != 1 and $nudgeReel == '-1') {
			for ($k = 1; $k <= 5; $k++) {
				if (isset($reel[$tReel][($reel_Pos[$tReel] + 5 + $k)]) and $reel[$tReel][($reel_Pos[$tReel] + 5 + $k)] == 0) {
					$bonusReels[$tReel] = 1;
					$nudgeReel = $tReel;
					$nudgeOffset = "-" . $k;
				}
			}
			//		echo "nudge = $nudgeReel : $nudgeOffset, reelpos ".$reel_Pos[$tReel]." = ".$reel[$tReel][($reel_Pos[$tReel]+6)]."<br>";
		}
	}

	if (!isset($fs_initial)) {
		//    echo "FSREE:<br>";
		foreach ($bonusReels as $e => $v) {
			$fs_initial += 1;
			$bonusSymbCount++;
			// echo "FS from reels $e";
		}
		$fs_initial += 2;
		//	echo " almong $fs_initial <br>";
	}



	/////////////////////////////////////////////add S_S in FS

	if ($lastAction == 'freespin') {
		if ($respinSymCount < 3) $k = 5;
		else $k = 3;
		if ($respinSymCount == 0) $k = 4;
		$stepNum = 0;
		do {
			$setX = round(rand(0, 5));
			$setY = round(rand(0, 4));
			$i1 = 0;
			for ($i = 0; $i < 6; $i++) for ($j = 0; $j < 5; $j++) if ($add_symbols[$i][$j] == 11)  $i1++;

			if ($symbols[$setX][$setY] != 11) {
				$add_symbols[$setX][$setY] = 11;
				//echo "add 11 to $setX $setY step $stepNum addcount=".$i1." cond  $k<br>";
			}
			$stepNum++;
			/*
$syms_after="<br>ITER $stepNum<br>";
for($j=0;$j<5;$j++)
 {
for($i=0;$i<6;$i++)
    {
$syms_after.="[".$add_symbols[$i][$j]."]\t\t\t\t";
    }
$syms_after.="<br>";
 }
echo $syms_after;
echo "<br>";
*/
		} while ($i1 < $k or $stepNum > 30);
		$respinSymCount += $i1;
		$substSymbCount += $i1;
		$symbolsOverlayed = $symbols;
	}
	///////////////////////////////////////

	/*
$syms_after="<br>symsORIG<br>";
for($j=0;$j<5;$j++)
 {
for($i=0;$i<6;$i++)
    {
$syms_after.="[".$symbols[$i][$j]."]\t\t\t\t";
    }
$syms_after.="<br>";
 }
echo $syms_after;
echo "<br>";
*/

	/*
unset($add_symbols);
$add_symbols[1][0]=11;
$add_symbols[4][0]=11;
$add_symbols[2][2]=11;
$add_symbols[0][4]=11;
$add_symbols[3][4]=11;

add 11 to 3 4 step 0 addcount=0 cond 4
add 11 to 4 1 step 1 addcount=1 cond 4
add 11 to 1 1 step 2 addcount=2 cond 4
add 11 to 1 0 step 3 addcount=3 cond 4
add 11 to 5 1 step 4 addcount=4 cond 4
*/

	if ($fs_initial > 4 and $lastAction != 'freespin' and $lastAction != 'respin') {
		$lastAction = "initfreespin";
	}

	if ($lastAction != "startfreespin" and $lastAction != "bonusgame" and $lastAction != "coins")
		include($gamePath . 'lines.php');
	else $symb_combs .= " fake spin;";

	/*
$syms_after="<br>s s symsORIG<br>";
for($j=0;$j<5;$j++)
 {
for($i=0;$i<6;$i++)
    {
$syms_after.="[".$s_s_symbols[$i][$j]."]\t\t\t\t";
    }
$syms_after.="<br>";
 }
echo $syms_after;
echo "<br>";
*/

	$stackExit = 0;
	$stepNum = 0;
	$feature_triggered = "false";
	if ($lastAction != 'freespin') $feature_positions = "";

	$k = 0;
	for ($i = 0; $i < 4; $i++)
		for ($j = 0; $j < 3; $j++) {
			$posibilites[$i][$j] = $k;
			$k++;
		}
	shuffle($posibilites);

	////////////////////////////////////
	do {
		if (!isset($randomSubSym) and $lastAction != "pre_s_s" and $lastAction != "respin" and $lastAction != "lastrespin") $stackExit = -1;
		elseif ($sameClusters != -1) { {
				//    echo "LAIN $lastAction<br>";
				//    echo "RSN $e1 => $v1 <br>";
				if ($lastAction == "pre_r_s") {
					$total_winCents = 0;
					$total_win = 0;
					unset($win);
					unset($winGroup);
					unset($winGr);
					unset($groups);
					unset($symbolsOverallCount);
					unset($symbols_count);
					unset($prestackGroup);
					unset($prestackSyms);
					unset($linewin);
					unset($randomSub);
					unset($randomSubSym);
					unset($add_symbols);

					for ($i = 0; $i < 4; $i++)
						for ($j = 0; $j < 3; $j++)
							if ($posibilites[$i][$j] == $stepNum) {
								$setX = $i + 1;
								$setY = $j + 1;
							}
					//    echo "ok ($setX $setY) => $e1;<br>";
					$add_symbols[$setX][$setY] = $e1;
					include($gamePath . 'lines.php');
					$stepNum++;
				} elseif ($lastAction == "pre_s_s") {
					//	echo "win = ".$total_win." for sym".($s_s_symbol-1)."<br>";

					$total_winCents = 0;
					$total_win = 0;
					unset($win);
					unset($winGroup);
					unset($winGr);
					unset($groups);
					unset($symbolsOverallCount);
					unset($symbols_count);
					unset($prestackGroup);
					unset($prestackSyms);
					unset($linewin);
					unset($randomSub);
					unset($randomSubSym);
					unset($add_symbols);
					$feature_positions = '';
					unset($symbOverlays);

					$symbols = $s_s_symbols;
					for ($i = 0; $i < 6; $i++)
						for ($j = 0; $j < 5; $j++) {
							if ($symbols[$i][$j] == 11) {
								$add_symbols[$i][$j] = $s_s_symbol;
								//		echo "add ($i $j) => $s_s_symbol;<br>";
							}
						}
					include($gamePath . 'lines.php');

					if ($total_win > 0) {
						$s_s_total_wins[$s_s_symbol] = $total_win;
						$s_s_feature_pos[$s_s_symbol] = $feature_positions;
						$s_s_wins[$s_s_symbol] = $win;
						$s_s_symbolOverlays[$s_s_symbol] = $symbOverlays;
						$s_s_winGr[$s_s_symbol] = $winGr[$s_s_symbol];
					}
					$s_s_symbol++;

					if ($s_s_symbol > 9) {
						//     $s_s_winGr[11]=1;
						//echo "<br><br>////////////////////////<br><br>";
						$grVal = '';
						foreach ($s_s_winGr as $e => $v) {
							//	echo "XYZ".$v."ZYX<br>";
							$grVal .= $v;
						}
						//	echo "GGGG".$grVal."XXXX<br>";
						if ($grVal != '') {
							if (isset($s_s_total_wins)) {
								$total_win = 0;
								$total_winCents = 0;
								unset($symbOverlays);
								foreach ($s_s_wins as $e => $v) {
									foreach ($s_s_winGr[$e] as $e1 => $v1) {
										$anim_num = 0;
										foreach ($winBlocks as $e2 => $v2)
											if ($v1 == $v2) $anim_num++;
										if ($anim_num == 0) $winBlocks[] = $v1;
									}
								}
								//			foreach($winBlocks as $e =>$v)	    echo "blocks $e $v <br>";
								foreach ($s_s_total_wins as $e => $v) {
									$anim_num = 0;
									foreach ($winBlocks as $blockIndex => $block)
										foreach ($s_s_winGr[$e] as $e1 => $v1) {
											foreach ($s_s_winGr as $eT => $vT) {
												foreach ($s_s_winGr[$eT] as $eT1 => $vT1) {
													if ($block == $v1) {
														if (!isset($wBlocks[$blockIndex])) {
															$wBlocks[$blockIndex] = $s_s_wins[$e][$e1];
															for ($i = 0; $i < 6; $i++)
																for ($j = 0; $j < 5; $j++)
																	if ($block[$i][$j] == 11) $equalOverlay[$i][$j] = $e;
														} elseif (explode("_", $wBlocks[$blockIndex])[0] < explode("_", $s_s_wins[$e][$e1])[0]) {
															$wBlocks[$blockIndex] = $s_s_wins[$e][$e1];
															//				echo 'ok';
															for ($i = 0; $i < 6; $i++)
																for ($j = 0; $j < 5; $j++)
																	if ($block[$i][$j] == 11) $equalOverlay[$i][$j] = $e;
														}
													}
												}
											}
										}
									//echo "<br><br>////////////////////////<br><br>";
								}
								do {
									$j1 = count($winBlocks);
									foreach ($winBlocks as $blockIndex => $block) {
										$deleteWin = '-1';
										$anim_num = $blockIndex + 1;
										for ($i1 = $anim_num; $i1 < $j1; $i1++) {
											$compare = -1;
											//		echo "compare $blockIndex and ".$i1."<br>";
											if ($block != $winBlocks[$i1]) {
												for ($i = 0; $i < 6; $i++)
													for ($j = 0; $j < 5; $j++)
														if ($block[$i][$j] == 11 and $winBlocks[$i1][$i][$j] == 11)
															$compare = 1;
												//			$b="<br>1<br>";	$b2="<br>2<br>";
												/*				    for($j=0;$j<5;$j++)
				    {
					for($i=0;$i<6;$i++)
					{
					    $b.="[".$block[$i][$j]."]\t\t\t\t";					$b2.="[".$winBlocks[$i1][$i][$j]."]\t\t\t\t";
					}
				    $b.="<br>";$b2.="<br>";
				    }*/
												//			echo $b;			echo $b2;
												if ($compare != -1) {
													//			    echo "result: yes<br>";
													//			    echo "wbl: #$blockIndex# ".$wBlocks[$blockIndex]." #$i1# ".$wBlocks[$i1]." ";
													if (explode("_", $wBlocks[$blockIndex])[0] > explode("_", $wBlocks[$i1])[0]) {
														$deleteWin = $i1;
														$newSym = explode("_", $wBlocks[$blockIndex])[2];
													} else {
														$deleteWin = $blockIndex;
														$newSym = explode("_", $wBlocks[$i1])[2];
													}
													//			    echo " index $deleteWin , symbol $newSym<br>";
													for ($j = 0; $j < 5; $j++) {
														for ($i = 0; $i < 6; $i++) {
															if ($winBlocks[$deleteWin][$i][$j] == 11) $equalOverlay[$i][$j] = $newSym;
														}
													}
												}
												//			else echo "result: no<br>";
											}
											if ($deleteWin != '-1') break 2;
										}
									}
									if ($deleteWin != '-1') {
										unset($wBlocks[$deleteWin]);
										sort($wBlocks);
										unset($winBlocks[$deleteWin]);
										sort($winBlocks);
									}
									//			  foreach($winBlocks as $blockIndex=>$block)	    echo "new $blockIndex ".$wBlocks[$blockIndex]."<br>";
								} while ($deleteWin != '-1');

								$win = $wBlocks;
							}
						} else {
							$total_winCents = 0;
							$total_win = 0;
							unset($win);
							unset($winGroup);
							unset($winGr);
							unset($groups);
							unset($symbolsOverallCount);
							unset($symbols_count);
							unset($prestackGroup);
							unset($prestackSyms);
							unset($linewin);
							unset($randomSub);
							unset($randomSubSym);
							unset($add_symbols);
							$feature_positions = '';
							unset($symbOverlays);
							if (!isset($fs_left)) $lastAction = "forceSpin";
							else $lastAction = "forceFreespin";
							//	 $symbols=$s_s_symbols;
							$symbols = $orig_symbols;
							include($gamePath . 'lines.php');
						}
						$stackExit = 2000;
					}
				} elseif ($lastAction == "respin") {
					$respinSym = $overlaySym;
					if ($respinSym == 3)	$output .= "respin.symbol=SYM18&";
					elseif ($respinSym == 4)	$output .= "respin.symbol=SYM19&";
					elseif ($respinSym == 5)	$output .= "respin.symbol=SYM20&";
					else $output .= "respin.symbol=SYM$respinSym&";

					$stackExit = 2500;
				} else $stackExit = 1000;
			}
		} else $stackExit = 1500;
		if ($stepNum > 10) $stackExit = 500;
	} while ($stackExit == 0);

	if ($stackExit == 1000 and ($lastAction == "cancel_r_s" or $lastAction == "pre_r_s")) {
		$feature_triggered = "false";
		$feature_positions .= "";
		$symbols = $symbolsOverlayed;
		$lastAction = "spin";
	}
	//////////////////////////////////////


	//echo "SE= $stackExit , SN = $stepNum LAST = $lastAction <br>";
	//echo "FP ".urldecode($feature_positions)." <br>";

	//echo "////////////////////////////////////////<br>";

	/*$syms_after="<br>syms<br>";
for($j=0;$j<5;$j++)
 {
for($i=0;$i<6;$i++)
    {
$syms_after.="[".$symbols[$i][$j]."]\t\t\t\t";
    }
$syms_after.="<br>";
 }
echo $syms_after;
echo "<br>";

$syms_after="<br>symsOVER<br>";
for($j=0;$j<5;$j++)
 {
for($i=0;$i<6;$i++)
    {
$syms_after.="[".$symbolsOverlayed[$i][$j]."]\t\t\t\t";
    }
$syms_after.="<br>";
 }
echo $syms_after;
echo "<br>";

$syms_after="<br>EQ OV<br>";
for($j=0;$j<5;$j++)
 {
for($i=0;$i<6;$i++)
    {
$syms_after.="[".$equalOverlay[$i][$j]."]\t\t\t\t";
    }
$syms_after.="<br>";
 }
echo $syms_after;
echo "<br>";
*/

	////////////////////////////////////////

	if (isset($fs_left) and ($lastAction == 'pre_s_s' or $lastAction == 'forceFreespin')) {
		$symbolsOverallCount[11] = 0;
		$symbols = $s_s_symbols;
		$symbolsOverlayed = $orig_symbols;
		$wilds = '';
		$wilds2 = '';
		/*$syms_after="<br>11 $lastAction<br>";
for($j=0;$j<5;$j++)
 {
for($i=0;$i<6;$i++)
    {
$syms_after.="[".$symbols[$i][$j]."]\t\t\t\t";
    }
$syms_after.="<br>";
 }
echo $syms_after;
echo "<br>";*/
		for ($i = 0; $i < 6; $i++) {
			for ($j = 0; $j < 5; $j++) {
				if ($symbols[$i][$j] == 11 and $equalOverlay[$i][$j] != 11) {
					$symbolsOverallCount[11] += 1;
					//		    $wildMatrix[$i][$j]=11;
				}
			}
		}
		//    echo "SYMCOUNT ".$symbolsOverallCount[11]." fs $fs_left<br>";

		if ($lastAction == 'forceFreespin') {
			$feature_positions = $fs_feature_positions;
			//    echo "FPos $fs_feature_positions<br>";
		}
		$lastAction = "freespin";
		$stepNum = 0;
		if ($symbolsOverallCount[11] > 5) {
			do {
				$i = round(rand(0, 5));
				$j = round(rand(0, 4));
				if ($symbols[$i][$j] == 11) {
					//echo "gobo";
					$symbolsOverallCount[11]--;
					if ($wilds2 == '') $wilds2 = $i . ":" . $j;
					else $wilds2 .= "," . $i . ":" . $j;
					$symbols[$i][$j] = 12;
					//		$wildMatrix[$i][$j]='';
				}
				//	    echo $stepNum." -  $i $j ".$symbols[$i][$j]."<br>";
				$stepNum++;
			} while ($symbolsOverallCount[11] > 5);
		}
	}
	for ($i = 0; $i < 6; $i++) {
		for ($j = 0; $j < 5; $j++) {
			if ($symbols[$i][$j] == 11) {
				if ($wilds == '') $wilds = $i . ":" . $j;
				else $wilds .= "," . $i . ":" . $j;
				//		    $wildMatrix[$i][$j]=11;
			}
		}
	}

	$wilds2 = $wilds;

	//echo "SYMCOUNT ".$symbolsOverallCount[11]." $wilds<br>";
	/*$syms_after="<br>12<br>";
for($j=0;$j<5;$j++)
 {
for($i=0;$i<6;$i++)
    {
$syms_after.="[".$symbols[$i][$j]."]\t\t\t\t";
    }
$syms_after.="<br>";
 }
echo $syms_after;
echo "<br>";
echo "RSLA ".$lastAction." <br>";*/

	//////////
	//draw rs
	//////////
	$anim_num = 0;

	for ($i = 0; $i < 6; $i++) {
		$anim_num = 0;
		for ($j = 0; $j < 5; $j++) {
			if ($symbols[$i][$j] == $overlaySym and $symbolsOverlayed[$i][$j] != $overlaySym and $lastAction != "pre_s_s" and $lastAction != "respin" and $lastAction != "lastrespin") { {
					if ($overlaySym == 3) $OS = 18;
					elseif ($overlaySym == 4) $OS = 19;
					elseif ($overlaySym == 5) $OS = 20;
					else $OS = $overlaySym;
					$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".with=SYM" . $OS . "&";
					$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".row=" . $j . "&";
					$anim_num++;
				}
			}
			/*
//		if($lastAction=="lastrespin" and $symbolsOverlayed[$i][$j]==$respinSym)//////////noneed?????
		    {
//			$symbolsOverlayed[$i][$j]=$overlaySym;
//				if($overlaySym==3)$OS=18;elseif($overlaySym==4)$OS=19;elseif($overlaySym==5)$OS=20;else $OS=$overlaySym;///??
//				$output.= "<br>&rs.i0.r.i".$i.".overlay.i".$anim_num.".with=SYM".$overlaySym."&";
//				$output.= "<br>&rs.i0.r.i".$i.".overlay.i".$anim_num.".row=".$j."&";
//			$anim_num++;
		    }
*/
			if ($lastAction == "pre_s_s" and $symbols[$i][$j] == $overlaySym and $symbolsOverlayed[$i][$j] != $overlaySym) {
				$symbolsOverlayed[$i][$j] = 11;
			}
			if ($lastAction == "pre_s_s" and isset($equalOverlay[$i][$j])) {
				$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".with=SYM" . $equalOverlay[$i][$j] . "&";
				$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".row=" . $j . "&";
				$anim_num++;
			}
			if ($lastAction == "freespin") {
				if ($symbols[$i][$j] == 12 or $symbols[$i][$j] == 11) {
					$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".pos=" . ($anim_num * 10 + $i) . "&";
					$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".with=SYM11&";
					$output .= "rs.i0.r.i" . $i . ".overlay.i" . $anim_num . ".row=" . $j . "&";
					$anim_num++;
				}
			}
		}
	}

	//echo "OS $overlaySym <br>";
	/*$syms_after="<br>symsOVER2<br>";
for($j=0;$j<5;$j++)
 {
for($i=0;$i<6;$i++)
    {
$syms_after.="[".$symbolsOverlayed[$i][$j]."]\t\t\t\t";
    }
$syms_after.="<br>";
 }
echo $syms_after;
echo "<br>";*/
	$anim_num = 0;
	if ($reelset != 'respin2' and $reelset != 'respin4') {
		for ($i = 0; $i < 6; $i++) {
			for ($j = 0; $j < 5; $j++) {
				$rs[$j] = $symbolsOverlayed[$i][$j];

				if (($nearwin < 2 or $lastAction == "initfreespin") and $symbolsOverlayed[$i][$j] == 0) {
					$output .= "rs.i0.r.i" . $i . ".attention.i" . $anim_num . "=" . $j . "&";
					$anim_num++;
				}
			}
			$output .= "rs.i0.r.i" . $i . ".hold=false&";
			$lastRs .= "rs.i0.r.i" . $i . ".syms=SYM" . $rs[0] . ",SYM" . $rs[1] . ",SYM" . $rs[2] . ",SYM" . $rs[3] . ",SYM" . $rs[4] . "&";

			if ($bonusSymbCount > 1 and $nearwin > 1) {
				if ($nearwinstr == '') $nearwinstr = $i;
				else $nearwinstr .= "," . $i;
			}
			if ($bonusReels[$i] == 1) $nearwin++;
			$anim_num = 0;
		}
		if ($lastAction != "freespin" and $lastAction != "respin"  and $lastAction != "lastrespin" and $nearwinstr != '')	$output .= "rs.i0.nearwin=" . $nearwinstr . "&";
	}
	//////////////////by single symbols
	else {
		$anim_num = 0;
		for ($i = 0; $i < 6; $i++) {
			for ($j = 0; $j < 5; $j++) {
				$output .= "rs.i0.r.i" . $anim_num . ".syms=SYM" . $symbolsOverlayed[$i][$j] . "&";
				$output .= "rs.i0.r.i" . $anim_num . ".hold=false&";
				$output .= "rs.i0.r.i" . $anim_num . ".pos=0&";
				$anim_num++;
			}
		}
	}
	$output .= $lastRs;
	if ($nudgeReel != '-1' and $fs_initial > 1 and $lastAction == 'spin') {
		$fs_initial++;
		if ($fs_initial > 4) $lastAction = 'initfreespin';
	}

	/////////////////////////////
	//draw ws			
	///////////////////////////
	$anim_num = 0;
	$total_win = 0;

	if ($lastAction == "initfreespin") {

		if ($buster10 != '') $fs_initial *= 2;
		$output .= "ws.i0.betline=null&";
		$output .= "ws.i0.direction=none&";
		foreach ($fs_wsStr as $e => $v) {
			$output .= "ws.i0.pos.i" . $e . "=" . $v . "&";
		}
		if ($nudgeReel != '-1') {
			$output .= "ws.i0.pos.i" . ($e + 1) . "=" . $nudgeReel . ",4&";
			$output .= "ws.i0.nudge=" . $nudgeReel . ":" . $nudgeOffset . "&";
			$output .= "rs.i0.nudge=" . $nudgeReel . ":" . $nudgeOffset . "&";
		}
		$output .= "ws.i0.reelset=basic&";
		$output .= "ws.i0.sym=SYM0&";
		$output .= "ws.i0.types.i0.freespins=" . $fs_initial . "&";
		$output .= "ws.i0.types.i0.multipliers=1&";
		$output .= "ws.i0.types.i0.wintype=freespins&";
	}
	foreach ($win as $e => $v) {
		$tmp = explode("_", $v);
		if ($lastAction != "freespin") $output .= "<br>&ws.i" . $anim_num . ".reelset=$reelset&";
		else $output .= "ws.i" . $anim_num . ".reelset=freespin&";

		if ($lastAction != "freespin" and $lastAction != "endfreespin")
			if ($buster12 != '') {
				$tmp[0] *= 2;
				$symb_combs .= " bus12=$buster12, " . $tmp[0] . ";";
			}

		$right_coins = $tmp[0] * $denomDB;

		$output .= "ws.i" . $anim_num . ".sym=SYM" . $tmp[2] . "&";

		$output .= "ws.i" . $anim_num . ".direction=none&";
		$output .= "ws.i" . $anim_num . ".betline=null&";
		$output .= "ws.i" . $anim_num . ".types.i0.coins=" . $tmp[0] . "&";
		$output .= "ws.i" . $anim_num . ".types.i0.cents=" . $right_coins . "&";
		$output .= "ws.i" . $anim_num . ".types.i0.wintype=coins&";

		$total_win += $tmp[0];

		$ani = explode(";", $tmp[1]);
		$i = 0;

		foreach ($ani as $smb) {
			$output .= "ws.i" . $anim_num . ".pos.i" . $i . "=" . $smb . "&";
			$i++;
		}

		$anim_num++;
	}
	$total_winCents = $total_win * $denomDB;



	if ($lastAction == "freespin") {
		$fs_total = $fs_left + $fs_played;
		$fs_totalwin += $total_win;

		if ($fs_left > 0 and $lastAction == "freespin") {
			$output .= "rs.i0.id=freespin&";
			$output .= "current.rs.i0=freespin&";
			$output .= "gamestate.current=freespin&";
			$output .= "gamestate.stack=basic%2Cfreespin&";
			$output .= "gamestate.history=basic%2Cfreespin&";

			$output .= "last.rs=freespin&";
			$output .= "next.rs=freespin&";
			$output .= "previous.rs.i0=freespin&";

			$output .= "clientaction=freespin&";
			$output .= "nextaction=freespin&";

			$gameover = 'false';
			$table_locked = 1;
			$botAction = "freespin";
		} else {
			$output .= "rs.i0.id=freespin&";
			$output .= "gamestate.current=basic&";
			$output .= "gamestate.stack=basic&";
			$output .= "gamestate.history=basic%2Cfreespin&";
			$output .= "clientaction=freespin&";
			$output .= "nextaction=spin&";

			$lastAction = 'endfreespin';
			$botAction = "spin";
			$wavecount = 0;
			$table_locked = 0;
		}
		//echo "next= $wilds <br>";
		//echo "added= $feature_positions <br>";

		$output .= "freespins.substitution.next=$wilds2&";
		$output .= "freespins.substitution.added=$feature_positions&";

		$output .= "freespins.betlevel=1&";
		$output .= "freespins.betlines=0&";
		$output .= "freespins.denomination=1.000&";
		$output .= "freespins.initial=$fs_initial&";
		$output .= "freespins.left=" . $fs_left . "&";
		$output .= "freespins.multiplier=1&";
		$output .= "freespins.played=" . $fs_played . "&";
		$output .= "freespins.total=" . $fs_total . "&";
		$output .= "freespins.totalwin.coins=" . $fs_totalwin . "&";
		$output .= "freespins.totalwin.cents=" . $fs_totalwin . "&";
		$output .= "freespins.wavecount=1&";
		$output .= "freespins.win.cents=" . $fs_totalwin . "&";
		$output .= "freespins.win.coins=" . $fs_totalwin . "&";

		$symb_combs .= "fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";";
	} elseif ($lastAction == "initfreespin") {
		$output .= "clientaction=spin&";
		$output .= "current.rs.i0=freespin&";
		$output .= "freespins.betlevel=1&";
		$output .= "freespins.betlines=0&";
		$output .= "freespins.denomination=1.000&";
		$output .= "freespins.initial=" . $fs_initial . "&";
		$output .= "freespins.left=" . $fs_initial . "&";
		$output .= "freespins.multiplier=1&";
		$output .= "freespins.total=" . $fs_initial . "&";
		$output .= "freespins.totalwin.cents=0&";
		$output .= "freespins.totalwin.coins=0&";
		$output .= "freespins.wavecount=1&";
		$output .= "freespins.win.cents=0&";
		$output .= "freespins.win.coins=0&";
		$output .= "gamestate.current=freespin&";
		$output .= "gamestate.history=basic&";
		$output .= "gamestate.stack=basic%2Cfreespin&";
		$output .= "next.rs=freespin&";
		$output .= "nextaction=freespin&";
		$output .= "rs.i0.id=basic&";

		$gameover = "false";
		$botAction = "initfreespin";
		$table_locked = 1;
	} elseif ($lastAction == "lastrespin") {
		$output .= "clientaction=respin&";
		$output .= "current.rs.i0=basic&";
		$output .= "last.rs=respin4&";
		$output .= "next.rs=basic&";
		$output .= "nextaction=spin&";
		$output .= "previous.rs.i0=respin4&";
		$output .= "rs.i0.id=respin4&";

		$output .= "gamestate.current=basic&";
		$output .= "gamestate.history=basic&";
		$output .= "gamestate.stack=basic&";

		$botAction = "spin";
		$table_locked = 0;
	} elseif ($lastAction == "respin") {

		$output .= "previous.rs.i0=$rs_Id&";

		$output .= "current.rs.i0=$reelset&";
		$output .= "next.rs=$reelset&";
		$output .= "rs.i0.id=$rs_Id&";

		$output .= "gamestate.current=basic&";
		$output .= "gamestate.history=basic&";
		$output .= "gamestate.stack=basic&";

		$output .= "nextaction=respin&";
		$output .= "clientaction=$clientAction&";

		$output .= "respin.positions=" . $wilds . "&";

		$gameover = "false";
		$botAction = "respin";
		$table_locked = 1;
	} else {
		$output .= "rs.i0.id=basic&";
		$output .= "current.rs.i0=basic&";

		$output .= "clientaction=spin&";
		$output .= "nextaction=spin&";

		$output .= "next.rs=basic&";

		$output .= "gamestate.current=basic&";
		$output .= "gamestate.stack=basic&";
		$output .= "gamestate.history=basic&";

		$botAction = "spin";
		$table_locked = 0;
	}

	if ($lastAction != 'freespin')	$output .= "feature.positions=$feature_positions&";
	$output .= "feature.triggered=$feature_triggered&";

	$output .= "freespins.retriggered=false&";

	//echo "LADB=$lastActionDB&LA=$lastAction&mrs=$reelset&<br>&";
	//echo "SYM $respinSym , w $wilds <br>&";

	$spincost = 0;
	if ($lastAction != 'respin' and $lastAction != 'freespin' and $lastAction != 'endfreespin') {
		$spin_to_history = 1;
		$spincost = $betDB * $denomDB * 0.15;
	}
	$credit /= 100;

	$real_win = $total_win * $denomDB * 0.01;

	if ($lastAction != 'respin' and $lastAction != 'freespin' and $lastAction != 'endfreespin') {
		$credit -= $spincost;
	}

	$credit += $real_win;
	$creditDB = $credit * 100;
	$credit *= 100;

	if ($lastAction == 'endfreespin') $totalWinsDB = $fs_totalwin;
	else $totalWinsDB = $total_win;
}

$common = '';

if ($lastAction == "respin") {
	$answ .= "respinSym=" . $respinSym . ";";
}

if ($lastAction == "freespin" or $lastAction == "startfreespin") {
	$answ .= "fs_initial=" . $fs_initial . ";fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";respinSym=" . $respinSym . ";";
}

if ($lastAction == "initfreespin") {
	$answ .= "fs_initial=" . $fs_initial . ";respinSym=11;";
}

$query = "answer='" . $answ . "'";
$query .= ", common='" . $common . "'";

$query .= ", locked='" . $table_locked . "'";

$query .= ", lastAction='" . $lastAction . "',wilds='" . $wilds . "', lastRs='" . $lastRs . "'";

$result = mysql_query("UPDATE ns.states set " . $query . " where sessionId='" . $_GET['sessid'] . "';");
