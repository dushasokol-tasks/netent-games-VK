<?
$output .= "bl.i13.coins=0&bl.i3.coins=0&bl.i5.id=5&bl.i11.id=11&bl.i12.coins=0&bl.i6.id=6&bl.i24.reelset=ALL&bl.i28.reelset=ALL&bl.i24.coins=0&rs.i0.r.i2.hold=false&bl.i15.line=0%2C1%2C1%2C1%2C0&rs.i0.r.i4.pos=0&bl.i19.reelset=ALL&bl.i4.coins=0&
&bl.i25.coins=0&bl.i5.coins=0&bl.i22.id=22&bl.i3.reelset=ALL&bl.i14.coins=0&
&bl.i14.id=14&bl.i26.coins=0&bl.i9.line=1%2C0%2C1%2C0%2C1&bl.i23.reelset=ALL&bl.i17.reelset=ALL&bl.i12.id=12&bl.i26.reelset=ALL&nextaction=spin&bl.i10.coins=0&bl.i5.reelset=ALL&bl.i26.line=1%2C0%2C2%2C0%2C1&bl.i18.line=2%2C0%2C2%2C0%2C2&rs.i1.r.i4.hold=false&bl.i8.coins=0&bl.i6.coins=0&bl.i14.reelset=ALL&multiplier=1&gameover=true&rs.i0.r.i3.hold=false&rs.i2.r.i2.pos=0&bl.i4.line=2%2C1%2C0%2C1%2C2&bl.i27.coins=0&bl.i5.line=0%2C0%2C1%2C0%2C0&bl.i1.line=0%2C0%2C0%2C0%2C0&bl.i6.line=2%2C2%2C1%2C2%2C2&bl.i4.id=4&bl.i20.id=20&rs.i2.r.i3.pos=0&bl.i4.reelset=ALL&bl.i28.coins=0&bl.i1.reelset=ALL&rs.i1.id=respin&rs.i2.r.i2.hold=false&bl.i22.reelset=ALL&bl.i19.id=19&rs.i1.r.i2.hold=false&rs.i2.r.i0.hold=false&bl.i20.line=2%2C0%2C0%2C0%2C2&bl.i18.id=18&bl.i0.coins=30&bl.i17.id=17&bl.i15.id=15&game.win.amount=null&bl.i15.reelset=ALL&rs.i2.r.i4.hold=false&bl.standard=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C21%2C22%2C23%2C24%2C25%2C26%2C27%2C28%2C29&rs.i1.r.i0.pos=0&
&bl.i19.line=0%2C2%2C2%2C2%2C0&jackpotcurrency=%26%23x20AC%3B&bl.i6.reelset=ALL&bl.i10.reelset=ALL&autoplayLossLimitEnabled=false&bl.i25.line=1%2C2%2C0%2C2%2C1&
&nearwinallowed=true&bl.i16.reelset=ALL&bl.i9.coins=0&bl.i23.line=0%2C2%2C1%2C2%2C0&rs.i1.r.i1.pos=0&bl.i28.line=2%2C2%2C1%2C0%2C0&bl.i18.coins=0&totalwin.coins=0&rs.i2.r.i0.pos=0&bl.i15.coins=0&
&bl.i0.line=1%2C1%2C1%2C1%2C1&bl.i20.reelset=ALL&bl.i1.id=1&bl.i13.line=1%2C1%2C0%2C1%2C1&rs.i0.r.i1.pos=0&bl.i26.id=26&rs.i1.r.i0.hold=false&rs.i0.r.i3.pos=0&gameEventSetters.enabled=false&bl.i29.coins=0&bl.i12.reelset=ALL&bl.i28.id=28&bl.i24.line=2%2C0%2C1%2C0%2C2&bl.i29.line=0%2C1%2C2%2C2%2C2&rs.i1.r.i4.pos=0&
&bl.i19.coins=0&bl.i22.line=2%2C2%2C0%2C2%2C2&
&gamestate.current=basic&confirmBetMessageEnabled=false&rs.i2.id=basic&rs.i1.r.i2.pos=0&rs.i0.r.i4.hold=false&bl.i3.line=0%2C1%2C2%2C1%2C0&game.win.cents=0&rs.i2.r.i1.hold=false&bl.i13.id=13&bl.i17.line=0%2C2%2C0%2C2%2C0&";

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

