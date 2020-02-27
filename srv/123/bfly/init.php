<?
$totalWinsDB = 0;
$total_win = 0;

$table_locked = 0;
$gsStack = "basic";
$gsCur = "basic";
$nesxAct = "spin";

$restore = "false";

if ($lastActionDB == "freespin" or $lastActionDB == "initfreespin") {
	$fs_multiplier = 1;
	$fs_initial = 10;

	$answ .= "wildStcks=" . $wildsDB . ";";

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

$output .= "playforfun=false&";


/////////////////////////parser
/*
$str=explode('&',$output);
sort($str);
foreach($str as $e=>$v)
echo '$output.= "'.$v.'&";<br>';
*/
////////////////////////

$output .= "autoplay=10%2C25%2C50%2C75%2C100%2C250%2C500%2C750%2C1000&";
$output .= "autoplayLossLimitEnabled=false&";
$output .= "betlevel.all=1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10&";
$output .= "bl.i0.coins=20&";
$output .= "bl.i0.id=0&";
$output .= "bl.i0.line=0%2C0%2C0%2C0%2C0&";
$output .= "bl.i0.reelset=ALL&";
$output .= "bl.i1.coins=0&";
$output .= "bl.i1.id=1&";
$output .= "bl.i1.line=1%2C1%2C1%2C1%2C1&";
$output .= "bl.i1.reelset=ALL&";
$output .= "bl.i10.coins=0&";
$output .= "bl.i10.id=10&";
$output .= "bl.i10.line=3%2C2%2C1%2C1%2C1&";
$output .= "bl.i10.reelset=ALL&";
$output .= "bl.i11.coins=0&";
$output .= "bl.i11.id=11&";
$output .= "bl.i11.line=2%2C1%2C0%2C0%2C0&";
$output .= "bl.i11.reelset=ALL&";
$output .= "bl.i12.coins=0&";
$output .= "bl.i12.id=12&";
$output .= "bl.i12.line=0%2C1%2C0%2C1%2C0&";
$output .= "bl.i12.reelset=ALL&";
$output .= "bl.i13.coins=0&";
$output .= "bl.i13.id=13&";
$output .= "bl.i13.line=1%2C2%2C1%2C2%2C1&";
$output .= "bl.i13.reelset=ALL&";
$output .= "bl.i14.coins=0&";
$output .= "bl.i14.id=14&";
$output .= "bl.i14.line=2%2C3%2C2%2C3%2C2&";
$output .= "bl.i14.reelset=ALL&";
$output .= "bl.i15.coins=0&";
$output .= "bl.i15.id=15&";
$output .= "bl.i15.line=3%2C2%2C3%2C2%2C3&";
$output .= "bl.i15.reelset=ALL&";
$output .= "bl.i16.coins=0&";
$output .= "bl.i16.id=16&";
$output .= "bl.i16.line=2%2C1%2C2%2C1%2C2&";
$output .= "bl.i16.reelset=ALL&";
$output .= "bl.i17.coins=0&";
$output .= "bl.i17.id=17&";
$output .= "bl.i17.line=1%2C0%2C1%2C0%2C1&";
$output .= "bl.i17.reelset=ALL&";
$output .= "bl.i18.coins=0&";
$output .= "bl.i18.id=18&";
$output .= "bl.i18.line=0%2C1%2C0%2C0%2C0&";
$output .= "bl.i18.reelset=ALL&";
$output .= "bl.i19.coins=0&";
$output .= "bl.i19.id=19&";
$output .= "bl.i19.line=1%2C2%2C1%2C1%2C1&";
$output .= "bl.i19.reelset=ALL&";
$output .= "bl.i2.coins=0&";
$output .= "bl.i2.id=2&";
$output .= "bl.i2.line=2%2C2%2C2%2C2%2C2&";
$output .= "bl.i2.reelset=ALL&";
$output .= "bl.i20.coins=0&";
$output .= "bl.i20.id=20&";
$output .= "bl.i20.line=2%2C3%2C2%2C2%2C2&";
$output .= "bl.i20.reelset=ALL&";
$output .= "bl.i21.coins=0&";
$output .= "bl.i21.id=21&";
$output .= "bl.i21.line=3%2C2%2C3%2C3%2C3&";
$output .= "bl.i21.reelset=ALL&";
$output .= "bl.i22.coins=0&";
$output .= "bl.i22.id=22&";
$output .= "bl.i22.line=2%2C1%2C2%2C2%2C2&";
$output .= "bl.i22.reelset=ALL&";
$output .= "bl.i23.coins=0&";
$output .= "bl.i23.id=23&";
$output .= "bl.i23.line=1%2C0%2C1%2C1%2C1&";
$output .= "bl.i23.reelset=ALL&";
$output .= "bl.i24.coins=0&";
$output .= "bl.i24.id=24&";
$output .= "bl.i24.line=0%2C0%2C0%2C1%2C2&";
$output .= "bl.i24.reelset=ALL&";
$output .= "bl.i25.coins=0&";
$output .= "bl.i25.id=25&";
$output .= "bl.i25.line=1%2C1%2C1%2C2%2C3&";
$output .= "bl.i25.reelset=ALL&";
$output .= "bl.i26.coins=0&";
$output .= "bl.i26.id=26&";
$output .= "bl.i26.line=3%2C3%2C3%2C2%2C1&";
$output .= "bl.i26.reelset=ALL&";
$output .= "bl.i27.coins=0&";
$output .= "bl.i27.id=27&";
$output .= "bl.i27.line=2%2C2%2C2%2C1%2C0&";
$output .= "bl.i27.reelset=ALL&";
$output .= "bl.i28.coins=0&";
$output .= "bl.i28.id=28&";
$output .= "bl.i28.line=0%2C1%2C1%2C1%2C0&";
$output .= "bl.i28.reelset=ALL&";
$output .= "bl.i29.coins=0&";
$output .= "bl.i29.id=29&";
$output .= "bl.i29.line=1%2C2%2C2%2C2%2C1&";
$output .= "bl.i29.reelset=ALL&";
$output .= "bl.i3.coins=0&";
$output .= "bl.i3.id=3&";
$output .= "bl.i3.line=3%2C3%2C3%2C3%2C3&";
$output .= "bl.i3.reelset=ALL&";
$output .= "bl.i30.coins=0&";
$output .= "bl.i30.id=30&";
$output .= "bl.i30.line=2%2C3%2C3%2C3%2C2&";
$output .= "bl.i30.reelset=ALL&";
$output .= "bl.i31.coins=0&";
$output .= "bl.i31.id=31&";
$output .= "bl.i31.line=3%2C2%2C2%2C2%2C3&";
$output .= "bl.i31.reelset=ALL&";
$output .= "bl.i32.coins=0&";
$output .= "bl.i32.id=32&";
$output .= "bl.i32.line=2%2C1%2C1%2C1%2C2&";
$output .= "bl.i32.reelset=ALL&";
$output .= "bl.i33.coins=0&";
$output .= "bl.i33.id=33&";
$output .= "bl.i33.line=1%2C0%2C0%2C0%2C1&";
$output .= "bl.i33.reelset=ALL&";
$output .= "bl.i34.coins=0&";
$output .= "bl.i34.id=34&";
$output .= "bl.i34.line=0%2C1%2C1%2C0%2C1&";
$output .= "bl.i34.reelset=ALL&";
$output .= "bl.i35.coins=0&";
$output .= "bl.i35.id=35&";
$output .= "bl.i35.line=1%2C2%2C2%2C1%2C2&";
$output .= "bl.i35.reelset=ALL&";
$output .= "bl.i36.coins=0&";
$output .= "bl.i36.id=36&";
$output .= "bl.i36.line=2%2C3%2C3%2C2%2C3&";
$output .= "bl.i36.reelset=ALL&";
$output .= "bl.i37.coins=0&";
$output .= "bl.i37.id=37&";
$output .= "bl.i37.line=3%2C2%2C3%2C3%2C2&";
$output .= "bl.i37.reelset=ALL&";
$output .= "bl.i38.coins=0&";
$output .= "bl.i38.id=38&";
$output .= "bl.i38.line=2%2C1%2C2%2C2%2C1&";
$output .= "bl.i38.reelset=ALL&";
$output .= "bl.i39.coins=0&";
$output .= "bl.i39.id=39&";
$output .= "bl.i39.line=1%2C0%2C1%2C1%2C0&";
$output .= "bl.i39.reelset=ALL&";
$output .= "bl.i4.coins=0&";
$output .= "bl.i4.id=4&";
$output .= "bl.i4.line=0%2C1%2C2%2C1%2C0&";
$output .= "bl.i4.reelset=ALL&";
$output .= "bl.i5.coins=0&";
$output .= "bl.i5.id=5&";
$output .= "bl.i5.line=1%2C2%2C3%2C2%2C1&";
$output .= "bl.i5.reelset=ALL&";
$output .= "bl.i6.coins=0&";
$output .= "bl.i6.id=6&";
$output .= "bl.i6.line=3%2C2%2C1%2C2%2C3&";
$output .= "bl.i6.reelset=ALL&";
$output .= "bl.i7.coins=0&";
$output .= "bl.i7.id=7&";
$output .= "bl.i7.line=2%2C1%2C0%2C1%2C2&";
$output .= "bl.i7.reelset=ALL&";
$output .= "bl.i8.coins=0&";
$output .= "bl.i8.id=8&";
$output .= "bl.i8.line=0%2C1%2C2%2C2%2C2&";
$output .= "bl.i8.reelset=ALL&";
$output .= "bl.i9.coins=0&";
$output .= "bl.i9.id=9&";
$output .= "bl.i9.line=1%2C2%2C3%2C3%2C3&";
$output .= "bl.i9.reelset=ALL&";
$output .= "bl.standard=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C21%2C22%2C23%2C24%2C25%2C26%2C27%2C28%2C29%2C30%2C31%2C32%2C33%2C34%2C35%2C36%2C37%2C38%2C39&";
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

$output .= "bet.betlevel=10&";
$output .= "bet.denomination=" . $denomDB . "&";


$output .= "gameEventSetters.enabled=false&";
$output .= "gamesoundurl=https%3A%2F%2F" . $soundURL . "%2F&";
$output .= "nearwinallowed=true&";
$output .= "rs.i0.id=freespin_last&";
$output .= "rs.i0.r.i0.hold=false&";
$output .= "rs.i0.r.i0.pos=0&";
$output .= "rs.i0.r.i0.syms=SYM3%2CSYM12%2CSYM12%2CSYM12&";
$output .= "rs.i0.r.i1.hold=false&";
$output .= "rs.i0.r.i1.pos=0&";
$output .= "rs.i0.r.i1.syms=SYM3%2CSYM12%2CSYM12%2CSYM12&";
$output .= "rs.i0.r.i2.hold=false&";
$output .= "rs.i0.r.i2.pos=0&";
$output .= "rs.i0.r.i2.syms=SYM3%2CSYM12%2CSYM12%2CSYM12&";
$output .= "rs.i0.r.i3.hold=false&";
$output .= "rs.i0.r.i3.pos=0&";
$output .= "rs.i0.r.i3.syms=SYM3%2CSYM12%2CSYM12%2CSYM12&";
$output .= "rs.i0.r.i4.hold=false&";
$output .= "rs.i0.r.i4.pos=0&";
$output .= "rs.i0.r.i4.syms=SYM3%2CSYM12%2CSYM12%2CSYM12&";
$output .= "rs.i1.id=respin1&";
$output .= "rs.i1.r.i0.hold=false&";
$output .= "rs.i1.r.i0.pos=0&";
$output .= "rs.i1.r.i0.syms=SYM3%2CSYM3%2CSYM3%2CSYM3&";
$output .= "rs.i1.r.i1.hold=false&";
$output .= "rs.i1.r.i1.pos=0&";
$output .= "rs.i1.r.i1.syms=SYM7%2CSYM8%2CSYM6%2CSYM4&";
$output .= "rs.i1.r.i2.hold=false&";
$output .= "rs.i1.r.i2.pos=0&";
$output .= "rs.i1.r.i2.syms=SYM5%2CSYM9%2CSYM8%2CSYM6&";
$output .= "rs.i1.r.i3.hold=false&";
$output .= "rs.i1.r.i3.pos=0&";
$output .= "rs.i1.r.i3.syms=SYM9%2CSYM10%2CSYM8%2CSYM11&";
$output .= "rs.i1.r.i4.hold=false&";
$output .= "rs.i1.r.i4.pos=0&";
$output .= "rs.i1.r.i4.syms=SYM6%2CSYM10%2CSYM7%2CSYM8&";
$output .= "rs.i2.id=respin2&";
$output .= "rs.i2.r.i0.hold=false&";
$output .= "rs.i2.r.i0.pos=0&";
$output .= "rs.i2.r.i0.syms=SYM3%2CSYM3%2CSYM3%2CSYM3&";
$output .= "rs.i2.r.i1.hold=false&";
$output .= "rs.i2.r.i1.pos=0&";
$output .= "rs.i2.r.i1.syms=SYM6%2CSYM10%2CSYM4%2CSYM3&";
$output .= "rs.i2.r.i2.hold=false&";
$output .= "rs.i2.r.i2.pos=0&";
$output .= "rs.i2.r.i2.syms=SYM9%2CSYM7%2CSYM4%2CSYM11&";
$output .= "rs.i2.r.i3.hold=false&";
$output .= "rs.i2.r.i3.pos=0&";
$output .= "rs.i2.r.i3.syms=SYM11%2CSYM11%2CSYM7%2CSYM6&";
$output .= "rs.i2.r.i4.hold=false&";
$output .= "rs.i2.r.i4.pos=0&";
$output .= "rs.i2.r.i4.syms=SYM10%2CSYM7%2CSYM11%2CSYM11&";
$output .= "rs.i3.id=freespin_first&";
$output .= "rs.i3.r.i0.hold=false&";
$output .= "rs.i3.r.i0.pos=0&";
$output .= "rs.i3.r.i0.syms=SYM3%2CSYM12%2CSYM12%2CSYM12&";
$output .= "rs.i3.r.i1.hold=false&";
$output .= "rs.i3.r.i1.pos=0&";
$output .= "rs.i3.r.i1.syms=SYM12%2CSYM3%2CSYM12%2CSYM12&";
$output .= "rs.i3.r.i2.hold=false&";
$output .= "rs.i3.r.i2.pos=0&";
$output .= "rs.i3.r.i2.syms=SYM3%2CSYM12%2CSYM12%2CSYM12&";
$output .= "rs.i3.r.i3.hold=false&";
$output .= "rs.i3.r.i3.pos=0&";
$output .= "rs.i3.r.i3.syms=SYM3%2CSYM12%2CSYM12%2CSYM12&";
$output .= "rs.i3.r.i4.hold=false&";
$output .= "rs.i3.r.i4.pos=0&";
$output .= "rs.i3.r.i4.syms=SYM12%2CSYM12%2CSYM3%2CSYM12&";
$output .= "rs.i4.id=respin3&";
$output .= "rs.i4.r.i0.hold=false&";
$output .= "rs.i4.r.i0.pos=0&";
$output .= "rs.i4.r.i0.syms=SYM3%2CSYM3%2CSYM3%2CSYM3&";
$output .= "rs.i4.r.i1.hold=false&";
$output .= "rs.i4.r.i1.pos=0&";
$output .= "rs.i4.r.i1.syms=SYM5%2CSYM4%2CSYM6%2CSYM8&";
$output .= "rs.i4.r.i2.hold=false&";
$output .= "rs.i4.r.i2.pos=0&";
$output .= "rs.i4.r.i2.syms=SYM9%2CSYM4%2CSYM6%2CSYM7&";
$output .= "rs.i4.r.i3.hold=false&";
$output .= "rs.i4.r.i3.pos=0&";
$output .= "rs.i4.r.i3.syms=SYM11%2CSYM11%2CSYM9%2CSYM7&";
$output .= "rs.i4.r.i4.hold=false&";
$output .= "rs.i4.r.i4.pos=0&";
$output .= "rs.i4.r.i4.syms=SYM11%2CSYM11%2CSYM6%2CSYM4&";
$output .= "rs.i5.id=freespin_standard&";
$output .= "rs.i5.r.i0.hold=false&";
$output .= "rs.i5.r.i0.pos=0&";
$output .= "rs.i5.r.i0.syms=SYM3%2CSYM12%2CSYM12%2CSYM12&";
$output .= "rs.i5.r.i1.hold=false&";
$output .= "rs.i5.r.i1.pos=0&";
$output .= "rs.i5.r.i1.syms=SYM3%2CSYM12%2CSYM12%2CSYM12&";
$output .= "rs.i5.r.i2.hold=false&";
$output .= "rs.i5.r.i2.pos=0&";
$output .= "rs.i5.r.i2.syms=SYM3%2CSYM12%2CSYM12%2CSYM12&";
$output .= "rs.i5.r.i3.hold=false&";
$output .= "rs.i5.r.i3.pos=0&";
$output .= "rs.i5.r.i3.syms=SYM3%2CSYM12%2CSYM12%2CSYM12&";
$output .= "rs.i5.r.i4.hold=false&";
$output .= "rs.i5.r.i4.pos=0&";
$output .= "rs.i5.r.i4.syms=SYM12%2CSYM3%2CSYM12%2CSYM12&";
$output .= "rs.i6.id=basic&";
$output .= "rs.i6.r.i0.hold=false&";
$output .= "rs.i6.r.i0.pos=290&";
$output .= "rs.i6.r.i0.syms=SYM9%2CSYM10%2CSYM11%2CSYM12&";
$output .= "rs.i6.r.i1.hold=false&";
$output .= "rs.i6.r.i1.pos=67&";
$output .= "rs.i6.r.i1.syms=SYM4%2CSYM0%2CSYM10%2CSYM5&";
$output .= "rs.i6.r.i2.hold=false&";
$output .= "rs.i6.r.i2.pos=175&";
$output .= "rs.i6.r.i2.syms=SYM1%2CSYM7%2CSYM6%2CSYM9&";
$output .= "rs.i6.r.i3.hold=false&";
$output .= "rs.i6.r.i3.pos=98&";
$output .= "rs.i6.r.i3.syms=SYM9%2CSYM3%2CSYM7%2CSYM5&";
$output .= "rs.i6.r.i4.hold=false&";
$output .= "rs.i6.r.i4.pos=58&";
$output .= "rs.i6.r.i4.syms=SYM5%2CSYM6%2CSYM4%2CSYM3&";
$output .= "rs.i7.id=respin_first&";
$output .= "rs.i7.r.i0.hold=false&";
$output .= "rs.i7.r.i0.pos=0&";
$output .= "rs.i7.r.i0.syms=SYM3%2CSYM3%2CSYM3%2CSYM3&";
$output .= "rs.i7.r.i1.hold=false&";
$output .= "rs.i7.r.i1.pos=0&";
$output .= "rs.i7.r.i1.syms=SYM4%2CSYM6%2CSYM5%2CSYM10&";
$output .= "rs.i7.r.i2.hold=false&";
$output .= "rs.i7.r.i2.pos=0&";
$output .= "rs.i7.r.i2.syms=SYM5%2CSYM3%2CSYM3%2CSYM4&";
$output .= "rs.i7.r.i3.hold=false&";
$output .= "rs.i7.r.i3.pos=0&";
$output .= "rs.i7.r.i3.syms=SYM4%2CSYM10%2CSYM8%2CSYM5&";
$output .= "rs.i7.r.i4.hold=false&";
$output .= "rs.i7.r.i4.pos=0&";
$output .= "rs.i7.r.i4.syms=SYM8%2CSYM9%2CSYM7%2CSYM6&";
$output .= "staticsharedurl=https%3A%2F%2F" . $staticSharedURL . "%2Fgameclient_html%2Fdevicedetection%2Fcurrent&";