$output .= "rs.i0.r.i0.pos=0&bl.i23.coins=0&bl.i22.coins=0&clientaction=init&rs.i1.r.i3.hold=false&bl.i25.reelset=ALL&rs.i2.r.i1.pos=0&bl.i16.id=16&
&playercurrencyiso=EUR&historybutton=false&bl.i8.reelset=ALL&bl.i1.coins=0&bl.i29.reelset=ALL&
&rs.i1.r.i3.pos=0&rs.i0.r.i1.hold=false&gamesoundurl=https%3A%2F%2F" . $soundURL . "&bl.i7.line=1%2C2%2C2%2C2%2C1&game.win.coins=0&bl.i14.line=1%2C1%2C2%2C1%2C1&bl.i27.id=27&rs.i0.r.i2.pos=0&totalwin.cents=0&bl.i23.id=23&betlevel.all=1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10&bl.i7.reelset=ALL&bl.i2.coins=0&bl.i10.id=10&bl.i11.line=0%2C1%2C0%2C1%2C0&
&rs.i2.r.i4.pos=0&bl.i8.line=1%2C0%2C0%2C0%2C1&bl.i8.id=8&wavecount=1&bl.i7.coins=0&bl.i17.coins=0&bl.i25.id=25&
&bl.i27.reelset=ALL&bl.i2.reelset=ALL&bl.i24.id=24&rs.i0.r.i0.hold=false&bl.i10.line=1%2C2%2C1%2C2%2C1&
&bl.i9.reelset=ALL&bl.i0.id=0&autoplay=10%2C25%2C50%2C75%2C100%2C250%2C500%2C750%2C1000&bl.i11.coins=0&restore=false&bl.i16.coins=0&bl.i11.reelset=ALL&bl.i2.id=2&bl.i3.id=3&bl.i21.line=0%2C0%2C2%2C0%2C0&bl.i12.line=2%2C1%2C2%2C1%2C2&isJackpotWin=false&jackpotcurrencyiso=EUR&bl.i27.line=0%2C0%2C1%2C2%2C2&bl.i21.coins=0&playercurrency=%26%23x20AC%3B&bl.i2.line=2%2C2%2C2%2C2%2C2&g4mode=false&bl.i18.reelset=ALL&bl.i21.reelset=ALL&bl.i20.coins=0&bl.i7.id=7&bl.i9.id=9&bl.i0.reelset=ALL&rs.i1.r.i1.hold=false&bl.i16.line=2%2C1%2C1%2C1%2C2&rs.i0.id=freespin&rs.i2.r.i3.hold=false&iframeEnabled=false&playforfun=false&";

$output .= "staticsharedurl=https%3A%2F%2F" . $staticSharedURL . "%2Fgameclient_html%2Fdevicedetection%2Fcurrent&bl.i13.reelset=ALL&bl.i29.id=29&bl.i21.id=21&";


$output .= "
&rs.i0.r.i0.syms=SYM7%2CSYM5%2CSYM5&
&rs.i0.r.i1.syms=SYM6%2CSYM7%2CSYM6&
&rs.i0.r.i2.syms=SYM8%2CSYM6%2CSYM1&
&rs.i0.r.i3.syms=SYM7%2CSYM6%2CSYM8&
&rs.i0.r.i4.syms=SYM3%2CSYM3%2CSYM3&

&rs.i1.r.i0.syms=SYM13%2CSYM16%2CSYM16&
&rs.i1.r.i1.syms=SYM16%2CSYM16%2CSYM16&
&rs.i1.r.i2.syms=SYM16%2CSYM16%2CSYM16&
&rs.i1.r.i3.syms=SYM16%2CSYM16%2CSYM16&
&rs.i1.r.i4.syms=SYM16%2CSYM16%2CSYM16&

&rs.i2.r.i0.syms=SYM11%2CSYM5%2CSYM5&
&rs.i2.r.i1.syms=SYM9%2CSYM8%2CSYM6&
&rs.i2.r.i2.syms=SYM8%2CSYM6%2CSYM15&
&rs.i2.r.i3.syms=SYM8%2CSYM1%2CSYM10&
&rs.i2.r.i4.syms=SYM4%2CSYM4%2CSYM4&";


//$output.="&freeRoundWidgetGameId=333&";

//$output.= "credit=";
